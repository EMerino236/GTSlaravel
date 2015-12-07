@extends('templates/otRetiroServicioTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Orden de trabajo de retiro de servicio</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

		{{ Form::hidden('idot_retiro', $ot_info->idot_retiro) }}
		{{ Form::hidden('idactivo', $ot_info->idactivo) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la OT</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('codigo','Código OT') }}
						{{ Form::text('codigo',$ot_info->ot_tipo_abreviatura.$ot_info->ot_correlativo.$ot_info->ot_activo_abreviatura,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('elaborador','Documento Elaborado Por') }}
						{{ Form::text('elaborador',$ot_info->apat_elaborador.' '.$ot_info->amat_elaborador.', '.$ot_info->nombre_elaborador,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('solicitante','Usuario Solicitante') }}
						{{ Form::text('solicitante',$ot_info->apat_solicitante.' '.$ot_info->amat_solicitante.', '.$ot_info->nombre_solicitante,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('ingeniero','Ejecutor del Mantenimiento') }}
						{{ Form::text('ingeniero',$ot_info->apat_ingeniero.' '.$ot_info->amat_ingeniero.', '.$ot_info->nombre_ingeniero,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('fecha_programacion','Fecha Programada') }}
						{{ Form::text('fecha_programacion',date("d-m-Y H:i:s",strtotime($ot_info->fecha_programacion)),array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('nombre_servicio','Servicio Hospitalario') }}
						{{ Form::text('nombre_servicio',$ot_info->nombre_servicio,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_ubicacion','Ubicación Física') }}
						{{ Form::text('nombre_ubicacion',$ot_info->nombre_ubicacion,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Equipo</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_equipo','Nombre del Equipo') }}
						{{ Form::text('nombre_equipo',$ot_info->nombre_equipo,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
						{{ Form::text('codigo_patrimonial',$ot_info->codigo_patrimonial,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('numero_serie','Número de Serie') }}
						{{ Form::text('numero_serie',$ot_info->numero_serie,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_marca','Marca') }}
						{{ Form::text('nombre_marca',$ot_info->nombre_marca,array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('modelo','Modelo') }}
						{{ Form::text('modelo',$ot_info->modelo,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte de Retiro</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('fecha_baja','Fecha de Baja') }}
						{{ Form::text('fecha_baja',date('d-m-Y H:i',strtotime($ot_info->fecha_baja)),array('class' => 'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('fecha_conformidad','Fecha de Conformidad') }}
						@if(!$ot_info->fecha_conformidad)					
							{{ Form::text('fecha_conformidad',null,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('fecha_conformidad',date('d-m-Y H:i',strtotime($ot_info->fecha_conformidad)),array('class'=>'form-control','readonly'=>'')) }}
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
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idestado')) has-error has-feedback @endif">
						{{ Form::label('idestado','Equipo No Intervenido') }}
						{{ Form::select('idestado', $estados,$ot_info->idestado_ot,['class' => 'form-control','disabled'=>'disabled']) }}
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Diagnóstico y Programación</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idestado_inicial')) has-error has-feedback @endif">
						{{ Form::label('idestado_inicial','Estado Inicial del Activo') }}
						{{ Form::select('idestado_inicial', $estado_activo,$ot_info->idestado_inicial,array('class'=>'form-control','disabled'=>'disabled')) }}
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos Generales de la Orden de Trabajo de Retiro de Servicio</h3>
			</div>
			<div class="panel-body">
				<table id="tareas-table" class="table">
					<tr class="info">
						<th>Descripción</th>
						<th>Estado</th>
					</tr>
					@foreach($tareas as $tarea)
					<tr id="tarea-row-{{ $tarea->idtareas_ot_retiro }}">
						<td>{{$tarea->nombre}}</td>
						<td>
							@if($tarea->idestado_realizado != 23)
								Realizada
							@else
								No Realizada
							@endif
						</td>
					</tr>
					@endforeach
				</table>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idestado_final')) has-error has-feedback @endif">
						{{ Form::label('idestado_final','Estado Final del Activo') }}
						{{ Form::select('idestado_final', $estado_activo,$ot_info->idestado_final,array('class'=>'form-control','disabled'=>'disabled')) }}
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de Mano de Obra</h3>
			</div>
			<div class="panel-body">
				<table id="personal-table" class="table">
					<tr class="info">
						<th>Nombres y Apellidos</th>
						<th>Horas Trabajadas</th>
						<th>Costo</th>
					</tr>
					@foreach($personal_data as $personal)
					<tr id="personal-row-{{ $personal->idpersonal_ot_retiro }}">
						<td>{{$personal->nombre}}</td>
						<td>{{$personal->horas_hombre}}</td>
						<td>{{$personal->costo}}</td>
					</tr>
					@endforeach
				</table>
				<div class="row">
					<div class="col-md-2">
			    		{{ Form::label('costo_total_personal','Gasto Total Mano de Obra (S/.)') }}
			    	</div>
			    	<div class="col-md-2">
			        	{{ Form::text('costo_total_personal', number_format($ot_info->costo_total_personal,2),array('class'=>'form-control','placeholder'=>'Costo','readonly'=>'')) }}
			    	</div>
			    </div>
			</div>
		</div>
		<div class="row">			
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::previous()}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
			</div>	
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::open(array('url'=>'retiro_servicio/export_pdf', 'role'=>'form')) }}
				{{ Form::hidden('idot_retiro', $ot_info->idot_retiro) }}
				{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar', 'type'=>'submit' ,'class' => 'btn btn-success btn-block')) }}
				{{ Form::close() }}
			</div>			
		</div>			
@stop