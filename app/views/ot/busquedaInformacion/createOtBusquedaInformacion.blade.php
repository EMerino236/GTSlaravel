@extends('templates/otBusquedaInformacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Orden de trabajo de búsqueda de información: {{$ot_info->ot_tipo_abreviatura}}{{$ot_info->ot_correlativo}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('numero_ficha',"Ingrese el número de ficha de la OTM ") }}</strong></p>
			<p><strong>{{ $errors->first('idestado',"Seleccione estado ") }}</strong></p>
			<p><strong>{{ $errors->first('idestado_inicial',"Seleccione un estado inicial del activo") }}</strong></p>
			<p><strong>{{ $errors->first('sin_interrupcion_servicio',"Seleccione si hubo interrupción en el servicio") }}</strong></p>
			<p><strong>{{ $errors->first('idestado_final',"Seleccione un estado final del activo") }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'busqueda_informacion/submit_create_ot', 'role'=>'form')) }}
		{{ Form::hidden('idot_busqueda_info', $ot_info->idot_busqueda_info,array('id'=>'idot_busqueda_info'))}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la OTM</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('solicitante','Usuario Solicitante') }}
							{{ Form::text('solicitante',$ot_info->apat_solicitante.' '.$ot_info->amat_solicitante.', '.$ot_info->nombre_solicitante,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('tipo','Tipo') }}
							{{ Form::select('tipo', array('0'=>'Seleccione') + $tipos,$ot_info->idtipo_busqueda_info,array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('area','Departamento') }}
							{{ Form::select('area', array('0'=>'Seleccione') + $areas,$ot_info->idarea,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('elaborador','Documento Elaborado Por') }}
							{{ Form::text('elaborador',$ot_info->apat_elaborador.' '.$ot_info->amat_elaborador.', '.$ot_info->nombre_elaborador,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('ingeniero','Ejecutor del Mantenimiento') }}
							{{ Form::text('ingeniero',$ot_info->nombre_ejecutor,array('class' => 'form-control','placeholder'=>'Ejecutor del Mantenimiento')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
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
				<div class="row">	
					<div class="col-md-6">					
						<div class="row">
							<div class="form-group col-md-8">
								{{ Form::label('fecha_programacion','Fecha Programada') }}
								{{ Form::text('fecha_programacion',date('d-m-Y',strtotime($ot_info->fecha_programacion)),array('class' => 'form-control','readonly'=>'','id'=>'fecha_programacion_ot')) }}
							</div>
						</div>
						<div class="row">
							<div class="col-md-8 form-group ">						
								{{ Form::label('fecha_conformidad','Fecha de Conformidad') }}
								<div id="datetimepicker_conformidad_fecha" class="input-group date @if($errors->first('fecha_conformidad')) has-error has-feedback @endif">
									@if($ot_info->fecha_conformidad == null)
										{{ Form::text('fecha_conformidad',null,array('class'=>'form-control','readonly'=>'')) }}
									@else
										{{Form::text('fecha_conformidad',date('d-m-Y',strtotime($ot_info->fecha_conformidad)),array('class'=>'form-control','readonly'=>'')) }}
									@endif
									<span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="form-group col-md-8">
								{{ Form::label('hora_programacion','Hora Programada') }}
								{{ Form::text('hora_programacion',date('H:i',strtotime($ot_info->fecha_programacion)),array('class' => 'form-control','readonly'=>'')) }}
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-8">
								{{ Form::label('fecha_conformidad','Hora de Conformidad') }}
								<div id="datetimepicker_conformidad_hora" class="input-group date @if($errors->first('fecha_conformidad')) has-error has-feedback @endif">
									@if($ot_info->fecha_conformidad == null)
										{{ Form::text('hora_conformidad',null,array('class'=>'form-control','readonly'=>'')) }}
									@else
										{{Form::text('hora_conformidad',date('H:i',strtotime($ot_info->fecha_conformidad)),array('class'=>'form-control','readonly'=>'')) }}
									@endif
									<span class="input-group-addon">
				                        <span class="glyphicon glyphicon-time"></span>
				                    </span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						{{ Form::label('descripcion','Descripcion') }}
						{{ Form::textarea('descripcion',$ot_info->descripcion,array('class' => 'form-control','rows'=>'3','maxlength'=>'500','style'=>'resize:none;')) }}
					</div>
					<div class="col-md-6 form-group">
						{{ Form::label('motivo','Motivo') }}
						{{ Form::textarea('motivo',$ot_info->motivo,array('class' => 'form-control','rows'=>'3','maxlength'=>'500','style'=>'resize:none;')) }}
					</div>
					<div class="col-md-6 form-group">
						{{ Form::label('detalle','Detalle') }}
						{{ Form::textarea('detalle',$ot_info->detalle_ot,array('class' => 'form-control','rows'=>'3','maxlength'=>'500','style'=>'resize:none;')) }}
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos generales de la Orden de Trabajo de Mantenimiento</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-8 form-group">
						{{ Form::label('nombre_tarea','Actividad:') }}
						{{ Form::text('nombre_tarea',null,array('class' => 'form-control','placeholder'=>'Ingrese nombre de la tarea' ,'id'=>'nombre_tarea')) }}
					</div>
					<div class="col-md-4 form-group">
						{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar',array('id'=>'submit-tarea', 'class'=>'btn btn-primary','style'=>'margin-top:25px')) }}
					</div>
				</div>
				<div class="row">		
					<div class="col-md-10">
						<table class="table" id="tareas-table" >
							<tr class="info">
								<th>Actividad</th>
								<th>Realizada</th>
								<th>Operaciones</th>
							</tr>
							@foreach($tareas as $tarea)
							<tr id="tarea-row-{{$tarea->idtareas_ot_busqueda_info}}">
								<td>{{$tarea->nombre}}</td>
								<td>
									@if($tarea->idestado_realizado == 23)
										{{ Form::button('Marcar realizada',array('class'=>'btn btn-default boton-tarea','data-id'=>$tarea->idtareas_ot_busqueda_info)) }}
									@else
										Realizada
									@endif
								</td>
								<td>
									<button class="btn btn-danger boton-eliminar-tarea" onclick="eliminar_tarea_preventivo(event,{{$tarea->idtareas_ot_busqueda_info}})" type="button">Eliminar</button>
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
					<div class="row">
						<div class="form-group col-md-5">
							{{ Form::text('nombre_personal', null,array('class'=>'form-control','placeholder'=>'Nombres Apellidos')) }}
						</div>
						<div class="form-group col-md-3">
							{{ Form::text('horas_trabajadas', null,array('class'=>'form-control','placeholder'=>'Hrs. Trab. ejem: 0.5')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::text('costo_personal', null,array('class'=>'form-control','placeholder'=>'Costo (S/.)')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar',array('id'=>'submit-personal', 'class'=>'btn btn-primary')) }}
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<table id="personal-table" class="table">
						<tr class="info">
							<th>Nombres y Apellidos</th>
							<th>Horas Trabajadas</th>
							<th>Subtotal</th>
							<th>Operaciones</th>
						</tr>
						@foreach($personal_data as $personal)
						<tr id="personal-row-{{ $personal->idpersonal_ot_preventivo }}">
							<td>{{$personal->nombre}}</td>
							<td>{{$personal->horas_hombre}}</td>
							<td>{{$personal->costo}}</td>
							<td>
								<button class="btn btn-danger boton-eliminar-mano-obra" onclick="eliminar_personal(event,{{$personal->idpersonal_ot_busqueda_info}})" type="button">Eliminar</button>
							</td>
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
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create_ots', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/busqueda_informacion/list_busqueda_informacion')}}">Cancelar</a>				
			</div>
		</div>	
	{{ Form::close() }}

	<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="modal_info_ot" role="dialog">
    <div class="modal-dialog modal-md">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" id="modal_header_ot">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Advertencia</h4>
        </div>
        <div class="modal-body" id="modal_text_ot">         	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="btn_close_modal" data-dismiss="modal">Aceptar</button>
        </div>
      </div>      
    </div>
  </div>  
</div>
@stop

