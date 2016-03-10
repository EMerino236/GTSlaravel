@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Plan de Mejora de Proceso: <strong>{{$plan_mejora_proceso_info->nombre}}</strong></h3>
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

	{{ Form::open(array('url'=>'plan_mejora_proceso/submit_edit_plan_mejora_proceso', 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('documento_id', $plan_mejora_proceso_info->iddocumento) }}

		<div class="col-md-12">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre') }}
							@if($plan_mejora_proceso_info->deleted_at)
								{{ Form::text('nombre',$plan_mejora_proceso_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('nombre',$plan_mejora_proceso_info->nombre,array('class'=>'form-control')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							@if($plan_mejora_proceso_info->deleted_at)
								{{ Form::text('descripcion',$plan_mejora_proceso_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('descripcion',$plan_mejora_proceso_info->descripcion,array('class'=>'form-control')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('autor')) has-error has-feedback @endif">
							{{ Form::label('autor','Autor') }}
							@if($plan_mejora_proceso_info->deleted_at)
								{{ Form::text('autor',$plan_mejora_proceso_info->autor,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('autor',$plan_mejora_proceso_info->autor,array('class'=>'form-control')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('codigo_archivamiento')) has-error has-feedback @endif">
							{{ Form::label('codigo_archivamiento','Código de Archivamiento') }}
							@if($plan_mejora_proceso_info->deleted_at)
								{{ Form::text('codigo_archivamiento',$plan_mejora_proceso_info->codigo_archivamiento,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('codigo_archivamiento',$plan_mejora_proceso_info->codigo_archivamiento,array('class'=>'form-control')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('ubicacion')) has-error has-feedback @endif">
							{{ Form::label('ubicacion','Ubicación') }}
							@if($plan_mejora_proceso_info->deleted_at)
								{{ Form::text('ubicacion',$plan_mejora_proceso_info->ubicacion,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('ubicacion',$plan_mejora_proceso_info->ubicacion,array('class'=>'form-control')) }}
							@endif
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('fecha_creacion','Fecha de Creación') }}
							{{ Form::text('fecha_creacion',$plan_mejora_proceso_info->created_at,array('class'=>'form-control','readonly'=>'')) }}					
						</div>						
						<div class="form-group col-md-4 @if($errors->first('idtipo_documento')) has-error has-feedback @endif">
							{{ Form::label('idtipo_documento','Tipo de Documento') }}
							@if($plan_mejora_proceso_info->deleted_at)
								{{ Form::select('idtipo_documento',$tipo_documentos,Input::old('idtipo_documento'),['class' => 'form-control','readonly'=>'','disabled'=>'disabled']) }}
							@else
								{{ Form::select('idtipo_documento',$tipo_documentos,Input::old('idtipo_documento'),['class' => 'form-control','disabled'=>'disabled']) }}	
							@endif	
						</div>
						{{Form::close()}}
						<div class="form-group col-md-2">
							{{ Form::label('arch_adjunto','Archivo Adjunto') }}
							{{ Form::text('arch_adjunto', $plan_mejora_proceso_info->nombre_archivo,array('class'=>'form-control','readonly'=>'')) }}
						</div>
						<div class="form-group col-md-2" style="margin-top:25px;">
							{{ Form::open(array('url'=>'/plan_mejora_proceso/download_documento','role'=>'form')) }}
								@if($plan_mejora_proceso_info->url != '')
									{{ Form::hidden('url', $plan_mejora_proceso_info->url) }}
									{{ Form::hidden('nombre_archivo', $plan_mejora_proceso_info->nombre_archivo) }}
									{{ Form::hidden('nombre_archivo_encriptado', $plan_mejora_proceso_info->nombre_archivo_encriptado) }}
									{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', array('id'=>'submit-search-form', 'type' => 'submit', 'class' => 'btn btn-success btn-block')) }}
								@else
									{{ Form::label('mensaje','Sin archivo adjunto') }}
								@endif
							{{ Form::close()}}
						</div>	
					</div>
			</div>
		</div>
		<div class="row">
		</div>

				<div class="container-fluid row">			
				@if(!$plan_mejora_proceso_info->deleted_at)
				<div class="col-md-2 form-group">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}						
				</div>
				@endif
				<div class="col-md-2 form-group">
					<a class="btn btn-default btn-block" href="{{URL::to('/plan_mejora_proceso/list_plan_mejora_procesos')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
				</div>	
		{{ Form::close() }}
			@if($plan_mejora_proceso_info->deleted_at)
			{{ Form::open(array('url'=>'/plan_mejora_proceso/submit_enable_plan_mejora_proceso', 'role'=>'form','id'=>'submit_enable')) }}
				{{ Form::hidden('documento_id', $plan_mejora_proceso_info->iddocumento) }}
					<div class="form-group col-md-2 col-md-offset-8">
						{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar', array('id'=>'btnEnable', 'class' => 'btn btn-success btn-block')) }}
					</div>
			{{ Form::close() }}
			@else
			{{ Form::open(array('url'=>'/plan_mejora_proceso/submit_disable_plan_mejora_proceso', 'role'=>'form','id'=>'submit_disable')) }}
				{{ Form::hidden('documento_id', $plan_mejora_proceso_info->iddocumento) }}
					<div class="form-group col-md-2 col-md-offset-6">
						{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar', array('id'=>'btnDisable', 'class' => 'btn btn-danger btn-block')) }}
					</div>
			{{ Form::close() }}
			@endif
			</div>
@stop