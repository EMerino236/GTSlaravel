@extends('templates/bienesIRETemplate')
@section('content')
	
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Indice de Riesgo por Equipo</h3>
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

    {{ Form::open(array('url'=>'/estado_ts/search_ire','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_departamento','Departamento') }}
				{{ Form::select('search_departamento', array('' => 'Seleccione') + $departamentos,$search_departamento,['class' => 'form-control']) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_servicio','Servicio Clínico') }}
				{{ Form::select('search_servicio', array('' => 'Seleccione') + $servicios,$search_servicio,['class' => 'form-control']) }}
			</div>			
		</div>

		<div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('row_number','Registros por Página') }}
				{{ Form::select('row_number', array('10' => '10 Registros','30' => '30 Registros','60' => '60 Registros','120' => '120 Registros'),$row_number,['class' => 'form-control']) }}								
			</div>
		</div>	

		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar_list_ire">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	
	{{ Form::close() }}	

    <div class="row">
    	<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap">Nº</th>
						<th class="text-nowrap">Servicio Clinico</th>						
						<th class="text-nowrap">Departamento</th>
						<!-- <th class="text-nowrap">Fecha de Edición</th> -->
						<th class="text-nowrap text-center"></th>
					</tr>
					@foreach($servicios_data as $index => $servicio_data)					
					<tr class="@if($servicio_data->deleted_at) bg-danger @endif">			
						<td class="text-nowrap">
							{{$index + 1}}
						</td>	
						<td class="text-nowrap">
							{{$servicio_data->nombre}}
						</td>
						<td class="text-nowrap">
							{{$servicio_data->nombre_area}}
						</td>						
						<!-- <td class="text-nowrap"> -->
							<!-- FECHA -->
						<!-- </td>						 -->
						@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
							<td>
								<a class="btn btn-info btn-block btn-sm" href="{{URL::to('/estado_ts/view_ire_servicio/')}}/{{$servicio_data->idservicio}}">
								<span class="glyphicon glyphicon-eye-open"></span> Visualizar</a>
							</td>
						@endif
					</tr>
					@endforeach				
				</table>
				@if($search_departamento || $search_servicio || $row_number)

					{{ $servicios_data->appends(array('search_departamento' => $search_departamento,'search_servicio' => $search_servicio, 'row_number' => $row_number))->links() }}
				@else	
					{{ $servicios_data->links()}}
				@endif
			</div>
		</div>
	</div>	
@stop