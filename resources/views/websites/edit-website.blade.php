@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Configuração da Leadpage</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('websites')}}">Leadpages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Configuração da leadpage</li>
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
                
                <form id="addUserForm" method="POST" action="{{route('websites.update', $website)}}">
                    @csrf

                    <p>Link: <a target="_blank" href="{{route('public.websites', $website)}}">{{route('public.websites', $website)}}</a></p>

                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-6">
                            <a href="{{route('websites')}}" class="btn btn-secondary mr-2">Ir para listagem</a>
                            <button class="btn btn-primary" type="submit">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop