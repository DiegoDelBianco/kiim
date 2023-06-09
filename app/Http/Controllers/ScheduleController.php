<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\CustomerService;
use Illuminate\Http\Request;
use App\Models\CustomerTimeline;
class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(request $request, CustomerService $customer_service)
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
