@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Servicio Clínico</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('servicio') }}</strong></p>
			<p><strong>{{ $errors->first('usuario') }}</strong></p>
			<p><strong>{{ $errors->first('codigo') }}</strong></p>
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(['route'=>'servicios_clinicos.store', 'role'=>'form', 'files'=>true]) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del servicio</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 @if($errors->first('servicio')) has-error has-feedback @endif">
						{{ Form::label('servicio','Servicio') }}
						{{ Form::select('servicio',$servicios,Input::old('servicio'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-6 @if($errors->first('usuario')) has-error has-feedback @endif">
						{{ Form::label('usuario','Usuario') }}
						{{ Form::select('usuario',$usuarios,Input::old('usuario'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-6 @if($errors->first('codigo')) has-error has-feedback @endif">
						{{ Form::label('codigo','Código de Archivamiento') }}
						{{ Form::text('codigo',Input::old('codigo'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-6 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Adjuntar Archivo</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>		
		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
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