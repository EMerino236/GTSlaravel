@extends('templates/recursosHumanosTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Plan de aprendizaje</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('competencia_generada') }}</strong></p>
			<p><strong>{{ $errors->first('indicador') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>['rh_plan_aprendizaje.recurso.update',$recurso->id], 'role'=>'form','files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">recurso: {{$recurso->competencia_generada}}</h3>
			</div>

		  	<div class="panel-body">
				<div class="form-group col-md-4">
					{{ Form::label('competencia_generada','Competencia Generada') }}
					{{ Form::text('competencia_generada', $recurso->competencia_generada, ['class'=>'form-control']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('indicador','Indicador') }}
					{{ Form::text('indicador', $recurso->indicador, ['class'=>'form-control']) }}
				</div>

			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>

			<div class="form-group col-md-2">
				<a class="btn-under" href="{{route('rh_plan_aprendizaje.recurso.destroy',$recurso->id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Eliminar', array('class' => 'btn btn-danger btn-block')) }}
				</a>
			</div>

			<div class="form-group col-md-2 col-md-offset-6">
				<a class="btn-under" href="{{route('rh_plan_aprendizaje.edit',$recurso->id_plan)}}">
					{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
				</a>
			</div>

		</div>

	{{ Form::close() }}

@stop