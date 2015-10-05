@extends('templates/otTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Orden de trabajo de mantenimiento correctivo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('fecha_programacion') }}</strong></p>
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
		<div class="col-xs-8">
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('sot','Número de SOT') }}
					{{ Form::text('sot',$sot_info->idsolicitud_orden_trabajo,array('class' => 'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('codigo_patrimonial','Código de activo') }}
					{{ Form::text('codigo_patrimonial',$sot_info->codigo_patrimonial,array('class' => 'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('mes','Programaciones pendientes en el mes') }}
					{{ Form::text('mes',$mes,array('class' => 'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8">
					{{ Form::label('trimestre','Programaciones pendientes en el trimestre') }}
					{{ Form::text('trimestre',$trimestre,array('class' => 'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				{{ Form::label('fecha_programacion','Ingrese fecha de programación') }}
				<div id="datetimepicker3" class="form-group input-group date col-xs-8 @if($errors->first('fecha_programacion')) has-error has-feedback @endif">
					{{ Form::text('fecha_programacion',null,array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
			{{ Form::submit('Programar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
		</div>
		<div class="col-xs-4">
			<h3 class="text-center">Programaciones del trimestre</h3>
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
	{{ Form::close() }}
@stop