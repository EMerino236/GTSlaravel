@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nueva Capacitación</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>			
		</div>
	@endif

	{{ Form::open(array('url'=>'#', 'role'=>'form')) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('nombre_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('nombre_capacitacion','Nombre de Capacitación') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_capacitacion',Input::old('nombre_capacitacion'),['class' => 'form-control'])}}						
					</div>								
					<div class="col-md-4 @if($errors->first('tipo_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('tipo_capacitacion','Tipo de Capacitación') }}<span style='color:red'>*</span>
						{{ Form::select('tipo_capacitacion',array(''=> 'Seleccione'), Input::old('tipo_capacitacion'),array('class'=>'form-control'))}}
					</div>
					<div class="col-md-4 @if($errors->first('modalidad_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('modalidad_capacitacion','Modalidad de Capacitación') }}<span style='color:red'>*</span>
						{{ Form::select('modalidad_capacitacion',array(''=> 'Seleccione'), Input::old('modalidad_capacitacion'),array('class'=>'form-control'))}}
					</div>
				</div>					
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('fecha_ini_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('fecha_ini_capacitacion','Fecha de Adquisición') }}<span style="color:red">*</span>
						<div id="datetimepicker1" class="form-group input-group date">
							{{ Form::text('fecha_ini_capacitacion',Input::old('fecha_ini_capacitacion'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="col-md-4 @if($errors->first('fecha_fin_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('fecha_fin_capacitacion','Fecha de Adquisición') }}<span style="color:red">*</span>
						<div id="datetimepicker2" class="form-group input-group date">
							{{ Form::text('fecha_fin_capacitacion',Input::old('fecha_fin_capacitacion'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('descripcion_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('descripcion_capacitacion','Descripción (MAX:200 Caracteres)') }}
						{{ Form::textarea('descripcion_capacitacion',Input::old('descripcion_capacitacion'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('nombre_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('nombre_capacitacion','Nombre de Capacitación') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_capacitacion',Input::old('nombre_capacitacion'),['class' => 'form-control'])}}						
					</div>
					<div class="col-md-4 @if($errors->first('nombre_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('nombre_capacitacion','Nombre de Capacitación') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_capacitacion',Input::old('nombre_capacitacion'),['class' => 'form-control'])}}						
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('nombre_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('nombre_capacitacion','Nombre de Capacitación') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_capacitacion',Input::old('nombre_capacitacion'),['class' => 'form-control'])}}						
					</div>
					<div class="col-md-4 @if($errors->first('nombre_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('nombre_capacitacion','Nombre de Capacitación') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_capacitacion',Input::old('nombre_capacitacion'),['class' => 'form-control'])}}						
					</div>
					<div class="col-md-4 @if($errors->first('nombre_capacitacion')) has-error has-feedback @endif">
						{{ Form::label('nombre_capacitacion','Nombre de Capacitación') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_capacitacion',Input::old('nombre_capacitacion'),['class' => 'form-control'])}}						
					</div>
				</div>	
			</div>
		</div>
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('#')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}
@stop