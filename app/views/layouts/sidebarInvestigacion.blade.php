<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                {{ HTML::link('programacion_guias/list_programacion_guias','Programación de elaboración de Guías y Reporte ETES') }}
            </li>
            <li>
                {{ HTML::link('documento_investigacion/list_documentos','Repositorio de documentos de módulo de investigación') }}
                
            </li>

            <li>
                <a href="#">Diseño de procesos y procedimientos de GTS<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">   
                    <li>{{ HTML::link('mapa_procesos/list_procesos','Mapa de procesos y procedimientos GTS (con definición e indicadores GTS) ') }}</li>
                    <li>
                        <a href="#">Plantillas<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>{{ HTML::link('plantillas_servicios/list_servicios','Plantillas de inspecciones de servicios') }}</li>
                            <li>{{ HTML::link('plantillas_mant_preventivo/list_mantenimientos','Plantillas de mantenimiento') }}</li>
                            <!--<li>{{ HTML::link('#','Plantillas de inspecciones de infraestructura ') }}</li>-->
                            <!--<li>{{ HTML::link('#','Plantillas de inspecciones hospitalario ') }}</li>-->
                        </ul>
                    </li>
                    <!--
                    <li>{{ HTML::link('#','Indicadores de diseño de procesos y procedimientos') }}</li>
                    -->
                </ul>                
            </li>
            
            <li>
                <a href="#">Elaboración de Guía <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>{{ HTML::link('guias_clinica_gpc/list_guias','Guía de Práctica Clínica') }}</li>
                    <li>{{ HTML::link('guias_tecno_salud/list_guias','Guía de Práctica de Tecnologías de Salud') }}</li>
                    <li>{{ HTML::link('/reporte_etes/list_reporte_etes','ETES de procedimientos clínicos') }}</li>
                    <!--
                    <li>{{ HTML::link('#','Indicadores de elaboración de guía de práctica clínica') }}</li>
                    -->
                </ul>
            </li>

            
            <li>
                {{ HTML::linkRoute('servicios_clinicos.index','Diseño de servicio clinico') }}
            </li>
            

            <li>
                <a href="#">Identificación de problemáticas, desarrollo de líneas de investigación e identificación de oportunidades de financiamiento <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">                           
                    <li>{{ HTML::linkRoute('reporte_financiamiento.index','Reporte que certifica la problemática e identificación de financiamiento') }}</li>
                    <li>{{ HTML::linkRoute('reporte_desarrollo.index','Reporte de desarrollo de línea de investigación') }}</li>
                    <li>{{ HTML::linkRoute('requerimientos_clinicos.index','Requerimientos clínicos') }}</li>
                    <!--
                    <li>{{ HTML::link('#','Requerimientos hospitalarios') }}</li>
                    <li>{{ HTML::link('#','Indicadores de investigación') }}</li>
                    -->
                </ul>
            </li>

            <li>
                {{ HTML::linkRoute('proyecto.index','Formulación y planificación de proyectos de investigación') }}
            </li>
            
            
            <li>
                <a href="#">Ejecución, control, cierre  y modificaciones de proyectos de investigación de TS y propiedad intelectual<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>{{ HTML::linkRoute('proyecto_documentacion.index','Documentación general de proyectos') }}</li>
                    
                    <li>{{ HTML::linkRoute('plan_aprendizaje.index','Plan de aprendizaje proyectos de investigación de TS') }}</li>
                    {{--
                    <li>{{ HTML::link('#','Informe económico del proyecto') }}</li>
                    
                    <li>{{ HTML::link('#','Indicadores de proyecto') }}</li>
                    --}}
                </ul>
            </li>
           
            <li>
                <a href="#">Gestión de transferencia de tecnología en salud desarrollada<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                     <!--
                    <li>{{ HTML::link('#','Indicadores de TTS') }}</li>                    
                    -->
                    <li>{{ HTML::linkRoute('reporte_seguimiento.index','Reporte de seguimiento y control de TTS y cronograma') }}</li>
                </ul>
            </li>
            
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->