        <!-- TAB COM DADOS DE CLIENTE -->
        <div id="horizontal__tab02" class="horizontal__tabcontent ">
            <h3>Dados do Lead</h3>
            <form class="col-md-6" id="updateClienteForm" action="{{route('customers.update', $customer)}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="nomeUpdateClienteForm" class="form-label">Nome</label>
                    <input value="{{ $customer->name }}" required type="text" class="form-control" id="nomeUpdateClienteForm" name="name" placeholder="Nome do Cliente" maxlength="60">
                </div>
                <div class="mb-3">
                    <label for="emailUpdateClienteForm" class="form-label">E-mail</label>
                    <input value="{{ $customer->email }}" type="text" class="form-control" id="emailUpdateClienteForm" name="email" placeholder="E-mail do Cliente" maxlength="60">
                </div>
                <div class="mb-3">
                    <label for="whatsappUpdateClienteForm" class="form-label">Whatsapp</label>
                    <input value="{{ $customer->whatsapp }}" type="text" class="form-control mask-phone" id="whatsappUpdateClienteForm" name="whatsapp" placeholder="Whatsapp do Cliente" maxlength="20">
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label for="ddd1UpdateClienteForm" class="form-label">DDD 1</label>
                        <input value="{{ $customer->ddd }}" type="text" id="ddd1UpdateClienteForm" name="ddd" class="form-control" placeholder="DDD 1" maxlength="3">
                    </div>
                    <div class="col">
                        <label for="telefone1UpdateClienteForm" class="form-label">Telefone 1</label>
                        <input value="{{ $customer->phone }}" type="text" id="telefone1UpdateClienteForm" name="phone" class="form-control mask_tel2" placeholder="Telefone 1">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label for="ddd2UpdateClienteForm" class="form-label">DDD 2</label>
                        <input value="{{ $customer->ddd_2 }}" type="text" id="ddd2UpdateClienteForm" name="ddd_2" class="form-control" placeholder="DDD 2" maxlength="3">
                    </div>
                    <div class="col">
                        <label for="telefone2UpdateClienteForm" class="form-label">Telefone 2</label>
                        <input value="{{ $customer->phone_2 }}" type="text" id="telefone2UpdateClienteForm" name="phone_2" class="form-control  mask_tel2" placeholder="Telefone 2">
                    </div>
                </div>
                <div class="mb-3 mt-3">
                    <label for="nascimentoUpdateClienteForm" class="form-label">Nascimento</label>
                    <input value="{{ $customer->birth }}" type="date" class="form-control mask_data" id="nascimentoUpdateClienteForm" name="birth" placeholder="Data de Nascimento do Cliente">
                </div>
                <button type="submit" class="btn btn-success">Salvar</button>
            </form>
        </div>
        <!-- FIM TAB COM DADOS DE CLIENTE -->
