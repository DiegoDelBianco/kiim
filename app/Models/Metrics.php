<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Metrics extends Model
{
    use HasFactory;

    public static function ontem($date){
        $explode = explode('-', $date);
        $month = $explode[1];
        $year = $explode[0];
        $day = $explode[2];

        $day = $day-1;
        if($day <= 0){
            $month = $month -1;
            if($month <= 0 ){
                $month = 12;
                $year = $year -1;
            }
            $day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }

        return $year."-".str_pad($month , 2 , '0' , STR_PAD_LEFT)."-".str_pad($day , 2 , '0' , STR_PAD_LEFT);

    }


    /*****************************************/

    /*
     * Todos os leads do sistema
     *
     */ 
    public static function allLeads($team_id = false, $assistent_id = false, $periodo = 1, $ano = 0, $mes = 0, $dataini = 0, $dataend = 0){
        $return = self::get_metrics("query_allLeads", $team_id, $assistent_id, $periodo, $ano, $mes, $dataini, $dataend);
        return $return;
    }

    // Função que gera a query de pesquisa para NewLeads
    private static function query_allLeads($assistent_id, $team_id, $minOperator){
        $where      = " ";
        return self::default_query($where, $assistent_id, $team_id, $minOperator);
    }


    /*****************************************/

    /*
     * Novos leads cadastrados sem remkarketing
     *
     * Todos os leads com n_atendimento < 2 e que não estejam com stage_id:
     *      - 9  Remarketing
     *      - 10 Remanejado
     * 3175 60
     */ 
    public static function newLeads($team_id = false, $assistent_id = false, $periodo = 1, $ano = 0, $mes = 0, $dataini = 0, $dataend = 0){
        $return = self::get_metrics("query_newLeads", $team_id, $assistent_id, $periodo, $ano, $mes, $dataini, $dataend);
        return $return;
    }

    // Função que gera a query de pesquisa para NewLeads
    private static function query_newLeads($assistent_id, $team_id, $minOperator){
        $where      = " AND n_customer_service < 2 AND stage_id <> 4 AND stage_id <> 5 ";
        return self::default_query($where, $assistent_id, $team_id, $minOperator);
    }


    /*****************************************/

    /*
     * Todas as vendas efetuadas
     *
     * Todos os leads com stage:
     *      - 3 Vendido (Aguardando confirmação)
     *      - 4 Vendido
     *      - 5 Vendido
     *      - 8 Cobrança
     *
     * CORREÇÃO 02/03/2023: Passou-se a pegar a data do contrato e não a data de criação do cliente
    */ 
    public static function newContracts($team_id = false, $assistent_id = false, $periodo = 1, $ano = 0, $mes = 0, $dataini = 0, $dataend = 0){
        $return = self::get_metrics("query_newContracts", $team_id, $assistent_id, $periodo, $ano, $mes, $dataini, $dataend);
        return $return;
    }

    // Função que gera a query de pesquisa para newContracts
    private static function query_newContracts($assistent_id, $team_id, $minOperator){
        
        $where      = " AND (customers.stage_id = 7 OR customers.stage_id = 6 OR customers.stage_id = 9 OR customers.stage_id = 8) ";
        return self::default_query_contracts($where, $assistent_id, $team_id, $minOperator);
    }


    /*****************************************/

    /*
     * Todas as vendas efetuadas por leads sem remarketing
     *
     * Todos com Leads com n_atendimentos < 2
     * E com stage sendo um desses:
     *      - 3 Vendido (Aguardando confirmação)
     *      - 4 Vendido
     *      - 5 Vendido
     *      - 8 Cobrança
     *
     * CORREÇÃO 02/03/2023: Passou-se a pegar a data do contrato e não a data de criação do cliente
    */ 
    public static function newContractsNoRemarketing($team_id = false, $assistent_id = false, $periodo = 1, $ano = 0, $mes = 0, $dataini = 0, $dataend = 0){
        $return = self::get_metrics("query_newContractsNoRemarketing", $team_id, $assistent_id, $periodo, $ano, $mes, $dataini, $dataend);
        return $return;
    }

    // Função que gera a query de pesquisa para newContractsNoRemarketing
    private static function query_newContractsNoRemarketing($assistent_id, $team_id, $minOperator){
        $where      = " AND customers.n_customer_service < 2 AND (customers.stage_id = 7 OR customers.stage_id = 6 OR customers.stage_id = 9 OR customers.stage_id = 8) ";
        return self::default_query_contracts($where, $assistent_id, $team_id, $minOperator);
    }


    /*****************************************/

    /*
     * A somatoria do valor de crédito de todos os clientes vendidos
     *
     * Com stage sendo um desses:
     *      - 3 Vendido (Aguardando confirmação)
     *      - 4 Vendido
     *      - 5 Vendido
     *      - 8 Cobrança
     *
    */ 
    public static function totals($team_id = false, $assistent_id = false, $periodo = 1, $ano = 0, $mes = 0, $dataini = 0, $dataend = 0){
        $return = self::get_metrics("query_totals", $team_id, $assistent_id, $periodo, $ano, $mes, $dataini, $dataend);
        return $return;
    }

    // Função que gera a query de pesquisa para totals
    private static function query_totals($assistent_id, $team_id, $minOperator){
        $where      = "";
        $args       = ['minOperator' => $minOperator];

        if($assistent_id) {
            $where .= "AND user_id = :user_id";
            $args['assistent_id'] = $assistent_id;
        }

        if($team_id){
            $where .= "AND team_id = :team_id";
            $args['team_id'] = $team_id;
        }

       /* $select = DB::select("SELECT sum(customers.credito) AS count FROM customers 
                INNER JOIN contracts ON contracts.customer_id = customers.customer_id
                WHERE contracts.created_at LIKE :minOperator ".$where, $args);
        
        $leads = $select[0]->count;*/
        $leads = 0;

        return $leads;
    }


    /*****************************************/

    /*
     * Leads de remarketing
     *
     * Todos os leads com n_atendimento > 1 ou que estejam com section_id:
     *      - 9  Remarketing
     *      - 10 Remanejado
     *
    */ 
    public static function remarketing($team_id = false, $assistent_id = false, $periodo = 1, $ano = 0, $mes = 0, $dataini = 0, $dataend = 0){
        $return = self::get_metrics("query_remarketing", $team_id, $assistent_id, $periodo, $ano, $mes, $dataini, $dataend);
        return $return;
    }

    // Função que gera a query de pesquisa para remarketing
    private static function query_remarketing($assistent_id, $team_id, $minOperator){
        $where      = " AND (n_customer_service > 1 OR stage_id = 4 OR stage_id = 5) ";
        return self::default_query($where, $assistent_id, $team_id, $minOperator);
    }


    /*****************************************/

    /*
     * Todas as vendas efetuadas por leads de remarketing
     *
     * Todos os leads com n_atendimento > 1
     * E com stage sendo um desses:
     *      - 3 Vendido (Aguardando confirmação)
     *      - 4 Vendido
     *      - 5 Vendido
     *      - 8 Cobrança
     *
     * CORREÇÃO 02/03/2023: Passou-se a pegar a data do contrato e não a data de criação do cliente
    */ 
    public static function vendasRemarketing($team_id = false, $assistent_id = false, $periodo = 1, $ano = 0, $mes = 0, $dataini = 0, $dataend = 0){
        $return = self::get_metrics("query_vendasRemarketing", $team_id, $assistent_id, $periodo, $ano, $mes, $dataini, $dataend);
        return $return;
    }

    // Função que gera a query de pesquisa para vendasRemarketing
    private static function query_vendasRemarketing($assistent_id, $team_id, $minOperator){        
        $where      = " AND (customers.n_customer_service > 1) AND (customers.stage_id = 7 OR customers.stage_id = 6 OR customers.stage_id = 9 OR customers.stage_id = 8) ";
        return self::default_query_contracts($where, $assistent_id, $team_id, $minOperator);
    }


    /*****************************************/

    private static function default_query($where, $assistent_id, $team_id, $minOperator){
        
        $args       = ['minOperator' => $minOperator];
        $where  = "";
        if($assistent_id) {
            $where .= " AND user_id = :assistent_id";
            $args['assistent_id'] = $assistent_id;
        }

        if($team_id){
            $where .= " AND team_id = :team_id";
            $args['team_id'] = $team_id;
        }

        $select = DB::select("SELECT count(*) AS count FROM customers 
                WHERE created_at LIKE :minOperator ".$where." AND customers.tenancy_id = ".Auth::user()->tenancy_id, $args);

        $leads = $select[0]->count;

        return $leads;
    }


    /*****************************************/

    private static function default_query_contracts($where, $assistent_id, $team_id, $minOperator){
        
        $args       = ['minOperator' => $minOperator];
        if($assistent_id) {
            $where .= " AND customers.user_id = :assistent_id";
            $args['assistent_id'] = $assistent_id;
        }

        if($team_id){
            $where .= " AND customers.team_id = :team_id";
            $args['team_id'] = $team_id;
        }

        $select = DB::select("SELECT count(*) AS count FROM customers 
                WHERE customers.buy_date LIKE :minOperator ".$where." AND customers.tenancy_id = ".Auth::user()->tenancy_id, $args);

        $leads = $select[0]->count;

        return $leads;
    }

    // Gera as métricas
    public static function get_metrics($function_query, $team_id = false, $assistent_id = false, $periodo = 1, $ano = 0, $mes = 0, $dataini = 0, $dataend = 0){
        
        $return = [];
        $month = ($mes==0?date('m'):$mes);
        $year = ($ano==0?date('o'):$ano);

        /*
         * Cálculo para periodos: (Mensais, agrupará o restulado por dia)
         *      2 - "Selecionar mês"
         *      4 - "Personalizado"
         */
        if($periodo == 2 || $periodo == 4){
            
            // Último dia do mês
            $limit_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            
            // Define datas iniciais e finais caso o periodo seja um mês selecinado
            // Caso o periodo seja personalizado ele ja vem com as dadas iniciais e finais configuradas por parametro
            if($periodo == 2){
                $dataini = $year."-".str_pad($month , 2 , '0' , STR_PAD_LEFT).'-'.'00';
                $dataend = $year."-".str_pad($month , 2 , '0' , STR_PAD_LEFT).'-'.$limit_days;
            }

            // Loop de pesquisa por dia
            for ($i=date('o-m-d', strtotime('+0 days', strtotime($dataend)));str_replace("-", "", $i) >=  str_replace("-", "", $dataini)  ; $i = self::ontem($i)) { 
                
                //Define os dados da data atual a ser pesquisada
                $explode = explode('-', $i);
                $month = $explode[1];
                $year = $explode[0];
                $day = $explode[2];

                // Nome do mês para ser usado na array de retorno
                $month_name = date('M', mktime(0, 0, 0, $month, 10));

                // Parametro da data para ser usado na query
                $minOperator = "%$year-".str_pad($month , 2 , '0' , STR_PAD_LEFT)."-".str_pad($day , 2 , '0' , STR_PAD_LEFT)."%";

                // Faz a consulta e armazena na array do dia
                $return[$day."/".$month_name."/".$year] = self::$function_query($assistent_id, $team_id, $minOperator);
            }

            // caso tenha mais de 150 dias agrupa por mês (Para consulta personalizada)
            if(count($return) > 150 ){
                $newreturn = [];
                foreach ($return as $key => $value) {
                    $newkey = substr($key, 3);
                    $newreturn[$newkey] = (isset($newreturn["newkey"])?$newreturn["newkey"]+$value:$value);
                }
                $return = $newreturn;
            }

        /*
         * Cálculo para periodos: (Anual, agrupará o restulado por mês)
         *      1 - "Últimos 12 meses"
         *      3 - "Selecionar Ano"
         */
        }else{
            // Caso o periodo seja um ano selecionado, define o Mês 12 como o incial para o loop
            if($periodo == 3) $month = 12;

            // Loop de pesquisa por 12 meses em ordem decrescente
            for ($i=12; $i > 0 ; $i--) { 

                // Nome do mês para ser usado na array de retorno
                $month_name = date('M', mktime(0, 0, 0, $month, 10));

                // Parametro da data para ser usado na query
                $minOperator = "%$year-".str_pad($month , 2 , '0' , STR_PAD_LEFT)."%";

                // Faz a consulta e armazena na array do mês
                $return[$month_name."/".substr($year, 2)] = self::$function_query($assistent_id, $team_id, $minOperator);
                $month--;

                // Caso o contador de mês tenha chegado a 0, volta para o 12
                if($month == 0){
                    $month = 12;
                    $year--;
                }
            }
        }

        return $return;
    }

}
