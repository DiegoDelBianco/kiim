<!-- MODAL ADICIONAR REGISTRO -->
<div class="modal fade" id="modal-create-customer-timeline" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Registro</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>
                    <form id="addEvent" action="{{route('customers.timelines.store', $customer)}}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Nome</label>
                            <select class="form-control" name="type" id="categoria_id" required>
                                <option value="" selected disabled>Selecionar Categoria</option>
                                <option value="1">Telefonema</option>
                                <option value="2">Whatsapp</option>
                                <option value="3">E-mail</option>
                                <option value="4">SMS</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="event" class="form-label">Evento</label>
                            <textarea class="form-control" name="event" id="event" cols="30" rows="10"></textarea>
                        </div>
                    </form>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="addEvent" class="btn btn-primary">Registrar</button>
            </div>
        </div>

    </div>
</div>
<!-- FIM MODAL ADICIONAR REGISTRO -->