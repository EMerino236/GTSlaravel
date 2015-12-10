@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Servicios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/servicios/search_servicio','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>
	 	<div class="panel-body">
		 	<div class="row">
				<div class="col-md-4 form-group">
					{{ Form::label('nombre','Nombre de Servicio:')}}
					{{ Form::text('search',Input::old('search'),['class' => 'form-control','placeholder'=>'Ingrese búsqueda']) }}
				</div>
				<div class="col-md-2 form-group" style="margin-top:25px">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar',array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/servicios/create_servicio')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
 
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th>N°</th>
						<th>Nombre del Servicio</th>
						<th>Tipo de Servicio</th>
						<th>Fecha de Creación</th>
						<th>Editar</th>
					</tr>
					@foreach($servicios_data as $index => $servicio_data)
					<tr class="@if($servicio_data->deleted_at) bg-danger @endif">			
						<td>
							{{$index+1}}
						</td>
						<td>
							{{$servicio_data->nombre}}
						</td>
						<td>
							{{$servicio_data->nombre_tipo_servicio}}
						</td>
						<td>
							{{$servicio_data->created_at->format('d-m-Y')}}
						</td>
						<td>
							<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/servicios/edit_servicio/')}}/{{$servicio_data->idservicio}}">
							<span class="glyphicon glyphicon-pencil"></span> Editar</a>
						</td>
					</tr>
					@endforeach	
				</table>
			</div>
		</div>
	</div>

	
	@if($search)
		{{ $servicios_data->appends(array('search' => $search))->links() }}
	@else	
		{{ $servicios_data->links()}}
	@endif
	
@stop