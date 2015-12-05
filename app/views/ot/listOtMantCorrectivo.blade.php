@extends('templates/otMantenimientoCorrectivoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Mantenimiento Correctivo</h3>
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
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_ing','Ingeniero a cargo') }}
						{{ Form::text('search_ing',$search_ing,array('class'=>'form-control','placeholder'=>'Nombre o apellidos')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_cod_pat','Código patrimonial') }}
						{{ Form::text('search_cod_pat',$search_cod_pat,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_ubicacion','Ubicación') }}
						{{ Form::text('search_ubicacion',$search_ubicacion,array('class'=>'form-control','placeholder'=>'Ubicación física')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_ot','OT') }}
						{{ Form::text('search_ot',$search_ot,array('class'=>'form-control','placeholder'=>'Número de OT')) }}
					</div>
					<div class="form-group col-md-4">
					{{ Form::label('search_ini','Fecha inicio') }}
						<div class="form-group input-group date datetimepicker">
							{{ Form::text('search_ini',$search_ini,array('class'=>'form-control')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_fin','Fecha de fin') }}
						<div class="form-group input-group date datetimepicker">
							{{ Form::text('search_fin',$search_fin,array('class'=>'form-control')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_equipo','Equipo relacionado') }}
						{{ Form::text('search_equipo',$search_equipo,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_proveedor','Proveedor') }}
						{{ Form::text('search_proveedor',$search_proveedor,array('class'=>'form-control','placeholder'=>'RUC, Razón social o Nombre de contacto')) }}
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
			<th>OT</th>
			<th>SOT</th>
			<th>Fecha y hora</th>
			<th>Departamento</th>
			<th>Servicio</th>
			<th>Ingeniero</th>
			<th>Ubicación</th>
			<th>Estado</th>
		</tr>
		@foreach($mant_correctivos_data as $mant_correctivo_data)
		<tr>
			<td>
				<a href="{{URL::to('/mant_correctivo/create_ot/')}}/{{$mant_correctivo_data->idot_correctivo}}">{{$mant_correctivo_data->ot_tipo_abreviatura}}{{$mant_correctivo_data->ot_correlativo}}{{$mant_correctivo_data->ot_activo_abreviatura}}</a>
			</td>
			<td>
				{{$mant_correctivo_data->sot_tipo_abreviatura}}{{$mant_correctivo_data->sot_correlativo}}{{$mant_correctivo_data->sot_activo_abreviatura}}
			</td>
			<td>
				{{date('d-m-Y H:i',strtotime($mant_correctivo_data->fecha_programacion))}}
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
				{{$mant_correctivo_data->nombre_estado}}
			</td>
		</tr>
		@endforeach
	</table>
	<div class="row">
		<div class="form-group col-md-12">
		@if($search_ing || $search_cod_pat || $search_ubicacion || $search_ot || $search_equipo || $search_proveedor || $search_ini || $search_fin)
			{{ $mant_correctivos_data->appends(array('search_ing' => $search_ing,'search_cod_pat'=>$search_cod_pat,'search_ubicacion'=>$search_ubicacion,'search_ot'=>$search_ot,'search_equipo'=>$search_equipo,'search_proveedor'=>$search_proveedor,'search_ini'=>$search_ini,'search_fin'=>$search_fin))->links() }}
		@else
			{{ $mant_correctivos_data->links() }}
		@endif
		</div>
	</div>
@stop