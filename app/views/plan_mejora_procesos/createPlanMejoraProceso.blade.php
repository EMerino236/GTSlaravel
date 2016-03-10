@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Plan de Mejora de Procesos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('autor') }}</strong></p>
			<p><strong>{{ $errors->first('codigo_archivamiento') }}</strong></p>
			<p><strong>{{ $errors->first('ubicacion') }}</strong></p>
			<p><strong>{{ $errors->first('url') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_documento') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('message') }}</strong>
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('error') }}</strong>
		</div>
	@endif

	{{ Form::open(array('url'=>'plan_mejora_proceso/submit_create_plan_mejora_proceso', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Plan de Mejora de Proceso</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_documento')) has-error has-feedback @endif">
						{{ Form::label('idtipo_documento','Tipo de Documento') }}
						{{ Form::select('idtipo_documento',$tipo_documentos,Input::old('idtipo_documento'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre de Documento') }}
						{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('autor')) has-error has-feedback @endif">
						{{ Form::label('autor','Autor') }}
						{{ Form::text('autor',Input::old('autor'),array('class'=>'form-control')) }}
					</div>
				</div>		
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_archivamiento')) has-error has-feedback @endif">
						{{ Form::label('codigo_archivamiento','Código de Archivamiento') }}
						{{ Form::text('codigo_archivamiento',Input::old('codigo_archivamiento'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('ubicacion')) has-error has-feedback @endif">
						{{ Form::label('ubicacion','Ubicación') }}
						{{ Form::text('ubicacion',Input::old('ubicacion'),array('class'=>'form-control')) }}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}
						{{ Form::text('descripcion',Input::old('descripcion'),array('class'=>'form-control')) }}
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
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/plan_mejora_proceso/list_plan_mejora_procesos/')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
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