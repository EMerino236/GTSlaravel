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
			<p><strong>{{ $errors->first('prioridades',"Seleccione una Prioridad") }}</strong></p>
			<p><strong>{{ $errors->first('idestado',"Seleccione estado ") }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_problema',"La descripción del problema es obligatoria y debe ser menor a 500 caracteres") }}</strong></p>
			<p><strong>{{ $errors->first('tipo_falla',"Seleccione un tipo de falla") }}</strong></p>
			<p><strong>{{ $errors->first('idestado_inicial',"Seleccione un estado inicial del activo") }}</strong></p>
			<p><strong>{{ $errors->first('diagnostico_falla',"El diagnostico de falla es obligatorio y debe ser menor a 500 caracteres") }}</strong></p>
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

	{{ Form::open(array('url'=>'mant_preventivo/submit_create_ot', 'role'=>'form')) }}
		{{ Form::hidden('idordenes_trabajo', $ot_info->idordenes_trabajo) }}
		{{ Form::hidden('idactivo', $ot_info->idactivo) }}
		{{ Form::hidden('idorden_trabajoxactivo', $otxact->idorden_trabajoxactivo) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la OTM</h3>
			</div>
			<div class="panel-body">
			<div class="col-md-6">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('solicitante','Usuario Solicitante') }}
						{{ Form::text('solicitante',$ot_info->apat_solicitante.' '.$ot_info->amat_solicitante.', '.$ot_info->nombre_solicitante,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
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
			<div class="col-md-6">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('elaborador','Documento Elaborado Por') }}
						{{ Form::text('elaborador',$ot_info->apat_elaborador.' '.$ot_info->amat_elaborador.', '.$ot_info->nombre_elaborador,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('ingeniero','Ejecutor del Mantenimiento') }}
						{{ Form::text('ingeniero',$ot_info->apat_ingeniero.' '.$ot_info->amat_ingeniero.', '.$ot_info->nombre_ingeniero,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
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
			<div class="col-md-6">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_equipo','Nombre del Equipo') }}
						{{ Form::text('nombre_equipo',$ot_info->nombre_equipo,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_marca','Marca') }}
						{{ Form::text('nombre_marca',$ot_info->nombre_marca,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('modelo','Modelo') }}
						{{ Form::text('modelo',$ot_info->modelo,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
						{{ Form::text('codigo_patrimonial',$ot_info->codigo_patrimonial,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
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
				<div class="col-md-12">
					<div class="row">
						<div class="form-group col-md-4">
							{{ Form::label('fecha_solicitud','Fecha de Solicitud') }}
							{{ Form::text('fecha_solicitud',date('d-m-Y H:i:s',strtotime($ot_info->fecha_solicitud)),array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						@if(!$ot_info->fecha_conformidad)
						{{ Form::label('fecha_conformidad','Fecha de Conformidad') }}
						<div class="datetimepicker form-group input-group date col-md-8 @if($errors->first('fecha_conformidad')) has-error has-feedback @endif">
							{{ Form::text('fecha_conformidad',null,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
						@else
						<div class="form-group col-md-4">
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
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-4 @if($errors->first('prioridades')) has-error has-feedback @endif">
							{{ Form::label('prioridades','Prioridad') }}
							{{ Form::select('prioridades', $prioridades,$ot_info->idprioridad,['class' => 'form-control']) }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-4 @if($errors->first('idestado')) has-error has-feedback @endif">
							{{ Form::label('idestado','Equipo No Intervenido') }}
							{{ Form::select('idestado', $estados,$ot_info->idestado,['class' => 'form-control']) }}
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="row">
						<div class="form-group col-md-12 @if($errors->first('descripcion_problema')) has-error has-feedback @endif">
							{{ Form::label('descripcion_problema','Descripción del Problema') }}
							{{ Form::textarea('descripcion_problema', $ot_info->descripcion_problema,array('class'=>'form-control','maxlength'=>'500')) }}
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
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('tipo_falla')) has-error has-feedback @endif">
							{{ Form::label('tipo_falla','Tipo de Falla') }}
							{{ Form::select('tipo_falla', $tipo_fallas,$ot_info->tipo_falla,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>	
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('idestado_inicial')) has-error has-feedback @endif">
							{{ Form::label('idestado_inicial','Estado Inicial del Activo') }}
							{{ Form::select('idestado_inicial', $estado_activo,$ot_info->idestado_inicial,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="row">
						<div class="form-group col-md-12 @if($errors->first('diagnostico_falla')) has-error has-feedback @endif">
							{{ Form::label('diagnostico_falla','Diagnóstico de la Falla') }}
							{{ Form::textarea('diagnostico_falla', $ot_info->diagnostico_falla,array('class'=>'form-control','maxlength'=>'500')) }}
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
						<td>
							@if($tarea->idestado_realizado == 23)
								{{ Form::button('Marcar realizada',array('class'=>'btn btn-default boton-tarea','data-id'=>$tarea->idorden_trabajoxactivoxtarea)) }}
							@else
								Realizada
							@endif
						</td>
					</tr>
					@endforeach
				</table>
						
				<div class="col-md-6">
					<div class="row">
						{{ Form::label('fecha_inicio_ejecucion','Fecha de Inicio') }}
						<div class="datetimepicker form-group input-group date col-md-8 @if($errors->first('fecha_inicio_ejecucion')) has-error has-feedback @endif">
							{{ Form::text('fecha_inicio_ejecucion',null,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('garantia')) has-error has-feedback @endif">
							{{ Form::label('garantia','Garantía') }}
							{{ Form::text('garantia', $ot_info->garantia,array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('idestado_final')) has-error has-feedback @endif">
							{{ Form::label('idestado_final','Estado Final del Activo') }}
							{{ Form::select('idestado_final', $estado_activo,$ot_info->idestado_final,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
						
				<div class="col-md-6">
					<div class="row">
						{{ Form::label('fecha_termino_ejecucion','Fecha de Término') }}
						<div class="datetimepicker form-group input-group date col-md-8 @if($errors->first('fecha_termino_ejecucion')) has-error has-feedback @endif">
							{{ Form::text('fecha_termino_ejecucion',null,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('sin_interrupcion_servicio')) has-error has-feedback @endif">
							{{ Form::label('sin_interrupcion_servicio','Sin Interrupción al Servicio') }}
							{{ Form::select('sin_interrupcion_servicio', ['0'=>'No','1'=>'Si'],$ot_info->sin_interrupcion_servicio,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de repuestos</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<div class="row">
						<div class="form-group col-md-4">
							{{ Form::text('nombre_repuesto', null,array('class'=>'form-control','placeholder'=>'Nombre y características técnicas')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::text('codigo_repuesto', null,array('class'=>'form-control','placeholder'=>'Código')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::text('cantidad_repuesto', null,array('class'=>'form-control','placeholder'=>'Cantidad')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::text('costo_repuesto', null,array('class'=>'form-control','placeholder'=>'Costo')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::button('Agregar',array('id'=>'submit-repuesto', 'class'=>'btn btn-primary')) }}
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<table id="repuestos-table" class="table">
						<tr class="info">
							<th>Nombre</th>
							<th>Código</th>
							<th>Cantidad</th>
							<th>Costo</th>
							<th>Operaciones</th>
						</tr>
						@foreach($repuestos as $repuesto)
						<tr id="repuesto-row-{{ $repuesto->idrepuestos_ot }}">
							<td>{{$repuesto->nombre}}</td>
							<td>{{$repuesto->codigo}}</td>
							<td>{{$repuesto->cantidad}}</td>
							<td>S/. {{number_format($repuesto->costo,2)}}</td>
							<td>
								<button class="btn btn-danger boton-eliminar-repuesto" onclick="eliminar_repuesto(event,{{$repuesto->idrepuestos_ot}})" type="button">Eliminar</button>
							</td>
						</tr>
						@endforeach
					</table>
					<div class="col-md-6">
				      {{ Form::label('costo_total_repuestos','Gasto Total Repuestos (S/.)',array('class'=>'col-sm-5')) }}
				      <div class="col-md-3">
				        {{ Form::text('costo_total_repuestos', number_format($otxact->costo_total_repuestos,2),array('class'=>'form-control','placeholder'=>'Costo','readonly'=>'')) }}
				      </div>
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
						<div class="form-group col-md-6">
							{{ Form::text('nombre_personal', null,array('class'=>'form-control','placeholder'=>'Nombres Apellidos')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::text('horas_trabajadas', null,array('class'=>'form-control','placeholder'=>'Hrs. Trab. ejem: 0.5')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::text('costo_personal', null,array('class'=>'form-control','placeholder'=>'Costo')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::button('Agregar',array('id'=>'submit-personal', 'class'=>'btn btn-primary')) }}
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
						<tr id="personal-row-{{ $personal->iddetalle_personalxot }}">
							<td>{{$personal->nombre}}</td>
							<td>{{$personal->horas_hombre}}</td>
							<td>{{$personal->costo}}</td>
							<td>
								<button class="btn btn-danger boton-eliminar-mano-obra" onclick="eliminar_personal(event,{{$personal->iddetalle_personalxot}})" type="button">Eliminar</button>
							</td>
						</tr>
						@endforeach
					</table>
					<div class="col-md-7">
				      {{ Form::label('costo_total_personal','Gasto Total Mano de Obra (S/.)',array('class'=>'col-sm-5')) }}
				      <div class="col-md-3">
				        {{ Form::text('costo_total_personal', number_format($otxact->costo_total_personal,2),array('class'=>'form-control','placeholder'=>'Costo','readonly'=>'')) }}
				      </div>
				    </div>
				</div>
			</div>
		</div>
		{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
	{{ Form::close() }}
@stop