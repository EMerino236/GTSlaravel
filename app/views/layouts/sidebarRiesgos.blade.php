<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{URL::to('/documentos_riesgos/list_documentos')}}">Planes para la Gestión de Riesgos de la tecnología</a>
            </li>
            <li>
                <a href="#">Gestión de Tecnovigilancia<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">   
                    <li>
                        <a href="#">Eventos Adversos  de TS: Registro e investigación de incidentes<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('/eventos_adversos/list_eventos_adversos','Registro de eventos adversos actualizado (digitalización / copiado de ficha)') }}</li>
                            
                        </ul>  
                    </li> 
                </ul>                
            </li>
            <li>
                <a href="#">Verificación metrológica y ajustes de equipo médico y hospitalario<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">   
                    <li>
                        <a href="#">Calibración: dado por entidad acreditada<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('/reportes_calibracion/list_reportes_calibracion','Certificado de Calibración') }}</li>
                            
                        </ul>  
                    </li> 
                </ul>                
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
  
    
    
