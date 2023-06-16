@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Contratar produto</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('tenancies')}}">Configurações</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contratar produto</li>
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
                <!-- show a service with bootstrap -->
                <div class="row">
                    <h2> {{$sysProduct->name}} </h2>
                </div>
                
                <p class="mb-0"><b>O que adiciona:</b></p>
                <p>
                @if($sysProduct->add_customers)+ {{$sysProduct->add_customers}} Leads @endif <br>
                @if($sysProduct->add_users)+ {{$sysProduct->add_users}} Usuários @endif <br>
                @if($sysProduct->add_websites)+ {{$sysProduct->add_websites}} Leadpages @endif
                </p>
                @if(!$contract)
                <form action="{{ route('sysProductTenancy.store', $sysProduct) }}" method="POST"> 
                    @csrf
                    <p class="mb-0"><b>Ciclo:</b></p>
                    <div class="col-md-6">
                        <select class="form-control mt-1" name="cycle" id="cycle">
                            @if($sysProduct->monthly_price)<option value="monthly">Mensal R$ {{$sysProduct->monthly_price}} </option> @endif
                            @if($sysProduct->quarterly_price)<option value="quarterly" selected style="color: green">Trimestral R$ {{$sysProduct->quarterly_price}} </option> @endif
                            @if($sysProduct->semiannually_price)<option value="semiannually">Semestral R$ {{$sysProduct->semiannually_price}} </option> @endif
                            @if($sysProduct->yearly_price)<option value="yearly">Anual R$ {{$sysProduct->yearly_price}} </option> @endif
                        </select>
                    </div>
                    
                    <div class="form-group row mt-3 mb-5">
                        <div class="col-md-6">
                            <a href="{{route('tenancies')}}" class="btn btn-secondary mr-2">Cancelar</a>
                            <button class="btn btn-success" type="submit">Contratar</button>
                        </div>
                    </div>

                </form>
                @else
                    <p>Este produto já foi contratado.</p>
                    @if($contract->status == 'await_payment')
                        <h2>Faça o pagamento para ter acesso</h2>
                        <form action="{{route('payment.store',$contract)}}" method="post">
                            @csrf

                        <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Ciclo de pagamento') }}</label>
                                <div class="col-md-6">
                                        <p class="mt-1">
                                        @if($contract->cycle == "monthly") Mensal R$ {{$sysProduct->monthly_price}}@endif
                                        @if($contract->cycle == "quarterly")Trimestral R$ {{$sysProduct->quarterly_price}}@endif
                                        @if($contract->cycle == "semiannually") Semestral R$ {{$sysProduct->semiannually_price}}@endif
                                        @if($contract->cycle == "yearly") Anual R$ {{$sysProduct->yearly_price}}@endif
                                        </p>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <h4 class="text-center">Dados do cartão</h4>
                            <div class="form-group row">
                                <label for="input-credit-card" class="col-md-4 col-form-label text-md-right">{{ __('Número do cartão de crédito') }}</label>
                                <div class="col-md-6">
                                    <input id="input-credit-card" type="text" class="form-control @error('credit_card') is-invalid @enderror" name="credit_card" value="{{ old('credit_card') }}" required autocomplete="credit_card" autofocus>
                                    @error('credit_card')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-credit-card-name" class="col-md-4 col-form-label text-md-right">{{ __('Nome no cartão de crédito') }}</label>
                                <div class="col-md-6">
                                    <input id="input-credit-card-name" type="text" class="form-control @error('credit_card_name') is-invalid @enderror" name="credit_card_name" value="{{ old('credit_card_name') }}" required autocomplete="credit_car_name" autofocus>
                                    @error('credit_card_expiry_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-credit-card-expiry-m" class="col-md-4 col-form-label text-md-right">{{ __('Mês de expiração') }}</label>
                                <div class="col-md-6">
                                    <select id="input-credit-card-expiry-m" type="text" class="form-control @error('credit_card_expiry_m') is-invalid @enderror" name="credit_card_expiry_m" required autocomplete="credit_card_expiry_m" autofocus>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                    @error('credit_card_expiry_m')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-credit-card-expiry-y" class="col-md-4 col-form-label text-md-right">{{ __('Ano de expiração') }}</label>
                                <div class="col-md-6">
                                    <select id="input-credit-card-expiry-y" type="text" class="form-control @error('credit_card_expiry_y') is-invalid @enderror" name="credit_card_expiry_y" required autocomplete="credit_card_expiry_y" autofocus>
                                        @for ($i = 2023; $i <= 2040; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                    @error('credit_card_expiry_y')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input-credit-card-ccv" class="col-md-4 col-form-label text-md-right">{{ __('CCV') }}</label>
                                <div class="col-md-6">
                                    <input id="input-credit-card-ccv" type="number" class="form-control @error('credit_card_ccv') is-invalid @enderror" name="credit_card_ccv" value="{{ old('credit_card_ccv') }}" required autocomplete="credit_car_ccv" autofocus>
                                    @error('credit_card_expiry_ccv')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <p><b>Atenção:</b> O pagamento é processado pelo sistema Assas, a kiim não armazena suas informações de cartão. Sua assinatura será gerenciar pelo Assas.</p>
                    
                            <h4 class="text-center">Dados do titular do cartão</h4>

                            <!-- create inputs to card holder data: name, email, cpfCnpj, cep, addressNumber, addressComplement and phone -->
                            <div class="form-group">
                                <label for="input-card-holder-name">Nome completo</label>
                                <input type="text" class="form-control" id="input-card-holder-name" name="card_holder_name" placeholder="Nome completo" required>
                            </div>
                            <div class="form-group">
                                <label for="input-card-holder-email">E-mail</label>
                                <input type="email" class="form-control" id="input-card-holder-email" name="card_holder_email" placeholder="E-mail" required>
                            </div>
                            <div class="form-group">
                                <label for="input-card-holder-cpf-cnpj">CPF/CNPJ</label>
                                <input type="text" class="form-control" id="input-card-holder-cpf-cnpj" name="card_holder_cpf_cnpj" placeholder="CPF/CNPJ" required>
                            </div>
                            <div class="form-group">
                                <label for="input-card-holder-cep">CEP</label>
                                <input type="text" class="form-control" id="input-card-holder-cep" name="card_holder_cep" placeholder="CEP" required>
                            </div>
                            <div class="form-group">
                                <label for="input-card-holder-address-number">Número</label>
                                <input type="text" class="form-control" id="input-card-holder-address-number" name="card_holder_address_number" placeholder="Número" required>
                            </div>
                            <div class="form-group">
                                <label for="input-card-holder-address-complement">Complemento</label>
                                <input type="text" class="form-control" id="input-card-holder-address-complement" name="card_holder_address_complement" placeholder="Complemento">
                            </div>
                            <div class="form-group">
                                <label for="input-card-holder-phone">Telefone</label>
                                <input type="text" class="form-control" id="input-card-holder-phone" name="card_holder_phone" placeholder="Telefone" required>
                            </div>

                            <div class="form-group row mt-3 mb-5">
                                <div class="col-md-6">
                                    <a href="{{route('tenancies')}}" class="btn btn-secondary mr-2">Cancelar</a>
                                    <button class="btn btn-success" type="submit">Pagar</button>
                                </div>
                            </div>
                        </form>
                    @endif
                @endif
                


            </div>
    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')

    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>

    <!-- call jquery mask plugin -->    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#input-credit-card').mask('0000 0000 0000 0000');
        });
        
        // mask cpf_cnpj input, cpf or cnpj in same input

        // script to mask doc input, cpf or cnpj in same input
        $(document).ready(function(){
            var $doc = $("#input-card-holder-cpf-cnpj");
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

        // mask to cep input
        $(document).ready(function(){
            $('#input-card-holder-cep').mask('00000-000');
        });

        // mas to phone input
        $(document).ready(function(){
            $('#input-card-holder-phone').mask('(00) 00000-0000');
        });


    </script>
@stop