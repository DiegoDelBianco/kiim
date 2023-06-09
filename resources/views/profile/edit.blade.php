
@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <!--h1>{{ __('Perfil') }}</h1-->
@stop

@section('content')
    <div class="py-0 pb-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!--div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div-->
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