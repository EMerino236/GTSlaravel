@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Familia de Activos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    {{ Form::open(array('url'=>'/familiaactivos/search_familiaactivos','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="search_bar">
			{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
			{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
		</div>	
	{{ Form::close() }}</br> 	
		<table class="table">
			<tr class="info">
				<th>Nº</th>
				<th>Tipo Activo</th>
				<th>Nombre Equipo</th>
				<th>Modelo</th>
				<th>Marca</th>
			</tr>
			@foreach($familiaactivos_data as $index => $familiaactivo_data)
			<tr class="@if($familiaactivo_data->deleted_at) bg-danger @endif">			
				<td>
					{{$index + 1}}
				</td>
				<td>
					{{$familiaactivo_data->nombre_tipoactivo}}
				</td>	
				<td>
					<a href="{{URL::to('/familiaactivos/edit_familiaactivo')}}/{{$familiaactivo_data->idfamilia_activo}}">{{$familiaactivo_data->nombre_equipo}}</a>					
				</td>				
				<td>
					{{$familiaactivo_data->modelo}}
				</td>
				<td>
					{{$familiaactivo_data->nombre_marca}}
				</td>
			</tr>
			@endforeach
			
		</table>	
@stop