@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Lista de Grupos de Activos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/grupos/search_grupo','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-inline')) }}
		<div class="search_bar">
			
			{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
		</div>	
	{{ Form::close() }}</br>
 
	<table class="table">
		<tr class="info">
			<th>N°</th>
			<th>Nombre del Grupo</th>
			<th>Usuario Responsable</th>
			<th>Fecha de Creación</th>
		</tr>
		@foreach($grupos_data as $index => $grupo_data)
		<tr class="@if($grupo_data->deleted_at) bg-danger @endif">			
			<td>
				{{$index+1}}
			</td>
			<td>
				<a href="{{URL::to('/grupos/edit_grupo/')}}/{{$grupo_data->idgrupo}}">
				{{$grupo_data->nombre}}
				</a>
			</td>
			<td>
				{{$grupo_data->nombre_resp}} {{$grupo_data->apellido_pat_responsable}}
			</td>
			<td>
				{{$grupo_data->created_at->format('d-m-Y')}}
			</td>
		</tr>
		@endforeach		
	</table>
	@if($search)
		{{ $grupos_data->appends(array('search' => $search))->links() }}
	@else	
		{{ $grupos_data->links()}}
	@endif
	
@stop