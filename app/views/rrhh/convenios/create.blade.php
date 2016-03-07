@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Plan de Desarrollo de RRHH</h3>
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
		</div>
	@endif

	{{ Form::open(array('url'=>'#', 'role'=>'form')) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('nombre_documento')) has-error has-feedback @endif">
						{{ Form::label('nombre_documento','Nombre de Documento') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_documento',Input::old('nombre_documento'),['class' => 'form-control'])}}						
					</div>								
					<div class="col-md-4 @if($errors->first('autor_documento')) has-error has-feedback @endif">
						{{ Form::label('autor_documento','Autor') }}<span style='color:red'>*</span>
						{{ Form::text('autor_documento',Input::old('autor_documento'),['class' => 'form-control'])}}						
					</div>
					<div class="col-md-4 @if($errors->first('codigo_documento')) has-error has-feedback @endif">
						{{ Form::label('codigo_documento','Código de Archivamiento') }}<span style='color:red'>*</span>
						{{ Form::text('codigo_documento',Input::old('codigo_documento'),['class' => 'form-control'])}}						
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('descripcion_documento')) has-error has-feedback @endif">
						{{ Form::label('descripcion_documento','Descripción (MAX:200 Caracteres)') }}
						{{ Form::textarea('descripcion_documento',Input::old('descripcion_documento'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
					</div>
				</div>				
			</div>
		</div>
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => '145px')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" sytle="width:145px" href="{{route('plan_desarrollo.index')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}
@stop