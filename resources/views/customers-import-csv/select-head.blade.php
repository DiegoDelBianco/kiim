@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Leads</h1>
@stop

@section('content')





    <div class="bg-white main-canvas">

        <!-- Bread Crumbs e Botão +Add Cliente -->
        <div class="d-flex flex-row justify-content-between shadow">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Leads </li>
                </ol>
            </nav>
        </div>
        <!-- Fim Bread Crumbs e Botão +Add Cliente -->



        <!-- MENSAGEM DE SUCESSO AO ADICIONAR LEAD  -->
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

        <div class="p-3 pt-4">
            <h1>Importar</h1>
            <p>Arquivo: {{$import->file}}</p>
            <h2>Selecione o que cada coluna do seu arquivo CSV representa</h2>
            <p>Vamos entender seu arquivo</p>
            <form action="{{route('customers.importCsv.finalize', $import->id)}}" method="POST">
                @csrf
                @php $count = 0; @endphp
                @foreach($head as $field)
                    <!-- input group to select a column from customers reference field  -->
                    <div class="input-group mb-3 col-md-8 pb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Coluna {{$count+1}} - {{$field}}: </label>
                        </div>
                        <select name="opt-{{$count}}" class="custom-select" id="inputGroupSelect01">
                            <option selected value="">Ignorar</option>
                            @foreach($fields_to_save as $name => $field)
                                <option value="{{$name}}">{{$field['title']}}</option>
                            @endforeach
                        </select>
                        @php $count++; @endphp
                    </div>

                @endforeach
                <button type="submit" class="btn btn-primary mb-5">Finalizar</button>
            </form>
        </div>

    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')



@stop
