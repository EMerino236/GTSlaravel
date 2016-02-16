@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Reporte de Priorización</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idarea_rp') }}</strong></p>
			<p><strong>{{ $errors->first('num_doc_responsable_priorizacion') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'reporte_priorizacion/submit_create_reporte_priorizacion', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idservicio_rp')) has-error has-feedback @endif">
						{{ Form::label('idservicio_rp','Servicio') }}
						{{ Form::select('idservicio_rp',array(''=>'Seleccione') + $servicios,Input::old('idservicio_rp'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('idarea_select_rp')) has-error has-feedback @endif">
						{{ Form::label('idarea_select_rp','Departamento') }}<span style='color:red'>*</span>
						{{ Form::select('idarea_select_rp',array(''=>'Seleccione') + $areas,Input::old('idarea_select_rp'),['class' => 'form-control']) }}
						{{ Form::hidden('idarea_rp')}}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('num_doc_responsable_priorizacion')) has-error has-feedback @endif">
						{{ Form::label('num_doc_responsable_priorizacion','N° Documento Responsable',array('id'=>'num_doc_responsable_priorizacion_label')) }}<span style='color:red'>*</span>
						{{ Form::text('num_doc_responsable_priorizacion',Input::old('num_doc_responsable_priorizacion'),array('placeholder'=>'N° Documento de Identidad','class'=>'form-control','maxlength'=>8)) }}
						{{ Form::hidden('idresponsable_priorizacion')}}
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_responsable_priorizacion()"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
						<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_responsable_priorizacion()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_responsable_priorizacion')) has-error has-feedback @endif">
						{{ Form::label('nombre_responsable_priorizacion','Nombre de Responsable',array('id'=>'nombre_responsable_priorizacion_label')) }}
						{{ Form::text('nombre_responsable_priorizacion',Input::old('nombre_responsable_priorizacion'),array('class'=>'form-control','readonly'=>'')) }}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_ot_retiro')) has-error has-feedback @endif">
						{{ Form::label('codigo_ot_retiro','OT de Baja de Equipo',array('id'=>'codigo_ot_retiro_label')) }}<span style='color:red'>*</span>
						{{ Form::text('codigo_ot_retiro',Input::old('codigo_ot_retiro'),array('placeholder'=>'RS0001TS','class'=>'form-control','maxlength'=>8)) }}
						{{ Form::hidden('idot_retiro')}}
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_equipo()"><span class="glyphicon glyphicon-plus"></span> Agregar OT</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
						<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_equipo()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
						{{ Form::label('nombre_equipo','Nombre de Equipo',array('id'=>'nombre_equipo_label')) }}
						{{ Form::text('nombre_equipo',Input::old('nombre_equipo'),array('class'=>'form-control','readonly'=>'')) }}
					</div>
				</div>	
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Subir Documentos</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8 @if($errors->first('archivo')) has-error has-feedback @endif">
					<label class="control-label">Seleccione un Documento<span style='color:red'>*</span></label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>		
			<div class="row">
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/reporte_priorizacion/list_reporte_priorizacion/')}}">Regresar</a>				
				</div>
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