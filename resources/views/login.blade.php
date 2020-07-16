<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login page</title>

<link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/datepicker3.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('css/styles.css')}}">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>

	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Log in</div>
				<div class="panel-body">
					<form role="form" action="{{ route('login') }}" method="post">
					{{ csrf_field() }}
						<fieldset>
							<div class="form-group {{$errors->has('username') ? 'has errors' : ''}}" >
								<input class="form-control" placeholder="Username" id="username" name="username" value="{{ old('username') }}" autofocus required>

								@if($errors->has('username'))
								<span class="help-block">
									<strong>{{ $errors->first('username') }}</strong>
								</span>
								@endif
							</div>

							<div class="form-group {{$errors->has('password') ? 'has errors' : ''}}" >
								<input class="form-control" placeholder="Password" id="password" name="password" value="{{ old('password') }}" required>

								@if($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
								@endif
							</div>
							<button type="submit" name="login" class="btn btn-primary">Login</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->

	<script type="text/javascript" src="{{asset('js/jquery-1.11.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/chart.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/chart-data.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/easypiechart.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/easypiechart-data.js')}} "></script>
	<script type="text/javascript" src="{{asset('js/bootstrap-datepicker.js')}}"></script>
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
</body>

</html>
