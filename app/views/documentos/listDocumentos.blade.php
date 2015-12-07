@extends('templates/documentosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Documentos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

{{ Form::open(array('url'=>'/documento/search_documento','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="row">
			<div class="col-md-4 form-group">
				{{ Form::label('search_nombre','Nombre de Documento') }}
				{{ Form::text('search_nombre',$search_nombre,array('class'=>'form-control','placeholder'=>'Nombre de Documento')) }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_autor','Autor de Documento') }}
				{{ Form::text('search_autor',$search_autor,array('class'=>'form-control','placeholder'=>'Autor de Documento'))  }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_codigo_archivamiento','Código de Archivamiento') }}				
				{{ Form::text('search_codigo_archivamiento',$search_codigo_archivamiento,array('class'=>'form-control','placeholder'=>'Código de Archivamiento')) }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_ubicacion','Ubicación') }}
				{{ Form::text('search_ubicacion',$search_ubicacion,array('class'=>'form-control','placeholder'=>'Ubicación')) }}
			</div>
			<div class="col-md-4 form-group">
				{{ Form::label('search_tipo_documento','Tipo de Documento') }}				
				{{ Form::select('search_tipo_documento', array('0' => 'Seleccione') + $tipo_documentos,$search_tipo_documento,['class' => 'form-control']) }}				
			</div>
		</div>	
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
			</div>
		</div>

	  </div>
	</div>
	{{ Form::close() }}</br>	
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/documento/create_documento')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<table class="table">
		<tr class="info">
			<th>Nombre</th>
			<th>Autor</th>
			<th>Cod. de Archivamiento</th>
			<th>Ubicación</th>
			<th>Tipo de Documento</th>
			<th>Fecha de Creación</th>
			<th>Archivo Adjunto</th>
		</tr>
		@foreach($documentos_data as $documento_data)
		<tr class="@if($documento_data->deleted_at) bg-danger @endif">
			@if($user->idrol == 5 || $user->idrol == 7 || $user->idrol == 8 || $user->idrol == 9 || $user->idrol == 10 || $user->idrol == 11
			|| $user->idrol == 12)
				<td>
					<a href="{{URL::to('/documento/view_documento/')}}/{{$documento_data->iddocumento}}">{{$documento_data->nombre}}</a>
				</td>	
			@else
				<td>
					<a href="{{URL::to('/documento/edit_documento/')}}/{{$documento_data->iddocumento}}">{{$documento_data->nombre}}</a>
				</td>			
			@endif
			
			<td>
				{{$documento_data->autor}}
			</td>
			<td>
				{{$documento_data->codigo_archivamiento}}
			</td>
			<td>
				{{$documento_data->ubicacion}}
			</td>
			<td>
				{{$documento_data->nombre_tipo_documento}}
			</td>
			<td>
				{{$documento_data->created_at}}
			</td>
			<td>
				{{ Form::open(array('url'=>'/documento/download_documento','role'=>'form')) }}
					@if($documento_data->url != '')
						{{ Form::hidden('url', $documento_data->url) }}
						{{ Form::hidden('nombre_archivo', $documento_data->nombre_archivo) }}
						{{ Form::hidden('nombre_archivo_encriptado', $documento_data->nombre_archivo_encriptado) }}
						{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', array('id'=>'submit-search-form', 'type' => 'submit', 'class' => 'btn btn-success btn-block')) }}
					@else
						{{ Form::label('mensaje','Sin archivo adjunto') }}
					@endif
				{{ Form::close() }}
			</td>
		</tr>
		@endforeach
	</table>
	@if($search_nombre || $search_autor || $search_codigo_archivamiento || $search_ubicacion || $search_tipo_documento)
		{{ $documentos_data->appends(array('search_nombre' => $search_nombre, 'search_autor'=> $search_autor,
		'search_codigo_archivamiento'=> $search_codigo_archivamiento, 'search_ubicacion'=> $search_ubicacion, 
		'search_tipo_documento'=>$search_tipo_documento))->links() }}
	@else
		{{ $documentos_data->links() }}
	@endif
@stop