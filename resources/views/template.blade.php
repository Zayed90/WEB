<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Data Quality Management</title>

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
                    <img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
                </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">{{Auth::user()->username}}</div>
                    <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="divider"></div>
            <ul class="nav menu">
                <li><a style="color:#fff" href="{{url('home')}}"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
                {{-- <li><a style="color:#fff" href="{{url('monitoring')}}"><em class="fa fa-bar-chart">&nbsp;</em> Monitoring</a></li>
                --}}
                <li class="parent "><a style="color:#fff" data-toggle="collapse" href="#sub-item-11">
                        <em class="fa fa-bar-chart">&nbsp;</em> Monitoring <span data-toggle="collapse" href="#sub-item-11" class="icon pull-right"><em class="fa fa-plus"></em></span>
                    </a>
                    <ul class="children collapse" id="sub-item-11">
                        <li><a class="" href="#">
                                <b>Single Column</b>
                            </a></li>
                        <li><a class="" href="{{url('/monitoring/pattern')}}">
                                <span class="fa fa-arrow-right">&nbsp;</span>Pattern
                            </a></li>
                        <li><a class="" href="{{url('/pentaho/valueDistribution')}}">
                                <span class="fa fa-arrow-right">&nbsp;</span>Value Distribution
                            </a></li>

                        <li><a class="" href="{{url('/pentaho/dataCompleteness')}}">
                                <span class="fa fa-arrow-right">&nbsp;</span>Data Completeness
                            </a></li>

                        <li><a class="" href="{{url('/pentaho/shownull')}}">
                                <span class="fa fa-arrow-right">&nbsp;</span>Show Null
                            </a></li>
                        <li><a class="" href="{{url('/pentaho/clustering')}}">
                                <span class="fa fa-arrow-right">&nbsp;</span>Clustering
                            </a></li>

                        <li><a class="" href="#">
                                <b>Multi Column</b>
                            </a></li>
                        <li><a class="" href="{{url('/pentaho/cardinalities')}}">
                                <span class="fa fa-arrow-right">&nbsp;</span>Cardinalities
                            </a></li>
                        <li><a class="" href="{{url('/pentaho/valueSimilarity')}}">
                                <span class="fa fa-arrow-right">&nbsp;</span>Value Similarity
                            </a></li>
                        <li><a class="" href="{{url('/pentaho/dataDeduplication')}}">
                                <span class="fa fa-arrow-right">&nbsp;</span>Data Deduplication
                            </a></li>

                    </ul>
                </li>
                @if(Auth::user()->status=='Admin')
                <li class="parent "><a style="color:#fff" data-toggle="collapse" href="#sub-item-1">
					<em class="fa fa-calendar">&nbsp;</em> Profiling <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
					</a>
					<ul class="children collapse" id="sub-item-1">
                            <li><a class="" href="#">
                                    <b>Single Column</b>
                                </a></li>
                                <li><a class="" href="{{url('/pentaho/pattern')}}">
                                    <span class="fa fa-arrow-right">&nbsp;</span>Pattern
                                </a></li>
                                <li><a class="" href="{{url('/pentaho/valueDistribution')}}">
                                    <span class="fa fa-arrow-right">&nbsp;</span>Value Distribution
                                </a></li>

                                <li><a class="" href="{{url('/pentaho/dataCompleteness')}}">
                                    <span class="fa fa-arrow-right">&nbsp;</span>Data Completeness
                                </a></li>

                                <li><a class="" href="{{url('/pentaho/shownull')}}">
                                    <span class="fa fa-arrow-right">&nbsp;</span>Show Null
                                </a></li>
                                <li><a class="" href="{{url('/pentaho/clustering')}}">
                                    <span class="fa fa-arrow-right">&nbsp;</span>Clustering
                                </a></li>

                            <li><a class="" href="#">
                                    <b>Multi Column</b>
                                </a></li>
						{{-- <li><a class="" href="{{url('/pentaho/cardinalities')}}">
							<span class="fa fa-arrow-right">&nbsp;</span>Cardinalities
                        </a></li> --}}
                        <li><a class="" href="{{url('/pentaho/valueSimilarity')}}">
							<span class="fa fa-arrow-right">&nbsp;</span>Value Similarity
                        </a></li>
                        <li><a class="" href="{{url('/pentaho/dataDeduplication')}}">
                        <span class="fa fa-arrow-right">&nbsp;</span>Data Deduplication
						</a></li>

					</ul>
                </li>

                <li class="parent "><a style="color:#fff"  data-toggle="collapse" href="#sub-item-5">

					<em class="fa fa-text-height">&nbsp;</em> Cleansing Package<span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="fa fa-plus"></em></span>
					</a>
					<ul class="children collapse" id="sub-item-5">
						<li><a  class="" href="{{url('cleansing/pattern/index')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Cleansing Pattern Modul
						</a></li>

						<li><a class="" href="{{url('cleansing/null/index')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Cleansing Null Modul
            </a></li>

            <li><a  class="" href="{{url('cleansing_mdm/index')}}">
              <span class="fa fa-arrow-right">&nbsp;</span> Cleansing Modul (MDM)
            </a></li>

            <li><a  class="" href="{{url('/cleansing/dedup')}}">
              <span class="fa fa-arrow-right">&nbsp;</span> Cleansing Deduplication
            </a></li>

            <li><a  class="" href="{{url('/cleansing/clustering')}}">
              <span class="fa fa-arrow-right">&nbsp;</span> Cleansing Clustering
            </a></li>

					</ul>
				</li>

				{{-- <li class="parent "><a style="color:#fff"  data-toggle="collapse" href="#sub-item-2">

					<em class="fa fa-th-list">&nbsp;</em> Master Data <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
					</a>
					<ul class="children collapse" id="sub-item-2">
						<li><a class="" href="{{url('masterdata')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Data Result
						</a></li>
						<li><a class="" href="{{url('/dataTest')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Data Test
						</a></li>
					</ul>
				</li> --}}
				{{-- <li class="parent "><a style="color:#fff" data-toggle="collapse" href="#sub-item-3">
					<em class="fa fa-download">&nbsp;</em> Import Data<span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
					</a>
					<ul class="children collapse" id="sub-item-3">
						<li><a class="" href="{{url('import')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Import Data
						</a></li>
						<li><a class="" href="#">
                        <span class="fa fa-arrow-right">&nbsp;</span> See Result
						</a></li>
					</ul>
                </li> --}}
                {{-- <li><a style="color:#fff" href="{{url('/multiproccess')}}"><em class="fa fa-object-group">&nbsp;</em> Multi Proccess</a></li> --}}
                <li><a style="color:#fff" href="{{url('/database')}}"><em class="fa fa-cog">&nbsp;</em> Database Settings</a></li>
                <li><a  style="color:#fff" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><em class="fa fa-power-off">&nbsp;</em> Log Out</a></li>

               @endif
            </ul>
        </div><!--/.sidebar-->

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

            <!--modal-->



            @yield('content')

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

