@extends('templates/otMantenimientoCorrectivoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programar mantenimiento correctivo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('fecha_programacion') }}</strong></p>
			<p><strong>{{ $errors->first('numero_ficha') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'mant_correctivo/submit_programacion', 'role'=>'form')) }}
		{{ Form::hidden('idactivo', $sot_info->idactivo) }}
		{{ Form::hidden('sot_id', $sot_info->idsolicitud_orden_trabajo) }}
		<div class="row">
			<div class="form-group col-md-4">
				{{ Form::label('sot','Número de SOT') }}
				{{ Form::text('sot',$sot_info->idsolicitud_orden_trabajo,array('class' => 'form-control','readonly'=>'')) }}
			</div>
			<div class="form-group col-md-4">
				{{ Form::label('codigo_patrimonial','Código patrimonial del activo') }}
				{{ Form::text('codigo_patrimonial',$sot_info->codigo_patrimonial,array('class' => 'form-control','readonly'=>'')) }}
			</div>
			<div class="form-group col-md-4">
				{{ Form::label('solicitante','Usuario solicitante') }}
				<select name="solicitante" class="form-control">
					@foreach($solicitantes as $solicitante)
						<option value="{{ $solicitante->id }}">{{ $solicitante->apellido_pat }} {{ $solicitante->apellido_mat }}, {{ $solicitante->nombre }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-4">
				{{ Form::label('mes','Programaciones pendientes en el mes') }}
				{{ Form::text('mes',$mes,array('class' => 'form-control','readonly'=>'')) }}
			</div>
			<div class="form-group col-md-4">
				{{ Form::label('trimestre','Programaciones pendientes en el trimestre') }}
				{{ Form::text('trimestre',$trimestre,array('class' => 'form-control','readonly'=>'')) }}
			</div>
			<div class="form-group col-md-4">
				{{ Form::label('fecha_programacion','Ingrese fecha de programación') }}
				<div id="datetimepicker3" class="form-group input-group date @if($errors->first('fecha_programacion')) has-error has-feedback @endif">
					{{ Form::text('fecha_programacion',null,array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-4">
				{{ Form::label('numero_ficha','Número de ficha') }}
				{{ Form::text('numero_ficha',Input::old('idprioridad'),array('class' => 'form-control')) }}
			</div>
			<div class="form-group col-md-4">
				{{ Form::label('idprioridad','Prioridad') }}
				{{ Form::select('idprioridad', $prioridades,Input::old('idprioridad'),['class' => 'form-control']) }}			
			</div>
			<div class="form-group col-md-4">
				{{ Form::label('idtipo_falla','Tipo de falla') }}
				{{ Form::select('idtipo_falla', $tipo_fallas,Input::old('idtipo_falla'),['class' => 'form-control']) }}			
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-12">
				{{ Form::submit('Programar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h3 class="text-center">Programaciones del mes</h3>
				<!-- Responsive calendar - START -->
				<div class="responsive-calendar">
				  <div class="controls">
				      <a class="pull-left" data-go="prev"><div class="btn"><i class="glyphicon glyphicon-chevron-left"></i></div></a>
				      <h4><span data-head-year></span> <span data-head-month></span></h4>
				      <a class="pull-right" data-go="next"><div class="btn"><i class="glyphicon glyphicon-chevron-right"></i></div></a>
				  </div><hr/>
				  <div class="day-headers">
				    <div class="day header">Lun</div>
				    <div class="day header">Mar</div>
				    <div class="day header">Mie</div>
				    <div class="day header">Jue</div>
				    <div class="day header">Vie</div>
				    <div class="day header">Sab</div>
				    <div class="day header">Dom</div>
				  </div>
				  <div class="days" data-group="days">
				    <!-- the place where days will be generated -->
				  </div>
				</div>
				<!-- Responsive calendar - END -->
			</div>
		</div>
	{{ Form::close() }}
@stop