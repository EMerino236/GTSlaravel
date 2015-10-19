@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Agregar Accesorio: <strong>{{$familia_activo_info->nombre_equipo}} - {{$modelo_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_modelo') }}</strong></p>			
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'', 'role'=>'form')) }}
	{{ Form::hidden('id_modelo', $modelo_info->idmodelo_equipo) }}
		<div class="panel panel-default">
		  	<div class="panel-heading">Nuevo Accesorio</div>
		  	<div class="panel-body">
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('nombre_accesorio')) has-error has-feedback @endif">
						{{ Form::label('nombre_accesorio','Nombre') }}
						{{ Form::text('nombre_accesorio',Input::old('nombre_accesorio'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('modelo_accesorio')) has-error has-feedback @endif">
						{{ Form::label('modelo_accesorio','Modelo') }}
						{{ Form::text('modelo_accesorio',Input::old('modelo_accesorio'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('costo_accesorio')) has-error has-feedback @endif">
						{{ Form::label('costo_accesorio','Costo') }}
						{{ Form::text('costo_accesorio',Input::old('costo_accesorio'),array('class'=>'form-control')) }}
					</div>
		  		</div>
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('numero_pieza')) has-error has-feedback @endif">
		  				{{ Form::label('numero_pieza','Numero de Pieza') }}
						{{ Form::text('numero_pieza',Input::old('numero_pieza'),array('class'=>'form-control')) }}
		  			</div>
		  		</div>
			</div>
		</div>			

		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/familia_activos/edit_familia_activo')}}/{{$familia_activo_info->idfamilia_activo}}">Cancelar</a>				
			</div>
		</div>
	{{ Form::close() }}

	<div class="table-responsive">
		<table class="table">
			<tr class="info">
				<th>Nº</th>
				<th>Numero de Pieza</th>
				<th>Nombre</th>
				<th>Modelo</th>				
				<th>Costo</th>
				<th>Eliminar</th>
			</tr>
		</table>
	</div>
@stop