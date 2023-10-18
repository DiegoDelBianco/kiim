<div class="modal fade" id="deleteTeam{{ $team->id }}">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal">&times;</a>
                <h4 class="modal-title">Remover Equipe</h4>
            </div>
            <div class="modal-body">
                <p>
                    <h4>Tem certeza que deseja remover esta equipe?</h4>
                    <span>{{ $team->name }}?</span>
                    <hr>
                    <form id="delete{{ $team->id }}" action="{{ route('teams.destroy', [$team]) }}" class="float-left" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </p>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                <input type="submit" form="delete{{ $team->id }}" class="btn btn-warning" value="Excluir">
            </div>
        </div>
    </div>
</div>
