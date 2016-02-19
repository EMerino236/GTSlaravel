<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>{{ HTML::link('/programacion_reportes/list_programacion_reportes','Asignación y control de reportes') }}</li>
            <li>
                <a href="#">Evaluación de necesidades, alernativas e instalaciones<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level"> 
                        <li>{{ HTML::link('/reporte_cn/list_reporte_cn','Necesidades') }}</li>
                        <li>
                            <a href="#">Instalación<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">                           
                                <li>{{ HTML::link('/reporte_priorizacion/list_reporte_priorizacion','Reporte de priorización') }}</li>
                                <li>{{ HTML::link('/reporte_paac/list_reporte_paac','Reporte para PAAC') }}</li>
                            </ul>
                        </li>
                    </ul>
            </li>
            <li>
                <a href="#">Evaluación económica<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">   
                    <li>
                        <a href="#">Elaboración de presupuesto<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('/cotizaciones/list_cotizacion','Precios referenciales de TS y bienes') }}</li>
                            <li>{{ HTML::link('/documentos_PAAC/list_documento_paac','Presupuesto de planes') }}</li>
                        </ul>  
                    </li>                  
                    <li>{{ HTML::link('/plan_director/list_documento_plan_director','Plan de ejecución') }}</li>
                </ul>                
            </li>            
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->