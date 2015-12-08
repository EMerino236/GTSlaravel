@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Plantillas de Inspeccíon de servicios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

{{ Form::open(array('url'=>'/plantillas_servicios/search_servicio','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_nombre','Nombre de Equipo') }}
				{{ Form::text('search_nombre',$search_nombre,array('class'=>'form-control','placeholder'=>'Nombre de Equipo')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_grupo','Grupo') }}
				{{ Form::text('search_grupo',$search_grupo,array('class'=>'form-control','placeholder'=>'Grupo'))  }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_departamento','Departamento') }}
				{{ Form::text('search_departamento',$search_departamento,array('class'=>'form-control','placeholder'=>'Departamento')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_usuario','Usuario') }}				
				{{ Form::text('search_usuario',$search_usuario,array('class'=>'form-control','placeholder'=>'Usuario')) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-xs-4">
				{{ Form::label('search_servicio_clinico','Servicio Clínico') }}				
				{{ Form::text('search_servicio_clinico',$search_servicio_clinico,array('class'=>'form-control','placeholder'=>'Servicio Clínico')) }}
			</div>
			<div class="col-xs-4">
				
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Filtrar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar">Limpiar</div>				
			</div>
		</div>

	  </div>
	</div>
	{{ Form::close() }}</br>	
	<div class="container-fluid form-group row">
		<div class="col-md-3 col-md-offset-9">
			<a class="btn btn-primary btn-block" href="{{URL::to('plantillas_servicios/create_servicio')}}">
			<span class="glyphicon glyphicon-plus"></span> Crear nueva plantilla</a>
		</div>
	</div>

	<table class="table">
		<tr class="info">
			<th>Nombre de equipo</th>
			<th>Departamento</th>
			<th>Servicio Clínico</th>
			<th>Grupo</th>
			<th>Usuario</th>
		</tr>
		@foreach($servicios_data as $servicio_data)
		<tr class="@if($servicio_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/documento_investigacion/edit_documento/')}}/{{$servicio_data->iddocumentosinf}}">{{$servicio_data->nombre}}</a>
			</td>
			<td>
				{{$servicio_data->nombre_tipo_documento}}
			</td>
			<td>
				{{$servicio_data->autor}}
			</td>
			<td>
				{{$servicio_data->codigo_archivamiento}}
			</td>
			<td>
				{{$servicio_data->ubicacion}}
			</td>
		</tr>
		@endforeach
	</table>
@stop