@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Familia de Activos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    {{ Form::open(array('url'=>'/familia_activos/search_familia_activos','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
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
					<a href="{{URL::to('/familia_activos/edit_familia_activo')}}/{{$familiaactivo_data->idfamilia_activo}}">{{$familiaactivo_data->nombre_equipo}}</a>					
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