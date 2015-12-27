@extends('templates/otVerificacionMetrologicaTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Orden de trabajo de Verificación Metrológica: {{$ot_info->ot_tipo_abreviatura.$ot_info->ot_correlativo.$ot_info->ot_activo_abreviatura}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('numero_ficha') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_ejecutor') }}</strong></p>
			<p><strong>{{ $errors->first('idestado') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_problema') }}</strong></p>
			<p><strong>{{ $errors->first('idestado_inicial') }}</strong></p>
			<p><strong>{{ $errors->first('idestado_final') }}</strong></p>
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

	{{ Form::open(array('url'=>'verif_metrologica/submit_create_ot', 'role'=>'form','id'=>'submit_ot_metrologica')) }}
		{{ Form::hidden('idot_vmetrologica', $ot_info->idot_vmetrologica) }}
		{{ Form::hidden('idactivo', $ot_info->idactivo) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la OT</h3>
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
							{{ Form::label('nombre_servicio','Servicio Hospitalario') }}
							{{ Form::text('nombre_servicio',$ot_info->nombre_servicio,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('nombre_ubicacion','Ubicación Física') }}
							{{ Form::text('nombre_ubicacion',$ot_info->nombre_ubicacion,array('class' => 'form-control','readonly'=>'')) }}
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
							{{ Form::label('nombre_ejecutor','Ejecutor del Mantenimiento') }}
							{{ Form::text('nombre_ejecutor',$ot_info->nombre_ejecutor,array('class' => 'form-control','placeholder'=>'Nombre del Ejecutor')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('numero_ficha','Número de Ficha') }}
							{{ Form::text('numero_ficha',$ot_info->numero_ficha,array('class' => 'form-control','placeholder'=>'Ingrese número de ficha')) }}
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
					<div class="form-group col-md-8">
						{{ Form::label('nombre_equipo','Nombre del Equipo') }}
						{{ Form::text('nombre_equipo',$ot_info->nombre_equipo,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						{{ Form::label('nombre_marca','Marca') }}
						{{ Form::text('nombre_marca',$ot_info->nombre_marca,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						{{ Form::label('modelo','Modelo') }}
						{{ Form::text('modelo',$ot_info->modelo,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="form-group col-md-8">
						{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
						{{ Form::text('codigo_patrimonial',$ot_info->codigo_patrimonial,array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
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
							{{ Form::text('hora_programacion',date('H:i:s',strtotime($ot_info->fecha_programacion)),array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('hora_conformidad','Hora de Conformidad') }}
							<div id="datetimepicker_conformidad_hora" class="input-group date @if($errors->first('hora_conformidad')) has-error has-feedback @endif">
								@if($ot_info->fecha_conformidad == null)
									{{ Form::text('hora_conformidad',null,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{Form::text('hora_conformidad',date('H:i:s',strtotime($ot_info->fecha_conformidad)),array('class'=>'form-control','readonly'=>'')) }}
								@endif
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-time"></span>
			                    </span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Estado inicial del Equipo</h3>
			</div>
			<div class="panel-body">				
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('idestado_inicial')) has-error has-feedback @endif">
							{{ Form::label('idestado_inicial','Estado Inicial del Activo') }}
							{{ Form::select('idestado_inicial', $estado_activo,$ot_info->idestado_inicial,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('idestado')) has-error has-feedback @endif">
							{{ Form::label('idestado_ot','Equipo No Intervenido') }}
							{{ Form::select('idestado_ot', $estados,$ot_info->idestado_ot,['class' => 'form-control']) }}
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Estado final del Equipo</h3>
			</div>
			<div class="panel-body">										
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('idestado_final')) has-error has-feedback @endif">
							{{ Form::label('idestado_final','Estado Final del Activo') }}
							{{ Form::select('idestado_final', $estado_activo,$ot_info->idestado_final,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default" id="panel-documentos-relacionados">
	  				<div class="panel-heading">Documento Relacionado</div>
	  				<div class="panel-body">
	  					<div class="col-md-12">
							<div class="row">
								<div class="form-group col-md-2 @if($errors->first('num_doc_relacionado1')) has-error has-feedback @endif">
									{{ Form::label('num_doc_relacionado1','Cód. Archivamiento') }}
									@if($documento_info != null)
										{{ Form::text('num_doc_relacionado1',$documento_info->codigo_archivamiento,['class' => 'form-control','id'=>'num_doc_relacionado1'])}}
									@else
										{{ Form::text('num_doc_relacionado1','',['class' => 'form-control','id'=>'num_doc_relacionado1'])}}
									@endif
								</div>
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" onclick="llenar_nombre_doc_relacionado(1)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
								</div>
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-default btn-block" onclick="limpiar_nombre_doc_relacionado(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
								</div>
								<div class="form-group col-md-4">
									{{ Form::label('nombre_doc_relacionado1','Nombre de Documento') }}
									@if($documento_info != null)
										{{ Form::text('nombre_doc_relacionado1',$documento_info->nombre,['class' => 'form-control','id'=>'nombre_doc_relacionado1','disabled'=>'disabled'])}}
									@else
										{{ Form::text('nombre_doc_relacionado1','',['class' => 'form-control','id'=>'nombre_doc_relacionado1','disabled'=>'disabled'])}}
									@endif
								</div>	
								<div class="form-group col-md-2" style="margin-top:25px">
									@if($documento_info != null)
										<a id="documento_url" class="btn btn-primary btn-block" href="{{URL::to('/verif_metrologica/download_documento/')}}/{{$documento_info->iddocumento}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
									@endif
								</div>						
							</div>
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
						<div class="form-group col-md-5">
							{{ Form::text('nombre_personal', null,array('class'=>'form-control','placeholder'=>'Nombres Apellidos')) }}
						</div>
						<div class="form-group col-md-3">
							{{ Form::text('horas_trabajadas', null,array('class'=>'form-control','placeholder'=>'Hrs. Trab. ejem: 0.5')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::text('costo_personal', null,array('class'=>'form-control','placeholder'=>'Costo')) }}
						</div>
						<div class="form-group col-md-2">
							{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar',array('id'=>'submit-personal', 'class'=>'btn btn-primary')) }}
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="table-responsive">
						<table id="personal-table" class="table">
							<tr class="info">
								<th class="text-nowrap text-center">Nombres y Apellidos</th>
								<th class="text-nowrap text-center">Horas Trabajadas</th>
								<th class="text-nowrap text-center">Costo por Hora</th>
								<th class="text-nowrap text-center">Eliminar</th>
							</tr>
							@foreach($personal_data as $personal)
							<tr id="personal-row-{{ $personal->idpersonal_ot_vmetrologica }}">
								<td class="text-nowrap">{{$personal->nombre}}</td>
								<td class="text-nowrap text-center">{{$personal->horas_hombre}}</td>
								<td class="text-nowrap text-center">S/. {{$personal->costo}}</td>
								<td class="text-nowrap text-center">
									<button class="btn btn-danger boton-eliminar-mano-obra" onclick="eliminar_personal(event,{{$personal->idpersonal_ot_vmetrologica}})" type="button"><span class="glyphicon glyphicon-trash"></span></button>
								</td>
							</tr>
							@endforeach
						</table>
					</div>
					<div class="col-md-7">
				      {{ Form::label('costo_total_personal','Gasto Total Mano de Obra (S/.)',array('class'=>'col-sm-5')) }}
				      <div class="col-md-3">
				        {{ Form::text('costo_total_personal', number_format($ot_info->costo_total,2),array('class'=>'form-control','placeholder'=>'Costo','readonly'=>'')) }}
				      </div>
				    </div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_ot','class' => 'btn btn-primary btn-block')) }}
			</div>
	{{ Form::close() }}
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/verif_metrologica/list_verif_metrologica')}}">Cancelar</a>				
			</div>
			{{Form::open(array('url'=>'verif_metrologica/export_pdf', 'role'=>'form'))}}		
				{{ Form::hidden('idot_vmetrologica', $ot_info->idot_vmetrologica) }}
				<div class="form-group col-md-2 col-md-offset-6">
					{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar', 'type'=>'submit' ,'class' => 'btn btn-success btn-block')) }}
				</div>
			{{ Form::close() }}
		</div>	
@stop