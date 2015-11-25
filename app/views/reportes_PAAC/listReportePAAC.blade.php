@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reportes Evaluación o Implantación</h3>
            <p class="text-right">{{ HTML::link('/reporte_paac/create_reporte_paac','+ Generar Reporte',array('class'=>'')) }}</p>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/reporte_paac/search_reporte_paac','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_tipo_reporte_paac','Tipo de Reporte:')}}
						{{ Form::select('search_tipo_reporte_paac',array('' => 'Seleccione')+$tipo_reporte_paac, $search_tipo_reporte_paac,array('class'=>'form-control')) }}
					</div>
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
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
						</div>
					</div>
				</div>
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>

	<table class="table">
		<tr class="info">
			<th>N° Reporte</th>
			<th>Fecha y Hora</th>
			<th>Usuario</th>
			<th>Servicio Clínico</th>
			<th>Departamento</th>
		</tr>
		@foreach($reportes_paac_data as $reporte_paac_data)
		<tr class="@if($reporte_paac_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/reporte_paac/edit_reporte_paac/')}}/{{$reporte_paac_data->idreporte_PAAC}}">{{$reporte_paac_data->numero_reporte_abreviatura}}{{$reporte_paac_data->numero_reporte_correlativo}}-{{$reporte_paac_data->numero_reporte_anho}}</a>
			</td>
			<td>
				{{date('d-m-Y H:i',strtotime($reporte_paac_data->created_at))}}
			</td>
			<td>
				{{$reporte_paac_data->apellido_pat}} {{$reporte_paac_data->apellido_mat}} {{$reporte_paac_data->nombre}}
			</td>
			<td>
				{{$reporte_paac_data->nombre_servicio}}
			</td>
			<td>
				{{$reporte_paac_data->nombre_area}}
			</td>		
		</tr>
		@endforeach
	</table>
	<div class="row">
		@if($search_tipo_reporte_paac || $search_numero_reporte || $search_usuario || $search_servicio || $search_area || $search_fecha_ini || $search_fecha_fin)
			{{ $reportes_paac_data->appends(array('search_tipo_reporte_paac' => $search_tipo_reporte_paac,'search_numero_reporte'=>$search_numero_reporte,'search_usuario'=>$search_usuario,'search_servicio'=>$search_servicio,'search_area'=>$search_area,'search_fecha_ini'=>$search_fecha_ini,'search_fecha_fin'=>$search_fecha_fin))->links() }}
		@else
			{{ $reportes_paac_data->links() }}
		@endif
	</div>
@stop