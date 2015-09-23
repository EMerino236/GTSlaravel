@extends('templates/loginTemplate')
@section('content')
	<h4 class="text-center">Ingrese a su cuenta</h4>
	<div id="message-container">
		@if (Session::has('error'))
			<div class="alert alert-danger">{{ Session::get('error') }}</div>
		@endif
		@if (Session::has('message'))
			<div class="alert alert-success">{{ Session::get('message') }}</div>
		@endif
	</div>
	<div id="login-container" class="bg-info">
		{{ Form::open(array('url'=>'login', 'role'=>'form')) }}
			<div class="form-group">
				{{ Form::label('usuario','Usuario') }}
				{{ Form::text('usuario',Input::old('usuario'),array('class'=>'form-control')) }}
			</div>
			<div class="form-group">
				{{ Form::label('password','Contraseña') }}
				{{ Form::password('password',array('class'=>'form-control')) }}
			</div>
			{{ Form::submit('Ingresar',array('id'=>'submit-login', 'class'=>'btn btn-lg btn-primary btn-block')) }}
		{{ Form::close() }}
	</div>
@stop