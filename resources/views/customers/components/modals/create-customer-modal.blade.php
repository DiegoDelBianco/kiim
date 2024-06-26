<div class="modal fade" id="modal-create-customer" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Lead</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>
                    <form id="addClienteForm" action="{{route('customers.store')}}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="tenancyTeamForm"  class="col-md-4 col-form-label text-md-right">{{ __('Para: ') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" required name="tenancy_id" id="tenancyTeamForm">
                                    <option value="">Selecione</option>
                                    @foreach($tenancies  as $tenancy)
                                        <option role="{{Auth::user()->hasAnyRoles(['basic'], $tenancy->id)? 'basic' : 'manager'}}" value="{{$tenancy->id}}">{{$tenancy->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 d-none">
                            <label for="equipeAddClienteForm" class="form-label">Equipe</label>
                            <select class="form-control" id="equipeAddClienteForm" name="team_id">
                                <option value="" selected disable>Na fila</option>
                            </select>
                        </div>

                        <div class="mb-3 d-none">
                            <label for="equipeAddUserForm" class="form-label">Usuário</label>
                            <select class="form-control" id="equipeAddUserForm" name="user_id">
                                <option value="" selected disable>Na fila</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="stageAddUserForm" class="form-label">Estágio</label>
                            <select class="form-control" id="stageAddUserForm" name="stage_id">
                                <option value="" selected disable>Selecine a empresa</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="sourceAddUserForm" class="form-label">Fonte</label>
                            <select class="form-control" id="sourceAddUserForm" name="source" onclick="if(this.value=='Outros'){ $('.wrapSourceOtherAddUserForm').show(); }else{ $('.wrapSourceOtherAddUserForm').hide(); }">
                                <option value="" selected >Selecione</option>
                                @foreach(\App\Models\Customer::listSources() as $source)
                                    <option value="{{$source}}">{{$source}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="empreendimentoAddClienteForm" class="form-label">Empreendimento</label>
                            <input value="" type="text" class="form-control" id="empreendimentoAddClienteForm" name="real_state_project" placeholder="" maxlength="60">
                        </div>

                        <div class="mb-3 wrapSourceOtherAddUserForm" style="display:none">
                            <label for="sourceOtherAddUserForm" class="form-label">Descreva a fonte</label>
                            <input class="form-control" id="sourceOtherAddUserForm" name="source_other" />
                        </div>

                        <div class="mb-3">
                            <label for="nomeAddClienteForm" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nomeAddClienteForm" name="name" placeholder="Nome do Cliente" maxlength="60">
                        </div>

                        <div class="mb-3">
                            <label for="emailAddClienteForm" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="emailAddClienteForm" name="email" placeholder="E-mail do Cliente" maxlength="60">
                        </div>

                        <div class="mb-3">
                            <label for="whatsappAddClienteForm" class="form-label">Whatsapp</label>
                            <input type="text" class="form-control mask_tel" id="whatsappAddClienteForm" name="whatsapp" placeholder="Whatsapp do Cliente" maxlength="20">
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="ddd1AddClienteForm" class="form-label">DDD</label>
                                    <input type="text" id="ddd1AddClienteForm" name="ddd" class="form-control" placeholder="DDD 1" maxlength="2">
                            </div>
                            <div class="col">
                                <label for="telefone1AddClienteForm" class="form-label">Telefone</label>
                                <input type="text" id="telefone1AddClienteForm" name="phone" class="form-control mask_tel2" placeholder="Telefone 1">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="ddd2AddClienteForm" class="form-label">DDD 2</label>
                                    <input type="text" id="ddd2AddClienteForm" name="ddd_2" class="form-control " placeholder="DDD 2" maxlength="2">
                            </div>
                            <div class="col">
                                <label for="telefone2AddClienteForm" class="form-label">Telefone 2</label>
                                <input type="text" id="telefone2AddClienteForm" name="phone_2" class="form-control mask_tel2" placeholder="Telefone 2">
                            </div>
                        </div>
                    </form>

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="addClienteForm" class="btn btn-success">Salvar</button>
            </div>
        </div>

    </div>
</div>
