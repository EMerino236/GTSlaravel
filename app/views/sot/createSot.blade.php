@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Generar Solicitud de Orden de Trabajo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('fecha_solicitud') }}</strong></p>
			<p><strong>{{ $errors->first('especificacion_servicio') }}</strong></p>
			<p><strong>{{ $errors->first('idestado') }}</strong></p>
			<p><strong>{{ $errors->first('motivo') }}</strong></p>
			<p><strong>{{ $errors->first('justificacion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'sot/submit_create_sot', 'role'=>'form')) }}
		<div class="col-xs-12">
			<div class="row">
				<div class="form-group col-xs-10">
					{{ Form::label('solicitante','Usuario solicitante: '.$user->apellido_pat." ".$user->apellido_mat.", ".$user->nombre." ") }}
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="row">
				{{ Form::label('fecha_solicitud','Fecha de solicitud') }}
				<div id="datetimepicker1" class="form-group input-group date col-xs-8 @if($errors->first('fecha_solicitud')) has-error has-feedback @endif">
					{{ Form::text('fecha_solicitud',Input::old('fecha_solicitud'),array('class'=>'form-control')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('especificacion_servicio')) has-error has-feedback @endif">
					{{ Form::label('especificacion_servicio','Especificación de servicio') }}
					{{ Form::textarea('especificacion_servicio',Input::old('especificacion_servicio'),array('class'=>'form-control','maxlength'=>'100')) }}
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idestado')) has-error has-feedback @endif">
					{{ Form::label('idestado','Estado') }}
					{{ Form::select('idestado',$estados,Input::old('idestado'),['class' => 'form-control','readonly'=>'','disabled'=>'']) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('motivo')) has-error has-feedback @endif">
					{{ Form::label('motivo','Motivo') }}
					{{ Form::textarea('motivo',Input::old('motivo'),array('class'=>'form-control','maxlength'=>'200')) }}
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="row">
				<div class="form-group col-xs-10 @if($errors->first('justificacion')) has-error has-feedback @endif">
					{{ Form::label('justificacion','Justificación') }}
					{{ Form::textarea('justificacion',Input::old('justificacion'),array('class'=>'form-control','maxlength'=>'200','rows'=>'3')) }}
				</div>
			</div>
			{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('/sot/list_sots','Cancelar',array('class'=>'')) }}
		</div>
	{{ Form::close() }}
@stop