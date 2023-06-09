
<!-- TAB DE TAREFAS -->
<div id="horizontal__tab04" class="horizontal__tabcontent">
    <h3>Agendamentos</h3>

    @if( $customer->opened == 1 and $customer->customerService)
        <div class="pt-2 pe-2 pb-4 text-center">
            <button data-toggle="modal" data-target="#modal-create-schedule" type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Agendar tarefa</span>
            </button>
        </div>
        @include('customers.components.modals.create-schedule-modal')
    @endif
    @if($customer->customerService)
        @foreach($customer->customerService->schedules as $tarefa)
            <div class="tarefa">
                <div class="tarefa-data">
                    <p>
                        <span class="status {{$tarefa->getStatus(1)}} " title='{{$tarefa->getStatus(1)}}'></span>
                        {{date('d/m/Y',strtotime($tarefa->date))}} {{$tarefa->time!=""?"ás ".substr($tarefa->time, 0, 5):""}} 
                        <i data-toggle="modal" data-target="#modal-edit-schedule-{{$tarefa->id}}" class="fas fa-pen tarefa-edit-button"></i> 
                    </p>
                </div>
                <div class="description">
                    <p>Status: <span class="status {{$tarefa->getStatus(1)}} ">{{$tarefa->getStatus(1)}}</span></p>
                    <p>{{$tarefa->description}}</p>
                </div>
            </div>
            @include('customers.components.modals.edit-schedule-modal.blade.php')
        @endforeach
    @endif

</div>
<!-- FIM TAB DE TAREFAS -->