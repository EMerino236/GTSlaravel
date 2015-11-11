@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Directorio de Proveedores</h3>            
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

    {{ Form::open(array('url'=>'/proveedores/search_proveedor','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
				<div class="form-group row">
					<div class="col-md-4">
						{{ Form::label('search_proveedor_ruc','RUC') }}				
						{{ Form::text('search_proveedor_ruc',$search_proveedor_ruc,array('class'=>'form-control','placeholder'=>'Número de RUC')) }}
					</div>
					<div class="col-md-4">
						{{ Form::label('search_proveedor_razon_social','Razón Social') }}				
						{{ Form::text('search_proveedor_razon_social',$search_proveedor_razon_social,array('class'=>'form-control','placeholder'=>'Número de RUC')) }}
					</div>
					<div class="col-md-2">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => 'margin-top:25px')) }}				
					</div>
					<div class="col-md-2">
						<div class="btn btn-default btn-block" id="btnLimpiar_list_activos" style="margin-top:25px">Limpiar</div>				
					</div>

				</div>	
			</div>
		</div>
	{{ Form::close() }}
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/proveedores/create_proveedor')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>

	<table class="table">
		<tr class="info">
			<th>Nº</th>
			<th>RUC</th>
			<th>Razón Social</th>
			<th>Nombre Contacto</th>
			<th>Teléfono</th>
			<th>Email</th>
			<th>Editar</th>		
		</tr>
		@foreach($proveedores_data as $index => $proveedor_data)
		<tr class="@if($proveedor_data->deleted_at) bg-danger @endif">
			<td>
				{{$index + 1}}
			</td>
			<td>
				<a href="">{{$proveedor_data->ruc}}</a>
			</td>
			<td>
				{{$proveedor_data->razon_social}}
			</td>
			<td>
				{{$proveedor_data->nombre_contacto}}
			</td>
			<td>
				{{$proveedor_data->telefono}}
			</td>
			<td>
				{{$proveedor_data->email}}
			</td>
			<td>
				<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/proveedores/edit_proveedor/')}}/{{$proveedor_data->idproveedor}}">
				<span class="glyphicon glyphicon-pencil"></span> Editar</a>
			</td>
		</tr>
		@endforeach
	</table>
	@if($search_proveedor_ruc)
		{{ $proveedores_data->appends(array('search_proveedor_ruc' => $search_proveedor_ruc))->links() }}
	@else
		{{ $proveedores_data->links() }}
	@endif
@stop