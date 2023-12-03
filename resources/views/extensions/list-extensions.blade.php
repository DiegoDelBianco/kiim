@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Extensões</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 style="margin-bottom: 15px; font-size: 22px; color: #777">Algumas opções para você:</h2>
        </div>
    </div>
    <div class="row">
        @foreach($extensions as $key => $extension)
            <div class="col-md-4">
                <!-- A boostrap card to call tenancies route -->
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <h5 class="card-title float-none pb-2"> <i class="{{$extension['icon']}}"></i> {{$extension['title']}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{$extension['subtitle']}}</h6>
                        <p class="card-text mb-2">{{$extension['description']}}</p>
                        @if(\App\Models\Extension::checkActive($key, auth()->user()->tenancy_id))
                            <form action="{{route('extensions.disable')}}" method="POST">
                                @csrf
                                <input type="hidden" name="extension" value="{{$key}}">
                                <button type="submit" class="btn btn-danger loadlayer">Desativar</button>
                                @if($extension['index-route'])
                                    <a href="{{route($extension['index-route'])}}" class="btn btn-info">Ver</a>
                                @endif
                            </form>
                        @else
                            <form action="{{route('extensions.active')}}" method="POST">
                                @csrf
                                <input type="hidden" name="extension" value="{{$key}}">
                                <button type="submit" class="btn btn-info loadlayer">Ativar</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop

@section('css')
    <!--link rel="stylesheet" href="/css/admin_custom.css"-->
@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop
