

        <!-- Modal -->
        <div class="modal fade" id="modal-create-user" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionar Usuário</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <form id="addUserForm" method="POST" action="{{route('users.store')}}">
                                @csrf
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
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @if(Auth::user()->hasRole('Master'))
                                    <div class="form-group row">
                                        <label for="equipeAddUserForm" class="col-md-4 col-form-label text-md-right">{{ __('Equipe') }}</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="team_id" id="equipeAddUserForm">
                                                <option value="">Sem Equipe</option>
                                                @foreach($teams  as $team)
                                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @elseif(Auth::user()->hasRole('Gerente'))
                                    <input type="hidden" name="team_id" value="{{ Auth::user()->team_id }}">
                                @endif
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" onchange='check_pass();'>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Senha') }}</label>
                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" onchange='check_pass();'>
                                        <span id='message'></span>
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