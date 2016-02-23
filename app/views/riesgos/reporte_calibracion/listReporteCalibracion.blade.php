@extends('templates/reporteCalibracionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Reportes de Calibración</h3>
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

{{ Form::open(array('url'=>'/reportes_calibracion/search_reporte','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="row">
			<div class="col-md-4 form-group">
				{{ Form::label('search_codigo_reporte','Código de Reporte:') }}
				{{ Form::text('search_codigo_reporte',$search_codigo_reporte,array('class'=>'form-control','placeholder'=>'Ejemplo: RC-2653-16')) }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_codigo_patrimonial','Código Patrimonial:') }}
				{{ Form::text('search_codigo_patrimonial',$search_codigo_patrimonial,array('class'=>'form-control','placeholder'=>'Código Patrimonial'))  }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_nombre_equipo','Nombre del Equipo:') }}				
				{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Nombre del Equipo')) }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_servicio','Servicio Clínico:') }}
				{{ Form::select('search_servicio', array('' => 'Seleccione') + $servicios,$search_servicio,array('class'=>'form-control')) }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_area','Departamento:') }}				
				{{ Form::select('search_area', array('' => 'Seleccione') + $areas,$search_area,['class' => 'form-control']) }}				
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_grupo','Grupo:') }}				
				{{ Form::select('search_grupo', array('' => 'Seleccione') + $grupos,$search_grupo,['class' => 'form-control']) }}				
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
			<a class="btn btn-primary btn-block" href="{{URL::to('/reportes_calibracion/create_reporte')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Reporte de Calibración</th>
						<th class="text-nowrap text-center">Grupo</th>
						<th class="text-nowrap text-center">Servicio Clínico</th>
						<th class="text-nowrap text-center">Nombre de Equipo</th>
						<th class="text-nowrap text-center">Marca</th>
						<th class="text-nowrap text-center">Modelo</th>
						<th class="text-nowrap text-center">Código Patrimonial</th>
						<th class="text-nowrap text-center">Proveedor de Calibracion</th>
					</tr>
					@foreach($reportes_data as $reporte_data)
					<tr class="@if($reporte_data->deleted_at) bg-danger @endif">
						<td class="text-nowrap text-center"  id="{{$reporte_data->id}}">
							<a href="" onclick="show_modal_documentos(event,this)">{{$reporte_data->codigo_abreviatura}}-{{$reporte_data->codigo_correlativo}}-{{$reporte_data->codigo_anho}}</a>
						</td>						
						<td class="text-nowrap text-center">
							{{$reporte_data->nombre_grupo}}
						</td>
						<td class="text-nowrap text-center">
							{{$reporte_data->nombre_servicio}}
						</td>
						<td class="text-nowrap text-center">
							{{$reporte_data->nombre_familia}}
						</td>
						<td class="text-nowrap text-center">
							{{$reporte_data->nombre_marca}}
						</td>
						<td class="text-nowrap text-center">
							{{$reporte_data->nombre_modelo}}
						</td>
						<td class="text-nowrap text-center">
							{{$reporte_data->codigo_patrimonial}}
						</td>
						<td class="text-nowrap text-center">
							{{$reporte_data->nombre_proveedor}}
						</td>
					</tr>
					@endforeach
				</table>
				@if($search_codigo_reporte || $search_codigo_patrimonial || $search_nombre_equipo || $search_servicio || $search_area ||$search_grupo)

					{{ $reportes_data->appends(array('search_codigo_reporte' => $search_codigo_reporte,'search_codigo_patrimonial' => $search_codigo_patrimonial, 'search_nombre_equipo' => $search_nombre_equipo,
						'search_servicio' => $search_servicio , 'search_area' => $search_area,  'search_grupo' => $search_grupo))->links() }}
				@else	
					{{ $reportes_data->links()}}
				@endif
			</div>
		</div>
	</div>
	<div id="modals">
	</div>
	
@stop