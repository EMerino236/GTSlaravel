@extends('templates/recursosHumanosTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Plan de aprendizaje</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Datos generales del proyecto</h3>
		</div>
		<div class="panel-body">

			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre', $plan->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento', $departamentos[$plan->id_departamento], ['id'=>'departamento','class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::text('servicio_clinico', $servicios[$plan->id_servicio_clinico], ['id'=>'servicio_clinico','class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('responsable','Responsable de elaboración') }}
					{{ Form::text('responsable',$usuarios[$plan->id_responsable],['class'=>'form-control','readonly'])}}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('numero_horas','Nº Horas') }}
					{{ Form::text('numero_horas', $plan->num_horas,['class'=>'form-control','readonly'])}}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('fecha_ini','Fecha Inicio') }}
					{{ Form::text('fecha_ini',$plan->fecha_ini,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('fecha_fin','Fecha Fin') }}
					{{ Form::text('fecha_fin',$plan->fecha_fin,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
			</div>	

			<div class="row">
				<div class="form-group col-md-12">
					{{ Form::label('plan_descripcion','Descripción') }}
					{{ Form::textarea('plan_descripcion', $plan->descripcion, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-12">
					{{ Form::label('objetivo','Objetivo') }}
					{{ Form::textarea('objetivo', $plan->objetivo, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-12">
					{{ Form::label('personal','Personal involucrado') }}
					{{ Form::textarea('personal', $plan->personal, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-12">
					{{ Form::label('competencias_requeridas','Competencias Requeridas') }}
					{{ Form::textarea('competencias_requeridas', $plan->competencias_requeridas, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
						    	<h3 class="panel-title">Actividades</h3>
					  	</div>

					  	<div class="panel-body">
							
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Actividad</th>
										<th>Descripción</th>
										<th>Servicio Involucrado</th>
										<th>Fecha</th>
										<th>Duración</th>
									</tr>
									<tbody class="act_table">
										@foreach($plan->actividades as $actividad)
											<tr>
												<td>{{$actividad->nombre}}</td>
												<td>{{$actividad->descripcion}}</td>
												<td>{{$actividad->servicio}}</td>
												<td>{{$actividad->fecha}}</td>
												<td>{{$actividad->duracion}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
						    	<h3 class="panel-title">Recursos Necesarios</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="form-group col-md-4">
								{{ Form::label('infraestructura','Infraestructura') }}
								{{ Form::text('infraestructura', $plan->infraestructura, ['class'=>'form-control','readonly']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('equipos','Equipos') }}
								{{ Form::text('equipos', $plan->equipos, ['class'=>'form-control','readonly']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('herramientas','Herramientas') }}
								{{ Form::text('herramientas', $plan->herramientas, ['class'=>'form-control','readonly']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('insumos','Insumos') }}
								{{ Form::text('insumos', $plan->insumos, ['class'=>'form-control','readonly']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('equipo_personal','Equipo Personal') }}
								{{ Form::text('equipo_personal', $plan->equipo_personal, ['class'=>'form-control','readonly']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('condiciones','Condiciones de seguridad') }}
								{{ Form::text('condiciones', $plan->condiciones, ['class'=>'form-control','readonly']) }}
							</div>
						</div>

						<div class="panel-body">

							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Competencias generadas</th>
										<th>Indicador de logro</th>
									</tr>
									<tbody class="rec_table">
										@foreach($plan->recursos as $recurso)
											<tr>
												<td>{{$recurso->competencia_generada}}</td>
												<td>{{$recurso->indicador}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
						    	<h3 class="panel-title">Archivo Adjunto</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="form-group col-md-6">
								{{ Form::text('archivo', $plan->nombre_archivo, ['class'=>'form-control','readonly']) }}
							</div>

							<div class="form-group col-md-2">
								<a class="btn-under" href="{{route('rh_plan_aprendizaje.download',$plan->id)}}">
									{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', ['class' => 'btn btn-success btn-block']) }}
								</a>
							</div>
					  	</div>
					  </div>
				</div>
			</div>

		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-2">
			<a class="btn-under" href="{{route('rh_plan_aprendizaje.edit',$plan->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', ['class' => 'btn btn-primary btn-block']) }}
			</a>
		</div>	

		<div class="form-group col-md-2">
			<a class="btn-under" href="{{route('rh_plan_aprendizaje.export',$plan->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-download"></span> Exportar', ['class' => 'btn btn-success btn-block']) }}
			</a>
		</div>

		<div class="form-group col-md-2 col-md-offset-6">
			<a class="btn-under" href="{{route('programacion_internado.index')}}">
				{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
			</a>
		</div>
	</div>

@stop