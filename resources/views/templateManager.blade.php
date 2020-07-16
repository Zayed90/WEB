<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Profiling - Dashboard</title>

<link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/datepicker3.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/styles.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap-table.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">


<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<!--Icons-->
<script type="text/javascript" src="{{asset('js/lumino.glyphs.js')}}"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

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
  						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Manager <span class="caret"></span></a>
  						<ul class="dropdown-menu" role="menu">
  							<li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
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
  			<li><a href="{{url('dashboardManager')}}"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
        <li><a href="{{url('monitoringManager')}}"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Monitoring</a></li>
  			<li role="presentation" class="divider"></li>
  		</ul>
  		<div class="attribution">Template by <a href="http://www.medialoot.com/item/lumino-admin-bootstrap-template/">Medialoot</a><br/><a href="http://www.glyphs.co" style="color: #333;">Icons by Glyphs</a></div>
  	</div><!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

    		@yield('content');
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
