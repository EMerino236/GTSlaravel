@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Centros de Costo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/centro_costos/search_centro_costo','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>
	 	<div class="panel-body">
	 		<div class="row">
				<div class="col-md-4 form-group">
					{{ Form::label('centro_costo','Nombre del Centro de Costo:')}}
					{{ Form::text('search',Input::old('search'),['class' => 'form-control']) }}
				</div>
				<div class="col-md-2 form-group" style="margin-top:25px">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar',array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
				</div>			
			</div>
		</div>
	</div>
	{{ Form::close() }}
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/centro_costos/create_centro_costo')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
	<table class="table">
		<tr class="info">
			<th>N°</th>
			<th>Nombre del Centro de Costo</th>
			<th>Fecha Creación</th>
			<th>Editar</th>
		</tr>
		@foreach($centro_costos as $index => $centro_costo)
		<tr class="@if($centro_costo->deleted_at) bg-danger @endif">			
			<td>
				{{$index+1}}
			</td>
			<td>
				{{$centro_costo->nombre}}
			</td>
			<td>
				{{$centro_costo->created_at->format('d-m-Y')}}
			</td>
			<td>
				<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/centro_costos/edit_centro_costo/')}}/{{$centro_costo->idcentro_costo}}">
				<span class="glyphicon glyphicon-pencil"></span> Editar</a>
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