@extends('templates/userTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Usuario</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('username') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('apellido_pat') }}</strong></p>
			<p><strong>{{ $errors->first('apellido_mat') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_documento') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc_identidad') }}</strong></p>
			<p><strong>{{ $errors->first('idarea') }}</strong></p>
			<p><strong>{{ $errors->first('idrol') }}</strong></p>
			<p><strong>{{ $errors->first('genero') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_nacimiento') }}</strong></p>
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	{{ Form::open(array('url'=>'user/submit_create_user', 'role'=>'form')) }}
		<div class="row">
			<div class="form-group col-md-6 @if($errors->first('username')) has-error has-feedback @endif">
				{{ Form::label('username','Nombre de usuario') }}
				{{ Form::text('username',Input::old('username'),array('class'=>'form-control','placeholder'=>'Nombre de Usuario')) }}
			</div>	
			<div class="form-group col-md-6 @if($errors->first('nombre')) has-error has-feedback @endif">
				{{ Form::label('nombre','Nombres') }}
				{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control','placeholder'=>'Nombres')) }}
			</div>					
		</div>
		<div class="row">
			<div class="form-group col-md-6 @if($errors->first('apellido_pat')) has-error has-feedback @endif">
				{{ Form::label('apellido_pat','Apellido paterno') }}
				{{ Form::text('apellido_pat',Input::old('apellido_pat'),array('class'=>'form-control','placeholder'=>'Apellido Paterno')) }}
			</div>
			<div class="form-group col-md-6 @if($errors->first('apellido_mat')) has-error has-feedback @endif">
				{{ Form::label('apellido_mat','Apellido materno') }}
				{{ Form::text('apellido_mat',Input::old('apellido_mat'),array('class'=>'form-control','placeholder'=>'Apellido Materno')) }}
			</div>				
		</div>
		<div class="row">
			<div class="form-group col-md-6 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
				{{ Form::label('tipo_documento','Tipo de documento') }}
				{{ Form::select('tipo_documento',array(''=>'Seleccione')+ $tipos_documento,Input::old('idtipo_documento'),['class' => 'form-control']) }}
			</div>
			<div class="form-group col-md-6 @if($errors->first('numero_doc_identidad')) has-error has-feedback @endif">
				{{ Form::label('numero_doc_identidad','No. Documento de identidad') }}
				{{ Form::text('numero_doc_identidad',Input::old('numero_doc_identidad'),array('class'=>'form-control','placeholder'=>'Documento de Identidad')) }}
			</div>
					
		</div>
		<div class="row">
			<div class="form-group col-md-6 @if($errors->first('idrol')) has-error has-feedback @endif">
				{{ Form::label('genero','Género') }}
				{{ Form::select('genero', [''=>'Seleccione','M'=>'Masculino','F'=>'Femenino'],Input::old('genero'),['class' => 'form-control']) }}
			</div>
			<div class="col-md-6">
				{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
				<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
					{{ Form::text('fecha_nacimiento',Input::old('fecha_nacimiento'),array('class'=>'form-control','readonly'=>'','placeholder'=>'Fecha de Nacimiento')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
				
		</div>
		<div class="row">
			<div class="form-group col-md-6 @if($errors->first('email')) has-error has-feedback @endif">
				{{ Form::label('email','E-mail') }}
				{{ Form::text('email',Input::old('email'),array('class'=>'form-control','placeholder'=>'E-mail')) }}
			</div>
			<div class="form-group col-md-6 @if($errors->first('telefono')) has-error has-feedback @endif">
				{{ Form::label('telefono','Teléfono/Anexo') }}
				{{ Form::text('telefono',Input::old('telefono'),array('class'=>'form-control','placeholder'=>'Telefono')) }}
			</div>	
					
		</div>
		<div class="row">			
			<div class="form-group col-md-6 @if($errors->first('idarea')) has-error has-feedback @endif">
				{{ Form::label('idarea','Área') }}
				{{ Form::select('idarea',array(''=>'Seleccione')+$areas,Input::old('idarea'),['class' => 'form-control']) }}
			</div>	
			<div class="form-group col-md-6 @if($errors->first('idrol')) has-error has-feedback @endif">
				{{ Form::label('idrol','Rol') }}
				{{ Form::select('idrol',array(''=>'Seleccione')+ $roles,Input::old('idrol'),['class' => 'form-control']) }}
			</div>	
			
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				<span>*La contraseña será autogenerada y enviada al email ingresado.</span>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-edit','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/user/list_users')}}">Cancelar</a>				
			</div>
		</div>
	{{ Form::close() }}
@stop