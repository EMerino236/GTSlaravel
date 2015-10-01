@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Servicios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/servicios/search_servicio','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="search_bar">
			{{ Form::label('tipo_servicio','Tipo de Servicio:')}}
			{{ Form::select('search',array('0'=> 'Seleccione')+$tipo_servicio,Input::old('search'),['class' => 'form-control']) }}
			{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
		</div>	
	{{ Form::close() }}</br>
 
	<table class="table">
		<tr class="info">
			<th>N°</th>
			<th>Nombre del Servicio</th>
			<th>Tipo de Servicio</th>
			<th>Fecha de Creación</th>
		</tr>
		@foreach($servicios_data as $index => $servicio_data)
		<tr class="@if($servicio_data->deleted_at) bg-danger @endif">			
			<td>
				{{$index+1}}
			</td>
			<td>
				<a href="{{URL::to('/servicios/edit_servicio/')}}/{{$servicio_data->idservicio}}">
				{{$servicio_data->nombre}}
				</a>
			</td>
			<td>
				{{$servicio_data->nombre_tipo_servicio}}
			</td>
			<td>
				{{$servicio_data->created_at->format('d-m-Y')}}
			</td>
		</tr>
		@endforeach		
	</table>
	@if($search)
		{{ $servicios_data->appends(array('search' => $search))->links() }}
	@else	
		{{ $servicios_data->links()}}
	@endif
	
@stop