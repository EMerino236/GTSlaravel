@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Precios Referenciales</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

{{ Form::open(array('url'=>'/cotizaciones/search_cotizacion','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Datos del Equipo</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('nombre_equipo','Nombre de Equipo') }}
				{{ Form::text('nombre_equipo',$cotizacion_data->nombre_equipo,array('class'=>'form-control','readonly'=>'')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('nombre_detallado','Nombre Detallado') }}
				{{ Form::text('nombre_detallado',$cotizacion_data->nombre_detallado,array('class'=>'form-control','readonly'=>''))  }}
			</div>
		</div>	

	  </div>
	</div>
	{{ Form::close() }}
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Compras INMP</h3>
	  </div>
	  <div class="panel-body">
		<table class="table">
			<tr class="info">
				<th>Código de Compra</th>
				<th>Marca</th>
				<th>Modelo</th>
				<th>Proveedor</th>
				<th>Enlace</th>
				<th>{{$anho_actual-5}}</th>
				<th>{{$anho_actual-4}}</th>
				<th>{{$anho_actual-3}}</th>
				<th>{{$anho_actual-2}}</th>
				<th>{{$anho_actual-1}}</th>
				<th>{{$anho_actual}}</th>
			</tr>
			@foreach($activos_precio_historico as $activo_precio_historico)
			<tr>
				<td>
					{{$activo_precio_historico->codigo_compra}}
				</td>
				<td>
					{{$activo_precio_historico->marca}}
				</td>
				<td>
					{{$activo_precio_historico->modelo_equipo}}
				</td>
				<td>
					{{$activo_precio_historico->proveedor}}
				</td>
				<td>
					{{$activo_precio_historico->enlace_seace}}
				</td>
				<td>
					{{$activo_precio_historico->precio1}}
				</td>
				<td>
					{{$activo_precio_historico->precio2}}
				</td>
				<td>
					{{$activo_precio_historico->precio3}}
				</td>
				<td>
					{{$activo_precio_historico->precio4}}
				</td>
				<td>
					{{$activo_precio_historico->precio5}}
				</td>
				<td>
					{{$activo_precio_historico->precio6}}
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Cotizaciones</h3>
	  </div>
	  <div class="panel-body">
		<table class="table">
			<tr class="info">
				<th>Código Cotización</th>
				<th>Marca</th>
				<th>Modelo</th>
				<th>Proveedor</th>
				<th>Enlace</th>
				<th>{{$anho_actual-5}}</th>
				<th>{{$anho_actual-4}}</th>
				<th>{{$anho_actual-3}}</th>
				<th>{{$anho_actual-2}}</th>
				<th>{{$anho_actual-1}}</th>
				<th>{{$anho_actual}}</th>
			</tr>
			@foreach($cotizaciones_historico as $cotizacion_historico)
			<tr>
				<td>
					{{$cotizacion_historico->codigo_cotizacion}}
				</td>
				<td>
					{{$cotizacion_historico->marca}}
				</td>
				<td>
					{{$cotizacion_historico->modelo_equipo}}
				</td>
				<td>
					{{$cotizacion_historico->proveedor}}
				</td>
				<td>
					{{$cotizacion_historico->enlace_seace}}
				</td>
				<td>
					{{$cotizacion_historico->precio1}}
				</td>
				<td>
					{{$cotizacion_historico->precio2}}
				</td>
				<td>
					{{$cotizacion_historico->precio3}}
				</td>
				<td>
					{{$cotizacion_historico->precio4}}
				</td>
				<td>
					{{$cotizacion_historico->precio5}}
				</td>
				<td>
					{{$cotizacion_historico->precio6}}
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Referencias Seace</h3>
	  </div>
	  <div class="panel-body">
		<table class="table">
			<tr class="info">
				<th>Referencia Seace</th>
				<th>Marca</th>
				<th>Modelo</th>
				<th>Proveedor</th>
				<th>Enlace</th>
				<th>{{$anho_actual-5}}</th>
				<th>{{$anho_actual-4}}</th>
				<th>{{$anho_actual-3}}</th>
				<th>{{$anho_actual-2}}</th>
				<th>{{$anho_actual-1}}</th>
				<th>{{$anho_actual}}</th>
			</tr>
			@foreach($referencias_seace_historico as $referencia_seace_historico)
			<tr>
				<td>
					-
				</td>
				<td>
					{{$referencia_seace_historico->marca}}
				</td>
				<td>
					{{$referencia_seace_historico->modelo_equipo}}
				</td>
				<td>
					{{$referencia_seace_historico->proveedor}}
				</td>
				<td>
					{{$referencia_seace_historico->enlace_seace}}
				</td>
				<td>
					{{$referencia_seace_historico->precio1}}
				</td>
				<td>
					{{$referencia_seace_historico->precio2}}
				</td>
				<td>
					{{$referencia_seace_historico->precio3}}
				</td>
				<td>
					{{$referencia_seace_historico->precio4}}
				</td>
				<td>
					{{$referencia_seace_historico->precio5}}
				</td>
				<td>
					{{$referencia_seace_historico->precio6}}
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	</div>
	{{Form::open(array('url'=>'cotizaciones/export_pdf', 'role'=>'form'))}}		
		{{ Form::hidden('idcotizacion', $cotizacion_data->idcotizacion) }}
		<div class="form-group col-md-2">
			{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar', 'type'=>'submit' ,'class' => 'btn btn-success btn-block')) }}
		</div>
	{{ Form::close() }}
	<div class="form-group col-md-2">
		<a class="btn btn-default btn-block" href="{{URL::to('/cotizaciones/list_cotizacion')}}">Cancelar</a>				
	</div>
@stop