@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Dimensiones</h3>
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

    {{ Form::open(array('route'=>'dimensiones.search','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>	
	  	<div class="panel-body">
			<div class="row">
				<div class="col-md-4 form-group">
					{{ Form::label('search_nombre','Nombre de la Dimensión:')}}
					{{ Form::text('search_nombre',$search_nombre,array('class'=>'form-control','placeholder'=>'Nombre de la Dimensión')) }}					
				</div>

				<div class="col-md-2 form-group">
					{{ Form::label('','&zwnj;&zwnj;') }}
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar',array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="col-md-2 form-group">
					{{ Form::label('','&zwnj;&zwnj;') }}
					<div class="btn btn-default btn-block" onClick="limpiar_criterios_dimensiones()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{route('dimensiones.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div> 
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">N°</th>
						<th class="text-nowrap text-center">Nombre</th>
						<th class="text-nowrap text-center">Fecha de Creación</th>
						<th class="text-nowrap text-center">Editar</th>
					</tr>
					@foreach($dimensiones as $dimension)
					<tr class="@if($dimension->deleted_at) bg-danger @endif">			
						<td class="text-nowrap text-center">
							{{$dimension->id}}
						</td>
						<td class="text-nowrap text-center">
							{{$dimension->nombre}}
						</td>
						<td class="text-nowrap text-center">
							{{$dimension->created_at->format('Y-m-d')}}
						</td>
						<td class="text-nowrap">
							<a class="btn btn-warning btn-block btn-sm" href="{{route('dimensiones.edit',$dimension->id)}}">
							<span class="glyphicon glyphicon-pencil"></span></a>
						</td>
					</tr>
					@endforeach		
				</table>
			</div>
		</div>
	</div>
	
	@if($search_nombre)
		{{ $dimensiones->appends(array('search_nombre' => $search_nombre))->links() }}
	@else	
		{{ $dimensiones->links()}}
	@endif	
@stop