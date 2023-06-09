@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Nova Leadpage</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('websites')}}">Leadpages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nova leadpage</li>
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
                
                <form id="addUserForm" method="POST" action="{{route('websites.store', $product)}}">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Imóvel') }}</label>
                        <div class="col-md-6">
                            <p>{{ $product->title }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="template" class="col-md-4 col-form-label text-md-right">{{ __('Template') }}</label>
                        <div class="col-md-6">
                            <select id="template" type="text" class="form-control @error('template') is-invalid @enderror" name="template" value="{{ old('template') }}" required autocomplete="template" autofocus>
                                @foreach($templates as $template)
                                    <option value="{{$template->slug}}">{{$template->name}}</option>
                                @endforeach
                            </select>
                            @error('template')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-6">
                            <a href="{{route('products')}}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button class="btn btn-primary" type="submit">Criar</button>
                        </div>
                    </div>
                </form>
            </div>
    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
@stop