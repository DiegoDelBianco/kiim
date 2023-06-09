@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Equipes</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Equipes</li>
                </ol>
            </nav>

            <div class="pt-2 pe-2">
                <button data-toggle="modal" data-target="#modal-create-team" type="button" class="btn btn-primary" >
                    <i class="fas fa-plus"></i> 
                    <span>Nova equipe</span>
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
        @include('teams.components.modals.create-team-modal')

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Usuários</th>
                            <th scope="col">Leads</th>
                            <th scope="col" style="width: 190px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                            <tr>
                                <td>{{ $team->name }}</td>
                                <td>{{ count($team->users) }}</td>
                                <td>{{ count($team->customers) }}</td>
                                <td>
                                    <button data-toggle="modal" data-target="#modal-edit-team-{{$team->id}}" class="btn btn-primary">Editar</button>
                                    <button href="#" class="btn btn-danger">Excluir</button>
                                    @include('teams.components.modals.edit-team-modal')
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop