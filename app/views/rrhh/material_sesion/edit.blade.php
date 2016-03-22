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

	{{ Form::open(array('route'=>'material.store', 'role'=>'form')) }}
	{{ Form::hidden('idcapacitacion')}}	
	{{ Form::hidden('idsesion')}}	
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">				
				<div class="form-group row">
					<div class="col-md-12 @if($errors->first('infraestructura')) has-error has-feedback @endif">
						{{ Form::label('infraestructura','Infraestructura (MAX:500 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('infraestructura',Input::old('infraestructura'),['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}						
					</div>								
				</div>
				<div class="form-group row">
					<div class="col-md-12 @if($errors->first('equipo')) has-error has-feedback @endif">
						{{ Form::label('equipo','Equipos (MAX:500 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('equipo',Input::old('equipo'),['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}						
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12 @if($errors->first('herramienta')) has-error has-feedback @endif">
						{{ Form::label('herramienta','Herramientas (MAX:500 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('herramienta',Input::old('herramienta'),['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}						
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('insumo')) has-error has-feedback @endif">
						{{ Form::label('insumo','Insumos (MAX:500 Caracteres)') }}
						{{ Form::textarea('insumo',Input::old('insumo'),['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}
					</div>
				</div>				
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('equipo_personal')) has-error has-feedback @endif">
						{{ Form::label('equipo_personal','Equipo Personal (MAX:500 Caracteres)') }}
						{{ Form::textarea('equipo_personal',Input::old('equipo_personal'),['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('condicion_seguridad')) has-error has-feedback @endif">
						{{ Form::label('condicion_seguridad','Condiciones de Seguridad (MAX:500 Caracteres)') }}
						{{ Form::textarea('condicion_seguridad',Input::old('condicion_seguridad'),['class' => 'form-control','maxlength'=>'500','style'=>'resize:none'])}}
					</div>
				</div>								
			</div>
		</div>
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => 'width:145px')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" style="width:145px" href="{{route('capacitacion.index')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}	
@stop