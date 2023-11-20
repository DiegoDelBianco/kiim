@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Api do facebook</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">API do facebook</li>
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
                <h2>Configurar API do facebook</h2>

                <fb:login-button
                config_id="{config_id}"
                onlogin="checkLoginState();">
                </fb:login-button>
            </div>
    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')

    <script>
        window.fbAsyncInit = function() {
            FB.init({
            appId      : '6860070017375035',
            cookie     : true,
            xfbml      : true,
            version    : 'v18.0'
            });

            FB.AppEvents.logPageView();



            FB.getLoginStatus(function(response) {
                console.log(response);
                statusChangeCallback(response);
            });

        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
        }
    </script>
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop
