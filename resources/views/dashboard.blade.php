@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Bem vindo {{Auth::user()->name}}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 style="margin-bottom: 15px; font-size: 22px; color: #777">Algumas opções para você:</h2>
        </div>
    </div>
    <div class="row">
        @can('menu-config')
        <div class="col-md-4">
            <!-- A boostrap card to call tenancies route -->
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title float-none pb-2"> <i class="fas fa-fw fa-cogs "></i> Configurações</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Seus dados e pacotes</h6>
                    <p class="card-text mb-2">Atualize seus dados empresariais e veja seus pacotes contratados.</p>
                    <a href="{{route('tenancies')}}" class="btn btn-primary">Ir agora</a>
                </div>
            </div>
        </div>
        @endcan
        @can('menu-customer-list')
        <div class="col-md-4">
            <!-- A boostrap card to call tenancies route -->
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title float-none pb-2"> <i class="fas fa-fw fa-address-book "></i> Leads</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Veja todos os seus leads</h6>
                    <p class="card-text mb-2">Veja, adicione e administre seus leads.</p>
                    <a href="{{route('customers')}}" class="btn btn-primary">Ir agora</a>
                </div>
            </div>
        </div>
        @endcan
        @can('menu-customer-service')
        <div class="col-md-4">
            <!-- A boostrap card to call tenancies route -->
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title float-none pb-2"> <i class="fas fa-fw fa-headphones "></i> Atendimento</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Atenda novos leads</h6>
                    <p class="card-text mb-2">Puxe novos leads do sistema para você atender.</p>
                    <a href="{{route('customers.customer-services')}}" class="btn btn-primary">Ir agora</a>
                </div>
            </div>
        </div>
        @endcan
        @can('menu-customer-service-remarketing')
        <div class="col-md-4">
            <!-- A boostrap card to call tenancies route -->
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title float-none pb-2"> <i class="fas fa-fw fa-recycle "></i> Leads Retorno</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Atenda leads antigo</h6>
                    <p class="card-text mb-2">Puxe leads que já foram atendidos a algum tempo, mas não converteram.</p>
                    <a href="{{route('customers.customer-services.remarketing')}}" class="btn btn-primary">Ir agora</a>
                </div>
            </div>
        </div>
        @endcan
        @can('menu-metrics')
        <div class="col-md-4">
            <!-- A boostrap card to call tenancies route -->
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title float-none pb-2"> <i class="fas fa-fw fa-chart-bar "></i> Métricas</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Gráficos do sistema</h6>
                    <p class="card-text mb-2">Veja seus dados de atendimento e vendas.</p>
                    <a href="{{route('metrics')}}" class="btn btn-primary">Ir agora</a>
                </div>
            </div>
        </div>
        @endcan
        <div class="col-md-4">
            <!-- A boostrap card to call tenancies route -->
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title float-none pb-2"> <i class="fas fa-fw fa-user-circle "></i> Meus dados</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Seus dados pessoais</h6>
                    <p class="card-text mb-2">Atualize seus dados pessoais e senha.</p>
                    <a href="{{route('profile.edit')}}" class="btn btn-primary">Ir agora</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!--link rel="stylesheet" href="/css/admin_custom.css"-->
@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop