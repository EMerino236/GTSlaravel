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
						{{ Form::label('search_username','Nombre de Usuario')}}
						{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda','id'=>'search')) }}
					</div>
					<div class="col-md-4">
						{{ Form::label('search_area','Area')}}
						{{ Form::select('search_area',array('0'=>'Seleccione')+$areas,$search_area,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block','style'=>'margin-top:25px;')) }}	
					</div>
					<div class="col-md-2">
						<div class="btn btn-default btn-block" id="btnLimpiar" style='margin-top:25px;'><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
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
							<a href="{{URL::to('/user/view_user/')}}/{{$user_data->id}}">{{$user_data->username}}</a>
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
	
	@if($search || $search_area)
		{{ $users_data->appends(array('search' => $search,'search_area'=>$search_area))->links() }}
	@else
		{{ $users_data->links() }}
	@endif
@stop