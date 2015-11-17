@extends('templates/otInspeccionEquiposTemplate')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Inspección de Equipo: {{$ot_info->ot_tipo_abreviatura}}{{$ot_info->ot_correlativo}}</h3>
    </div>
</div>

@if ($errors->has())
<div class="alert alert-danger" role="alert">
	<p><strong>{{ $errors->first('fecha_programacion') }}</strong></p>
	<p><strong>{{ $errors->first('solicitante') }}</strong></p>
</div>
@endif

@if (Session::has('message'))
	<div class="alert alert-success">{{ Session::get('message') }}</div>
@endif
@if (Session::has('error'))
	<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

	{{ Form::open(array('url'=>'inspec_equipos/submit_create_ot', 'role'=>'form')) }}
		{{ Form::hidden('idot_inspec_equipo', $ot_info->idot_inspec_equipo,array('id'=>'idot_inspec_equipo'))}}
		{{ Form::hidden('idservicio', $ot_info->idservicio) }}
		{{ Form::hidden('count_activos', count($activos_info),array('id'=>'count_activos')) }}
		
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
						<div class="form-group col-md-8">
							{{ Form::label('numero_ficha','Número de Ficha') }}
							{{ Form::text('numero_ficha',$ot_info->numero_ficha,array('class' => 'form-control','placeholder'=>'Ingrese número de ficha')) }}
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
							{{ Form::label('nombre_ubicacion','Ubicación Física') }}
							{{ Form::text('nombre_ubicacion',$ot_info->nombre_ubicacion,array('class' => 'form-control','readonly'=>'')) }}
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
					<div class="col-md-9" >
						<div class="table-responsive" style="margin-left:250px">
							<table class="table" id="table_equipos">
								<tr class="info">
									<th class="text-nowrap text-center">Equipo</th>
									<th class="text-nowrap text-center">Modelo</th>
									<th class="text-nowrap text-center">Código Patrimonial</th>
									<th class="text-nowrap text-center">Seleccionar</th>
								</tr>
								@foreach($activos_info as $index => $activo)
								<tr>
									<td class="text-nowrap text-center">{{$activo->nombre_familia}}</td>
									<td class="text-nowrap text-center">{{$activo->nombre_modelo}}</td>
									<td class="text-nowrap text-center" id={{"cod_pat".$index}}>{{$activo->codigo_patrimonial}}</td>
									<td class="text-nowrap text-center">{{Form::radio('seleccionar',$index,array('id'=>'fila'.$index)) }}</td>
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
			@foreach($activos_info as $index1 => $activo)
				<div class="row">
					<div class="col-md-6 form-group">
						<div class="table-responsive">
							<table class="table">
								<tr class="info">
									<th>Tarea</th>
									<th>Estado</th>
								</tr>
								@foreach($tareas_activos[$index] as $index2 => $tarea)
									<td>{{$tarea->nombre}}</td>
								@endforeach
							</table>
						</div>
					</div>
					<div class="col-md-6 form-group">
						<label class="control-label">Seleccione una Imagen</label>(png,jpe,jpeg,jpg)
						<input name="archivo" id={{"input-file".$index1}} type="file" class="file file-loading" data-show-upload="false">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						{{ Form::label('observaciones_equipo','Observaciones del Equipo') }}
						{{ Form::textarea('observaciones_equipo',null,array('class' => 'form-control','style'=>'resize:none;')) }}
					</div>
				</div>
				
			@endforeach		
			</div>
		</div>

	{{Form::close()}}

@stop