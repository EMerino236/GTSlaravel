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

	<div id="tab_menu">
	  <ul class="nav nav-pills">
	    <li class="active">
	      <a href="#tab_reporte_cn" data-toggle="tab">Reporte de Necesidad</a>
	    </li>
	    <li><a href="#tab_reporte_paac" data-toggle="tab">Reporte de Evaluación de Instalación o Implantación</a>
	    </li>
	  </ul>

	  <div class="tab-content clearfix">
	    <div class="tab-pane active" id="tab_reporte_cn">
		    {{ Form::open(array('url'=>'programacion_reportes/submit_create_programacion_reporte_cn', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Datos Generales</h3>
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
							<div class="form-group col-md-4 @if($errors->first('num_doc_responsable_cn')) has-error has-feedback @endif">
								{{ Form::label('num_doc_responsable_cn','N° Documento Responsable',array('id'=>'num_doc_responsable_cn_label')) }}<span style='color:red'>*</span>
								{{ Form::text('num_doc_responsable_cn',Input::old('num_doc_responsable_cn'),array('placeholder'=>'N° Documento de Identidad','class'=>'form-control','maxlength'=>8)) }}
								{{ Form::hidden('idresponsable_cn')}}
							</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_responsable_cn()"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
								<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_responsable_cn()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
							</div>
							<div class="form-group col-md-4 @if($errors->first('nombre_responsable_cn')) has-error has-feedback @endif">
								{{ Form::label('nombre_responsable_cn','Nombre de Responsable',array('id'=>'nombre_responsable_cn_label')) }}
								{{ Form::text('nombre_responsable_cn',Input::old('nombre_responsable_cn'),array('class'=>'form-control','readonly'=>'')) }}
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
	    </div>
	    <div class="tab-pane" id="tab_reporte_paac">
	      	{{ Form::open(array('url'=>'programacion_reportes/submit_create_programacion_reporte_paac', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Datos Generales</h3>
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
							<div class="form-group col-md-4 @if($errors->first('num_doc_responsable_paac')) has-error has-feedback @endif">
								{{ Form::label('num_doc_responsable_paac','N° Documento Responsable',array('id'=>'num_doc_responsable_paac_label')) }}<span style='color:red'>*</span>
								{{ Form::text('num_doc_responsable_paac',Input::old('num_doc_responsable_paac'),array('placeholder'=>'N° Documento de Identidad','class'=>'form-control','maxlength'=>8)) }}
								{{ Form::hidden('idresponsable_paac')}}
							</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_responsable_paac()"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
								<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_responsable_paac()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
							</div>
							<div class="form-group col-md-4 @if($errors->first('nombre_responsable_paac')) has-error has-feedback @endif">
								{{ Form::label('nombre_responsable_paac','Nombre de Responsable',array('id'=>'nombre_responsable_paac_label')) }}
								{{ Form::text('nombre_responsable_paac',Input::old('nombre_responsable_paac'),array('class'=>'form-control','readonly'=>'')) }}
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
	    </div>
	  </div>
	</div>



	

<!--
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

-->
	
	
@stop