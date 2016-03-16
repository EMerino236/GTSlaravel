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

	{{ Form::open(array('route'=>'registro_perfil.store', 'role'=>'form')) }}		
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
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('dni')) has-error has-feedback @endif">
					{{ Form::label('dni','DNI') }}
					{{ Form::text('dni',Input::old('dni'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('pais')) has-error has-feedback @endif">
					{{ Form::label('pais','Pais de nacimiento') }}
					{{ Form::select('pais_nacimiento',$paises,Input::old('pais'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('genero')) has-error has-feedback @endif">
					{{ Form::label('genero','Genero') }}
					{{ Form::select('genero',[0=>'Masculino',1=>'Femenino'],Input::old('genero'),['class' => 'form-control'])}}
				</div>
			</div>
	
			<div class="row">
				<div class="form-group col-md-4 @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
					{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
					<div id="datetimepicker3" class="form-group input-group date">
						{{ Form::text('fecha_nacimiento',Input::old('fecha_nacimiento'),array('class'=>'form-control', 'readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>

				<div class="col-md-4 @if($errors->first('domicilio')) has-error has-feedback @endif">
					{{ Form::label('pais_residencia','Pais de residencia') }}
					{{ Form::select('pais_residencia',$paises,Input::old('pais_residencia'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('domicilio')) has-error has-feedback @endif">
					{{ Form::label('domicilio','Domicilio') }}
					{{ Form::text('domicilio',Input::old('domicilio'),['class' => 'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Telefono') }}
					{{ Form::number('telefono',Input::old('telefono'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('celular')) has-error has-feedback @endif">
					{{ Form::label('celular','Celular') }}
					{{ Form::number('celular',Input::old('celular'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','Email') }}
					{{ Form::email('email',Input::old('email'),['class' => 'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('web')) has-error has-feedback @endif">
					{{ Form::label('web','Web Personal') }}
					{{ Form::text('web',Input::old('web'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('institucion')) has-error has-feedback @endif">
					{{ Form::label('institucion','Institución donde pertenece') }}
					{{ Form::text('institucion',Input::old('institucion'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('rol')) has-error has-feedback @endif">
					{{ Form::label('rol','Rol donde pertenece') }}
					{{ Form::select('rol', [0=>'Docente',1=>'Investigador',2=>'Interno'],Input::old('rol'),['class' => 'form-control'])}}
				</div>
			</div>
		</div>

		<div class="panel-heading">Formación Academica</div>
	  	<div class="panel-body">	
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('grado')) has-error has-feedback @endif">
					{{ Form::label('grado','Grado Obtenido') }}
					{{ Form::select('grado',[0=>'Bachiller',1=>'Titulado',2=>'Magister',3=>'Doctorado'],Input::old('grado'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('nombre_grado')) has-error has-feedback @endif">
					{{ Form::label('nombre_grado','Nombre del titulo o grado') }}
					{{ Form::text('nombre_grado',Input::old('nombre_grado'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('centro_estudios')) has-error has-feedback @endif">
					{{ Form::label('centro_estudios','Centro de estudios') }}
					{{ Form::text('centro_estudios',Input::old('centro_estudios'),['class' => 'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('pais_estudios')) has-error has-feedback @endif">
					{{ Form::label('pais_estudios','Pais de Estudios') }}
					{{ Form::select('pais_estudios',$paises,Input::old('pais_estudios'),['class' => 'form-control'])}}
				</div>

				<div class="form-group col-md-4 @if($errors->first('fecha_inicio')) has-error has-feedback @endif">
					{{ Form::label('fecha_inicio','Fecha Inicio') }}
					<div id="datetimepicker1" class="form-group input-group date">
						{{ Form::text('fecha_inicio',Input::old('fecha_inicio'),array('class'=>'form-control', 'readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>

				<div class="form-group col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
					{{ Form::label('fecha_fin','Fecha Fin') }}
					<div id="datetimepicker2" class="form-group input-group date">
						{{ Form::text('fecha_fin',Input::old('fecha_fin'),array('class'=>'form-control', 'readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Adjuntar Archivo</h3>
				</div>
				<div class="panel-body">
					<div class="col-md-8 @if($errors->first('archivos')) has-error has-feedback @endif">
						<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
						<input name="archivos[]" id="input-file" type="file" class="file file-loading" data-show-upload="false">
					</div>
				</div>	
			</div>
		</div>
		
		<!--
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
		-->
	</div>

	<div class="row">
		<div class="form-group col-md-2">
			{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
		</div>
		<div class="form-group col-md-offset-8 col-md-2">
			<a class="btn btn-default btn-block" href="{{route('registro_perfil.index')}}">Cancelar</a>				
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