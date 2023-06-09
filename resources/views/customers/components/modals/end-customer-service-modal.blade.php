<!-- Modal Whatsapp -->
<div class="modal fade" id="modal-end-customer-service" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form class="text-center pt-3" method="POST" action="{{ route('customers.customer-services.destroy', $customer->customerService) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Finalizar atendimento</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>
                        <p class="d-flex flex-column">
                            <label for="zapnumero"><strong>Motivo</strong></label>
                            <select onchange="changeMotivoFinalizacao()" class="form-control" name="reason_finish" id="motivosFinalizar" required>
                                <option value="">Escolha um motivo</option>
                                @if(isset($list_reason_finish))
                                    @foreach($list_reason_finish as $key => $motivo)
                                        <option value="{{$key}}">{{$motivo}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </p>
                        <p class=" flex-column j_venda" style="display:none !important">
                            <label for="buy_date"><strong>Data da venda</strong></label>
                            <input type='date' class="form-control" name="buy_date" id="buy_date">
                        </p>
                        <p class=" flex-column j_venda" style="display:none !important">
                            <label for="pay_date"><strong>Data primeiro pagamento</strong></label>
                            <input type='date' class="form-control" name="pay_date" id="pay_date">
                        </p>
                        <p class="d-flex flex-column">
                            <label for="zaptexto"><strong>Observação</strong></label>
                            <textarea class="form-control" required name="description"  cols="30" rows="10"></textarea>
                        </p>

                    </p>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">Cancelar</a>
                    <button  type="submit" class="btn btn-success">Finalizar</button>
                </div>
             </form>
        </div>

    </div>
</div>