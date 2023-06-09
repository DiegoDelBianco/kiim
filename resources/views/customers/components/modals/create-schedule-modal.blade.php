<!-- Modal Whatsapp -->
<div class="modal fade" id="tarefaModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form class="text-center pt-3" method="POST" action="{{ route('schedules.store', $customer->customerService) }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Agendar Tarefa</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>
                        <p class="d-flex flex-column" style="width: 45%; display: inline-block !important;">
                            <label for="inputdate"><strong>Dia:</strong></label>
                            <input type="date" name="date" min='{{date( "Y-m-d")}}' id="inputdate" class="form-control" >
                        </p>
                        <p class="d-flex flex-column" style="width: 45%; display: inline-block !important;">
                            <label for="inputhour"><strong>Hora:</strong></label>
                            <input type="time" name="time" id="inputhour" class="form-control" >
                        </p>
                        <p class="d-flex flex-column">
                            <label for="zaptexto"><strong>Descrição</strong></label>
                            <textarea class="form-control" id="create-schedule-description" required name="description" maxlength="255" cols="30" rows="6"></textarea>
                        </p>

                    </p>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">Cancelar</a>
                    <button  type="submit" class="btn btn-success">Salvar</button>
                </div>
             </form>
        </div>

    </div>
</div>