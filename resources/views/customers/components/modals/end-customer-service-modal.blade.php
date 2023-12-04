<!-- Modal Whatsapp -->
<div class="modal fade" id="modal-end-customer-service" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form class="text-center pt-3" method="POST" action="{{ route('customers.customer-services.destroy', $customer->customerService) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Atualizar atendimento</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>
                        <p class="d-flex flex-column">
                            <label for="zapnumero"><strong>Motivo</strong></label>
                            <select onchange="changeMotivoFinalizacao()" class="form-control" name="reason_finish" id="motivosFinalizar" required>
                                <option value="">Escolha um motivo</option>
                                @if(isset($list_reason_finish))
                                    @foreach($list_reason_finish as $motivo)
                                        <option value="{{$motivo->id}}">{{$motivo->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </p>
                        <p class="flex-column confim_buy_date" style="display:none !important">
                            <label for="buy_date"><strong>Data da venda</strong></label>
                            <input type='date' class="form-control" name="buy_date" id="buy_date">
                        </p>
                        <p class="flex-column confim_signature_date" style="display:none !important">
                            <label for="buy_date"><strong>Data da assinatura</strong></label>
                            <input type='date' class="form-control" name="signature_date" id="buy_date">
                        </p>
                        <p class="flex-column confim_delivery_keys_date" style="display:none !important">
                            <label for="buy_date"><strong>Data de entrega das chaves</strong></label>
                            <input type='date' class="form-control" name="delivery_keys_date" id="buy_date">
                        </p>
                        <p class="flex-column confim_next_contact_date" style="display:none !important">
                            <label for="buy_date"><strong>Data do proximo contato</strong></label>
                            <input type='date' class="form-control" name="next_contact_date" id="buy_date">
                        </p>
                        <p class="flex-column confim_paid_date" style="display:none !important">
                            <label for="buy_date"><strong>Data do pagamento</strong></label>
                            <input type='date' class="form-control" name="paid_date" id="buy_date">
                        </p>


                        <p class="d-flex flex-column">
                            <label for="zaptexto"><strong>Observação</strong></label>
                            <textarea class="form-control" required name="description"  cols="30" rows="10"></textarea>
                        </p>

                    </p>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">Cancelar</a>
                    <button  type="submit" class="btn btn-success">Atualizar</button>
                </div>
             </form>
        </div>

    </div>
</div>


<script>
    function changeMotivoFinalizacao(){
        let motivo = $("#motivosFinalizar").val();
        $('.confim_buy_date').hide();
        $('.confim_signature_date').hide();
        $('.confim_delivery_keys_date').hide();
        $('.confim_next_contact_date').hide();
        $('.confim_paid_date').hide();
        @php
        foreach($list_reason_finish as $reason){
            if($reason->confim_buy_date)
                echo 'if(motivo == '.$reason->id.') $(".confim_buy_date").show(); ';

            if($reason->confim_signature_date)
                echo 'if(motivo == '.$reason->id.') $(".confim_signature_date").show(); ';

            if($reason->confim_delivery_keys_date)
                echo 'if(motivo == '.$reason->id.') $(".confim_delivery_keys_date").show(); ';

            if($reason->confim_next_contact_date)
                echo 'if(motivo == '.$reason->id.') $(".confim_next_contact_date").show(); ';

            if($reason->confim_paid_date)
                echo 'if(motivo == '.$reason->id.') $(".confim_paid_date").show(); ';
        }
        @endphp

    }
</script>
