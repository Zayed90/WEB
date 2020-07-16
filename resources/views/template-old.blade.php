<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Profiling - Dashboard</title>

<link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/datepicker3.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/styles.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-table.css')}}">

<!--Icons-->
<script type="text/javascript" src="{{asset('js/lumino.glyphs.js')}}"></script>


<!--Modals-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

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
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  		<div class="container-fluid">
  			<div class="navbar-header">
  				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
  					<span class="sr-only">Toggle navigation</span>
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  				</button>
  				<a class="navbar-brand" href="#"><span>Profiling</span>Admin</a>
  				<ul class="user-menu">
  					<li class="dropdown pull-right">
  						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> {{ Auth::user()->status }} <span class="caret"></span></a>
  						<ul class="dropdown-menu" role="menu">
  							<!-- <li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li> -->
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
  						</ul>
  					</li>
  				</ul>
  			</div>

  		</div><!-- /.container-fluid -->
  	</nav>

  	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
  		<form role="search">
  			<div class="form-group">

  			</div>
  		</form>
  		<ul class="nav menu">
  			<li><a href="{{url('home')}}"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
  			<!-- <li><a href="{{url('dataSource')}}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Tables</a></li>
				<li><a href="{{url('monitoringAdmin')}}"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Monitoring</a></li> -->
				<li class="parent "><a data-toggle="collapse" href="#sub-item-1"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-notepad"></use></svg>
					<em class="fa fa-navicon">&nbsp;</em> Profiling <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
					</a>
					<ul class="children collapse" id="sub-item-1">
						<li><a class="" href="{{url('/pentaho/cardinalities')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Run Cardinalities
						</a></li>
						<li><a class="" href="{{url('/pentaho/pattern')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Run Pattern
						</a></li>
						<li><a class="" href="{{url('/pentaho/valueDistribution')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Run Value Distribution
						</a></li>
						<li><a class="" href="{{url('/pentaho/valueSimilarity')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Run Value Similarity
						</a></li>
						<li><a class="" href="{{url('/pentaho/dataCompleteness')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Run Data Completeness
						</a></li>
						<li><a class="" href="{{url('/pentaho/dataDeduplication')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Run Data Deduplication
						</a></li>
						<li><a class="" href="{{url('/pentaho/shownull')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Run Show Null
						</a></li>
						<li><a class="" href="{{url('/pentaho/clustering')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Run Clustering
						</a></li>
					</ul>
				</li>
				<li class="parent "><a data-toggle="collapse" href="#sub-item-2"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>
					<em class="fa fa-navicon">&nbsp;</em> Master Data <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
					</a>
					<ul class="children collapse" id="sub-item-2">
						<li><a class="" href="{{url('masterdata')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Data Result
						</a></li>
						<li><a class="" href="{{url('/dataTest')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Data Test
						</a></li>
					</ul>
				</li>
				<li class="parent "><a data-toggle="collapse" href="#sub-item-3"><svg class="glyph stroked download"><use xlink:href="#stroked-download"></use></svg>
					<em class="fa fa-navicon">&nbsp;</em> Import from External<span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
					</a>
					<ul class="children collapse" id="sub-item-3">
						<li><a class="" href="{{url('import')}}">
							<span class="fa fa-arrow-right">&nbsp;</span> Import Data
						</a></li>
						<li><a class="" href="#">
							<span class="fa fa-arrow-right">&nbsp;</span> See Result
						</a></li>
					</ul>
				</li>
				
  			<li role="presentation" class="divider"></li>
  		</ul>
  		<div class="attribution">Template by <a href="http://www.medialoot.com/item/lumino-admin-bootstrap-template/">Medialoot</a><br/><a href="http://www.glyphs.co" style="color: #333;">Icons by Glyphs</a></div>
  	</div><!--/.sidebar-->

<!--Modals-->
<div class="modal fade" id="myModal" role="dialog" style="margin-top: 100px">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        
        <div class="modal-body">
		<center>
			<div style="width: 50%; ">
				<div style="display: inline-block;">
			<h2>Please Wait</h2>
		</div>
		<div style="display: inline-flex;margin-left: 10px">
			<div style=" " class="loader"></div>
		</div>
		</div>
		</center>
			
        </div>
        
      </div>
	</div>
</div>
<!--End-->
	  
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

    		@yield('content')
    	</div>	<!--/.main-->

</body>
</html>

  <script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/chart.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/chart-data.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/easypiechart.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/easypiechart-data.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/bootstrap-datepicker.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/bootstrap-table.js')}}"></script>
	<script>
		$('#calendar').datepicker({
		});

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
