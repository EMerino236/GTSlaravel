@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programación de mantenimiento correctivo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/mant_correctivo/search_ot_mant_correctivo','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_ing','Ingeniero a cargo') }}
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
			<th>Servicio</th>
			<th>Ingeniero</th>
			<th>Ubicación</th>
			<th>OT</th>
			<th>SOT</th>
			<th>Estado</th>
		</tr>
		@foreach($mant_correctivos_data as $mant_correctivo_data)
		<tr>
			<td>
				{{date('d-m-Y H:i:s',strtotime($mant_correctivo_data->fecha_programacion))}}
			</td>
			<td>
				{{$mant_correctivo_data->nombre_area}}
			</td>
			<td>
				{{$mant_correctivo_data->nombre_servicio}}
			</td>
			<td>
				{{$mant_correctivo_data->apellido_pat}} {{$mant_correctivo_data->apellido_mat}}, {{$mant_correctivo_data->nombre_user}}
			</td>
			<td>
				{{$mant_correctivo_data->nombre_ubicacion}}
			</td>
			<td>
				<a href="{{URL::to('/mant_correctivo/create_ot/')}}/{{$mant_correctivo_data->idordenes_trabajo}}">{{$mant_correctivo_data->idordenes_trabajo}}</a>
			</td>
			<td>
				{{$mant_correctivo_data->idsolicitud_orden_trabajo}}
			</td>
			<td>
				{{$mant_correctivo_data->nombre_estado}}
			</td>
		</tr>
		@endforeach
	</table>
	@if($search_ing || $search_cod_pat || $search_ubicacion || $search_ot || $search_equipo || $search_proveedor || $search_ini || $search_fin)
		{{ $mant_correctivos_data->appends(array('search_ing' => $search_ing,'search_cod_pat'=>$search_cod_pat,'search_cod_pat'=>$search_ubicacion,'search_cod_pat'=>$search_ot,'search_cod_pat'=>$search_equipo,'search_cod_pat'=>$search_proveedor,'search_ini'=>$search_ini,'search_fin'=>$search_fin))->links() }}
	@else
		{{ $mant_correctivos_data->links() }}
	@endif
@stop