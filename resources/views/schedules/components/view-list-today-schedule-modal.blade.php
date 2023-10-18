<!-- Modal Whatsapp -->
<div class="modal fade" id="modalSchedulingHoje" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align: center; width: 100%;">Tarefa para Hoje<span class="status"></span></h4>
            </div>
            <div class="modal-body">
                @foreach($hoje as $scheduling)
                    <div class="tarefa">
                        <p><b>Vendedor: </b>{{ $scheduling->user_name }}</p>
                        {{--<p><b>Cliente: </b>{{ $scheduling->customer_name }}</p>--}}
                        <p><b>Data: </b>{{ date('d/m/Y',strtotime($scheduling->date)) }} @if($scheduling->hour != '') ás {{substr($scheduling->time, 0, 5)}}  @endif</p>
                        <p><b>Nota: </b>{{ $scheduling->description }}</p>
                        <p><b>Status: </b><span class="status {{ $scheduling->getStatus(1) }}">{{ $scheduling->getStatus(1) }}</span></p>
                        {{--<p><a href='{{ route('customer.edit', $scheduling->customer_id) }}' class="btn btn-info loadlayer">Ver Atendimento</a></p>--}}
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <a class="btn btn-default" data-dismiss="modal">Fechar</a>
            </div>
        </div>

    </div>
</div>
<style>
    #modalSchedulingHoje .tarefa p{
        padding: 5px;
        margin-bottom: 0px;
    }
</style>
