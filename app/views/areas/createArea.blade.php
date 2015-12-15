@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nueva Área</h3>
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
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre_area') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_area') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_area') }}</strong></p>
		</div>
	@endif

	{{ Form::open(array('url'=>'areas/submit_area', 'role'=>'form')) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('tipo_area')) has-error has-feedback @endif">
						{{ Form::label('tipo_area','Tipo de Área') }}<span style='color:red'>*</span>
						{{ Form::select('tipo_area',array(''=> 'Seleccione')+$tipo_areas, Input::old('idtipo_area'),array('class'=>'form-control'))}}
					</div>								
					<div class="form-group col-md-4 @if($errors->first('nombre_area')) has-error has-feedback @endif">
						{{ Form::label('nombre_area','Nombre del Área') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_area',Input::old('nombre_area'),['class' => 'form-control'])}}
					</div>					
				</div>
				<div class="row">						
					<div class="form-group col-md-12 @if($errors->first('descripcion_area')) has-error has-feedback @endif">
						{{ Form::label('descripcion_area','Descripción (MAX:200 Caracteres)') }}
						{{ Form::textarea('descripcion_area',Input::old('descripcion_area'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
					</div>
				</div>	
			</div>
		</div>
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/areas/list_areas')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}
@stop