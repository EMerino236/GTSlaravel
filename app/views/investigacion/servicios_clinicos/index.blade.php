@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Busqueda Documentos para la creación de Servicios Clínicos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	{{ Form::open(['route'=>'servicios_clinicos.search','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group']) }}
	
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>
	  	<div class="panel-body">
		    <div class="form-group row">
				<div class="col-xs-4">
					{{ Form::label('search_codigo','Código de Archivamiento') }}
					{{ Form::text('search_codigo',$search_codigo,array('id'=>'search_codigo','class'=>'form-control','placeholder'=>'Código de Archivamiento'))  }}
				</div>
				<div class="col-xs-4">
					{{ Form::label('search_servicio','Servicio') }}
					{{ Form::select('search_servicio',[0=>'Seleccione'] + $servicios, $search_servicio,array('id'=>'search_servicio','class'=>'form-control')) }}
				</div>
				<div class="col-xs-4">
					{{ Form::label('search_usuario','Usuario') }}
					{{ Form::select('search_usuario',[0=>'Seleccione'] + $usuarios, $search_usuario,array('id'=>'search_usuario','class'=>'form-control')) }}
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xs-4">
					{{ Form::label('search_nombre','Nombre') }}
					{{ Form::text('search_nombre',$search_nombre,array('id'=>'search_nombre','class'=>'form-control','placeholder'=>'Nombre')) }}
				</div>
			</div>

			<div class="form-group row">
				<div class="form-group col-md-2 col-md-offset-8">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
				</div>
				<div class="form-group col-md-2">
					<div class="btn btn-default btn-block" id="btnLimpiar" onClick="limpiar_criterios_sol_serv()">Limpiar</div>				
				</div>
			</div>
	  	</div>
	</div>

	{{ Form::close() }}

	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{route('servicios_clinicos.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<table class="table">
		<tr class="info">
			<th>Servicio</th>
			<th>Nombre de documento</th>
			<th>Usuario</th>
			<th>Código de archivamiento</th>
			<th>Fecha de creación</th>
			<th>Archivo Adjunto</th>
		</tr>
		@foreach($servicios_data as $documento_data)
		<tr class="@if($documento_data->deleted_at) bg-danger @endif">
			<td>
				{{$documento_data->servicio->nombre}}
			</td>
			<td>
				<a href="{{route('servicios_clinicos.edit',$documento_data->id)}}">{{$documento_data->nombre}}</a>
			</td>
			<td>
				{{$documento_data->usuario->UserFullName}}
			</td>
			<td>
				{{$documento_data->codigo}}
			</td>
			<td>
				{{$documento_data->created_at}}
			</td>
			<td>
				{{ Form::open(['route'=>['servicios_clinicos.download',$documento_data->id],'role'=>'form', 'id'=>'search-form','class' => 'form-inline']) }}
					<div class="search_bar">
						@if($documento_data->url != '')
							{{ Form::submit('Descargar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
						@else
							{{ Form::label('mensaje','Sin archivo adjunto') }}
						@endif
					</div>	
				{{ Form::close() }}
			</td>
		</tr>
		@endforeach
	</table>
	@if($search_codigo || $search_servicio || $search_usuario || $search_nombre)
		{{ $servicios_data->appends(array('search_codigo' => $search_codigo, 'search_servicio'=> $search_servicio,
		'search_usuario'=> $search_usuario, 'search_nombre' => $search_nombre))->links() }}
	@else
		{{ $servicios_data->links() }}
	@endif

@stop