<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Team;
use App\Models\User;
use App\Models\Metrics;

class MetricsController extends Controller
{
    public function index()
    {
        // Se o Usuário for Master
        if(Auth::user()->hasRole('Master') OR Auth::user()->hasRole('Monitor')) {
            //die("teste2");
            $teams = Team::where('tenancy_id', Auth::user()->tenancy_id)->get();

            $tipoPeriodo = 1;
            $assistent = false;
            //$listAssistents = User::where("sector_id", 3)->get();
            $listAssistents = User::where('tenancy_id', Auth::user()->tenancy_id)->get();


            if(isset($_GET["assistent"])?$_GET["assistent"]>0:false) $assistent = $_GET["assistent"];
            if(isset($_GET["selectPeriodo"])) $tipoPeriodo = $_GET["selectPeriodo"];
            $ano        = ($tipoPeriodo == 1 ? false : $_GET["ano"]);
            $mes        = ($tipoPeriodo == 1 ? false : $_GET["mes"]);
            $dateini    = ($tipoPeriodo == 4 ? $_GET["dateini"]:false);
            $dateend    = ($tipoPeriodo == 4 ? $_GET["dateend"]:false);

            $newLeads                   = Metrics::newLeads(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $allLeads                   = Metrics::allLeads(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $newContracts               = Metrics::newContracts(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $totals                     = Metrics::totals(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $remarketing                = Metrics::remarketing(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $vendas_remarketing         = Metrics::vendasRemarketing(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$remarketing_remanejado     = Metrics::remarketing_remanejado(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$newContractsNoRemarketing  = Metrics::newContractsNoRemarketing(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasCanceladas           = Metrics::vendasCanceladas(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasSemData              = Metrics::vendasSemData(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasAguardandoPag        = Metrics::vendasAguardandoPag(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasAguardandoFin        = Metrics::vendasAguardandoFin(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasConcluída            = Metrics::vendasConcluída(false, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);

            $tabs = [];
            //$tabs[] = ['title' => "Geral", 'route' => route('metrics.geral')];
            $tabs[] = ['title' => "Geral", 'route' => route('metrics')];


            $sufixo = "";
            if($tipoPeriodo == 2) $sufixo = " (".str_pad($mes , 2 , '0' , STR_PAD_LEFT)."/".$ano.") ";
            if($tipoPeriodo == 3) $sufixo = " (".$ano.") ";
            if($tipoPeriodo == 4){ 
                $explode = explode('-', $dateini);
                $monthini = date('M', mktime(0, 0, 0, $explode[1], 10));
                $yearini = $explode[0];
                $dayini = $explode[2];
                $explode = explode('-', $dateend);
                $monthend = date('M', mktime(0, 0, 0, $explode[1], 10));
                $yearend = $explode[0];
                $dayend = $explode[2];

                $sufixo = " ( $dayini/$monthini/$yearini Até $dayend/$monthend/$yearend ) ";
            }



            foreach($teams as $team){
                $tabs[] = ['title' => $team->name, 'route' => route('metrics.team', [$team->id])];
            }



            $title = 'Todas as equipes ';
            if($assistent){
                //$assistent = User::where("id", $assistent)->first();
                //$title = "Atendente: ".$assistent->name;
            }

            return view('metrics.index', [
                'title' => $title.$sufixo,
                'tabs' => $tabs, 
                'leads' => array_reverse($allLeads),                                        // Total de leads
                'novosLeads' => array_reverse($newLeads),                                   // Leads sem remarketing
                'remarketing' => array_reverse($remarketing),                               // Leads de remarketing
                'contracts' => array_reverse($newContracts),                                // Total de Vendas
                'vendas_remarketing' => array_reverse($vendas_remarketing),                 // Leads de remarketing vendidos
                //'newContractsNoRemarketing' =>  array_reverse($newContractsNoRemarketing),  // Leads sem remarketing vendidos
                'totals' => array_reverse($totals),                                         // Valor de vendas
                //'remarketing_remanejado' => array_reverse($remarketing_remanejado),         // Descontinuado
                'listAssistents' => $listAssistents,
                //'vendasCanceladas' => $vendasCanceladas,
                //'vendasSemData' => $vendasSemData,
                //'vendasAguardandoPag' => $vendasAguardandoPag,
                //'vendasAguardandoFin' => $vendasAguardandoFin,
                //'vendasConcluída' => $vendasConcluída
            ]);

        // Se o Usuário for Gerente
        } elseif(Auth::user()->hasRole('Gerente')) {

            $team_id = Auth::user()->team_id;
            $team_selected = Team::where('team_id', $team_id)->first();
            //$listAssistents = User::where([["sector_id", 3], ["team_id", $team_id]])->get();
            //$listAssistents = User::listAssistents($team_id);
            $listAssistents = User::where('tenancy_id', Auth::user()->tenancy_id)->where('team_id', $team_id)->get();
            $assistent = false;

            if(isset($_GET["assistent"])?$_GET["assistent"]>0:false) $assistent = $_GET["assistent"];
            $tipoPeriodo = 1;
            if(isset($_GET["selectPeriodo"])) $tipoPeriodo = $_GET["selectPeriodo"];
            $ano  = ($tipoPeriodo == 1 ? false : $_GET["ano"]);
            $mes  = ($tipoPeriodo == 1 ? false : $_GET["mes"]);
            $dateini  = ($tipoPeriodo == 4 ? $_GET["dateini"] : false);
            $dateend  = ($tipoPeriodo == 4 ? $_GET["dateend"]  : false);

            $newLeads                   = Metrics::newLeads($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $allLeads                   = Metrics::allLeads($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $newContracts               = Metrics::newContracts($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $totals                     = Metrics::totals($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $remarketing                = Metrics::remarketing($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $vendas_remarketing         = Metrics::vendasRemarketing($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$remarketing_remanejado     = Metrics::remarketing_remanejado($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$newContractsNoRemarketing  = Metrics::newContractsNoRemarketing($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasCanceladas           = Metrics::vendasCanceladas($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasSemData              = Metrics::vendasSemData($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasAguardandoPag        = Metrics::vendasAguardandoPag($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasAguardandoFin        = Metrics::vendasAguardandoFin($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasConcluída            = Metrics::vendasConcluída($team_id, $assistent, $tipoPeriodo, $ano, $mes, $dateini, $dateend);


            $sufixo = "";
            if($tipoPeriodo == 2) $sufixo = " (".str_pad($mes , 2 , '0' , STR_PAD_LEFT)."/".$ano.") ";
            if($tipoPeriodo == 3) $sufixo = " (".$ano.") ";
            if($tipoPeriodo == 4){ 
                $explode = explode('-', $dateini);
                $monthini = date('M', mktime(0, 0, 0, $explode[1], 10));
                $yearini = $explode[0];
                $dayini = $explode[2];
                $explode = explode('-', $dateend);
                $monthend = date('M', mktime(0, 0, 0, $explode[1], 10));
                $yearend = $explode[0];
                $dayend = $explode[2];

                $sufixo = " ( $dayini/$monthini/$yearini Até $dayend/$monthend/$yearend ) ";
            }


            $tabs = [];
            //$tabs[] = ['title' => 'Equipe: '.$team_selected->team, 'route' => route('metrics.geral')];
            $tabs[] = ['title' => 'Equipe: '.$team_selected->team, 'route' => route('metrics')];
            
            return view('metrics.index', [
                'title' => 'Equipe: '.$team_selected->team.$sufixo,
                'tabs' => $tabs, 
                'leads' => array_reverse($allLeads),                                        // Total de leads
                'novosLeads' => array_reverse($newLeads),                                   // Leads sem remarketing
                'remarketing' => array_reverse($remarketing),                               // Leads de remarketing
                'contracts' => array_reverse($newContracts),                                // Total de Vendas
                'vendas_remarketing' => array_reverse($vendas_remarketing),                 // Leads de remarketing vendidos
                //'newContractsNoRemarketing' =>  array_reverse($newContractsNoRemarketing),  // Leads sem remarketing vendidos
                'totals' => array_reverse($totals),                                         // Valor de vendas
                //'remarketing_remanejado' => array_reverse($remarketing_remanejado),         // Descontinuado
                'listAssistents' => $listAssistents,
                //'vendasCanceladas' => $vendasCanceladas,
                //'vendasSemData' => $vendasSemData,
                //'vendasAguardandoPag' => $vendasAguardandoPag,
                //'vendasAguardandoFin' => $vendasAguardandoFin,
                //'vendasConcluída' => $vendasConcluída
            ]);
        // Se o Usuário for Assistente
        } elseif(Auth::user()->hasRole('Assistente')) {

            $team_id = Auth::user()->team_id;
            $assistent_id = Auth::user()->id;

            // Se o Usuário for Master
            /*$teams = Team::where('sector_id', 3)->get();
            $team_selected = Team::where('team_id', $team_id)->first();

            $newLeads = Metrics::newLeads($team_id, $assistent_id);
            $newContracts = Metrics::newContracts($team_id, $assistent_id);
            $totals = Metrics::totals($team_id, $assistent_id);
            $remarketing = Metrics::remarketing($team_id, $assistent_id);
            */

            $tipoPeriodo = 1;
            if(isset($_GET["selectPeriodo"])) $tipoPeriodo = $_GET["selectPeriodo"];
            $ano  = ($tipoPeriodo == 1 ? false : $_GET["ano"]);
            $mes  = ($tipoPeriodo == 1 ? false : $_GET["mes"]);
            $dateini  = ($tipoPeriodo == 4 ? $_GET["dateini"] : false);
            $dateend  = ($tipoPeriodo == 4 ? $_GET["dateend"]  : false);

            $newLeads                   = Metrics::newLeads(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $allLeads                   = Metrics::allLeads(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $newContracts               = Metrics::newContracts(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $totals                     = Metrics::totals(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $remarketing                = Metrics::remarketing(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            $vendas_remarketing         = Metrics::vendasRemarketing(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$remarketing_remanejado     = Metrics::remarketing_remanejado(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$newContractsNoRemarketing  = Metrics::newContractsNoRemarketing(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasCanceladas           = Metrics::vendasCanceladas(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasSemData              = Metrics::vendasSemData(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasAguardandoPag        = Metrics::vendasAguardandoPag(false,  $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasAguardandoFin        = Metrics::vendasAguardandoFin(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);
            //$vendasConcluída            = Metrics::vendasConcluída(false, $assistent_id, $tipoPeriodo, $ano, $mes, $dateini, $dateend);

            $sufixo = "";
            if($tipoPeriodo == 2) $sufixo = " (".str_pad($mes , 2 , '0' , STR_PAD_LEFT)."/".$ano.") ";
            if($tipoPeriodo == 3) $sufixo = " (".$ano.") ";
            if($tipoPeriodo == 4){ 
                $explode = explode('-', $dateini);
                $monthini = date('M', mktime(0, 0, 0, $explode[1], 10));
                $yearini = $explode[0];
                $dayini = $explode[2];
                $explode = explode('-', $dateend);
                $monthend = date('M', mktime(0, 0, 0, $explode[1], 10));
                $yearend = $explode[0];
                $dayend = $explode[2];

                $sufixo = " ( $dayini/$monthini/$yearini Até $dayend/$monthend/$yearend ) ";
            }


            $tabs = [];
            //$tabs[] = ['title' => 'Meus relatórios de venda', 'route' => route('metrics.geral')];
            $tabs[] = ['title' => 'Meus relatórios de venda', 'route' => route('metrics')];
            
            return view('metrics.index', [
                'title' => 'Meus relatórios de venda '.$sufixo,
                'tabs' => $tabs, 
                'leads' => array_reverse($allLeads),                                        // Total de leads
                'novosLeads' => array_reverse($newLeads),                                   // Leads sem remarketing
                'remarketing' => array_reverse($remarketing),                               // Leads de remarketing
                'contracts' => array_reverse($newContracts),                                // Total de Vendas
                'vendas_remarketing' => array_reverse($vendas_remarketing),                 // Leads de remarketing vendidos
                //'newContractsNoRemarketing' =>  array_reverse($newContractsNoRemarketing),// Leads sem remarketing vendidos
                'totals' => array_reverse($totals),                                         // Valor de vendas
                //'remarketing_remanejado' => array_reverse($remarketing_remanejado),       // Descontinuado
                //'vendasCanceladas' => $vendasCanceladas,
                //'vendasSemData' => $vendasSemData,
                //'vendasAguardandoPag' => $vendasAguardandoPag,
                //'vendasAguardandoFin' => $vendasAguardandoFin,
                //'vendasConcluída' => $vendasConcluída
            ]);

        }
    }
}
