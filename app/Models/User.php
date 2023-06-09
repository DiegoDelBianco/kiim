<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'picture',
        'creci',
        'active',
        'tenancy_id',
        'team_id',
        'sector_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    protected $roles_user = NULL;


    // Verifica se o usuário tem uma das permissões listadas em uma array
    public function hasAnyRoles(array $roles)
    {
        $role = $this->roles()->whereIn('name', $roles)->first();

        if($role)
            return true;

        return false;
    }

    // Verifica se o usuário tem uma permissão especifica
    public function hasRole($role)
    {

        if($this->roles_user === NULL){
            $this->roles_user = [];
            foreach($this->roles as $value)
                $this->roles_user[$value->name] = true;
        }

        return isset($this->roles_user[$role])?$this->roles_user[$role]:false;
    }

    /* Retorna as notificações do usúarios, está função sempre retonará as informações do usúario logado.
     * 
     * $limit define qual o limite do contador, ex $limite = 10, caso tenha 15 notificações irá retornar '10+'
     * $withText recebe um valor booleano para definir se a função deve retornar os textos das notificações junto
     *
     * -- ATENÇÃO, esta função deve ser movida para o MODEL de notificações
     */
    public static function countNotifications($limit = false, $withText = false){

        $user = Auth::user();

        // Obtem somatória de todos os módulos que retornam notificações
        $countRemarketing = CustomerService::countRemarketing();    // Notifica remarketing á serem atendidos
        $countSchedules = Scheduling::countSchedules();         // NOtifica agendamentos em atraso
        $countTotals = $countRemarketing + $countSchedules;     // Soma tudo

        // Se adequa ao limite caso tenha sido definido
        if($limit) $countTotals = $countTotals > $limit ? $limit."+":$countTotals; 
        
        // Caso não tenha sido solicitado o texto da notificação retorna apenas a contagem
        if(!$withText)
            return $countTotals;

        // Variavel de retorno
        $response = ['countTotals' => $countTotals, 'notifications' => []];

        // Gera mensagem para remaketing
        if($countRemarketing > 0){
            $response['notifications'][] = [
                'message' => '<p><i class="fa-solid fa-arrow-right-long"></i> '.($user->hasRole('Assistente')? "Parabéns!":"")." Você tem $countRemarketing Novos leads de remarketing ".($user->hasRole('Assistente')? "para vender!":"para remanejar.").' <a class="btn btn-success" href="'.($user->hasRole('Assistente')?route('clientes.remarketing'):route('remarketing')).'">veja aqui</a></p>',
            ];
        }

        //gera mensagem para agendamentos
        if($countSchedules > 0){
            $response['notifications'][] = [
                'message' => '<p><i class="fa-solid fa-arrow-right-long"></i> '.$countSchedules.' Tarefas em atraso. <a class="btn btn-success" href="'.route('scheduling.list').'">veja aqui</a></p>',
            ];
        }

        return $response;
    }

    // Retorna o nome da equipe caso exista
    public function teamName(){
        return $this->team ? $this->team->name : "Não definido";
    }


    /* Retorna notificações a partir de um timestamp até o momento atual 
     * Usado para notificações ajax
     *
     * $timestamp recebe data minima
     * $now recebe data limite
     *
     * Para as notificações da tabela de notificações, são lançadas as não visualizadas dos ultimos 3 minutos
     * Com isso os usuários que acabaram de entrar podem ver as notificações.
     *
     * ATENÇÃO: Esta função deve ir para a classe de notificações
     * ATENÇÃO: Esta função não deveria estar pegando nada diretamente dos agendamentos, o agendamento deveria estar rodando um cron para lançar uma notificação direto na tabela.
     *
     */
    public static function listNotificationsByTimestamp($timestamp, $now = false){

        if($now === false) $now =  time();

        $user = Auth::user();

        // Define variavel de retorno
        $list = [];

        // Define a lista de agendamentos para notificar
        $where[] = ['schedules.status','=', 1];
        $where[] = ['schedules.date','=', date('Y-m-d', $now)];
        $where[] = ['schedules.time','>', date('H:i:s', $timestamp)];
        $where[] = ['schedules.time','<=', date('H:i:s', $now)];
        $schedules = Scheduling::listWithWhere($where);

        // Adiciona cada agendamento no retorno
        foreach($schedules as $schedule)
            $list[] = ['message' => "<b>Você tem uma tarefa agendada para agora!</b><br> <b>Cliente:</b> ".$schedule->customer_name." <br> <b>Horario:</b> ".date('d/m/Y',strtotime($schedule->date)).($schedule->hour != ''? ' ás '.substr($schedule->hour, 0, 5):'').'<br><a href="'.route("customer.edit",$schedule->customer_id).'" class="btn btn-primary">Ver Atendimento</button>',];


        // Procura dos ultimos 3 min notificações na tabela
        $time_limit = date('Y-m-d H:i:s', strtotime('-180 seconds'));
        $time_limit_out = date('Y-m-d H:i:s');
        $notifications = NotifyUser::where([['user_id','=', $user->id], ['shoot', '>', $time_limit], ['shoot', '<', $time_limit_out]])->orWhere([['team_id','=', $user->team_id], ['shoot', '>', $time_limit], ['shoot', '<', $time_limit_out]])->get();

        foreach ($notifications as $notify) {

            // Se já existe um registro da notificação visualizada, continua
            if($notify->notifyUserView) continue;

            // Adiciona notificação ao retorno
            $list[] = [
                    'message' => $notify->notify_text,
                    'style' => $notify->notify_style,
                ];

            // Registra visualização na notificação no DB
            NotifyUsersView::create(['user_id' => $user->id, 'notify_user_id' => $notify->id]);
        }

        return $list;
    }


    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    /*belongsTo*/
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }
    public function sector()
    {
        return $this->belongsTo('App\Models\Sector');
    }

    /*hasMany*/
    public function teams()
    {
        return $this->hasMany('App\Models\RoleUser');
    }
    public function websites()
    {
        return $this->hasMany('App\Models\Website');
    }
    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }
    public function customerServices()
    {
        return $this->hasMany('App\Models\CustomerService');
    }
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }
    public function notifyUsers()
    {
        return $this->hasMany('App\Models\NotifyUsers');
    }
    public function notifyUsersViews()
    {
        return $this->hasMany('App\Models\NotifyUsersView');
    }
    public function customerTimelines()
    {
        return $this->hasMany('App\Models\CustomerTimeline');
    }
}
