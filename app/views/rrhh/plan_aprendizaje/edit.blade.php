@extends('templates/recursosHumanosTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Plan de aprendizaje</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach		
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>['rh_plan_aprendizaje.update',$plan->id], 'role'=>'form','files'=>true,'id'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos generales del plan</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', $plan->nombre, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::select('departamento', $departamentos, $plan->id_departamento, ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::select('servicio_clinico', $servicios, $plan->id_servicio_clinico, ['id'=>'servicio_clinico','class'=>'form-control','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable de elaboración') }}
						{{ Form::select('responsable',$usuarios, $plan->id_responsable,['class'=>'form-control'])}}
					</div>

					<div class="form-group col-md-4 @if($errors->first('numero_horas')) has-error has-feedback @endif">
						{{ Form::label('numero_horas','N° Horas') }}
						{{ Form::number('numero_horas', $plan->num_horas,['class'=>'form-control','readonly'])}}
					</div>

				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
						{{ Form::label('fecha_ini','Fecha Inicio') }}
						<div id="datetimepicker1" class="form-group input-group date">
							{{ Form::text('fecha_ini',date('dd-mm-YYYY',strtotime($plan->fecha_ini)),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
						{{ Form::label('fecha_fin','Fecha Fin') }}
						<div id="datetimepicker2" class="form-group input-group date">
							{{ Form::text('fecha_fin',date('dd-mm-YYYY',strtotime($plan->fecha_fin)),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>	

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('plan_descripcion')) has-error has-feedback @endif">
						{{ Form::label('plan_descripcion','Descripción') }}
						{{ Form::textarea('plan_descripcion', $plan->descripcion, ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('objetivo')) has-error has-feedback @endif">
						{{ Form::label('objetivo','Objetivo') }}
						{{ Form::textarea('objetivo', $plan->objetivo, ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('personal')) has-error has-feedback @endif">
						{{ Form::label('personal','Personal involucrado') }}
						{{ Form::textarea('personal', $plan->personal, ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('competencias_requeridas')) has-error has-feedback @endif">
						{{ Form::label('competencias_requeridas','Competencias Requeridas') }}
						{{ Form::textarea('competencias_requeridas', $plan->competencias_requeridas, ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
							    	<h3 class="panel-title">Actividades</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4 @if($errors->first('act_nombres')) has-error has-feedback @endif">
									{{ Form::label('actividad','Nombre') }}
									{{ Form::text('actividad', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('act_nombres')) has-error has-feedback @endif">
									{{ Form::label('descripcion','Descripción') }}
									{{ Form::text('descripcion', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('act_nombres')) has-error has-feedback @endif">
									{{ Form::label('servicio','Servicios Involucrados') }}
									{{ Form::text('servicio', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('act_nombres')) has-error has-feedback @endif">
									{{ Form::label('fecha','Fecha') }}
									<div id="datetimepicker3" class="form-group input-group date">
										{{ Form::text('fecha',Input::old('fecha'),array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>

								<div class="form-group col-md-4 @if($errors->first('act_nombres')) has-error has-feedback @endif">
									{{ Form::label('duracion','Duración') }}
									{{ Form::number('duracion', null, ['class'=>'form-control','min'=>0]) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" onclick="agregarPlanAct()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Actividad</th>
											<th>Descripción</th>
											<th>Servicio Involucrado</th>
											<th>Fecha</th>
											<th>Duración</th>
											<th></th>
										</tr>
										<tbody class="act_table">
											@foreach($plan->actividades as $actividad)
												<tr>
													<td>{{$actividad->nombre}}</td>
													<td>{{$actividad->descripcion}}</td>
													<td>{{$actividad->servicio}}</td>
													<td>{{$actividad->fecha}}</td>
													<td>{{$actividad->duracion}}</td>
													<td>
														<a class="btn btn-default delete-detail" href="{{route('rh_plan_aprendizaje.actividad.edit',$actividad->id)}}">Editar</a>
													</td>
												</tr>
											@endforeach
											@if(Input::old('act_nombres'))
												@foreach(Input::old('act_nombres') as $key => $act)
													<tr>
														<td><input class="cell" name='act_nombres[]' value='{{$act}}' readonly/></td>
														<td><input class="cell" name='act_descripciones[]' value='{{Input::old('act_descripciones')[$key]}}' readonly/></td>
														<td><input class="cell" name='act_servicios[]' value='{{Input::old('act_servicios')[$key]}}' readonly/></td>
														<td><input class="cell" name='act_fechas[]' value='{{Input::old('act_fechas')[$key]}}' readonly/></td>
														<td><input class="cell" name='act_duraciones[]' value='{{Input::old('act_duraciones')[$key]}}' readonly/></td>

														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
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
								<div class="form-group col-md-12 @if($errors->first('infraestructura')) has-error has-feedback @endif">
									{{ Form::label('infraestructura','Infraestructura') }}
									{{ Form::textarea('infraestructura', $plan->infraestructura, ['class'=>'form-control','rows'=>5]) }}
								</div>

								<div class="form-group col-md-12 @if($errors->first('equipos')) has-error has-feedback @endif">
									{{ Form::label('equipos','Equipos') }}
									{{ Form::textarea('equipos', $plan->equipos, ['class'=>'form-control','rows'=>5]) }}
								</div>

								<div class="form-group col-md-12 @if($errors->first('herramientas')) has-error has-feedback @endif">
									{{ Form::label('herramientas','Herramientas') }}
									{{ Form::textarea('herramientas', $plan->herramientas, ['class'=>'form-control','rows'=>5]) }}
								</div>

								<div class="form-group col-md-12 @if($errors->first('insumos')) has-error has-feedback @endif">
									{{ Form::label('insumos','Insumos') }}
									{{ Form::textarea('insumos', $plan->insumos, ['class'=>'form-control','rows'=>5]) }}
								</div>

								<div class="form-group col-md-12 @if($errors->first('equipo_personal')) has-error has-feedback @endif">
									{{ Form::label('equipo_personal','Equipo Personal') }}
									{{ Form::textarea('equipo_personal', $plan->equipo_personal, ['class'=>'form-control','rows'=>5]) }}
								</div>

								<div class="form-group col-md-12 @if($errors->first('condiciones')) has-error has-feedback @endif">
									{{ Form::label('condiciones','Condiciones de seguridad') }}
									{{ Form::textarea('condiciones', $plan->condiciones, ['class'=>'form-control','rows'=>5]) }}
								</div>
							</div>

							<div class="panel-heading">
							    	<h3 class="panel-title">Competencias</h3>
						  	</div>

							<div class="panel-body">

								<div class="form-group col-md-4 @if($errors->first('competencias_generadas')) has-error has-feedback @endif">
									{{ Form::label('competencia_generada','Compentencias Generadas') }}
									{{ Form::text('competencia_generada', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('competencias_generadas')) has-error has-feedback @endif">
									{{ Form::label('indicador','Indicador de logro') }}
									{{ Form::text('indicador', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-3">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" onclick="agregarPlanRec()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Competencias generadas</th>
											<th>Indicador de logro</th>
											<th></th>
										</tr>
										<tbody class="rec_table">
											@foreach($plan->recursos as $recurso)
												<tr>
													<td>{{$recurso->competencia_generada}}</td>
													<td>{{$recurso->indicador}}</td>
													<td>
														<a class="btn btn-default delete-detail" href="{{route('rh_plan_aprendizaje.recurso.edit',$recurso->id)}}">Editar</a>
													</td>
												</tr>
											@endforeach
											@if(Input::old('competencias_generadas'))
												@foreach(Input::old('competencias_generadas') as $key => $data)
													<tr>
														<td><input class="cell" name='competencias_generadas[]' value='{{$data}}' readonly/></td>
														<td><input class="cell" name='indicadores[]' value='{{Input::old('indicadores')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
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
							    	<h3 class="panel-title">Adjuntar Archivo</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="col-md-8 @if($errors->first('archivo')) has-error has-feedback @endif">
									<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
									<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
								</div>
								<div class="col-md-8 form-group">
									{{ Form::label('archivo_subido','Archivo Subido') }}
									{{ Form::text('archivo_subido', $plan->nombre_archivo, ['class'=>'form-control','readonly']) }}
								</div>
						  	</div>
						  </div>
					</div>
				</div>

			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>

			<div class="form-group col-md-offset-8 col-md-2">
				<a class="btn-under" href="{{route('rh_plan_aprendizaje.show',$plan->id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
				</a>
			</div>

		</div>

	{{ Form::close() }}

	
	<script>
		$("#input-file").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>
@stop