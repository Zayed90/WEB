<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profiling - Dashboard</title>

    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/datepicker3.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/styles.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-table.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.css">
    <!--Icons-->


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
                <li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <em class="fa fa-dashboard"></em>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-top-links navbar-left">
                <li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <em class="fa fa-bar-chart"></em>
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
                <li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <em class="fa fa-clipboard"></em>
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
</nav>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div style="margin-top: 100px" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div style="padding-bottom: 5px" class="alert bg-primary" role="alert"><em class="fa fa-lg fa-check">&nbsp;</em> Loading, Please Wait
                    <div style="margin-top: 10px" class="progress">
                        <div  class="progress-bar progress-bar-striped active" role="progressbar"
                              aria-valuenow="40" aria-valuemin="0" aria-valuemax="40" style="width:100%">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div><!--/.row-->
<!--/.main-->
<div class="row">
    <ol class="breadcrumb">
        <li class="active"><em class="fa fa-home"></em>Monitoring</li>
        <li><a href="{{url('/monitoring/pattern')}}">Pattern</a></li>
        <li class="active">Record Result</li>
    </ol>
</div><!--/.row-->

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">View Pattern</h1>
    </div>
</div><!--/.row-->

<div class="bs-callout bs-callout-success">
    <h4>Result & Information</h4>

    <pre>
ID Running : {{ $id_running }}
Host Name : {{ $datasource_detail['host'] }}
Database Name : {{ $datasource_detail['db_name'] }}
User Name : {{ $datasource_detail['db_username'] }}
Port : {{ $datasource_detail['port'] }}
Table name : {{ $datasource_detail['tab'] }}
Column Name : {{ $datasource_detail['col'] }}
</pre>

    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table data-toggle="table" data-show-refresh="true" data-search="true" data-pagination="true">
                        <thead>
                        <tr>
                            <th>Pattern</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        @foreach($results as $row)
                            @if(($loop->first) && (!empty($_GET['done'])))
                                <tr class="success">
                            @else
                                <tr>
                                    @endif
                                    <td>{{$row->column_pattern}}</td>
                                    <td>{{$row->total_each_pattern}}</td>
                                </tr>
                                @endforeach
                    </table>
                </div>
            </div>
            <a href="{{route('patternMonitorView')}}"<button type="button" class="btn btn-success btn-block">Back</button></a>
        </div>
    </div>
</div>

<!--/.main-->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/chart.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/chart-data.js')}}"></script>
<script type="text/javascript" src="{{asset('js/easypiechart.js')}}"></script>
<script type="text/javascript" src="{{asset('js/easypiechart-data.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-table.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/c3_renderers.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/export_renderers.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.6.0/tips_data.min.js"></script>
<!--Modals-->
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

</script>
</body>
</html>
