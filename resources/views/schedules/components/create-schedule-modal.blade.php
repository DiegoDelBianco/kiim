

        <!-- Modal -->
        <div class="modal fade" id="modal-create-schedule" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Nova tarefa</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <form id="addUserForm" method="POST" action="{{route('schedules.store')}}">
                                @csrf

                                <div class="form-group row">
                                    <label for="tenancyTeamForm"  class="col-md-4 col-form-label text-md-right">{{ __('Empresa: ') }}</label>
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
                                    <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Data') }}</label>
                                    <div class="col-md-6">
                                        <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" autofocus>
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="time" class="col-md-4 col-form-label text-md-right">{{ __('Horario') }}</label>
                                    <div class="col-md-6">
                                        <input id="time" type="time" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ old('time') }}" required autocomplete="time" autofocus>
                                        @error('time')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Descrição') }}</label>
                                    <div class="col-md-6">
                                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus></textarea>
                                        @error('description')
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
