@extends('templates/sotTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Historial de Solicitudes de Ordenes de Trabajo</h3>
            <div class="container-fluid form-group row">
				<div class="col-md-4 col-md-offset-8">
            		<a class="btn btn-primary btn-block" href="{{URL::to('/sot/create_sot')}}">
					<span class="glyphicon glyphicon-plus"></span> Generar Solicitud</a>
				</div>
			</div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/sot/search_sot','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-6">
						{{ Form::label('search','Número de ficha/Usuario solicitante') }}
						{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'')) }}
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('search_estado','Estado') }}
						{{ Form::select('search_estado',array("0"=>"Seleccione")+$estados,$search_estado,['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						{{ Form::label('search_ini','Fecha inicio') }}
						<div id="datetimepicker1" class="form-group input-group date">
							{{ Form::text('search_ini',$search_ini,array('class'=>'form-control')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('search_fin','Fecha de fin') }}
						<div id="datetimepicker2" class="form-group input-group date">
							{{ Form::text('search_fin',$search_fin,array('class'=>'form-control')) }}
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
	{{ Form::close() }}</br>

	<table class="table">
		<tr class="info">
			<th>Número de SOT</th>
			<th>Fecha de solicitud</th>
			<th>Usuario solicitante</th>
			<th>Estado</th>
		</tr>
		@foreach($sots_data as $sot_data)
		<tr>
			<td>
				<a href="{{URL::to('/sot/edit_sot/')}}/{{$sot_data->idsolicitud_orden_trabajo}}">{{$sot_data->sot_tipo_abreviatura}}{{$sot_data->sot_correlativo}}{{$sot_data->sot_activo_abreviatura}}</a>
			</td>
			<td>
				{{date('d-m-Y',strtotime($sot_data->fecha_solicitud))}}
			</td>
			<td>
				{{$sot_data->apellido_pat}} {{$sot_data->apellido_mat}}, {{$sot_data->nombre}}
			</td>
			<td>
				{{$sot_data->nombre_estado}}
			</td>
		</tr>
		@endforeach
	</table>
	@if($search || $search_estado || $search_ini || $search_fin)
		{{ $sots_data->appends(array('search' => $search,'search_estado'=>$search_estado,'search_ini'=>$search_ini,'search_fin'=>$search_fin))->links() }}
	@else
		{{ $sots_data->links() }}
	@endif
@stop