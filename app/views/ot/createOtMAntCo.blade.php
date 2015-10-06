@extends('templates/otTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Orden de trabajo de mantenimiento correctivo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('fecha_programacion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'mant_correctivo/submit_create_ot', 'role'=>'form')) }}
		{{ Form::hidden('idactivo', $ot_info->idactivo) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la OT</h3>
			</div>
			<div class="panel-body">
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('solicitante','Usuario Solicitante') }}
						{{ Form::text('solicitante',$ot_info->apat_solicitante.' '.$ot_info->amat_solicitante.', '.$ot_info->nombre_solicitante,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('nombre_servicio','Servicio Hospitalario') }}
						{{ Form::text('nombre_servicio',$ot_info->nombre_servicio,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('nombre_ubicacion','Ubicación Física') }}
						{{ Form::text('nombre_ubicacion',$ot_info->nombre_ubicacion,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('ingeniero','Ejecutor del Mantenimiento') }}
						{{ Form::text('ingeniero',$ot_info->apat_ingeniero.' '.$ot_info->amat_ingeniero.', '.$ot_info->nombre_ingeniero,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('fecha_programacion','Fecha Programada') }}
						{{ Form::text('fecha_programacion',$ot_info->fecha_programacion,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Equipo</h3>
			</div>
			<div class="panel-body">
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('nombre_equipo','Nombre del Equipo') }}
						{{ Form::text('nombre_equipo',$ot_info->nombre_equipo,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('nombre_marca','Marca') }}
						{{ Form::text('nombre_marca',$ot_info->nombre_marca,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('modelo','Modelo') }}
						{{ Form::text('modelo',$ot_info->modelo,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
						{{ Form::text('codigo_patrimonial',$ot_info->codigo_patrimonial,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::label('numero_serie','Número de Serie') }}
						{{ Form::text('numero_serie',$ot_info->numero_serie,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la Solicitud</h3>
			</div>
			<div class="panel-body">
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('fecha_solicitud','Fecha de Solicitud') }}
							{{ Form::text('fecha_solicitud',date('d-m-Y H:i:s',strtotime($ot_info->fecha_solicitud)),array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="row">
						@if(!$ot_info->fecha_conformidad)
						{{ Form::label('fecha_conformidad','Fecha de Conformidad') }}
						<div id="datetimepicker1" class="form-group input-group date col-xs-8 @if($errors->first('fecha_conformidad')) has-error has-feedback @endif">
							{{ Form::text('fecha_conformidad',null,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
						@else
						<div class="form-group col-xs-8">
							{{ Form::label('fecha_conformidad','Fecha de Conformidad') }}
							{{ Form::text('fecha_conformidad',date('d-m-Y H:i:s',strtotime($ot_info->fecha_conformidad)),array('class'=>'form-control','readonly'=>'')) }}
						</div>
						@endif
					</div>
				</div>

			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Estado de la Orden de Trabajo</h3>
			</div>
			<div class="panel-body">
				<div class="col-xs-12">
					<div class="row">
						<div class="form-group col-xs-4 @if($errors->first('prioridades')) has-error has-feedback @endif">
							{{ Form::label('prioridades','Prioridad') }}
							{{ Form::select('prioridades', $prioridades,$ot_info->idprioridad,['class' => 'form-control']) }}
						</div>
					</div>

					<div class="row">
						<div class="form-group col-xs-4 @if($errors->first('equipo_noint')) has-error has-feedback @endif">
							{{ Form::label('equipo_noint','Equipo No Intervenido') }}
							{{ Form::select('equipo_noint', $estado_equipo_noint,$ot_info->idestado_equipo_noint,['class' => 'form-control']) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-12 @if($errors->first('descripcion_problema')) has-error has-feedback @endif">
							{{ Form::label('descripcion_problema','Descripción del Problema') }}
							{{ Form::textarea('descripcion_problema', $ot_info->descripcion_problema,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del diagnóstico y programación</h3>
			</div>
			<div class="panel-body">
				<div class="col-xs-12">
					<div class="row">
						<div class="form-group col-xs-12 @if($errors->first('descripcion_problema')) has-error has-feedback @endif">
							{{ Form::label('descripcion_problema','Descripción del Problema') }}
							{{ Form::textarea('descripcion_problema', $ot_info->descripcion_problema,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="row">
						<div class="form-group col-xs-4 @if($errors->first('tipo_falla')) has-error has-feedback @endif">
							{{ Form::label('tipo_falla','Tipo de Falla') }}
							{{ Form::select('tipo_falla', $tipo_fallas,$ot_info->tipo_falla,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="row">
						<div class="form-group col-xs-4 @if($errors->first('idestado_inicial')) has-error has-feedback @endif">
							{{ Form::label('idestado_inicial','Estado Inicial del Activo') }}
							{{ Form::select('idestado_inicial', $estado_activo,$ot_info->idestado_inicial,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos generales de la Orden de Trabajo de Mantenimiento</h3>
			</div>
			<div class="panel-body">
				<table class="table">
					<tr class="info">
						<th>Actividad</th>
						<th>Descripción</th>
						<th>Realizada</th>
					</tr>
					@foreach($tareas as $tarea)
					<tr>
						<td>{{$tarea->nombre_tarea}}</td>
						<td>{{$tarea->descripcion_tarea}}</td>
						@if($tarea->idestado_realizado == 25)
							<td>{{ Form::button('Marcar realizada',array('id'=>'submit-edit', 'class'=>'btn btn-default')) }}</td>
						@endif
					</tr>
					@endforeach
				</table>
						
				<div class="col-xs-6">
					<div class="row">
						{{ Form::label('fecha_inicio_ejecucion','Fecha de Inicio') }}
						<div id="datetimepicker1" class="form-group input-group date col-xs-8 @if($errors->first('fecha_inicio_ejecucion')) has-error has-feedback @endif">
							{{ Form::text('fecha_inicio_ejecucion',null,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('garantia')) has-error has-feedback @endif">
							{{ Form::label('garantia','Garantía') }}
							{{ Form::text('garantia', $ot_info->garantia,array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('idestado_final')) has-error has-feedback @endif">
							{{ Form::label('idestado_final','Estado Final del Activo') }}
							{{ Form::select('idestado_final', $estado_activo,$ot_info->idestado_final,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
						
				<div class="col-xs-6">
					<div class="row">
						{{ Form::label('fecha_termino_ejecucion','Fecha de Término') }}
						<div id="datetimepicker1" class="form-group input-group date col-xs-8 @if($errors->first('fecha_termino_ejecucion')) has-error has-feedback @endif">
							{{ Form::text('fecha_termino_ejecucion',null,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('sin_interrupcion_servicio')) has-error has-feedback @endif">
							{{ Form::label('sin_interrupcion_servicio','Sin Interrupción al Servicio') }}
							{{ Form::select('sin_interrupcion_servicio', ['0'=>'No','1'=>'Si'],$ot_info->sin_interrupcion_servicio,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
			</div>
		</div>
		{{ Form::submit('Programar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
	{{ Form::close() }}
@stop