<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, follow">
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <title>Configuraciones</title>
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
    <script src="{{ asset('js/user/user.js') }}"></script>
    <script src="{{ asset('js/configuraciones/configuraciones.js') }}"></script>
    <script src="{{ asset('js/familia_activos/listFamiliaActivos.js') }}"></script>
    <script src="{{ asset('js/familia_activos/editFamiliaActivos.js') }}"></script>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            @include('layouts.header', array('user'=>$user))
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                        <a href="#">Mantenimientos<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Áreas <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>{{ HTML::link('/areas/create_area','Nueva Área') }}</li>
                                    <li>{{ HTML::link('/areas/list_areas','Buscar Área') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#">Servicios <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>{{ HTML::link('/servicios/create_servicio','Nuevo Servicio') }}</li>
                                    <li>{{ HTML::link('/servicios/list_servicios','Buscar Servicio') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#">Centro de Costos <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>{{ HTML::link('/centro_costos/create_centro_costo','Nuevo Centro de Costo') }}</li>
                                    <li>{{ HTML::link('/centro_costos/list_centros_costos','Buscar Centro de Costo') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#">Grupos <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>{{ HTML::link('/grupos/create_grupo','Nuevo Grupo') }}</li>
                                    <li>{{ HTML::link('/grupos/list_grupos','Buscar Grupo') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#">Marcas <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>{{ HTML::link('/marcas/create_marca','Nueva Marca') }}</li>
                                    <li>{{ HTML::link('/marcas/list_marcas','Buscar Marca') }}</li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Familias de Equipos <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>{{ HTML::link('/familia_activos/create_familia_activo','Nueva Familia de Equipo') }}</li>
                                    <li>{{ HTML::link('/familia_activos/list_familia_activos','Buscar Familia de Equipo') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#">Tipos de Tareas<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>{{ HTML::link('/tipoTarea/create_tipoTarea','Nuevo Tipo de Tarea') }}</li>
                                    <li>{{ HTML::link('/tipoTarea/list_tipoTareas','Buscar Tipo de Tarea') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="page-wrapper">
            @yield('content')
        </div>
    </div>


</body>
</html>