@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Área: <strong>{{$area_info->nombre}}</strong></h3>
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
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_area') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_area') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_area') }}</strong></p>
		</div>
	@endif

	
	{{ Form::hidden('area_id', $area_info->idarea) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
	  	<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-4 @if($errors->first('tipo_area')) has-error has-feedback @endif">
					{{ Form::label('tipo_area','Tipo de Área') }}
					@if($area_info->deleted_at)
						{{ Form::select('tipo_area',$tipo_areas,$area_info->idtipo_area,array('class'=>'form-control','disabled'=>'disabled')) }}
					@else
						{{ Form::select('tipo_area',$tipo_areas,$area_info->idtipo_area,array('class'=>'form-control','disabled'=>'disabled' )) }}
					@endif
				</div>												
				<div class="form-group col-md-4 @if($errors->first('nombre_area')) has-error has-feedback @endif">
					{{ Form::label('nombre_area','Nombre del Area') }}
					@if($area_info->deleted_at)
						{{ Form::text('nombre_area',$area_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('nombre_area',$area_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
					@endif
				</div>
			</div>	
			<div class="row">		
				<div class="form-group col-md-12 @if($errors->first('descripcion_area')) has-error has-feedback @endif">
				{{ Form::label('descripcion_area','Descripción (MAX:200 Caracteres)') }}
				@if($area_info->deleted_at)
					{{ Form::textarea('descripcion_area',$area_info->descripcion,array('class'=>'form-control','readonly'=>'','maxlength'=>'200','rows'=>'4','style'=>'resize:none','readonly'=>'')) }}
				@else
					{{ Form::textarea('descripcion_area',$area_info->descripcion,array('class'=>'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none','readonly'=>'')) }}
				@endif							
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
		<div class="col-md-2 col-md-offset-10 form-group">
			<a class="btn btn-default btn-block" href="{{URL::to('/areas/list_areas')}}">
			<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
		</div>		
	</div>
@stop