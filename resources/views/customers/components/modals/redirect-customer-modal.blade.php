<!-- Modal -->
<div class="modal fade" id="modal-redirect-customer-{{ $customer->id }}" tabindex="-1" role="dialog" aria-labelledby="lixeiralabel{{ $customer->id }}ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="{{route('customers.redirect', $customer->id )}}" method="post">
          @csrf
          <div class="modal-header">
              <h5 class="modal-title" id="lixeiralabel{{ $customer->id }}ModalLabel">Remanejar Lead.</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
        	<p>Você deseja remanejar esse lead?</p>
          <div class="mb-3">
              <label for="equipeRedirectClienteForm-{{ $customer->id }}" class="form-label">Equipe</label>
              <select class="form-control input-red-team" id="equipeRedirectClienteForm-{{ $customer->id }}" name="team_id">
                  <option value="" selected disable>Na fila</option>
                  @foreach ($listTeams as $key => $value)
                      <option value="{{ $value->id }}" >{{ $value->name }}</option>
                  @endforeach
              </select>
          </div>

          <div class="mb-3">
              <label for="equipeRedirectUserForm-{{ $customer->id }}" class="form-label">Usuário</label>
              <select class="form-control input-red-user" id="equipeRedirectUserForm-{{ $customer->id }}" name="user_id">
                  <option value="" selected disable>Na fila</option>
                  @foreach ($listUsers as $user)
                      <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
              </select>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            	<button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </form>
    </div>
  </div>
</div>

<script>
/*****  Script para o modal de criar customer  ******/
$(document).ready(function() {  
    $('#equipeRedirectClienteForm-{{ $customer->id }}').on('change', function() {
        $('#equipeRedirectUserForm-{{ $customer->id }}').empty();
        var team_id = $(this).val();
        $.ajax({
            url: "{{route('users.list.ajax.by-team')}}",
            type: "GET",
            data: {team_id: team_id},
            dataType: "json",
            success:function(data) {
                $('#equipeRedirectUserForm-{{ $customer->id }}').html('<option value="">Na Fila</option>');
                data.map(function(assistent){
                    $('#equipeRedirectUserForm-{{ $customer->id }}').append('<option value="'+ assistent['id'] +'">'+ assistent['name'] +'</option>');
                });
            }
        });
    });
});
/*****  FIM - Script para o modal de criar customer  ******/

</script>