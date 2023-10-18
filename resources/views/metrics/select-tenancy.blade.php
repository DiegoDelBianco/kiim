@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Métricas</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Métricas</li>
                </ol>
            </nav>

        </div>

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


            <h1>Você deseja ver as métricas de qual empresa?</h1>

            <div class="row">
            @foreach($tenancies as $tenancy)
                    <div class="col-md-3" style="">
                        <div class="card" style="width: 18rem;background:#eee; width: 100%">
                            <div class="card-body">
                                <h5 class="card-title">{{$tenancy->name}}</h5>
                                <br>
                                <a href="?tenancy={{$tenancy->id}}" class="card-link">Ver Métricas</a>
                            </div>
                        </div>
                    </div>
            @endforeach
                </div>

            </div>
    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
    <!-- call echarts cdn script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.1.0/echarts.min.js"></script>

@stop
