@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Presupuesto por Capacitacion</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

{{ Form::open(array('route'=>'presupuesto_capacitacion.search','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
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
				{{ Form::label('search_tipo','Tipo') }}
				{{ Form::select('search_tipo',[0=>"Seleccione"]+$tipos,$search_tipo,array('class'=>'form-control')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_modalidad','Modalidad') }}
				{{ Form::select('search_modalidad',[0=>"Seleccione"]+$modalidades,$search_modalidad,array('class'=>'form-control')) }}
			</div>
		</div>
		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_servicio_clinico','Servicio Clínico') }}
				{{ Form::select('search_servicio_clinico',[0=>"Seleccione"]+$servicios,$search_servicio_clinico,array('class'=>'form-control')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_departamento','Departamento') }}
				{{ Form::select('search_departamento',[0=>"Seleccione"]+$departamentos,$search_departamento,array('class'=>'form-control')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_responsable','Responsable') }}
				{{ Form::select('search_responsable',[0=>"Seleccione"]+$usuarios,$search_responsable,array('class'=>'form-control')) }}
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Filtrar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar" onclick="limpiarCriteriosPresupuestoCapacitacion()">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	{{ Form::close() }}</br>

	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{route('presupuesto_capacitacion.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tr class="info">
					<th>Código Capacitación</th>
					<th>Nombre</th>
					<th>Tipo</th>
					<th>Modalidad</th>
					<th>Servicio Clínico</th>
					<th>Departamento</th>
					<th>Responsable</th>
				</tr>
				@foreach($proyectos_data as $reporte_data)
				<tr class="@if($reporte_data->deleted_at) bg-danger @endif">
					<td>
						<a href="{{route('presupuesto_capacitacion.show',$reporte_data->id)}}">{{$reporte_data->capacitacion->codigo}}</a>
					</td>
					<td>{{$reporte_data->nombre}}</td>
					<td>{{$reporte_data->tipo->nombre}}</td>
					<td>{{$reporte_data->modalidad->nombre}}</td>
					<td>{{$reporte_data->servicio->nombre}}</td>
					<td>{{$reporte_data->departamento->nombre}}</td>
					<td>{{$reporte_data->responsable->UserFullName}}</td>
				</tr>
				@endforeach
			</table>
		</div>
		<div class="col-md-12">
		@if($search_nombre || $search_tipo!=0 || $search_modalidad!=0 || $search_servicio_clinico != 0 || $search_departamento != 0 || $search_responsable != 0)
			{{ $proyectos_data->appends(['search_nombre' => $search_nombre,'search_tipo'=>$search_tipo, 'search_modalidad'=>$search_modalidad,'search_servicio_clinico'=>$search_servicio_clinico,'search_departamento'=>$search_departamento,'search_responsable'=>$search_responsable])->links() }}
		@else
			{{ $proyectos_data->links() }}
		@endif
		</div>
	</div>
@stop