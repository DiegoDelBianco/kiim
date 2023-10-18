

        <!-- Modal -->
        <div class="modal fade" id="modal-create-team" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionar Equipe</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <form id="addUserForm" method="POST" action="{{route('teams.store')}}">
                                @csrf
                                <div class="form-group row">
                                    <label for="tenancyTeamForm"  class="col-md-4 col-form-label text-md-right">{{ __('Para: ') }}</label>
                                    <div class="col-md-6">
                                        <select class="form-control" required name="tenancy_id" id="tenancyTeamForm">
                                            <option value="">Selecione</option>
                                            @foreach($tenancies  as $tenancy)
                                                <option value="{{$tenancy->id}}">{{$tenancy->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="submitAddUser" type="submit" form="addUserForm" class="btn btn-success">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