</body>
</html>
<style>
    .w3-animate-input{transition:width 0.4s ease-in-out}.w3-animate-input:focus{width:100%!important}
    .w3-input{background:#F1F4F7;margin-left:18px;padding:18px;display:block;border:none;border-bottom:5px solid #0690A8;width:100%}

 .bt1 {
  font-size: 16px;
  cursor: pointer;
  height:50px;
  width:290px;
}
.bita {
  color: #ffffff;
  background-color:#DC400D;
  margin-left:1019px;
  border-radius: 9px;
}
.bita:hover {
  color:#ffffff;
  background-color: #551804;
}
.pronow {
  color: #ffffff;
  background-color:#DC400D;
  border-radius: 9px;
}
.pronow:hover {
  color:#ffffff;
  background-color: #551804;
}
.biti {
  color: #ffffff;
  background-color:#F03F06;
  margin-left:79px;
  border-radius: 11px;
}
.biti:hover {
  color:#ffffff;
  background-color: #7C2205;
}
.bitu {
  color: #ffffff;
  background-color:#00719F;
  margin-left:14px;
  border-radius: 11px;
}
.bitu:hover {
  color:#ffffff;
  background-color: #034F6E;

}
.siti {
  color: black;
  border-bottom: 2px double  #EA1313;
}
.siti:hover {
  background: #E68383;
}
}.bati {
  color: #ffffff;
  background-color:#EA1313;
  border-radius: 9px;
  width:25%;
}
.bati:hover {
  color:#ffffff;
  background-color: #EA1000;
}
.dui {
  color: black;
  margin-right:680px;
  border-bottom: 2px double  #4DD769;
}
.dui:hover {
  background: #4DD769;
  color: white;
}
.back {
  color: black;
  border-bottom: 2px double  #EA1313;
}
.back:hover {
  background: #E68383;
}
.skip {
  color: black;
  margin-left:680px;
  border-bottom: 2px double  #4DD769;
}
.skip:hover {
  background: #4DD769;
  color: white;
}
select {
  -webkit-appearance: none;
  -moz-appearance: none;
  -ms-appearance: none;
  appearance: none;
  outline: 0;
  box-shadow: none;
  border: 5 !important;
  background: #ffffff;
  background-image: none;
}
td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
/* Remove IE arrow */
select::-ms-expand {
  display: none;
}
/* Custom Select */
.select {
  position: relative;
  display: flex;
  width:50%;
  margin-left:6px;
  height: 3em;
  line-height: 3;
  background: #ffffff;
  overflow: hidden;
  border-radius: .25em;
}
select {
  flex: 1;
  padding: 0 .5em;
  color: #0690A8;
  cursor: pointer;
}
/* Arrow */
.select::after {
  content: '\25BC';
  position: absolute;
  top: 0;
  right: 0;
  padding: 0 1em;
  background: #0690A8;
  cursor: pointer;
  pointer-events: none;
  -webkit-transition: .25s all ease;
  -o-transition: .25s all ease;
  transition: .25s all ease;
}
/* Transition */
.select:hover::after {
  color: #C40707;
}
.buti {
  display: inline-block;
  padding: 7px 12px;
  font-size: 18px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  width:23%;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  border: none;
  border-radius: 8px;
  height:115px;
  box-shadow: 0 12px #999;
  margin-left:5px;
  margin-right:9px;
  margin-bottom:7px;
  margin-top:10px;
}
.satu {
  background-color: #00293C;}
.satu:hover {
  background: #02231E;
  color: white;}
.dua {
  background-color: #1E656D; }
.dua:hover {
  background: #05806D;
  color: white;}
.tiga {
  background-color: #B28A1F;
  color:white;}
.tiga:hover {
  background: #443304;
  color: white;}
.empat {
  background-color: #F62A00; }
.empat:hover {
  background: #9B0E00;
  color: white;}
.lima {
  background-color: #8cba51;}
.lima:hover {
  color: white;
  background: #408302;}
.enam {
  background-color: #FF5733;}
.enam:hover {
  color: white;
  background: #172901;}
.tujuh {
  background-color: #C70039;}
.tujuh:hover {
  color: white;
  background: #045A34;}
.delapan {
  background-color: #581845;}
.delapan:hover {
  color: white;
  background: #549503;}

.mantul {
  display: inline-block;
  border-radius: 6px;
  background-color: #f4511e;
  border: none;
  color: #FFFFFF;
  padding-top: 6px;
  padding-bottom: 14px;
  padding-right: 14px;
  padding-left: 14px;
  padding-top: 14px;
  transition: all 0.3s;
  cursor: pointer;
  }

.mantul span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;}
.mantul span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;}
.mantul:hover span {
  padding-right: 25px;}
.mantul:hover span:after {
  opacity: 1;
  right: 0;}

.caw {
  color: black;
  border: 2px dashed  #DBD51B;
  margin-left:9px;

}
.caw:hover {
  background: #FBF304;
}
.ciw {
  color: black;
  border: 2px dashed  #95C706;
  margin-left:9px;
}
.ciw:hover {
  background: #A6DC0C;
}
.cow {
  color: black;
  border: 2px dashed  #881365;
  margin-left:9px;
}
.cow:hover {
  background: #A6DC0C;
}
.cew {
  color: black;
  border: 2px dashed  #071083;
  margin-left:9px;
}
.cew:hover {
  background: #A6DC0C;

}
.pilihpattern {
  display: inline-block;
  padding: 7px 12px;
  font-size: 18px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: #fff;
  background-color: #1E94AB;
  border: none;
  border-radius: 15px;
  box-shadow: 0 9px #999;
  margin-left:5px;
  margin-right:9px;
  margin-bottom:7px;
  margin-top:10px;
}
.pilihpattern:hover {background-color: #E73617}

.pilihpattern:active {
  background-color: #C6432C;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
input[type=checkbox] {
  transform: scale(0.9);
}

input[type=checkbox] {
  width: 20px;
  height: 20px;
  margin-right: 18px;
  cursor: pointer;
  visibility: hidden;
}

input[type=checkbox]:after {
  content: " ";
  background-color: #fff;
  display: inline-block;
  padding-bottom: 5px;
  color: #0690A8;
  width: 26px;
  height: 25px;
  visibility: visible;
  border: 1px solid #0690A8;
  padding-left: 3px;
  border-radius: 5px;
}

input[type=checkbox]:checked:after {
  content: "\2714";
  padding: -5px;
  font-weight: bold;
}

</style>
</html>
