@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Familia de Equipos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    {{ Form::open(array('url'=>'/familia_activos/search_familia_activos','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>
	 	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-4">
					{{ Form::label('search_nombre_equipo','Nombre de Equipo') }}
					{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Nombre de Equipo')) }}
				</div>
				<div class="col-md-4">
					{{ Form::label('search_nombre_siga','Nombre SIGA') }}
					{{ Form::text('search_nombre_siga',$search_nombre_siga,array('class'=>'form-control','placeholder'=>'Nombre SIGA')) }}				
				</div>
				<div class="col-md-4">
					{{ Form::label('search_marca','Marca') }}
					{{ Form::select('search_marca', array('0' => 'Seleccione') + $marca,$search_marca,['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2 col-md-offset-8">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
					
				</div>
				<div class="form-group col-md-2">
					<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/familia_activos/create_familia_activo')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table">
			<tr class="info">
				<th>Nº</th>
				<th>Tipo Activo</th>
				<th>Nombre SIGA</th>
				<th>Nombre Equipo</th>				
				<th>Marca</th>
				<th>Editar</th>
			</tr>
			@foreach($familiaactivos_data as $index => $familiaactivo_data)
			<tr class="@if($familiaactivo_data->deleted_at) bg-danger @endif">			
				<td>
					{{$index + 1}}
				</td>
				<td>
					{{$familiaactivo_data->nombre_tipo_activo}}
				</td>
				<td>
					{{$familiaactivo_data->nombre_siga}}
				</td>	
				<td>
					<a href="{{URL::to('/familia_activos/view_familia_activo')}}/{{$familiaactivo_data->idfamilia_activo}}">{{$familiaactivo_data->nombre_equipo}}</a>					
				</td>
				<td>
					{{$familiaactivo_data->nombre_marca}}
				</td>
				<td>
					<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/familia_activos/edit_familia_activo')}}/{{$familiaactivo_data->idfamilia_activo}}">
					<span class="glyphicon glyphicon-pencil"></span> Editar</a>
				</td>
			</tr>
			@endforeach
			
		</table>
	</div>
@stop