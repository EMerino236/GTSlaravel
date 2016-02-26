@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información economica</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

{{ Form::open(array('route'=>'informacion_economica.search','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
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
				{{ Form::select('search_categoria',[0=>"Seleccione"]+$categorias,$search_categoria,array('class'=>'form-control')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_servicio_clinico','Servicio Clínico') }}
				{{ Form::select('search_servicio_clinico',[0=>"Seleccione"]+$servicios,$search_servicio_clinico,array('class'=>'form-control')) }}
			</div>
		</div>
		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_departamento','Departamento') }}
				{{ Form::select('search_departamento',[0=>"Seleccione"]+$departamentos,$search_departamento,array('class'=>'form-control')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_responsable','Responsable') }}
				{{ Form::select('search_responsable',[0=>"Seleccione"]+$usuarios,$search_responsable,array('class'=>'form-control')) }}
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_fecha_ini','Desde') }}
				<div id="datetimepicker_desarrollo_ini" class="form-group input-group date">
					{{ Form::text('search_fecha_ini',$search_fecha_ini,array('class'=>'form-control', 'readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
			<div class="col-md-4">
				{{ Form::label('search_fecha_fin','Hasta') }}
				<div id="datetimepicker_desarrollo_fin" class="form-group input-group date">
					{{ Form::text('search_fecha_fin',$search_fecha_fin,array('class'=>'form-control', 'readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Filtrar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar" onclick="limpiar_criterios_reporte_des()">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	{{ Form::close() }}</br>

	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{route('informacion_economica.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tr class="info">
					<th>Código del Proyecto</th>
					<th>Nombre</th>
					<th>Categoría</th>
					<th>Servicio Clínico</th>
					<th>Departamento</th>
					<th>Responsable</th>
					<th>Fecha de actualización</th>
				</tr>
				@foreach($proyectos_data as $reporte_data)
				<tr class="@if($reporte_data->deleted_at) bg-danger @endif">
					<td>{{$reporte_data->codigo}}</td>
					<td>
						<a href="{{route('proyecto.show',$reporte_data->id)}}">{{$reporte_data->nombre}}</a>
					</td>
					<td>{{$reporte_data->categoria->nombre}}</td>
					<td>{{$reporte_data->servicio->nombre}}</td>
					<td>{{$reporte_data->departamento->nombre}}</td>
					<td>{{$reporte_data->responsable->nombre}} {{$reporte_data->responsable->apellido_pat}} {{$reporte_data->responsable->apellido_mat}}</td>
					<td>{{$reporte_data->updated_at}}</td>
				</tr>
				@endforeach
			</table>
		</div>
		<div class="col-md-12">
		@if($search_nombre || $search_categoria!=0 || $search_servicio_clinico != 0 || $search_departamento != 0 || $search_responsable != 0 || $search_fecha_ini || $search_fecha_ini)
			{{ $proyectos_data->appends(['search_nombre' => $search_nombre,'search_categoria'=>$search_categoria,'search_servicio_clinico'=>$search_servicio_clinico,'search_departamento'=>$search_departamento,'search_responsable'=>$search_responsable,'search_fecha_ini'=>$search_fecha_ini,'search_fecha_ini'=>$search_fecha_ini])->links() }}
		@else
			{{ $proyectos_data->links() }}
		@endif
		</div>
	</div>
@stop