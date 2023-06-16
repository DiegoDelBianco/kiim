@extends('adminlte::page')

@section('title', 'Painel Kiim')

@section('content_header')
    <h1>Métricas</h1>
@stop

@section('content')

    <div class="bg-white main-canvas">
        {{-- Bread Crumbs e Botão +Add Cliente--}}
        <div class="d-flex flex-row justify-content-between">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Métricas</li>
                </ol>
            </nav>

        </div>

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

            <div class="card-body">













            <h2 class="text-center mt-4">{{ $title }}</h2>
                <div class="row">
                    <div class="col-md-12 text-center pt-3">
                        <form action="" class=" form-inline">
                        <span class="pr-2">Periodo de apuração:  </span>
                            <select class="form-control" onchange="altperiodo();" name="selectPeriodo" id="selectPeriodo" style=" margin-right: 15px">
                                <option value="1">Ultimos 12 meses</option>
                                <option value="2">Selecionar Mês</option>
                                <option value="3">Selecionar Ano</option>
                                <option value="4">Personalizado</option>
                            </select>
                            <select class="form-control" name="mes" id="selectMes" style="display:none">
                                <option value="1">Jan</option>
                                <option value="2">Fev</option>
                                <option value="3">Mar</option>
                                <option value="4">Abr</option>
                                <option value="5">Mai</option>
                                <option value="6">Jun</option>
                                <option value="7">Jul</option>
                                <option value="8">Ago</option>
                                <option value="9">Set</option>
                                <option value="10">Out</option>
                                <option value="11">Nov</option>
                                <option value="12">Dez</option>
                            </select>
                            <span class="type4" style="display:none;"> De: </span>
                            <input class="form-control" type="date" id="dateini" name="dateini" style="display:none">
                            <span class="type4" style="display:none; padding-left: 5px"> Até: </span>
                            <input class="form-control " type="date" id="dateend" name="dateend" style="display:none">
                            <select class="form-control" name="ano" id="selectAno" style="display:none">
                                @for($i = date('o'); $i>=2020 ; $i--)
                                   <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            @if(isset($listAssistents))
                            <select class="form-control" name="assistent" id="selectAssistents" style=" margin-right: 15px; margin-left: 15px; max-width: 190px;">
                                <option value="">Todos os Usuários</option>
                                @foreach($listAssistents as $assistent)
                                    <option value="{{ $assistent->id }}" @if(isset($_GET['assistent'])?($_GET['assistent']==$assistent->id):false)  selected  @endif >{{ $assistent->name }}</option>
                                @endforeach
                            </select>
                            @endif
                            <button class="btn btn-primary" type="submit" class="btn">Atualizar</button>
                        </form>
                    </div>
                </div>
                <style type="text/css">
                    .desc_graf{
                        color: #888;
                        text-align: center;
                        font-size: 14px;
                        padding: 10px 15px;
                    }
                </style>
                <div class="card rounded shadow-sm m-4" style="width: fit-content;">
                    <div class="car-header text-center">
                        <h4 class="mt-3">Vendas  X Leads</h4>
                    </div>
                    <div class="card-body">
                        <div id="newLeadsContractsChart" style="width: 900px;height:400px;"></div>
                    </div>
                    <p class="desc_graf"><b>Descição dos dados: </b>
                        <br> <b>Leads</b> - Todos os leads inseridos no sistema, independente da etapa, inclusive deletados(Deletados não aparecem nas listagens).
                        <br> <b>Vendas (Novo)</b> - Leads que não passaram por remarketing, com estágios pós venda (Vendido(aguardado pagamento) | Vendido | Cobrança), a data no gráfico faz refência a data de criação do Contrato no sistema (*Não se refere a data de criação do lead*).
                        <br> <b>Vendas (Remar.)</b> - Leads que já passaram por remarketing, com estágios pós venda (Vendido(aguardado pagamento) | Vendido | Cobrança), a data no gráfico faz refência a data de criação do Contrato no sistema (*Não se refere a data de criação do lead*).
                    </p>
                </div>



                <div class="card rounded shadow-sm m-4 d-none" style="width: fit-content;">
                    <div class="car-header text-center">
                        <h4 class="mt-3">Vendas remarketing ({{ number_format(array_sum($vendas_remarketing), 0, '', '.') }}) X Leads Remarketing ({{ number_format(array_sum($remarketing), 0, '', '.') }})</h4>
                    </div>
                    <div class="card-body">
                        <div id="remarketing_vendas" style="width: 900px;height:400px;"></div>
                    </div>
                    <p class="desc_graf"><b>Descição dos dados: </b>
                        <br> <b>Leads Remarketing</b> - Todos que já passaram por remarketing, independente da etapa atual, inclusive deletados(Deletados não aparecem nas listagens), a data no gráfico faz refência a data de criação do lead no sistema.
                        <br> <b>Vendas Remarketing</b> - Leads que já passaram por remarketing, com estágios pós venda (Vendido(aguardado pagamento) | Vendido | Cobrança), a data no gráfico faz refência a data de criação do Contrato no sistema (*Não se refere a data de criação do lead*).
                    </p>
                </div>

                <div class="card rounded shadow-sm m-4" style="width: fit-content;">
                    <div class="car-header text-center">
                        <h4 class="mt-3">Leads({{ number_format(array_sum($leads), 0, '', '.') }})</h4>
                    </div>
                    <div class="card-body">
                        <div id="newLeadsChart" style="width: 900px;height:400px;"></div>
                    </div>
                    <p class="desc_graf"><b>Descição dos dados: </b>
                        <br> <b>Leads</b> - Todos os leads inseridos no sistema, independente da etapa, inclusive deletados(Deletados não aparecem nas listagens).
                    </p>
                </div>

                <div class="card rounded shadow-sm m-4" style="width: fit-content;">
                    <div class="car-header text-center">
                        <h4 class="mt-3">Leads vendidos({{ number_format(array_sum($contracts), 0, '', '.') }})</h4>
                    </div>
                    <div class="card-body">
                        <div id="newContracts" style="width: 900px;height:400px;"></div>
                    </div>
                    <p class="desc_graf"><b>Descição dos dados: </b>
                        <br> <b>Leads vendidos</b> -  Todos os leads, com estágios pós venda (Vendido(aguardado pagamento) | Vendido | Cobrança), a data no gráfico faz refência a data de criação do Contrato no sistema (*Não se refere a data de criação do lead*).
                    </p>
                </div>

                {{--<div class="card rounded shadow-sm m-4" style="width: fit-content;">
                    <div class="car-header text-center">
                        <h4 class="mt-3">Vendas (Novo)({{ number_format(array_sum($newContractsNoRemarketing), 0, '', '.') }}) X Vendas (Remar.)({{ number_format(array_sum($vendas_remarketing), 0, '', '.') }}) </h4>
                    </div>
                    <div class="card-body">
                        <div id="newContractsNewContractsNoRemarketing" style="width: 900px;height:400px;"></div>
                    </div>
                    <p class="desc_graf"><b>Descição dos dados: </b>
                        <br> <b>Vendas (Remar.)</b> - Leads que já passaram por remarketing, com estágios pós venda (Vendido(aguardado pagamento) | Vendido | Cobrança), a data no gráfico faz refência a data de criação do Contrato no sistema (*Não se refere a data de criação do lead*).
                        <br> <b>Vendas (Novo)</b> - Leads que não passaram por remarketing, com estágios pós venda (Vendido(aguardado pagamento) | Vendido | Cobrança), a data no gráfico faz refência a data de criação do Contrato no sistema (*Não se refere a data de criação do lead*).
                    </p>
                </div> --}}


                {{--<div class="card rounded shadow-sm m-4" style="width: fit-content;">
                    <div class="car-header text-center">
                        <h4 class="mt-3">Incompletos X Aguardando Pagamento X Aguardando Financeiro X Cancelados</h4>
                    </div>
                    <div class="card-body">
                        <div id="contractsByStatus" style="width: 900px;height:400px;"></div>
                    </div>
                    <p class="desc_graf"><b>Descição dos dados: </b>
                        <br> <b>Contratos incompletos</b> - Contratos sem data de pagamento definida
                        <br> <b>Contratos Agu. Pagamento</b> - Cotratos aguardando pagamento
                        <br> <b>Contratos Agu. Financeiro</b> - Contratos Aguardando confirmação financeira (Considere concluídos até ser desenvolvido o painel financeiro)
                        <br> <b>Contratos cancelados</b> - Contratos Aguardando Cancelamento
                    </p>
                </div>--}}

                <div class="card rounded shadow-sm m-4 d-none" style="width: fit-content;">
                    <div class="car-header text-center">
                        <h4 class="mt-3">Valor total(R$ {{ number_format(array_sum($totals), 2, ',', '.') }})</h4>
                    </div>
                    <div class="card-body">
                        <div id="totals" style="width: 900px;height:400px;"></div>
                    </div>
                    <p class="desc_graf"><b>Descição dos dados: </b>
                        <br> <b>Valor total</b> -  Valor total obtido pela somatória do valor de crédito solicitado por todos os cliente com estágio pós venda (Atenção o valor não está sendo obtido pelo contrato, então pode não ser o valor real da venda).
                    </p>
                </div>

                <div class="card rounded shadow-sm m-4 d-none" style="width: fit-content;">
                    <div class="car-header text-center">
                        <h4 class="mt-3">Lead de Remarketing({{ number_format(array_sum($remarketing), 0, '', '.') }})</h4>
                    </div>
                    <div class="card-body">
                        <div id="remarketing" style="width: 900px;height:400px;"></div>
                    </div>
                    <p class="desc_graf"><b>Descição dos dados: </b>
                        <br> <b>Leads Remarketing</b> - Todos que já passaram por remarketing, independente da etapa atual, inclusive deletados(Deletados não aparecem nas listagens), a data no gráfico faz refência a data de criação do lead no sistema.
                    </p>

                </div>
    <br>
    <br>
    <br>
    <br>













            
            </div>
    </div><!-- FIM DA CANVAS -->


