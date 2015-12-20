@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Guía: <strong>{{$documento_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('autor') }}</strong></p>
			<p><strong>{{ $errors->first('url') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_documento') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'guias_clinica_gpc/edit_guia/'.$documento_info->iddocumentosinf, 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('documento_id', $documento_info->iddocumentosinf) }}
		{{ Form::hidden('idtipo_documento', $documento_info->idtipo_documentosinf) }}
		{{ Form::hidden('id_subtipo', $documento_info->id_subtipo) }}

		<div class="col-md-6">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre') }}
							@if($documento_info->deleted_at)
								{{ Form::text('nombre',$documento_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('nombre',$documento_info->nombre,array('class'=>'form-control')) }}
							@endif
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							@if($documento_info->deleted_at)
								{{ Form::text('descripcion',$documento_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('descripcion',$documento_info->descripcion,array('class'=>'form-control')) }}
							@endif
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('autor')) has-error has-feedback @endif">
							{{ Form::label('autor','Autor') }}
							@if($documento_info->deleted_at)
								{{ Form::text('autor',$documento_info->autor,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('autor',$documento_info->autor,array('class'=>'form-control')) }}
							@endif
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('fecha_creacion','Fecha de Creación') }}
							{{ Form::text('fecha_creacion',$documento_info->created_at,array('class'=>'form-control','readonly'=>'')) }}					
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8">
							{{ Form::label('arch_adjunto','Archivo Adjunto') }}
							{{ Form::text('arch_adjunto',$archivo,array('class'=>'form-control','readonly'=>'')) }}					
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
		</div>
		
		@if(!$archivo)
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Adjuntar Archivo</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>		
		@endif

		<div class="container-fluid row">			
			@if(!$documento_info->deleted_at)
			<div class="col-md-2 form-group">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}						
			</div>
			@endif
			<div class="col-md-2 form-group">
				<a class="btn btn-default btn-block" href="{{URL::to('/guias_clinica_gpc/list_guias')}}">Cancelar</a>
			</div>	
		{{ Form::close() }}
			@if($documento_info->deleted_at)
			{{ Form::open(array('url'=>'guias_clinica_gpc/submit_enable_guia', 'role'=>'form')) }}
				{{ Form::hidden('documento_id', $documento_info->iddocumentosinf) }}
					<div class="form-group col-md-2 col-md-offset-8">
						{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar', array('id'=>'submit-delete', 'type' => 'submit', 'class' => 'btn btn-success btn-block')) }}
					</div>
			{{ Form::close() }}
			@else
			{{ Form::open(array('url'=>'guias_clinica_gpc/submit_disable_guia', 'role'=>'form')) }}
				{{ Form::hidden('documento_id', $documento_info->iddocumentosinf) }}
					<div class="form-group col-md-2 col-md-offset-6">
						{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar', array('id'=>'submit-delete', 'type' => 'submit', 'class' => 'btn btn-danger btn-block')) }}
					</div>
			{{ Form::close() }}
			@endif
		</div>
		
	{{ Form::close() }}

	<script>
		$("#input-file").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>

@stop