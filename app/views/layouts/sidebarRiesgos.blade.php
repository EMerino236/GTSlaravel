<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{URL::to('/documentos_riesgos/list_documentos')}}">Planes</a>
            </li>
            <li>
                <a href="#">Gestión de Tecnovigilancia<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">   
                    <li>
                        <a href="#">Eventos Adversos<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('/eventos_adversos/list_eventos_adversos','Registro de eventos adversos') }}</li>                                                  
                            <li>{{ HTML::link('/reportes_investigacion/list_reportes_investigacion','Investigación y toma de acciones') }}</li>
                        </ul>  
                    </li>
                    <li>
                        <a href="#"> Gestión de riesgos en servicios clínicos<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('/ipers/list_ipers/1','Reporte de Identificación, Evaluación de riesgos TS por servicio clínico') }}</li>                                                  
                        </ul>  
                    </li> 
                     <li>
                        <a href="#"> Salud Ocupacional en TS: <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">                           
                            <li>{{ HTML::link('/ipers/list_ipers/2','IPER - Salud Ocupacional') }}</li>                                                  
                        </ul>  
                    </li> 
 
                </ul>                
            </li>
            <li>
                <a href="#">Verificación metrológica y ajustes de equipo médico y hospitalario<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">   
                    <li>
                        {{ HTML::link('/reportes_calibracion/list_reportes_calibracion','Certificado de Calibración') }}
                    </li> 
                </ul>                
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
  
    
    
