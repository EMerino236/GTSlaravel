@extends('templates/userTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Usuarios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/user/search_user','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="search_bar">
			{{ Form::text('search',$search,array('class'=>'form-control','placeholder'=>'Ingrese Búsqueda')) }}
			{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
		</div>	
	{{ Form::close() }}</br>

	<table class="table">
		<tr class="info">
			<th>Usuario</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Doc. de identidad</th>
			<th>Rol</th>
			<th>Área</th>
		</tr>
		@foreach($users_data as $user_data)
		<tr class="@if($user_data->deleted_at) bg-danger @endif">
			<td>
				<a href="{{URL::to('/user/edit_user/')}}/{{$user_data->id}}">{{$user_data->username}}</a>
			</td>
			<td>
				{{$user_data->nombre}}
			</td>
			<td>
				{{$user_data->apellido_pat}} {{$user_data->apellido_mat}}
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
	@if($search)
		{{ $users_data->appends(array('search' => $search))->links() }}
	@else
		{{ $users_data->links() }}
	@endif
@stop