@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Solicitud de Orden de Trabajo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
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

	{{ Form::open(array('url'=>'sot/submit_edit_sot', 'role'=>'form')) }}
		{{ Form::hidden('sot_id', $sot_info->idsolicitud_orden_trabajo) }}
		<div class="col-xs-12">
			<div class="row">
				<div class="form-group col-xs-10">
					{{ Form::label('solicitante','Usuario solicitante: '.$user->apellido_pat." ".$user->apellido_mat.", ".$user->nombre." ") }}
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('fecha_solicitud','Fecha de solicitud') }}
					{{ Form::text('fecha_solicitud',date('d-m-Y',strtotime($sot_info->fecha_solicitud)),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('especificacion_servicio')) has-error has-feedback @endif">
					{{ Form::label('especificacion_servicio','Especificación de servicio') }}
					{{ Form::textarea('especificacion_servicio',$sot_info->especificacion_servicio,array('class'=>'form-control','maxlength'=>'100')) }}
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idestado')) has-error has-feedback @endif">
					{{ Form::label('idestado','Estado') }}
					{{ Form::select('idestado',$estados,$sot_info->idestado,['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('motivo')) has-error has-feedback @endif">
					{{ Form::label('motivo','Motivo') }}
					{{ Form::textarea('motivo',$sot_info->motivo,array('class'=>'form-control','maxlength'=>'200')) }}
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="row">
				<div class="form-group col-xs-10 @if($errors->first('justificacion')) has-error has-feedback @endif">
					{{ Form::label('justificacion','Justificación') }}
					{{ Form::textarea('justificacion',$sot_info->justificacion,array('class'=>'form-control','maxlength'=>'200','rows'=>'3')) }}
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
					{{ HTML::link('/sot/list_sots','Cancelar',array('class'=>'')) }}
				</div>
			</div>	
		</div>	
	{{ Form::close() }}
	{{ Form::open(array('url'=>'sot/submit_disable_sot', 'role'=>'form')) }}
		{{ Form::hidden('sot_id', $sot_info->idsolicitud_orden_trabajo) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Eliminar Solicitud',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
				</div>
			</div>	
		</div>	
	{{ Form::close() }}
@stop