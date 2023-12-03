@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Leads</h1>
@stop

@section('content')





    <div class="bg-white main-canvas">

        <!-- Bread Crumbs e Botão +Add Cliente -->
        <div class="d-flex flex-row justify-content-between shadow">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> Leads </li>
                </ol>
            </nav>

            @can('store-customer')
                    <div class="pt-2 pe-2">
                        <button data-toggle="modal" data-target="#modal-create-customer" type="button" class="btn btn-primary" aria-expanded="false">
                            <i class="fas fa-user-plus"></i>
                            <span>Novo Lead</span>
                        </button>
                        <a href="{{route('customers.importCsv')}}" class="btn btn-primary" aria-expanded="false">
                            <i class="fas fa-file-download"></i>
                            <span>CSV</span>
                        </a>
                    </div>
            @endcan
        </div>
        <!-- Fim Bread Crumbs e Botão +Add Cliente -->



        <!-- MENSAGEM DE SUCESSO AO ADICIONAR LEAD  -->
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
            </div>


        <!-- MENSAGEM DE ERRO AO ADICIONAR LEAD  -->
        @elseif(session()->has('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif

        <!-- MODAL ADICIONAR CUSTOMER -->
        @include('customers.components.modals.create-customer-modal')

        <div class="btn-toolbar p-3" role="toolbar" aria-label="Toolbar with button groups">


            <!-- FILTROS (NÃO ESTÀ FUNCIONANDO) -->
            @include('customers.components.filters-list-customers')

            <!-- CHECK ALL (NÂO ESTA FUNCIONANDO) -->
            <!--div class="btn-group me-2 ml-2" role="group" aria-label="First group">
                <button type="button" class="btn btn-outline-secondary">
                    <input style="width: 20px; height: 20px;" type="checkbox" onclick="toggle(this);" >
                </button>
                <div id="dropdown-check" class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <li><a class="dropdown-item" href="#">(Em breve)</a></li>
                    </ul>
                </div>
            </div-->
            <!-- FIM CHECK ALL -->
        </div>

        <!-- TABELA DE LEADS - ALIMENTADA POR AJAX -->
        <div id="clientes-table"></div>

    </div><!-- FIM DA CANVAS -->


@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@stop

@section('js')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(document).ready(function(){
          carregarTabela(0);
    });
    $(document).on('click', '.paginacao a' , function(e){
        e.preventDefault();
        var pagina = $(this).attr('href').split('page=')[1];
        carregarTabela(pagina);
    });
    $(document).on('keyup submit change input' , '.form' , function(e){
        e.preventDefault();
        carregarTabela(0);
    });
    function carregarTabela(pagina)
    {
        $('#clientes-table').html('<div class="spinner-border m-5" role="status"><span class="sr-only"></span></div>');
         $('#page').val(pagina);
         var dados =  $('#form').serialize();

         $.ajax({
            url: "{{route('customers.list.ajax')}}",
            method: 'GET',
            data: dados
         }).done(function(data){
             $('#clientes-table').html(data);
         });
    }
</script>

<script type="text/javascript" defer>

/****  script para filtros  ****/
$(function() {
    var start = '01/01/2017 00:00:00';
    $('.dataPick').daterangepicker({
        "showDropdowns": true,
        "showWeekNumbers": true,
        "showISOWeekNumbers": true,
        "autoApply": true,
        "startDate": start,
              "endDate": new Date,
        ranges: {
            'Hoje': [moment(), moment()],
            'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
            'Este Mês': [moment().startOf('month'), moment().endOf('month')],
            'Mês Passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "locale": {
            "format": "DD/MM/YYYY HH:mm:ss",
            "separator": " ~ ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "De",
            "toLabel": "até",
            "customRangeLabel": "Personalizar",
            "weekLabel": "S",
            "daysOfWeek": [ "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            "monthNames": [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            "firstDay": 0
        },
        "drops": "down"
    });
});


$(document).ready(function() {
    /*$('select[name="filtro_equipe"]').on('change', function() {
        $('select[name="filtro_assistent"]').empty();
        var stateID = $(this).val();
        if(stateID) {
            $.ajax({
                url: '/city/'+stateID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="filtro_assistent"]').append('<option value="">Todos os Assistentes</option>');
                    $.each(data, function(key, value) {
                        $('select[name="filtro_assistent"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }else{
            $('select[name="filtro_assistent"]').append('<option value="">Todos os Assistentes</option>');
        }
    });*/
    /*$('select[name="sector_id"]').on('change', function() {
        $('select[name="team_id"]').empty();
        var stateID = $(this).val();
        if(stateID) {
            $.ajax({
                url: '/equipe/'+stateID,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('select[name="team_id"]').append('<option value="" selected disabled>Escolha uma Equipe</option>');
                    $.each(data, function(key, value) {
                        $('select[name="team_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        }else{
            $('select[name="team_id"]').append('<option value="">Todos os Assistentes</option>');
        }
    });*/

});
/****  Fim script para filtros  ****/
</script>


<script>
/*****  Script para o modal de criar customer  ******/


// Pass variables arrays from php ($listTeams and $listUsers) to javascript
var listTeams = {!! json_encode($listTeams) !!};
var listUsers = {!! json_encode($listUsers) !!};

$(document).ready(function() {
    $('select[name="tenancy_id"]').on('change', function() {
        var tenancy_id = $(this).val();
        $('select[name="team_id"]').html('<option value="">Na Fila</option>');
        $('select[name="user_id"]').html('<option value="">Na Fila</option>');

        // foreach in listTeams var
        for (var key in listTeams) {
            if(listTeams[key][0] !== undefined ){
                if(listTeams[key][0]['tenancy_id'] == tenancy_id){
                    for(var key2 in listTeams[key]) {
                        console.log(listTeams[key][key2]['name'] );
                        $('select[name="team_id"]').append('<option value="'+ listTeams[key][key2]['id'] +'">'+ listTeams[key][key2]['name'] +'</option>');
                    }
                }
            }
        }

        // foreach in listTeams var
        for (var key in listUsers) {
            console.log(listUsers[key][0]['tenancy_id'] );
            if(listUsers[key][0]['pivot']['tenancy_id'] == tenancy_id){
                for(var key2 in listUsers[key]) {
                    console.log(listUsers[key][key2]['name'] );
                    $('select[name="user_id"]').append('<option value="'+ listUsers[key][key2]['id'] +'">'+ listUsers[key][key2]['name'] +'</option>');
                }
            }
        }

/*
        listTeams.forEach(function(team){
            if(team['tenancy_id'] == tenancy_id){
                $('select[name="team_id"]').append('<option value="'+ team['id'] +'">'+ team['name'] +'</option>');
            }
        });



        listUsers.map(function(user){
            if(user['tenancy_id'] == tenancy_id){
                $('select[name="user_id"]').append('<option value="'+ user['id'] +'">'+ user['name'] +'</option>');
            }
        });
*/
    });
    $('select[name="team_id"]').on('change', function() {
        $('select[name="user_id"]').html('<option value="">Na Fila</option>');
        var team_id = $(this).val();
        /*$.ajax({
            url: "{{route('users.list.ajax.by-team')}}",
            type: "GET",
            data: {team_id: team_id},
            dataType: "json",
            success:function(data) {
                $('select[name="user_id"]').html('<option value="">Na Fila</option>');
                data.map(function(assistent){
                    $('select[name="user_id"]').append('<option value="'+ assistent['id'] +'">'+ assistent['name'] +'</option>');
                });
            }
        });*/
    });
});
/*****  FIM - Script para o modal de criar customer  ******/

</script>



<script>

    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('ruaAddClienteForm').value=("");
            document.getElementById('bairroAddClienteForm').value=("");
            document.getElementById('cidadeAddClienteForm').value=("");
            document.getElementById('ufAddClienteForm').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('ruaAddClienteForm').value=(conteudo.logradouro);
            document.getElementById('bairroAddClienteForm').value=(conteudo.bairro);
            document.getElementById('cidadeAddClienteForm').value=(conteudo.localidade);
            document.getElementById('ufAddClienteForm').value=(conteudo.uf);
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
                document.getElementById('ruaAddClienteForm').value="...";
                document.getElementById('bairroAddClienteForm').value="...";
                document.getElementById('cidadeAddClienteForm').value="...";
                document.getElementById('ufAddClienteForm').value="..";

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


@stop
