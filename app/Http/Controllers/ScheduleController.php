<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\CustomerService;
use Illuminate\Http\Request;
use App\Models\CustomerTimeline;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenancy;
use App\Models\ScheduleType;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {



        $tenancies = [];

        foreach(Auth::user()->roles as $tenancy){
            $current_tenancy = Tenancy::find($tenancy->tenancy_id);
            $tenancies[$tenancy->tenancy_id] = $current_tenancy;
        }

        $periodo = 2;
        if(isset($_GET['periodo'])){
            switch ($_GET['periodo']) {
                case 'mes':
                    $periodo = 1;
                    break;
                case 'semana':
                    $periodo = 2;
                    break;

                default:
                    $periodo = 1;
                    break;
            }
        }
        $meses = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );

        $month = false;
        $year = false;
        $difference = 0;

        if($periodo == 1 AND isset($_GET['ref'])){
            $next = date('Y-m', strtotime("+1 month",strtotime($_GET['ref'].'-01')));
            $prev = date('Y-m', strtotime("-1 month",strtotime($_GET['ref'].'-01')));
            $month = substr($_GET['ref'], 5, 2);
            $year = substr($_GET['ref'], 0, 4);
        }elseif($periodo == 1){
            $next = date('Y-m', strtotime("+1 month"));
            $prev = date('Y-m', strtotime("-1 month"));
        }elseif($periodo == 2 AND  isset($_GET['ref'])){
            $next = $_GET['ref'] + 1;
            $prev = $_GET['ref'] - 1;
            if($next >= 0) $next = '+'.$next;
            if($prev >= 0) $prev = '+'.$prev;
            $difference = $_GET['ref'];
        }else{
            $next = '+1';
            $prev = '-1';
        }

        $result = Schedule::calendarMonth($periodo, $month, $year, $difference);




        return view('schedules.calendar', [
            'tenancies' => $tenancies,
            'calendar' => $result['calendar'],
            'ano' => $result['year'],
            'mes' => $meses[$result['month']],
            'prev' => $prev,
            'next' => $next,
            'atrasados' => Schedule::listByStatus(5),
            'hoje' => Schedule::listByStatus(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(request $request)
    {
        $tenancy_id = $request->tenancy_id;
        $tenancy = Tenancy::find($tenancy_id);

        if(!$tenancy)
            return redirect()->back()->with('error', 'Empresa não encontrada');

        $rel = $tenancy->users()->where('user_id', Auth::user()->id)->first();

        if(!$rel)
            return redirect()->back()->with('error', 'Você não tem permissão para adicionar leads nesta empresa');

        //if(!($customer_service->status == 1 OR $customer_service->status == 2)) return back()->with('error','Atendimento indisponivel para novos agendamentos');

        if(strlen($request->description) > 255 ) return back()->with('error','Descrição muito longa, deve ter no máximo 255 caracteres');
        if(strlen($request->description) == 0 ) return back()->with('error','Descrição é obrigatória');
        if($request->schedule_type_id and !ScheduleType::find($request->schedule_type_id)) return back()->with('error','Tipo de agendamento não encontrado');

        $result = Schedule::create([
            //'customer_service_id' => $customer_service->id,
            'tenancy_id' => $tenancy_id,
            'user_id' => Auth::user()->id,
            'description' => $request->description,
            'schedule_type_id' => $request->schedule_type_id,
            'title' => $request->title,
            'date' => $request->date,
            'time' => $request->time,
        ]);


        $timeline = new CustomerTimeline;
        //$event = $timeline->newTimeline($customer_service->customer_id, "Novo agendamento de tarefa, dia ".date('d/m/Y',strtotime($request->date))." as ".$request->time , 5);
        return back()->with('success','Agendamento realizado com sucesso!');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeWithCS(request $request, CustomerService $customer_service)
    {
        if (!$customer_service)
            return redirect()->back()->with('error', 'Atendimento não encontrado');

        $tenancy_id = $customer_service->tenancy_id;
        $tenancy = Tenancy::find($tenancy_id);

        if(!$tenancy)
            return redirect()->back()->with('error', 'Empresa não encontrada');

        $rel = $tenancy->users()->where('user_id', Auth::user()->id)->first();

        if(!$rel)
            return redirect()->back()->with('error', 'Você não tem permissão para adicionar leads nesta empresa');

        //if(!($customer_service->status == 1 OR $customer_service->status == 2)) return back()->with('error','Atendimento indisponivel para novos agendamentos');

        if(strlen($request->description) > 255 ) return back()->with('error','Descrição muito longa, deve ter no máximo 255 caracteres');
        if(strlen($request->description) == 0 ) return back()->with('error','Descrição é obrigatória');
        if(!ScheduleType::find($request->schedule_type_id)) return back()->with('error','Tipo de agendamento não encontrado');

        $result = Schedule::create([
            //'customer_service_id' => $customer_service->id,
            'title' => $customer_service->customer->name,
            'tenancy_id' => $tenancy_id,
            'user_id' => Auth::user()->id,
            'schedule_type_id' => $request->schedule_type_id,
            'customer_id' => $customer_service->customer_id,
            'customer_service_id' => $customer_service->id,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
        ]);


        $timeline = new CustomerTimeline;
        //$event = $timeline->newTimeline($customer_service->customer_id, "Novo agendamento de tarefa, dia ".date('d/m/Y',strtotime($request->date))." as ".$request->time , 5);

        return back()->with('success','Agendamento realizado com sucesso!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeCustomerService(request $request, CustomerService $customer_service)
    {
        $this->authorize('create', $customer_service);

        if(!($customer_service->status == 1 OR $customer_service->status == 2)) return back()->with('error','Atendimento indisponivel para novos agendamentos');

        if(strlen($request->description) > 255 ) return back()->with('error','Descrição muito longa, deve ter no máximo 255 caracteres');
        if(strlen($request->description) == 0 ) return back()->with('error','Descrição é obrigatória');

        $result = Schedule::create([
            'customer_service_id' => $customer_service->id,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
        ]);


        $timeline = new CustomerTimeline;
        $event = $timeline->newTimeline($customer_service->customer_id, "Novo agendamento de tarefa, dia ".date('d/m/Y',strtotime($request->date))." as ".$request->time , 5);

        return back()->with('success','Agendamento realizado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editDone(Schedule $schedule)
    {
        if(Auth::user()->id !== $schedule->user_id) return back()->with('error','Você não tem permissão para cancelar este agendamento');

        $schedule->status = 2;
        $schedule->save();

        return back()->with('success','Agendamento cancelado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editCancel(Schedule $schedule)
    {
        if(Auth::user()->id !== $schedule->user_id) return back()->with('error','Você não tem permissão para cancelar este agendamento');

        $schedule->status = 3;
        $schedule->save();

        return back()->with('success','Agendamento cancelado com sucesso!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(request $request, Schedule $schedule)
    {
        $this->authorize('update', $customer_service);

        if($request->status != 1 AND $request->status != 2 AND $request->status != 3) return back()->with('error','Status indisponivel');
        if(!($schedule->customerService->status == 1 OR $schedule->customerService->status  == 2) ) return back()->with('error','Atendimento indisponivel para agendamentos');


        $schedule->status = $request->status;
        $schedule->save();
        return back()->with('success', 'Tarefa salva');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
