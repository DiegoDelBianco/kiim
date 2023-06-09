<!-- Modal -->
<div class="modal fade" id="modal-delete-customer-{{ $customer->id }}" tabindex="-1" role="dialog" aria-labelledby="lixeiralabel{{ $customer->id }}ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form id="remover-ip"></form>
      <div class="modal-header">
          <h5 class="modal-title" id="lixeiralabel{{ $customer->id }}ModalLabel">Enviar cliente para lixeira.</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    	<p>Você deseja enviar esse cliente para a lixeira?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <form action="{{route('customers.destroy', $customer->id )}}" method="post">
        	@csrf
        	@method('DELETE')
        	<button type="submit" class="btn btn-danger">Enviar</button>
        </form>
      </div>
    </div>
  </div>
</div>