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
            <h3>Importar</h3>
            <form action="{{route('customers.importCsv.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- input group to selecte tenancy -->
                <div class="input-group mb-3 col-md-6 pb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Empresa: </label>
                    </div>
                    <select class="custom-select" name="tenancy_id" id="inputGroupSelect01" required>
                        <option value="">Escolha...</option>
                        @foreach($tenancies as $tenancy)
                            <option value="{{$tenancy->id}}">{{$tenancy->name}}</option>
                        @endforeach
                    </select>
                    <!-- laravel virification error -->
                    @error('tenancy_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <!-- input group to file csv -->
                <div class="input-group mb-3 col-md-6 pb-3">
                    <div class="custom-file">
                        <input type="file" name="csv_file" class="custom-file-input" id="inputGroupFile02" required>
                        <label class="custom-file-label" for="inputGroupFile02">Escolha o arquivo</label>
                    </div>
                    <!-- laravel virification error -->
                </div>
                @error('csv_file')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
                <!-- submit button -->
                <div class="input-group mb-3 col-md-6 pb-3">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
                <script>
                    // Add the following code if you want the name of the file appear on select, in vanilla javascript
                    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
                        var fileName = document.getElementById("inputGroupFile02").files[0].name;
                        var nextSibling = e.target.nextElementSibling
                        nextSibling.innerText = fileName
                    })
                </script>
            </form>
            @foreach($tenancies as $tenancy)
                <h2 class="mt-5">Importações para: {{$tenancy->name}}</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <td>Arquivo</td>
                            <td>Leads</td>
                            <td>Status</td>
                            <td></td>
                        </tr>
                    </thead>
                @foreach($import_list[$tenancy->id] as $csv)
                    <tbody>
                        <tr>
                            <td>{{$csv->file}}</td>
                            <td>{{count($csv->customers)}}</td>
                            <td>{{$csv->status}}</td>
                            <td>@if($csv->status == "Processando" ) <a href="{{route('customers.importCsv.selectHead', $csv)}}" class="btn btn-primary">Finalizar</a>  @endif</td>
                        </tr>
                    </tbody>
                @endforeach
                </table>
                @if(count($import_list[$tenancy->id]) == 0)
                <!-- bootstrap alert -->
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Ops!</strong> Você ainda não importou nenhum arquivo.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
                @endif
            @endforeach

    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')



@stop
