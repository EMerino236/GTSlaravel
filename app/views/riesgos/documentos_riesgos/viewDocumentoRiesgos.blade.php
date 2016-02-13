@extends('templates/documentosRiesgosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Documento: <strong>{{$documento_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre') }}
							@if($documento_info->deleted_at)
								{{ Form::text('nombre',$documento_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('nombre',$documento_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							@if($documento_info->deleted_at)
								{{ Form::text('descripcion',$documento_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('descripcion',$documento_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('autor')) has-error has-feedback @endif">
							{{ Form::label('autor','Autor') }}
							@if($documento_info->deleted_at)
								{{ Form::text('autor',$documento_info->autor,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('autor',$documento_info->autor,array('class'=>'form-control','readonly'=>'')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('codigo_archivamiento')) has-error has-feedback @endif">
							{{ Form::label('codigo_archivamiento','Código de Archivamiento') }}
							@if($documento_info->deleted_at)
								{{ Form::text('codigo_archivamiento',$documento_info->codigo_archivamiento,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('codigo_archivamiento',$documento_info->codigo_archivamiento,array('class'=>'form-control','readonly'=>'')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('ubicacion')) has-error has-feedback @endif">
							{{ Form::label('ubicacion','Ubicación') }}
							@if($documento_info->deleted_at)
								{{ Form::text('ubicacion',$documento_info->ubicacion,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('ubicacion',$documento_info->ubicacion,array('class'=>'form-control','readonly'=>'')) }}
							@endif
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('fecha_creacion','Fecha de Creación') }}
							{{ Form::text('fecha_creacion',$documento_info->created_at,array('class'=>'form-control','readonly'=>'')) }}					
						</div>						
						<div class="form-group col-md-4 @if($errors->first('idtipo_documento')) has-error has-feedback @endif">
							{{ Form::label('idtipo_documento','Tipo de Documento') }}
							@if($documento_info->deleted_at)
								{{ Form::select('idtipo_documento',$tipo_documentos,$documento_info->id_tipo,['class' => 'form-control','disabled'=>'disabled','readonly'=>'']) }}
							@else
								{{ Form::select('idtipo_documento',$tipo_documentos,$documento_info->id_tipo,['class' => 'form-control','disabled'=>'disabled']) }}	
							@endif	
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('arch_adjunto','Archivo Adjunto') }}
							{{ Form::text('arch_adjunto', $documento_info->nombre_archivo,array('class'=>'form-control','readonly'=>'')) }}
						</div>
						<div class="form-group col-md-2" style="margin-top:25px;">
							{{ Form::open(array('url'=>'/documentos_riesgos/download_documento','role'=>'form')) }}
								@if($documento_info->url != '')
									{{ Form::hidden('url', $documento_info->url) }}
									{{ Form::hidden('nombre_archivo', $documento_info->nombre_archivo) }}
									{{ Form::hidden('nombre_archivo_encriptado', $documento_info->nombre_archivo_encriptado) }}
									{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', array('id'=>'submit-search-form', 'type' => 'submit', 'class' => 'btn btn-success btn-block')) }}
								@else
									{{ Form::label('mensaje','Sin archivo adjunto') }}
								@endif
							{{ Form::close()}}
						</div>	
					</div>	
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::previous()}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
		</div>
	</div>
@stop