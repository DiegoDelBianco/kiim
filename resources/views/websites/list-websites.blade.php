@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Leadpages</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Leadpages</li>
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
                

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Template</th>
                            <th scope="col">Imóvel</th>
                            <th scope="col" style="width: 190px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($websites as $website)
                            <tr>
                                <td>{{ $website->name }}</td>
                                <td></td>
                                <td>{{ $website->product->title }}</td>
                                <td>
                                    <a href="{{route('websites.edit', $website)}}" class="btn btn-primary">Configurar</a>
                                    <button href="#" class="btn btn-danger">Excluir</button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(count($websites) == 0)
                <p>Você ainda não tem nenhuma leadpage, crie uma leadpage na listagem de imóveis</p>
            @endif

            </div>
    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop