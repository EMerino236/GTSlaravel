@extends('templates/investigacionTemplate')
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
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('servicio') }}</strong></p>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('duracion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>['plan_aprendizaje.actividad.update',$actividad->id], 'role'=>'form','files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Actividad: {{$actividad->nombre}}</h3>
			</div>

		  	<div class="panel-body">
				<div class="form-group col-md-4">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre', $actividad->nombre, ['class'=>'form-control']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::text('descripcion', $actividad->descripcion, ['class'=>'form-control']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('servicio','Servicios Involucrados') }}
					{{ Form::text('servicio', $actividad->servicio, ['class'=>'form-control']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('fecha')) has-error has-feedback @endif">
					{{ Form::label('fecha','Fecha') }}
					<div id="datetimepicker_plan" class="form-group input-group date">
						{{ Form::text('fecha',date('d-m-Y',strtotime($actividad->fecha)),array('class'=>'form-control', 'readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('duracion','Duración') }}
					{{ Form::number('duracion', $actividad->duracion, ['class'=>'form-control','min'=>0]) }}
				</div>

			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>

			<div class="form-group col-md-2">
				<a class="btn-under" href="{{route('plan_aprendizaje.actividad.destroy',$actividad->id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Eliminar', array('class' => 'btn btn-danger btn-block')) }}
				</a>
			</div>

			<div class="form-group col-md-2 col-md-offset-6">
				<a class="btn-under" href="{{route('plan_aprendizaje.edit',$actividad->id_plan)}}">
					{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
				</a>
			</div>

		</div>

	{{ Form::close() }}

@stop