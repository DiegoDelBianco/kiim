
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
            @include('customers.components.modals.edit-schedule-modal')
        @endforeach
        <style>
      .calendar_table{
        width: 100%;
        margin-bottom: 60px;
      }
      .calendar_table thead th{
        padding: 5px 0px
        }
      .calendar_table thead{
        background: #333;
        color: #fff;
      }
      .calendar_table tbody tr{
        border-bottom: 2px solid #ddd;
      }
      .calendar_table tbody tr td{
        border-left: 1px solid #ddd;
      }
      .calendar_table tbody tr td{
        min-height: 250px;
      }
      .calendar_table th, .calendar_table td{
        width: calc(100% / 7);
        text-align: center;
        vertical-align: text-top;
      }
      /*.calendar_table tr td:nth-child(even) {
          background:#fafafa;
       }*/
      .calendar_table .inativo{
        background: #eaeaea !important;
      }
      .calendar_table .day-wrap{
        text-align:center
      }
      .calendar_table .day{
        background: #222;
        color: #fff;
        background: #74b9ff;        color: #000;
        display: inline-block;
        line-height: 30px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin: 15px 0px 10px 0px;
      }
      .calendar_table .fds .day{
        background: #ed7475;
        background: #006ede;
        color: #fff;
      }
      .calendar_table .hoje .day{
        background: #fdcb6e;
        color: #000;
      }
      .calendar_table .scheduling{
        background: #eaeaea;
        border-radius: 5px;
        border: 1px solid #aaa;
        padding: 5px;
      }
      .calendar_table .scheduling:hover{
        cursor:pointer;
        background: #dadada;
      }
      .calendar_table .scheduling .assistent-name{
        line-height: 25px;
        display: inline-block;
        overflow: hidden;
        height: 25px;
        width: 100%;
      }
      .calendar_table .scheduling .hour{
        background: #222;
        color: #fff;
        border-radius: 10px;
        padding: 2px 5px;
      }
      .calendar_table .cancelado-wrap{
        display:none;
      }
      h1{
        text-align: center;
        padding-top: 20px;
      }

    .tarefa{
        display: block;
        width: 500px;
        max-width: 90%;
        margin: 0 auto 20px auto;
        background-color: #efefef;
        border-radius: 5px;
        border: 1px solid #aaa;
        padding: 0 0;
        text-align: center;
        overflow: hidden;
    }
    .tarefa .tarefa-data{
        background-color: #0a0a0a;
        color: #fff;
        font-size: 20px;
        line-height: 37px;
    }

    .tarefa .description{
        font-size: 18px;
        color: #000;
    }
    .status{
        display: inline-block;
        min-width: 18px;
        min-height: 18px;
        border-radius: 9px;
        background-color: white;
        margin-left: 5px;
        margin-right: 5px;
        padding: 2px 9px;
        color: #000;
        font-weight: 400;
        text-transform: capitalize;
    }
    .status.aguardando{
        background-color: #74b9ff;
    }
    .status.cancelado{
        background-color: #636e72;
    }
    .status.feito{
        background-color: #00b894;
    }
    .status.hoje{
        background-color: #fdcb6e;
    }
    .status.atrasado{
        background-color: #d63031;
    }
    .tarefa-edit-button{
        font-size: 15px;
        margin: 0 5px;
        cursor: pointer;
    }
  </style>

    @endif

</div>
<!-- FIM TAB DE TAREFAS -->
