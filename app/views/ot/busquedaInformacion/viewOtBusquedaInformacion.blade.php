@extends('templates/otBusquedaInformacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Orden de trabajo de búsqueda de información: {{$ot_info->ot_tipo_abreviatura}}{{$ot_info->ot_correlativo}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	
		{{ Form::hidden('idot_busqueda_info', $ot_info->idot_busqueda_info,array('id'=>'idot_busqueda_info'))}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la OTM</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-10">
							{{ Form::label('solicitante','Usuario Solicitante') }}
							{{ Form::text('solicitante',$ot_info->apat_solicitante.' '.$ot_info->amat_solicitante.', '.$ot_info->nombre_solicitante,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-10">
							{{ Form::label('tipo','Tipo') }}
							{{ Form::select('tipo', array('0'=>'Seleccione') + $tipos,$ot_info->idtipo_busqueda_info,array('class'=>'form-control','disabled'=>'disabled')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-10">
							{{ Form::label('area','Departamento') }}
							{{ Form::select('area', array('0'=>'Seleccione') + $areas,$ot_info->idarea,array('class'=>'form-control','disabled'=>'disabled')) }}
						</div>
					</div>										
					<div class="row">
						<div class="col-md-10 form-group ">						
							{{Form::label('estado_ot','Estado OT:')}}
							{{ Form::select('estado_ot', array('0' => 'Seleccione') + $estados ,$ot_info->idestado_ot ,array('class'=>'form-control','disabled'=>'disabled')) }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-10">
							{{ Form::label('elaborador','Documento Elaborado Por') }}
							{{ Form::text('elaborador',$ot_info->apat_elaborador.' '.$ot_info->amat_elaborador.', '.$ot_info->nombre_elaborador,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-10">
							{{ Form::label('encargado','Ejecutor del Mantenimiento') }}
							{{ Form::text('encargado',$ot_info->apat_encargado.' '.$ot_info->amat_encargado.', '.$ot_info->nombre_encargado,array('class' => 'form-control','placeholder'=>'Ejecutor del Mantenimiento','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-10">
							{{ Form::label('numero_solicitud','Número de Solicitud') }}
							{{ Form::text('numero_solicitud',$ot_info->sot_tipo_abreviatura.$ot_info->sot_correlativo,array('class' => 'form-control','readonly'=>'	')) }}
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
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-10 form-group">
							{{ Form::label('descripcion','Descripcion') }}
							{{ Form::textarea('descripcion',$ot_info->descripcion,array('class' => 'form-control','rows'=>'3','maxlength'=>'500','style'=>'resize:none;','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-10 form-group">
							{{ Form::label('detalle','Detalle') }}
							{{ Form::textarea('detalle',$ot_info->detalle,array('class' => 'form-control','rows'=>'3','maxlength'=>'500','style'=>'resize:none;','readonly'=>'')) }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-10 form-group">
							{{ Form::label('motivo','Motivo') }}
							{{ Form::textarea('motivo',$ot_info->motivo,array('class' => 'form-control','rows'=>'3','maxlength'=>'500','style'=>'resize:none;','readonly'=>'')) }}
						</div>
					</div>
				</div>				
			</div>
		</div>
	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Fecha de Programación y Conformidad</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-6">					
					<div class="row">
						<div class="form-group col-md-10">
							{{ Form::label('fecha_programacion','Fecha Programada') }}
							{{ Form::text('fecha_programacion',date('d-m-Y',strtotime($ot_info->fecha_programacion)),array('class' => 'form-control','readonly'=>'','id'=>'fecha_programacion_ot')) }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-10 form-group ">						
							{{ Form::label('fecha_conformidad','Fecha de Conformidad') }}
							@if($ot_info->fecha_conformidad == null)
								{{ Form::text('fecha_conformidad',null,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{Form::text('fecha_conformidad',date('d-m-Y',strtotime($ot_info->fecha_conformidad)),array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
							@endif
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-10">
							{{ Form::label('hora_programacion','Hora Programada') }}
							{{ Form::text('hora_programacion',date('H:i',strtotime($ot_info->fecha_programacion)),array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-10">
							{{ Form::label('fecha_conformidad','Hora de Conformidad') }}
							@if($ot_info->fecha_conformidad == null)
								{{ Form::text('hora_conformidad',null,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{Form::text('hora_conformidad',date('H:i',strtotime($ot_info->fecha_conformidad)),array('class'=>'form-control','readonly'=>'')) }}
							@endif
						</div>
					</div>
				</div>	
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Actividades de la OTM</h3>
			</div>
			<div class="panel-body">
				<div class="row">		
					<div class="col-md-10">
						<table class="table" id="tareas-table" >
							<tr class="info">
								<th>Actividad</th>
								<th>Realizada</th>
							</tr>
							@foreach($tareas as $tarea)
							<tr id="tarea-row-{{$tarea->idtareas_ot_busqueda_info}}">
								<td>{{$tarea->nombre}}</td>
								<td>
									@if($tarea->idestado_realizado == 23)
										No Realizada
									@else
										Realizada
									@endif
								</td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de mano de obra</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<table id="personal-table" class="table">
						<tr class="info">
							<th>Nombres y Apellidos</th>
							<th>Horas Trabajadas</th>
							<th>Subtotal</th>
						</tr>
						@foreach($personal_data as $personal)
						<tr id="personal-row-{{ $personal->idpersonal_ot_busqueda_info }}">
							<td>{{$personal->nombre}}</td>
							<td>{{$personal->horas_hombre}}</td>
							<td>{{$personal->costo}}</td>
						</tr>
						@endforeach
					</table>
					<div class="col-md-8">
				      {{ Form::label('costo_total_personal','Gasto Total Mano de Obra (S/.)',array('class'=>'col-sm-5')) }}
				      <div class="col-md-3">
				        {{ Form::text('costo_total_personal', number_format($ot_info->costo_total_personal,2),array('class'=>'form-control','placeholder'=>'Costo','readonly'=>'')) }}
				      </div>
				    </div>
				</div>
			</div>
		</div>
		<div class="row">			
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/solicitud_busqueda_informacion/list_busqueda_informacion')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
			</div>	
			{{Form::open(array('url'=>'busqueda_informacion/export_pdf', 'role'=>'form'))}}		
			{{Form::hidden('idot_busqueda_info', $ot_info->idot_busqueda_info) }}
			<div class="form-group col-md-2 col-md-offset-6">
				{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar', 'type'=>'submit' ,'class' => 'btn btn-success btn-block')) }}
			</div>
			{{ Form::close() }}
		</div>	

@stop