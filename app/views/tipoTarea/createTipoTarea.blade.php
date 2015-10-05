@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Tipo de Tarea</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'tipoTarea/submit_create_tipoTarea', 'role'=>'form')) }}
		<div class="col-xs-6">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">
					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre de Tipo de Tarea') }}
							{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							{{ Form::text('descripcion',Input::old('descripcion'),array('class'=>'form-control')) }}
						</div>
					</div>	
				</div>
			</div>
		</div>			
		<div class="row">
			<div class="form-group col-xs-8">
				{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
			</div>
		</div>
	{{ Form::close() }}
@stop