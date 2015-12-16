@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Servicio</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_servicio') }}</strong></p>
			<p><strong>{{ $errors->first('area') }}</strong></p>
			<p><strong>{{ $errors->first('personal') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	{{ Form::open(array('url'=>'servicios/submit_servicio', 'role'=>'form')) }}	
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Datos Generales</div>
				  	<div class="panel-body">	
						<div class="row">								
							<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
								{{ Form::label('nombre','Nombre del Servicio') }}
								{{ Form::text('nombre',Input::old('nombre_servicio'),['class' => 'form-control','maxlength'=>'100'])}}
							</div>
							<div class="form-group col-md-4 @if($errors->first('tipo_servicio')) has-error has-feedback @endif">
								{{ Form::label('tipo_servicio','Tipo de Servicio') }}
								{{ Form::select('tipo_servicio',array(''=> 'Seleccione')+$tipo_servicios, Input::old('tipo_servicio'),array('class'=>'form-control'))}}
							</div>						
							<div class="form-group col-md-4 @if($errors->first('area')) has-error has-feedback @endif">
								{{ Form::label('area','Area') }}
								{{ Form::select('area',array(''=> 'Seleccione')+$areas, Input::old('area'),array('class'=>'form-control',"onchange" => "fill_usuario_responsable_servicio()",'id'=>'area'))}}
							</div>
							<div class="form-group col-md-4 @if($errors->first('personal')) has-error has-feedback @endif">
								{{ Form::label('personal','Usuario Responsable') }}
								{{ Form::select('personal',$personal, Input::old('personal'),array('class'=>'form-control','id'=>'usuario'))}}
							</div>							
						</div>
						<div class="row">
							<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
								{{ Form::label('descripcion','Descripción (MAX:200 Caracteres)') }}
								{{ Form::textarea('descripcion',Input::old('descripcion'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
							</div>		
						</div>
					</div>			
				</div>
			</div>
		</div>
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/servicios/list_servicios')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}
@stop