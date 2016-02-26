@extends('templates/reporteInvestigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Reportes de Investigación, Toma de Acciones y Difusión de Eventos Adversos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('message') }}</strong>
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('error') }}</strong>
		</div>
	@endif

{{ Form::open(array('url'=>'/reportes_investigacion/search_reporte','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="row">
			<div class="col-md-4 form-group">
				{{ Form::label('search_codigo_reporte_investigacion','Código de Reporte de Investigación:') }}
				{{ Form::text('search_codigo_reporte_investigacion',$search_codigo_reporte_investigacion,array('class'=>'form-control','placeholder'=>'Ejemplo: RE-2653-16')) }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_codigo_reporte_evento','Código de Reporte de Evento Adverso:') }}
				{{ Form::text('search_codigo_reporte_evento',$search_codigo_reporte_evento,array('class'=>'form-control','placeholder'=>'Ejemplo: EA-2653-16')) }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_entorno_asistencial','Entorno Asistencial:') }}
				{{ Form::select('search_entorno_asistencial', array('' => 'Seleccione') + $entornos_asistencial,$search_entorno_asistencial,array('class'=>'form-control')) }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_usuario','Usuario:') }}
				{{ Form::text('search_usuario',$search_usuario,array('class'=>'form-control','placeholder'=>'Nombre de Usuario')) }}
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
			<a class="btn btn-primary btn-block" href="{{URL::to('/reportes_investigacion/create_reporte')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Reporte de Investigación</th>
						<th class="text-nowrap text-center">Reporte de Evento Adverso</th>
						<th class="text-nowrap text-center">Entorno Asistencial</th>
						<th class="text-nowrap text-center">Usuario</th>
						<th class="text-nowrap text-center">Fecha Reporte</th>
					</tr>
					@foreach($reportes_data as $reporte_data)
					<tr class="@if($reporte_data->deleted_at) bg-danger @endif">						
						<td class="text-nowrap text-center">
							<a href="{{URL::to('/reportes_investigacion/view_reporte/')}}/{{$reporte_data->id}}">{{$reporte_data->codigo_abreviatura}}-{{$reporte_data->codigo_correlativo}}-{{$reporte_data->codigo_anho}}</a>
						</td>
						<td class="text-nowrap text-center">
							<a href="{{URL::to('/eventos_adversos/view_evento_adverso/')}}/{{$reporte_data->idevento}}" onmouseover="show_modal(event,{{$reporte_data->idevento}})" >{{ $reporte_data->evento_abreviatura}}-{{$reporte_data->evento_correlativo}}-{{$reporte_data->evento_anho}}</a>
						</td>
						<td class="text-nowrap text-center">
							@if($reporte_data->nombre_entorno_etapa == NULL)
								{{$reporte_data->nombre_entorno}}
							@else
								{{$reporte_data->nombre_entorno_etapa}}
							@endif
						</td>
						<td class="text-nowrap text-center" class="text-nowrap text-center">
							{{$reporte_data->nombre}} {{$reporte_data->apellido_pat}} {{$reporte_data->apellido_mat}}
						</td>
						<td class="text-nowrap text-center">
							{{$reporte_data->created_at}}
						</td>						
					</tr>
					@endforeach
				</table>
			</div>
		</div>
		<div class="col-md-4">
			{{ Form::label('toma_acciones','Toma de Acciones:') }}
			{{ Form::textarea('toma_acciones', null,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','id'=>'toma_acciones')) }}
		</div>
	</div>
	@if($search_codigo_reporte_investigacion || $search_codigo_reporte_evento || $search_entorno_asistencial || $search_usuario || $search_fecha_ini ||$search_fecha_fin)

		{{ $reportes_data->appends(array('search_codigo_reporte_investigacion' => $search_codigo_reporte_investigacion,'search_codigo_reporte_evento' => $search_codigo_reporte_evento, 'search_entorno_asistencial' => $search_entorno_asistencial,
			'search_usuario' => $search_usuario , 'search_fecha_ini' => $search_fecha_ini,  'search_fecha_fin' => $search_fecha_fin))->links() }}
	@else	
		{{ $reportes_data->links()}}
	@endif
	<div id="modals">
	</div>
	
@stop