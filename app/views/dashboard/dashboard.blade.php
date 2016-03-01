

@extends('templates/dashboardTemplate')
@section('content')
    
        <div class="col-md-12">
<!--            <h3 class="page-header">Bienvenido al sistema GTS</h3>-->

            <div id="divCircle">
                <div id="gts-logo"><img src="{{asset('img')}}/logo_gts.png" id="logo-gts"/></div>
                <font size=5><a href="{{ URL::to('planeamiento') }}" id="link-planeamiento"><i class="fa fa-calendar fa-fw"></i> Planeamiento</a></font>
                <font size=5><a href="{{ URL::to('adquisicion') }}" id="link-adquisicion"><i class="fa fa-credit-card fa-fw"></i> Adquisición</a></font>
                <font size=5><a href="{{ URL::to('bienes') }}" id="link-bienes"><i class="fa fa-wrench fa-fw"></i> Bienes </a></font>
                <font size=5><a href="{{ URL::to('riesgos') }}" id="link-riesgos"><i class="fa fa-bomb fa-fw"></i> Riesgos</a></font>
                <font size=5><a href="{{ URL::to('investigacion') }}" id="link-investigacion"><i class="fa fa-graduation-cap fa-fw"></i> Investigación</a></font>
                <font size=5><a href="{{ URL::to('#') }}" id="link-rrhh"><i class="fa fa-users fa-fw"></i> RRHH</a></font>
                <a href="{{ URL::to('mision_vision') }}" id="logo-mision-vision"><img src="{{asset('img')}}/MisionVision.jpg"/></a>
                <font size=3><a href="#" id="font-misionVision">Misión y Visión</a></font>
                <a href="{{ URL::to('acerca_desarrollo') }}" id="logo-acerca-desarrollo"><img src="{{asset('img')}}/AcercaDesarrollo.jpg"/></a>
                <font size=3><a href="#" id="font-acercaDesarrollo">Acerca del Desarrollo</a></font>
            </div>
        </div>
    
@stop        