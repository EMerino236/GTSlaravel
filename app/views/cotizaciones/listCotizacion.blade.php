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
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_nombre_equipo','Nombre de Equipo') }}
				{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Nombre de Equipo')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_nombre_detallado','Nombre Detallado') }}
				{{ Form::text('search_nombre_detallado',$search_nombre_detallado,array('class'=>'form-control','placeholder'=>'Nombre Detallado'))  }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_marca','Marca') }}				
				{{ Form::text('search_marca',$search_marca,array('class'=>'form-control','placeholder'=>'Marca')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_modelo','Modelo') }}
				{{ Form::text('search_modelo',$search_modelo,array('class'=>'form-control','placeholder'=>'Modelo')) }}
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar">Limpiar</div>				
			</div>
		</div>

	  </div>
	</div>
	{{ Form::close() }}</br>	
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/documento/create_documento')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<table class="table">
		<tr class="info">
			<th>Nombre de Equipo</th>
			<th>Nombre Detallado</th>
			<th>Marca</th>
			<th>Modelo</th>
		</tr>
		@foreach($cotizaciones_data as $cotizacion_data)
		<tr class="@if($cotizacion_data->deleted_at) bg-danger @endif">
			<td>
				<a>{{$cotizacion_data->nombre}}</a>
			</td>
			<td>
				{{$cotizacion_data->autor}}
			</td>
			<td>
				{{$cotizacion_data->codigo_archivamiento}}
			</td>
			<td>
				{{$cotizacion_data->ubicacion}}
			</td>
		</tr>
		@endforeach
	</table>
@stop