@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Requerimientos clinicos y hospitalarios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

{{ Form::open(array('route'=>'requerimientos_clinicos.search','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_nombre','Nombre') }}
				{{ Form::text('search_nombre',$search_nombre,array('class'=>'form-control','placeholder'=>'Nombre')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_categoria','Categoría') }}
				{{ Form::select('search_categoria',[0=>"Seleccione"]+$categorias,$search_categoria,array('class'=>'form-control','placeholder'=>'Categoría')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_servicio_clinico','Servicio Clínico') }}
				{{ Form::select('search_servicio_clinico',[0=>"Seleccione"]+$servicios,$search_servicio_clinico,array('class'=>'form-control','placeholder'=>'Servicio Clínico')) }}
			</div>
		</div>
		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_departamento','Departamento') }}
				{{ Form::select('search_departamento',[0=>"Seleccione"]+$departamentos,$search_departamento,array('class'=>'form-control','placeholder'=>'Departamento')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_tipo','Tipo') }}
				{{ Form::select('search_tipo', $tipos,$search_tipo,array('class'=>'form-control','placeholder'=>'Tipo')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_estado','Estado') }}
				{{ Form::select('search_estado',[0=>"Seleccione"]+$estados,$search_estado,array('class'=>'form-control','placeholder'=>'Estado')) }}
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Filtrar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar" onclick="limpiar_criterios_req_clinico()">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	{{ Form::close() }}</br>

	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{route('requerimientos_clinicos.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tr class="info">
					<th>Código de proyecto</th>
					<th>Nombre</th>
					<th>Categoría</th>
					<th>Servicio Clínico</th>
					<th>Departamento</th>
					<th>Responsable</th>
					<th>Tipo</th>
					<th>Estado</th>
				</tr>
				@foreach($requerimientos_data as $requerimiento_data)
				<tr class="@if($requerimiento_data->id_estado == 1) bg-success @elseif($requerimiento_data->id_estado == 2) bg-danger @endif">
					<td>{{$requerimiento_data->id}}</td>
					<td>
						<a href="{{URL::to('/requerimientos_clinicos/show/')}}/{{$requerimiento_data->id}}">{{$requerimiento_data->nombre}}</a>
					</td>
					<td>{{$requerimiento_data->categoria->nombre}}</td>
					<td>{{$requerimiento_data->servicio->nombre}}</td>
					<td>{{$requerimiento_data->departamento->nombre}}</td>
					<td>{{$requerimiento_data->responsable->nombre}} {{$requerimiento_data->responsable->apellido_pat}} {{$requerimiento_data->responsable->apellido_mat}}</td>	
					<td>{{$tipos[$requerimiento_data->tipo]}}</td>
					<td><b>{{$requerimiento_data->estado->nombre}}</b></td>
				</tr>
				@endforeach
			</table>
		</div>
		<div class="col-md-12">
		@if($search_nombre!=0)
			{{ $requerimientos_data->appends(array('search_nombre' => $search_nombre))->links() }}
		@else
			{{ $requerimientos_data->links() }}
		@endif
		</div>
	</div>
@stop