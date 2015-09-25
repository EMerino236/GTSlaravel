@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Áreas</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
 
	<table class="table">
		<tr class="info">
			<th>Código de Área</th>
			<th>Nombre</th>
			<th>Tipo de Área</th>
		</tr>
		@foreach($areas_data as $area_data)
		<tr class="@if($area_data->deleted_at) bg-danger @endif">			
			<td>
				{{$area_data->idarea}}
			</td>
			<td>
				{{$area_data->nombre}}
			</td>
			<td>
				{{$area_data->nombre_tipo_area}}
			</td>
		</tr>
		@endforeach
		
	</table>
	
@stop