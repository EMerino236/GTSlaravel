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
					{{ Form::text('codigo_patrimonial', $codigo_patrimonial , ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-6">
					{{ Form::label('equipo_relacionado','Equipo Relacionado') }}
					{{ Form::text('equipo_relacionado', $equipo_relacionado, ['class'=>'form-control','readonly']) }}
				</div>	
			</div>
			@endif

			<div class="form-group row">
				<div class="form-group col-md-4">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento', $capacitacion->servicio->departamento->nombre, ['id'=>'departamento','class'=>'form-control','readonly']) }}
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

	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos de las Sesiones de la Capacitación
	  	</div>
	  	<div class="panel-body">	
		  	<div class="form-group row">
				<div class="form-group col-md-6 @if($errors->first('numero_sesiones')) has-error has-feedback @endif">
					{{ Form::label('numero_sesiones','Número de Sesiones') }}
					{{ Form::text('numero_sesiones',$capacitacion->numero_sesiones,['class' => 'form-control','readonly'=>''])}}
				</div>
				<div class="form-group col-md-6 @if($errors->first('horasxsesion')) has-error has-feedback @endif">
					{{ Form::label('horasxsesion','Horas Por Sesión') }}
					{{ Form::text('horasxsesion',$capacitacion->horasxsesiones,['class' => 'form-control','readonly'=>''])}}
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Plan de Capacitación
	  	</div>
	  	<div class="panel-body">	
		  	<div class="form-group row">
				<div class="form-group col-md-12 @if($errors->first('objetivo')) has-error has-feedback @endif">
					{{ Form::label('objetivo','Objetivo (MAX: 200 Caracteres)') }}
					{{ Form::textarea('objetivo',$capacitacion->objetivo,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none','readonly'=>''])}}
				</div>
			</div>
			<div class="form-group row">
				<div class="form-group col-md-12 @if($errors->first('personas_involucradas')) has-error has-feedback @endif">
					{{ Form::label('personas_involucradas','Personas Involucradas (MAX: 200 Caracteres)') }}
					{{ Form::textarea('personas_involucradas',$capacitacion->personal_involucrado,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none','readonly'=>''])}}
				</div>
			</div>
			<div class="form-group row">
				<div class="form-group col-md-12 @if($errors->first('competencias_requeridas')) has-error has-feedback @endif">
					{{ Form::label('competencias_requeridas','Competencias Requeridas (MAX: 200 Caracteres)') }}
					{{ Form::textarea('competencias_requeridas',$capacitacion->competencia,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none','readonly'=>''])}}
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Personal Externo Involucrado
	  	</div>
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table">
							<tr class="info">						
								<th class="text-nowrap text-center">Nombre</th>
								<th class="text-nowrap text-center">Descripción</th>						
								<th class="text-nowrap text-center">Rol</th>
								<th class="text-nowrap text-center">Institución</th>
							</tr>	
							<?php 								
								$count = count($details_personas);	
							?>	
							<?php for($i=0;$i<$count;$i++){ ?>
							<tr>
								<td>
									<input style="border:0" name='details_nombre[]' value='{{ $details_personas[$i]->nombre }}' readonly/>
								</td>
								<td>
									<input style="border:0" name='details_descripcion[]' value='{{ $details_personas[$i]->descripcion }}' readonly/>
								</td>
								<td>
									<input style="border:0" name='details_rol[]' value='{{ $details_personas[$i]->rol }}' readonly/>
								</td>
								<td>
									<input style="border:0" name='details_institucion[]' value='{{ $details_personas[$i]->institucion }}' readonly/>
								</td>					
							</tr>
							<?php } ?>					
						</table>				
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Documento Adjunto del Plan de Capacitación
	  	</div>
	  	<div class="panel-body">
	  		<div class="row" >
    			<div class="col-md-5 col-md-offset-3 form-group">
    				{{ Form::label('label_doc','Plan de Capacitación:') }}
    				{{ Form::text('nombre_doc',$capacitacion->nombre_archivo,array('class'=>'form-control','id'=>'file','readonly'=>''))}}								
   				</div>
   				<div class="col-md-2" style="margin-top:25px;">
   					@if($capacitacion->url != '')
						<a class="btn btn-success btn-block" href="{{URL::to('/capacitacion/download')}}/{{$capacitacion->id}}" ><span class="glyphicon glyphicon-download"></span> Descargar</a>
					@else
						Sin archivo adjunto
					@endif
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
			<a class="btn btn-default btn-block" href="{{route('capacitacion.index')}}">Regresar</a>				
		</div>
	</div>
@stop