<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Master Data Management</title>

<link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/datepicker3.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/styles.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-table.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.23.0/pivot.min.css">

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
                    <a class="navbar-brand" href="#"><span class="fa fa-line-chart">&nbsp;</span><span>Data</span>Governance</a>
                    <ul class="nav navbar-nav">

                        <li class=" nav-item active"><a href="{{ route('home') }}">DQM</a></li>
                        {{-- <li><a href="{{ route('home_mdm') }}">MDM</a></li> --}}
                        @if(Auth::user()->status=='Admin')
                        <li><a href="/home_mdm">MDM</a></li>
                        @elseif((Auth::user()->status=='adminApp1'))
                        <li><a href="/app1_mdm/home_app1">MDM</a></li>
                        @elseif((Auth::user()->status=='adminApp2'))
                        <li><a href="/app2_mdm/home_app2">MDM</a></li>
                        @elseif((Auth::user()->status=='adminApp3'))
                        <li><a href="/app3_mdm/home_app3">MDM</a></li>
                        @endif
                        

                      </ul>
                    <ul class="nav navbar-top-links navbar-right">           
                        <li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <em class="fa fa-power-off"></em>
                        </a>
                            <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <em class="fa fa-power-off">&nbsp;
                                        </em>Logout
                                    </a>
                                </li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                                <li class="divider"></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!-- /.container-fluid -->
            </nav>
        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar" style="background-color: #3d3942;color:#fff">
            <div class="profile-sidebar">
                <div class="profile-userpic">
                @if(Auth::user()->status=='Admin')
                <img src="{{asset('img/gambar.png')}}" class="img-responsive" alt="">
                @else
                <img src="{{asset('img/userr.png')}}" class="img-responsive" alt="">
                @endif
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">{{Auth::user()->username}}</div>
                    <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="divider"></div>
            <ul class="nav menu">
                @if(Auth::user()->status=='Admin')
                    <li><a style="color:#fff" href="{{url('/home_mdm')}}"><em class="fa fa-dashboard"></em> Dashboard</a></li>                
                    <li><a style="color:#fff" href="{{url('/showMaster')}}"><em class="fa fa-database">&nbsp;</em> Master Data</a></li>
                    <li><a style="color:#fff" href="{{url('/showNoMatch')}}"><em class="fa fa-upload">&nbsp;</em>Insert/Update Master Data</a></li>
                    <li><a style="color:#fff" href="{{url('/history')}}"><em class="fa fa-history">&nbsp;</em> Master Data History</a></li>
                @elseif(Auth::user()->status=='adminApp1')
                    <li><a style="color:#fff" href="{{url('/app1_mdm/home_app1')}}"><em class="fa fa-dashboard"></em> Dashboard</a></li>                
                    <li><a style="color:#fff" href="{{url('/showMaster')}}"><em class="fa fa-database">&nbsp;</em> Master Data</a></li>
                    <li><a style="color:#fff" href="{{url('/history')}}"><em class="fa fa-history">&nbsp;</em> Master Data History</a></li>

                @elseif(Auth::user()->status=='adminApp2')
                    <li><a style="color:#fff" href="{{url('/app2_mdm/home_app2')}}"><em class="fa fa-dashboard"></em> Dashboard</a></li>                
                    <li><a style="color:#fff" href="{{url('/showMaster')}}"><em class="fa fa-database">&nbsp;</em> Master Data</a></li>
                    <li><a style="color:#fff" href="{{url('/history')}}"><em class="fa fa-history">&nbsp;</em> Master Data History</a></li>

                @elseif(Auth::user()->status=='adminApp3')
                    <li><a style="color:#fff" href="{{url('/app3_mdm/home_app3')}}"><em class="fa fa-dashboard"></em> Dashboard</a></li>                
                    <li><a style="color:#fff" href="{{url('/showMaster')}}"><em class="fa fa-database">&nbsp;</em> Master Data</a></li>
                    <li><a style="color:#fff" href="{{url('/history')}}"><em class="fa fa-history">&nbsp;</em> Master Data History</a></li>

                @endif 
            </ul>
        </div><!--/.sidebar-->
            
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
                
            <!--modal-->

             @yield('contentMDM')
            
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

                <div class="col-sm-12">
                    <p class="back-link">Lumino Theme by <a href="https://www.medialoot.com">Medialoot</a></p>
                </div>
            </div><!--/.row-->
       	<!--/.main-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/chart.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/chart-data.js')}}"></script>
