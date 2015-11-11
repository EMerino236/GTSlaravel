@extends('templates/otInspeccionEquiposTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programación de inspección de equipos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
		<div class="container-fluid form-group row">
			<div class="col-md-4 col-md-offset-8">
				<a class="btn btn-primary btn-block" href="{{URL::to('/inspec_equipos/programacion')}}">
				<span class="glyphicon glyphicon-plus"></span> Agregar Inspección de Equipos</a>
			</div>
		</div>
    {{ Form::open(array('url'=>'/inspec_equipos/search_ot_inspec_equipos','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Búsqueda</h3>
				</div>
				<div class="panel-body">
					<div class="container-fluid form-group row">
						<div class="form-group col-md-4">
							{{ Form::label('search_ing','Ingeniero a cargo') }}
							{{ Form::text('search_ing',$search_ing,array('class'=>'form-control','placeholder'=>'Nombre o apellidos','id'=>'search_ing')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_ot','Orden de Trabajo de Mantenimiento') }}
							{{ Form::text('search_ot',$search_ot,array('class'=>'form-control','placeholder'=>'Número de OT','id'=>'search_ot')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_servicio','Servicio') }}
							{{ Form::select('search_servicio', array('0' => 'Seleccione') + $servicios ,$search_servicio ,array('class'=>'form-control')) }}
						</div>					
						<div class="form-group col-md-4">
							{{ Form::label('search_ini','Fecha inicio') }}
							<div id="search_datetimepicker1" class="form-group input-group date">
								{{ Form::text('search_ini',$search_ini,array('class'=>'form-control','id'=>'search_fecha_inicio')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
							</div>
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_fin','Fecha fin') }}
							<div id="search_datetimepicker2" class="input-group date">
								{{ Form::text('search_fin',$search_fin,array('class'=>'form-control','id'=>'search_fecha_fin')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
						</div>					
					</div>
					<div class="container-fluid form-group row">
						<div class="form-group col-md-2 col-md-offset-8">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
						</div>
						<div class="form-group col-md-2">
							<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>					
					</div>
				</div>	
			</div>
		</div>
	</div>
	{{ Form::close() }}	
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<table class="table">
				<tr class="info">
					<th>Fecha</th>
					<th>Departamento</th>
					<th>Servicio</th>
					<th>Ingeniero</th>
					<th>Orden Trabajo Mantenimiento</th>
					<th>Estado</th>
				</tr>
				@foreach($inspecciones_equipos_data as $inspeccion_equipo_data)
				<tr>
					<td>
						{{date('d-m-Y',strtotime($inspeccion_equipo_data->fecha_inicio))}}
					</td>
					<td>
						{{$inspeccion_equipo_data->nombre_area}}
					</td>
					<td>
						{{$inspeccion_equipo_data->nombre_servicio}}
					</td>
					<td>
						{{$inspeccion_equipo_data->apellido_pat}} {{$inspeccion_equipo_data->apellido_mat}}, {{$inspeccion_equipo_data->nombre_user}}
					</td>
					<td>
						<a href="#">{{$inspeccion_equipo_data->ot_tipo_abreviatura}}{{$inspeccion_equipo_data->ot_correlativo}}{{$inspeccion_equipo_data->ot_activo_abreviatura}}</a>
					</td>					
					<td>
						{{$inspeccion_equipo_data->nombre_estado}}
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
	
@stop