@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Seu painel imobiliário</h1>
@stop

@section('content')
    <p>Bem vindo</p>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!--link rel="stylesheet" href="/css/admin_custom.css"-->
@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop