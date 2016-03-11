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
                                <li>{{ HTML::link('especificacion_tecnica/list_especificacion_tecnica','Especificaciones Técnicas') }}</li>
                                <li>{{ HTML::link('cotizaciones/list_cotizacion_adquisicion','Precios Referenciales') }}</li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Expediente Técnico<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">                           
                                <li>{{ HTML::link('expediente_tecnico/list_expediente_tecnicos','Expediente Técnico y Económico') }}</li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Verificación de Cumplimiento<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">                           
                                <li>{{ HTML::link('oferta_expediente/list_oferta_expedientes','Ofertas') }}</li>
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
                            <li>{{ HTML::link('miembro_comite/list_miembro_comites','Miembros de Comité') }}</li>
                            <li>{{ HTML::link('observacion_expediente/list_observacion_expedientes','Observaciones') }}</li>
                        </ul>  
                    </li>                  
                    <li>
                        <a href="#">Evaluación de Ofertas<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('oferta_evaluada_expediente/list_oferta_evaluada_expedientes','Reportes de Ofertas Evaluadas') }}</li>
                        </ul>  
                    </li> 
                    <li>
                        <a href="#">Adjudicación<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('adjudicacion_expediente/list_adjudicacion_expedientes','Adjudicaciones y Contratos Firmados') }}</li>
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