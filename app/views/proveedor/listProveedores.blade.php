@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Directorio de Proveedores</h3>
            <p class="text-right">{{ HTML::link('/proveedores/create_proveedor','+ Agregar proveedor',array('class'=>'')) }}</p>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/proveedores/search_proveedor','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
				{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
			</div>	
			</div>
		</div>
	{{ Form::close() }}</br>

	<table class="table">
		<tr class="info">
			<th>RUC</th>
			<th>Raz. Social</th>
			<th>Teléfono</th>
			<th>Email</th>
			<th>Estado</th>
		</tr>
		@foreach($proveedores_data as $proveedor_data)
		<tr class="@if($proveedor_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/proveedores/edit_proveedor/')}}/{{$proveedor_data->idproveedor}}">{{$proveedor_data->ruc}}</a>
			</td>
			<td>
				{{$proveedor_data->razon_social}}
			</td>
			<td>
				{{$proveedor_data->telefono}}
			</td>
			<td>
				{{$proveedor_data->email}}
			</td>
			<td>
				{{$proveedor_data->nombre_estado}}
			</td>
		</tr>
		@endforeach
	</table>
	@if($search)
		{{ $proveedores_data->appends(array('search' => $search))->links() }}
	@else
		{{ $proveedores_data->links() }}
	@endif
@stop