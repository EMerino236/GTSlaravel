<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                {{ HTML::link('documento_investigacion/list_documentos','Repositorio de documentos de módulo de investigación') }}
                
            </li>
            <li>
                <a href="#">Diseño de procesos y procedimientos de GTS<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">   
                    <li>{{ HTML::link('#','Mapa de procesos y procedimientos GTS (con definición e indicadores GTS) ') }}</li>
                    <li>{{ HTML::link('plantillas_servicios/list_servicios','Plantillas de inspecciones de servicios') }}</li>
                    <li>{{ HTML::link('#','Plantillas de inspecciones de infraestructura ') }}</li>
                    <li>{{ HTML::link('#','Plantillas de inspecciones hospitalario ') }}</li>
                    <li>{{ HTML::link('#','Indicadores de diseño de procesos y procedimientos') }}</li>
                </ul>                
            </li>
            <li>
                <a href="#">Elaboración de Guía de Práctica Clínica GPC  y ETES de procedimientos clínicos<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">                           
                    <li>{{ HTML::link('#','Indicadores de elaboración de guía de práctica clínica  ') }}</li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->