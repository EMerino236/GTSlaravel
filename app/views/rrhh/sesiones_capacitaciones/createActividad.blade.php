@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Actividad</h3>
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

	{{ Form::open(array('route'=>'capacitacion.store_actividad', 'role'=>'form','files'=>'true')) }}		
		{{Form::hidden('id_sesion',$sesion->id)}}
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos Generales
	  	</div>

	  	<div class="panel-body">	
			<div class="form-group row">
				<div class="col-md-12 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre de la Actividad') }}<span style='color:red'>*</span>
					{{ Form::text('nombre',Input::old('nombre'),['class' => 'form-control'])}}						
				</div>	
			</div>
			<div class="form-group row">				
				<div class="col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripcion') }}<span style='color:red'>*</span>
					{{ Form::textarea('descripcion',Input::old('descripcion'),['class' => 'form-control','style'=>'resize:none','rows'=>'5'])}}	
				</div>
			</div>
			<div class="form-group row">				
				<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::select('servicio_clinico', array('' => 'Seleccione') + $servicios, Input::old('servicio_clinico'), ['id'=>'servicio_clinico','class'=>'form-control']) }}
				</div>						
				<div class="col-md-4 @if($errors->first('fecha')) has-error has-feedback @endif">
					{{ Form::label('fecha','Fecha') }}<span style="color:red">*</span>
					<div id="datetimepicker1" class="form-group input-group date">
						{{ Form::text('fecha',Input::old('fecha'),array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
				<div class="form-group col-md-4 @if($errors->first('duracion')) has-error has-feedback @endif">
					{{ Form::label('duracion','Duración (Horas)') }}
					{{ Form::number('duracion',Input::old('duracion'),['class' => 'form-control','min'=>0])}}
				</div>	
			</div>
			
		</div>
	</div>

	<div class="container-fluid row">
		<div class="form-group col-md-2 col-md-offset-8">				
			{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => '145px')) }}
		</div>
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" style="width:145px" href="{{URL::to('/capacitacion/show_actividades')}}/{{$sesion->id}}">Cancelar</a>				
		</div>
	</div>
	{{ Form::close() }}

	<script type="text/javascript">

		$( document ).ready(function(){

			habilitaCampos();

			
		});


	</script>
@stop