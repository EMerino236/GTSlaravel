<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
    <meta name="robots" content="noindex, follow">
    <title>Bienes</title>
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
    
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		@include('layouts.header', array('user'=>$user))
		<div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>{{ HTML::link('/sot/list_sots','Solicitud de Orden de Trabajo') }}</li>
                    <li>
                        <a href="#">Gestión documentaria<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">                           
							<li>{{ HTML::link('/equipos/list_equipos','Directorio de equipos') }}</li>
							<li>{{ HTML::link('/#','Lista de inventario') }}</li>
							<li>{{ HTML::link('/#','Registro histórico de OT') }}</li>
							<li>{{ HTML::link('/#','Servicio de búsqueda de información') }}</li>
							<li>{{ HTML::link('/documento/list_documentos','Registro y servicio de biblioteca') }}</li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#">Gestión de bienes e inspección<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
							<li>{{ HTML::link('/rep_instalacion/list_rep_instalacion','Reporte de Instalación') }}</li>
							<li>
                                <a href="#">Retiro TS <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
									<li>{{ HTML::link('/retiro_servicio/list_reporte_retiro_servicio','Reporte de retiro de equipos') }}</li>
                                    <li>{{ HTML::link('/retiro_servicio/list_retiro_servicio','Programación de OT de retiro de servicio') }}</li>
                                    <li>{{ HTML::link('/#','OT de retiro de servicio') }}</li>
									<li>{{ HTML::link('/#','Listado de baja definitiva') }}</li>
									<li>{{ HTML::link('/#','Indicadores baja de bienes') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
							<li>
                                <a href="#">Requerimiento <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
									<li>{{ HTML::link('/solicitudes_compra/list_solicitudes','Listado de requerimientos') }}</li>
									<li>{{ HTML::link('/#','Indicadores') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#">Proveedores <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
									<li>{{ HTML::link('/#','Reporte de supervisión') }}</li>
                                    <li>{{ HTML::link('/proveedores/list_proveedores','Directorio') }}</li>
									<li>{{ HTML::link('/reportes_incumplimiento/list_reportes','Reporte de incumplimiento') }}</li>
                        			<li>{{ HTML::link('/#','Acta de conformidad') }}</li>
									<li>{{ HTML::link('/#','Indicadores') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#">Programación <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
									<li>{{ HTML::link('/#','Inspecciones y MP de TS') }}</li>
									<li>{{ HTML::link('/#','Inspecciones y MP de ambientes y servicios no clínicos') }}</li>
									<li>{{ HTML::link('/#','Inspecciones de servicios clínicos') }}</li>
									<li>{{ HTML::link('/#','Verificación metrológica') }}</li>
									<li>{{ HTML::link('/mant_correctivo/list_mant_correctivo','Mantenimiento Correctivo') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#">Estado de TS <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
									<li>{{ HTML::link('/#','Reporte MENSUAL de estado de TS por servicio clínico actualizado') }}</li>
									<li>{{ HTML::link('/#','Reporte MENSUAL de estado de bienes por servicio clínico actualizado') }}</li>
									<li>{{ HTML::link('/#','Indicadores de informes de estado de TS actualizado') }}</li>
									<li>{{ HTML::link('/#','Indicadores de informes de estado de bienes actualizado') }}</li>
									<li>{{ HTML::link('/#','Reporte de verificación metrológica de TS') }}</li>
									<li>{{ HTML::link('/#','Reporte de verificación metrológica de bienes') }}</li>
									<li>{{ HTML::link('/#','Reporte trimestral de evaluación de resultados') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#">Ejecución <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
									<li>{{ HTML::link('/#','OT de inspección de TS realizadas') }}</li>
									<li>{{ HTML::link('/#','OT de inspección de ambientes y ser vicios no clínicos') }}</li>
									<li>{{ HTML::link('/#','OT de inspección de servicios clínico realizada') }}</li>
									<li>{{ HTML::link('/#','OT de mantenimiento preventivo realizada  de TS') }}</li>
									<li>{{ HTML::link('/#','OT de mantenimiento preventivo realizada  de bienes') }}</li>
									<li>{{ HTML::link('/#','OT de verificación metrológica') }}</li>
									<li>{{ HTML::link('/#','OT de mantenimiento correctivo realizada') }}</li>
									<li>{{ HTML::link('/#','OT de mantenimiento correctivo realizada  bienes') }}</li>
									<li>{{ HTML::link('/#','Indicadores de ejecución de Inspecciones, mantenimiento preventivo MP y calibraciones') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        	@yield('content')
        </div>
	</div>
</body>
</html>