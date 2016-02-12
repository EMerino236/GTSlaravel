<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
    <meta name="robots" content="noindex, follow">
    <title>Riesgos</title>
    <link rel="shortcut icon" href="{{ asset('img')}}/logo_gts.png">
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Datepicker CSS-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
    <!-- MetisMenu CSS -->
    <link href="{{ asset('bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="{{ asset('dist/css/timeline.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/sb-admin-2.css') }}" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="{{ asset('bower_components/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <script type="text/javascript">
        var inside_url = "{{$inside_url}}";
    </script>
    <!--Bootstrap-Dialog CSS-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-dialog.min.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Moment JavaScript -->
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <!-- Bootstrap Datepicker JavaScript -->
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>
    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('bower_components/morrisjs/morris.min.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('dist/js/sb-admin-2.js') }}"></script>
    <script src="{{ asset('js/bienes/bienes.js') }}"></script>
    <script src="{{ asset('js/activos/listActivos.js') }}"></script>
    <script src="{{ asset('js/activos/utilActivo.js') }}"></script>
    <script src="{{ asset('js/activos/createActivos.js') }}"></script>    
    <script src="{{ asset('js/activos/editActivos.js') }}"></script>
    <script src="{{ asset('js/soporte_tecnico/listSoporteTecnico.js') }}"></script>
    <script src="{{ asset('js/soporte_tecnico/createSoporteTecnicoProveedor.js') }}"></script>
    <script src="{{ asset('js/reporte_instalacion/list_reporte_instalacion.js') }}"></script>
    <!--Bootstrap-Dialog Javascritp-->
    <script src="{{asset('js/bootstrap-dialog.min.js') }}"></script> 
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		@include('layouts.header', array('user'=>$user))
		@include('layouts.sidebarRiesgos', array('user'=>$user))
        </nav>
        <div id="page-wrapper">
        	@yield('content')
        </div>
	</div>
</body>
</html>