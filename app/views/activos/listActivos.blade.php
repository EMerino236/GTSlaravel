@extends('templates/activosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Directorio de Equipos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    {{ Form::open(array('url'=>'/equipos/search_equipos','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_grupo','Grupo') }}
				{{ Form::select('search_grupo', array('0' => 'Seleccione') + $grupos,$search_grupo,['class' => 'form-control']) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_servicio','Servicio Clínico') }}
				{{ Form::select('search_servicio', array('0' => 'Seleccione') + $servicio,$search_servicio,['class' => 'form-control']) }}
			</div>
			<div class="col-xs-4">
				
			</div>
		</div>

		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_nombre_equipo','Nombre de Equipo') }}				
				{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Nombre de Equipo')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_marca','Marca') }}
				{{ Form::select('search_marca', array('0' => 'Seleccione') + $marca,$search_marca,['class' => 'form-control']) }}				
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_modelo','Modelo') }}				
				{{ Form::text('search_modelo',$search_modelo,array('class'=>'form-control','placeholder'=>'Modelo')) }}				
			</div>
		</div>

		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_serie','Número de Serie') }}				
				{{ Form::text('search_serie',$search_serie,array('class'=>'form-control','placeholder'=>'Nombre de Equipo')) }}
			</div>
			<div class="col-xs-4">
								
			</div>
			<div class="col-xs-4">
				
			</div>
		</div>	

		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
			</div>
		</div>

	  </div>
	</div>
	{{ Form::close() }}</br>

    <div class="row">
    	<div class="col-xs-12">
	<table class="table">
		<tr class="info">
			<th>Nº</th>
			<th>Grupo</th>
			<th>Servicio Clinico</th>
			<th>Ubicacion Fisica</th>
			<th>Nombre de Equipo</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Serie</th>
			<th>Proveedor</th>
			<th>Código de Compra</th>
			<th>Código Patrimonial</th>	
		</tr>
		@foreach($activos_data as $index => $activo_data)
		<tr class="@if($activo_data->deleted_at) bg-danger @endif">			
			<td>
				{{$index + 1}}
			</td>	
			<td>
				{{$activo_data->nombre_grupo}}
			</td>
			<td>
				{{$activo_data->nombre_servicio}}
			</td>
			<td>
				{{$activo_data->nombre_ubicacion_fisica}}
			</td>
			<td>
				{{$activo_data->nombre_equipo}}
			</td>
			<td>
				{{$activo_data->nombre_marca}}
			</td>
			<td>
				{{$activo_data->activo_modelo}}
			</td>
			<td>
				{{$activo_data->numero_serie}}
			</td>
			<td>
				{{$activo_data->nombre_proveedor}}
			</td>
			<td>
				{{$activo_data->codigo_compra}}
			</td>
			<td>
				{{$activo_data->codigo_patrimonial}}
			</td>
		</tr>
		@endforeach
		
	</table>
	</div>
	</div>
@stop