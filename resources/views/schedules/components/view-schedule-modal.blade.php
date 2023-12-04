<!-- Modal Whatsapp -->
<div class="modal fade" id="modalSchedulingInfo" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align: center; width: 100%;">Tarefa <span class="status"></span></h4>
            </div>
            <div class="modal-body">
                <p><span class="label">Titulo: </span> <span class="scheduling-title"></span> <a class="info-customer-link btn btn-primary" href="#">Ver</a>  </p>
                <p><span class="label">Status:</span> <span class="status status-name"></span></p>
                <p><span class="label">Usuário: </span> <span class="assistent-name"></span></p>
                <p><span class="label">Data: </span> <span class="scheduling-date"></span><span class="time-wrap"> ás <span class="scheduling-hour"></span></span></p>
                <p><span class="label">Nota: </span> <span class="scheduling-note"></span></p>

                <center>
                    <button onclick="$(this).hide(); $('.alt-status').show()" class="btn-alt-status btn btn-default">Alterar status</button>
                    <form method="POST" action='#' class="form-schedules-done">
                        @csrf
                        <button class="alt-status btn btn-success mb-3">Marcar como Feita</button>
                    </form>
                    <form method="POST" action='#' class="form-schedules-cancel">
                        @csrf
                        <button class="alt-status btn btn-danger">Cancelar tarefa</button>
                    </form>
                </center>
            </div>
            <div class="modal-footer">
                <a class="btn btn-default" data-dismiss="modal">Fechar</a>
                <!--a  href="#" class="btn btn-success ver-atendimento loadlayer">Ver atendimento</a-->
            </div>
        </div>

    </div>
</div>
<style>
    #modalSchedulingInfo .label{
        font-weight: bold;
    }
</style>
