@extends('templates/documentosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Documentos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

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
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Nombre</th>
						<th class="text-nowrap text-center">Autor</th>
						<th class="text-nowrap text-center">Cod. de Archivamiento</th>
						<th class="text-nowrap text-center">Ubicación</th>
						<th class="text-nowrap text-center">Tipo de Documento</th>
						<th class="text-nowrap text-center">Fecha de Creación</th>
						<th class="text-nowrap text-center">Archivo Adjunto</th>
						<th class="text-nowrap text-center">Editar</th>
					</tr>
					@foreach($documentos_data as $documento_data)
					<tr class="@if($documento_data->deleted_at) bg-danger @endif">
						<td class="text-nowrap">
							<a href="{{URL::to('/documento/view_documento/')}}/{{$documento_data->iddocumento}}">{{$documento_data->nombre}}</a>
						</td>	
						
						<td class="text-nowrap text-center">
							{{$documento_data->autor}}
						</td>
						<td class="text-nowrap text-center">
							{{$documento_data->codigo_archivamiento}}
						</td>
						<td class="text-nowrap text-center">
							{{$documento_data->ubicacion}}
						</td>
						<td class="text-nowrap text-center" class="text-nowrap text-center">
							{{$documento_data->nombre_tipo_documento}}
						</td>
						<td class="text-nowrap text-center">
							{{$documento_data->created_at}}
						</td>
						<td class="text-nowrap text-center">
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
						@if($user->idrol == 5 || $user->idrol == 7 || $user->idrol == 8 || $user->idrol == 9 || $user->idrol == 10 || $user->idrol == 11
						|| $user->idrol == 12)
							<td class="text-nowrap text-center">
								-
							</td>	
						@else
							<td class="text-nowrap text-center">
								<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/documento/edit_documento/')}}/{{$documento_data->iddocumento}}">
								<span class="glyphicon glyphicon-pencil"></span></a>
							</td>			
						@endif
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
	
	@if($search_nombre || $search_autor || $search_codigo_archivamiento || $search_ubicacion || $search_tipo_documento)
		{{ $documentos_data->appends(array('search_nombre' => $search_nombre, 'search_autor'=> $search_autor,
		'search_codigo_archivamiento'=> $search_codigo_archivamiento, 'search_ubicacion'=> $search_ubicacion, 
		'search_tipo_documento'=>$search_tipo_documento))->links() }}
	@else
		{{ $documentos_data->links() }}
	@endif
@stop