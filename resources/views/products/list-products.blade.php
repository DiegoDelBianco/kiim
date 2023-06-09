@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Imóveis</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Imóveis</li>
                </ol>
            </nav>

            <div class="pt-2 pe-2">
                <a href="{{route('products.create')}}" class="btn btn-primary" >
                    <i class="fas fa-plus"></i> 
                    <span>Novo Imóvel</span>
                </a>
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

            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Endereço</th>
                            <th scope="col" style="width: 190px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td> </td>
                                <td>{{ $product->title }}</td>
                                <th>{{ $product->address  }}</th>
                                <td style="width:210px">
                                    <button data-toggle="modal" data-target="#modal-list-leadpages-{{ $product->id }}" class="btn btn-success">Leadpages</button>
                                    @include('products.components.modals.list-leadpages-modal')
                                    <a href="{{ route('products.edit', $product)}}" class="btn btn-primary"><i class="fas fa-pen"></i></a>
                                    <button data-toggle="modal" data-target="#modal-delete-product-{{ $product->id }}" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    @include('products.components.modals.delete-product-modal')
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