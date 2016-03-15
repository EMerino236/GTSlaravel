@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programacion de internado por servicio clinico</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

{{ Form::open(array('route'=>'programacion_internado.search','method'=>'get','class' => 'form-group')) }}
	
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
				{{ Form::label('search_servicio_clinico','Servicio Clínico') }}
				{{ Form::select('search_servicio_clinico',[0=>"Seleccione"]+$servicios,$search_servicio_clinico,array('class'=>'form-control')) }}
			</div>

			<div class="col-xs-4">
				{{ Form::label('search_departamento','Departamento') }}
				{{ Form::select('search_departamento',[0=>"Seleccione"]+$departamentos,$search_departamento,array('class'=>'form-control')) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_responsable','Responsable') }}
				{{ Form::select('search_responsable',[0=>"Seleccione"]+$usuarios,$search_responsable,array('class'=>'form-control')) }}
			</div>

			<div class="col-md-4">
				{{ Form::label('search_fecha_ini','Desde') }}
				<div id="datetimepicker1" class="form-group input-group date">
					{{ Form::text('search_fecha_ini',$search_fecha_ini,array('class'=>'form-control', 'readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
			<div class="col-md-4">
				{{ Form::label('search_fecha_fin','Hasta') }}
				<div id="datetimepicker2" class="form-group input-group date">
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
				<div class="btn btn-default btn-block" id="btnLimpiar" onclick="limpiarCriteriosProgramacionInternado()">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	{{ Form::close() }}</br>

	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{route('programacion_internado.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tr class="info">
					<th>Nombre</th>
					<th>Departamento</th>
					<th>Servicio Clínico</th>
					<th>Responsable</th>
					<th>N° Horas</th>
					<th>Fecha Inicio</th>
					<th>Fecha Fin</th>
					<th>Plan de Aprendizaje</th>
				</tr>
				@foreach($reportes_data as $reporte_data)
				<tr class="@if($reporte_data->deleted_at) bg-danger @endif">
					<td>
						<a href="{{route('programacion_internado.show',$reporte_data->id)}}">
							{{$reporte_data->nombre}}
						</a>
					</td>
					<td>{{$reporte_data->departamento->nombre}}</td>
					<td>{{$reporte_data->servicioClinico->nombre}}</td>
					<td>{{$reporte_data->responsable->UserFullName}}</td>
					<td>{{$reporte_data->num_horas}}</td>
					<td>{{$reporte_data->fecha_ini}}</td>
					<td>{{$reporte_data->fecha_fin}}</td>
					<td class="text-nowrap text-center">
						@if($reporte_data->plan->isEmpty())
						<a class="btn-under" href="{{route('rh_plan_aprendizaje.create',$reporte_data->id)}}">
							{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', ['class' => 'btn btn-success btn-block']) }}
						</a>
						@else
						<a class="btn-under" href="{{route('rh_plan_aprendizaje.show',$reporte_data->plan->first()->id)}}">
							{{ Form::button('<span class="glyphicon glyphicon-search"></span> Ver', ['class' => 'btn btn-success btn-block']) }}
						</a>
						@endif
					</td>
				</tr>
				@endforeach
			</table>
		</div>
		<div class="col-md-12">
		@if($search_nombre || $search_servicio_clinico != 0 || $search_departamento != 0 || $search_responsable != 0 || $search_fecha_ini || $search_fecha_fin)
			{{ $reportes_data->appends(['search_nombre' => $search_nombre,'search_servicio_clinico'=>$search_servicio_clinico,'search_departamento'=>$search_departamento,'search_responsable'=>$search_responsable,'search_fecha_ini'=>$search_fecha_ini,'search_fecha_fin'=>$search_fecha_fin])->links() }}
		@else
			{{ $reportes_data->links() }}
		@endif
		</div>
	</div>
@stop