@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Agênda</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Agênda</li>
                </ol>
            </nav>

            <div class="pt-2 pe-2">
                <button data-toggle="modal" data-target="#modal-create-schedule" type="button" class="btn btn-primary" >
                    <i class="fas fa-plus"></i>
                    <span>Tarefa</span>
                </button>
            </div>

        </div>

        @include('schedules.components.create-schedule-modal')
        @include('schedules.components.view-schedule-modal')
        @include('schedules.components.view-list-late-schedule-modal')
        @include('schedules.components.view-list-today-schedule-modal')

        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
            </div>

        <!-- MENSAGEM DE ERRO AO ADICIONAR LEAD  -->
        @elseif(session()->has('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
            <div class="card-body">



            <h1> Calendário - {{$mes}} de {{$ano}}</h1>
            @if(count($atrasados) > 0)
                <button data-toggle="modal" data-target="#modalSchedulingAtrasados" class="btn btn-danger buttonListAtraso" ><i class="fas fa-exclamation-circle"></i></button>
                <style>
                    .buttonListAtraso{
                        float:left;
                        width: 50px;
                        margin-right: -80px;
                        margin-left: 30px;
                        margin-top: 10px;
                    }
                </style>
            @endif
            @if(count($hoje) > 0)
                <button data-toggle="modal" data-target="#modalSchedulingHoje" class="btn btn-warning buttonListHoje" ><i class="fas fa-exclamation-circle"></i></button>
                <style>
                    .buttonListHoje{
                        float:left;
                        width: 50px;
                        margin-right: {{ (count($atrasados) > 0)?'-170px':'-80px'}};
                        margin-left: {{ (count($atrasados) > 0)?'90px':'30px'}};
                        margin-top: 10px;
                        color: #fff;
                    }
                    .buttonListHoje:hover{
                        color: #fff;
                    }
                </style>
            @endif
            <div class="control-periodo">
                <form action="">
                    <input type="hidden" name='periodo' value='semana'>
                    <button type="submit" class="loadlayer {{isset($_GET['periodo'])?($_GET['periodo']=='semana'?'active':''):'active'}}">Semana</button>
                </form>
                <form action="">
                    <input type="hidden" name='periodo' value='mes'>
                    <button type="submit" class="loadlayer {{isset($_GET['periodo'])?($_GET['periodo']=='mes'?'active':''):''}}">Mês</button>
                </form>
            </div>
            <style>
                .control-periodo{
                    float: right;
                    margin: 10px 20px 20px 20px;
                    border-radius: 15px;
                    overflow: hidden;
                    background: #eee;
                    border: 1px solid #aaa;
                }
                .control-periodo form, .control-periodo button{
                    display:inline-block;
                }
                .control-periodo form{
                    margin-left: 0px;
                }
                .control-periodo button{
                    margin: 0px;
                    border: 0px;
                    background: transparent;
                    height: 40px;
                    width: 75px;
                    text-align: center;
                    line-height: 40px;
                }

                .control-periodo button.active{
                    background: #16e9b3;
                    color: black;
                }
            </style>
            <div class="control-next">
                <form action="">
                    <input type="hidden" name='periodo' value='{{isset($_GET["periodo"])?$_GET["periodo"]:"semana"}}'>
                    <input type="hidden" name='ref' value='{{$prev}}'>

                    <button type="submit" class="loadlayer"><i class="fas fa-angle-left"></i> Anterior</button>
                </form>
                <form action="" style="border-left: 1px solid #aaa">
                    <input type="hidden" name='periodo' value='{{isset($_GET["periodo"])?$_GET["periodo"]:"semana"}}'>
                    <input type="hidden" name='ref' value='{{$next}}'>
                    <button type="submit" class="loadlayer">Próximo <i class="fas fa-angle-right"></i></button>

                </form>
            </div>
            <style>
                .control-next{
                    border-radius: 15px;
                    overflow: hidden;
                    background: #eee;
                    border: 1px solid #aaa;
                    float: left;
                    margin-left: calc(50% - 95px);
                    margin-top: 20px;
                    margin-bottom: 15px;
                }
                .control-next form, .control-periodo button{
                    display:inline-block;
                }
                .control-next form{
                    margin-left: 0px;
                }
                .control-next button{
                    margin: 0px;
                    border: 0px;
                    background: transparent;
                    height: 40px;
                    width: 95px;
                    text-align: center;
                    line-height: 40px;
                }

                .control-next button.active{
                    background: #16e9b3;
                    color: black;
                }
            </style>

            <table class="calendar_table" style="width:100%">
                <thead>
                    <tr>
                        <th>Domingo</th>
                        <th>Segunda</th>
                        <th>Terça</th>
                        <th>Quarta</th>
                        <th>Quinta</th>
                        <th>Sexta</th>
                        <th>Sabado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calendar as $week)
                        <tr>
                            @foreach($week as $day)
                                <td class="{{$day['day']==0?'inativo':''}} {{$day['today']?'hoje':''}} {{($day['weekDay']==0 OR $day['weekDay']==6)?'fds':''}}">
                                    @if($day['day']!=0)
                                        <p class="day-wrap" ><span class="day">{{$day['day']==0?'':$day['day']}}</span></p>
                                        @foreach($day['schedules'] as $tarefa)
                                            {{--<p class="scheduling  {{$tarefa->getStatus(TRUE)}}-wrap" onClick="showScheduling('{{route("customer.edit", $tarefa->customer_id)}}', '{{$tarefa->customer_name}}', '{{$tarefa->assistent_name}}', `{{str_replace("`",'"',$tarefa->description)}}`, '{{date("d/m/Y",strtotime($tarefa->date))}}', '{{substr($tarefa->hour, 0, 5)}}', '{{$tarefa->getStatus(TRUE)}}')"  data-toggle="modal" data-target="#modalSchedulingInfo" >--}}
                                            <p class="scheduling  {{$tarefa->getStatus(TRUE)}}-wrap" onClick="showScheduling('{{route("schedules.update.done", $tarefa->id)}}', '{{route("schedules.update.cancel", $tarefa->id)}}', '{{$tarefa->user_name}}', `{{str_replace("`",'"',$tarefa->description)}}`, '{{date("d/m/Y",strtotime($tarefa->date))}}', '{{substr($tarefa->time, 0, 5)}}', '{{$tarefa->getStatus(TRUE)}}')"  data-toggle="modal" data-target="#modalSchedulingInfo" >
                                                <span class="assistent-name">{{$tarefa->user_name}}</span>
                                                @if($tarefa->time != "")
                                                    <span class="hour">{{substr($tarefa->time, 0, 5)}}</span>
                                                @endif
                                                <span class="status {{$tarefa->getStatus(TRUE)}}"></span>
                                            </p>
                                        @endforeach
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

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

  <script>
      function showScheduling(doneUrl, cancelUrl, vendedor, nota, data, hora, status){
        /*$('#modalSchedulingInfo .ver-atendimento').attr('href', route);*/
        /*$('#modalSchedulingInfo .customer-name').html(cliente);*/
        $('#modalSchedulingInfo .form-schedules-done').attr('action', doneUrl);
        $('#modalSchedulingInfo .form-schedules-cancel').attr('action', cancelUrl);
        $('#modalSchedulingInfo .assistent-name').html(vendedor);
        $('#modalSchedulingInfo .scheduling-note').html(nota);
        $('#modalSchedulingInfo .scheduling-date').html(data);
        $('#modalSchedulingInfo .scheduling-hour').html(hora);
        $('#modalSchedulingInfo .status-name').html(status);
        $('#modalSchedulingInfo .status').removeClass('cancelado');
        $('#modalSchedulingInfo .status').removeClass('feito');
        $('#modalSchedulingInfo .status').removeClass('aguardando');
        $('#modalSchedulingInfo .status').removeClass('hoje');
        $('#modalSchedulingInfo .status').removeClass('atrasado');
        $('#modalSchedulingInfo .status').addClass(status);
        if(hora == ''){
            $('#modalSchedulingInfo .time-wrap').hide();
        }else{
            $('#modalSchedulingInfo .time-wrap').show();
        }

        $('.alt-status').hide();
        $('.btn-alt-status').show();
      }
  </script>







            </div>
    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop
