<div class="modal fade" id="modal-show-product-type" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar tipo de produto</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>
                    <form id="editProductType" action="{{route('customers.update.product-type', $customer)}}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="product_type_id"  class="col-md-4 col-form-label text-md-right">{{ __('Interessado em: ') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" required name="product_type_id" id="product_type_id">
                                    <option value="">Selecione</option>
                                    @foreach(\App\Models\ProductType::all()  as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="editProductType" class="btn btn-success">Salvar</button>
            </div>
        </div>

    </div>
</div>
