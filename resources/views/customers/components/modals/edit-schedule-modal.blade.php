<!-- Modal Whatsapp -->
<div class="modal fade" id="modal-edit-schedule-{{$tarefa->id}}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
                @method("PATCH")
                <div class="modal-header">
                    <h4 class="modal-title">Editar Tarefa</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!--div class="modal-body">
                    <p class="d-flex flex-column">
                        <label for="inputdate"><strong>Status</strong></label>
                        <select name="status" id="inputdate" class="form-control" >
                            <option value="1">Aguardando</option>
                            <option value="2">Feito</option>
                            <option value="3">Cancelado</option>
                        </select>
                    </p>
                </div-->
                <div class="p-3">
                    <center>
                        <form method="POST" action='{{route("schedules.update.done", $tarefa->id)}}' class="form-schedules-done">
                            @csrf
                            <button class="alt-status btn btn-success mb-3">Marcar como Feita</button>
                        </form>
                        <form method="POST" action='{{route("schedules.update.cancel", $tarefa->id)}}' class="form-schedules-cancel">
                            @csrf
                            <button class="alt-status btn btn-danger">Cancelar tarefa</button>
                        </form>
                    </center>
                </div>

                <div class="modal-footer">
                    <a class="btn btn-default" data-dismiss="modal">Cancelar</a>
                    <!--button  type="submit" class="btn btn-success">Salvar</button-->
                </div>
        </div>

    </div>
</div>
