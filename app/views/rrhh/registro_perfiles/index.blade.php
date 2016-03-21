@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Registro de perfiles profesionales</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

{{ Form::open(array('route'=>'registro_perfil.search','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="form-group col-xs-4">
				{{ Form::label('search_rol','Rol Institucional') }}
				{{ Form::text('search_rol',$search_rol,array('class'=>'form-control','placeholder'=>'Nombre')) }}
			</div>
			<div class="form-group col-xs-4">
				{{ Form::label('search_dni','DNI') }}
				{{ Form::text('search_dni',$search_dni,array('class'=>'form-control','placeholder'=>'DNI')) }}
			</div>
			<div class="form-group col-xs-4">
				{{ Form::label('search_nombre','Nombre') }}
				{{ Form::text('search_nombre',$search_nombre,array('class'=>'form-control','placeholder'=>'Nombre')) }}
			</div>
			<div class="form-group col-xs-4">
				{{ Form::label('search_pais','Pais de Nacimiento') }}
				{{ Form::select('search_pais',[0=>"Seleccione"]+$paises,$search_pais,array('class'=>'form-control')) }}
			</div>
		</div>
	  </div>
	</div>
	{{ Form::close() }}</br>

	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{route('registro_perfil.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tr class="info">
					<th>Nombres</th>
					<th>Apellido Paterno</th>
					<th>Apellido Materno</th>
					<th>DNI</th>
					<th>Pais de Nacimiento</th>
					<th>Institucion donde pertenece</th>
					<th>Rol Insitiucional</th>
					<th>CV</th>
				</tr>
				@foreach($perfiles_data as $reporte_data)
				<tr class="@if($reporte_data->deleted_at) bg-danger @endif">
					<td>{{$reporte_data->nombres}}</td>
					<td>{{$reporte_data->apellido_paterno}}</td>
					<td>{{$reporte_data->apellido_materno}}</td>
					<td>{{$reporte_data->dni}}</td>
					<td>{{$reporte_data->paisNacimiento->nombre}}</td>
					<td>{{$reporte_data->institucion}}</td>
					<td>{{$roles[$reporte_data->id_rol]}}</td>
					<td>
						<a href="{{route('registro_perfil.show',$reporte_data->id)}}">
							{{ Form::button('<span class="glyphicon glyphicon-search"></span> Ver', ['class' => 'btn btn-primary btn-block']) }}
						</a>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
		<div class="col-md-12">
		@if($search_rol || $search_dni || $search_nombre || $search_pais != 0)
			{{ $perfiles_data->appends(['search_rol' => $search_rol,'search_dni'=>$search_dni, 'search_nombre'=>$search_nombre,'search_pais'=>$search_pais])->links() }}
		@else
			{{ $perfiles_data->links() }}
		@endif
		</div>
	</div>
@stop
