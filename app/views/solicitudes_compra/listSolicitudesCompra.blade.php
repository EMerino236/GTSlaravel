@extends('templates/solicitudCompraTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Requerimiento de Compras</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
	{{ Form::open(array('url'=>'/solicitudes_compra/search_solicitudes','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
			<div class="form-group row">
				<div class="col-md-4">
					{{ Form::label('search_tipo_solicitud','Tipo:')}}
					{{ Form::select('search_tipo_solicitud',array('0' => 'Seleccione')+ $tipos, $search_tipo_solicitud,array('class'=>'form-control','id'=>'search_tipo_solicitud')) }}
				</div>					
				<div class="col-md-4">
					{{ Form::label('search_nombre_equipo','Nombre de Equipo:')}}
					{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Ingrese Nombre de Equipo','id'=>'search_nombre_equipo')) }}
				</div>
				<div class="col-md-4">
					{{ Form::label('search_servicio','Servicio Clínico:')}}
					{{ Form::select('search_servicio',array('0' => 'Seleccione')+ $servicios, $search_servicio,array('class'=>'form-control','id'=>'servicio_clinico')) }}
				</div>
			</div>
			<div class="form-group row">			
				
				<div class="col-md-4">
					{{ Form::label('search_estado','Estado:')}}
					{{ Form::select('search_estado',array('0' => 'Seleccione')+ $estados, $search_estado,array('class'=>'form-control','id'=>'estados')) }}
				</div>				
				<div class="col-md-4">
					{{ Form::label('fecha_desde','Fecha Desde:')}}
					<div id="datetimepicker1" class="form-group input-group date">					
						{{ Form::text('fecha_desde',$fecha_desde,array('class'=>'form-control','readonly'=>'','id'=>'fecha_desde')) }}
						<span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
        		</div>
				<div class="col-md-4">
					{{ Form::label('fecha_hasta','Fecha Hasta:')}}
					<div id="datetimepicker2" class="form-group input-group date">					
						{{ Form::text('fecha_hasta',$fecha_hasta,array('class'=>'form-control','readonly'=>'','id'=>'fecha_hasta')) }}
						<span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
        		</div>
			</div>	
			<div class="row form-group">
				<div class="col-md-2 col-md-offset-8">	
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}			
				</div>
				<div class="col-md-2">
					<div class="btn btn-default btn-block" id="btnLimpiarCriterios">Limpiar</div>				
				</div>
			</div>
		</div>	
	</div>		
	{{ Form::close() }}
	<div class="container-fluid row form-group">
		<div class="col-md-2 col-md-offset-10">	
			<a class="btn btn-primary btn-block" href="{{URL::to('/solicitudes_compra/create_solicitud')}}"><span class="glyphicon glyphicon-plus"></span>Agregar</a>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table">
			<tr class="info">
				<th class="text-nowrap">N°</th>
				<th class="text-nowrap">Código de Requerimiento</th>
				<th class="text-nowrap">Tipo</th>
				<th class="text-nowrap">Nombre de Equipo</th>
				<th class="text-nowrap">Servicio Clínico</th>
				<th class="text-nowrap">Número OT</th>
				<th class="text-nowrap">Estado</th>
				<th class="text-nowrap">Editar</th>	
			</tr>
			@foreach($solicitudes_data as $index => $solicitud_data)
				<tr>
					<td class="text-nowrap text-center">{{$index+1}}</td>
					<td class="text-nowrap text-center">						
						<a href="{{URL::to('/solicitudes_compra/view_solicitud_compra/')}}/{{$solicitud_data->idsolicitud_compra}}">{{$solicitud_data->idsolicitud_compra}}</a>
					</td>					
					<td class="text-nowrap text-center">{{$solicitud_data->nombre_tipo}}</td>
					<td class="text-nowrap text-center">{{$solicitud_data->nombre_equipo}}</td>
					<td class="text-nowrap text-center">{{$solicitud_data->nombre_servicio}}</td>
					<td class="text-nowrap text-center">{{$solicitud_data->codigo_ot}}</td>
					<td class="text-nowrap text-center">{{$solicitud_data->nombre_estado}}</td>
					<td class="text-nowrap text-center">
						<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/solicitudes_compra/edit_solicitud_compra/')}}/{{$solicitud_data->idsolicitud_compra}}">
						<span class="glyphicon glyphicon-pencil"></span> Editar</a>
					</td>
				</tr>
			@endforeach	
		</table>
	</div>
@stop