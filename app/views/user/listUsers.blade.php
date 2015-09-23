@extends('templates/userTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Usuarios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

		<table class="table table-hover">
			<tr class="info">
				<th>Usuario</th>
				<th>Nombres</th>
				<th>Apellido Paterno</th>
				<th>Apellido Materno</th>
				<th>Doc. de identidad</th>
				<th>Rol</th>
				<th>Área</th>
			</tr>
			@foreach($users_data as $user_data)
			<tr class="@if($user_data->deleted_at) bg-danger @endif">
				<td>
					@if($user_data->deleted_at)
						{{$user_data->username}}
					@else
						<a href="{{URL::to('/user/edit_user/')}}/{{$user_data->id}}">{{$user_data->username}}</a>
					@endif
				</td>
				<td>
					{{$user_data->nombre}}
				</td>
				<td>
					{{$user_data->apellido_pat}}
				</td>
				<td>
					{{$user_data->apellido_mat}}
				</td>
				<td>
					{{$user_data->numero_doc_identidad}}
				</td>
				<td>
					{{$user_data->nombre_rol}}
				</td>
				<td>
					{{$user_data->nombre_area}}
				</td>
			</tr>
			@endforeach
		</table>
@stop