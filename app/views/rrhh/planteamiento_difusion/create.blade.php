@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Planteamiento de Difusión</h3>
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
					<div class="col-md-4 @if($errors->first('nombre_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('nombre_planteamiento_difusion','Nombre') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_planteamiento_difusion',Input::old('nombre_planteamiento_difusion'),['class' => 'form-control'])}}						
					</div>					
				</div>					
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('descripcion_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('descripcion_planteamiento_difusion','Descripción (MAX:200 Caracteres)') }}
						{{ Form::textarea('descripcion_planteamiento_difusion',Input::old('descripcion_planteamiento_difusion'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('departamento_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('departamento_planteamiento_difusion','Departamento') }}<span style='color:red'>*</span>
						{{ Form::text('departamento_planteamiento_difusion',Input::old('departamento_planteamiento_difusion'),['class' => 'form-control'])}}						
					</div>
					<div class="col-md-4 @if($errors->first('servicio_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('servicio_planteamiento_difusion','Servicio') }}<span style='color:red'>*</span>
						{{ Form::text('servicio_planteamiento_difusion',Input::old('servicio_planteamiento_difusion'),['class' => 'form-control'])}}						
					</div>
					<div class="col-md-4 @if($errors->first('responsable_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('responsable_planteamiento_difusion','Responsable') }}<span style='color:red'>*</span>
						{{ Form::text('responsable_planteamiento_difusion',Input::old('responsable_planteamiento_difusion'),['class' => 'form-control'])}}						
					</div>
				</div>			
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('fecha_ini_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('fecha_ini_planteamiento_difusion','Fecha Inicio') }}<span style="color:red">*</span>
						<div id="datetimepicker1" class="form-group input-group date">
							{{ Form::text('fecha_ini_planteamiento_difusion',Input::old('fecha_ini_planteamiento_difusion'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="col-md-4 @if($errors->first('fecha_fin_planteamiento_difusion')) has-error has-feedback @endif">
						{{ Form::label('fecha_fin_planteamiento_difusion','Fecha Fin') }}<span style="color:red">*</span>
						<div id="datetimepicker2" class="form-group input-group date">
							{{ Form::text('fecha_fin_planteamiento_difusion',Input::old('fecha_fin_planteamiento_difusion'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
		</div>
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block','style' => '145px')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" style="width:145x" href="{{route('planteamiento_difusion.index')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}
@stop