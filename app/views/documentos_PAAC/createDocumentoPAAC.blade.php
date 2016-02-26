	@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Documento para PAAC</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idtipo_documento') }}</strong></p>
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('anho') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'documentos_PAAC/submit_create_documento_paac', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Documento</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_documento')) has-error has-feedback @endif">
						{{ Form::label('idtipo_documento','Tipo de Documento') }}<span style="color:red">*</span>
						{{ Form::select('idtipo_documento',array(''=>'Seleccione') + $tipo_documento,Input::old('idtipo_documento'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}<span style="color:red">*</span>
						{{ Form::text('nombre',Input::old('nombre'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('anho')) has-error has-feedback @endif">
						{{ Form::label('anho','Año') }}<span style="color:red">*</span>
						<div id="datetimepicker_cotizacion" class="input-group date">
							{{ Form::text('anho',Input::old('anho'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-12">
						<strong>Reportes Vinculados</strong>  (Puede ser de Reporte de Necesidad de inmediato o mediano plazo (Con Reporte de Priorizacion) y Reporte PAAC O PAAC COMPLEMENTARIO)
					</div>
				</div>
				<div id="div_paac1" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn_paac1')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_cn_paac1',Input::old('codigo_reporte_cn_paac1'),array('id'=>'codigo_reporte_cn_paac1','placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('cod_reporte_cn_paac1')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_cn_paac1" class="btn btn-primary btn-block" onclick="validar_cn_paac(1)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_cn_paac1" class="btn btn-default btn-block" onclick="limpiar_cn_paac(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_cn_paac2" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn_paac2')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_cn_paac2',Input::old('codigo_reporte_cn_paac2'),array('id'=>'codigo_reporte_cn_paac2', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('cod_reporte_cn_paac2')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_cn_paac2" class="btn btn-primary btn-block" onclick="validar_cn_paac(2)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_cn_paac2" class="btn btn-default btn-block" onclick="limpiar_cn_paac(2)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_cn_paac3" class="row" hidden>
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn_paac3')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_cn_paac3',Input::old('codigo_reporte_cn_paac3'),array('id'=>'codigo_reporte_cn_paac3', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('cod_reporte_cn_paac3')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_cn_paac3" class="btn btn-primary btn-block" onclick="validar_cn_paac(3)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_cn_paac3" class="btn btn-default btn-block" onclick="limpiar_cn_paac(3)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_cn_paac4" class="row" hidden>
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn_paac4')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_cn_paac4',Input::old('codigo_reporte_cn_paac4'),array('id'=>'codigo_reporte_cn_paac4', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('cod_reporte_cn_paac4')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_cn_paac4" class="btn btn-primary btn-block" onclick="validar_cn_paac(4)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_cn_paac4" class="btn btn-default btn-block" onclick="limpiar_cn_paac(4)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_cn_paac5" class="row" hidden>
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn_paac5')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_cn_paac5',Input::old('codigo_reporte_cn_paac5'),array('id'=>'codigo_reporte_cn_paac5', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('cod_reporte_cn_paac5')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_cn_paac5" class="btn btn-primary btn-block" onclick="validar_cn_paac(5)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_cn_paac5" class="btn btn-default btn-block" onclick="limpiar_cn_paac(5)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<a id="label_agregar_cn_paac">Agregar más Reportes vinculados</a>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Subir Documentos</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>		
			<div class="row">
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/documentos_PAAC/list_documento_paac/')}}">Regresar</a>				
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