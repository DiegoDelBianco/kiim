        <div id="horizontal__tab01" class="horizontal__tabcontent" style="position: relative;">
            <h3> #{{$customer->id}} - {{ $customer->name }} </h3>

            <div class="ficha_cliente">
                <p><span>Nome: </span> {{ $customer->name!="" ? $customer->name : "Não informado" }} </p>
                <p><span>Status: </span> {{ $customer->stage->name }} {{-- !$customer->new ? "Retorno" : "Primeiro atendimento" }} ({{ $customer->customerService ? ( $customer->customerService->status == 1 ? "Atendimento Aberto": "Atendimento Finalizado"):"Não atendido" --}}  </p>
                <p><span>Cadastrado: </span> Dia {{ $customer->created_at != "" ? date( 'd/m/Y H:i' , strtotime($customer->created_at)):"Não informado" }} {{ isset($customer->website) ? "em " . $customer->website->name : "" }}</p>
                <p><span>Origem do lead: </span>  {{$customer->source}}</p>
                <p><span>Empreendimento: </span> {{$customer->real_state_project}} </p>
                <p><span>Interessado em: </span> {{$customer->product_type_id?$customer->productType->name:'Não informado'}} <button data-toggle="modal" data-target="#modal-show-product-type" type="button" class="btn btn-info" data-bs-toggle="dropdown" aria-expanded="false" style="padding-left: 6px;padding-right: 6px;margin-left: 10px;"> <i class="fas fa-edit"></i> </button>  </p>
                <p><span>Telefone: </span> <?php echo  $customer->phone != "" ? "(" . $customer->ddd . ") " . $customer->phone.' <a target="_blank" class="cli_whats" href="https://api.whatsapp.com/send?phone='.preg_replace('/[^0-9]/', '',  $customer->ddd.$customer->phone).'"><i class="fab fa-whatsapp"></i></a>' : "Não informado" ; ?> <?php echo $customer->phone_2 != "" ? " Ou (" . $customer->ddd_2 . ") " . $customer->phone_2 .' <a target="_blank" class="cli_whats" href="https://api.whatsapp.com/send?phone='.preg_replace('/[^0-9]/', '',  $customer->ddd_d.$customer->phone_d).'"><i class="fab fa-whatsapp"></i></a>' : "" ; ?> </p>
                @if( $customer->customer_service ? ($customer->customer_service->status == 2) : false) <p><span>Finalizado: </span>  {{ $customer->customer_service->titleReasonFinish() }}  </p> @endif
            </div>
            <style>.cli_whats{     margin-right: 15px;
    margin-left: 5px;
    color: white;
    background: #00a884;
    padding: 3px;
    border-radius: 50%;
    width: 1.7em;
    height: 1.7em;
    display: inline-block;
    text-align: center;}</style>
            <!--div class="section_contact">
                <p class="pb-0 mb-0" style="font-weight: bold;">Contato:</p>
                <button data-toggle="modal" data-target="#zapar" type="button" class="btn btn-success" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fab fa-whatsapp"></i>
                <span>Zapar</span>
                </button>
                <button disabled data-toggle="modal" data-target="#disparoemmassaatendimento" type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-envelope"></i>
                    <span>Enviar E-mail</span>
                </button>

            </div-->

            <!-- @ include('customers.components.modalProdutoShow') -->
            @include('customers.components.modals.show-product-type-modal')
            <h3></h3>

        </div>
