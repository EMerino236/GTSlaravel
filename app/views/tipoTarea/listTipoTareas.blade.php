@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Tipo de Tareas</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/tipoTarea/search_tipoTarea','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="search_bar">
			{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
			{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
		</div>	
	{{ Form::close() }}</br>

	<table class="table">
		<tr class="info">
			<th>Nombre</th>
			<th>Descripción</th>
		</tr>
		@foreach($tipoTareas_data as $tipoTarea_data)
		<tr class="@if($tipoTarea_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/tipoTarea/edit_tipoTarea/')}}/{{$tipoTarea_data->idtipo_tarea}}">{{$tipoTarea_data->nombre}}</a>
			</td>
			<td>
				{{$tipoTarea_data->descripcion}}
			</td>
		</tr>
		@endforeach
	</table>
	@if($search)
		{{ $tipoTareas_data->appends(array('search' => $search))->links() }}
	@else
		{{ $tipoTareas_data->links() }}
	@endif
@stop