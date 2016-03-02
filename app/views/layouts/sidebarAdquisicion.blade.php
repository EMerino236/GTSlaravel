<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="#">Planes de Adquisición<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level"> 
                        <li>{{ HTML::link('plan_mejora_proceso/list_plan_mejora_procesos','Plan de Mejora') }}</li>
                        <li>{{ HTML::link('programacion_compra/list_programacion_compras','Programación de Compras y Contrataciones') }}</li>
                    </ul>
            </li>
            <li>
                <a href="#">Convocatoria<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level"> 
                        <li>
                            <a href="#">Elaboración de Especificaciones Técnicas<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">                           
                                <li>{{ HTML::link('#','Especificaciones Técnicas') }}</li>
                                <li>{{ HTML::link('cotizaciones/list_cotizacion_adquisicion','Precios Referenciales') }}</li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Expediente Técnico<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">                           
                                <li>{{ HTML::link('#','Expediente Técnico y Económico') }}</li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Verificación de Cumplimiento<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">                           
                                <li>{{ HTML::link('#','Ofertas') }}</li>
                            </ul>
                        </li>
                    </ul>
            </li>
            <li>
                <a href="#">Evaluación<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">   
                    <li>
                        <a href="#">Comité<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('#','Miembros de Comité') }}</li>
                            <li>{{ HTML::link('#','Observaciones') }}</li>
                            <li>{{ HTML::link('#','Impugnaciones') }}</li>
                            <li>{{ HTML::link('#','Penalizaciones') }}</li>
                        </ul>  
                    </li>                  
                    <li>
                        <a href="#">Evaluación de Ofertas<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('#','Reportes de Ofertas Evaluadas') }}</li>
                        </ul>  
                    </li> 
                    <li>
                        <a href="#">Adjudicación<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('#','Adjudicaciones y Contratos Firmados') }}</li>
                        </ul>  
                    </li> 
                    <li>
                        <a href="#">Recepción<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('#','TS comprados y recibidos') }}</li>
                            <li>{{ HTML::link('#','Indicadores') }}</li>
                        </ul>  
                    </li> 
                </ul>                
            </li>            
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->