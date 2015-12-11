<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex, follow">
	<title>Home</title>
	<!-- Styles -->
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="shortcut icon" href="{{ asset('img')}}/logo_gts.png">
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
			background-color: #eee;
		}

		#header .row{
			border-color: #337ab7;
			background-color:#f5f5f5;
		}

		#title1{
			float:left;
			display:block;
			width:200px;
			margin-top:10px;
			font-size:12px;
			font-weight:bold;
		}

		#logo1{
			width:8%;
			display:inline-block;
			float:left;
			margin:10px 10px 10px 100px;
		}

		.row-header{
			width:100%;
		}

		@media (max-width: 767px) {
			#title1 {
				float:left;
				display:inline;
				font-size:12px;
				font-weight:bold;
			}

			#logo1{
				width:20%;
			}

			.row-header{
				width:100%;
			}
		} 
	</style>
</head>

<body>
	<div id="main-container">
		@yield('content')
	</div>
</body>
</html>