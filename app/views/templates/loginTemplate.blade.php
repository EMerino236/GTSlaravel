<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Home</title>
	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/login/form-elements.css') }}">
	<link rel="stylesheet" href="{{ asset('css/login/style.css') }}">
	<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<link rel="stylesheet" href="{{ asset('css/bootstrap-dialog.min.css') }}">
	<link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
	<script src="{{ asset('js/jquery.backstretch.min.js') }}"></script>
	<script src="{{ asset('js/cripts.js') }}"></script>
	<!-- Scripts -->
	<style type="text/css">
		body{
			background-color:;
		}
	</style>
</head>

<body>
	<div id="main-container">
		@yield('content')
	</div>
</body>
</html>