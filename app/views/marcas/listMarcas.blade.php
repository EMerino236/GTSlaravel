@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Marcas</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    {{ Form::open(array('url'=>'/marcas/search_marcas','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="search_bar">
			{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
			{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
		</div>	
	{{ Form::close() }}</br> 	
		<table class="table">
			<tr class="info">
				<th>Nº</th>			
				<th>Nombre</th>
				<th>Fecha de Creación</th>
			</tr>
			@foreach($marcas_data as $index => $marca_data)
			<tr class="@if($marca_data->deleted_at) bg-danger @endif">			
				<td>
					{{$index + 1}}
				</td>	
				<td>
					<a href="{{URL::to('/marcas/edit_marca/')}}/{{$marca_data->idmarca}}">{{$marca_data->nombre}}</a>					
				</td>
				<td>
					{{$marca_data->created_at}}
				</td>
			</tr>
			@endforeach
			
		</table>	
@stop