@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Capacitación: {{$capacitacion->codigo}}</h3>
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

	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos Generales
	  	</div>
	  	<div class="panel-body">	
			<div class="form-group row">
				<div class="col-md-4">
					{{ Form::label('nombre_capacitacion','Nombre de Capacitación') }}<span style='color:red'>*</span>
					{{ Form::text('nombre_capacitacion', $capacitacion->nombre,['class' => 'form-control', 'readonly'])}}						
				</div>								
				<div class="col-md-4">
					{{ Form::label('tipo_capacitacion','Tipo de Capacitación') }}<span style='color:red'>*</span>
					{{ Form::text('tipo_capacitacion',$capacitacion->tipo->nombre, array('class'=>'form-control','readonly'))}}
				</div>
				<div class="col-md-4">
					{{ Form::label('modalidad_capacitacion','Modalidad de Capacitación') }}<span style='color:red'>*</span>
					{{ Form::text('modalidad_capacitacion',$capacitacion->modalidad->nombre, array('class'=>'form-control','readonly'))}}
				</div>
			</div>	

			<div class="form-group row">
				<div class="form-group col-md-12">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::textarea('descripcion',$capacitacion->descripcion,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none','readonly'])}}
				</div>
			</div>			

			@if($capacitacion->id_tipo != 3)
			<div class="form-group row">
				<div class="form-group col-md-6">
					{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
					{{ Form::text('codigo_patrimonial', $capacitacion->codigo_patrimonial, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-6">
					{{ Form::label('equipo_relacionado','Equipo Relacionado') }}
					{{ Form::text('equipo_relacionado', $capacitacion->equipo_relacionado, ['class'=>'form-control','readonly']) }}
				</div>	
			</div>
			@endif

			<div class="form-group row">
				<div class="form-group col-md-4">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento', $capacitacion->departamento->nombre, ['id'=>'departamento','class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::text('servicio_clinico', $capacitacion->servicio->nombre, ['id'=>'servicio_clinico','class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('responsable','Responsable') }}
					{{ Form::text('responsable', $capacitacion->responsable->UserFullName,['class'=>'form-control','readonly'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4">
					{{ Form::label('fecha_ini_capacitacion','Fecha de Inicio') }}<span style="color:red">*</span>
					{{ Form::text('fecha_ini',$capacitacion->fecha_ini,array('class'=>'form-control','readonly'=>'')) }}
				</div>
				<div class="col-md-4">
					{{ Form::label('fecha_fin_capacitacion','Fecha de Fin') }}<span style="color:red">*</span>
					{{ Form::text('fecha_fin',$capacitacion->fecha_fin,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>

		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-2 ">
			<a href="{{route('capacitacion.edit',$capacitacion->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('class' => 'btn btn-primary btn-block')) }}
			</a>
		</div>
		<div class="form-group col-md-offset-8 col-md-2">
			<a class="btn btn-default btn-block" href="{{route('capacitacion.index')}}">Cancelar</a>				
		</div>
	</div>
@stop