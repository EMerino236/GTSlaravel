<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="#">Evaluación de necesidades, alernativas e instalaciones<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">                           
                    <li>
                        <li>{{ HTML::link('/reporte_cn/list_reporte_cn','Necesidades') }}</li>
                        <li>{{ HTML::link('/reporte_etes/list_reporte_etes','Alternativas') }}</li>
                        <li>{{ HTML::link('/reporte_paac/list_reporte_paac','Instalación') }}</li>
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
                            <li>{{ HTML::link('/documentos_PAAC/list_documento_paac','Elaboración de presupuesto para PAAC') }}</li>
                        </ul>  
                    </li>                  
                    <li>{{ HTML::link('/plan_director/list_documento_plan_director','Plan de ejecución') }}</li>
                </ul>                
            </li>
            <li>{{ HTML::link('#','Asignación y control de reportes') }}</li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->