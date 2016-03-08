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
			<p><strong>{{ $errors->first('nombre_documento') }}</strong></p>
			<p><strong>{{ $errors->first('autor_documento') }}</strong></p>
			<p><strong>{{ $errors->first('codigo_documento') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_documento') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	{{ Form::open(array('route'=>'plan_desarrollo.store', 'role'=>'form', 'files'=>true)) }}		
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

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Adjuntar Archivo</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8 @if($errors->first('archivo')) has-error has-feedback @endif">
					<label class="control-label">Seleccione un Documento </label><span style='color:red'>*</span><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="right" title="Formatos Permitidos: png, jpe, jpeg, jpg, gif, bmp, zip, rar, pdf, doc, docx, xls, xlsx, ppt, pptx"></span>
					<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => 'width:145px')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" style="width:145px" href="{{route('plan_desarrollo.index')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}

	<script>
	$("#input-file").fileinput({
	    language: "es",
	    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
	});
	</script>
@stop