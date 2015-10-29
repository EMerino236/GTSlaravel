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
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Datos Generales</div>
				  	<div class="panel-body">	
						<div class="row">								
							<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
								{{ Form::label('nombre','Nombre del Area') }}
								@if($area_info->deleted_at)
									{{ Form::text('nombre',$area_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::text('nombre',$area_info->nombre,array('class'=>'form-control')) }}
								@endif
							</div>
							<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
								{{ Form::label('descripcion','Descripción') }}
								@if($area_info->deleted_at)
									{{ Form::text('descripcion',$area_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::text('descripcion',$area_info->descripcion,array('class'=>'form-control')) }}
								@endif							
							</div>
						
							<div class="form-group col-md-4 @if($errors->first('tipo_area')) has-error has-feedback @endif">
								{{ Form::label('tipo_area','Tipo de Área') }}
								@if($area_info->deleted_at)
									{{ Form::select('tipo_area',$tipo_areas,$area_info->idtipo_area,array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
								@else
									{{ Form::select('tipo_area',$tipo_areas,$area_info->idtipo_area,array('class'=>'form-control' )) }}
								@endif
							</div>			
						</div>
					</div>
				</div>			
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
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
		</div>
		<div class="container-fluid row">
			@if(!$area_info->deleted_at)
				<div class="col-md-2 form-group">				
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
				</div>
			@endif
			<div class="col-md-2 form-group">
				<a class="btn btn-default btn-block" href="{{URL::to('/areas/list_areas')}}">Cancelar</a>
			</div>
		{{ Form::close() }}
		@if($area_info->deleted_at)
		{{ Form::open(array('url'=>'areas/submit_enable_area', 'role'=>'form')) }}
			{{ Form::hidden('area_id', $area_info->idarea) }}
				<div class="form-group col-md-2 col-md-offset-8">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar', array('id'=>'submit-delete', 'type' => 'submit', 'class' => 'btn btn-success btn-block')) }}
				</div>					
		{{ Form::close() }}
		@else
		{{ Form::open(array('url'=>'areas/submit_disable_area', 'role'=>'form')) }}
			{{ Form::hidden('area_id', $area_info->idarea) }}
				<div class="form-group col-md-2 col-md-offset-6">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar', array('id'=>'submit-delete', 'type' => 'submit', 'class' => 'btn btn-danger btn-block')) }}
				</div>
		{{ Form::close() }}
		@endif
		</div>
@stop