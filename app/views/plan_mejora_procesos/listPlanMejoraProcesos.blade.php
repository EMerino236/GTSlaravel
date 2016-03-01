@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Plan de Mejora de Procesos</h3>
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

{{ Form::open(array('url'=>'/plan_mejora_proceso/search_plan_mejora_proceso','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
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
			<a class="btn btn-primary btn-block" href="{{URL::to('/plan_mejora_proceso/create_plan_mejora_proceso')}}">
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
					@foreach($plan_mejora_procesos_data as $plan_mejora_proceso_data)
					<tr class="@if($plan_mejora_proceso_data->deleted_at) bg-danger @endif">
						<td class="text-nowrap">
							<a href="{{URL::to('/plan_mejora_proceso/view_plan_mejora_proceso/')}}/{{$plan_mejora_proceso_data->iddocumento}}">{{$plan_mejora_proceso_data->nombre}}</a>
						</td>	
						
						<td class="text-nowrap text-center">
							{{$plan_mejora_proceso_data->autor}}
						</td>
						<td class="text-nowrap text-center">
							{{$plan_mejora_proceso_data->codigo_archivamiento}}
						</td>
						<td class="text-nowrap text-center">
							{{$plan_mejora_proceso_data->ubicacion}}
						</td>
						<td class="text-nowrap text-center" class="text-nowrap text-center">
							{{$plan_mejora_proceso_data->nombre_tipo_documento}}
						</td>
						<td class="text-nowrap text-center">
							{{$plan_mejora_proceso_data->created_at}}
						</td>
						<td class="text-nowrap text-center">
							{{ Form::open(array('url'=>'/plan_mejora_proceso/download_documento','role'=>'form')) }}
								@if($plan_mejora_proceso_data->url != '')
									{{ Form::hidden('url', $plan_mejora_proceso_data->url) }}
									{{ Form::hidden('nombre_archivo', $plan_mejora_proceso_data->nombre_archivo) }}
									{{ Form::hidden('nombre_archivo_encriptado', $plan_mejora_proceso_data->nombre_archivo_encriptado) }}
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
								<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/plan_mejora_proceso/edit_plan_mejora_proceso/')}}/{{$plan_mejora_proceso_data->iddocumento}}">
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
		{{ $plan_mejora_procesos_data->appends(array('search_nombre' => $search_nombre, 'search_autor'=> $search_autor,
		'search_codigo_archivamiento'=> $search_codigo_archivamiento, 'search_ubicacion'=> $search_ubicacion, 
		'search_tipo_documento'=>$search_tipo_documento))->links() }}
	@else
		{{ $plan_mejora_procesos_data->links() }}
	@endif
@stop