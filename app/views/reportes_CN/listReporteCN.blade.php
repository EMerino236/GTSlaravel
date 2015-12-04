@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reportes para Certificado de Necesidad</h3>            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/reporte_cn/search_reporte_cn','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_tipo_reporte_cn','Tipo de Reporte:')}}
						{{ Form::select('search_tipo_reporte_cn',array('' => 'Seleccione')+$tipo_reporte_cn, $search_tipo_reporte_cn,array('class'=>'form-control')) }}
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
						{{ Form::label('search_nombre_equipo','Nombre de Equipo:') }}
						{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Nombre de Equipo')) }}
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
						<div class="btn btn-default btn-block" id="btnLlimpiar_criterios_list_reporte_cn"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
					</div>
				</div>
				</div>
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>
	<div class="container-fluid form-group row">
		<div class="col-md-3 col-md-offset-9">
			<a class="btn btn-primary btn-block" href="{{URL::to('/reporte_cn/create_reporte_cn')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar Reporte</a>
		</div>
	</div>
	<table class="table">
		<tr class="info">
			<th>N° Reporte</th>
			<th>Fecha y Hora</th>
			<th>Usuario</th>
			<th>Nombre de Equipo</th>
			<th>Servicio Clínico</th>
			<th>Departamento</th>
			<th>OT de Baja de Equipo</th>
		</tr>
		@foreach($reportes_cn_data as $reporte_cn_data)
		<tr class="@if($reporte_cn_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/reporte_cn/edit_reporte_cn/')}}/{{$reporte_cn_data->idreporte_CN}}">{{$reporte_cn_data->numero_reporte_abreviatura}}{{$reporte_cn_data->numero_reporte_correlativo}}-{{$reporte_cn_data->numero_reporte_anho}}</a>
			</td>
			<td>
				{{date('d-m-Y H:i',strtotime($reporte_cn_data->created_at))}}
			</td>
			<td>
				{{$reporte_cn_data->apellido_pat}} {{$reporte_cn_data->apellido_mat}} {{$reporte_cn_data->nombre}}
			</td>
			<td>
				{{$reporte_cn_data->nombre_equipo}}
			</td>
			<td>
				{{$reporte_cn_data->nombre_servicio}}
			</td>
			<td>
				{{$reporte_cn_data->nombre_area}}
			</td>	
			<td>
				<a href="{{URL::to('/retiro_servicio/create_ot/')}}/{{$reporte_cn_data->idot_retiro}}">{{$reporte_cn_data->ot_tipo_abreviatura}}{{$reporte_cn_data->ot_correlativo}}{{$reporte_cn_data->ot_activo_abreviatura}}
			</td>		
		</tr>
		@endforeach
	</table>
	<div class="row">
		@if($search_tipo_reporte_cn || $search_numero_reporte || $search_usuario || $search_servicio || $search_area || $search_nombre_equipo || $search_fecha_ini || $search_fecha_fin)
			{{ $reportes_cn_data->appends(array('search_tipo_reporte_cn' => $search_tipo_reporte_cn,'search_numero_reporte'=>$search_numero_reporte,'search_usuario'=>$search_usuario,'search_servicio'=>$search_servicio,'search_area'=>$search_area,'search_nombre_equipo'=>$search_nombre_equipo,'search_fecha_ini'=>$search_fecha_ini,'search_fecha_fin'=>$search_fecha_fin))->links() }}
		@else
			{{ $reportes_cn_data->links() }}
		@endif
	</div>
@stop