

@extends('templates/misionVisionTemplate')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h3 class="page-header">Misión y Visión</h3>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-6" style="margin-left:20px;margin-top:20px;">
            <font size=4>Mision:</font>
            <p style="background-color:#f2f2f2; text-align:justify;">Brindar las herramientas necesarias 
                para una adecuada gestión de tecnología en establecimientos de salud en el Perú a través 
                del desarrollo e implementación de procesos validados.</p>
        </div>
        <div class="col-md-2">
            <img heigth= "150" width="150" src="{{asset('img')}}/mision.jpe"/>
        </div>
    </div>  
    <div class="row">
        <div class="col-md-6" style="margin-left:20px;margin-top:50px;">
            <font size=4>Visión:</font>
            <p style="background-color:#f2f2f2; text-align:justify;">Implementar los procesos y la plataforma 
                informática en los establecimientos de salud del Perú.</p>
        </div>
        <div class="col-md-2">
            <img heigth= "190" width="190" src="{{asset('img')}}/vision.jpg"/>
        </div>
    </div>  
    <div class="row">
        <div class="form-group col-md-2">
            <a class="btn btn-default btn-block" href="{{URL::to('/dashboard')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>                
        </div>
    </div>  
@stop        