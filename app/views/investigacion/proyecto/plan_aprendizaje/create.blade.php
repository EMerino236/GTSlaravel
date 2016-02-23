@extends('templates/investigacionTemplate')
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
			<p><strong>{{ $errors->first('id_reporte') }}</strong></p>
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('categoria') }}</strong></p>
			<p><strong>{{ $errors->first('servicio_clinico') }}</strong></p>
			<p><strong>{{ $errors->first('responsable') }}</strong></p>
			<p><strong>{{ $errors->first('departamento') }}</strong></p>
			<p><strong>{{ $errors->first('plan_descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('objetivo') }}</strong></p>
			<p><strong>{{ $errors->first('personal') }}</strong></p>
			<p><strong>{{ $errors->first('competencias_requeridas') }}</strong></p>

			<p><strong>{{ $errors->first('act_nombres') }}</strong></p>
			<p><strong>{{ $errors->first('act_descripciones') }}</strong></p>
			<p><strong>{{ $errors->first('act_servicios') }}</strong></p>
			<p><strong>{{ $errors->first('act_fechas') }}</strong></p>
			<p><strong>{{ $errors->first('act_duraciones') }}</strong></p>

			<p><strong>{{ $errors->first('infraestructura') }}</strong></p>
			<p><strong>{{ $errors->first('equipos') }}</strong></p>
			<p><strong>{{ $errors->first('herramientas') }}</strong></p>
			<p><strong>{{ $errors->first('insumos') }}</strong></p>
			<p><strong>{{ $errors->first('equipo_personal') }}</strong></p>
			<p><strong>{{ $errors->first('condiciones') }}</strong></p>

			<p><strong>{{ $errors->first('competencias_generadas') }}</strong></p>
			<p><strong>{{ $errors->first('indicadores') }}</strong></p>

			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>'plan_aprendizaje.store', 'role'=>'form','files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos generales del proyecto</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('id_reporte','Código de proyecto') }}
						{{ Form::number('id_reporte', null, ['id'=>'id_reporte','class'=>'form-control']) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::label('','&zwnj;&zwnj;') }}
						{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Validar', array('id'=>'submit_create', 'class' => 'btn btn-primary btn-block','onClick'=>'validarProyectoExiste()')) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', Input::old('nombre'), ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('categoria')) has-error has-feedback @endif">
						{{ Form::label('categoria','Categoría') }}
						{{ Form::select('categoria', $categorias, Input::old('categoria'), ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::select('departamento', $departamentos, Input::old('departamento'), ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::select('servicio_clinico', $servicios, Input::old('servicio_clinico'), ['id'=>'servicio_clinico','class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable de elaboración') }}
						{{ Form::select('responsable',$usuarios, Input::old('responsable'),['class'=>'form-control'])}}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('plan_descripcion')) has-error has-feedback @endif">
						{{ Form::label('plan_descripcion','Descripción') }}
						{{ Form::textarea('plan_descripcion', Input::old('plan_descripcion'), ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('objetivo')) has-error has-feedback @endif">
						{{ Form::label('objetivo','Objetivo') }}
						{{ Form::textarea('objetivo', Input::old('objetivo'), ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('personal')) has-error has-feedback @endif">
						{{ Form::label('personal','Personal involucrado') }}
						{{ Form::textarea('personal', Input::old('personal'), ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('competencias_requeridas')) has-error has-feedback @endif">
						{{ Form::label('competencias_requeridas','Competencias Requeridas') }}
						{{ Form::textarea('competencias_requeridas', Input::old('competencias_requeridas'), ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
							    	<h3 class="panel-title">Actividades</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4">
									{{ Form::label('actividad','Nombre') }}
									{{ Form::text('actividad', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('descripcion','Descripción') }}
									{{ Form::text('descripcion', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('servicio','Servicios Involucrados') }}
									{{ Form::text('servicio', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('fecha')) has-error has-feedback @endif">
									{{ Form::label('fecha','Fecha') }}
									<div id="datetimepicker_plan" class="form-group input-group date">
										{{ Form::text('fecha',Input::old('fecha'),array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>

								<div class="form-group col-md-4">
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
								<div class="form-group col-md-4">
									{{ Form::label('infraestructura','Infraestructura') }}
									{{ Form::text('infraestructura', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('equipos','Equipos') }}
									{{ Form::text('equipos', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('herramientas','Herramientas') }}
									{{ Form::text('herramientas', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('insumos','Insumos') }}
									{{ Form::text('insumos', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('equipo_personal','Equipo Personal') }}
									{{ Form::text('equipo_personal', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('condiciones','Condiciones de seguridad') }}
									{{ Form::text('condiciones', null, ['class'=>'form-control']) }}
								</div>
							</div>

							<div class="panel-body">

								<div class="form-group col-md-4">
									{{ Form::label('competencia_generada','Compentencias Generadas') }}
									{{ Form::text('competencia_generada', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
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
								<div class="col-md-8">
									<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
									<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
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

			<div class="form-group col-md-2">
				<a class="btn-under" href="{{route('plan_aprendizaje.index')}}">
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