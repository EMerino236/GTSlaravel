@extends('templates/solicitudCompraTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Requerimiento de Compra N° {{$reporte_data->idsolicitud_compra}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('numero_ot') }}</strong></p>
			<p><strong>{{ $errors->first('servicio') }}</strong></p>
			<p><strong>{{ $errors->first('marca1') }}</strong></p>
			<p><strong>{{ $errors->first('sustento') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_equipo1') }}</strong></p>
			<p><strong>{{ $errors->first('usuario_responsable') }}</strong></p>
			<p><strong>{{ $errors->first('tipo') }}</strong></p>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('numero_reporte') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

		<div>						
			{{ Form::hidden('flag_ot',2,array('id'=>'flag_ot'))}}
		</div>
		{{Form::hidden('reporte_id',$reporte_data->idsolicitud_compra,array('id'=>'reporte_id')) }}
		{{ Form::hidden('type_solicitud',1,array('id'=>'type_solicitud'))}}
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">	
					<div class="form-group row">								
						<div class="form-group col-md-4 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('numero_ot','Número de OT:') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_ot',$reporte_data->codigo_ot,array('class'=>'form-control','readonly'=>'','placeholder'=>'Número de OT','readonly'=>'')) }}
							@else
								{{ Form::text('numero_ot',$reporte_data->codigo_ot,array('class'=>'form-control','placeholder'=>'Número de OT','readonly'=>'')) }}
							@endif	
						</div>
						<div class="form-group col-md-4 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio:') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::select('servicio',array('0'=> 'Seleccione')+ $servicios,$reporte_data->idservicio,array('class'=>'form-control','readonly'=>'','id'=>'servicio','disabled'=>'disabled')) }}
							@else
								{{ Form::select('servicio',array('0'=> 'Seleccione')+ $servicios,$reporte_data->idservicio,array('class'=>'form-control','id'=>'servicio','disabled'=>'disabled')) }}
							@endif							
						</div>
						<div class="form-group col-md-4 @if($errors->first('marca1')) has-error has-feedback @endif">
							{{ Form::label('marca1','Marca:') }}
							@if($reporte_data->deleted_at)
								{{ Form::select('marca1',array('0'=> 'Seleccione')+ $marcas1,$reporte_data->idmarca,array('class'=>'form-control','readonly'=>'','id'=>'marca1','disabled'=>'disabled')) }}
							@else
								{{ Form::select('marca1',array('0'=> 'Seleccione')+ $marcas1,$reporte_data->idmarca,array('class'=>'form-control','id'=>'marca1','disabled'=>'disabled')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('nombre_equipo1')) has-error has-feedback @endif">
							{{ Form::label('nombre_equipo1','Equipo:') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::select('nombre_equipo1',$nombre_equipos1,$reporte_data->idfamilia_activo,array('class'=>'form-control','readonly'=>'','id'=>'equipo1','disabled'=>'disabled')) }}
							@else
								{{ Form::select('nombre_equipo1',$nombre_equipos1,$reporte_data->idfamilia_activo,array('class'=>'form-control','id'=>'equipo1','disabled'=>'disabled')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
							{{ Form::label('usuario_responsable','Usuario Responsable:') }}<span style="color:red"> *</span>
							<select name="usuario_responsable" class="form-control" id="usuario_responsable" disabled="disabled">
								@foreach($usuarios_responsable as $usuario_responsable)
									@if($reporte_data->id_responsable == $usuario_responsable->id)
										<option value="{{ $usuario_responsable->id }}" selected="selected">{{ $usuario_responsable->apellido_pat }} {{ $usuario_responsable->apellido_mat }}, {{ $usuario_responsable->nombre }}</option>
									@else
										<option value="{{ $usuario_responsable->id }}">{{ $usuario_responsable->apellido_pat }} {{ $usuario_responsable->apellido_mat }}, {{ $usuario_responsable->nombre }}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-4 @if($errors->first('tipo')) has-error has-feedback @endif">
							{{ Form::label('tipo','Tipo de Requerimiento:') }}<span style="color:red"> *</span>
							@if($reporte_data->deleted_at)
								{{ Form::select('tipo',array('0'=> 'Seleccione')+ $tipos,$reporte_data->idtipo_solicitud_compra,array('class'=>'form-control','readonly'=>'','id'=>'tipo')) }}
							@else
								{{ Form::select('tipo',array('0'=> 'Seleccione')+ $tipos,$reporte_data->idtipo_solicitud_compra,array('class'=>'form-control','id'=>'tipo','readonly'=>'')) }}
							@endif
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('tiempo_maximo','Tiempo Máximo (Días):') }}
							{{ Form::text('tiempo_maximo','',['class' => 'form-control','id'=>'tiempo_maximo','placeholder'=>'Tiempo Máximo','readonly'=>''])}}
						</div>
						<div class="col-md-4">
							{{ Form::label('fecha','Fecha:')}}<span style="color:red"> *</span>
							{{ Form::text('fecha',date('d-m-Y',strtotime($reporte_data->fecha)),array('class'=>'form-control','readonly'=>'')) }}
        				</div>
        				<div class="col-md-4 form-group">
        					{{ Form::label('estado','Estado:') }}<span style="color:red"> *</span>
        					@if($reporte_data->deleted_at)
								{{ Form::select('estado',array('0'=> 'Seleccione')+ $estados,$reporte_data->idestado,array('class'=>'form-control','readonly'=>'','id'=>'estado','disabled'=>'disabled')) }}
							@else
								{{ Form::select('estado',array('0'=> 'Seleccione')+ $estados,$reporte_data->idestado,array('class'=>'form-control','id'=>'estado','disabled'=>'disabled')) }}
							@endif							
        				</div> 
					</div>
				</div>			
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Sustento</div>
				  	<div class="panel-body">
				  		<div class="form-group row">
				  			<div class="form-group col-md-12 @if($errors->first('sustento')) has-error has-feedback @endif">
					  			{{ Form::label('sustento','Sustento de la solicitud:') }}
								@if($reporte_data->deleted_at)
									{{ Form::textarea('sustento',$reporte_data->sustento,['class' => 'form-control','style'=>'resize:none;','readonly'=>'','placeholder'=>'Texto para explicar nueva adquisición','id'=>'sustento']) }}
								@else
									{{ Form::textarea('sustento',$reporte_data->sustento,['class' => 'form-control','style'=>'resize:none;','placeholder'=>'Texto para explicar nueva adquisición','id'=>'sustento','readonly'=>'']) }}
								@endif									
				  			</div>
				  		</div>
				  	</div>
				</div>
			</div>
		</div>
		
		
		
		<div class="container-fluid row">
			<h3> Detalle de Solicitud de Compra</h3>
			<div class="col-md-12 form-group">
				<div class="table-responsive">
				<table class="table" id="table_solicitud">
					<tr class="info">
						<th class="text-nowrap text-center">Descripción</th>
						<th class="text-nowrap text-center">Marca</th>
						<th class="text-nowrap text-center">Modelo</th>
						<th class="text-nowrap text-center">Serie/Número de Parte</th>
						<th class="text-nowrap text-center">Cantidad</th>
					</tr>					
					@foreach($detalles_solicitud as $index => $detalle_solicitud)
						<tr>
							{{Form::hidden('iddetalle',$detalle_solicitud->iddetalle_solicitud_compra,array('id'=>'iddetalle'.$index))}}
							<td id="{{$index}}"  class="text-nowrap text-center">{{$detalle_solicitud->descripcion}}</td>
							<td class="text-nowrap text-center">{{$detalle_solicitud->marca}}</td>
							<td class="text-nowrap text-center">{{$detalle_solicitud->modelo}}</td>
							<td class="text-nowrap text-center">{{$detalle_solicitud->serie_parte}}</td>
							<td class="text-nowrap text-center">{{$detalle_solicitud->cantidad}}</td>
						</tr>
					@endforeach					
				</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
	  				<div class="panel-heading">Documento Relacionado</div>
	  				<div class="panel-body">
						<div class="row">								
							<div class="form-group col-md-2 @if($errors->first('numero_reporte')) has-error has-feedback @endif">
								{{ Form::label('numero_reporte','N° Reporte:') }}<span style="color:red"> *</span>
								@if($documento_info->deleted_at)
									{{ Form::text('numero_reporte',$documento_info->codigo_archivamiento,array('class'=>'form-control','readonly'=>'','id'=>'numero_reporte')) }}
								@else
									{{ Form::text('numero_reporte',$documento_info->codigo_archivamiento,array('class'=>'form-control','id'=>'numero_reporte','readonly'=>'')) }}
								@endif								
							</div>
							<div class="form-group col-md-4">
								{{ Form::label('nombre_reporte','Documento') }}
								@if($reporte_data->deleted_at)
									{{ Form::text('nombre_reporte',$documento_info->nombre,array('class'=>'form-control','readonly'=>'','id'=>'nombre_reporte')) }}
								@else
									{{ Form::text('nombre_reporte',$documento_info->nombre,array('class'=>'form-control','id'=>'nombre_reporte')) }}
								@endif
							</div>									
							<div class="form-group col-md-2">
								{{ Form::open(array('url'=>'solicitudes_compra/download_reporte', 'role'=>'form')) }}
								{{ Form::hidden('numero_reporte_hidden',null)}}
								{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', array('id'=>'btn_descarga', 'type' => 'submit', 'class' => 'btn btn-primary btn-block','style'=>'margin-top:25px')) }}
								{{ Form::close() }}
							</div>									
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row container-fluid">
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/solicitudes_compra/list_solicitudes')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>					
			</div>
			{{Form::open(array('url'=>'solicitudes_compra/export_pdf', 'role'=>'form'))}}		
				{{Form::hidden('solicitud_id',$reporte_data->idsolicitud_compra) }}
				<div class="form-group col-md-2 col-md-offset-8">
					{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar', 'type'=>'submit' ,'class' => 'btn btn-success btn-block')) }}
				</div>
			{{ Form::close() }}			
		</div>	
			
@stop