<script type="text/javascript" src="{{asset('js/easypiechart.js')}}"></script>
<script type="text/javascript" src="{{asset('js/easypiechart-data.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-table.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
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

    //     window.onload = function () {
    //     var chart1 = document.getElementById("line-chart").getContext("2d");
    //     window.myLine = new Chart(chart1).Line(lineChartData, {
    //     responsive: true,
    //     scaleLineColor: "rgba(0,0,0,.2)",
    //     scaleGridLineColor: "rgba(0,0,0,.05)",
    //     scaleFontColor: "#c5c7cc"
    //     });
    //     var chart2 = document.getElementById("bar-chart").getContext("2d");
    //     window.myBar = new Chart(chart2).Bar(barChartData, {
    //     responsive: true,
    //     scaleLineColor: "rgba(0,0,0,.2)",
    //     scaleGridLineColor: "rgba(0,0,0,.05)",
    //     scaleFontColor: "#c5c7cc"
    //     });
    //     var chart3 = document.getElementById("doughnut-chart").getContext("2d");
    //     window.myDoughnut = new Chart(chart3).Doughnut(doughnutData, {
    //     responsive: true,
    //     segmentShowStroke: false
    //     });
    //     var chart4 = document.getElementById("pie-chart").getContext("2d");
    //     window.myPie = new Chart(chart4).Pie(pieData, {
    //     responsive: true,
    //     segmentShowStroke: false
    //     });
    //     var chart5 = document.getElementById("radar-chart").getContext("2d");
    //     window.myRadarChart = new Chart(chart5).Radar(radarData, {
    //     responsive: true,
    //     scaleLineColor: "rgba(0,0,0,.05)",
    //     angleLineColor: "rgba(0,0,0,.2)"
    //     });
    //     var chart6 = document.getElementById("polar-area-chart").getContext("2d");
    //     window.myPolarAreaChart = new Chart(chart6).PolarArea(polarData, {
    //     responsive: true,
    //     scaleLineColor: "rgba(0,0,0,.2)",
    //     segmentShowStroke: false
    //     });
    // };

        function selectDatabase() {
        var x = document.getElementById("selectDB").value;
        var strings = "";
        if(x=="CSV"){
            strings = "You Can Import Your CSV <a href="+"{{ url('/import') }}"+">Here</a> then Choose MySql Connection";
            document.getElementById("tableinput").type = 'file';
        }else{
            strings = "Settings Database Connection <a href="+"{{ url('/database') }}"+">Here</a>";
            document.getElementById("tableinput").type = 'text';
        }

        document.getElementById("small").innerHTML = strings;
        }

        function selectDatabaseMulti() {
        var x = document.getElementById("selectDB").value;
        var strings = "";
        if(x=="CSV"){
            strings = "You Can Import Your CSV <a href="+"{{ url('/import') }}"+">Here</a> then Choose MySql Connection";
            document.getElementById("tableinput1").type = 'file';
            document.getElementById("tableinput2").type = 'file';
        }else{
            strings = "Settings Database Connection <a href="+"{{ url('/database') }}"+">Here</a>";
            document.getElementById("tableinput1").type = 'text';
            document.getElementById("tableinput2").type = 'text';
        }

        document.getElementById("small").innerHTML = strings;
        }
        </script>
            @include('sweetalert::alert')
</body>
</html>