@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reportes de Priorización</h3>            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/reporte_priorizacion/search_reporte_priorizacion','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_numero_reporte','Número de Reporte:') }}
						{{ Form::text('search_numero_reporte',$search_numero_reporte,array('class'=>'form-control','placeholder'=>'Número de Reporte')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_usuario','Usuario:') }}
						{{ Form::text('search_usuario',$search_usuario,array('class'=>'form-control','placeholder'=>'Usuario')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_servicio','Servicio:')}}
						{{ Form::select('search_servicio',array('' => 'Seleccione')+$servicio, $search_servicio,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_area','Departamento:')}}
						{{ Form::select('search_area',array('' => 'Seleccione')+$area, $search_area,array('class'=>'form-control')) }}
					</div>				
					<div class="form-group col-md-4">
						{{ Form::label('search_fecha_ini','Fecha inicio') }}
						<div id="search_datetimepicker1" class="form-group input-group date">
							{{ Form::text('search_fecha_ini',$search_fecha_ini,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_fecha_fin','Fecha fin') }}
						<div id="search_datetimepicker2" class="input-group date">
							{{ Form::text('search_fecha_fin',$search_fecha_fin,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-12">
					<div class="form-group col-md-2 col-md-offset-8">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
					</div>
					<div class="form-group col-md-2">
						<div class="btn btn-default btn-block" id="btnLlimpiar_criterios_list_reporte_priorizacion"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
					</div>
				</div>
				</div>
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>
	<div class="container-fluid form-group row">
		<div class="col-md-3 col-md-offset-9">
			<a class="btn btn-primary btn-block" href="{{URL::to('/reporte_priorizacion/create_reporte_priorizacion')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar Reporte</a>
		</div>
	</div>
	<table class="table">
		<tr class="info">
			<th>N° Reporte</th>
			<th>Fecha y Hora</th>
			<th>Usuario</th>
			<th>Servicio Clínico</th>
			<th>Departamento</th>
		</tr>
		@foreach($reportes_priorizacion_data as $reporte_priorizacion_data)
		<tr class="@if($reporte_priorizacion_data->deleted_at) bg-danger @endif">
			<td>
				@if($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
					<a href="{{URL::to('/reporte_priorizacion/edit_reporte_priorizacion/')}}/{{$reporte_priorizacion_data->idreporte_priorizacion}}">{{$reporte_priorizacion_data->numero_reporte_abreviatura}}{{$reporte_priorizacion_data->numero_reporte_correlativo}}-{{$reporte_priorizacion_data->numero_reporte_anho}}</a>
				@endif
				@if($user->idrol == 7 || $user->idrol == 8 || $user->idrol == 9 || $user->idrol == 10 || $user->idrol == 11 || $user->idrol == 12)
					<a href="{{URL::to('/reporte_priorizacion/view_reporte_priorizacion/')}}/{{$reporte_priorizacion_data->idreporte_priorizacion}}">{{$reporte_priorizacion_data->numero_reporte_abreviatura}}{{$reporte_priorizacion_data->numero_reporte_correlativo}}-{{$reporte_priorizacion_data->numero_reporte_anho}}</a>
				@endif
			</td>
			<td>
				{{date('d-m-Y H:i',strtotime($reporte_priorizacion_data->created_at))}}
			</td>
			<td>
				{{$reporte_priorizacion_data->apellido_pat}} {{$reporte_priorizacion_data->apellido_mat}} {{$reporte_priorizacion_data->nombre}}
			</td>
			<td>
				{{$reporte_priorizacion_data->nombre_servicio}}
			</td>
			<td>
				{{$reporte_priorizacion_data->nombre_area}}
			</td>	
		</tr>
		@endforeach
	</table>
	<div class="row">
		@if($search_numero_reporte || $search_usuario || $search_servicio || $search_area || $search_fecha_ini || $search_fecha_fin)
			{{ $reportes_priorizacion_data->appends(array('search_numero_reporte'=>$search_numero_reporte,'search_usuario'=>$search_usuario,'search_servicio'=>$search_servicio,'search_area'=>$search_area,'search_fecha_ini'=>$search_fecha_ini,'search_fecha_fin'=>$search_fecha_fin))->links() }}
		@else
			{{ $reportes_priorizacion_data->links() }}
		@endif
	</div>
@stop