@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programación Anual de Compras</h3>            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/programacion_compra/search_programacion_compra','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
				<div class="row">	
					<div class="form-group col-md-4">
						{{ Form::label('search_fecha','Año') }}
						<div id="datetimepicker_search_anho" class="form-group input-group date">
							{{ Form::text('search_fecha',$search_fecha,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<div class="btn btn-default btn-block" id="btnLlimpiar_criterios_list_reporte_cn"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}</br>
	<div class="container-fluid form-group row">
		<div class="col-md-3 col-md-offset-9">
			<a class="btn btn-primary btn-block" href="{{URL::to('/programacion_compra/create_programacion_compra')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar Programación</a>
		</div>
	</div>
	@if($search_fecha>0)
		<h1 style="font-weight:bold">Año: {{$search_fecha}}</h1>
	@else
		<h1 style="font-weight:bold">Año: {{$anho_actual}}</h1>
	@endif
	<!--
	<table class="table">
		<tr>	
			<th bgcolor='red'></th>
			<th>Atrasado</th>
			<th bgcolor='yellow'></th>
			<th>Programado para el mes actual</th>					
			<th bgcolor='lightGreen'></th>
			<th>Programado para el trimestre actual</th>
			<th bgcolor='whitesmoke'></th>
			<th>Programado para el resto del año</th>	
		</tr>
	</table>
-->
	<div class="col-md-5">
		<strong>Leyenda</strong>
		<table class="table" border="1">
			<tr class="info">
				<th width="5">Color</th>
				<th width="50">Descripción</th>
			</tr>
			<tr>	
				<td bgcolor='red'></td>
				<td>Atrasado</td>	
			</tr>
			<tr>	
				<td bgcolor='yellow'></td>
				<td>Programado para el mes actual</td>	
			</tr>
			<tr>				
				<td bgcolor='lightGreen'></td>
				<td>Programado para el trimestre actual</td>
			</tr>
			<tr>	
				<td bgcolor='whitesmoke'></td>
				<td>Programado para el resto del año</td>	
			</tr>
		</table>
	</div>

	<table class="table">
		<tr class="info">	
			<th>Código de Compra</th>
			<th>Elemento de compra</th>
			<th>Usuario Solicitante</th>
			<th>Departamento</th>
			<th>Servicio</th>
			<th>Responsable</th>
			<th>Fecha Inicio Evaluación</th>
			<th>Fecha Aproximada Adquisición</th>
			<th>Fecha Programacion de compra</th>
		</tr>
		@foreach($programacion_compras_data as $programacion_compra_data)
		<tr class="@if($programacion_compra_data->deleted_at) bg-danger @endif">
			@if((date('Y',strtotime($programacion_compra_data->fecha_aproximada_adquisicion))*10000+
				date('m',strtotime($programacion_compra_data->fecha_aproximada_adquisicion))*100+
				date('d',strtotime($programacion_compra_data->fecha_aproximada_adquisicion))) < 
				($anho_actual*10000+$mes_actual*100+$dia_actual))
				<td bgcolor="red">
					@if($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
						<a href="{{URL::to('/programacion_compra/edit_programacion_compra/')}}/{{$programacion_compra_data->idprogramacion_compra}}">{{$programacion_compra_data->codigo_compra}}</a>
					@endif
					@if($user->idrol == 7 || $user->idrol == 8 || $user->idrol == 9 || $user->idrol == 10 || $user->idrol == 11 || $user->idrol == 12)
						<a href="{{URL::to('/programacion_compra/view_programacion_compra/')}}/{{$programacion_compra_data->idprogramacion_compra}}">{{$programacion_compra_data->codigo_compra}}</a>
					@endif
				</td>
			@elseif((date('Y',strtotime($programacion_compra_data->fecha_aproximada_adquisicion))*10000+
				date('m',strtotime($programacion_compra_data->fecha_aproximada_adquisicion))*100) ==
				($anho_actual*10000+$mes_actual*100))
				<td bgcolor="yellow">
					@if($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
						<a href="{{URL::to('/programacion_compra/edit_programacion_compra/')}}/{{$programacion_compra_data->idprogramacion_compra}}">{{$programacion_compra_data->codigo_compra}}</a>
					@endif
					@if($user->idrol == 7 || $user->idrol == 8 || $user->idrol == 9 || $user->idrol == 10 || $user->idrol == 11 || $user->idrol == 12)
						<a href="{{URL::to('/programacion_compra/view_programacion_compra/')}}/{{$programacion_compra_data->idprogramacion_compra}}">{{$programacion_compra_data->codigo_compra}}</a>
					@endif
				</td>
			@elseif((date('Y',strtotime($programacion_compra_data->fecha_aproximada_adquisicion))*10000+
				date('m',strtotime($programacion_compra_data->fecha_aproximada_adquisicion))*100) <=
				($anho_actual*10000+$trimestre*3*100))
				<td bgcolor="green">
					@if($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
						<a href="{{URL::to('/programacion_compra/edit_programacion_compra/')}}/{{$programacion_compra_data->idprogramacion_compra}}">{{$programacion_compra_data->codigo_compra}}</a>
					@endif
					@if($user->idrol == 7 || $user->idrol == 8 || $user->idrol == 9 || $user->idrol == 10 || $user->idrol == 11 || $user->idrol == 12)
						<a href="{{URL::to('/programacion_compra/view_programacion_compra/')}}/{{$programacion_compra_data->idprogramacion_compra}}">{{$programacion_compra_data->codigo_compra}}</a>
					@endif
				</td>
			@else
				<td bgcolor="whitesmoke">
					@if($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
						<a href="{{URL::to('/programacion_compra/edit_programacion_compra/')}}/{{$programacion_compra_data->idprogramacion_compra}}">{{$programacion_compra_data->codigo_compra}}</a>
					@endif
					@if($user->idrol == 7 || $user->idrol == 8 || $user->idrol == 9 || $user->idrol == 10 || $user->idrol == 11 || $user->idrol == 12)
						<a href="{{URL::to('/programacion_compra/view_programacion_compra/')}}/{{$programacion_compra_data->idprogramacion_compra}}">{{$programacion_compra_data->codigo_compra}}</a>
					@endif
				</td>
			@endif
			<td>
				{{$programacion_compra_data->tipo_compra}}
			</td>
			<td>
				{{$programacion_compra_data->apellido_pat_usuario}} {{$programacion_compra_data->apellido_mat_usuario}} {{$programacion_compra_data->nombre_usuario}}
			</td>
			<td>
				{{$programacion_compra_data->nombre_area}}
			</td>
			<td>
				{{$programacion_compra_data->nombre_servicio}}
			</td>	
			<td>
				{{$programacion_compra_data->apellido_pat_responsable}} {{$programacion_compra_data->apellido_mat_responsable}} {{$programacion_compra_data->nombre_responsable}}
			</td>
			<td>
				{{date('d-m-Y',strtotime($programacion_compra_data->fecha_inicio_evaluacion))}}
			</td>	
			<td>
				{{date('d-m-Y',strtotime($programacion_compra_data->fecha_aproximada_adquisicion))}}
			</td>		
			<td>
				{{date('d-m-Y',strtotime($programacion_compra_data->created_at))}}
			</td>
		</tr>
		@endforeach
	</table>
@stop