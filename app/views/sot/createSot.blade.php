@extends('templates/sotTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Generar Solicitud de Orden de Trabajo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('cod_pat') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_solicitud') }}</strong></p>
			<p><strong>{{ $errors->first('especificacion_servicio') }}</strong></p>
			<p><strong>{{ $errors->first('idestado') }}</strong></p>
			<p><strong>{{ $errors->first('motivo') }}</strong></p>
			<p><strong>{{ $errors->first('justificacion') }}</strong></p>
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

	{{ Form::open(array('url'=>'sot/submit_create_sot', 'role'=>'form')) }}
		<div class="row">
			<div class="form-group col-md-12">
				{{ Form::label('solicitante','Usuario solicitante: '.$user->apellido_pat." ".$user->apellido_mat.", ".$user->nombre." ") }}
			</div>
		</div>

		<div class="panel panel-default">
		  	<div class="panel-heading">Datos del Activo</div>
		  	<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 @if($errors->first('cod_pat')) has-error has-feedback @endif">
						{{ Form::label('cod_pat','Codigo Patrimonial') }}<span style="color:red"> *</span>
						{{ Form::text('cod_pat',Input::old('cod_pat'),['class' => 'form-control','id'=>'cod_pat'])}}
					</div>
					<div class="form-group col-md-6 @if($errors->first('modelo')) has-error has-feedback @endif">
						{{ Form::label('modelo','Equipo') }}
						{{ Form::text('modelo',Input::old('equipo'),['class' => 'form-control','id'=>'marca_equipo','readonly'=>''])}}
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
		  	<div class="panel-heading">Datos de la Solicitud</div>
		  	<div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						{{ Form::label('fecha_solicitud','Fecha de solicitud ') }}<span style="color:red"> *</span>
						<div id="fecha_solicitud" class="fecha-hora form-group input-group date @if($errors->first('fecha_solicitud')) has-error has-feedback @endif">
							{{ Form::text('fecha_solicitud',Input::old('fecha_solicitud'),array('class'=>'form-control')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-6 @if($errors->first('idestado')) has-error has-feedback @endif">
						{{ Form::label('idestado','Estado') }}
						{{ Form::text('idestado',$estado->nombre,array('class'=>'form-control','disabled'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 @if($errors->first('especificacion_servicio')) has-error has-feedback @endif">
						{{ Form::label('especificacion_servicio','Especificación de servicio (MAX: 100 Caracteres)') }}<span style="color:red"> *</span>
						{{ Form::textarea('especificacion_servicio',Input::old('especificacion_servicio'),array('class'=>'form-control','maxlength'=>'100','rows'=>3,'style'=>'resize:none;')) }}
					</div>
					<div class="form-group col-md-6 @if($errors->first('motivo')) has-error has-feedback @endif">
						{{ Form::label('motivo','Motivo (MAX: 200 Caracteres)') }}<span style="color:red"> *</span>
						{{ Form::textarea('motivo',Input::old('motivo'),array('class'=>'form-control','maxlength'=>'200','rows'=>3,'style'=>'resize:none;')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6 @if($errors->first('justificacion')) has-error has-feedback @endif">
						{{ Form::label('justificacion','Justificación (MAX: 200 Caracteres)') }}<span style="color:red"> *</span>
						{{ Form::textarea('justificacion',Input::old('justificacion'),array('class'=>'form-control','maxlength'=>'200','rows'=>'3','style'=>'resize:none;')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-2">
						{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit_create_sot','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
					</div>
					<div class="form-group col-md-2">
						<a class="btn btn-default btn-block" href="{{URL::to('/sot/list_sots')}}">Cancelar</a>				
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
@stop