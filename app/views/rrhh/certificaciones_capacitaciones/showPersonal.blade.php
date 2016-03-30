@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Personal de la Capacitación: {{$capacitacion->codigo}}</h3>
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
	  		Personal  <strong>(Cantidad de Personas: {{count($personal_data)}} )</strong>
	  	</div>
	  	<div class="panel-body">	
	  		<div class="row">
		    	<div class="col-md-12">
					<div class="table-responsive">
						<table class="table">
							<tr class="info">				
								<th class="text-nowrap text-center">N°</th>
								<th class="text-nowrap text-center">Nombres</th>
								<th class="text-nowrap text-center">Apellidos</th>						
								<th class="text-nowrap text-center">Servicio Clínico</th>
								<th class="text-nowrap text-center">Departamento</th>
								<th class="text-nowrap text-center">Tipo Documento Identidad</th>
								<th class="text-nowrap text-center">Número de Documento</th>
								<th class="text-nowrap text-center">N° Sesiones Asistidas</th>
								<th class="text-nowrap text-center">Certificado</th>
							</tr>

							@foreach($personal_data as $index => $personal)
								<tr>
									<td  class="text-nowrap text-center">
										{{$index+1}}
									</td>
									<td  class="text-nowrap text-center">
										{{$personal->nombre}}
									</td>
									<td  class="text-nowrap text-center">
										{{$personal->apellidos}}
									</td>
									<td  class="text-nowrap text-center">
										{{$personal->nombre_servicio}}
									</td>
									<td  class="text-nowrap text-center">
										{{$personal->nombre_area}}
									</td>
									<td  class="text-nowrap text-center">
										{{$personal->nombre_documento}}
									</td>
									<td  class="text-nowrap text-center">
										<a href="{{URL::to('/certificacion/show_info_personal')}}/{{$personal->id}}">
										{{$personal->numero_documento}}</a>
									</td>
									<td  class="text-nowrap text-center">
										@if($personal->sesiones_asistidas == null)
											-
										@else
											{{$personal->sesiones_asistidas}}
										@endif
									</td>
									<td  class="text-nowrap text-center">
										@if(!$personal->nombre_archivo == null)
											<a class="btn btn-warning" type="button" href="{{URL::to('certificacion/edit_certificado_personal')}}/{{$personal->id}}"><span class="glyphicon glyphicon-pencil"></span> Editar</button>
										@else
											<a class="btn btn-success" type="button" href="{{URL::to('certificacion/edit_certificado_personal')}}/{{$personal->id}}"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
										@endif
									</td>
								</tr>	
							@endforeach
						</table>
					</div>
				</div>
			</div>
	  	</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" href="{{route('certificacion.index')}}">Regresar</a>				
		</div>
	</div>
	
	
	<script type="text/javascript">

		$( document ).ready(function(){
			
		});

	</script>
@stop