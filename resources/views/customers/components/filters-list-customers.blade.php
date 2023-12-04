@php if(!isset($blockfilter)) $blockfilter = []; @endphp
<div class="btn-group me-2" role="group" aria-label="First group">
  <div class="btn-group" role="group">
    <button id="btnGroupDrop2" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" data-auto-close="outside">
      <i class="fas fa-filter"></i>
    </button>
    <ul class="dropdown-menu shadow px-3" aria-labelledby="btnGroupDrop2" style="width: 470px;">
        <form class="form" id="form">
            <input type="hidden" name="orderbyfield" id="orderbyfield" value="">
            <input type="hidden" name="orderbyorder" id="orderbyorder" value="">
            <input type="hidden" name="limit" id="limitpag" value="25">
            <input type="hidden" id="page" name="page" value="0">

            {{-- SetlistView serve para definir o view que será retornado no request das páginas, podenendo ser usado padrões diferente, por enquanto não está sendo usado nesse sistema --}}
            @if(isset($setListView)) <input type="hidden" id="setListView" name="setListView" value="{{$setListView}}"> @endif

            @csrf

            <h5>Filtros</h5>

            <hr>

            <div class="row"  @if(isset($blockfilter["name"])) style="display:none" @endif>
                <div class="col">
                    <label for="filtro_nome">Nome</label>
                    <div class="input-group">
                        <label for="filtro_nome" class="input-group-text"><i class="fas fa-signature"></i></label>
                        <input type="text" id="filtro_nome" name="filtro_nome" class="form-control" placeholder="Nome do Lead">
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col">
                    <label for="filtro_data">Adicionado no sistema</label>
                    <div class="input-group">
                        <label for="filtro_data" class="input-group-text"><i class="fas fa-calendar-day"></i></label>
                        <input type="text" class="form-control dataPick" name="filtro_data" id="filtro_data" onchange="carregarTabela(0)">
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col">
                    <label for="filtro_alt">Última Alteração</label>
                    <div class="input-group">
                        <label for="filtro_alt" class="input-group-text"><i class="fas fa-calendar-day"></i></label>
                        <input type="text" class="form-control dataPick" name="filtro_alt" id="filtro_alt" onchange="carregarTabela(0)">
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4 mt-2">
                    <label for="filtro_cpf">CPF</label>
                    <div class="input-group">
                        <label for="filtro_cpf" class="input-group-text"><i class="fas fa-id-card"></i></label>
                        <input type="text" id="filtro_cpf" name="filtro_cpf" class="form-control" placeholder="CPF do Lead">
                    </div>
                </div>

                <!--div class="col-md-4 mt-2">
                    <label for="filtro_id">Código/Id do Lead</label>
                    <div class="input-group">
                        <label for="filtro_id" class="input-group-text"><i class="fas fa-barcode"></i></label>
                        <input type="text" id="filtro_id" name="filtro_id" class="form-control" placeholder="Código do Lead">
                    </div>
                </div-->

                <!--div class="col-md-4 mt-2">
                    <label for="filtro_produto">Produto</label>
                    <div class="input-group">
                        <label for="filtro_produto" class="input-group-text"><i class="fas fa-cubes"></i></label>
                        <input type="text" id="filtro_produto" name="filtro_produto" class="form-control" placeholder="Produto">
                    </div>
                </div-->

                <div class="col-md-4 mt-2">
                    <label for="filtro_phone">Telefone</label>
                    <div class="input-group">
                        <label for="filtro_phone" class="input-group-text"><i class="fas fa-phone"></i></label>
                        <input type="text" id="filtro_phone" name="filtro_phone" class="form-control" placeholder="Telefone">
                    </div>
                </div>

                @can('manage-users')
                    <div class="col-md-4 mt-2" @if(isset($blockfilter['team'])) style="display:none" @endif>
                        <label for="filtro_equipe">Equipe</label>
                        <div class="input-group">
                            <label for="filtro_equipe" class="input-group-text"><i class="fas fa-users-cog"></i></label>
                            <select name="filtro_equipe" id="filtro_equipe" class="form-control">
                                <option value="">Todas as Equipes</option>
                                @foreach ($listTeams as $key => $value)
                                    @if(is_string($value))
                                        <option value="{{ $key }}" @if(isset($blockfilter['team'])?$blockfilter['team']==$key:false) selected @endif >{{ $value }}</option>
                                    @else
                                        @foreach($value as $k => $v)
                                            <option value="{{ $v->id }}" @if(isset($blockfilter['team'])?$blockfilter['team']==$v->id:false) selected @endif >{{ $v->name }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if(isset($listUsers))
                    <div class="col-md-4 mt-2" @if(isset($blockfilter['user'])) style="display:none" @endif>
                        <label for="filtro_assistent">Usuário</label>
                        <div class="input-group">
                            <label for="filtro_assistent" class="input-group-text"><i class="fas fa-headphones"></i></label>
                            <select name="filtro_assistent" id="filtro_assistent" class="form-control">
                                <option value="">Todos os usuários</option>
                                @foreach($listUsers as $user)
                                    @if(!isset($user->id))
                                        @foreach($user as $u)
                                            <option value="{{$u->id}}" @if(isset($blockfilter['user'])?$blockfilter['user']==$u->id:false) selected @endif>{{$u->name}}</option>
                                        @endforeach
                                    @else
                                        <option value="{{$user->id}}" @if(isset($blockfilter['user'])?$blockfilter['user']==$user->id:false) selected @endif>{{$user->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @endif
                @endcan

                @if(isset($listWebsites))
                <div class="col-md-4 mt-2">
                    <label for="filtro_website">LeadPage</label>
                    <div class="input-group">
                        <label for="filtro_website" class="input-group-text"><i class="fas fa-globe"></i></label>
                        <select name="filtro_website" id="filtro_website" class="form-control">
                            <option value="">Todas as LeadPages</option>
                            @foreach($listWebsites as $website)
                                <option value="{{$website->id}}">{{$website->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

                @if(isset($listStages))
                <div class="col-md-4 mt-2"  @if(isset($blockfilter["stage"])) style="display:none" @endif>
                    <label for="filtro_stage">Estágio</label>
                    <div class="input-group">
                        <label for="filtro_stage" class="input-group-text"><i class="fas fa-map-marker"></i></label>
                        <select name="filtro_stage" id="filtro_stage" class="form-control">
                            <option value="">Todos os Estágios</option>
                            @foreach($listStages as $stage)
                                <option @if(isset($stage['is_deleted'])) style="color: red; background: #eee" @endif value="{{$stage['key']}}">{{$stage['value']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif

            </div>
        </form>

    </ul>
  </div>
</div>



