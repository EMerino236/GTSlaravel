@extends('templates/bienesTemplate')
@section('content')
	
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Directorio de Equipos</h3>
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

    {{ Form::open(array('url'=>'/equipos/search_inventario','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_grupo','Grupo') }}
				{{ Form::select('search_grupo', array('' => 'Seleccione') + $grupos,$search_grupo,['class' => 'form-control']) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_servicio','Servicio Clínico') }}
				{{ Form::select('search_servicio', array('' => 'Seleccione') + $servicio,$search_servicio,['class' => 'form-control']) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_ubicacion','Ubicación') }}
				{{ Form::select('search_ubicacion', array('' => 'Seleccione') + $ubicacion,$search_ubicacion,['class' => 'form-control']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_nombre_equipo','Nombre de Equipo') }}				
				{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Nombre de Equipo')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_marca','Marca') }}
				{{ Form::select('search_marca', array('' => 'Seleccione') + $marca,$search_marca,['class' => 'form-control']) }}				
			</div>
			<div class="col-md-4">
				{{ Form::label('search_modelo','Modelo') }}				
				{{ Form::text('search_modelo',$search_modelo,array('class'=>'form-control','placeholder'=>'Modelo')) }}				
			</div>
		</div>

		<div class="form-group row">			
			<div class="col-md-4">
				{{ Form::label('search_proveedor','Proveedor') }}
				{{ Form::select('search_proveedor', array('' => 'Seleccione') + $proveedor,$search_proveedor,['class' => 'form-control']) }}								
			</div>
			<div class="col-md-4">
				{{ Form::label('search_codigo_patrimonial','Código Patrimonial') }}				
				{{ Form::text('search_codigo_patrimonial',$search_codigo_patrimonial,array('class'=>'form-control','placeholder'=>'Código Patrimonial')) }}
			</div>			
		</div>

		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" id="btnLimpiar_list_activos">Limpiar</div>				
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
						<th class="text-nowrap">Grupo</th>
						<th class="text-nowrap">Servicio Clinico</th>
						<th class="text-nowrap">Ubicación Física</th>												
						<th class="text-nowrap">Nombre de Equipo</th>
						<th class="text-nowrap">Marca</th>
						<th class="text-nowrap">Modelo</th>
						<th class="text-nowrap">Número de Serie</th>
						<th class="text-nowrap">Proveedor</th>
						<th class="text-nowrap">Código Patrimonial</th>
						<th class="text-nowrap">Año de Adquisición</th>
						<th class="text-nowrap">Garantía Restante</th>
						<th class="text-nowrap">Garantía Vigente</th>					
						<th class="text-nowrap">Estado</th>
					</tr>
					@foreach($activos_data as $index => $activo_data)					
					<tr class="@if($activo_data->deleted_at) bg-danger @endif">			
						<td class="text-nowrap">
							{{$index + 1}}
						</td>	
						<td class="text-nowrap text-center text-center">
							{{$activo_data->nombre_grupo}}
						</td>
						<td class="text-nowrap text-center">
							{{$activo_data->nombre_servicio}}
						</td>						
						<td class="text-nowrap text-center">
							{{$activo_data->nombre_ubicacion_fisica}}
						</td>
						<td class="text-nowrap text-center">
							{{$activo_data->nombre_equipo}}
						</td>
						<td class="text-nowrap text-center">
							{{$activo_data->nombre_marca}}
						</td>
						<td class="text-nowrap text-center">
							{{$activo_data->modelo}}
						</td>
						<td class="text-nowrap text-center">
							{{$activo_data->numero_serie}}
						</td>
						<td class="text-nowrap text-center">
							{{$activo_data->nombre_proveedor}}
						</td>
						<td class="text-nowrap text-center">
							<a href="{{URL::to('/equipos/view_inventario/')}}/{{$activo_data->idactivo}}">{{$activo_data->codigo_patrimonial}}</a>
						</td>
						<td class="text-nowrap text-center">
							{{$activo_data->anho_adquisicion}}
						</td>
						<td class="text-nowrap text-center">
							@if($activo_data->garantia->invert == 1)
								{{$activo_data->garantia->m}} Meses, {{$activo_data->garantia->d}} Días
							@else
								0 Meses, 0 Días
							@endif
						</td>
						<td class="text-nowrap text-center">
							@if($activo_data->garantia->invert == 0)
								NO
							@else
								SI
							@endif
						</td>						
						<td class="text-nowrap text-center">
							{{strtoupper($activo_data->estado)}}
						</td>
					</tr>
					@endforeach				
				</table>

			</div>
		</div>
	</div>	
@stop