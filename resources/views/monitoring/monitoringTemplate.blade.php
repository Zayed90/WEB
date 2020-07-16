<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring - Dashboard</title>
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/datepicker3.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-table.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.css">
    <!--Icons-->
    @yield('addcss')
    <style>
        .chart {
            width: 100%;
            min-height: 450px;
        }
        .row {
            margin:0 !important;
        }
        .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;

            /* Position the tooltip */
            position: absolute;
            z-index: 1;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
        }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!--Icons-->
<!--
<script type="text/javascript" src="{{asset('js/lumino.glyphs.js')}}"></script>
-->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <style>
        .loader {
            border: 4px solid #f3f3f3; /* Light grey */
            border-top: 4px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>

</head>
<body>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="{{url('home')}}"><span>Data</span>Quality Management</a>
            <ul class="nav navbar-top-links navbar-left">
                <li class="dropdown">
                    @if(Auth::user()->status=='Admin')
                    <a href="{{url('/home')}}">
                            <em class="fa fa-dashboard"></em>
                            <span>Dashboard</span>
                    </a>
                        @else
                        <a href="{{url('/monitoring/dashboardvar')}}">
                            <em class="fa fa-dashboard"></em>
                            <span>Dashboard</span>
                        </a>
                    @endif
                </li>
            </ul>
            <ul class="nav navbar-top-links navbar-left">
                <li class="dropdown"><a data-toggle="dropdown" href="#" title="Monitoring">
                        <em class="fa fa-bar-chart"></em>
                        <span>Monitoring</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('/monitoring/pattern')}}">Pattern</a></li>
                        <li><a href="{{url('/monitoring/shownull')}}">Show Null</a></li>
                        <li><a href="{{url('/monitoring/completeness')}}">Data Completeness</a></li>
                        <li><a href="{{url('/monitoring/distribution')}}">Value Distribution </a></li>
                        <li><a href="{{url('/monitoring/clustering')}}">Clustering</a></li>
                        {{-- SIL --}}
                        <li><a href="{{url('/monitoring/similarity')}}">Value Similarity</a></li>
                        <li><a href="{{url('/monitoring/deduplication')}}">Data Deduplication</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-top-links navbar-left">
                <li class="dropdown"><a data-toggle="dropdown" href="#" aria-expanded="false">
                        <em class="fa fa-clipboard"></em>
                        <span>Reporting</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{url('/report/pattern')}}">Pattern</a></li>
                        <li><a href="{{url('/report/null')}}">Show Null</a></li>
                        <li><a href="{{url('/report/completeness')}}">Data Completeness</a></li>
                        <li><a href="{{url('/report/distribution')}}">Value Distribution </a></li>
                        <li><a href="{{url('/report/clustering')}}">Clustering</a></li>
                        <li><a href="{{url('/report/similarity')}}">Value Similarity</a></li>
                        <li><a href="{{url('/report/deduplication')}}">Data Deduplication</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <em class="fa fa-power-off"></em>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><em class="fa fa-power-off">&nbsp;</em>Logout</a></li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                        <li class="divider"></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div><!-- /.container-fluid -->
</nav><!--/.row-->
<!--/.main-->
@yield('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="{{asset('js/chart.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/chart-data.js')}}"></script>
<script type="text/javascript" src="{{asset('js/easypiechart.js')}}"></script>
<script type="text/javascript" src="{{asset('js/easypiechart-data.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-table.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/c3_renderers.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/export_renderers.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.6.0/tips_data.min.js"></script>
<!--Modals-->
@yield('jspivot')
<script>
    !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
</script>
<script>
    $(function () {
        $('[data-toggle="dashboard"]').tooltip()
        $('[data-toggle="dropdown"]').tooltip()

    })
</script>
</body>
</html>
