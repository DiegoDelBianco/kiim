<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'phone_2',
        'whatsapp',
        'birth',
        'customer_stage',
        'public_description',
        'private_description',
        'no_mail_send',
        'n_customer_service',
        'website_id',
        'user_id',
        'team_id',
        'tenancy_id',
        'product_id',
        'customer_service_id',
    ];

    protected $stage_title = [  
            1 => "Novo",                                // Antigo 1
            2 => "Em atendimento",                      // Antigo 6
            3 => "Negociando",                          // Antigo 2
            4 => "Remarketing",                         // Antigo 9
            5 => "Remanejado",                          // Antigo 10
            6 => "Cobrança",                            // Antigo 8
            7 => "Vendido (Aguardando confirmação)",    // Antigo 3
            8 => "Vendido",                             // Antigo 4
            9 => "Vendido",                             // Antigo 5
            10 => "Lixeira",                            // Antigo 7
        ];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function($model){

        });

        static::created(function ($model) {

            // Manda notificação para a equipe
            if($model->team_id != "")
                NotifyUser::create([
                    "team_id" => $model->team_id,
                    "notify_text" => "+1 lead cadastrado na sua equipe <br> ".date('H:i'),
                    "shoot" => date('Y-m-d H:i:s'),
                    "notify_style" => "high",
                    "tenancy_id" => Auth::user()->tenancy_id
                    ]);

            // Manda notificação para o usuário
            if($model->user_id != "")
                NotifyUser::create([
                    "user_id" => $model->user_id,
                    "notify_text" => "+1 lead cadastrado para você<br> ".date('H:i'),
                    "shoot" => date('Y-m-d H:i:s'),
                    "notify_style" => "high",
                    "tenancy_id" => Auth::user()->tenancy_id
                    ]);
        });


        static::updated(function ($model) {

        });
    }

    /*
     * Retorna o titulo para apresentação de um estagio
     */
    public static function stageTitle($stage_id){
        $instance = new Customer;

        return 
            isset($instance->stage_title[$stage_id])
                ? $instance->stage_title[$stage_id] : "Não definido";
    }

    /*
     * Retorna o titulo para apresentação do estágio do customer instanciado
     */
    public function stage(){
        return 
            isset($this->stage_title[$this->stage_id])
                ? $this->stage_title[$this->stage_id] : "Não definido";
    }

    /*
     * Retorna listagem de customers de remarketing de um usuário
     * Estes leads não estão com estado de remarketing, pois leads me estado de remarketing definido não tem usuário, estão aguardando um
     *
     * $user recebe o ID do usuário
     * $page recebe a página atual da listagem
     * $limit Recebe o limite por página da listagem
     * $view recebe a view que usará no retorno da listagem, defina como false para retornar panas o objeto
     */
    public static function listRemarketingByUser($user, $page = 0, $limit = 100, $view = 'customers.components.listRemarketing'){
        $customers = self::select('SELECT 
                                    customers.*
                                    FROM customers 
                                        WHERE 
                                            stage_id <> 10 AND
                                            stage_id <> 4 AND
                                            user_id = :user_id AND 
                                            (n_customer_service > 1 OR (n_customer_service = 1 AND opened = 2))
                                        LIMIT :limit
                                        OFFSET :offset', 
                                        ['user_id' => $user, 'limit' => $limit, 'offset' => ($page*$limit)]);
        if($view)
            return view($view, ["customers" => $customers, "list_users" => false]);

        return $customers;
    }


    /*
     * Retorna contagem total de customers de remarketing aguardando ser atendido de um usuário
     * Estes leads não estão com estado de remarketing, pois leads me estado de remarketing definido não tem usuário, estão aguardando um
     *
     * $user recebe instancia do usuário
     */
    public static function countRemarketingByUser($user = false){

        if($user === false) $user = Auth::user();
        
        $remarketingList = DB::select('SELECT 
            count(id) AS count
            FROM customers WHERE 
                stage_id <> 7 AND
                stage_id <> 9 AND
                user_id = :user_id AND 
                (n_customer_service > 1 OR (n_customer_service = 1 AND opened = 2))', 
                ['user_id' => $user->id]);

            return $remarketingList[0]->count;
    }

    // Direciona o custmer para um novo usuario
    public function redirectCustomer(User $user){

        // Verifica se o customer pode ser remanejado
        if(!$this->canRedirect()) return false;

        // Caso o atendimento ainda esteja aberto, finaliza ele para poder remanejar o customer
        $customerService = $this->customerService;
        if($customerService? $customerService->status == 1 : false)
            $customerService->end(3, 'Finalizado para remanejar');

        // Define se é remarketing
        $remarketing = ($this->n_customer_service >= 1);

        // Fazer o remanejamento
        $this->user_id = $user->user_id;
        $this->opened = 2;
        $this->stage_id = 5;
        $this->save();

        // Adicionar no registro de timeline do cliente
        $timeline_event = "O usuário #".Auth::user()->id." ".Auth::user()->name." designou para ".($remarketing?"remarketing com ":"")."o usuário ".$assistent->name.".";
        $timeline = new CustomerTimeline;
        $timeline->newTimeline($this, $timeline_event, 5);

        return true;
    }

    // Verifica se o cliente pode ser redirecionado
    public function canRedirect(){

        //Impede redirecionamento para clientes novos
        if($this->n_customer_service == 0 ) return false;

        // Verifica se o cliente já está vendido
        if($this->stage_id >= 6) return false;

        if(Auth::user()->hasRole("Master") OR
                        (Auth::user()->hasRole("Gerente") && 
                            Auth::user()->team_id == $this->team_id)) 
            return true;

        return false;
    }


    /*
     * Gera lista de customers com filtros
     *
     * $args vem direto do $request
     * $paginate define se vai páginar a lsitagem
     *
     */
    public static function getListByFilters($args, $paginate = true){

        // Se o Usuário for Master
        if(Auth::user()->hasRole('Master')) {
            $customers = ViewBaseCustomer::where([['id','>','0']]);

        // Se o Usuário for Gerente
        } elseif(Auth::user()->hasRole('Gerente')) {
            $customers = ViewBaseCustomer::where('team_id', Auth::user()->team_id);

        // Se o Usuário for Assistente
        } else{
            $customers = ViewBaseCustomer::where('user_id', Auth::user()->id)
                ->whereIn('stage_id', [1, 2, 3, 7, 5]);
        }

        // Remove clientes excluidos da listagem
        if($args->filtro_stage != 10) 
            $customers->where('stage_id', '<>', '10');

        if ($args->filtro_nome)
            $customers->where('name', 'like', '%'.$args->filtro_nome.'%');

        if ($args->filtro_produto) 
            $customers->where('product', 'like', '%'.$args->filtro_produto.'%');

        if ($args->filtro_phone) 
            $customers->where('concat_phone', 'like', '%'.$args->filtro_phone.'%');

        if ($args->filtro_id) 
            $customers->where('id', $args->filtro_id);

        if ($args->filtro_assistent) 
            $customers->where('user_id', $args->filtro_assistent);

        if ($args->filtro_website) 
            $customers->where('website_id', $args->filtro_website);

        if ($args->filtro_stage) 
            $customers->where('stage_id', $args->filtro_stage);

        if ($args->filtro_equipe) 
            $customers->where('team_id', $args->filtro_equipe);

        if ($args->filtro_data) {
            $search = $args->filtro_data;
            $search = str_replace("/","-",$search); // 02/20/2021 00:00:00-02/26/2021 00:00:00
            $data = explode(' ~ ',$search);    // data[0] {02/20/2021 00:00:00} data[1] {02/26/2021 00:00:00}
            $search1 = date("Y-m-d H:i:s", strtotime($data[0]));
            $search2 = date("Y-m-d H:i:s", strtotime($data[1]));
            $customers->whereBetween('created_at', [$search1, $search2]);
        }

        if ($args->filtro_alt) {
            $search = $args->filtro_alt;
            $search = str_replace("/","-",$search); // 02/20/2021 00:00:00-02/26/2021 00:00:00
            $data = explode(' ~ ',$search);    // data[0] {02/20/2021 00:00:00} data[1] {02/26/2021 00:00:00}
            $search1 = date("Y-m-d H:i:s", strtotime($data[0]));
            $search2 = date("Y-m-d H:i:s", strtotime($data[1]));
            $customers->whereBetween('updated_at', [$search1, $search2]);
        }

        $orderbyfield = "";
        $orderbyorder = "";

        if($args->orderbyfield AND $args->orderbyorder){
            $customers->orderBy($args->orderbyfield, $args->orderbyorder);
            $orderbyfield = $args->orderbyfield;
            $orderbyorder = $args->orderbyorder;
        }

        $quantidade = 25;
        if($args->limit) $quantidade = $args->limit;

        if($paginate) $customers = $customers->paginate($quantidade);
        else $customers = $customers->get();

        return $customers;
    }




    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/

    /*belongsTo*/
    public function website()
    {
        return $this->belongsTo('App\Models\Website');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    public function customerService()
    {
        return $this->belongsTo('App\Models\CustomerService');
    }

    /*hasMany*/
    public function customerServices()
    {
        return $this->hasMany('App\Models\CustomerService');
    }
    public function customerTimelines()
    {
        return $this->hasMany('App\Models\CustomerTimeline')->orderBy('created_at', 'desc');
    }
}
