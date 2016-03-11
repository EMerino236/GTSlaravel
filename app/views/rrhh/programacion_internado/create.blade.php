@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Agregar Programacion de internado por servicio clinico</h3>
        </div>
    </div>

    @if ($errors->has())
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		@foreach($errors->all() as $error)
			<p><strong>{{ $error }}</strong></p>
		@endforeach	
	</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	
    <div class="row">
    	<div class="col-md-8">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos de la Programación</div>
			  	<div class="panel-body">	
					<div class="row">
						<div class="form-group col-md-6 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre') }}
							{{ Form::text('nombre', Input::old('nombre'), ['class'=>'form-control']) }}
						</div>

						<div class="form-group col-md-6 @if($errors->first('departamento')) has-error has-feedback @endif">
							{{ Form::label('departamento','Departamento') }}
							{{ Form::select('departamento', $departamentos, Input::old('departamento'), ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)']) }}
						</div>

						<div class="form-group col-md-6 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
							{{ Form::label('servicio_clinico','Servicio Clínico') }}
							{{ Form::select('servicio_clinico', $servicios, Input::old('servicio_clinico'), ['id'=>'servicio_clinico','class'=>'form-control']) }}
						</div>

						<div class="form-group col-md-6 @if($errors->first('responsable')) has-error has-feedback @endif">
							{{ Form::label('responsable','Responsable') }}
							{{ Form::select('responsable',$usuarios, Input::old('responsable'),['id'=>'responsable','class'=>'form-control'])}}
						</div>

						<div class="form-group col-md-6 @if($errors->first('numero_horas')) has-error has-feedback @endif">
							{{ Form::label('numero_horas','Numero de horas') }}
							{{ Form::text('numero_horas', Input::old('numero_horas'),['id'=>'numero_horas','class'=>'form-control'])}}
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
							{{ Form::label('fecha_ini','Fecha Inicio') }}
							<div id="datetimepicker1" class="form-group input-group date">
								{{ Form::text('fecha_ini',Input::old('fecha_ini'),array('class'=>'form-control', 'readonly'=>'')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
						</div>
						<div class="form-group col-md-6 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
							{{ Form::label('fecha_fin','Fecha Fin') }}
							<div id="datetimepicker2" class="form-group input-group date">
								{{ Form::text('fecha_fin',Input::old('fecha_fin'),array('class'=>'form-control', 'readonly'=>'')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
						</div>
					</div>

			        <div class="row">
						<div class="form-group col-md-4">
							{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar Programacion', array('class' => 'btn btn-primary btn-block','onClick'=>'agregaRowProgInter()')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::button('<span class="glyphicon glyphicon-refresh"></span> Limpiar', array('id'=>'btnLimpiar',  'class' => 'btn btn-default btn-block','onClick'=>'limpiarCriteriosAgregarProgramacionInternado()')) }}			
						</div>
					</div>	
			    </div>				    
			</div>
		</div>
		
		<div class="col-md-4">
			<h3 class="text-center">Programaciones del mes</h3>
			<!-- Responsive calendar - START -->
			<div class="responsive-calendar">
			  <div class="controls">			     
			      <a class="pull-left" data-go="prev"><div class="btn"><i class="glyphicon glyphicon-chevron-left"></i></div></a>
			      <h4><span data-head-year></span> <span data-head-month></span></h4>
			      <a class="pull-right" data-go="next"><div class="btn"><i class="glyphicon glyphicon-chevron-right"></i></div></a>
			  </div><hr/>
			  <div class="day-headers">
			    <div class="day header">Lun</div>
			    <div class="day header">Mar</div>
			    <div class="day header">Mie</div>
			    <div class="day header">Jue</div>
			    <div class="day header">Vie</div>
			    <div class="day header">Sab</div>
			    <div class="day header">Dom</div>
			  </div>
			  <div class="days" data-group="days">
			    <!-- the place where days will be generated -->
			  </div>
			</div>
			<!-- Responsive calendar - END -->
		</div>
	</div>

	<div class="form-group row">
		<div class="table-responsive">
			<div class="col-md-12">
				<table class="table" id="table_programacion">
					<tr class="info">
						<th class="text-center">Nombre</th>
						<th class="text-center">Departamento</th>
						<th class="text-center">Servicio Clinico</th>
						<th class="text-center">Responsable</th>
						<th class="text-center">Numero de horas</th>
						<th class="text-center">Fecha Inicio</th>
						<th class="text-center">Fecha Fin</th>
						<th class="text-center"></th>
					</tr>
					<tbody class="pr_table"></tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-2 col-md-offset-8">
			{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit_create_ots', 'class' => 'btn btn-primary btn-block')) }}
		</div>
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::to('/inspec_equipos/list_inspec_equipos')}}">Cancelar</a>				
		</div>
	</div>	

@stop