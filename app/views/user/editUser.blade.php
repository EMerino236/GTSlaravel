@extends('templates/userTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Usuario: <strong>{{$user_info->username}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
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
			<p><strong>{{ $errors->first('password') }}</strong></p>
			<p><strong>{{ $errors->first('password_confirmation') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'user/submit_edit_user', 'role'=>'form')) }}
		{{ Form::hidden('user_id', $user_info->id) }}

		<div class="col-xs-6">

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','E-mail') }}
					@if($user_info->deleted_at)
						{{ Form::text('email',$user_info->email,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('email',$user_info->email,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idarea')) has-error has-feedback @endif">
					{{ Form::label('idarea','Área') }}
					@if($user_info->deleted_at)
						{{ Form::select('idarea', $areas,$user_info->idarea,['class' => 'form-control','readonly'=>'']) }}
					@else
						{{ Form::select('idarea', $areas,$user_info->idarea,['class' => 'form-control']) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idrol')) has-error has-feedback @endif">
					{{ Form::label('idrol','Rol') }}
					@if($user_info->deleted_at)
						{{ Form::select('idrol', $roles,$user_info->idrol,['class' => 'form-control','readonly'=>'']) }}
					@else
						{{ Form::select('idrol', $roles,$user_info->idrol,['class' => 'form-control']) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idrol')) has-error has-feedback @endif">
					{{ Form::label('genero','Género') }}
					@if($user_info->deleted_at)
						{{ Form::select('genero', ['M'=>'Masculino','F'=>'Femenino'],$user_info->genero,['class' => 'form-control','readonly'=>'']) }}
					@else
						{{ Form::select('genero', ['M'=>'Masculino','F'=>'Femenino'],$user_info->genero,['class' => 'form-control']) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('password')) has-error has-feedback @endif">
					{{ Form::label('password','Cambiar contraseña') }}
					@if($user_info->deleted_at)
						{{ Form::password('password',array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::password('password',array('class'=>'form-control')) }}
					@endif
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('password_confirmation')) has-error has-feedback @endif">
					{{ Form::label('password_confirmation','Confirmar contraseña') }}
					@if($user_info->deleted_at)
						{{ Form::password('password_confirmation',array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::password('password_confirmation',array('class'=>'form-control')) }}
					@endif
				</div>
			</div>
			@if(!$user_info->deleted_at)
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			@endif		
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombres') }}
					@if($user_info->deleted_at)
						{{ Form::text('nombre',$user_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('nombre',$user_info->nombre,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellido_pat')) has-error has-feedback @endif">
					{{ Form::label('apellido_pat','Apellido paterno') }}
					@if($user_info->deleted_at)
						{{ Form::text('apellido_pat',$user_info->apellido_pat,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('apellido_pat',$user_info->apellido_pat,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('apellido_mat')) has-error has-feedback @endif">
					{{ Form::label('apellido_mat','Apellido materno') }}
					@if($user_info->deleted_at)
						{{ Form::text('apellido_mat',$user_info->apellido_mat,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('apellido_mat',$user_info->apellido_mat,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
					{{ Form::label('tipo_documento','Tipo de documento') }}
					@if($user_info->deleted_at)
						{{ Form::select('tipo_documento', $tipos_documento,$user_info->idtipo_documento,['class' => 'form-control','readonly'=>'']) }}
					@else
						{{ Form::select('tipo_documento', $tipos_documento,$user_info->idtipo_documento,['class' => 'form-control']) }}
					@endif
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('numero_doc_identidad')) has-error has-feedback @endif">
					{{ Form::label('numero_doc_identidad','No. Documento de identidad') }}
					@if($user_info->deleted_at)
						{{ Form::text('numero_doc_identidad',$user_info->numero_doc_identidad,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('numero_doc_identidad',$user_info->numero_doc_identidad,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>

			<div class="row">
				{{ Form::label('fecha_nacimiento','Cambiar fecha de nacimiento') }}
				<div id="datetimepicker1" class="form-group input-group date col-xs-8 @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
					{{ Form::text('fecha_nacimiento',$user_info->fecha_nacimiento,array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
		</div>
	{{ Form::close() }}
	@if($user_info->deleted_at)
		{{ Form::open(array('url'=>'user/submit_enable_user', 'role'=>'form')) }}
			{{ Form::hidden('user_id', $user_info->id) }}
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
					</div>
				</div>	
			</div>	
		{{ Form::close() }}
	@else
		{{ Form::open(array('url'=>'user/submit_disable_user', 'role'=>'form')) }}
			{{ Form::hidden('user_id', $user_info->id) }}
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
					</div>
				</div>	
			</div>	
		{{ Form::close() }}
	@endif
@stop