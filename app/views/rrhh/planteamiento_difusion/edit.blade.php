@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Planteamiento de Difusión</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>			
			<p><strong>{{ $errors->first('nombre_planteamiento_difusion') }}</strong></p>
			<p><strong>{{ $errors->first('departamento_planteamiento_difusion') }}</strong></p>
			<p><strong>{{ $errors->first('servicio_planteamiento_difusion') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_planteamiento_difusion') }}</strong></p>
			<p><strong>{{ $errors->first('dni_responsable_planteamiento_difusion') }}</strong></p>
			<p><strong>{{ $errors->first('idresponsable',"El Responsable Asignado no es un usuario del sistema. ") }}</strong></p>
			<p><strong>{{ $errors->first('fecha_ini_planteamiento_difusion') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_fin_planteamiento_difusion') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>		
		</div>
	@endif

	{{ Form::open(array('route'=>['planteamiento_difusion.update',$plan_difusion->id], 'role'=>'form', 'files'=>true)) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('nombre_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('nombre_planteamiento_difusion','Nombre') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_planteamiento_difusion',$plan_difusion->nombre,['class' => 'form-control'])}}						
					</div>
					<div class="col-md-4 @if($errors->first('departamento_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('departamento_planteamiento_difusion','Departamento') }}<span style='color:red'>*</span>
						{{ Form::select('departamento_planteamiento_difusion', array('' => 'Seleccione') + $departamentos,$plan_difusion->iddepartamento,['class' => 'form-control', 'onChange' =>'getServiciosCreateAjax()']) }}						
					</div>
					<div class="col-md-4 @if($errors->first('servicio_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('servicio_planteamiento_difusion','Servicio') }}<span style='color:red'>*</span>
						{{ Form::select('servicio_planteamiento_difusion', array('' => 'Seleccione') +$servicios,$plan_difusion->idservicio,['class' => 'form-control']) }}						
					</div>					
				</div>					
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('descripcion_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('descripcion_planteamiento_difusion','Descripción (MAX:200 Caracteres)') }}
						{{ Form::textarea('descripcion_planteamiento_difusion',$plan_difusion->descripcion,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
					</div>
				</div>
				<div class="form-group row">					
					<div class="col-md-4 @if($errors->first('dni_responsable_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('dni_responsable_planteamiento_difusion','Número de Documento del Responsable') }}<span style='color:red'>*</span>
						{{ Form::text('dni_responsable_planteamiento_difusion',$plan_difusion->responsable->numero_doc_identidad,['class' => 'form-control'])}}						
					</div>
					<div class="col-md-2">
						<button id="btnValidarResponsablePlanDifusion" class="btn btn-primary btn-block" type="button" style="margin-top:25px" onClick="getUserCreateAjax()"><span class="glyphicon glyphicon-search"></span> Buscar</button>
					</div>
					<div class="col-md-2">
						<button id="btnLimpiarResponsablePlanDifusion" class="btn btn-default btn-block" type="button" style="margin-top:25px" onClick="limpiarResponsableData()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</button>						
					</div>
					<div class="col-md-4 @if($errors->first('responsable_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('responsable_planteamiento_difusion','Nombre del Responsable') }}<span style='color:red'>*</span>
						{{ Form::text('responsable_planteamiento_difusion',$plan_difusion->responsable->apellido_pat . " " . $plan_difusion->responsable->apellido_mat . ", " . $plan_difusion->responsable->nombre,['class' => 'form-control', 'readonly' => 'true'])}}
						{{ Form::hidden('idresponsable',$plan_difusion->responsable->id,array('id'=>'idresponsable')) }}
					</div>
				</div>			
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('fecha_ini_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('fecha_ini_planteamiento_difusion','Fecha Inicio') }}<span style="color:red">*</span>
						<div id="datetimepicker_create_plan_difusion_ini" class="form-group input-group date">
							{{ Form::text('fecha_ini_planteamiento_difusion',date('d-m-Y',strtotime($plan_difusion->fechainicio)),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="col-md-4 @if($errors->first('fecha_fin_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('fecha_fin_planteamiento_difusion','Fecha Fin') }}<span style="color:red">*</span>
						<div id="datetimepicker_create_plan_difusion_fin" class="form-group input-group date">
							{{ Form::text('fecha_fin_planteamiento_difusion',date('d-m-Y',strtotime($plan_difusion->fechafin)),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-4">
						{{ Form::label('file_documento','Archivo') }}
						{{ Form::text('file_documento',$plan_difusion->nombre_archivo,['class' => 'form-control', 'readonly' => 'true'])}}						
					</div>
					<div class="col-md-2 hide">
						<a class="btn btn-success btn-block btn-md" style="width:145px; float: left; margin-top:25px" href="{{route('planteamiento_difusion.download',$plan_difusion->id)}}">
						<span class="glyphicon glyphicon-download"></span> Descargar</a>
					</div>
					<div class="col-md-2">
						<div class="btn btn-warning btn-block" style="width:145px; float: left; margin-top:25px" id="btnReemplazar" onClick="showAdjuntarPlanDifusion()">
							<span class="glyphicon glyphicon-refresh"></span> Reemplazar</div>				
					</div>
				</div>
		</div>
	</div>

	<div id="adjuntar_plan_difusion" class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Adjuntar Archivo</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-8 @if($errors->first('archivo')) has-error has-feedback @endif">
				<label class="control-label">Seleccione un Documento </label><span style='color:red'>*</span><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="right" title="Formatos Permitidos: png, jpe, jpeg, jpg, gif, bmp, zip, rar, pdf, doc, docx, xls, xlsx, ppt, pptx"></span>
				<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
			</div>
		</div>	
	</div>
		
	<div class="container-fluid row">
		<div class="form-group col-md-2 col-md-offset-8">				
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block','style' => '145px')) }}
		</div>
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" style="width:145x" href="{{route('planteamiento_difusion.index')}}">Cancelar</a>				
		</div>
	</div>
		{{ Form::close() }}

	<script>
	$("#input-file").fileinput({
	    language: "es",
	    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
	});
	</script>
@stop