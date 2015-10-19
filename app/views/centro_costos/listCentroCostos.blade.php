@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Centros de Costo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/centro_costos/search_centro_costo','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="search_bar">
			{{ Form::label('centro_costo','Nombre del Centro de Costo:')}}
			{{ Form::text('search',Input::old('search'),['class' => 'form-control']) }}
			{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
		</div>	
	{{ Form::close() }}</br> 
	<table class="table">
		<tr class="info">
			<th>N°</th>
			<th>Nombre del Centro de Costo</th>
			<th>Presupuesto</th>
			<th>Fecha Creación</th>
		</tr>
		@foreach($centro_costos as $index => $centro_costo)
		<tr class="@if($centro_costo->deleted_at) bg-danger @endif">			
			<td>
				{{$index+1}}
			</td>
			<td>
				<a href="{{URL::to('/centro_costos/edit_centro_costo/')}}/{{$centro_costo->idcentro_costo}}">
				{{$centro_costo->nombre}}
				</a>
			</td>
			<td>
				{{$centro_costo->presupuesto}}
			</td>
			<td>
				{{$centro_costo->created_at->format('d-m-Y')}}
			</td>
		</tr>
		@endforeach		
	</table>
	@if($search)
		{{ $centro_costos->appends(array('search' => $search))->links() }}
	@else	
		{{ $centro_costos->links()}}
	@endif	
@stop