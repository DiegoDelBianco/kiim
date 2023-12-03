@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Extensão: Termometro</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 style="margin-bottom: 15px; font-size: 22px; color: #777">Configure as metas da sua empresa:</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">

                        @foreach($goals as $goal)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    {{$goal->title}}
                                </div>
                                <div class="card-body">
                                    @if($goal->trophy_svg)
                                        <img src="{{\App\Models\Extensions\Thermometer::getImagePath($goal->trophy_svg)}}" style="width: 100%; max-width: 120px; margin: 0 auto; display: block;">
                                    @endif
                                    <p class="card-text mb-1"><b>Recompensa:</b></p>
                                    @if($goal->award_value)
                                        <p class="card-text mb-1">{{$goal->set_limit_lead}} leads por dia.</p>
                                    @endif
                                    @if($goal->set_limit_lead)
                                        <p class="card-text mb-1">R$ {{number_format($goal->award_value, 2, ',', '.');}} reais.</p>
                                    @endif

                                    <p class="card-text mb-1 mt-3"><b>metas:</b></p>
                                    <p class="card-text mb-1">{{ intval($goal->goal)}} Vendas no mês.</p>

                                </div>
                                <div class="card-footer text-muted text-center">
                                    <a class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-goal-{{$goal->id}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-goal-{{$goal->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @include('extensions/thermometer/components/modal-edit-goal')
                        @include('extensions/thermometer/components/modal-delete-goal')
                        @endforeach


                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-create-goal">Adicionar Meta</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    @include('extensions/thermometer/components/modal-create-goal')
@stop

@section('css')
    <!--link rel="stylesheet" href="/css/admin_custom.css"-->
@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop
