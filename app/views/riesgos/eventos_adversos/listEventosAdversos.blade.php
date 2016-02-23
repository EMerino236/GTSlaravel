@extends('templates/eventosAdversosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Eventos Adversos</h3>
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

{{ Form::open(array('url'=>'/eventos_adversos/search_eventos_adversos','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="row">
			<div class="col-md-4 form-group">
				{{ Form::label('search_numero_reporte','Número de Registro del Evento Adverso') }}
				{{ Form::text('search_numero_reporte',$search_numero_reporte,array('class'=>'form-control','placeholder'=>'Ejemplo: EA-4568-16')) }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_tipo','Tipo de Evento') }}
				{{ Form::select('search_tipo', array('' => 'Seleccione')+$tipo_eventos, $search_tipo,['class' => 'form-control']) }}				
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_usuario','Usuario Reportante') }}				
				{{ Form::text('search_usuario',$search_usuario,array('class'=>'form-control','placeholder'=>'Usuario Reportante')) }}
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
			<a class="btn btn-primary btn-block" href="{{URL::to('/eventos_adversos/create_evento_adverso')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">N° de Reporte</th>
						<th class="text-nowrap text-center">Tipo de Evento Adverso</th>
						<th class="text-nowrap text-center">Usuario Reportante</th>
						<th class="text-nowrap text-center">Fecha de Reporte</th>
						<th class="text-nowrap text-center">Editar</th>
					</tr>
					@foreach($eventos_adversos_data as $evento_adverso)
					<tr class="@if($evento_adverso->deleted_at) bg-danger @endif">
						<td class="text-nowrap text-center">
							<a href="{{URL::to('/eventos_adversos/view_evento_adverso/')}}/{{$evento_adverso->id}}">
								{{$evento_adverso->codigo_abreviatura}}-{{$evento_adverso->codigo_correlativo}}-{{$evento_adverso->codigo_anho}}
							</a>
						</td>
						<td class="text-nowrap text-center">
								{{$evento_adverso->nombre_incidente}}
						</td>
						<td class="text-nowrap text-center">
								{{$evento_adverso->nombre_reportante}}
						</td>
						<td class="text-nowrap text-center">
								{{date('d-m-Y',strtotime($evento_adverso->fecha_reporte))}}
						</td>
						<td class="text-nowrap text-center">
							<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/eventos_adversos/edit_evento_adverso/')}}/{{$evento_adverso->id}}">
							<span class="glyphicon glyphicon-pencil"></span></a>
						</td>
					</tr>
					@endforeach
				</table>				
				@if($search_numero_reporte || $search_tipo || $search_usuario || $search_fecha_ini || $search_fecha_fin)

					{{ $eventos_adversos_data->appends(array('search_numero_reporte' => $search_numero_reporte,'search_tipo' => $search_tipo, 'search_usuario' => $search_usuario,
						'search_fecha_ini' => $search_fecha_ini , 'search_fecha_fin' => $search_fecha_fin))->links() }}
				@else	
					{{ $eventos_adversos_data->links()}}
				@endif
			</div>
		</div>
	</div>
	
	
@stop