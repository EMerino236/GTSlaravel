@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Área: <strong>{{$area_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_area') }}</strong></p>
			<p><strong>{{ $errors->first('centro_costo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'areas/submit_edit_area', 'role'=>'form')) }}
	{{ Form::hidden('area_id', $area_info->idarea) }}
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-xs-3 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre del Area') }}
							@if($area_info->deleted_at)
								{{ Form::text('nombre',$area_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('nombre',$area_info->nombre,array('class'=>'form-control')) }}
							@endif
						</div>
						<div class="form-group col-xs-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							@if($area_info->deleted_at)
								{{ Form::text('descripcion',$area_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('descripcion',$area_info->descripcion,array('class'=>'form-control')) }}
							@endif							
						</div>
					
						<div class="form-group col-xs-2 @if($errors->first('tipo_area')) has-error has-feedback @endif">
							{{ Form::label('tipo_area','Tipo de Área') }}
							@if($area_info->deleted_at)
								{{ Form::select('tipo_area',$tipo_areas,$area_info->idtipo_area,array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
							@else
								{{ Form::select('tipo_area',$tipo_areas,$area_info->idtipo_area,array('class'=>'form-control' ,'disabled'=>'disabled')) }}
							@endif
						</div>
						<div class="form-group col-xs-3 @if($errors->first('centro_costo')) has-error has-feedback @endif">
							{{ Form::label('centro_costo','Centro de Costo') }}
							@if($area_info->deleted_at)
								{{ Form::select('centro_costo',$centro_costos, Input::old('idcentro_costo'),array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
							@else
								{{ Form::select('centro_costo',$centro_costos, Input::old('idcentro_costo'),array('class'=>'form-control','disabled'=>'disabled'))}}
							@endif	
						</div>
					
					</div>
				</div>			
			</div>
		</div>
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Personal</div>
			  	<div class="panel-body">
			  		<table id="table" class="table">
			  			<tr>
			  				<th>Número de Identidad</th>
			  				<th>Nombre del Personal</th>
			  				<th>Rol</th>
			  			</tr>
			  			@foreach($personal as $persona)
			  			<tr>
			  				<td>
			  					{{$persona->numero_doc_identidad}}
			  				</td>
			  				<td>
			  					{{$persona->nombre}} {{$persona->apellido_pat}} {{$persona->apellido_mat}}
			  				</td>
			  				<td>
			  					{{$persona->nombre_rol}}
			  				</td>
			  			</tr>
			  			@endforeach	
			  		</table>
			  	</div>
			 </div>
		</div>
	{{ Form::close() }}
		@if($area_info->deleted_at)
		{{ Form::open(array('url'=>'areas/submit_enable_area', 'role'=>'form')) }}
			{{ Form::hidden('area_id', $area_info->idarea) }}
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-3">
						{{ Form::submit('Guardar',array('idarea'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
					</div>
					<div class="form-group col-xs-8">
						{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
					</div>
				</div>	
			</div>	
		{{ Form::close() }}
		@else
		{{ Form::open(array('url'=>'areas/submit_disable_area', 'role'=>'form')) }}
			{{ Form::hidden('area_id', $area_info->idarea) }}
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-3">
						{{ Form::submit('Guardar',array('idarea'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
					</div>
					<div class="form-group col-xs-8">
						{{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
					</div>
				</div>	
			</div>	
		{{ Form::close() }}
		@endif
@stop