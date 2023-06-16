<div class="modal fade" id="modal-list-sys-products" role="dialog">
    <div class="modal-dialog  modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Produtos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 text-center">


                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <h4 class="float-none mb-1">{{$product->name}}</h4>
									<h6 class="card-subtitle mb-2 text-muted">Contrate agora.</h6>
                                	<p class="card-text">{{$product->description}}</p>
									
                                    <p class="mb-0"><b>O que adiciona:</b></p>
                                    <p>
                                    @if($product->add_customers)+ {{$product->add_customers}} Leads @endif <br>
                                    @if($product->add_users)+ {{$product->add_users}} Usuários @endif <br>
                                    @if($product->add_websites)+ {{$product->add_websites}} Leadpages @endif
                                    </p>

                                    <p class="mb-0"><b>Valores:</b></p>
                                    <p>Mensal: R$ {{$product->monthly_price}}<br>
                                    <span style="color: green">Trimestral: R$ {{$product->quarterly_price}} <b>(Recomendado)</b></span><br>
                                    Semestral: R$ {{$product->semiannually_price}}<br>
                                    Anual: R$ {{$product->yearly_price}}</p>

                                    <a href="{{ route('sysProduct', $product) }}" class="card-link btn btn-primary">Contratar</a>
                                    <!--a href="#" class="card-link">Another link</a-->
                                </div>
                            </div>
                            
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <!--button type="submit" form="addClienteForm" class="btn btn-success">Salvar</button-->
            </div>
        </div>

    </div>
</div>