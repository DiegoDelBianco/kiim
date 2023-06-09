

    @if ($btn_end_customer_service)
        <button  data-toggle="modal" data-target="#modal-end-customer-service" data-bs-toggle="dropdown" aria-expanded="false"   type="button" class="btn btn-warning finalizar_atendimento">Finalizar Atendimento</button>
        @include('customers.components.modals.end-customer-service-modal')
    @endif


    <!-- PARA O ASSISTENTE QUANDO ESTIVER EM NEGOCIACAO -->
    @if($btn_start_customer_service)
        <form action="{{-- route('iniciar.atendimento', $customer->customer_id) --}}" method='POST'>
            @csrf
            <button type="submit" class="btn btn-warning finalizar_atendimento">Iniciar Atendimento</button>
        </form>
    @endif



    <!-- DEFINE TABS -->
    <div class="row pt-2">
        <div class=" shadow-sm col-md-2">
            <div class="horizontal__tab row">
                <button class="horizontal__tablinks col-md-12 btn btn-info mb-2 @if(isset($_GET['tab'])?$_GET['tab']==1:true) active @endif" data-tab='horizontal__tab01' onclick="horizontalOpenTab(this)" >Atendimento</button>
                <button class="horizontal__tablinks col-md-12 btn btn-info mb-2 @if(isset($_GET['tab'])?$_GET['tab']==2:false) active @endif" data-tab='horizontal__tab02' onclick="horizontalOpenTab(this)" >Dados do Cliente</button>
                <button class="horizontal__tablinks col-md-12 btn btn-info mb-2 @if(isset($_GET['tab'])?$_GET['tab']==3:false) active @endif" data-tab='horizontal__tab03' onclick="horizontalOpenTab(this)" >Timeline</button>
                <button class="horizontal__tablinks col-md-12 btn btn-info mb-2 @if(isset($_GET['tab'])?$_GET['tab']==4:false) active @endif" data-tab='horizontal__tab04' onclick="horizontalOpenTab(this)" >Agendamentos 
                        @if($schedules[1]) <span class="status aguardando" style="border-radius: 50%;">{{$schedules[1]}}</span> @endif   
                        @if($schedules[4]) <span class="status hoje" style="border-radius: 50%; margin: 0px;">{{$schedules[4]}}</span> @endif    
                        @if($schedules[5]) <span class="status atrasado" style="border-radius: 50%; margin: 0px;">{{$schedules[5]}}</span> @endif 
                </button>
            </div>
        </div>

        <div class="w-100 p-3 col-md-10" style="padding-top: 0px !important;">
            @include('customers.components.customer-service-tabs.home-customer-service-tab')
            @include('customers.components.customer-service-tabs.edit-customer-tab')
            @include('customers.components.customer-service-tabs.show-customer-timeline-tab')
            @include('customers.components.customer-service-tabs.show-schedule-tab')
        </div>
    </div>


