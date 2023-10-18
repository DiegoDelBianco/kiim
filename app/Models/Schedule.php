<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'report',
        'date',
        'time',
        'status',
        'customer_service_id',
        'user_id',
        'tenancy_id',
    ];

    // Retonar o titulo do status do agendamento instanciado
    public function getStatus($completo = false){
        $status = $this->status;

        if($status == 3) return "cancelado";
        if($status == 2) return "feito";

        if($completo == false) return "aguardando";

        if(str_replace('-', '', $this->date) > date('Ymd'))  return "aguardando";
        if(str_replace('-', '', $this->date) == date('Ymd'))  return "hoje";
        if(str_replace('-', '', $this->date) < date('Ymd'))  return "atrasado";
        return false;
    }


    /*
     * Listagem de agendamentos para o usuário logado, pelo status
     *
     * $status recebe o status a ser pesquisado
     *   1 aguardando
     *   2 feitos
     *   3 cancelados
     *   4 hoje
     *   5 atrasados
     * $team_id caso seja passado, retorna apenas os vinculados á equipe especificada
     * $user_id caso seja passado, retorna apenas os vinculados ao usuário especificado
     */
    public static function listByStatus($status/*, $team_id = false, $user_id = false*/){

        $where = [];

        // Aguardando
        if($status == 1){
            $where[] = ['schedules.date','>=', date('Y-m-d')];
            $where[] = ['schedules.status','=', '1'];
        }

        // Feito
        if($status == 2){
            $where[] = ['schedules.status','=', '2'];
        }

        // Cancelado
        if($status == 3){
            $where[] = ['schedules.status','=', '3'];
        }

        // Hoje
        if($status == 4){
            $where[] = ['schedules.date','=', date('Y-m-d')];
            $where[] = ['schedules.status','=', '1'];
        }

        // Atrasado
        if($status == 5){
            $where[] = ['schedules.date','<', date('Y-m-d')];
            $where[] = ['schedules.status','=', '1'];
        }

        //if($team_id != false) $where[] = ['users.team_id', '=', $team_id];
        //if($user_id != false) $where[] = ['CustomerService.user_id', '=', $user_id];

        $where[] = ['schedules.user_id', '=', Auth::user()->id];

        $schedules = self::listWithWhere($where);

        return $schedules;
    }

    /*
     * Retorna contagem dos agendamentos em atraso
     *
     * $limit define qual o limite do contador, ex $limite = 10, caso tenha 15 notificações irá retornar '10+'
     */
    public static function countSchedules($limit = false){

        $count = count(self::listByStatus(5));
        if($limit) $count = $count > $limit ? $limit."+":$count;

        return $count;
    }

    // Gera uma listagem considerando o usuário atual, mais o where passado
    public static function listWithWhere(array $where){

        $where[] = ['users.id','=',Auth::user()->id];

        return self::where($where)
        //->rightJoin('customer_services', 'schedules.customer_service_id', '=', 'customer_services.id')
        //->rightJoin('customers', 'customer_services.user_id', '=', 'customers.id')
                ->rightJoin('users', 'users.id', '=', 'schedules.user_id')
                ->select(   'schedules.id as id',
                            'users.id as user_id',
                            'users.team_id as team_id',
                            'users.name as user_name',
                            'schedules.date as date',
                            'schedules.time as time',
                            'schedules.status as status',
                            'schedules.description as description',
                            //'customer_services.customer_id as customer_id',
                            //'customers.name as customer_name'
                            )
                ->orderBy('schedules.date', 'asc')
                ->orderBy('schedules.time', 'asc')
                ->get();
    }

    /*
     * Gera um calendário de agendamentos organizado por mês
     *
     *
     *
     */
    public static function calendarMonth($periodo = 1, $month = false, $year = false, $difference = 0/*, $team_id = false, $assistent = false*/){

        if($month == false) $month = date('m');
        if($year == false) $year = date('Y');

        $diasDaSemana = [
            '0' => 'Domingo',
            '1' => 'Segunda',
            '2' => 'Terça',
            '3' => 'Quarta',
            '4' => 'Quinta',
            '5' => 'Sexta',
            '6' => 'Sabado'];

        $firstDayWeek = date('w', strtotime(date("Y-".$month."-01")));
        $lastDayMonth = date('t', strtotime(date("Y-".$month."-d")));
        $nowWeekDay = 0;
        $nowMonthDay = 0;
        $nowWeek = 1;
        $end = 0;
        $nextMonth = false;

        if($periodo == 2){
            $ref = strtotime("+$difference Weeks");
            $ref = strtotime("Last Sunday", $ref);
            $firstDayWeek = 0;
            $lastDayMonth = date('d', strtotime('next saturday', $ref));
            $nowMonthDay = date('d', $ref);
            $month = date('m', $ref);
            $year = date('Y', $ref);
            $nextMonth = true;
            //if($nowMonthDay < $f)
        }

        $response = [];

        while($nowWeekDay != 0 OR !$end){

            //Inicia a contagem de dias do mês
            if($nowMonthDay == 0 AND ($nowWeekDay == $firstDayWeek) AND !$end) $nowMonthDay = 1;

            $where = [];
            $date = $year."-".str_pad($month , 2 , '0' , STR_PAD_LEFT)."-".str_pad($nowMonthDay , 2 , '0' , STR_PAD_LEFT);
            $where[] = ['date','=', $date];
            // if($team_id != false) $where[] = ['team_id','=', $team_id];

            $schedules = self::listWithWhere($where);

            //Monta Resposta
            $response['week-'.$nowWeek][$nowWeekDay] = [
                'day'           => $nowMonthDay,
                'weekDay'       => $nowWeekDay,
                'weekDayName'   => $diasDaSemana[$nowWeekDay],
                'schedules'     => $schedules ,
                'today'         => ("$year-$month-$nowMonthDay" == date('Y-m-d')),
                'date'          => $date,
            ];

            //var_dump($schedules);

            //Soma um dia na semana
            $nowWeekDay++;

            //Se for o ultimo dia do Mês finaliza a contagem
            if($nowMonthDay == $lastDayMonth){
                $end = TRUE;
                $nowMonthDay = 0;
            }

            //Soma um dia no mês
            if($nowMonthDay != 0 AND !$end){
                $nowMonthDay++;
            }

            // Se for domingo inicia nova semana
            if($nowWeekDay > 6) {
                $nowWeekDay = 0;
                $nowWeek++;
            }

            //caso o nextMont esteja ativo, prepara o script para inicar um novo mês
            if($nextMonth && $nowMonthDay > date('t', strtotime($year."-".$month."-01"))){
                $ref =strtotime($year."-".$month."-01");
                $month = date('m', strtotime("+1 month",$ref));
                $year = date('Y', strtotime("+1 month",$ref));
                $nowMonthDay = 1;
            }
        }

        return ['calendar' => $response, 'month' =>  $month, 'year' => $year];
    }

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/

    /*belongsTo*/
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function customerService()
    {
        return $this->belongsTo('App\Models\CustomerService');
    }
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }

    /*hasMany*/

}
