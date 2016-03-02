@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Formulación de proyecto</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('categoria') }}</strong></p>
			<p><strong>{{ $errors->first('servicio_clinico') }}</strong></p>
			<p><strong>{{ $errors->first('responsable') }}</strong></p>
			<p><strong>{{ $errors->first('departamento') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_ini') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_fin') }}</strong></p>
			<p><strong>{{ $errors->first('proposito') }}</strong></p>
			<p><strong>{{ $errors->first('objetivos') }}</strong></p>
			<p><strong>{{ $errors->first('metodologia') }}</strong></p>
			<p><strong>{{ $errors->first('requerimientos') }}</strong></p>
			<p><strong>{{ $errors->first('asunciones') }}</strong></p>
			<p><strong>{{ $errors->first('restricciones') }}</strong></p>
			<p><strong>{{ $errors->first('riesgo_descs') }}</strong></p>
			<p><strong>{{ $errors->first('riesgo_tipos') }}</strong></p>
			<p><strong>{{ $errors->first('crono_descs') }}</strong></p>
			<p><strong>{{ $errors->first('crono_fechas_ini') }}</strong></p>
			<p><strong>{{ $errors->first('crono_fechas_fin') }}</strong></p>
			<p><strong>{{ $errors->first('pre_descs') }}</strong></p>
			<p><strong>{{ $errors->first('pre_montos') }}</strong></p>
			<p><strong>{{ $errors->first('pers_nombres') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('entidades') }}</strong></p>
			<p><strong>{{ $errors->first('apro_nombres') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>'proyecto.store', 'role'=>'form','id'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos generales del proyecto</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('id_reporte','Código de proyecto') }}
						{{ Form::number('id_reporte', null, ['id'=>'id_reporte','class'=>'form-control','min'=>'1']) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::label('','&zwnj;&zwnj;') }}
						{{ Form::button('<span class="glyphicon glyphicon-check"></span> Validar', array('id'=>'submit_create', 'class' => 'btn btn-primary btn-block','onClick'=>'validarProyecto()')) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', Input::old('nombre'), ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('categoria')) has-error has-feedback @endif">
						{{ Form::label('categoria','Categoría') }}
						{{ Form::select('categoria', $categorias, Input::old('categoria'), ['class'=>'form-control','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::select('departamento', $departamentos, Input::old('departamento'), ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::select('servicio_clinico', $servicios, Input::old('servicio_clinico'), ['id'=>'servicio_clinico','class'=>'form-control','disabled']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable de elaboración de linea base') }}
						{{ Form::select('responsable',$usuarios, Input::old('responsable'),['class'=>'form-control'])}}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
						{{ Form::label('fecha_ini','Fecha Inicio') }}
						<div id="datetimepicker_desarrollo_ini" class="form-group input-group date">
							{{ Form::text('fecha_ini',Input::old('fecha_ini'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
						{{ Form::label('fecha_fin','Fecha Fin') }}
						<div id="datetimepicker_desarrollo_fin" class="form-group input-group date">
							{{ Form::text('fecha_fin',Input::old('fecha_fin'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4 form-group">
						{{ Form::label('total_inversion','Total disponible por inversion') }}
						{{ Form::text('total_inversion', null ,['id'=>'total_inv','class'=>'form-control','readonly'])}}	
					</div>
				</div>
			
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('proposito')) has-error has-feedback @endif">
						{{ Form::label('proposito','Propósito - Justificación') }}
						{{ Form::textarea('proposito', Input::old('proposito'), ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('objetivos')) has-error has-feedback @endif">
						{{ Form::label('objetivos','Objetivos del proyecto') }}
						{{ Form::textarea('objetivos', Input::old('objetivos'), ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('metodologia')) has-error has-feedback @endif">
						{{ Form::label('metodologia','Metodología') }}
						{{ Form::textarea('metodologia', Input::old('metodologia'), ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
							    	<h3 class="panel-title">Principales Requerimientos</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4">
									{{ Form::text('requerimiento', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-3">
									<div class="btn btn-primary btn-block" onclick="agregarProyReq()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Requerimiento</th>
											<th></th>
										</tr>
										<tbody class="req_table">
											@if(Input::old('requerimientos'))
												@foreach(Input::old('requerimientos') as $req)
													<tr>
														<td><input style="border:0" name='requerimientos[]' value='{{$req}}' readonly/></td>
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
							    	<h3 class="panel-title">Asunciones</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4">
									{{ Form::text('asuncion', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-3">
									<div class="btn btn-primary btn-block" onclick="agregarProyAsu()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Asunción</th>
											<th></th>
										</tr>
										<tbody class="asu_table">
											@if(Input::old('asunciones'))
												@foreach(Input::old('asunciones') as $data)
													<tr>
														<td><input style="border:0" name='asunciones[]' value='{{$data}}' readonly/></td>
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
							    	<h3 class="panel-title">Restricciones</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4">
									{{ Form::text('restriccion', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-3">
									<div class="btn btn-primary btn-block" onclick="agregarProyRes()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Restricción</th>
											<th></th>
										</tr>
										<tbody class="res_table">
											@if(Input::old('restricciones'))
												@foreach(Input::old('restricciones') as $data)
													<tr>
														<td><input style="border:0" name='restricciones[]' value='{{$data}}' readonly/></td>
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

				<div class="row ">
					<div class="col-md-12 form-group @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}
						{{ Form::textarea('descripcion', Input::old('descripcion'), ['class'=>'form-control','rows'=>7]) }}
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
							    	<h3 class="panel-title">Riesgos</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4">
									{{ Form::label('riesgo_desc','Descripción') }}
									{{ Form::text('riesgo_desc', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('riesgo_tipo','Tipo') }}
									{{ Form::text('riesgo_tipo', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" onclick="agregarProyRies()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Descripción</th>
											<th>Tipo</th>
											<th></th>
										</tr>
										<tbody class="ries_table">
											@if(Input::old('riesgo_descs'))
												@foreach(Input::old('riesgo_descs') as $key => $data)
													<tr>
														<td><input style="border:0" name='riesgo_descs[]' value='{{$data}}' readonly/></td>
														<td><input style="border:0" name='riesgo_tipos[]' value='{{Input::old('riesgo_tipos')[$key]}}' readonly/></td>
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
							    	<h3 class="panel-title">Resumen del Cronograma</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-3">
									{{ Form::label('crono_desc','Descripción') }}
									{{ Form::text('crono_desc', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-3">
									{{ Form::label('fecha_ini','Fecha Inicio') }}
									<div id="datetimepicker_crono_ini" class="form-group input-group date">
										{{ Form::text('crono_fecha_ini',null,array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>
								<div class="form-group col-md-3">
									{{ Form::label('fecha_fin','Fecha Fin') }}
									<div id="datetimepicker_crono_fin" class="form-group input-group date">
										{{ Form::text('crono_fecha_fin',null,array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>

								<div class="form-group col-md-3">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" onclick="agregarProyCrono()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Descripción</th>
											<th>Fecha Inicio</th>
											<th>Fecha Fin</th>
											<th></th>
										</tr>
										<tbody class="crono_table">
											@if(Input::old('crono_descs'))
												@foreach(Input::old('crono_descs') as $key => $data)
													<tr>
														<td><input style="border:0" name='crono_descs[]' value='{{$data}}' readonly/></td>
														<td><input style="border:0" name='crono_fechas_ini[]' value='{{Input::old('crono_fechas_ini')[$key]}}' readonly/></td>
														<td><input style="border:0" name='crono_fechas_fin[]' value='{{Input::old('crono_fechas_fin')[$key]}}' readonly/></td>
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
							    	<h3 class="panel-title">Resumen de Presupuesto</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4">
									{{ Form::label('pre_desc','Descripción') }}
									{{ Form::text('pre_desc', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('pre_monto','Monto') }}
									{{ Form::number('pre_monto', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" onclick="agregarProyPre()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Descripción</th>
											<th>Monto</th>
											<th></th>
										</tr>
										<tbody class="pre_table">
											@if(Input::old('pre_descs'))
												@foreach(Input::old('pre_descs') as $key => $data)
													<tr>
														<td><input style="border:0" name='pre_descs[]' value='{{$data}}' readonly/></td>
														<td><input style="border:0" name='pre_montos[]' value='{{Input::old('pre_montos')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowPre(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
										</tbody>
										<th>TOTAL: S/. <input class="cell" name="total" value="{{0+Input::old('total')}}" id="total" readonly/></th>
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
							    	<h3 class="panel-title">Personal involucrado</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4">
									{{ Form::label('pers_nombre','Nombre') }}
									{{ Form::select('pers_nombre', $usuarios, null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-3">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" onclick="agregarProyPers()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Nombre</th>
											<th></th>
										</tr>
										<tbody class="pers_table">
											@if(Input::old('pers_nombres'))
												@foreach(Input::old('pers_nombres') as $key => $data)
													<tr>
														<td><input style="border:0" value='{{$usuarios[$data]}}' readonly/><input type='hidden' name='pers_nombres[]' value='{{$data}}'/></td>
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
							    	<h3 class="panel-title">Entidades o Grupos involucrados</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4">
									{{ Form::label('entidad','Nombre') }}
									{{ Form::text('entidad', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-3">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" onclick="agregarProyEnt()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Entidad</th>
											<th></th>
										</tr>
										<tbody class="ent_table">
											@if(Input::old('entidades'))
												@foreach(Input::old('entidades') as $data)
													<tr>
														<td><input style="border:0" name='entidades[]' value='{{$data}}' readonly/></td>
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
							    	<h3 class="panel-title">Aprobaciones necesarias</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4">
									{{ Form::label('apro_nombre','Nombre') }}
									{{ Form::select('apro_nombre',$usuarios, null, ['id'=>'apro_nombre','class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-3">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" onclick="agregarProyApro()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Nombre</th>
											<th></th>
										</tr>
										<tbody class="apro_table">
											@if(Input::old('apro_nombres'))
												@foreach(Input::old('apro_nombres') as $key => $data)
													<tr>
														<td><input style="border:0" value='{{$usuarios[$data]}}' readonly/><input type='hidden' name='apro_nombres[]' value='{{$data}}'/></td>
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

			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>

	{{ Form::close() }}


@stop