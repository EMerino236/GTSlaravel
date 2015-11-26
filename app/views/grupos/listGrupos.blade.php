@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Grupos de Activos</h3>
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

    {{ Form::open(array('url'=>'/grupos/search_grupo','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>
	 	<div class="panel-body">
	 		<div class="row">
				<div class="col-md-4 form-group">
					{{ Form::label('search_nombre_grupo','Nombre de Grupo')}}
					{{ Form::text('search_nombre_grupo',$search_nombre_grupo,array('class'=>'form-control','placeholder'=>'Ingrese Nombre del Grupo'))}}
				</div>
				<div class="col-md-2 form-group" style="margin-top:25px">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar',array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="col-md-2 form-group" style="margin-top:25px">
					<div class="btn btn-default btn-block" id="list_group_btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>
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
 	<div class="row">
 		<div class="col-md-12">
 			<div class="table-responsive">
 				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">N°</th>
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
							<a href="{{URL::to('/grupos/view_grupo')}}/{{$grupo_data->idgrupo}}">{{$grupo_data->nombre}}</a>				
						</td>
						<td>
							{{$grupo_data->nombre_responsable}} {{$grupo_data->apellido_pat_responsable}} {{$grupo_data->apellido_mat_responsable}}
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
 			</div>
 		</div>
 	</div>

		
	@if($search_nombre_grupo)
		{{ $grupos_data->appends(array('search_nombre_grupo' => $search_nombre_grupo))->links() }}
	@else	
		{{ $grupos_data->links()}}
	@endif
	
@stop