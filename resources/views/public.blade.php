<!DOCTYPE html>
<html lang="pt-br">
<!--  Maintenance Page Theme by Start Bootstrap and Jackie D'Elia Design -->
<head>

    <meta charset="utf-8">
    <meta name="facebook-domain-verification" content="pdf4r8fu3mh1k7f9mleb3n9eq65a6k" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('images/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('images/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title>Kiim - CRM Imobiliário</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('maintenance/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('maintenance/css/landing-page.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <!--link href="{{asset('maintenance/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"-->
    <!-- font awesome cdn -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    @include('script-default-values')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="site">
    <div class="overlay">
        <!-- Header -->
        <div class="container">
            <div class="intro-message">
                <h1>Kiim</h1>
                <h2>Vamos revolucionar o relacionamento com seu cliente.</h2>
                <hr class="intro-divider">
                @if (Route::has('login'))
                    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-center z-10">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Meu painel</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Entrar</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-success">Registrar</a>
                            @endif
                        @endauth
                    </div>
                @endif
                <hr class="intro-divider">
                <h3>Uma ferramenta completa de vendas, marketing e gestão, <br> para construtoras, imobiliárias e corretores.</h3>
                <ul class="intro-social-buttons">
                    <li>
                        <a href="#" class="btn btn-default btn-lg"><i class="fa fa-instagram fa-fw"></i> <span class="network-name">Instagram</span></a>
                    </li>
                    <li>
                        <a href="#" class="btn btn-default btn-lg"><i class="fa fa-linkedin fa-fw"></i> <span class="network-name">Linkedin</span></a>
                    </li>
                    <li>
                        <a href="#" class="btn btn-default btn-lg"><i class="fa fa-behance fa-fw"></i> <span class="network-name">Behance</span></a>
                    </li>
                </ul>
                <div class="intro-content">
                    <p>S.A.C Comercial</p>
                    <p >
                        <!-- whatsapp button using font-awesome -->
                        <a style="font-size: 20px" href="{{config('contacts.whatsapp_link')}}" class="btn btn-success"><i class="fa fa-whatsapp"></i> WhatsApp</a>
                    </p>
                    <a class="tel" href="tel:{{config('contacts.phone')}}">{{config('contacts.phone')}}</a>
                    <!--p class="address">123 Main St.
                        <br>Anytown, AB 55555
                    </p-->
                </div>
            </div>

            <div class="intro-footer">
                <p class="copyright text-muted small">Copyright &copy; 2023. Este é um produto de propriedade da <a href="#"> Agência Jobs</a>. All Rights Reserved</p>
            </div>
        </div>
        <!-- /.container -->


    </div>
    <!-- overlay -->
    <!-- jQuery -->
    <script src="{{asset('maintenance/js/jquery.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('maintenance/js/bootstrap.min.js')}}"></script>

    <!-- font awesome js cdn -->
    <script src="https://use.fontawesome.com/1e803d693b.js"></script>

</body>

</html>
