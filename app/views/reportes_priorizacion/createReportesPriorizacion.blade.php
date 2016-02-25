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
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
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
					<div class="form-group col-md-12">
						<strong>Reportes de Necesidad Vinculados</strong>  (Los reportes deben tener al menos un Reporte ETES vinculado)
					</div>
				</div>
				<div id="div_cn1" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn1')) has-error has-feedback @endif">					
						{{ Form::text('codigo_reporte_cn1',Input::old('codigo_reporte_cn1'),array('id'=>'codigo_reporte_cn1', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('idreporte_cn1')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_cn1" class="btn btn-primary btn-block" onclick="validar_cn(1)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_cn1" class="btn btn-default btn-block" onclick="limpiar_cn(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_cn2" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn2')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_cn2',Input::old('codigo_reporte_cn2'),array('id'=>'codigo_reporte_cn2', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('idreporte_cn2')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_cn2" class="btn btn-primary btn-block" onclick="validar_cn(2)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_cn2" class="btn btn-default btn-block" onclick="limpiar_cn(2)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_cn3" class="row" hidden>
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn3')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_cn3',Input::old('codigo_reporte_cn3'),array('id'=>'codigo_reporte_cn3', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('idreporte_cn3')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_cn3" class="btn btn-primary btn-block" onclick="validar_cn(3)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_cn3" class="btn btn-default btn-block" onclick="limpiar_cn(3)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_cn4" class="row" hidden>
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn4')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_cn4',Input::old('codigo_reporte_cn4'),array('id'=>'codigo_reporte_cn4', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('idreporte_cn4')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_cn4" class="btn btn-primary btn-block" onclick="validar_cn(4)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_cn4" class="btn btn-default btn-block" onclick="limpiar_cn(4)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_cn5" class="row" hidden>
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn5')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_cn5',Input::old('codigo_reporte_cn5'),array('id'=>'codigo_reporte_cn5', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('idreporte_cn5')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_cn5" class="btn btn-primary btn-block" onclick="validar_cn(5)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_cn5" class="btn btn-default btn-block" onclick="limpiar_cn(5)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<a id="label_agregar_cn">Agregar más Reportes de Necesidad vinculados</a>
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