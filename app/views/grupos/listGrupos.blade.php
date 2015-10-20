@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Grupos de Activos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/grupos/search_grupo','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>
	 	<div class="panel-body">
	 		<div class="row">
				<div class="col-md-4 form-group">
					{{ Form::label('nombre','Nombre de Grupo:')}}
					{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Nombre del Grupo'))}}
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
			<a class="btn btn-primary btn-block" href="{{URL::to('/grupos/create_grupo')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
 
	<table class="table">
		<tr class="info">
			<th>N°</th>
			<th>Nombre del Grupo</th>
			<th>Usuario Responsable</th>
			<th>Fecha de Creación</th>
			<th>Editar</th>
		</tr>
		@foreach($grupos_data as $index => $grupo_data)
		<tr class="@if($grupo_data->deleted_at) bg-danger @endif">			
			<td>
				{{$index+1}}
			</td>
			<td>
				{{$grupo_data->nombre}}
			</td>
			<td>
				{{$grupo_data->nombre_reponsable}} {{$grupo_data->apellido_pat_responsable}} {{$grupo_data->apellido_mat_responsable}}
			</td>
			<td>
				{{$grupo_data->created_at->format('d-m-Y')}}
			</td>
			<td>
				<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/grupos/edit_grupo/')}}/{{$grupo_data->idgrupo}}">
				<span class="glyphicon glyphicon-pencil"></span> Editar</a>
			</td>
		</tr>
		@endforeach		
	</table>
	@if($search)
		{{ $grupos_data->appends(array('search' => $search))->links() }}
	@else	
		{{ $grupos_data->links()}}
	@endif
	
@stop