@extends('templates/otVerifMetrologicaTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programación de Verificación Metrológica</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
		<div class="container-fluid form-group row">
			<div class="col-md-4 col-md-offset-8">
				<a class="btn btn-primary btn-block" href="{{URL::to('/verif_metrologica/programacion')}}">
				<span class="glyphicon glyphicon-plus"></span> Agregar Verificación Metrológica</a>
			</div>
		</div>
    {{ Form::open(array('url'=>'/verif_metrologica/search_ot_verif_metrologica','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Búsqueda</h3>
				</div>
				<div class="panel-body">
					<div class="container-fluid form-group row">
						<div class="form-group col-md-4">
							{{ Form::label('search_ing','Ingeniero a cargo') }}
							{{ Form::text('search_ing',$search_ing,array('class'=>'form-control','placeholder'=>'Nombre o apellidos','id'=>'search_ing')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_cod_pat','Código patrimonial') }}
							{{ Form::text('search_cod_pat',$search_cod_pat,array('class'=>'form-control','id'=>'search_cod_pat')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_ubicacion','Ubicación') }}
							{{ Form::text('search_ubicacion',$search_ubicacion,array('class'=>'form-control','placeholder'=>'Ubicación física','id'=>'search_ubicacion')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_ot','Orden de Trabajo de Mantenimiento') }}
							{{ Form::text('search_ot',$search_ot,array('class'=>'form-control','placeholder'=>'Número de OT','id'=>'search_ot')) }}
						</div>					
						<div class="form-group col-md-4">
							{{ Form::label('search_equipo','Equipo relacionado') }}
							{{ Form::text('search_equipo',$search_equipo,array('class'=>'form-control','id'=>'search_equipo')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_proveedor','Proveedor') }}
							{{ Form::text('search_proveedor',$search_proveedor,array('class'=>'form-control','placeholder'=>'RUC, Razón social o Nombre de contacto','id'=>'search_proveedor')) }}
						</div>	
						<div class="form-group col-md-4">
							{{ Form::label('search_servicio','Servicio') }}
							{{ Form::text('search_servicio',$search_servicio,array('class'=>'form-control','placeholder'=>'Servicio','id'=>'search_servicio')) }}
						</div>						
						<div class="form-group col-md-4">
							{{ Form::label('search_ini','Fecha inicio') }}
							<div id="search_datetimepicker1" class="form-group input-group date">
								{{ Form::text('search_ini',$search_ini,array('class'=>'form-control','id'=>'search_fecha_inicio')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
							</div>
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_fin','Fecha fin') }}
							<div id="search_datetimepicker2" class="input-group date">
								{{ Form::text('search_fin',$search_fin,array('class'=>'form-control','id'=>'search_fecha_fin')) }}
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
	</div>
	{{ Form::close() }}	
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<table class="table">
				<tr class="info">
					<th>Fecha y hora</th>
					<th>Departamento</th>
					<th>Servicio</th>
					<th>Ingeniero</th>
					<th>Ubicación</th>
					<th>Orden Trabajo Mantenimiento</th>
					<th>Estado</th>
				</tr>
				@foreach($verif_metrologicas_data as $verif_metrologica_data)
				<tr>
					<td>
						{{date('d-m-Y H:i:s',strtotime($verif_metrologica_data->fecha_programacion))}}
					</td>
					<td>
						{{$verif_metrologica_data->nombre_area}}
					</td>
					<td>
						{{$verif_metrologica_data->nombre_servicio}}
					</td>
					<td>
						{{$verif_metrologica_data->apellido_pat}} {{$verif_metrologica_data->apellido_mat}}, {{$verif_metrologica_data->nombre_user}}
					</td>
					<td>
						{{$verif_metrologica_data->nombre_ubicacion}}
					</td>
					<td>
						<a href="{{URL::to('/verif_metro/create_ot/')}}/{{$verif_metrologica_data->idordenes_trabajo}}">{{$verif_metrologica_data->idordenes_trabajo}}</a>
					</td>
					<td>
						{{$verif_metrologica_data->nombre_estado}}
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
	@if($search_ing || $search_cod_pat || $search_ubicacion || $search_ot || $search_equipo || $search_proveedor || $search_proveedor || $search_ini || $search_fin)
		{{ $verif_metrologicas_data->appends(array('search_ing' => $search_ing,'search_cod_pat'=>$search_cod_pat,'search_ubicacion'=>$search_ubicacion,'search_ot'=>$search_ot,'search_equipo'=>$search_equipo,'search_proveedor'=>$search_proveedor,'search_servicio'=>$search_servicio,'search_ini'=>$search_ini,'search_fin'=>$search_fin))->links() }}
	@else
		{{ $verif_metrologicas_data->links() }}
	@endif
@stop