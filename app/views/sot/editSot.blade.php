@extends('templates/sotTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Solicitud de Orden de Trabajo: <strong>{{$sot_info->sot_tipo_abreviatura}}{{$sot_info->sot_correlativo}}{{$sot_info->sot_activo_abreviatura}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

	{{ Form::open(array('url'=>'sot/submit_program_ot', 'role'=>'form','id'=>'submit_program_ot')) }}
		{{ Form::hidden('sot_id', $sot_info->idsolicitud_orden_trabajo) }}
		<div class="row">
			<div class="form-group col-md-6">
				{{ Form::label('solicitante','Usuario solicitante') }}
				{{ Form::text('solicitante',$sot_info->apellido_pat." ".$sot_info->apellido_mat.", ".$sot_info->nombre,array('class'=>'form-control','disabled'=>'')) }}
			</div>
			<div class="form-group col-md-6">
				{{ Form::label('activo','Código de activo involucrado') }}
				{{ Form::text('activo',$sot_info->codigo_patrimonial,array('class'=>'form-control','disabled'=>'')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
				{{ Form::label('fecha_solicitud','Fecha de solicitud') }}
				{{ Form::text('fecha_solicitud',date('d-m-Y',strtotime($sot_info->fecha_solicitud)),array('class'=>'form-control','disabled'=>'')) }}
			</div>
			<div class="form-group col-md-6 @if($errors->first('idestado')) has-error has-feedback @endif">
				{{ Form::label('idestado','Estado') }}
				{{ Form::select('idestado',$estados,$sot_info->idestado,['class' => 'form-control','disabled'=>'']) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 @if($errors->first('especificacion_servicio')) has-error has-feedback @endif">
				{{ Form::label('especificacion_servicio','Especificación de servicio') }}
				{{ Form::textarea('especificacion_servicio',$sot_info->especificacion_servicio,array('class'=>'form-control','maxlength'=>'100','rows'=>3,'disabled'=>'','style'=>'resize:none;')) }}
			</div>
			<div class="form-group col-md-6 @if($errors->first('motivo')) has-error has-feedback @endif">
				{{ Form::label('motivo','Motivo') }}
				{{ Form::textarea('motivo',$sot_info->motivo,array('class'=>'form-control','maxlength'=>'200','rows'=>3,'disabled'=>'','style'=>'resize:none;')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 @if($errors->first('justificacion')) has-error has-feedback @endif">
				{{ Form::label('justificacion','Justificación') }}
				{{ Form::textarea('justificacion',$sot_info->justificacion,array('class'=>'form-control','maxlength'=>'200','rows'=>'3','disabled'=>'','style'=>'resize:none;')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2">
				@if($sot_info->idestado == 14 && ($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4))
					{{ Form::button('<span class="glyphicon glyphicon-time"></span>  Programar OTM', array('id'=>'submit-edit','class' => 'btn btn-success btn-block')) }}
				@endif
			</div>		
			{{ Form::close() }}			
			@if($sot_info->idestado == 14 && ($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 7 || $user->idrol == 8 || $user->idrol == 9))
				{{ Form::open(array('url'=>'sot/submit_disable_sot', 'role'=>'form','id'=>'disable_sot')) }}
					{{ Form::hidden('sot_id', $sot_info->idsolicitud_orden_trabajo) }}
					<div class="form-group col-md-3">
						{{ Form::button('<span class="glyphicon glyphicon-remove"></span> Marcar como Falsa Alarma', array('id'=>'submit-delete', 'class' => 'btn btn-danger btn-block')) }}
					</div>
				{{ Form::close() }}
				{{ Form::open(array('url'=>'sot/submit_disable_sot_false_alarm', 'role'=>'form','id'=>'disable_sot_false_alarm')) }}
					{{ Form::hidden('sot_id', $sot_info->idsolicitud_orden_trabajo) }}
					<div class="form-group col-md-3">
						{{ Form::button('<span class="glyphicon glyphicon-remove"></span> Marcar como Mal Ingreso', array('id'=>'submit-delete-false-alarm', 'class' => 'btn btn-danger btn-block')) }}
					</div>
				{{ Form::close() }}
			@endif	
			<div class="form-group col-md-2 col-md-offset-2">
				<a class="btn btn-default btn-block" href="{{URL::previous()}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
			</div>	
					
		</div>
@stop