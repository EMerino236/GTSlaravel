<div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>{{ HTML::link('/sot/list_sots','Solicitud de Orden de Trabajo') }}</li>
                    <li>
                        <a href="#">Gestión documentaria<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">                           
							<li>{{ HTML::link('/equipos/list_equipos','Directorio de equipos') }}</li>
							<li>{{ HTML::link('/equipos/list_inventario','Lista de inventario') }}</li>
							<li>{{ HTML::link('/registro_historico_otm/list_ot','Registro histórico de OT') }}</li>
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
                                    <li>{{ HTML::link('/proveedores/list_proveedores','Directorio de Proveedores') }}</li>
                                    <li>{{ HTML::link('/soportes_tecnico/list_soporte_tecnico','Directorio de Soporte Técnico') }}</li>
									<li>{{ HTML::link('/reportes_incumplimiento/list_reportes','Reporte de incumplimiento') }}</li>
                        			<li>{{ HTML::link('/actas_conformidad/list_actas','Acta de conformidad') }}</li>
									<li>{{ HTML::link('/#','Indicadores') }}</li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                            <li>
                                <a href="#">Programación <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
									<li>{{ HTML::link('/inspec_equipos/list_inspec_equipos','Inspecciones de Equipos') }}</li>
                                    <li>{{ HTML::link('/mant_preventivo/list_mant_preventivo','Mantenimiento Preventivo') }}</li>
									<li>{{ HTML::link('/verif_metrologica/list_verif_metrologica','Verificación metrológica') }}</li>
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