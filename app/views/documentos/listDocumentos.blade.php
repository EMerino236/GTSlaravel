@extends('templates/documentosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Documentos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/documento/search_documento','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="search_bar">
			{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
			{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
		</div>	
	{{ Form::close() }}</br>

	<table class="table">
		<tr class="info">
			<th>Nombre</th>
			<th>Autor</th>
			<th>Cod. de Archivamiento</th>
			<th>Ubicación</th>
			<th>Tipo de Documento</th>
			<th>Descargar</th>
		</tr>
		@foreach($documentos_data as $documento_data)
		<tr class="@if($documento_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/documento/edit_documento/')}}/{{$documento_data->iddocumento}}">{{$documento_data->nombre}}</a>
			</td>
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
				{{$documento_data->tipo_documento}}
			</td>
			<td>
				{{ Form::open(array('url'=>'/documento/download_documento','role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
					<div class="search_bar">
						{{ Form::hidden('url', $documento_data->url) }}
						{{ Form::submit('Descargar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
					</div>	
				{{ Form::close() }}
			</td>
		</tr>
		@endforeach
	</table>
	@if($search)
		{{ $documentos_data->appends(array('search' => $search))->links() }}
	@else
		{{ $documentos_data->links() }}
	@endif
@stop