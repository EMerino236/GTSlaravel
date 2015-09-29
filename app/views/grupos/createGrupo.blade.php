@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Grupo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('usuario_responsable') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'grupos/submit_grupo', 'role'=>'form')) }}
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
							{{ Form::label('nombre','Nombre del Grupo') }}
							{{ Form::text('nombre',Input::old('nombre'),['class' => 'form-control'])}}
						</div>
						<div class="form-group col-xs-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							{{ Form::text('descripcion',Input::old('descripcion'),['class' => 'form-control'])}}
						</div>
						<div class="form-group col-xs-2 @if($errors->first('usuario_responsable')) has-error has-feedback @endif">
							{{ Form::label('usuario_responsable','Usuario Responsable') }}
							{{ Form::select('usuario_responsable',$usuario_responsable, Input::old('id_responsable'),array('class'=>'form-control'))}}
						</div>
					</div>
					
				</div>			
			</div>
		</div>
		{{ Form::close() }}
@stop