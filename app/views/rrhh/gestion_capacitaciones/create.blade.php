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
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach		
		</div>
	@endif

	{{ Form::open(array('route'=>'capacitacion.store', 'role'=>'form')) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos Generales
	  	</div>

	  	<div class="panel-body">	
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombre_capacitacion')) has-error has-feedback @endif">
					{{ Form::label('nombre_capacitacion','Nombre de Capacitación') }}<span style='color:red'>*</span>
					{{ Form::text('nombre_capacitacion',Input::old('nombre_capacitacion'),['class' => 'form-control'])}}						
				</div>								
				<div class="col-md-4 @if($errors->first('tipo_capacitacion')) has-error has-feedback @endif">
					{{ Form::label('tipo_capacitacion','Tipo de Capacitación') }}<span style='color:red'>*</span>
					{{ Form::select('tipo_capacitacion',$tipos, Input::old('tipo_capacitacion'),array('class'=>'form-control','onChange'=>'habilitaCampos(this)'))}}
				</div>
				<div class="col-md-4 @if($errors->first('modalidad_capacitacion')) has-error has-feedback @endif">
					{{ Form::label('modalidad_capacitacion','Modalidad de Capacitación') }}<span style='color:red'>*</span>
					{{ Form::select('modalidad_capacitacion',$modalidades, Input::old('modalidad_capacitacion'),array('class'=>'form-control'))}}
				</div>
			</div>	

			<div class="form-group row">
				<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripción (MAX: 200 Caracteres)') }}
					{{ Form::textarea('descripcion',Input::old('descripcion'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
				</div>
			</div>			

			<div class="form-group row" id="collapseCampos">
				<div class="form-group col-md-6 @if($errors->first('codigo_patrimonial')) has-error has-feedback @endif">
					{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
					{{ Form::text('codigo_patrimonial', Input::old('codigo_patrimonial'), ['class'=>'form-control']) }}
				</div>

				<div class="form-group col-md-6 @if($errors->first('equipo_relacionado')) has-error has-feedback @endif">
					{{ Form::label('equipo_relacionado','Equipo Relacionado') }}
					{{ Form::text('equipo_relacionado', Input::old('equipo_relacionado'), ['class'=>'form-control']) }}
				</div>	
			</div>

			<div class="form-group row">
				<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::select('departamento', $departamentos, Input::old('departamento'), ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::select('servicio_clinico', $servicios, Input::old('servicio_clinico'), ['id'=>'servicio_clinico','class'=>'form-control']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
					{{ Form::label('responsable','Responsable') }}
					{{ Form::select('responsable',$usuarios, Input::old('responsable'),['class'=>'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
					{{ Form::label('fecha_ini_capacitacion','Fecha de Inicio') }}<span style="color:red">*</span>
					<div id="datetimepicker1" class="form-group input-group date">
						{{ Form::text('fecha_ini',Input::old('fecha_ini'),array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
				<div class="col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
					{{ Form::label('fecha_fin_capacitacion','Fecha de Fin') }}<span style="color:red">*</span>
					<div id="datetimepicker2" class="form-group input-group date">
						{{ Form::text('fecha_fin',Input::old('fecha_fin'),array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container-fluid row">
		<div class="form-group col-md-2 col-md-offset-8">				
			{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => '145px')) }}
		</div>
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" style="width:145px" href="{{route('capacitacion.index')}}">Cancelar</a>				
		</div>
	</div>
	{{ Form::close() }}

	<script type="text/javascript">

		$( document ).ready(function(){

			habilitaCampos();

		});

	</script>
@stop