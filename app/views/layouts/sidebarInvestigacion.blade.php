<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                {{ HTML::link('documento_investigacion/list_documentos','Repositorio de documentos de módulo de investigación') }}
                
            </li>
            <li>
                <a href="#">Diseño de procesos y procedimientos de GTS<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">   
                    <li>{{ HTML::link('mapa_procesos/list_procesos','Mapa de procesos y procedimientos GTS (con definición e indicadores GTS) ') }}</li>
                    <li>
                        <a href="#">Plantillas de inspecciones<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>{{ HTML::link('plantillas_servicios/list_servicios','Plantillas de inspecciones de servicios') }}</li>
                            <!--<li>{{ HTML::link('#','Plantillas de inspecciones de infraestructura ') }}</li>-->
                            <!--<li>{{ HTML::link('#','Plantillas de inspecciones hospitalario ') }}</li>-->
                        </ul>
                    </li>
                    <li>{{ HTML::link('#','Indicadores de diseño de procesos y procedimientos') }}</li>
                </ul>                
            </li>
            <li>
                <a href="#">Diseño integral y funcional de servicios clínicos<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>{{ HTML::link('plantillas_mant_preventivo/list_mantenimientos','Plantillas de mantenimiento por TS') }}</li>
                </ul>
            </li>
            <li>
                {{ HTML::link('guias_tecno_salud/list_guias','Elaboración de Guía de Práctica de Tecnologías de Salud') }}
            </li>
            <li>
                <a href="#">Elaboración de Guía de Práctica Clínica GPC  y ETES de procedimientos clínicos<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">                           
                    <li>{{ HTML::link('#','Indicadores de elaboración de guía de práctica clínica  ') }}</li>
                    <li>{{ HTML::link('guias_clinica_gpc/list_guias','Guía de Práctica Clínica') }}</li>
                    <li>{{ HTML::link('/reporte_etes/list_reporte_etes','ETES de procedimientos clínicos') }}</li>
                </ul>
            </li>
            <li>
                {{ HTML::link('programacion_guias/list_programacion_guias','Programación de elaboración de Guías y Reporte ETES') }}
                
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->