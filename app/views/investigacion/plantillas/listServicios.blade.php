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
				{{ Form::label('search_nombre','Nombre de Familia') }}
				{{ Form::text('search_nombre',$search_nombre,array('class'=>'form-control','placeholder'=>'Nombre de Familia')) }}
			</div>
			<div class="col-xs-4">
				{{ Form::label('search_marca','Marca') }}
				{{ Form::select('search_marca',array('0' => 'Seleccione') + $marcas, $search_marca,array('class'=>'form-control','placeholder'=>'Marca'))  }}
			</div>
		</div>
		<!--
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
		-->
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Filtrar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar" onclick="limpiar_criterios_ins_serv()">Limpiar</div>				
			</div>
		</div>
		
	  </div>
	</div>
	{{ Form::close() }}</br>	
	<div class="col-md-6">
		<table class="table">
			<tr class="info">
				<th>Nombre de familia</th>
				<th>Nombre de la marca</th>
			</tr>
			@foreach($servicios_data as $servicio_data)
			<tr class="@if($servicio_data->deleted_at) bg-danger @endif">
				<td>
					<a href="{{URL::to('/plantillas_servicios/create_servicio/')}}/{{$servicio_data->idfamilia_activo}}">{{$servicio_data->nombre_equipo}}</a>
					
				</td>
				<td>{{$servicio_data->marca->nombre}}</td>
			</tr>
			@endforeach
		</table>
	</div>
	<div class="col-md-12">
	@if($search_nombre || $search_marca!=0)
		{{ $servicios_data->appends(array('search_nombre' => $search_nombre, 'search_marca'=> $search_marca))->links() }}
	@else
		{{ $servicios_data->links() }}
	@endif
	</div>
@stop