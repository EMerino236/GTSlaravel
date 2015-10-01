@extends('templates/activosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Directorio de Equipos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    {{ Form::open(array('url'=>'/equipos/search_equipos','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_nombreequipo','Nombre de Equipo') }}
				{{ Form::text('search_nombreequipo',$search_nombreequipo,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_marca','Marca') }}
				{{ Form::select('search_marca', array('0' => 'Seleccione') + $marca,$search_marca,['class' => 'form-control']) }}
			</div>
		</div>	

		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
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
				{{$activo_data->codigo_patrimonial}}
			</td>
		</tr>
		@endforeach
		
	</table>
	</div>
	</div>
@stop