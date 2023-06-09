@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Atendimento @if($is_remarketing) Retorno @endif</h1>
@stop

@section('content')


    <div class="bg-white main-canvas">
        <div class="d-flex flex-row justify-content-between shadow-sm">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Atedimento @if($is_remarketing) Remarketing @endif</li>
                </ol>
            </nav>
            @if($customer)
                <div class="pt-2 pe-2">
                    <button data-toggle="modal" data-target="#modal-create-customer-timeline" type="button" class="btn btn-outline-secondary" aria-expanded="false">
                        <i class="fas fa-book"></i>
                        <span>Novo Registro</span>
                    </button>
                    @include('customers.components.modals.create-customer-timeline-modal')
                </div>
            @endif
        </div>

        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
        </div>
        @elseif(session()->has('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session()->get('error') }}
        </div>
        @endif


    <!-- CASO O ATENDENTE TENHA UM ATENDIMENTO EM ABERTO -->
    @if($customer != "")
        @include('customers.components.show-customer-service')

    <!-- CASO O ATENDENTE NÃO TENHA UM ATENDIMENTO EM ABERTO -->
    @else
        <div class="p-3">
        <div class="alert alert-warning" role="alert">
            Você ainda não está atendendo nenhum Lead, clique no botão abaixo para atender um agora mesmo:
        </div>
        <p>
            <form method="POST" action="{{ route('customers.customer-services.store') }}">
                @csrf
                <input type="hidden" name="remarketing" value="{{ $is_remarketing ? 1 : 0 }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <button type="submit" class="btn btn-info loadlayer">Atender Lead</button>
            </form>
        </p>
        </div>
    @endif

@stop

@section('css')

@stop

@section('js')
@stop