@section('css')
<style>
    * {
        box-sizing: border-box;
    }

    .finalizar_atendimento{
        position: fixed;
        bottom: 69px;
        width: 200px;
        left: calc(50vw - 100px);
        right: auto;
        font-size: 18px;
        line-height: 34px;
        box-shadow: #333 2px 2px 6px;
        z-index: 1;
    }

    .ficha_cliente{
        margin-top: 20px;
        max-width: 600px;
        border: 1px #eee solid;
        border-radius: 5px;
    }
    .ficha_cliente p{
        color: #222;
        margin-bottom: 2px;
        padding-left: 8px;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 18px;
    }
    .ficha_cliente p span{
        font-weight: 500;
        display: inline-block;
        min-width: 115px;
    }
    .ficha_cliente p:nth-child(even) {
      background: #eee;
    }
    .section_contact{
        width: auto;
        display: inline-block;
        position: absolute;
        top: 0px;
        right: 0px;
        padding: 5px;
        background: #eee;
        border-radius: 3px;
        text-align:center
    }

    .horizontal__tabcontent{
        padding-bottom: 150px !important
    }

    /* The actual timeline (the vertical ruler) */
    .timeline {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    }

    /* The actual timeline (the vertical ruler) */
    .timeline::after {
    content: '';
    position: absolute;
    width: 6px;
    background-color: white;
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -3px;
    }

    /* Container around content */
    .containerx {
    padding: 10px 40px;
    position: relative;
    background-color: inherit;
    width: 50%;
    }

    /* The circles on the timeline */
    .containerx::after {
    content: '';
    position: absolute;
    width: 25px;
    height: 25px;
    right: -17px;
    background-color: white;
    border: 4px solid #FF9F55;
    top: 15px;
    border-radius: 50%;
    z-index: 1;
    }

    /* Place the containerx to the left */
    .left {
    left: 0;
    }

    /* Place the containerx to the right */
    .right {
    left: 50%;
    }

    /* Add arrows to the left containerx (pointing right) */
    .left::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 22px;
    width: 0;
    z-index: 1;
    right: 30px;
    border: medium solid white;
    border-width: 10px 0 10px 10px;
    border-color: transparent transparent transparent black;
    }

    /* Add arrows to the right containerx (pointing left) */
    .right::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 22px;
    width: 0;
    z-index: 1;
    left: 30px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent black transparent transparent;
    }

    /* Fix the circle for containers on the right side */
    .right::after {
    left: -16px;
    }

    /* The actual content */
    .content {
    padding: 20px 30px;
    background-color: white;
    position: relative;
    border-radius: 6px;
    border: 1px solid;
    }

    /* Media queries - Responsive timeline on screens less than 600px wide */
    @media screen and (max-width: 600px) {
    /* Place the timelime to the left */
    .timeline::after {
    left: 31px;
    }

    /* Full-width containers */
    .containerx {
    width: 100%;
    padding-left: 70px;
    padding-right: 25px;
    }

    /* Make sure that all arrows are pointing leftwards */
    .containerx::before {
    left: 60px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
    }

    /* Make sure all circles are at the same spot */
    .left::after, .right::after {
    left: 15px;
    }

    /* Make all right containers behave like the left ones */
    .right {
    left: 0%;
    }
    }
</style>

@stop

@section('js')

<script>
$(document).ready(function(){
    let element = $(".horizontal__tablinks.active")[0];
    horizontalOpenTab(element);
});

function horizontalOpenTab(evt) {

    let tab = $(evt).data('tab');
    var i, tabcontent, tablinks;

    $(".horizontal__tabcontent").css('display', 'none');
    $("#"+tab).css('display', 'block');
    $(".horizontal__tablinks").removeClass("active");

    $(evt).addClass("active");
}


function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('ruaUpdateClienteForm').value=("");
        document.getElementById('bairroUpdateClienteForm').value=("");
        document.getElementById('cidadeUpdateClienteForm').value=("");
        document.getElementById('ufUpdateClienteForm').value=("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('ruaUpdateClienteForm').value=(conteudo.logradouro);
        document.getElementById('bairroUpdateClienteForm').value=(conteudo.bairro);
        document.getElementById('cidadeUpdateClienteForm').value=(conteudo.localidade);
        document.getElementById('ufUpdateClienteForm').value=(conteudo.uf);
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('ruaUpdateClienteForm').value="...";
            document.getElementById('bairroUpdateClienteForm').value="...";
            document.getElementById('cidadeUpdateClienteForm').value="...";
            document.getElementById('ufUpdateClienteForm').value="..";

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};

</script>

<script>
    function generateLink() {
    let number = document.getElementById('zapnumber').value;
    let message = document.getElementById('zapmessage').value;
    let url = "https://wa.me/";
    let end_url = `${url}55${number}?text=${message}`;
    document.getElementById('zaplink').href = end_url;
    }
</script>

<script>
    function changeMotivoFinalizacao(){
        let motivo = $("#motivosFinalizar").val();

        if(motivo == 2){
            $('.j_venda').show();
        }else{
            $('.j_venda').hide();
        }

    }
</script>
@stop