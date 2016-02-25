@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programación de Elaboración de Guias y Reportes</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idtipo_reporte_ts') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_reporte_etes') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_publicacion') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_ts') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_etes') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_gpc') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_ts') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_etes') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_gpc') }}</strong></p>
			<p><strong>{{ $errors->first('num_doc_responsable_etes') }}</strong></p>
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
	    	<a href="#tab_reporte_ts" data-toggle="tab">Guía de práctica de Tecnologías de Salud</a>
	    </li>
	    <li>
	    	<a href="#tab_reporte_gpc" data-toggle="tab">Guía de práctica Clínica GPC</a>
	    </li>
	    <li>
	    	<a href="#tab_reporte_etes" data-toggle="tab">Reporte ETES</a>
	    </li>
	  </ul>

	  <div class="tab-content clearfix">
	    <div class="tab-pane active" id="tab_reporte_ts">
		    {{ Form::open(array('url'=>'programacion_guias/submit_create_programacion_guia_ts', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Datos Generales</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-4 @if($errors->first('idtipo_reporte_ts')) has-error has-feedback @endif">
								{{ Form::label('idtipo_reporte_ts','Tipo de Guía') }}<span style='color:red'>*</span>
								{{ Form::select('idtipo_reporte_ts',array(''=>'Seleccione') + $tipo_reporte_ts,Input::old('idtipo_reporte_ts'),['class' => 'form-control']) }}
							</div>
						</div>

						<div class="row">
							<div class="form-group col-md-8 @if($errors->first('nombre_ts')) has-error has-feedback @endif">
								{{ Form::label('nombre_ts','Nombre de Guía') }}<span style='color:red'>*</span>
								{{ Form::text('nombre_ts',Input::old('nombre_ts'),['class' => 'form-control']) }}
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								{{ Form::label('fecha_ts','Fecha de Presentación') }}<span style='color:red'>*</span>
								<div id="datetimepicker_ts" class="form-group input-group date @if($errors->first('fecha_ts')) has-error has-feedback @endif">
									{{ Form::text('fecha_ts',Input::old('fecha_ts'),array('class'=>'form-control', 'readonly'=>'')) }}
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
	    <div class="tab-pane" id="tab_reporte_gpc">
	      	{{ Form::open(array('url'=>'programacion_guias/submit_create_programacion_guia_gpc', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Datos Generales</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-4 @if($errors->first('fecha_publicacion')) has-error has-feedback @endif">
								{{ Form::label('fecha_publicacion','Fecha de Publicación') }}<span style='color:red'>*</span>
								<div id="datetimepicker_fecha" class="form-group input-group date @if($errors->first('fecha_publicacion')) has-error has-feedback @endif">
									{{ Form::text('fecha_publicacion',Input::old('fecha_publicacion'),array('class'=>'form-control', 'readonly'=>'')) }}
									<span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-8 @if($errors->first('nombre_gpc')) has-error has-feedback @endif">
								{{ Form::label('nombre_gpc','Nombre de Guía') }}<span style='color:red'>*</span>
								{{ Form::text('nombre_gpc',Input::old('nombre_gpc'),['class' => 'form-control']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								{{ Form::label('fecha_gpc','Fecha de Presentación') }}<span style='color:red'>*</span>
								<div id="datetimepicker_gpc" class="form-group input-group date @if($errors->first('fecha_gpc')) has-error has-feedback @endif">
									{{ Form::text('fecha_gpc',Input::old('fecha_gpc'),array('class'=>'form-control', 'readonly'=>'')) }}
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
	    <div class="tab-pane" id="tab_reporte_etes">
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
							<div class="form-group col-md-4 @if($errors->first('num_doc_responsable_etes')) has-error has-feedback @endif">
								{{ Form::label('num_doc_responsable_etes','N° Documento Responsable',array('id'=>'num_doc_responsable_etes_label')) }}<span style='color:red'>*</span>
								{{ Form::text('num_doc_responsable_etes',Input::old('num_doc_responsable_etes'),array('placeholder'=>'N° Documento de Identidad','class'=>'form-control','maxlength'=>8)) }}
								{{ Form::hidden('idresponsable_etes')}}
							</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_responsable_etes()"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
								<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_responsable_etes()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
							</div>
							<div class="form-group col-md-4 @if($errors->first('nombre_responsable_etes')) has-error has-feedback @endif">
								{{ Form::label('nombre_responsable_etes','Nombre de Responsable',array('id'=>'nombre_responsable_etes_label')) }}
								{{ Form::text('nombre_responsable_etes',Input::old('nombre_responsable_etes'),array('class'=>'form-control','readonly'=>'')) }}
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
	    </div>
	  </div>
	</div>
	
@stop