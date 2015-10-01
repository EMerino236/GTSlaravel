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
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_servicio') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'servicios/submit_servicio', 'role'=>'form')) }}
		<div class="row">
			<div class="form-group col-xs-3 col-xs-offset-10">
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
			</div>
		</div>	
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre del Servicio') }}
							{{ Form::text('nombre',Input::old('nombre_servicio'),['class' => 'form-control'])}}
						</div>
						<div class="form-group col-xs-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							{{ Form::text('descripcion',Input::old('descripcion'),['class' => 'form-control'])}}
						</div>

						<div class="form-group col-xs-2 @if($errors->first('tipo_servicio')) has-error has-feedback @endif">
							{{ Form::label('tipo_servicio','Tipo de Servicio') }}
							{{ Form::select('tipo_servicio',$tipo_servicios, Input::old('idtipo_servicios'),array('class'=>'form-control'))}}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-3 col-xs-offset-1 @if($errors->first('area')) has-error has-feedback @endif">
							{{ Form::label('area','Area') }}
							{{ Form::select('area',$areas, Input::old('idarea'),array('class'=>'form-control',"onchange" => "fill_usuario_responsable_servicio()",'id'=>'area'))}}
						</div>
						<div class="form-group col-xs-4 @if($errors->first('personal')) has-error has-feedback @endif">
							{{ Form::label('personal','Usuario Responsable') }}
							{{ Form::select('personal',$personal, Input::old('id_usuario_responsable'),array('class'=>'form-control','id'=>'usuario'))}}
						</div>
					</div>
				</div>			
			</div>
		</div>
		{{ Form::close() }}
@stop