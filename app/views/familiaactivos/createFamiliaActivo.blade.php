@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nueva Familia de Activo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_equipo') }}</strong></p>
			<p><strong>{{ $errors->first('modelo') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_activo') }}</strong></p>
			<p><strong>{{ $errors->first('idmarca') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'familiaactivos/submit_create_familiaactivo', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idtipo_activo')) has-error has-feedback @endif">
					{{ Form::label('idtipo_activo','Tipo de Activo') }}
					{{ Form::select('idtipo_activo',$tipo_activo,Input::old('idtipo_activo'),['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
					{{ Form::label('nombre_equipo','Nombre de Equipo') }}
					{{ Form::text('nombre_equipo',Input::old('nombre_equipo'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			</div>		
		</div>

		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idmarca')) has-error has-feedback @endif">
					{{ Form::label('idmarca','Marca') }}
					{{ Form::select('idmarca', $marca,Input::old('idmarca'),['class' => 'form-control']) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('modelo')) has-error has-feedback @endif">
					{{ Form::label('modelo','Modelo') }}
					{{ Form::text('modelo',Input::old('modelo'),array('class'=>'form-control')) }}
				</div>
			</div>
		</div>
	{{ Form::close() }}
@stop