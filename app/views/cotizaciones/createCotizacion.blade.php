@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Agregar Cotización</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_equipo') }}</strong></p>
			<p><strong>{{ $errors->first('modelo_equipo') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor') }}</strong></p>
			<p><strong>{{ $errors->first('anho') }}</strong></p>
			<p><strong>{{ $errors->first('precio') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_referencia') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'cotizaciones/submit_create_cotizacion', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la Cotización</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
						{{ Form::label('nombre_equipo','Nombre de Equipo') }}<span style="color:red">*</span>
						<input type="hidden" id="nombre_equipo_string" name="nombre_equipo_string" />
						{{ Form::select('nombre_equipo',array(''=>'Seleccione') + $nombres_equipo,Input::old('nombre_equipo'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_detallado')) has-error has-feedback @endif">
						{{ Form::label('nombre_detallado','Nombre Detallado') }}
						{{ Form::text('nombre_detallado',Input::old('nombre_detallado'),['placeholder'=>'Nombre de Accesorio o Componente','class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('marca')) has-error has-feedback @endif">
						{{ Form::label('marca','Marca') }}<span style="color:red">*</span>
						{{ Form::text('marca',Input::old('marca'),['placeholder'=>'Marca','class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('modelo_equipo')) has-error has-feedback @endif">
						{{ Form::label('modelo_equipo','Modelo de Equipo') }}<span style="color:red">*</span>
						{{ Form::text('modelo_equipo',Input::old('modelo_equipo'),['placeholder'=>'Modelo de Equipo','class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
						{{ Form::label('proveedor','Proveedor') }}<span style="color:red">*</span>
						{{ Form::text('proveedor',Input::old('proveedor'),['placeholder'=>'Proveedor','class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('precio')) has-error has-feedback @endif">
						{{ Form::label('precio','Precio') }}<span style="color:red">*</span>
						{{ Form::text('precio',Input::old('precio'),['placeholder'=>'Precio Referencial','class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('año')) has-error has-feedback @endif">
						{{ Form::label('año','Año') }}<span style="color:red">*</span>
						<div id="datetimepicker_cotizacion" class="input-group date">
							{{ Form::text('anho',Input::old('anho'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-4 @if($errors->first('tipo_referencia')) has-error has-feedback @endif">
						{{ Form::label('tipo_referencia','Tipo de Referencia') }}<span style="color:red">*</span>
						{{ Form::select('tipo_referencia',array(''=>'Seleccione') + $tipos_referencia,Input::old('tipo_referencia'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('codigo_cotizacion')) has-error has-feedback @endif">
						{{ Form::label('codigo_cotizacion','Código de Cotización') }}
						{{ Form::text('codigo_cotizacion',Input::old('codigo_cotizacion'),['placeholder'=>'Código de Cotización','class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-8 @if($errors->first('enlace_seace')) has-error has-feedback @endif">
						{{ Form::label('enlace_seace','Enlace SEACE') }}
						{{ Form::text('enlace_seace',Input::old('enlace_seace'),['placeholder'=>'Enlace SEACE','class' => 'form-control']) }}
					</div>
				</div>
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