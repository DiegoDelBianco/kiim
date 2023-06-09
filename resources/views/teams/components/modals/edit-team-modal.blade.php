

        <!-- Modal -->
        <div class="modal fade" id="modal-edit-team-{{$team->id}}" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <form  method="POST" action="{{route('teams.update', $team)}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Equipe</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>
                                @csrf
                                @method('PATCH')
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$team->name}}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="submitAddUser" type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>