@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Plantillas de Mantenimiento Preventivo por TS</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

{{ Form::open(array('url'=>'/plantillas_mant_preventivo/search_mantenimiento','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
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
				<th>Tipo</th>
				<th>Estado</th>
			</tr>
			@foreach($mantenimientos_data as $mantenimiento_data)
			<tr class="@if($mantenimiento_data->deleted_at) bg-danger @endif">
				<td>
					<a href="{{URL::to('/plantillas_mant_preventivo/create_mantenimiento/')}}/{{$mantenimiento_data->idfamilia_activo}}">{{$mantenimiento_data->nombre_equipo}}</a>
				</td>
				<td>{{$mantenimiento_data->marca->nombre}}</td>
				<td>{{$mantenimiento_data->tipo->nombre}}</td>
				<td>{{$mantenimiento_data->estado->nombre}}</td>
			</tr>
			@endforeach
		</table>
	</div>
	<div class="col-md-12">
	@if($search_nombre || $search_marca!=0)
		{{ $mantenimientos_data->appends(array('search_nombre' => $search_nombre, 'search_marca'=> $search_marca))->links() }}
	@else
		{{ $mantenimientos_data->links() }}
	@endif
	</div>
@stop