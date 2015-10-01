@extends('templates/documentosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Documentos</h3>
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

	{{ Form::open(array('url'=>'documento/submit_create_documento', 'role'=>'form', 'files'=>true)) }}
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre de Documento') }}
					{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::text('descripcion',Input::old('descripcion'),array('class'=>'form-control')) }}
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('autor')) has-error has-feedback @endif">
					{{ Form::label('autor','Autor') }}
					{{ Form::text('autor',Input::old('autor'),array('class'=>'form-control')) }}
				</div>
			</div>		
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('codigo_archivamiento')) has-error has-feedback @endif">
					{{ Form::label('codigo_archivamiento','Código de Archivamiento') }}
					{{ Form::text('codigo_archivamiento',Input::old('codigo_archivamiento'),array('class'=>'form-control')) }}
				</div>
			</div>		
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('ubicacion')) has-error has-feedback @endif">
					{{ Form::label('ubicacion','Ubicación') }}
					{{ Form::text('ubicacion',Input::old('ubicacion'),array('class'=>'form-control')) }}
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idtipo_documento')) has-error has-feedback @endif">
					{{ Form::label('idtipo_documento','Tipo de Documento') }}
					{{ Form::select('idtipo_documento',$tipo_documentos,Input::old('idtipo_documento'),['class' => 'form-control']) }}
				</div>
			</div>	
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('url')) has-error has-feedback @endif">
				    {{ Form::label('archivo','Seleccione archivo adjunto',array('id'=>'archivo','class'=>'')) }}
  					{{ Form::file('archivo','',array('id'=>'archivo','class'=>'form-control')) }}
				</div>
			</div>				
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			</div>		
		</div>	
	{{ Form::close() }}
@stop