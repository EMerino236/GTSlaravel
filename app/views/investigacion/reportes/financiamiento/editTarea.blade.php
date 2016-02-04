@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte que certifica la problemática e identificación de financiamiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
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
	{{ Form::open(['route'=>['reporte_financiamiento.tarea.update',$tarea->id], 'role'=>'form']) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información de la tarea</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
							    <h3 class="panel-title">Cronograma</h3>
						  	</div>

						  	<div class="panel-body">

								<div class="form-group col-md-3 @if($errors->first('descripcion')) has-error has-feedback @endif">
									{{ Form::label('descripcion','Descripción') }}
									{{ Form::text('descripcion', $tarea->descripcion, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-3 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
									{{ Form::label('fecha_ini','Fecha Inicio') }}
									<div id="datetimepicker_cronograma_ini" class="form-group input-group date">
										{{ Form::text('fecha_ini',date("d-m-Y",strtotime($tarea->fecha_ini)),array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>

								<div class="form-group col-md-3 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
									{{ Form::label('fecha_fin','Fecha Fin') }}
									<div id="datetimepicker_cronograma_fin" class="form-group input-group date">
										{{ Form::text('fecha_fin',date("d-m-Y",strtotime($tarea->fecha_fin)),array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>

								<div class="form-group col-md-3 @if($errors->first('duracion')) has-error has-feedback @endif">
									{{ Form::label('duracion','Duración') }}
									{{ Form::number('duracion', $tarea->duracion, ['class'=>'form-control']) }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		

	{{ Form::close() }}

			<div class="form-group col-md-2 col-md-offset-8">
				<a class="btn-under" href="{{route('reporte_financiamiento.tarea.destroy',$tarea->id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Borrar', array('class' => 'btn btn-danger btn-block')) }}
				</a>
			</div>
		</div>
@stop