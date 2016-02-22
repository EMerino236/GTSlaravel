@extends('templates/iperTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
        	@if($tipo == 1)
            	<h3 class="page-header">Lista de Identificación de Peligros Y Evaluación de Riesgos en TS
				</h3>
			@else
				<h3 class="page-header">Lista de Identificación de Peligros Y Evaluación de Riesgos en Salud Ocupacional
				</h3>
			@endif
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

{{ Form::open(array('url'=>'/ipers/search_ipers','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	{{Form::hidden('tipo',$tipo)}}
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="row">
			<div class="col-md-4 col-md-offset-2 form-group">
				{{ Form::label('search_codigo_reporte','Código de Reporte:') }}
				@if($tipo == 1)
					{{ Form::text('search_codigo_reporte',$search_codigo_reporte,array('class'=>'form-control','placeholder'=>'Ejemplo: IPER-TS-0001-16')) }}
				@else
					{{ Form::text('search_codigo_reporte',$search_codigo_reporte,array('class'=>'form-control','placeholder'=>'Ejemplo: IPER-SO-0001-16')) }}
				@endif
			</div>
			<div class="form-group col-md-4">
				{{ Form::label('search_anho','Año') }}
				<div id="search_datetimepicker1" class="form-group input-group date">
					{{ Form::text('search_anho',$search_anho,array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
	                    <span class="glyphicon glyphicon-calendar"></span>
	                </span>
				</div>
			</div>
		</div>
		<div class="row">	
			@if($tipo == 1)		
				<div class="col-md-4  col-md-offset-2 form-group">
					{{ Form::label('search_servicio','Servicio Clínico:') }}
					{{ Form::select('search_servicio', array('' => 'Seleccione') + $servicios,$search_servicio,array('class'=>'form-control')) }}
				</div>
			@else
				<div class="col-md-4  col-md-offset-2 form-group">
					{{ Form::label('search_entorno','Entorno Asistencial:') }}
					{{ Form::select('search_entorno', array('' => 'Seleccione') + $entornos,$search_entorno,array('class'=>'form-control')) }}
				</div>
			@endif
			<div class="col-md-4 form-group">
				{{ Form::label('search_usuario','Usuario:') }}				
				{{ Form::text('search_usuario',$search_usuario,array('class'=>'form-control','placeholder'=>'Usuario')) }}
			</div>
		</div>	
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-6">
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
			<a class="btn btn-primary btn-block" href="{{URL::to('/ipers/create_iper')}}/{{$tipo}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">N° de IPER</th>
						@if($tipo == 1)
							<th class="text-nowrap text-center">Servicio Clínico</th>
						@else
							<th class="text-nowrap text-center">Entorno Asistencial</th>
						@endif
						<th class="text-nowrap text-center">Usuario</th>
						<th class="text-nowrap text-center">Año</th>
						<th class="text-nowrap text-center">Editar</th>
					</tr>
					@foreach($ipers_data as $iper_data)
					<tr class="@if($iper_data->deleted_at) bg-danger @endif">
						<td class="text-nowrap text-center"  id="{{$iper_data->id}}">
							<a href="{{URL::to('/ipers/view_iper/')}}/{{$iper_data->idtipo_iper}}/{{$iper_data->id}}">{{$iper_data->codigo_abreviatura}}-{{$iper_data->codigo_tipo}}-{{$iper_data->codigo_correlativo}}-{{$iper_data->codigo_anho}}</a>
						</td>
						@if($tipo == 1)						
							<td class="text-nowrap text-center">
								{{$iper_data->nombre_servicio}}
							</td>
						@else
							<td class="text-nowrap text-center">
								{{$iper_data->nombre_entorno}}
							</td>
						@endif
						<td class="text-nowrap text-center">
							{{$iper_data->nombre}} {{$iper_data->apellido_pat}} {{$iper_data->apellido_mat}}
						</td>
						<td class="text-nowrap text-center">
							{{date('Y',strtotime($iper_data->fecha))}}
						</td>
						<td class="text-nowrap text-center">
							<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/ipers/edit_iper/')}}/{{$iper_data->idtipo_iper}}/{{$iper_data->id}}">
							<span class="glyphicon glyphicon-pencil"></span></a>
						</td>
					</tr>
					@endforeach
				</table>
				
			</div>
		</div>
	</div>
	<div id="modals">
	</div>
	
@stop