@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Leads Vendidos</h1>
@stop

@section('content')


    <div class="bg-white main-canvas">
        <div class="d-flex flex-row justify-content-between shadow-sm">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vendas</li>
                </ol>
            </nav>
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

        @include('customers.components.list-templates.list-customers-salles')

@stop

@section('css')

@stop

@section('js')

@stop