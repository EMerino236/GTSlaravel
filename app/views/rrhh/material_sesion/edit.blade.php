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

	{{ Form::open(array('route'=>array('material.update',$material_sesion->id), 'role'=>'form')) }}
	{{ Form::hidden('idcapacitacion')}}	
	{{ Form::hidden('idsesion')}}	
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">				
				<div class="form-group row">
					<div class="col-md-12 @if($errors->first('infraestructura')) has-error has-feedback @endif">
						{{ Form::label('infraestructura','Infraestructura (MAX:500 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('infraestructura',$material_sesion->infraestructura,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}						
					</div>								
				</div>
				<div class="form-group row">
					<div class="col-md-12 @if($errors->first('equipo')) has-error has-feedback @endif">
						{{ Form::label('equipo','Equipos (MAX:500 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('equipo',$material_sesion->equipos,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}						
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12 @if($errors->first('herramienta')) has-error has-feedback @endif">
						{{ Form::label('herramienta','Herramientas (MAX:500 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('herramienta',$material_sesion->herramientas,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}						
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('insumo')) has-error has-feedback @endif">
						{{ Form::label('insumo','Insumos (MAX:500 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('insumo',$material_sesion->insumos,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}
					</div>
				</div>				
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('equipo_personal')) has-error has-feedback @endif">
						{{ Form::label('equipo_personal','Equipo Personal (MAX:500 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('equipo_personal',$material_sesion->equipopersonal,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('condicion_seguridad')) has-error has-feedback @endif">
						{{ Form::label('condicion_seguridad','Condiciones de Seguridad (MAX:500 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('condicion_seguridad',$material_sesion->condicionesseguridad,['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}
					</div>
				</div>								
			</div>
		</div>
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => 'width:145px')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" style="width:145px" href="{{route('material.show',$material_sesion->idsesion)}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}	
@stop