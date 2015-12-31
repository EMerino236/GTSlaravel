@extends('templates/reporteIncumplimientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reportes de Incumplimiento</h3>
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
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

    {{ Form::open(array('url'=>'/reportes_incumplimiento/search_reporte','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>	
	  	<div class="panel-body">
	  		<div class="col-md-6">			
				<div class="row">
					<div class="form-group col-md-8">
						{{ Form::label('fecha_desde','Fecha Desde:')}}
						<div id="search_datetimepicker1" class="input-group date">					
							{{ Form::text('fecha_desde',$fecha_desde,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
			            </div>
		        	</div>
		        </div>
		        <div class="row">
		        	<div class="form-group col-md-8">
						{{ Form::label('fecha_hasta','Fecha Hasta:')}}
						<div id="search_datetimepicker2" class="input-group date">					
							{{ Form::text('fecha_hasta',$fecha_hasta,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-8 form-group">
						{{ Form::label('search_tipo_reporte','Tipo Reporte:')}}
						{{ Form::select('search_tipo_reporte',['0'=>'Seleccione', '1'=>'Por Servicio','2'=>'Por Equipo'], $search_tipo_reporte,array('class'=>'form-control','id'=>'search_tipo_reporte')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						{{ Form::label('search_proveedor','Proveedor:')}}
						{{ Form::select('search_proveedor',array('0' => 'Seleccione')+$proveedor, $search_proveedor,array('class'=>'form-control','id'=>'search_proveedor')) }}
					</div>				
				</div>
			</div>
			<div class="col-md-6 col-md-offset-6">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
					</div>
					<div class="form-group col-md-4">
						<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
					</div>
				</div>
			</div>	
		</div>
	</div>						
	{{ Form::close() }}
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/reportes_incumplimiento/create_reporte')}}">
			<span class="glyphicon glyphicon-plus"></span> Nuevo Reporte</a>
		</div>
	</div>
 	<div class="row">
 		<div class="table-responsive">
			<table class="table">
				<tr class="info">
					<th class="text-nowrap text-center">N°</th>
					<th class="text-nowrap text-center">Código de Reporte</th>
					<th class="text-nowrap text-center">Fecha de Registro</th>
					<th class="text-nowrap text-center">Servicio</th>
					<th class="text-nowrap text-center">Proveedor</th>
					<th class="text-nowrap text-center">Editar</th>
				</tr>
				@foreach($reportes_data as $index => $reporte_data)
					<tr>
						<td class="text-nowrap text-center">{{$index+1}}</td>
						<td class="text-nowrap text-center">
							<a  href="{{URL::to('/reportes_incumplimiento/view_reporte/')}}/{{$reporte_data->idreporte_incumplimiento}}">{{$reporte_data->numero_reporte_abreviatura}}{{$reporte_data->numero_reporte_correlativo}}-{{$reporte_data->numero_reporte_anho}}</a>
						</td>					
						<td class="text-nowrap text-center">{{date('d-m-Y',strtotime($reporte_data->fecha))}}</td>
						<td class="text-nowrap text-center">{{$reporte_data->nomb_servicio}}</td>
						<td class="text-nowrap text-center">{{$reporte_data->nomb_proveedor}}</td>
						<td class="text-nowrap text-center">
							<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/reportes_incumplimiento/edit_reporte/')}}/{{$reporte_data->idreporte_incumplimiento}}">
							<span class="glyphicon glyphicon-pencil"></span> Editar</a>
						</td>
					</tr>
				@endforeach				
			</table>
		</div>
	</div>
	@if($fecha_desde || $fecha_hasta || $search_tipo_reporte || $search_proveedor)
		{{ $reportes_data->appends(array('fecha_desde' => $fecha_desde,'fecha_hasta' => $fecha_hasta, 'search_tipo_reporte' => $search_tipo_reporte,
			'search_proveedor' => $search_proveedor))->links() }}
	@else	
		{{ $reportes_data->links()}}
	@endif	
@stop