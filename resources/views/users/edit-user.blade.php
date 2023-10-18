@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Editar Usuários</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('users')}}">Usuários</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
        <div class="card-body h-100">
            <h2 class="mb-4">Editar {{$user->name }} <br /><small>Para: {{$tenancy->name}}</small></h2>

            <form action="{{ route('users.update', [$tenancy, $user]) }}" method="POST">
                @csrf
                {{ method_field('PATCH') }}

                <div class="form-group row">
                    <label for="roles" class="col-md-2 col-form-label text-md-right">Privilégio</label>
                    <div class="col-md-6">
                        @foreach($roles as $name_role => $role)
                            <div class="form-check">
                                <input type="radio" name="roles[]" value="{{ $name_role }}" id="role{{ $name_role }}"
                                @if($user->hasRole($name_role, $tenancy->id)) checked @endif>
                                <label for="role{{ $name_role }}">{{ $role['name'] }} - {{ $role['description'] }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>


                @if(Auth::user()->hasAnyRoles(['admin', 'manager'], $tenancy->id))
                    <div class="form-group row mt-3">
                        <label for="email" class="col-md-2 col-form-label text-md-right">Equipe</label>
                        <div class="col-md-6">
                            <select name="equipeEditUser" id="equipeEditUser" class="form-control">
                                <option value="">Sem equipe</option>
                                @foreach($teams  as $team)
                                    <option value="{{$team->id}}" @if($user->teamId() == $team->id) selected @endif>{{$team->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @elseif(Auth::user()->hasRole('team_manager', $tenancy->id))
                    <input type="hidden" name="equipeEditUser" value="{{ Auth::user()->team_id }}">
                @endif
                <div class="modal-footer mb-4">
                    <a href="{{route('users')}}" type="button" class="btn btn-default">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
            {{--<h5>Mudar Senha</h5>
            <div class="form-group">
                <form id="changePasswordForm" method="POST" action="{{route('users.update.password', $user)}}">
                    @csrf

                    <div class="form-group row">
                        <label for="password" class="col-md-2 col-form-label text-md-right">Senha nova</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>É preciso inserir a nova senha.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="password" class="col-md-2 col-form-label text-md-right">Confirmar senha</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="password_confirmation">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>É preciso confirmar a nova senha.</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0 mt-3">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" form="changePasswordForm" class="btn btn-warning">Mudar Senha</button>
                        </div>
                    </div>
                </form>
            </div>--}}
        </div>
    </div>



@stop

@section('css')

@stop

@section('js')


@stop
