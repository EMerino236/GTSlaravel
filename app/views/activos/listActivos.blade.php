@extends('templates/activosTemplate')
@section('content')
	
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Directorio de Equipos</h3>
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
		<div class="alert alert-danger alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

    {{ Form::open(array('url'=>'/equipos/search_equipos','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_grupo','Grupo') }}
				{{ Form::select('search_grupo', array('0' => 'Seleccione') + $grupos,$search_grupo,['class' => 'form-control']) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_servicio','Servicio Clínico') }}
				{{ Form::select('search_servicio', array('0' => 'Seleccione') + $servicio,$search_servicio,['class' => 'form-control']) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_ubicacion','Ubicación') }}
				{{ Form::select('search_ubicacion', array('0' => 'Seleccione'),$search_ubicacion,['class' => 'form-control']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_nombre_siga','Nombre SIGA') }}				
				{{ Form::text('search_nombre_siga',$search_nombre_siga,array('class'=>'form-control','placeholder'=>'Nombre SIGA')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_nombre_equipo','Nombre de Equipo') }}				
				{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Nombre de Equipo')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_marca','Marca') }}
				{{ Form::select('search_marca', array('0' => 'Seleccione') + $marca,$search_marca,['class' => 'form-control']) }}				
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_modelo','Modelo') }}				
				{{ Form::text('search_modelo',$search_modelo,array('class'=>'form-control','placeholder'=>'Modelo')) }}				
			</div>
			<div class="col-md-4">
				{{ Form::label('search_serie','Número de Serie') }}				
				{{ Form::text('search_serie',$search_serie,array('class'=>'form-control','placeholder'=>'Número de Serie')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_proveedor','Proveedor') }}
				{{ Form::select('search_proveedor', array('0' => 'Seleccione') + $proveedor,$search_proveedor,['class' => 'form-control']) }}								
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_codigo_compra','Código de Compra') }}				
				{{ Form::text('search_codigo_compra',$search_codigo_compra,array('class'=>'form-control','placeholder'=>'Código de Compra')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_codigo_patrimonial','Código Patrimonial') }}				
				{{ Form::text('search_codigo_patrimonial',$search_codigo_patrimonial,array('class'=>'form-control','placeholder'=>'Código Patrimonial')) }}
			</div>			
		</div>		

		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	
	{{ Form::close() }}	
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/equipos/create_equipo')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

    <div class="row">
    	<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap">Nº</th>
						<th class="text-nowrap">Grupo</th>
						<th class="text-nowrap">Servicio Clinico</th>						
						<th class="text-nowrap">Nombre SIGA</th>
						<th class="text-nowrap">Nombre de Equipo</th>
						<th class="text-nowrap">Marca</th>
						<th class="text-nowrap">Modelo</th>
						<th class="text-nowrap">Serie</th>
						<th class="text-nowrap">Proveedor</th>
						<th class="text-nowrap">Código de Compra</th>
						<th class="text-nowrap">Código Patrimonial</th>
						<th class="text-nowrap">Soporte Técnico</th>
						<th class="text-nowrap">Editar</th>
					</tr>
					@foreach($activos_data as $index => $activo_data)
					<tr class="@if($activo_data->deleted_at) bg-danger @endif">			
						<td class="text-nowrap">
							{{$index + 1}}
						</td>	
						<td class="text-nowrap">
							{{$activo_data->nombre_grupo}}
						</td>
						<td class="text-nowrap">
							{{$activo_data->nombre_servicio}}
						</td>						
						<td class="text-nowrap">
							{{$activo_data->nombre_siga}}
						</td>
						<td class="text-nowrap">
							{{$activo_data->nombre_equipo}}
						</td>
						<td class="text-nowrap">
							{{$activo_data->nombre_marca}}
						</td>
						<td class="text-nowrap">
							{{$activo_data->modelo}}
						</td>
						<td class="text-nowrap">
							{{$activo_data->numero_serie}}
						</td>
						<td class="text-nowrap">
							{{$activo_data->nombre_proveedor}}
						</td>
						<td class="text-nowrap">
							{{$activo_data->codigo_compra}}
						</td>
						<td>
							<a href="{{URL::to('/equipos/view_equipo/')}}/{{$activo_data->idactivo}}">{{$activo_data->codigo_patrimonial}}</a>							
						</td>
						<td>
							<a class="btn btn-success btn-block btn-sm" href="{{URL::to('/equipos/create_soporte_tecnico_equipo/')}}/{{$activo_data->idactivo}}">
							<span class="glyphicon glyphicon-plus"></span> Agregar</a>
						</td>
						<td>
							<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/equipos/edit_equipo/')}}/{{$activo_data->idactivo}}">
							<span class="glyphicon glyphicon-pencil"></span> Editar</a>
						</td>
					</tr>
					@endforeach				
				</table>
			</div>
		</div>
	</div>	
@stop