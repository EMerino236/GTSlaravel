@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Marcas</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

    {{ Form::open(array('url'=>'/marcas/search_marcas','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}		
		<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>
	 	<div class="panel-body">
	 		<div class="row">
				<div class="col-md-4 form-group">
					{{ Form::label('search_nombre_marca','Nombre de Marca')}}
					{{ Form::text('search_nombre_marca',$search_nombre_marca,array('class'=>'form-control','placeholder'=>'Nombre de la Marca'))}}
				</div>
				<div class="col-md-2 form-group" style="margin-top:25px">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar',array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="col-md-2 form-group" style="margin-top:25px">
					<div class="btn btn-default btn-block" id="list_marca_btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>
				</div>
			</div>
		</div>
	</div>	
	{{ Form::close() }}

	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/marcas/create_marca')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<table class="table">
		<tr class="info">
			<th>Nº</th>			
			<th>Nombre</th>
			<th>Fecha de Creación</th>
			<th>Editar</th>
		</tr>
		@foreach($marcas_data as $index => $marca_data)
		<tr class="@if($marca_data->deleted_at) bg-danger @endif">			
			<td>
				{{$index + 1}}
			</td>	
			<td>
				{{$marca_data->nombre}}
			</td>
			<td>
				{{$marca_data->created_at->format('d-m-Y')}}
			</td>
			<td>
				<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/marcas/edit_marca/')}}/{{$marca_data->idmarca}}">
				<span class="glyphicon glyphicon-pencil"></span> Editar</a>
			</td>
		</tr>
		@endforeach			
	</table>
	@if($search_nombre_marca)
	{{ $marcas_data->appends(array('search_nombre_marca' => $search_nombre_marca))->links() }}
	@else	
	{{ $marcas_data->links()}}
	@endif	
@stop