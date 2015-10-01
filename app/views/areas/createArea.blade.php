@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nueva Área</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_area') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_area') }}</strong></p>
			<p><strong>{{ $errors->first('id_estado') }}</strong></p>
			<p><strong>{{ $errors->first('idcentro_costo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'areas/submitArea', 'role'=>'form')) }}
		<div class="row">
			<div class="form-group col-xs-3 col-xs-offset-10">
				{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
			</div>
		</div>	
		<div class="row">
			<div class="panel panel-default">
		  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="row">								
					<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('area')) has-error has-feedback @endif">
						{{ Form::label('nombre_area','Nombre del Area') }}
						{{ Form::text('nombre_area',Input::old('nombre_area'),['class' => 'form-control'])}}
					</div>
					<div class="form-group col-xs-4">
						{{ Form::label('descripcion','Descripción') }}
						{{ Form::text('descripcion',Input::old('descripcion'),['class' => 'form-control'])}}
					</div>
					<div class="form-group col-xs-4">
						{{ Form::label('tipo_area','Tipo de Área') }}
						{{ Form::select('tipo_area',$tipo_areas, Input::old('idtipo_area'),array('class'=>'form-control'))}}
					</div>				
				</div>
				
				
			</div>
			
			</div>
		</div>
@stop