@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Ficha do lead</h1>
@stop

@section('content')


    <div class="bg-white main-canvas">
        <div class="d-flex flex-row justify-content-between shadow-sm">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('customers')}}">Leads</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $customer->name }}</li>
                </ol>
            </nav>
            <div class="pt-2 pe-2">
                <button data-toggle="modal" data-target="#modal-create-customer-timeline" type="button" class="btn btn-outline-secondary" aria-expanded="false">
                    <i class="fas fa-book"></i>
                    <span>Novo Registro</span>
                </button>
                @include('customers.components.modals.create-customer-timeline-modal')
            </div>
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

        @include('customers.components.show-customer-service')

@stop

@section('css')

@stop

@section('js')
@stop