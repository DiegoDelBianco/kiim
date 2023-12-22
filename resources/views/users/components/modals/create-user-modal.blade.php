

        <!-- Modal -->
        <div class="modal fade" id="modal-create-user" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionar Usuário</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="init-user-form">
                        <!-- show two options, the firt optino is to "add a existing user", the secound is to "crea a new user" -->
                        <p>Você pode vincular um usuário que já tem conta na kiim ao seu negócio, ou pode criar um novo usuário.</p>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <button onclick="$('#init-user-form').hide(); $('#link-user-form').show(); " class="btn btn-primary" id="add-existing-user">Vincular usuário</button>
                            </div>
                            <div class="col-md-6 text-center">
                                <button onclick="$('#init-user-form').hide(); $('#create-user-form').show(); " class="btn btn-primary" id="create-new-user">Criar novo usuário</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" id="link-user-form" style="display:none">
                        <!-- back link -->
                        <a onclick="$('#init-user-form').show(); $('#link-user-form').hide(); " class="btn btn-primary" id="back-link"> <i class="fa fa-arrow-left"></i> Voltar</a>

                        <form id="linkUserForm" method="POST" action="{{route('users.link')}}">
                            @csrf
                            <div class="form-group row">
                                <label for="tenancyLinkUserForm"  class="col-md-4 col-form-label text-md-right">{{ __('Para: ') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control" required name="tenancy_id" id="tenancyLinkUserForm">
                                        <option value="">Selecione</option>
                                        @foreach($tenancies  as $tenancy)
                                            <option value="{{$tenancy->id}}">{{$tenancy->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="emailLInk" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
                                <div class="col-md-6">
                                    <input id="emailLInk" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Vincular</button>
                        </form>

                    </div>
                    <div class="modal-body" id="create-user-form" style="display:none">
                        <!-- back link -->
                        <a onclick="$('#init-user-form').show(); $('#create-user-form').hide(); " class="btn btn-primary" id="back-link"> <i class="fa fa-arrow-left"></i> Voltar</a>
                        <p>
                            <!-- bootstrap alert -->
                            <div class="alert alert-warning"><strong>Atenção!</strong> você pode criar um usuário, para participar da sua conta, mas após a criação você só pode editar as permissões dele sobre a sua empresa, e não os dados dele</div>
                            <form id="addUserForm" method="POST" action="{{route('users.store')}}">
                                @csrf
                                <div class="form-group row">
                                    <label for="tenancyAddUserForm"  class="col-md-4 col-form-label text-md-right">{{ __('Para: ') }}</label>
                                    <div class="col-md-6">
                                        <select class="form-control" required name="tenancy_id" id="tenancyAddUserForm">
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
                                <div class="form-group row">
                                    <label for="creci" class="col-md-4 col-form-label text-md-right">{{ __('Creci') }}</label>
                                    <div class="col-md-6">
                                        <input id="creci" required type="text" class="form-control @error('creci') is-invalid @enderror mask-creci" name="creci" value="{{ old('creci') }}" required autocomplete="creci" autofocus>
                                        @error('creci')
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
                                <input type="hidden" name="team_id" value="">
                                {{--@if(Auth::user()->hasRole('Master'))
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
                                @endif --}}
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
                        <button id="submitAddUser" type="submit" form="addUserForm" class="btn btn-success">Salvar</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
