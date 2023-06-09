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
        <div class="card-body h-100">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                {{ method_field('PATCH') }}
                <div class="form-group row">
                    <label for="email" class="col-md-2 col-form-label text-md-right">Email</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Nome</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @if(Auth::user()->hasRole('Master'))
                    <hr>
                    <div class="form-group row">
                        <label for="roles" class="col-md-2 col-form-label text-md-right">Privilégio</label>
                        <div class="col-md-6">
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input type="radio" name="roles[]" value="{{ $role->id }}" id="role{{ $role->id }}"
                                    @if($user->roles->pluck('id')->contains($role->id)) checked @endif>
                                    <label for="role{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-md-6 d-none">
                        @foreach($roles as $role)
                            <div class="form-check">
                                <input type="radio" name="roles[]" value="{{ $role->id }}" id="role{{ $role->id }}"
                                @if($user->roles->pluck('id')->contains($role->id)) checked @endif>
                                <label for="role{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        @endforeach
                    </div>
                @endif


                @if(Auth::user()->hasRole('Master'))
                    <div class="form-group row mt-3">
                        <label for="email" class="col-md-2 col-form-label text-md-right">Equipe</label>
                        <div class="col-md-6">
                            <select name="equipeEditUser" id="equipeEditUser" class="form-control">
                                <option value="">Sem equipe</option>
                                @foreach($teams  as $team)
                                    <option value="{{$team->id}}" @if($user->team_id == $team->id) selected @endif>{{$team->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @elseif(Auth::user()->hasRole('Gerente'))
                    <input type="hidden" name="equipeEditUser" value="{{ Auth::user()->team_id }}">
                @endif
                <div class="modal-footer mb-4">
                    <a href="{{route('users')}}" type="button" class="btn btn-default">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
            <hr>
            <h5>Mudar Senha</h5>
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
            </div>
        </div>
    </div>



@stop

@section('css')

@stop

@section('js')


@stop