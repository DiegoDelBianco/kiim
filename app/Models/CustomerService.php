<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerService extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'user_id',
        'status',
        'remarketing',
        'reason_finish',
        'tenancy_id',
    ];

    protected $status_name = [
            '1' => "Em Negociação",
            '2' => "Vendido",
            '6' => "Não atende",
            '7' => "Não contactado",
            '4' => "Dados de contato Inválido",
            '5' => "Cliente solicitou remoção",
            '3' => "Outros",
        ];

    public $nextCustomer = false;
    public $next_remarketing = false;

    // Retorna a array de nomes de status
    public static function listStatusFinish($tenancy_id)
    {
        //$intance = new CustomerService;
        //return $intance->status_name;
        //$reasons = ReasonFinish::where('avaliable_to_basic', 1)->get();

        $return = [];

        $rule = RoleUser::where('user_id', Auth::user()->id)->where('tenancy_id', $tenancy_id)->first();

        if(!$rule)
            return [];

        $reasons = ReasonFinish::where('avaliable_to_'.$rule->name, 1)->where('tenancy_id', $tenancy_id)->orderBy('order', 'asc')->get();

        return $reasons;

    }

    // Retona o nome de um status
    public static function getTitleReasonFinish($id)
    {
        $intance = new CustomerService;
        if(!isset($intance->status_name[$id])) return "Não definido";
        return $intance->status_name[$id];
    }

    // Retona o nome de um status do atendimento instanciado
    public function titleReasonFinish()
    {
        $id = $this->reason_finish;
        if(!isset($this->status_name[$id])) return "Não definido";
        return $this->status_name[$id];
    }

    /*
     * Retorna o cliente de que está sendo atendido no momento pelo usuário passado
     *
     * $user_id recebe o id o usuário, caso false, pega do usuário logado
     * $remarketing define se vai puxar de remarketing ou não remarketing, mentenha com 2 caso queria puxar o primeiro independete de remarkeitng
     */
    public static function currentCustomer($remarketing = 2, $user_id = FALSE)
    {
        // Caso não seja especificando o Id o User pega o do usuário logado
        if($user_id === FALSE) $user_id = Auth::user()->id;
        $where = [];
        $where[] = ["user_id", "=", $user_id];
        $where[] = ["status", "=", "1"];
        if($remarketing !== 2)
            $where[] = ["remarketing", $remarketing ? "=" : "<>", "1"];

        // Obtem e retorna
        $customer_service = self::where($where)->first();
        return $customer_service ? $customer_service->customer : false;
    }

    // O proximo cliente para atendimento
    public function nextCustomer($remarketing = false)
    {

        $nextCustomer = Customer::baseQueryUserQueue(); //Customer::where('tenancy_id', Auth::user()->tenancy_id);

        if($remarketing){
            $nextCustomer->where('new', '=', false);
        }else{
            $nextCustomer->where('new', '=', true);
        }

        $nextCustomer = $nextCustomer->orderBy('created_at', 'asc')->first();

        $this->nextCustomer         = $nextCustomer; //$remarketing?false:$nextCustomer;
        $this->next_remarketing     = $remarketing; //?$nextCustomer:false;

        return $nextCustomer;
    }

    /*
     * Inicia o atendimento, está função deve ser chama após a "nextLead"
     *
     * $negociation define se vai inicar em modo de negociação
     */
    public function start($negociation = false)
    {

        $stage = Stage::where('tenancy_id', $this->nextCustomer->tenancy_id)->where('is_customer_service_default', 1)->first();

        //atualiza Timeline
        $timeline = new CustomerTimeline;
        $timeline->newTimeline($this->nextCustomer, "O usuário #".Auth::user()->id." ".Auth::user()->name." iniciou o atendimento ".($negociation?"(Em modo de negociação)":""), 5);

        //Salva o novo atendimento
        $this->tenancy_id = $this->nextCustomer->tenancy_id;
        $this->remarketing = $this->next_remarketing;
        $this->customer_id = $this->nextCustomer->id;
        $this->user_id = Auth::user()->id;
        $this->stage_id = $stage->id;
        //if($negociation) $this->status = 2;
        //if($negociation) $this->reason_finish = 1;
        $this->save();

        //Atualiza usuário
        $this->nextCustomer->user_id = Auth::user()->id;
        $this->nextCustomer->updateStage($stage->id);
        $this->nextCustomer->opened = 1;
        $this->nextCustomer->customer_service_id = $this->id;
        $this->nextCustomer->n_customer_service = count($this->nextCustomer->customerServices);
        $this->nextCustomer->save();

        return true;
    }

    // Finaliza o atendimento da instancia atual
    public function end(ReasonFinish $reason_finish, $description, $request = false)
    {

        // Altera customer service
        $this->status = 2;
        $this->reason_finish_id = $reason_finish->id;

        if($reason_finish->customer_service_stage_id)
            $this->stage_id = $reason_finish->customer_service_stage_id;

        //confim_buy_date
        if($reason_finish->confim_buy_date ? $request ? $request->buy_date : false : false)
            $this->buy_date = $request->buy_date;

        //confim_signature_date
        if($reason_finish->confim_signature_date ? $request ? $request->signature_date : false : false)
            $this->signature_date = $request->signature_date;

        //confim_delivery_keys_date
        if($reason_finish->confim_delivery_keys_date ? $request ? $request->delivery_keys_date : false : false)
            $this->delivery_keys_date = $request->delivery_keys_date;

        //confim_next_contact_date
        if($reason_finish->confim_next_contact_date ? $request ? $request->next_contact_date : false : false)
            $this->next_contact_date = $request->next_contact_date;

        //confim_paid_date
        $this->save();

        // Salva timeline
        $event = "O usuário #".Auth::user()->id." ".Auth::user()->name." finalizou o atendimento \n Motivo: ".$reason_finish->name."\n Observação: \n ".$description;
        $timeline = new CustomerTimeline;
        $timeline->newTimeline($this->customer, $event, "5");

        /*
        ** Define stage do cliente
        */
        if($reason_finish->customer_stage_id){
            $stage = Stage::find($reason_finish->customer_stage_id);
            $this->customer->updateStage($reason_finish->customer_stage_id);
        }

        //confim_buy_date
        if($reason_finish->confim_buy_date ? $request ? $request->buy_date : false : false)
            $this->customer->buy_date = $request->buy_date;

        $this->customer->save();

        return true;
    }

    /*
     * Retona a contade de leads na fila de remarketing para notificações
     *
     * $user define o usuário, caso 0 usa o usuário logado
     * $limit define qual o limite do contador, ex $limite = 10, caso tenha 15 notificações irá retornar '10+'
     *
     */
    public static function countRemarketing($user = 0, $limit = false)
    {
        if($user == 0 ) $user = Auth::user()->id;
        $user = User::find($user);
        $countRemarketing = 0;
        $countRemarketing = Customer::countRemarketingByUser($user);

        if($limit) $countRemarketing = $countRemarketing > $limit ? $limit."+":$countRemarketing;

        return $countRemarketing;
    }

    /*
     * Retorna quantidade de agendamentos vinculado ao atendimento instanciado
     * Retorna coforme status:
     *   0 todos
     *   1 aguardando
     *   2 feitos
     *   3 cancelados
     *   4 hoje
     *   5 atrasados
     */
    public function countScheduling($status = 0)
    {

        if($status == 0)
            return count($this->schedules);

        if($status == 1)
            return Schedule::where('status', 1)
                ->where('customer_service_id', $this->id)
                ->where('date','>',date('Y-m-d'))->count();

        if($status == 2)
            return Schedule::where('status', 2)
                ->where('customer_service_id', $this->id)->count();

        if($status == 3)
            return Schedule::where('status', 3)
                ->where('customer_service_id', $this->id)->count();

        if($status == 4)
            return Schedule::where('status', 1)
                ->where('customer_service_id', $this->id)
                ->where('date','=',date('Y-m-d'))->count();

        if($status == 5)
            return Schedule::where('status', 1)
                ->where('customer_service_id', $this->id)
                ->where('date','<',date('Y-m-d'))->count();

        return false;
    }


    // lista a quantidade de atendimentos feitos hoje por tenancy para o usuario logado
    public static function myCsByTenancy(){

        $count_by_tenancies = DB::table('customer_services')
            ->select(DB::raw('count(*) as count, tenancy_id'))
            ->where('created_at', '>', date('Y-m-d 00:00:00'))
            ->where('user_id', Auth::user()->id)
            ->groupBy('tenancy_id')
            ->get();

        return $count_by_tenancies;
    }


    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/

    /*belongsTo*/
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }

    /*hasMany*/
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }
    public function customerTimelines()
    {
        return $this->hasMany('App\Models\CustomerTimeline');
    }
    public function customers()
    {
        return $this->hasMany('App\Models\Customers');
    }
}
