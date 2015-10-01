@extends('templates/documentosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Documento: <strong>{{$documento_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
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
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'documento/submit_edit_documento', 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('documento_id', $documento_info->iddocumento) }}

		<div class="col-xs-6">

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre') }}
					@if($documento_info->deleted_at)
						{{ Form::text('nombre',$documento_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('nombre',$documento_info->nombre,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripción') }}
					@if($documento_info->deleted_at)
						{{ Form::text('descripcion',$documento_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('descripcion',$documento_info->descripcion,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('autor')) has-error has-feedback @endif">
					{{ Form::label('autor','Autor') }}
					@if($documento_info->deleted_at)
						{{ Form::text('autor',$documento_info->autor,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('autor',$documento_info->autor,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('codigo_archivamiento')) has-error has-feedback @endif">
					{{ Form::label('codigo_archivamiento','Código de Archivamiento') }}
					@if($documento_info->deleted_at)
						{{ Form::text('codigo_archivamiento',$documento_info->codigo_archivamiento,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('codigo_archivamiento',$documento_info->codigo_archivamiento,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('ubicacion')) has-error has-feedback @endif">
					{{ Form::label('ubicacion','Ubicación') }}
					@if($documento_info->deleted_at)
						{{ Form::text('ubicacion',$documento_info->ubicacion,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('ubicacion',$documento_info->ubicacion,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('fecha_creacion','Fecha de Creación') }}
					{{ Form::text('fecha_creacion',$documento_info->created_at,array('class'=>'form-control','readonly'=>'')) }}					
				</div>
			</div>
			<!--
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idtipo_documento')) has-error has-feedback @endif">
					{{ Form::label('idtipo_documento','Tipo de Documento') }}
					@if($documento_info->deleted_at)
						{{ Form::select('idtipo_documento',$tipo_documentos,Input::old('idtipo_documento'),['class' => 'form-control','readonly'=>'']) }}
					@else
						{{ Form::select('idtipo_documento',$tipo_documentos,Input::old('idtipo_documento'),['class' => 'form-control']) }}	
					@endif	
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('url')) has-error has-feedback @endif">
				    {{ Form::label('archivo','Seleccione archivo adjunto',array('id'=>'archivo','class'=>'')) }}
  					{{ Form::file('archivo','',array('id'=>'archivo','class'=>'')) }}
				</div>
			</div>	
			-->
			
			@if(!$documento_info->deleted_at)
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			@endif		
		</div>
	{{ Form::close() }}
@stop