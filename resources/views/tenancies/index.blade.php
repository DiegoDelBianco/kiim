@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Configurações</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Configurações</li>
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

                <h2>Seus pacotes</h2>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-list-sys-products" >Contratar produto</button>
                @include('tenancies.components.modals.list-sys-products')
                @if(count($current_products) == 0)
                    <div class="alert alert-warning mt-3 mb-5" role="alert">
                        Você ainda não tem produtos contratados
                    </div>
                @endif
                <div class="row mt-2 mb-4">
                    @foreach($current_products as $product)
                        <div class="col-md-4 text-center">


                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <h4 class="float-none mb-1">{{$product->sysProduct->name}}</h4>
									<h6 class="card-subtitle mb-2 text-muted">Contrate agora.</h6>
                                	<p class="card-text">{{$product->sysProduct->description}}</p>
									
                                    <p class="mb-0"><b>O que adiciona:</b></p>
                                    <p>
                                    @if($product->sysProduct->add_customers)+ {{$product->sysProduct->add_customers}} Leads @endif <br>
                                    @if($product->sysProduct->add_users)+ {{$product->sysProduct->add_users}} Usuários @endif <br>
                                    @if($product->sysProduct->add_websites)+ {{$product->sysProduct->add_websites}} Leadpages @endif
                                    </p>
                                    @if($product->cycle == 'monthly')
                                        <p class="mb-0"><b>Valor:</b></p>
                                        <p>R$ {{$product->sysProduct->monthly_price}} / mês</p>
                                    @elseif($product->cycle == 'yearly')
                                        <p class="mb-0"><b>Valor:</b></p>
                                        <p>R$ {{$product->sysProduct->yearly_price}} / ano</p>
                                    @elseif($product->cycle == 'quarterly')
                                        <p class="mb-0"><b>Valor:</b></p>
                                        <p>R$ {{$product->sysProduct->quarterly_price}} / trimestre</p>
                                    @elseif($product->cycle == 'semiannually')
                                        <p class="mb-0"><b>Valor:</b></p>
                                        <p>R$ {{$product->sysProduct->semiannually_price}} / semestre</p>
                                    @endif
                                    @if($product->status == 'await_payment')
                                        <p>Você ainda não finalizou sua contratação, pague para ativar seu serviço:</p>
                                        <a href="{{ route('sysProduct', $product->sysProduct) }}" class="card-link btn btn-success">Finalizar</a>
                                    @else
                                        <p>Para saber mais sobre seu pacote ou cancelar, entre em contato com nosso suporte via <a href="https://api.whatsapp.com/send?phone=5511956695325">WhatsApp</a></p>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    @endforeach
                </div>
                
                <h2>Suas configurações</h2>

                <form id="addUserForm" method="POST" action="{{route('tenancies.update')}}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group row">
                        <label for="input-name" class="col-md-4 col-form-label text-md-right">{{ __('Nome empresarial') }}</label>
                        <div class="col-md-6">
                            <input id="input-name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $tenancy->name }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Usuários no seu pacote:</label>
                        <div class="col-md-6 p-2">
                            Até {{ $tenancy->max_users == '9999' ? "Ilimitado" : $tenancy->max_users}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Leadpages no seu pacote:</label>
                        <div class="col-md-6 p-2">
                            Até {{ $tenancy->max_websites == '9999' ? "Ilimitado" : $tenancy->max_websites}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Leads no seu pacote:</label>
                        <div class="col-md-6 p-2">
                            Até {{ $tenancy->max_customers == '9999' ? "Ilimitado" : $tenancy->max_customers}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-doc" class="col-md-4 col-form-label text-md-right">{{ __('CPF/CNPJ') }}</label>
                        <div class="col-md-6">
                            <input id="input-doc" type="text" class="form-control @error('doc') is-invalid @enderror" name="doc" value="{{ $tenancy->doc }}" required autocomplete="doc" autofocus>
                            @error('doc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-email" class="col-md-4 col-form-label text-md-right">{{ __('E-mail') }}</label>
                        <div class="col-md-6">
                            <input id="input-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $tenancy->email }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $email }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-phone" class="col-md-4 col-form-label text-md-right">{{ __('Telefone') }}</label>
                        <div class="col-md-6">
                            <input id="input-phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $tenancy->phone }}" required autocomplete="phone" autofocus>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-cep" class="col-md-4 col-form-label text-md-right">{{ __('CEP') }}</label>
                        <div class="col-md-6">
                            <input id="input-cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" value="{{ $tenancy->cep }}" required autocomplete="cep" autofocus>
                            @error('cep')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-address" class="col-md-4 col-form-label text-md-right">{{ __('Endereço') }}</label>
                        <div class="col-md-6">
                            <input id="input-address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $tenancy->address }}" required autocomplete="address" autofocus>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input-address_number" class="col-md-4 col-form-label text-md-right">{{ __('Número') }}</label>
                        <div class="col-md-6">
                            <input id="input-address_number" type="text" class="form-control @error('address_number') is-invalid @enderror" name="address_number" value="{{ $tenancy->address_number }}" required autocomplete="address_number" autofocus>
                            @error('address_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input-complement" class="col-md-4 col-form-label text-md-right">{{ __('Complemento') }}</label>
                        <div class="col-md-6">
                            <input id="input-complement" type="text" class="form-control @error('complement') is-invalid @enderror" name="complement" value="{{ $tenancy->complement }}" autocomplete="complement" autofocus>
                            @error('complement')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="input-province" class="col-md-4 col-form-label text-md-right">{{ __('Bairro') }}</label>
                        <div class="col-md-6">
                            <input id="input-province" type="text" class="form-control @error('province') is-invalid @enderror" name="province" value="{{ $tenancy->province }}" required autocomplete="province" autofocus>
                            @error('province')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input-city" class="col-md-4 col-form-label text-md-right">{{ __('Cidade') }}</label>
                        <div class="col-md-6">
                            <input id="input-city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $tenancy->city }}" required autocomplete="city" autofocus>
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="input-uf" class="col-md-4 col-form-label text-md-right">{{ __('UF') }}</label>
                        <div class="col-md-6">
                            <input id="input-uf" type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" value="{{ $tenancy->uf }}" required autocomplete="uf" autofocus>
                            @error('uf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

    


                
                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-6">
                            <button class="btn btn-primary" type="submit">Salvar</button>
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
    <!-- call mask plugin jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- script to mask cep input -->
    <script>
        $(document).ready(function(){
            $('#input-cep').mask('00000-000');
        });

        // script to mask doc input, cpf or cnpj in same input
        $(document).ready(function(){
            var $doc = $("#input-doc");
            $doc.mask('000.000.000-00', {reverse: true});
            var options = {
                onKeyPress: function(doc, e, field, options) {
                    var masks = ['000.000.000-000', '00.000.000/0000-00'];
                    var mask = (doc.length>14) ? masks[1] : masks[0];
                    $doc.mask(mask, options);
                }
            };
            $doc.length > 11 ? $doc.mask('00.000.000/0000-00', options) : $doc.mask('000.000.000-00#', options);
        });

        // mask phone
        $(document).ready(function(){
            $('#input-phone').mask('(00) 0 0000-0000');
        });


        // autocomplete address with cep using viacep api
        $(document).ready(function(){
            $('#input-cep').blur(function(){
                var cep = $(this).val().replace(/[^0-9]/, '');
                if(cep){
                    var url = 'https://viacep.com.br/ws/'+cep+'/json/';
                    $.ajax({
                        url: url,
                        dataType: 'jsonp',
                        crossDomain: true,
                        contentType: "application/json",
                        success : function(json){
                            if(json.logradouro){
                                $('#input-address').val(json.logradouro);
                                $('#input-province').val(json.bairro);
                                $('#input-city').val(json.localidade);
                                $('#input-uf').val(json.uf);
                                $('#input-address_number').focus();
                            }
                        }
                    });
                }
            });
        });
    </script>

@stop