@stop

@section('css')

@stop

@section('js')
    <script> console.log('Sistema desenvolvido por Agência Jobs.'); </script>
    <!-- call echarts cdn script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.1.0/echarts.min.js"></script>

<script type="text/javascript">

    var colors = {
            leadsQtd: {ini: "#74b9ff", end: "#0984e3"},
            leadsVen: {ini: "#a29bfe", end: "#6c5ce7"},
            remQtd: {ini: "#ff7675", end: "#d63031"},
            remVen: {ini: "#fd79a8", end: "#e84393"},
            novQtd: {ini: "#55efc4", end: "#00b894"},
            novVen: {ini: "#81ecec", end: "#00cec9"},
        };

    // Initialize the echarts instance based on the prepared dom
    var newLeadsChart = echarts.init(document.getElementById('newLeadsChart'));
    var newContractsChart = echarts.init(document.getElementById('newContracts'));
    var totalsChart = echarts.init(document.getElementById('totals'));
    var remarketingChart = echarts.init(document.getElementById('remarketing'));
    var newLeadsContractsChart = echarts.init(document.getElementById('newLeadsContractsChart'));
    var remarketing_vendasChart = echarts.init(document.getElementById('remarketing_vendas'));
    //var newContractsNewContractsNoRemarketingChart = echarts.init(document.getElementById('newContractsNewContractsNoRemarketing'));
    //var contractsByStatusChart = echarts.init(document.getElementById('contractsByStatus'));

    /***************- Leads X Vendas X Remarketing -***************/
    var newLeadsContractsChartOption = {
        tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
        legend: {},
        grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
        xAxis: [
        {
            type: 'category',
            data: [
            @foreach ($leads as $key => $value )
            '{{$key}}',
            @endforeach
            ]
        }
        ],
        yAxis: [ { type: 'value' } ],
        series: [
            {
                name: 'Vendas',
                type: 'bar',
                //stack: 'Ad',
                emphasis: { focus: 'series' },
                //itemStyle: { color: 'green' },

                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: colors.novVen.ini },
                        { offset: 1, color: colors.novVen.end }
                    ])      
                },
                label: { show: true, position: 'top'  },
                data: [
                    @foreach ($contracts as $key => $value )
                    '{{$value}}',
                    @endforeach
                    //220, 182, 191, 234, 290, 330, 310, 190, 220, 320, 270, 400
                ]
            },

            {
                name: 'Leads',
                type: 'bar',
                //stack: 'Ad',
                emphasis: { focus: 'series' },
                //itemStyle: { color: 'blue' },
                //itemStyle: { color: 'blue' },

                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: colors.leadsQtd.ini },
                        { offset: 1, color: colors.leadsQtd.end }
                    ])      
                },
                label: { show: true, position: 'top'  },
                data: [

                    @foreach ($leads as $key => $value )
                    {{$value}},
                    @endforeach
                    //220, 182, 191, 234, 290, 330, 310, 190, 220, 320, 270, 400
                ]
            }
        ]
        };

    /***************- Leads Remarketing X Vendas remarketing -***************/
    var remarketing_vendasOption = {
        tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
        legend: {},
        grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
        xAxis: [
        {
            type: 'category',
            data: [
            @foreach ($leads as $key => $value )
            '{{$key}}',
            @endforeach
            ]
        }
        ],
        yAxis: [ { type: 'value' } ],
        series: [

            {
                name: 'Vendas remarketing',
                type: 'bar',
                //stack: 'Ad',
                emphasis: { focus: 'series' },
                //itemStyle: { color: 'green' },

                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: colors.remVen.ini },
                        { offset: 1, color: colors.remVen.end }
                    ])      
                },

                label: { show: true, position: 'top'  },
                data: [
                    @foreach ($vendas_remarketing as $key => $value )
                    {{$value}},
                    @endforeach
                    //220, 182, 191, 234, 290, 330, 310, 190, 220, 320, 270, 400
                ]
            },

            {
                name: 'Leads Remarketing',
                type: 'bar',
                //stack: 'Ad',
                emphasis: { focus: 'series' },
                label: { show: true, position: 'top'  },
                //itemStyle: { color: 'red' },
                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: colors.remQtd.ini },
                        { offset: 1, color: colors.remQtd.end }
                    ])      
                },

                data: [
                    @foreach ($remarketing as $key => $value )
                    {{$value}},
                    @endforeach
                    //220, 182, 191, 234, 290, 330, 310, 190, 220, 320, 270, 400
                ]
            }
        ]
        };




    /***************- Comparação de contratos por status -***************/
    {{--var contractsByStatusOption = {
        tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
        legend: {},
        grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
        xAxis: [
        {
            type: 'category',
            data: [
            @foreach ($leads as $key => $value )
            '{{$key}}',
            @endforeach
            ]
        }
        ],
        yAxis: [ { type: 'value' } ],
        series: [

            {
                name: 'Contratos incompletos',
                type: 'bar',
                //stack: 'Ad',
                emphasis: { focus: 'series' },

                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: colors.novVen.ini },
                        { offset: 1, color: colors.novVen.end }
                    ])      
                },

                label: { show: true, position: 'top'  },
                data: [
                    @foreach ($vendasSemData as $key => $value )
                    {{$value}},
                    @endforeach
                    //220, 182, 191, 234, 290, 330, 310, 190, 220, 320, 270, 400
                ]
            },

            {
                name: 'Contratos Agu. Pagamento',
                type: 'bar',
                //stack: 'Ad',
                emphasis: { focus: 'series' },
                label: { show: true, position: 'top'  },

                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: colors.remVen.ini },
                        { offset: 1, color: colors.remVen.end }
                    ])      
                },

                data: [
                    @foreach ($vendasAguardandoPag as $key => $value )
                    {{$value}},
                    @endforeach
                    //220, 182, 191, 234, 290, 330, 310, 190, 220, 320, 270, 400
                ]
            },

            {
                name: 'Contratos Agu. Financeiro',
                type: 'bar',
                //stack: 'Ad',
                emphasis: { focus: 'series' },
                label: { show: true, position: 'top'  },

                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: colors.leadsVen.ini },
                        { offset: 1, color: colors.leadsVen.end }
                    ])      
                },

                data: [
                    @foreach ($vendasAguardandoFin as $key => $value )
                    {{$value}},
                    @endforeach
                    //220, 182, 191, 234, 290, 330, 310, 190, 220, 320, 270, 400
                ]
            },

            {
                name: 'Contratos cancelados',
                type: 'bar',
                //stack: 'Ad',
                emphasis: { focus: 'series' },
                label: { show: true, position: 'top'  },

                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: colors.remQtd.ini },
                        { offset: 1, color: colors.remQtd.end }
                    ])      
                },

                data: [
                    @foreach ($vendasCanceladas as $key => $value )
                    {{$value}},
                    @endforeach
                    //220, 182, 191, 234, 290, 330, 310, 190, 220, 320, 270, 400
                ]
            }
        ]
        };--}}




    /***************- Vendas remarketing X Vendas primeiro atendimento -***************/
    var newContractsNewContractsNoRemarketingOption = {
        tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
        legend: {},
        grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
        xAxis: [
        {
            type: 'category',
            data: [
            @foreach ($leads as $key => $value )
            '{{$key}}',
            @endforeach
            ]
        }
        ],
        yAxis: [ { type: 'value' } ],
        series: [

            {
                name: 'Vendas',
                type: 'bar',
                //stack: 'Ad',
                emphasis: { focus: 'series' },

                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: colors.novVen.ini },
                        { offset: 1, color: colors.novVen.end }
                    ])      
                },

                label: { show: true, position: 'top'  },
                data: [

        
                    @foreach ($contracts as $key => $value )
                    '{{$key}}',
                    @endforeach
                    //220, 182, 191, 234, 290, 330, 310, 190, 220, 320, 270, 400
                ]
            }
        ]
        };

    
    /***************- Leads -***************/
    var newLeadsChartOption = {
        tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
        legend: {},
        grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
        xAxis: [
        {
            type: 'category',
            data: [
            @foreach ($leads as $key => $value )
            '{{$key}}',
            @endforeach
            ]
        }
        ],
        yAxis: [ { type: 'value' } ],
        series: [
            {
                //name: 'Canceladas',
                type: 'bar',
                stack: 'Ad',
                emphasis: { focus: 'series' },
                //itemStyle: { color: 'red' },
                //itemStyle: { color: 'blue' },

                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: colors.leadsQtd.ini },
                        { offset: 1, color: colors.leadsQtd.end }
                    ])      
                },
                label: { show: true, position: 'top'  },
                data: [

                    @foreach ($leads as $key => $value )
                    {{$value}},
                    @endforeach
                    //220, 182, 191, 234, 290, 330, 310, 190, 220, 320, 270, 400
                ]
            },
           /* {
                name: 'Vendidas',
                type: 'bar',
                stack: 'Ad',
                emphasis: { focus: 'series' },
                itemStyle: { color: 'green' },
                data: [150, 232, 201, 154, 190, 330, 410, 700, 670, 450, 370, 250]
            }*/
        ]
        };


    /***************- Leads vendidos -***************/
    var newContractsOption = {

    tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' }  },
    legend: {},
    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
    xAxis: [
    {
        type: 'category',
        data: [
        
        @foreach ($contracts as $key => $value )
        '{{$key}}',
        @endforeach
        ]
    }
    ],
    yAxis: [ { type: 'value' } ],
    series: [
    {
        type: 'bar',
        showBackground: true,
        label: { show: true, position: 'top'  },

        itemStyle: {
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                { offset: 0, color: colors.leadsVen.ini },
                { offset: 1, color: colors.leadsVen.end }
            ])      
        },
        data: [
        @foreach ($contracts as $key => $value )
        {{$value}},
        @endforeach
        ]
    }
    ]
    };

    /***************- Valor total -***************/
    var totalsOption = {

    tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' }  },
    legend: {},
    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
    xAxis: [
    {
        type: 'category',
        data: [
        
        @foreach ($totals as $key => $value )
        '{{$key}}',
        @endforeach
        ]
    }
    ],
    yAxis: [ { type: 'value' } ],
    series: [
    {
        type: 'bar',
        showBackground: true,
        label: { show: true, position: 'top'  },
        itemStyle: {
        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
            { offset: 0, color: '#83bff6' },
            { offset: 0.5, color: '#188df0' },
            { offset: 1, color: '#188df0' }
        ])
        },
        data: [
        @foreach ($totals as $key => $value )
        {{$value}},
        @endforeach
        ]
    }
    ]
    };

    /***************- Lead de Remarketing -***************/
    var remarketingOption = {

    tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' }  },
    legend: {},
    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
    xAxis: [
    {
        type: 'category',
        data: [
        
        @foreach ($remarketing as $key => $value )
        '{{$key}}',
        @endforeach
        ]
    }
    ],
    yAxis: [ { type: 'value' } ],
    series: [
    {
        type: 'bar',
        showBackground: true,
        label: { show: true, position: 'top'  },
        itemStyle: {
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                { offset: 0, color: colors.remQtd.ini },
                { offset: 1, color: colors.remQtd.end }
            ])      
        },
        data: [
        @foreach ($remarketing as $key => $value )
        {{$value}},
        @endforeach
        ]
    }
    ]
    };


    // Display the chart using the configuration items and data just specified.
    //newContractsNewContractsNoRemarketingChart.setOption(newContractsNewContractsNoRemarketingOption);

    // Display the chart using the configuration items and data just specified.
    remarketing_vendasChart.setOption(remarketing_vendasOption);

    // Display the chart using the configuration items and data just specified.
    newLeadsContractsChart.setOption(newLeadsContractsChartOption);

    // Display the chart using the configuration items and data just specified.
    remarketingChart.setOption(remarketingOption);

    // Display the chart using the configuration items and data just specified.
    totalsChart.setOption(totalsOption);

    // Display the chart using the configuration items and data just specified.
    newLeadsChart.setOption(newLeadsChartOption);

    // Display the chart using the configuration items and data just specified.
    newContractsChart.setOption(newContractsOption);

    // Display the chart using the configuration items and data just specified.
    //contractsByStatusChart.setOption(contractsByStatusOption);



    function altperiodo(){
        let periodo = $("#selectPeriodo").val();

        if(periodo == 1){
            $("#selectMes").hide();
            $("#dateini").removeProp("selectMes");
            $("#selectAno").hide();
            $("#selectAno").removeProp("selectAno");
            $("#dateini").hide();
            $("#dateini").removeProp("required");
            $("#dateend").hide();
            $("#dateend").removeProp("required");
            $(".type4").hide();
        }
        if(periodo == 2){
            $("#selectMes").show();
            $("#selectMes").prop("required", true);
            $("#selectAno").show();
            $("#selectAno").prop("required", true);
            $("#dateini").hide();
            $("#dateini").removeProp("required");
            $("#dateend").hide();
            $("#dateend").removeProp("required");
            $(".type4").hide();
        }
        if(periodo == 3){
            $("#selectMes").hide();
            $("#selectMes").removeProp("required");
            $("#selectAno").show();
            $("#selectAno").prop("required", true);
            $("#dateini").hide();
            $("#dateini").removeProp("required");
            $("#dateend").hide();
            $("#dateend").removeProp("required");
            $(".type4").hide();
        }
        if(periodo == 4){
            $("#selectMes").hide();
            $("#selectMes").removeProp("required");
            $("#selectAno").hide();
            $("#selectAno").removeProp("required");
            $("#dateini").show();
            $("#dateini").prop("required", true);
            $("#dateend").show();
            $("#dateend").prop("required", true);
            $(".type4").show();
        }
    }
</script>
@stop