@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Adjudicaciones y Contratos Firmados</h3>            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/adjudicacion_expediente/search_adjudicacion_expediente','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_codigo_compra','Código de compra:') }}
						{{ Form::text('search_codigo_compra',$search_codigo_compra,array('class'=>'form-control','placeholder'=>'Código de compra')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_usuario','Usuario:') }}
						{{ Form::text('search_usuario',$search_usuario,array('class'=>'form-control','placeholder'=>'Usuario')) }}
					</div>	
					<div class="form-group col-md-4">
						{{ Form::label('search_servicio','Servicio:')}}
						{{ Form::select('search_servicio',array('' => 'Seleccione')+$servicios, $search_servicio,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_area','Departamento:')}}
						{{ Form::select('search_area',array('' => 'Seleccione')+$areas, $search_area,array('class'=>'form-control')) }}
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
						<div class="btn btn-default btn-block" id="btnLlimpiar_criterios_list_adjudicacion_expediente"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
					</div>
				</div>
				</div>
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>
	<table class="table">
		<tr class="info">
			<th>Código de Compra</th>
			<th>Código de Archivamiento</th>
			<th>Nombre de Equipo</th>
			<th>Fecha</th>
			<th>Usuario</th>
			<th>Servicio Clínico</th>
			<th>Departamento</th>
			<th>Adjudicación</th>
		</tr>
		@foreach($expedientes_tecnico_data as $expediente_tecnico_data)
		<tr class="@if($expediente_tecnico_data->deleted_at) bg-danger @endif">
			<td>
				@if($user->id == $expediente_tecnico_data->idresponsable || $user->id == $expediente_tecnico_data->idpresidente)
					<a href="{{URL::to('/expediente_tecnico/edit_expediente_tecnico/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}">{{$expediente_tecnico_data->codigo_compra}}</a>
				@else
					<a href="{{URL::to('/expediente_tecnico/view_expediente_tecnico/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}">{{$expediente_tecnico_data->codigo_compra}}</a>
				@endif
			</td>
			<td>
				{{$expediente_tecnico_data->codigo_archivamiento}}
			</td>
			<td>
				@if($expediente_tecnico_data->nombre_equipo == 0)
					{{$expediente_tecnico_data->otros_equipos}}
				@else
					{{$expediente_tecnico_data->nombre_equipo}}
				@endif
			</td>
			<td>
				{{date('d-m-Y H:i',strtotime($expediente_tecnico_data->created_at))}}
			</td>
			<td>
				{{$expediente_tecnico_data->apellido_pat}} {{$expediente_tecnico_data->apellido_mat}} {{$expediente_tecnico_data->nombre}}
			</td>
			<td>
				{{$expediente_tecnico_data->nombre_servicio}}
			</td>
			<td>
				{{$expediente_tecnico_data->nombre_area}}
			</td>
			<td class="text-nowrap text-center">
				@if(!($user->id == $expediente_tecnico_data->idresponsable || $user->idrol == 2 || 
					$user->id == $expediente_tecnico_data->idpresidente))
					<a disabled class="btn btn-warning btn-block btn-sm" href="{{URL::to('/adjudicacion_expediente/edit_adjudicacion_expediente/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}">
				@else
					<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/adjudicacion_expediente/edit_adjudicacion_expediente/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}">
				@endif
				<span class="glyphicon glyphicon-pencil"></span></a>
			</td>	
		</tr>
		@endforeach
	</table>
	<div class="row">
		@if($search_codigo_compra || $search_usuario || $search_fecha_ini || $search_fecha_fin)
			{{ $expedientes_tecnico_data->appends(array('search_codigo_compra'=>$search_codigo_compra,'search_usuario'=>$search_usuario,'search_fecha_ini'=>$search_fecha_ini,'search_fecha_fin'=>$search_fecha_fin))->links() }}
		@else
			{{ $expedientes_tecnico_data->links() }}
		@endif
	</div>
@stop