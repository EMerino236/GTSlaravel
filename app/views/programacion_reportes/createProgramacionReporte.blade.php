@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programación de Elaboración de Reportes</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idtipo_reporte_cn') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_reporte_etes') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_reporte_paac') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_cn') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_etes') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_paac') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_cn') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_etes') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_paac') }}</strong></p>
			<p><strong>{{ $errors->first('idarea_cn') }}</strong></p>
			<p><strong>{{ $errors->first('idarea_etes') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'programacion_reportes/submit_create_programacion_reporte_cn', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Reporte de Necesidad</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_reporte_cn')) has-error has-feedback @endif">
						{{ Form::label('idtipo_reporte_cn','Tipo de Reporte') }}<span style='color:red'>*</span>
						{{ Form::select('idtipo_reporte_cn',array(''=>'Seleccione') + $tipo_reporte_cn,Input::old('idtipo_reporte_cn'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idservicio_cn')) has-error has-feedback @endif">
						{{ Form::label('idservicio_cn','Servicio') }}
						{{ Form::select('idservicio_cn',array(''=>'Seleccione') + $servicios,Input::old('idservicio_cn'),['class' => 'form-control']) }}
					</div><div class="form-group col-md-4 @if($errors->first('idarea_select_cn')) has-error has-feedback @endif">
						{{ Form::label('idarea_select_cn','Departamento') }}<span style='color:red'>*</span>
						{{ Form::select('idarea_select_cn',array(''=>'Seleccione') + $areas,Input::old('idarea_select_cn'),['class' => 'form-control']) }}
						{{ Form::hidden('idarea_cn')}}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-8 @if($errors->first('nombre_cn')) has-error has-feedback @endif">
						{{ Form::label('nombre_cn','Nombre de Reporte') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_cn',Input::old('nombre_cn'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('fecha_cn','Fecha de Presentación') }}<span style='color:red'>*</span>
						<div id="datetimepicker_cn" class="form-group input-group date @if($errors->first('fecha_cn')) has-error has-feedback @endif">
							{{ Form::text('fecha_cn',Input::old('fecha_cn'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-2 col-md-offset-10">
						{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}

	{{ Form::open(array('url'=>'programacion_reportes/submit_create_programacion_reporte_etes', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Reporte ETES</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_reporte_etes')) has-error has-feedback @endif">
						{{ Form::label('idtipo_reporte_etes','Tipo de Reporte') }}<span style='color:red'>*</span>
						{{ Form::select('idtipo_reporte_etes',array(''=>'Seleccione') + $tipo_reporte_etes,Input::old('idtipo_reporte_etes'),['class' => 'form-control']) }}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-8 @if($errors->first('nombre_etes')) has-error has-feedback @endif">
						{{ Form::label('nombre_etes','Nombre de Reporte') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_etes',Input::old('nombre_etes'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('fecha_etes','Fecha de Presentación') }}<span style='color:red'>*</span>
						<div id="datetimepicker_etes" class="form-group input-group date @if($errors->first('fecha_etes')) has-error has-feedback @endif">
							{{ Form::text('fecha_etes',Input::old('fecha_etes'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-2 col-md-offset-10">
						{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}

	{{ Form::open(array('url'=>'programacion_reportes/submit_create_programacion_reporte_paac', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Reporte de Evaluación de Instalación o Implantación</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_reporte_paac')) has-error has-feedback @endif">
						{{ Form::label('idtipo_reporte_paac','Tipo de Reporte') }}<span style='color:red'>*</span>
						{{ Form::select('idtipo_reporte_paac',array(''=>'Seleccione') + $tipo_reporte_paac,Input::old('idtipo_reporte_paac'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idservicio_paac')) has-error has-feedback @endif">
						{{ Form::label('idservicio_paac','Servicio') }}
						{{ Form::select('idservicio_paac',array(''=>'Seleccione') + $servicios,Input::old('idservicio_paac'),['class' => 'form-control']) }}
					</div><div class="form-group col-md-4 @if($errors->first('idarea_select_paac')) has-error has-feedback @endif">
						{{ Form::label('idarea_select_paac','Departamento') }}<span style='color:red'>*</span>
						{{ Form::select('idarea_select_paac',array(''=>'Seleccione') + $areas,Input::old('idarea_select_paac'),['class' => 'form-control']) }}
						{{ Form::hidden('idarea_paac')}}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8 @if($errors->first('nombre_paac')) has-error has-feedback @endif">
						{{ Form::label('nombre_paac','Nombre de Reporte') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_paac',Input::old('nombre_paac'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('fecha_paac','Fecha de Presentación') }}<span style='color:red'>*</span>
						<div id="datetimepicker_paac" class="form-group input-group date @if($errors->first('fecha_paac')) has-error has-feedback @endif">
							{{ Form::text('fecha_paac',Input::old('fecha_paac'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-2 col-md-offset-10">
						{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
					</div>
				</div>
			</div>
		</div>
	{{ Form::close() }}
	
@stop