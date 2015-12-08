@extends('templates/otInspeccionEquiposTemplate')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Inspección de Equipo: {{$ot_info->ot_tipo_abreviatura}}{{$ot_info->ot_correlativo}}</h3>
    </div>
</div>

@if ($errors->has())
<div class="alert alert-danger" role="alert">
	<p><strong>{{ $errors->first('numero_ficha') }}</strong></p>
	<p><strong>{{ $errors->first('archivo0') }}</strong></p>
</div>
@endif

@if (Session::has('message'))
	<div class="alert alert-success">{{ Session::get('message') }}</div>
@endif
@if (Session::has('error'))
	<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

	{{ Form::open(array('url'=>'inspec_equipos/submit_create_ot', 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('idot_inspec_equipo', $ot_info->idot_inspec_equipo,array('id'=>'idot_inspec_equipo'))}}
		{{ Form::hidden('idservicio', $ot_info->idservicio) }}
		{{ Form::hidden('count_activos', count($activos_info),array('id'=>'count_activos')) }}
		{{ Form::hidden('value_activo',0,array('id'=>'value_activo'))}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la OTM</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('numero_ot','Número de OTM') }}
							{{ Form::text('numero_ot',$ot_info->ot_tipo_abreviatura.' '.$ot_info->ot_correlativo,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('nombre_servicio','Servicio Hospitalario') }}
							{{ Form::text('nombre_servicio',$ot_info->nombre_servicio,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-8 form-group ">						
							{{ Form::label('fecha_inicio','Fecha Inicio') }}
							@if($ot_info->fecha_inicio == null)
								{{ Form::text('fecha_inicio',null,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{Form::text('fecha_inicio',date('d-m-Y',strtotime($ot_info->fecha_inicio)).' ['.date('H:i',strtotime($ot_info->fecha_inicio)).'-'.date('H:i',strtotime($ot_info->fecha_fin)).']',array('class'=>'form-control','readonly'=>'')) }}
							@endif								
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('ingeniero','Ejecutor del Mantenimiento') }}
							{{ Form::text('ingeniero',$ot_info->apat_ingeniero.' '.$ot_info->amat_ingeniero.', '.$ot_info->nombre_ingeniero,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>					
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('numero_ficha','Número de Ficha') }}
							{{ Form::text('numero_ficha',$ot_info->numero_ficha,array('class' => 'form-control','placeholder'=>'Ingrese número de ficha')) }}
						</div>
					</div>
					<div class="row">
						<div class="col-md-8 form-group ">						
							{{Form::label('estado_ot','Estado OT:')}}
							{{ Form::select('estado_ot', array('0' => 'Seleccione') + $estados ,$ot_info->idestado ,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
			</div>			
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Equipos Asociados</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12" >
						<div class="table-responsive">
							<table class="table" id="table_equipos">
								<tr class="info">
									<th class="text-nowrap text-center">N°</th>
									<th class="text-nowrap text-center">Equipo</th>
									<th class="text-nowrap text-center">Modelo</th>
									<th class="text-nowrap text-center">Código Patrimonial</th>
								</tr>
								@foreach($activos_info as $index => $activo)
								<tr>
									<td class="text-nowrap text-center">{{$index+1}}</td>
									<td class="text-nowrap text-center">{{$activo->nombre_familia}}</td>
									<td class="text-nowrap text-center">{{$activo->nombre_modelo}}</td>
									<td class="text-nowrap text-center" id={{"cod_pat".$index}}>{{$activo->codigo_patrimonial}}</td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>				
			</div>			
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Equipos Asociados</h3>
			</div>
			<div class="panel-body" id="body_equipos">
				<div class="row">
					<div class="col-md-2" style="margin-top:5px;">
						{{Form::label('numero_fila','Número de Fila:')}}						
						
					</div>
					<div class="col-md-4">
						{{ Form::select('filas', array('0' => 'Seleccione') + $filas ,null ,array('class'=>'form-control','id'=>'fila')) }}
					</div>
					
				</div>

			@foreach($activosxot_info as $i => $otxactivo)
				<!--<div id="{{$i+1}}" style="position:relative;visibility:hidden;" >-->
				<div id="{{$i+1}}" >
					<div class="row">
						<div class="col-md-12">
							<h4>{{$i+1}}. {{$otxactivo->nombre_equipo}} - {{$otxactivo->nombre_modelo}} - Código Patrimonial: {{$otxactivo->codigo_patrimonial}}</h4>
						</div>
					</div>
					{{Form::hidden('idactivo'.$i,$otxactivo->idactivo)}}
					<div class="row">
						<div class="col-md-6 form-group">
							<div class="table-responsive">
								<table class="table">
									<tr class="info">
										<th>Tarea</th>
										<th>Estado</th>
									</tr>
									@foreach($tareas_activos[$i] as $j => $tarea)
										<tr>
											<td>{{$tarea->nombre_tarea}}</td>
											<td>
											@if($tarea->idestado_realizado == 23)
												{{ Form::button('Marcar realizada',array('class'=>'btn btn-default boton-tarea','data-id'=>$tarea->idot_inspec_equiposxactivosxtareas_inspec_equipo)) }}
											@else
												Realizada
											@endif
											</td>
										</tr>
									@endforeach
								</table>
							</div>
						</div>
						<div class="col-md-4 form-group">
							{{Form::label('imagen','Imagen del Equipo:')}}						
							<div style="border:solid;width:450px;height:300px;">
								@if($otxactivo->imagen_url!= null && $otxactivo->nombre_archivo!=null)
									<img style="max-width:100%;max-height:100%;width:100%;height:100%;" src={{$inside_url.$otxactivo->imagen_url.$otxactivo->nombre_archivo_encriptado}}>
								@endif
							</div>
							<label class="control-label">Seleccione una Imagen</label>(png,jpe,jpeg,jpg)
							<input name={{"archivo".$i}} id={{"input-file".$i}} type="file" class="file file-loading" data-show-upload="false">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-group">
							{{ Form::label('observaciones_equipo','Observaciones del Equipo') }}
							{{ Form::textarea('observaciones_equipo'.$i,$otxactivo->observaciones,array('class' => 'form-control','style'=>'resize:none;')) }}
						</div>
					</div>	
				</div>			
			@endforeach		
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create_ots', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/inspec_equipos/list_inspec_equipos')}}">Cancelar</a>				
			</div>
	{{Form::close()}}
			{{Form::open(array('url'=>'inspec_equipos/export_pdf', 'role'=>'form'))}}		
			{{Form::hidden('idot_inspec_equipo', $ot_info->idot_inspec_equipo) }}
			<div class="form-group col-md-2 col-md-offset-6">
				{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar', 'type'=>'submit' ,'class' => 'btn btn-success btn-block')) }}
			</div>
			{{ Form::close() }}
		</div>

@stop