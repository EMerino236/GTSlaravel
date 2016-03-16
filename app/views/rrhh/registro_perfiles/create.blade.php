@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Registro de perfiles profesionales</h3>
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
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach					
		</div>
	@endif

	{{ Form::open(array('url'=>'registro_perfil.store', 'role'=>'form')) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('nombres')) has-error has-feedback @endif">
						{{ Form::label('nombres','Nombres') }}
						{{ Form::text('nombres',Input::old('nombres'),['class' => 'form-control'])}}
					</div>

					<div class="col-md-4 @if($errors->first('apellido_paterno')) has-error has-feedback @endif">
						{{ Form::label('apellido_paterno','Apellido Paterno') }}
						{{ Form::text('apellido_paterno',Input::old('apellido_paterno'),['class' => 'form-control'])}}
					</div>

					<div class="col-md-4 @if($errors->first('apellido_materno')) has-error has-feedback @endif">
						{{ Form::label('apellido_materno','Apellido Materno') }}
						{{ Form::text('apellido_materno',Input::old('apellido_materno'),['class' => 'form-control'])}}
					</div>

					<div class="col-md-4 @if($errors->first('dni')) has-error has-feedback @endif">
						{{ Form::label('dni','DNI') }}
						{{ Form::text('dni',Input::old('dni'),['class' => 'form-control'])}}
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
				<a class="btn btn-default btn-block" style="width:145px" href="{{route('acuerdo_convenio.index')}}">Cancelar</a>				
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