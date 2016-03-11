<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                {{ HTML::linkRoute('plan_desarrollo.index','Planes de Desarrollo de RR.HH. para GTS') }}
            </li>            

            <li>
                <a href="#">Gestión de Capacitaciones<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">                       
                    <li>
                        <a href="#">Identificación de programas de capacitación<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>{{ HTML::linkRoute('capacitacion.index','Listado de capacitaciones') }}</li>
                            <li>{{ HTML::link('#','Indicadores de capacitación') }}</li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Gestión interinstitucional para capacitación, financiamiento y difusión de los programas<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>{{ HTML::linkRoute('acuerdo_convenio.index','Acuerdos y convenios de asociación con entidades') }}</li>
                            <li>{{ HTML::linkRoute('planteamiento_difusion.index','Planteamiento de disfusión por programa') }}</li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Gestión logística, seguimiento, control de las actividades de capacitación<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>{{ HTML::link('#','Materiales y herramientas para capacitaciones') }}</li>
                            <li>{{ HTML::link('#','Certificación del programa de capacitación') }}</li>
                            <li>{{ HTML::link('#','Indicadores de gestión logística, seguimiento y control de capacitaciones en TS actualizados ') }}</li>
                            <li>{{ HTML::link('#','Reporte de supervisión de ejecución de capacitación') }}</li>
                        </ul>
                    </li>
                </ul>                
            </li>
            
            <li>
                <a href="#">Diseño de Programas de Capacitación para Usuarios y personal de GTS<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Gestión de docentes, asistentes de docencia e investigadores<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>{{ HTML::link('#','RRHH para capacitaciones y proyectos') }}</li>
                            <li>{{ HTML::link('#','Programación de docentes para capacitaciones') }}</li>
                            <li>{{ HTML::link('#','Registro de perfiles profesionales') }}</li>                            
                        </ul>
                    </li>
                    <li>
                        <a href="#">Elaboración del presupuesto por actividad<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>{{ HTML::linkRoute('presupuesto_capacitacion.index','Presupuesto de capacitación formulado por actividad de capacitación') }}</li>                            
                        </ul>
                    </li>
                    <li>
                        <a href="#">Gestión de internado / residentado / PSP en TS<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>{{ HTML::linkRoute('programacion_internado.index','Programación por servicio clínico') }}</li>
                            <li>{{ HTML::link('#','Indicadores de Gestión') }}</li>
                        </ul>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->