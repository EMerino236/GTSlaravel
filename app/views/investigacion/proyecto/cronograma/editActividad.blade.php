@extends('templates/investigacionTemplate')
@section('content')	

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar actividad: {{$actividad->nombre}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			<p><strong>{{ $errors->first('actividad') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('actividad_previa') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_ini') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_fin') }}</strong></p>
			<p><strong>{{ $errors->first('duracion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>['proyecto_cronograma.actividad.update',$actividad->id], 'role'=>'form')) }}

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Informacion general del proyecto</h3>
		</div>
	
	  	<div class="panel-body">
	  		<div class="row">
				<div class="form-group col-md-4 @if($errors->first('actividad')) has-error has-feedback @endif">
					{{ Form::label('actividad','Actividad') }}
					{{ Form::text('actividad', $actividad->nombre, ['class'=>'form-control']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::text('descripcion', $actividad->descripcion, ['class'=>'form-control']) }}
				</div>


				<div class="form-group col-md-4 @if($errors->first('actividad_previa')) has-error has-feedback @endif">
					{{ Form::label('actividad_previa','Actividad Previa') }}
					{{ Form::select('actividad_previa', [0=>'No posee actividad previa']+$actividades, $actividad->id_actividad_previa, ['id'=>'actividad_previa','class'=>'form-control']) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-4 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
					{{ Form::label('fecha_ini','Fecha Inicio') }}
					<div id="datetimepicker_crono_act_ini" class="form-group input-group date">
						{{ Form::text('fecha_ini', date('d-m-Y',strtotime($actividad->fecha_ini)),array('class'=>'form-control', 'readonly'=>'','onChange'=>'calcula_duracion()')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
					<script type="text/javascript">proy_ini = new Date("{{$cronograma->proyecto->fecha_ini}}")</script>
				</div>

				<div class="form-group col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
					{{ Form::label('fecha_fin','Fecha Fin') }}
					<div id="datetimepicker_crono_act_fin" class="form-group input-group date">
						{{ Form::text('fecha_fin', date('d-m-Y',strtotime($actividad->fecha_fin)),array('class'=>'form-control', 'readonly'=>'','onChange'=>'calcula_duracion()')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
					<script type="text/javascript">proy_fin = new Date("{{$cronograma->proyecto->fecha_fin}}")</script>
				</div>

				<div class="form-group col-md-4 @if($errors->first('duracion')) has-error has-feedback @endif">
					{{ Form::label('duracion','Duración') }}
					{{ Form::text('duracion', $actividad->duracion, ['class'=>'form-control','readonly']) }}
				</div>
			</div>
		</div>
		
	</div>

	<div class="row">
		<div class="form-group col-md-2">
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
		</div>

		<div class="form-group col-md-2">
			<a class="btn-under" href="{{route('proyecto_cronograma.actividad.destroy',$actividad->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Eliminar', array('class' => 'btn btn-danger btn-block')) }}
			</a>
		</div>

		<div class="form-group col-md-offset-6 col-md-2">
			<a class="btn-under" href="{{route('proyecto_cronograma.show',$cronograma->id_proyecto)}}">
				{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
			</a>
		</div>
	</div>

	{{Form::close()}}
@stop
