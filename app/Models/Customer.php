<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

/*
+-------------------------+---------------------+------+-----+---------+----------------+
| id                      | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| name                    | varchar(255)        | YES  |     | NULL    |                |
| last_name               | varchar(255)        | YES  |     | NULL    |                |
| email                   | varchar(255)        | YES  |     | NULL    |                |
| ddi                     | varchar(255)        | YES  |     | 55      |                |
| ddd                     | varchar(255)        | YES  |     | NULL    |                |
| phone                   | varchar(255)        | YES  |     | NULL    |                |
| ddi_2                   | varchar(255)        | YES  |     | 55      |                |
| ddd_2                   | varchar(255)        | YES  |     | NULL    |                |
| phone_2                 | varchar(255)        | YES  |     | NULL    |                |
| whatsapp                | varchar(255)        | YES  |     | NULL    |                |
| birth                   | date                | YES  |     | NULL    |                |
| stage_id                | int(11)             | NO   |     | 1       |                |
| public_description      | mediumtext          | YES  |     | NULL    |                |
| private_description     | mediumtext          | YES  |     | NULL    |                |
| no_mail_send            | tinyint(1)          | NO   |     | 0       |                |
| n_customer_service      | int(11)             | YES  |     | 0       |                |
| opened                  | int(11)             | NO   |     | 2       |                |
| website_id              | bigint(20) unsigned | YES  | MUL | NULL    |                |
| user_id                 | bigint(20) unsigned | YES  | MUL | NULL    |                |
| team_id                 | bigint(20) unsigned | YES  | MUL | NULL    |                |
| tenancy_id              | bigint(20) unsigned | NO   | MUL | NULL    |                |
| buy_date                | date                | YES  |     | NULL    |                |
| pay_date                | date                | YES  |     | NULL    |                |
| buy_price               | decimal(10,2)       | YES  |     | NULL    |                |
| seller_commission       | decimal(10,2)       | YES  |     | NULL    |                |
| deleted_at              | timestamp           | YES  |     | NULL    |                |
| created_at              | timestamp           | YES  |     | NULL    |                |
| updated_at              | timestamp           | YES  |     | NULL    |                |
| product_id              | bigint(20) unsigned | YES  | MUL | NULL    |                |
| customer_timeline_id    | bigint(20) unsigned | YES  | MUL | NULL    |                |
| customer_service_id     | bigint(20) unsigned | YES  | MUL | NULL    |                |
| customer_csv_import_id  | bigint(20) unsigned | YES  | MUL | NULL    |                |
| value                   | decimal(10,2)       | YES  |     | NULL    |                |
| rent                    | tinyint(1)          | NO   |     | 0       |                |
| rent_adjustment         | varchar(255)        | YES  |     | NULL    |                |
| rent_adjustment_last    | date                | YES  |     | NULL    |                |
| rent_adjustment_next    | date                | YES  |     | NULL    |                |
| rent_guarantee          | varchar(255)        | YES  |     | NULL    |                |
| rent_guarantee_value    | varchar(255)        | YES  |     | NULL    |                |
| product_type            | varchar(255)        | YES  |     | NULL    |                |
| acquisition_date        | timestamp           | YES  |     | NULL    |                |
| first_contact_date      | timestamp           | YES  |     | NULL    |                |
| last_contact_date       | timestamp           | YES  |     | NULL    |                |
| next_contact_date       | timestamp           | YES  |     | NULL    |                |
| source                  | varchar(255)        | YES  |     | NULL    |                |
| source_other            | varchar(255)        | YES  |     | NULL    |                |
| source_campaign_id      | varchar(255)        | YES  |     | NULL    |                |
| source_campaign         | varchar(255)        | YES  |     | NULL    |                |
| source_ads_account      | varchar(255)        | YES  |     | NULL    |                |
| source_business_account | varchar(255)        | YES  |     | NULL    |                |
| source_ad               | varchar(255)        | YES  |     | NULL    |                |
| source_id               | varchar(255)        | YES  |     | NULL    |                |
| source_form             | varchar(255)        | YES  |     | NULL    |                |
| marital_status          | varchar(255)        | YES  |     | NULL    |                |
| cpf                     | varchar(255)        | YES  |     | NULL    |                |
| familiar_income         | varchar(255)        | YES  |     | NULL    |                |
| income                  | varchar(255)        | YES  |     | NULL    |                |
| job                     | varchar(255)        | YES  |     | NULL    |                |
| restriction             | tinyint(1)          | YES  |     | NULL    |                |
| entry                   | varchar(255)        | YES  |     | NULL    |                |
| installments            | int(11)             | YES  |     | NULL    |                |
| installment_value       | decimal(10,2)       | YES  |     | NULL    |                |
| region                  | varchar(255)        | YES  |     | NULL    |                |
| fgts                    | decimal(10,2)       | YES  |     | NULL    |                |
| best_time               | varchar(255)        | YES  |     | NULL    |                |
*/

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'ddi',
        'ddd',
        'phone',
        'ddi_2',
        'ddd_2',
        'phone_2',
        'whatsapp',
        'birth',
        'stage_id',
        'public_description',
        'private_description',
        'no_mail_send',
        'n_customer_service',
        'opened',
        'website_id',
        'user_id',
        'team_id',
        'tenancy_id',
        'buy_date',
        'pay_date',
        'buy_price',
        'seller_commission',
        'deleted_at',
        'created_at',
        'updated_at',
        'product_id',
        'customer_timeline_id',
        'customer_service_id',
        'customer_csv_import_id',
        'value',
        'rent',
        'rent_adjustment',
        'rent_adjustment_last',
        'rent_adjustment_next',
        'rent_guarantee',
        'rent_guarantee_value',
        'product_type',
        'acquisition_date',
        'first_contact_date',
        'last_contact_date',
        'next_contact_date',
        'source',
        'source_other',
        'source_campaign_id',
        'source_campaign',
        'source_ads_account',
        'source_business_account',
        'source_ad',
        'source_id',
        'source_form',
        'marital_status',
        'cpf',
        'familiar_income',
        'income',
        'job',
        'restriction',
        'entry',
        'installments',
        'installment_value',
        'region',
        'fgts',
        'best_time',
        'real_state_project',
        'product_type_id'
    ];

    protected $list_sources = [
        'Network' => 'Network',
        'Indicação' => 'Indicação',
        'Facebook (Tráfego Pago)' => 'Facebook (Tráfego Pago)',
        'Instagram (Tráfego Pago)' => 'Instagram (Tráfego Pago)',
        'Google (Tráfego Pago)' => 'Google (Tráfego Pago)',
        'Tiktok (Tráfego Pago)' => 'Tiktok (Tráfego Pago)',
        'Facebook (Tráfego Orgânico)' => 'Facebook (Tráfego Orgânico)',
        'Instagram (Tráfego Orgânico)' => 'Instagram (Tráfego Orgânico)',
        'Google (Tráfego Orgânico)' => 'Google (Tráfego Orgânico)',
        'Tiktok (Tráfego Orgânico)' => 'Tiktok (Tráfego Orgânico)',
        'Disparo de E-mail' => 'Disparo de E-mail',
        'Disparo Whatsapp' => 'Disparo Whatsapp',
        'Outros' => 'Outros',
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
            // se tiver atualização do stage_id
            if ($model->isDirty('stage_id')) {
                $stage = Stage::find($model->stage_id);

                // Atualiza o modelo sem acionar o evento updated novamente
                $model->withoutEvents(function () use ($model, $stage) {
                    $model->update(['new' => $stage->is_new]);
                });
            }
        });
    }

    public static function listSources(){
        $instance = new Customer();
        return $instance->list_sources;
    }

    /*
     * Retorna o titulo para apresentação de um estagio
     */
    public static function stageTitle($stage_id){

        $stage = Stage::find($stage_id);


        return stage->name;
    }

    /*
     * Retorna o titulo para apresentação do estágio do customer instanciado
     */
    public function stage(){

            return $this->belongsTo(Stage::class);
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
                                    INNER JOIN stages ON stages.id = customers.stage_id
                                        WHERE
                                            stages.is_avaliable_to_cs =  true AND
                                            stages.is_deleted =  false AND
                                            user_id = :user_id AND
                                            new = false
                                            AND customers.tenancy_id = '.Auth::user()->tenancy_id.'
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
/*
        $remarketingList = DB::select('SELECT
            count(id) AS count
            FROM customers WHERE
                stage_id <> 7 AND
                stage_id <> 9 AND
                (user_id = :user_id OR (team_id = :team_id and (user_id IS NULL OR user_id = "")) OR ((user_id IS NULL OR user_id = "") AND (team_id IS NULL OR team_id = "")))
                AND  (n_customer_service > 1 OR (n_customer_service = 1 AND opened = 2))
                AND tenancy_id = '.Auth::user()->tenancy_id,
                ['user_id' => $user->id, 'team_id' => $user->team_id]);
*/

            $total_leads = 0;

            $list = Customer::baseQueryUserQueue(true);

            $list->where(function($query) use ($user){
                $query->where([['customers.new','=', false]]);
            });

            $result = $list->get();

            // Obtem o total de leads atendidos hoje por tenancy
            $count_by_tenancies = CustomerService::myCsByTenancy();


            foreach(Auth::user()->roles as $tenancy){

                $limit_by_day               = $tenancy->limit_cs_by_day;
                $count_cs                   = 0;
                $count_tenancy_leads        = 0;


                // Obtem a quantidade de leads a serem atendidos para a tenancy atual do loop
                foreach($result as $count_by_tenancy){

                    if($count_by_tenancy->tenancy_id == $tenancy->tenancy_id){
                        $count_tenancy_leads = $count_by_tenancy->count;
                    }
                }

                // Caso não tenha limitação soma o total de leads do tenancy e continua
                if(!$limit_by_day){
                    $total_leads += $count_tenancy_leads;
                    continue;
                }

                // obtem contagem de atedimentos para a tenancy atual do loop
                foreach($count_by_tenancies as $count_by_tenancy){
                    if($count_by_tenancy->tenancy_id == $tenancy->tenancy_id){
                        $count_cs = $count_by_tenancy->count;
                    }
                }

                $current_limit = $limit_by_day - $count_cs;

                // Caso o limite de atendimentos do dia seja maior que o total de leads, soma o total de leads
                if($current_limit < $count_tenancy_leads)
                    $total_leads += $current_limit;
                else
                    $total_leads += $count_tenancy_leads;
            }

            if($total_leads < 0) $total_leads = 0;

            return $total_leads;
            //return $list->count('*');
    }

    public static function countQueueByUser($user = false){

        if($user === false) $user = Auth::user();
/*
        $remarketingList = DB::select('SELECT
            count(id) AS count
            FROM customers WHERE
                (user_id = :user_id OR (team_id = :team_id and (user_id IS NULL OR user_id = "")) OR ((user_id IS NULL OR user_id = "") AND (team_id IS NULL OR team_id = "")))
                AND  n_customer_service = 0 and opened = 2
                AND tenancy_id = '.Auth::user()->tenancy_id,
                ['user_id' => $user->id, 'team_id' => $user->team_id]);
*/
        $total_leads = 0;

        $list = Customer::baseQueryUserQueue(true);

        $list->where('n_customer_service', 0)
            ->where('opened', 2);

        $result = $list->get();

        // Obtem o total de leads atendidos hoje por tenancy
        $count_by_tenancies = CustomerService::myCsByTenancy();


        foreach(Auth::user()->roles as $tenancy){

            $limit_by_day               = $tenancy->limit_cs_by_day;
            $count_cs                   = 0;
            $count_tenancy_leads        = 0;


            // Obtem a quantidade de leads a serem atendidos para a tenancy atual do loop
            foreach($result as $count_by_tenancy){

                if($count_by_tenancy->tenancy_id == $tenancy->tenancy_id){
                    $count_tenancy_leads = $count_by_tenancy->count;
                }
            }

            // Caso não tenha limitação soma o total de leads do tenancy e continua
            if(!$limit_by_day){
                $total_leads += $count_tenancy_leads;
                continue;
            }

            // obtem contagem de atedimentos para a tenancy atual do loop
            foreach($count_by_tenancies as $count_by_tenancy){
                if($count_by_tenancy->tenancy_id == $tenancy->tenancy_id){
                    $count_cs = $count_by_tenancy->count;
                }
            }

            $current_limit = $limit_by_day - $count_cs;

            // Caso o limite de atendimentos do dia seja maior que o total de leads, soma o total de leads
            if($current_limit < $count_tenancy_leads)
                $total_leads += $current_limit;
            else
                $total_leads += $count_tenancy_leads;
        }

        if($total_leads < 0) $total_leads = 0;


        return $total_leads;
    }

    // Direciona o custmer para um novo usuario
    public function redirect($user = false, $team = false){

        // Verifica se o customer pode ser remanejado
        if(!$this->canRedirect()) return false;

        $stage = Stage::where('is_rearranged_default', true)->where('tenancy_id', $this->tenancy_id)->first();
        if(!$stage) return false;


        // Verifica se foi passada alguma informação
        if($user == false and $team == false ){
            // Define se é remarketing
            $remarketing = (!$this->new);

            // Fazer o remanejamento
            $this->team_id = NULL;
            $this->user_id = NULL;
            $this->opened = 2;
            $this->updateStage($stage->id);
            $this->save();

            // Adicionar no registro de timeline do cliente
            $timeline_event = "O usuário #".Auth::user()->id." ".Auth::user()->name." designou para ".($remarketing?"remarketing com ":"")."o proximo usuário do sistema";
            $timeline = new CustomerTimeline;
            $timeline->newTimeline($this, $timeline_event, 5);

            return true;
        }

        // Redireciona para outra quipe caso tenha sido solicitado
        if($team) $this->redirectTeam($team);

        // Verfica se dever forçar um redirecionamento de equipe também
        if($team == false and $this->team_id != $user->team_id)
            $this->redirectTeam($user->team);

        // Caso o atendimento ainda esteja aberto, finaliza ele para poder remanejar o customer
        $customerService = $this->customerService;
        if($customerService? $customerService->status == 1 : false){

            $customerService->end($stage, 'Finalizado para remanejar');
        }


        // Daqui para baixo é apenas o redirecionamento para outro atendente
        if( $user == false ) return true;

        // Define se é remarketing
        $remarketing = (!$this->new);

        // Fazer o remanejamento
        $this->user_id = $user->id;
        $this->opened = 2;
        $this->updateStage($stage->id);
        $this->save();

        // Adicionar no registro de timeline do cliente
        $timeline_event = "O usuário #".Auth::user()->id." ".Auth::user()->name." designou para ".($remarketing?"remarketing com ":"")."o usuário #".$user->id." ".$user->name.".";
        $timeline = new CustomerTimeline;
        $timeline->newTimeline($this, $timeline_event, 5);

        return true;
    }

    public function updateStage($stage_id){
        $stage = Stage::find($stage_id);
        if(!$stage) {
            return false;
        }
        if($stage->tenancy_id != $this->tenancy_id){
            return false;
        }

        $this->update([
            'stage_id' => $stage->id,
            'new' => $stage->is_new
        ]);

        // se for deletado ou deixar disponivel para novo atendimento fecha o atendimento anterior
        $customerService = $this->customerService;
        if($stage->is_deleted || $stage->is_avaliable_to_cs){
            if($customerService ? $customerService->status == 1 : false){
                $customerService->update(['status' => 2]);
            }
        }

        if(!$stage->is_deleted && !$stage->is_avaliable_to_cs && !$customerService){
            $customerService = new CustomerService;
            $customerService->start(true, ($this->user_id ?? Auth::user()->id), $this->id, $stage_id);
        }
    }

    // Direciona o custmer para uma nova equipe
    public function redirectTeam($team){

        // Verifica se o customer pode ser remanejado
        if(!$this->canRedirect()) return false;

        $stage = Stage::where('is_rearranged_default', true)->where('tenancy_id', $customer->tenancy_id)->first();
        if(!$stage) return false;

        // Define se é remarketing
        $remarketing = (!$this->new);

        // Fazer o remanejamento
        $this->team_id = ($team?$team->id:NULL);
        $this->user_id =  NULL;
        $this->opened = 2;
        $this->updateStage($stage->id);
        $this->save();

        // Adicionar no registro de timeline do cliente
        $timeline_event = "O usuário #".Auth::user()->id." ".Auth::user()->name." designou para ".($remarketing?"remarketing com ":"")."a equipe #".($team?$team->id:NULL)." ".($team?$team->name:NULL).".";
        $timeline = new CustomerTimeline;
        $timeline->newTimeline($this, $timeline_event, 5);

        return true;
    }

    // Verifica se o cliente pode ser redirecionado
    public function canRedirect(){

        //Impede redirecionamento para clientes novos
        //if($this->n_customer_service == 0 ) return false;

        // Verifica se o cliente já está vendido
        if($this->stage->is_buy) return false;

        if(Auth::user()->hasRole("Master") OR
                        (Auth::user()->hasRole("Gerente") &&
                            Auth::user()->team_id == $this->team_id))
            return true;

        return false;
    }

    public static function baseQueryUserSearch($useView = true, $deleted = false){

        $tenancy_field = ($useView?'tenancy':'tenancy_id');

        $tenancies_manage_users = [];
        $tenancies_manage_users_only_team = [];
        $teams_for_tenancies = [];
        foreach(Auth::user()->roles as $tenancy){
            if(Auth::user()->can('manage-any-users', $tenancy->tenancy_id)){
                $tenancies_manage_users[] = $tenancy->tenancy_id;
            }
            if(Auth::user()->can('manage-only-team-users', $tenancy->tenancy_id)){
                $tenancies_manage_users_only_team[] = $tenancy->tenancy_id;
                $teams_for_tenancies[] = Auth::user()->teamId($tenancy->tenancy_id);
            }
        }

        if($useView){
            $customers = ViewBaseCustomer::where('id', '>', '0');
        }else{
            $customers = Customer::where('id', '>', '0');
        }

        $customers->where( function($query) use ($tenancies_manage_users, $tenancies_manage_users_only_team, $teams_for_tenancies, $tenancy_field) {

            $query->where('user_id', Auth::user()->id);

            if(count($tenancies_manage_users) > 0){
                $query->orWhereIn($tenancy_field, $tenancies_manage_users);
            }

            if(count($tenancies_manage_users_only_team) > 0 and count($teams_for_tenancies) > 0){
                $query->orWhere(function($query) use ($tenancies_manage_users_only_team, $teams_for_tenancies, $tenancy_field){
                    print_r($tenancies_manage_users_only_team);
                    $query->whereIn($tenancy_field, $tenancies_manage_users_only_team);
                    $query->whereIn('team_id', $teams_for_tenancies);
                });
            }
        });

        if(!$deleted){
            $customers->whereIn('stage_id', function ($query) {
                $query->select('id')
                    ->from('stages')
                    ->where('is_deleted', false)
                    ->whereColumn('tenancy_id', 'view_base_customers.tenancy');
            });
        }
        return $customers;
    }



    public static function baseQueryUserQueue($count = false){


        // Obtem lista de atendimentos de hoje do usuario por tenancy
        //select count(*), tenancy_id from  customer_services where created_at > ?today AND user_id = ?  group by tenancy_id;

        $tenancy_field = 'tenancy_id';

        $tenancies = [];
        $teams = [];

        if(!$count){
            $count_by_tenancies = CustomerService::myCsByTenancy();

            foreach(Auth::user()->roles as $tenancy){

                $limit_by_day   = $tenancy->limit_cs_by_day;
                $count_cs       = 0;

                // obtem contagem de atedimentos do dia pela variavel count_by_tenancies
                foreach($count_by_tenancies as $count_by_tenancy){
                    if($count_by_tenancy->tenancy_id == $tenancy->tenancy_id){
                        $count_cs = $count_by_tenancy->count;
                    }
                }

                // caso não tenha atingido o limite da empresa, usa ela na query
                if(($limit_by_day AND $count_cs < $limit_by_day) OR !$limit_by_day){
                    $tenancies[] = $tenancy->tenancy_id;
                    $teams[] = Auth::user()->teamId($tenancy->tenancy_id);
                }
            }
        }else{
            foreach(Auth::user()->roles as $tenancy){


                $tenancies[] = $tenancy->tenancy_id;
                $teams[] = Auth::user()->teamId($tenancy->tenancy_id);

            }
        }

        $customers = $count ? DB::table('customers')->where('opened', '2') : Customer::where('opened', '2');
        //$customers->where([['stage_id', '<' , '6']]);
        //$customers->join('stages', 'customers.stage_id', '=', 'stages.id')->where('stages.is_avaliable_to_cs', true);
        $customers->whereIn('stage_id', function ($query) {
            $query->select('id')
                ->from('stages')
                ->where('is_avaliable_to_cs', true)
                ->whereColumn('tenancy_id', 'customers.tenancy_id');
        });

        $customers->where(function($query) use ($tenancies, $teams, $tenancy_field){
            // Obtem o proximo na lista pelo usuário
            $query->where('user_id', Auth::user()->id);

            // Pega pela lista da equipe
            $query->orWhere(function($query) use ($tenancy_field, $tenancies, $teams){
                $query->whereIn($tenancy_field, $tenancies);
                $query->whereIn('team_id', $teams);
                $query->whereNull('user_id');
            });

            // Pega pela lista geral
            $query->orWhere(function($query) use ($tenancies, $tenancy_field){
                $query->whereIn($tenancy_field, $tenancies);
                $query->whereNull('team_id');
                $query->whereNull('user_id');
            });

        });

        if($count){
            $customers->select(DB::raw('count(*) as count, tenancy_id'));
            $customers->groupBy('tenancy_id');
        }

        return $customers;
    }


    /*
     * Gera lista de customers com filtros
     *
     * $args vem direto do $request
     * $paginate define se vai páginar a lsitagem
     *
     */
    public static function getListByFilters($args, $paginate = true){

        $customers = self::baseQueryUserSearch();


        // Remove clientes excluidos da listagem
        $delete = false;
        if($args->filtro_stage){
            $stage = Stage::find($args->filtro_stage);
            $delete = $stage->is_deleted;
        }

        if ($args->filtro_stage){
            $customers->whereIn('stage_id', explode(",", $args->filtro_stage));
        }else{
            $customers->where('is_deleted', '=', false);
        }

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

    public function productType()
    {
        return $this->belongsTo('App\Models\ProductType');
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
