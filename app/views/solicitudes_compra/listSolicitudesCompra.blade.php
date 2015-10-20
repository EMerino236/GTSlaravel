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
					{{ Form::select('search_tipo_solicitud',array('0' => 'Seleccione')+ $tipos, $search_tipo_solicitud,array('class'=>'form-control')) }}
				</div>					
				<div class="col-md-4">
					{{ Form::label('search_nombre_equipo','Nombre de Equipo:')}}
					{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Ingrese Nombre de Equipo')) }}
				</div>
				<div class="col-md-4">
					{{ Form::label('search_servicio','Servicio Clínico:')}}
					{{ Form::select('search_servicio',array('0' => 'Seleccione')+ $servicios, $search_servicio,array('class'=>'form-control','id'=>'servicio_clinico')) }}
				</div>
			</div>
			<div class="form-group row">			
				
				<div class="col-md-4">
					{{ Form::label('search_estado','Estado:')}}
					{{ Form::select('search_estado',array('0' => 'Seleccione')+ $estados, $search_estado,array('class'=>'form-control')) }}
				</div>				
				<div class="col-md-4">
					{{ Form::label('fecha_desde','Fecha Desde:')}}
					<div id="datetimepicker1" class="form-group input-group date">					
						{{ Form::text('fecha_desde',$fecha_desde,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
        		</div>
				<div class="col-md-4">
					{{ Form::label('fecha_hasta','Fecha Hasta:')}}
					<div id="datetimepicker2" class="form-group input-group date">					
						{{ Form::text('fecha_hasta',$fecha_hasta,array('class'=>'form-control','readonly'=>'')) }}
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
					<div class="btn btn-default btn-block" id="btnLimpiar">Limpiar</div>				
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
				<th>N°</th>
				<th>Código de Requerimiento</th>
				<th>Tipo</th>
				<th>Nombre de Equipo</th>
				<th>Servicio Clínico</th>
				<th>Número OT</th>
				<th>Estado</th>	
			</tr>
			@foreach($solicitudes_data as $index => $solicitud_data)
				<tr>
					<td>{{$index+1}}</td>
					<td>						
						{{$solicitud_data->idsolicitud_compra}}
					</td>					
					<td>{{$solicitud_data->nombre_tipo}}</td>
					<td>{{$solicitud_data->nombre_equipo}}</td>
					<td>{{$solicitud_data->nombre_servicio}}</td>
					<td>{{$solicitud_data->idordenes_trabajo}}</td>
					<td>{{$solicitud_data->nombre_estado}}</td>
				</tr>
			@endforeach	
		</table>
	</div>
@stop