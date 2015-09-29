@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Agregar Proveedor</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('ruc') }}</strong></p>
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
			<p><strong>{{ $errors->first('idestado') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'proveedores/submit_create_proveedor', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('razon_social')) has-error has-feedback @endif">
					{{ Form::label('razon_social','Razón Social') }}
					{{ Form::text('razon_social',Input::old('razon_social'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('ruc')) has-error has-feedback @endif">
					{{ Form::label('ruc','RUC') }}
					{{ Form::text('ruc',Input::old('ruc'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idestado')) has-error has-feedback @endif">
					{{ Form::label('idestado','Área') }}
					{{ Form::select('idestado',$estados,Input::old('idestado'),['class' => 'form-control']) }}
				</div>
			</div>
			{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('/proveedores/list_proveedores','Cancelar',array('class'=>'')) }}
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',Input::old('telefono'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','E-mail') }}
					{{ Form::text('email',Input::old('email'),array('class'=>'form-control')) }}
				</div>
			</div>
		</div>
	{{ Form::close() }}
@stop