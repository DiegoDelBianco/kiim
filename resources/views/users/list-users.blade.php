@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Usuários</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Usuários</li>
                </ol>
            </nav>

            <div class="pt-2 pe-2">
                <button data-toggle="modal" data-target="#modal-create-user" type="button" class="btn btn-primary" >
                    <i class="fas fa-user-plus"></i>
                    <span>Novo Usuário</span>
                </button>
            </div>

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
        @include('users.components.modals.create-user-modal')
            <div class="card-body">
                @foreach($tenancies as $tenancy)
                <h2>Usuários para {{$tenancy->name}}</h2>
                <table class="table mb-4">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Equipe</th>
                            <th scope="col">Privilégios</th>
                            <th scope="col" style="width: 190px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users_by_tenancy[$tenancy->id] as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <th scope="row">{{ $user->teamName($tenancy->id)  }}</th>
                                <td>{{ $user->getRoleName($tenancy->id) }} {{-- implode(', ', $user->roles()->get()->pluck('name')->toArray()) --}}</td>
                                <td>
                                    <a href="{{ route('users.edit', [$tenancy, $user])}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('metrics').'?assistent='.$user->id }}" class="btn btn-success"><i class="fas fa-chart-line"></i></a>
                                    <a data-toggle="modal" data-target="#deleteUser{{ $user->id }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    <div class="modal fade" id="deleteUser{{ $user->id }}">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <a type="button" class="close" data-dismiss="modal">&times;</a>
                                                    <h4 class="modal-title">Remover usuário</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        <h4>Tem certeza que deseja desvincular este usuário?</h4>
                                                        <span>{{ $user->name }}?</span>
                                                        <hr>
                                                        <form id="delete{{ $user->id }}" action="{{ route('users.unlink', [$tenancy, $user]) }}" class="float-left" method="POST">
                                                            @csrf
                                                        </form>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                                                    <input type="submit" form="delete{{ $user->id }}" class="btn btn-warning" value="Desvincular">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- alert if no users --}}
                @if(count($users_by_tenancy[$tenancy->id]) == 0)
                    <div class="alert alert-warning alert-dismissible fade show mb-5" role="alert">
                        <strong>Nenhum usuário cadastrado!</strong> Clique no botão <strong>+ Novo Usuário</strong> para adicionar um novo usuário.
                    </div>
                @endif

                @endforeach
            </div>
    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop
