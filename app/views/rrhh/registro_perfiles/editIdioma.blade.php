@extends('templates/recursosHumanosTemplate')
@section('content')	

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Idioma: {{$idioma->nombre->nombre}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach	
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>['registro_perfil.idioma.update',$idioma->id], 'role'=>'form')) }}

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Informacion general</h3>
		</div>
	
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombres_idioma')) has-error has-feedback @endif">
					{{ Form::label('nombre_idioma','Idioma') }}
					{{ Form::select('nombre_idioma',$idiomas,$idioma->id_nombre,['id'=>'nombre_idioma','class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('nombres_idioma')) has-error has-feedback @endif">
					{{ Form::label('lectura','Lectura') }}
					{{ Form::select('lectura',$niveles_idioma,$idioma->id_lectura,['id'=>'lectura','class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('nombres_idioma')) has-error has-feedback @endif">
					{{ Form::label('conversacion','Conversacion') }}
					{{ Form::select('conversacion',$niveles_idioma,$idioma->id_conversacion,['id'=>'conversacion','class' => 'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombres_idioma')) has-error has-feedback @endif">
					{{ Form::label('escritura','Escritura') }}
					{{ Form::select('escritura',$niveles_idioma,$idioma->id_escritura,['id'=>'escritura','class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('nombres_idioma')) has-error has-feedback @endif">
					{{ Form::label('forma_aprendizaje','Forma de aprendizaje') }}
					{{ Form::select('forma_aprendizaje',$formas_idioma,$idioma->id_forma,['id'=>'forma_aprendizaje','class' => 'form-control'])}}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
		</div>

		<div class="form-group col-md-2">
			<a class="btn-under" href="{{route('registro_perfil.idioma.destroy',$idioma->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Eliminar', array('class' => 'btn btn-danger btn-block')) }}
			</a>
		</div>

		<div class="form-group col-md-offset-6 col-md-2">
			<a class="btn-under" href="{{route('registro_perfil.edit',$idioma->id_perfil)}}">
				{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
			</a>
		</div>
	</div>

	{{Form::close()}}
@stop
