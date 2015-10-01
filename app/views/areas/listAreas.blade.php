@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Áreas</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/areas/search_area','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="search_bar">
			{{ Form::label('tipo_area','Tipo de Área:')}}
			{{ Form::select('search',$tipo_area,Input::old('search'),['class' => 'form-control']) }}
			{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
		</div>	
	{{ Form::close() }}</br>
 
	<table class="table">
		<tr class="info">
			<th>N°</th>
			<th>Nombre del Área</th>
			<th>Tipo de Área</th>
			<th>Centro de Costo</th>
			<th>Fecha de Creación</th>
		</tr>
		@foreach($areas_data as $index => $area_data)
		<tr class="@if($area_data->deleted_at) bg-danger @endif">			
			<td>
				{{$index+1}}
			</td>
			<td>
				<a href="{{URL::to('/areas/edit_area/')}}/{{$area_data->idarea}}">
				{{$area_data->nombre}}
				</a>
			</td>
			<td>
				{{$area_data->nombre_tipo_area}}
			</td>
			<td>
				{{$area_data->nombre_centro_costo}}
			</td>
			<td>
				{{$area_data->created_at->format('d-m-Y')}}
			</td>
		</tr>
		@endforeach		
	</table>
	@if($search)
		{{ $areas_data->appends(array('search' => $search))->links() }}
	@else	
		{{ $areas_data->links()}}
	@endif
	
@stop