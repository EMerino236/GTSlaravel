@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Materiales para la Sesión</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('infraestructura') }}</strong></p>
			<p><strong>{{ $errors->first('equipo') }}</strong></p>
			<p><strong>{{ $errors->first('herramienta') }}</strong></p>
			<p><strong>{{ $errors->first('insumo') }}</strong></p>
			<p><strong>{{ $errors->first('equipo_personal') }}</strong></p>
			<p><strong>{{ $errors->first('condicion_seguridad') }}</strong></p>
		</div>
	@endif
	
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">				
				<div class="form-group row">
					<div class="col-md-12 @if($errors->first('infraestructura')) has-error has-feedback @endif">
						{{ Form::label('infraestructura','Infraestructura (MAX:500 Caracteres)') }}
						{{ Form::textarea('infraestructura',$material_sesion->infraestructura,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none', 'readonly' => 'true'])}}						
					</div>								
				</div>
				<div class="form-group row">
					<div class="col-md-12 @if($errors->first('equipo')) has-error has-feedback @endif">
						{{ Form::label('equipo','Equipos (MAX:500 Caracteres)') }}
						{{ Form::textarea('equipo',$material_sesion->equipos,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none', 'readonly' => 'true'])}}						
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12 @if($errors->first('herramienta')) has-error has-feedback @endif">
						{{ Form::label('herramienta','Herramientas (MAX:500 Caracteres)') }}
						{{ Form::textarea('herramienta',$material_sesion->herramientas,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none', 'readonly' => 'true'])}}						
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('insumo')) has-error has-feedback @endif">
						{{ Form::label('insumo','Insumos (MAX:500 Caracteres)') }}
						{{ Form::textarea('insumo',$material_sesion->insumos,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none', 'readonly' => 'true'])}}
					</div>
				</div>				
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('equipo_personal')) has-error has-feedback @endif">
						{{ Form::label('equipo_personal','Equipo Personal (MAX:500 Caracteres)') }}
						{{ Form::textarea('equipo_personal',$material_sesion->equipopersonal,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none', 'readonly' => 'true'])}}
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('condicion_seguridad')) has-error has-feedback @endif">
						{{ Form::label('condicion_seguridad','Condiciones de Seguridad (MAX:500 Caracteres)') }}
						{{ Form::textarea('condicion_seguridad',$material_sesion->condicionesseguridad,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none', 'readonly' => 'true'])}}
					</div>
				</div>								
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-md-4">
				<a class="btn btn-warning btn-block btn-md" style="width:145px; float: left" href="{{route('material.edit',$material_sesion->idsesion)}}">
				<span class="glyphicon glyphicon-pencil"></span> Editar</a>
			</div>
			<div class="col-md-offset-4 col-md-4">
				<a class="btn btn-default btn-block btn-md" style="width:145px; float: right" href="{{route('capacitacion.show_sesiones',$material_sesion->sesion->id_capacitacion)}}">
				<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
			</div>
	</div>	
@stop