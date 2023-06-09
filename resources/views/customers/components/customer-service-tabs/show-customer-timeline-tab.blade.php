<!-- TAB DE TIMELINE -->
<div id="horizontal__tab03" class="horizontal__tabcontent">
    <h3>Timeline</h3>

    <div class="pt-2 pe-2 pb-4 text-center">
        <button data-toggle="modal" data-target="#modal-create-customer-timeline" type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-book"></i>
        <span>Novo Registro</span>
        </button>
    </div>
    @include('customers.components.modals.create-customer-timeline-modal')

    @if($customer->customerTimelines)
        <div class="timeline">
            @foreach($customer->customerTimelines as $registro)
                <div class="containerx {{ $loop->odd ? "left" : "right" }}">
                    <div class="content">
                        <h2>
                            @if ($registro->type == 1)
                            <i class="fas fa-phone-alt"></i>
                            @elseif ($registro->type == 2)
                            <i class="fab fa-whatsapp"></i>
                            @elseif ($registro->type == 3)
                            <i class="fas fa-envelope"></i>
                            @elseif ($registro->type == 4)
                            <i class="fas fa-sms"></i>
                            @elseif ($registro->type == 5)
                            <i class="fas fa-robot"></i>
                            @elseif ($registro->type == 6)
                            <i class="fas fa-pen-nib"></i>
                            @endif
                            {{ date('d/m/Y H:i:s', strtotime($registro->created_at)) }}
                        </h2>
                        <p>{{ $registro->autor }}</p>
                        <p style="word-wrap: break-word;">{!! str_replace("\n", "<br />", $registro->event) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p style="text-center">Nenhum registro encontrado</p>
    @endif
</div>
<!-- FIM TAB DE TIMELINE -->