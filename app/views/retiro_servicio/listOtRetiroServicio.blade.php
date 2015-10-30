@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programación de OT de retiro de servicio</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/retiro_servicio/search_ot_retiro_servicio','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_ing','Ingeniero para retiro') }}
							{{ Form::text('search_ing',$search_ing,array('class'=>'form-control','placeholder'=>'Nombre o apellidos')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_cod_pat','Código patrimonial') }}
							{{ Form::text('search_cod_pat',$search_cod_pat,array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_ubicacion','Ubicación') }}
							{{ Form::text('search_ubicacion',$search_ubicacion,array('class'=>'form-control','placeholder'=>'Ubicación física')) }}
						</div>
					</div>
					<div class="row">
						{{ Form::label('search_ini','Fecha inicio') }}
						<div id="datetimepicker1" class="form-group input-group date col-xs-8">
							{{ Form::text('search_ini',$search_ini,array('class'=>'form-control')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_ot','OT') }}
							{{ Form::text('search_ot',$search_ot,array('class'=>'form-control','placeholder'=>'Número de OT')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_equipo','Equipo relacionado') }}
							{{ Form::text('search_equipo',$search_equipo,array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_proveedor','Proveedor') }}
							{{ Form::text('search_proveedor',$search_proveedor,array('class'=>'form-control','placeholder'=>'RUC, Razón social o Nombre de contacto')) }}
						</div>
					</div>
					<div class="row">
						{{ Form::label('search_fin','Fecha de fin') }}
						<div id="datetimepicker2" class="form-group input-group date col-xs-8">
							{{ Form::text('search_fin',$search_fin,array('class'=>'form-control')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="row">
						<div class="form-group col-xs-8">
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
			<th>Fecha y hora</th>
			<th>Departamento</th>
			<th>Servicio Clínico</th>
			<th>Ingeniero</th>
			<th>Ubicación</th>
			<th>Estado</th>
			<th>No. de reporte de retiro de servicio</th>
			<th>OT</th>
		</tr>
		@foreach($retiro_servicios_data as $retiro_servicio_data)
		<tr>
			<td>
				{{date('d-m-Y H:i:s',strtotime($retiro_servicio_data->fecha_programacion))}}
			</td>
			<td>
				{{$retiro_servicio_data->nombre_area}}
			</td>
			<td>
				{{$retiro_servicio_data->nombre_servicio}}
			</td>
			<td>
				{{$retiro_servicio_data->apellido_pat}} {{$retiro_servicio_data->apellido_mat}}, {{$retiro_servicio_data->nombre_user}}
			</td>
			<td>
				{{$retiro_servicio_data->nombre_ubicacion}}
			</td>
			<td>
				
			</td>
			<td>
				<a href="{{URL::to('/mant_correctivo/create_ot/')}}/{{$retiro_servicio_data->idordenes_trabajo}}">{{$retiro_servicio_data->idordenes_trabajo}}</a>
			</td>
			<td>
				{{$retiro_servicio_data->nombre_estado}}
			</td>
		</tr>
		@endforeach
	</table>
	@if($search_ing || $search_cod_pat || $search_ubicacion || $search_ot || $search_equipo || $search_proveedor || $search_ini || $search_fin)
		{{ $retiro_servicios_data->appends(array('search_ing' => $search_ing,'search_cod_pat'=>$search_cod_pat,'search_cod_pat'=>$search_ubicacion,'search_cod_pat'=>$search_ot,'search_cod_pat'=>$search_equipo,'search_cod_pat'=>$search_proveedor,'search_ini'=>$search_ini,'search_fin'=>$search_fin))->links() }}
	@else
		{{ $retiro_servicios_data->links() }}
	@endif
@stop