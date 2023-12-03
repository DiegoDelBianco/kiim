<!-- Modal -->
<div class="modal fade" id="modal-delete-goal-{{$goal->id}}" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="deleteGoalFrom-{{$goal->id}}" method="POST" action="{{route('extensions.thermometer.del-goal', $goal)}}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Deletar Meta</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <h3>Você tem certeza que deseja deletar essa meta?</h3>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Deletar</button>
                </div>
            </form>
        </div>
    </div>
</div>
