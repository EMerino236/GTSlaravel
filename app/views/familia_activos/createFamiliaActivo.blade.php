@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nueva Familia de Equipo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_equipo') }}</strong></p>
			<p><strong>{{ $errors->first('modelo') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_activo') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_siga') }}</strong></p>
		</div>
	@endif

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

	{{ Form::open(array('url'=>'familia_activos/submit_create_familia_activo', 'role'=>'form')) }}
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">
			  		<div class="row">
			  			<div class="form-group col-md-6 @if($errors->first('idtipo_activo')) has-error has-feedback @endif">
			  				{{ Form::label('idtipo_activo','Tipo de Activo') }}<span style="color:red">*</span>
							{{ Form::select('idtipo_activo',array('' => 'Seleccione') + $tipo_activo,Input::old('idtipo_activo'),['class' => 'form-control']) }}
			  			</div>

			  			<div class="form-group col-md-6 @if($errors->first('idmarca')) has-error has-feedback @endif">
							{{ Form::label('idmarca','Marca') }}<span style="color:red">*</span>
							{{ Form::select('idmarca',array('' => 'Seleccione') + $marca,Input::old('idmarca'),['class' => 'form-control']) }}
						</div>
			  		</div>
			  		<div class="row">
			  			<div class="form-group col-md-6 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
							{{ Form::label('nombre_equipo','Nombre de Equipo') }}<span style="color:red">*</span>
							{{ Form::text('nombre_equipo',Input::old('nombre_equipo'),array('class'=>'form-control')) }}
						</div>

						<div class="form-group col-md-6 @if($errors->first('nombre_siga')) has-error has-feedback @endif">
							{{ Form::label('nombre_siga','Nombre SIGA') }}<span style="color:red">*</span>
							{{ Form::text('nombre_siga',Input::old('nombre_siga'),array('class'=>'form-control')) }}
						</div>
			  		</div>
				</div>
			</div>

			<div class="container-fluid row">
				<div class="form-group col-md-2 col-md-offset-8">				
					{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/familia_activos/list_familia_activos')}}">Cancelar</a>				
				</div>
			</div>
	{{ Form::close() }}
@stop