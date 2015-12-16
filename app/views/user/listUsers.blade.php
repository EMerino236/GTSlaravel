@extends('templates/userTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Usuarios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/user/search_user','method'=>'get' ,'role'=>'form', 'id'=>'search-form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4">
						{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
					</div>
				</div>			
			</div>
		</div>
	{{ Form::close() }}</br>

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Usuario</th>
						<th class="text-nowrap text-center">Nombres</th>
						<th class="text-nowrap text-center">Apellidos</th>
						<th class="text-nowrap text-center">Doc. de identidad</th>
						<th class="text-nowrap text-center">Rol</th>
						<th class="text-nowrap text-center">Área</th>
						<th class="text-nowrap text-center">Editar</th>
					</tr>
					@foreach($users_data as $user_data)
					<tr class="@if($user_data->deleted_at) bg-danger @endif">
						<td class="text-nowrap text-center">
							{{$user_data->username}}
						</td>
						<td class="text-nowrap text-center">
							{{$user_data->nombre}}
						</td>
						<td class="text-nowrap text-center">
							{{$user_data->apellido_pat}} {{$user_data->apellido_mat}}
						</td>
						<td class="text-nowrap text-center">
							{{$user_data->numero_doc_identidad}}
						</td>
						<td class="text-nowrap text-center">
							{{$user_data->nombre_rol}}
						</td>
						<td class="text-nowrap text-center">
							{{$user_data->nombre_area}}
						</td>
						<td class="text-nowrap">
							<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/user/edit_user/')}}/{{$user_data->id}}">
							<span class="glyphicon glyphicon-pencil"></span></a>
						</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
	
	@if($search)
		{{ $users_data->appends(array('search' => $search))->links() }}
	@else
		{{ $users_data->links() }}
	@endif
@stop