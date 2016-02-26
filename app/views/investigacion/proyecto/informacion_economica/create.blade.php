@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información Económica</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('id_proyecto') }}</strong></p>
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('categoria') }}</strong></p>
			<p><strong>{{ $errors->first('servicio_clinico') }}</strong></p>
			<p><strong>{{ $errors->first('responsable') }}</strong></p>
			<p><strong>{{ $errors->first('departamento') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_ini') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_fin') }}</strong></p>

			<p><strong>{{ $errors->first('rh_actividades') }}</strong></p>

			<p><strong>{{ $errors->first('eq_actividades') }}</strong></p>

			<p><strong>{{ $errors->first('go_actividades') }}</strong></p>

			<p><strong>{{ $errors->first('ga_actividades') }}</strong></p>

			<p><strong>{{ $errors->first('rh_actividades_post') }}</strong></p>

			<p><strong>{{ $errors->first('eq_actividades_post') }}</strong></p>

			<p><strong>{{ $errors->first('go_actividades_post') }}</strong></p>

			<p><strong>{{ $errors->first('ga_actividades_post') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>'informacion_economica.store', 'role'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informacion general del proyecto</h3>
			</div>
			<div class="panel-body">
				
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('id_proyecto','Código de proyecto') }}
						{{ Form::number('id_proyecto', null, ['id'=>'id_reporte','class'=>'form-control']) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::label('','&zwnj;&zwnj;') }}
						{{ Form::button('<span class="glyphicon glyphicon-check"></span> Validar', array('id'=>'submit_create', 'class' => 'btn btn-primary btn-block','onClick'=>'validarProyectoInfExiste()')) }}
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
						{{ Form::label('responsable','Responsable') }}
						{{ Form::select('responsable',$usuarios, Input::old('responsable'),['class'=>'form-control'])}}
					</div>

					<div class="form-group col-md-4 @if($errors->first('tipo')) has-error has-feedback @endif">
						{{ Form::label('tipo','Tipo') }}
						{{ Form::select('tipo',$tipos, Input::old('tipo'),['class'=>'form-control'])}}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
						{{ Form::label('fecha_ini','Fecha Inicio') }}
						<div id="datetimepicker_desarrollo_ini" class="form-group input-group date">
							{{ Form::text('fecha_ini', Input::old('fecha_ini'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
						{{ Form::label('fecha_fin','Fecha Fin') }}
						<div id="datetimepicker_desarrollo_fin" class="form-group input-group date">
							{{ Form::text('fecha_fin', Input::old('fecha_fin'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>

				<div id="tab_menu">
				  <ul class="nav nav-pills">
				    <li class="active">
				      	<a href="#tab_create_fase" data-toggle="tab">Fase de inversión</a>
				    </li>
				    <li>
				    	<a href="#tab_create_fase_post" data-toggle="tab">Fase de post inversión</a>
				    </li>
				  </ul>

				  <div class="tab-content clearfix">
				    <div class="tab-pane active" id="tab_create_fase">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Recursos Humanos</h3>
							</div>

						  	<div class="panel-body">
						  		<div class="row form-group">
							  		<div class="col-md-4">
							  			{{ Form::label('rh_inversion','Inversión disponible') }}
										{{ Form::text('rh_inversion', Input::old('rh_inversion'), ['id'=>'rh_inversion','class'=>'form-control','readonly']) }}
							  		</div>
						  		</div>
						  		<div class="row form-group">
									<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
										{{ Form::label('rh_actividad','Actividad') }}
										{{ Form::select('rh_actividad',[] ,null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
										{{ Form::label('rh_descripcion','Descripción') }}
										{{ Form::text('rh_descripcion', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
										{{ Form::label('rh_unidad','Unidad') }}
										{{ Form::text('rh_unidad', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
										{{ Form::label('rh_cantidad','Cantidad') }}
										{{ Form::number('rh_cantidad', null, ['class'=>'form-control','min'=>'0']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
										{{ Form::label('rh_costo_unitario','Costo por unidad') }}
										{{ Form::number('rh_costo_unitario', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
									</div>

									<div class="form-group col-md-4">
										{{ Form::label('','&zwnj;&zwnj;') }}
										<div class="btn btn-primary btn-block" onclick="agregarInfRH()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
									</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Actividad</th>
											<th>Descripcion</th>
											<th>Unidad</th>
											<th>Cantidad</th>
											<th>Costo por unidad</th>
											<th>Subtotal</th>
											<th></th>
										</tr>
										<tbody class="rh_table">
											@if(Input::old('rh_actividades'))
												@foreach(Input::old('rh_actividades') as $key => $req)
													<tr>
														<td><input class="cell" name='rh_actividades[]' value='{{$req}}' readonly/></td>
														<td><input class="cell" name='rh_descripciones[]' value='{{Input::old('rh_descripciones')[$key]}}' readonly/></td>
														<td><input class="cell" name='rh_unidades[]' value='{{Input::old('rh_unidades')[$key]}}' readonly/></td>
														<td><input class="cell" name='rh_cantidades[]' value='{{Input::old('rh_cantidades')[$key]}}' readonly/></td>
														<td><input class="cell" name='rh_costos_unitarios[]' value='{{Input::old('rh_costos_unitarios')[$key]}}' readonly/></td>
														<td><input class="cell" value='{{Input::old('rh_cantidades')[$key] * Input::old('rh_costos_unitarios')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfRH(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
										</tbody>
										<th>TOTAL: S/. <input class="cell" name="rh_total" value="{{0+Input::old('rh_total')}}" id="rh_total" readonly/></th>
									</table>
								</div>
							</div>

							<div class="panel-heading">
								<h3 class="panel-title">Equipos y bienes duraderos</h3>
							</div>

						  	<div class="panel-body">
						  		<div class="row form-group">
							  		<div class="col-md-4">
							  			{{ Form::label('eq_inversion','Inversión disponible') }}
										{{ Form::text('eq_inversion', Input::old('eq_inversion'), ['id'=>'eq_inversion','class'=>'form-control','readonly']) }}
							  		</div>
						  		</div>
						  		<div class="row form-group">
									<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
										{{ Form::label('eq_actividad','Actividad') }}
										{{ Form::select('eq_actividad',[], null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
										{{ Form::label('eq_descripcion','Descripción') }}
										{{ Form::text('eq_descripcion', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
										{{ Form::label('eq_unidad','Unidad') }}
										{{ Form::text('eq_unidad', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
										{{ Form::label('eq_cantidad','Cantidad') }}
										{{ Form::number('eq_cantidad', null, ['class'=>'form-control','min'=>'0']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
										{{ Form::label('eq_costo_unitario','Costo por unidad') }}
										{{ Form::number('eq_costo_unitario', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
									</div>

									<div class="form-group col-md-4">
										{{ Form::label('','&zwnj;&zwnj;') }}
										<div class="btn btn-primary btn-block" onclick="agregarInfEQ()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
									</div>
								</div>
					
								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Actividad</th>
											<th>Descripcion</th>
											<th>Unidad</th>
											<th>Cantidad</th>
											<th>Costo por unidad</th>
											<th>Subtotal</th>
											<th></th>
										</tr>
										<tbody class="eq_table">
											@if(Input::old('eq_actividades'))
												@foreach(Input::old('eq_actividades') as $key => $req)
													<tr>
														<td><input class="cell" name='eq_actividades[]' value='{{$req}}' readonly/></td>
														<td><input class="cell" name='eq_descripciones[]' value='{{Input::old('eq_descripciones')[$key]}}' readonly/></td>
														<td><input class="cell" name='eq_unidades[]' value='{{Input::old('eq_unidades')[$key]}}' readonly/></td>
														<td><input class="cell" name='eq_cantidades[]' value='{{Input::old('eq_cantidades')[$key]}}' readonly/></td>
														<td><input class="cell" name='eq_costos_unitarios[]' value='{{Input::old('eq_costos_unitarios')[$key]}}' readonly/></td>
														<td><input class="cell" value='{{Input::old('eq_cantidades')[$key]*Input::old('eq_costos_unitarios')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfEQ(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
										</tbody>
										<th>TOTAL: S/. <input class="cell" name="eq_total" value="{{0+Input::old('eq_total')}}" id="eq_total" readonly/></th>
									</table>
								</div>
							</div>

							<div class="panel-heading">
								<h3 class="panel-title">Gastos operativos</h3>
							</div>

						  	<div class="panel-body">
						  		<div class="row form-group">
							  		<div class="col-md-4">
							  			{{ Form::label('go_inversion','Inversión disponible') }}
										{{ Form::text('go_inversion', Input::old('go_inversion'), ['id'=>'go_inversion','class'=>'form-control','readonly']) }}
							  		</div>
						  		</div>
						  		<div class="row form-group">
									<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
										{{ Form::label('go_actividad','Actividad') }}
										{{ Form::select('go_actividad',[], null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
										{{ Form::label('go_descripcion','Descripción') }}
										{{ Form::text('go_descripcion', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
										{{ Form::label('go_unidad','Unidad') }}
										{{ Form::text('go_unidad', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
										{{ Form::label('go_cantidad','Cantidad') }}
										{{ Form::number('go_cantidad', null, ['class'=>'form-control','min'=>'0']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
										{{ Form::label('go_costo_unitario','Costo por unidad') }}
										{{ Form::number('go_costo_unitario', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
									</div>

									<div class="form-group col-md-4">
										{{ Form::label('','&zwnj;&zwnj;') }}
										<div class="btn btn-primary btn-block" onclick="agregarInfGO()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
									</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Actividad</th>
											<th>Descripcion</th>
											<th>Unidad</th>
											<th>Cantidad</th>
											<th>Costo por unidad</th>
											<th>Subtotal</th>
											<th></th>
										</tr>
										<tbody class="go_table">
											@if(Input::old('go_actividades'))
												@foreach(Input::old('go_actividades') as $key => $req)
													<tr>
														<td><input class="cell" name='go_actividades[]' value='{{$req}}' readonly/></td>
														<td><input class="cell" name='go_descripciones[]' value='{{Input::old('go_descripciones')[$key]}}' readonly/></td>
														<td><input class="cell" name='go_unidades[]' value='{{Input::old('go_unidades')[$key]}}' readonly/></td>
														<td><input class="cell" name='go_cantidades[]' value='{{Input::old('go_cantidades')[$key]}}' readonly/></td>
														<td><input class="cell" name='go_costos_unitarios[]' value='{{Input::old('go_costos_unitarios')[$key]}}' readonly/></td>
														<td><input class="cell" value='{{Input::old('go_cantidades')[$key]*Input::old('go_costos_unitarios')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGO(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
										</tbody>
										<th>TOTAL: S/. <input class="cell" name="go_total" value="{{0+Input::old('go_total')}}" id="go_total" readonly/></th>
									</table>
								</div>
							</div>

							<div class="panel-heading">
								<h3 class="panel-title">Gastos administrativos y gestión</h3>
							</div>

						  	<div class="panel-body">
						  		<div class="row form-group">
							  		<div class="col-md-4">
							  			{{ Form::label('ga_inversion','Inversión disponible') }}
										{{ Form::text('ga_inversion', Input::old('ga_inversion'), ['id'=>'ga_inversion','class'=>'form-control','readonly']) }}
							  		</div>
						  		</div>
						  		<div class="row form-group">
									<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
										{{ Form::label('ga_actividad','Actividad') }}
										{{ Form::select('ga_actividad',[], null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
										{{ Form::label('ga_descripcion','Descripción') }}
										{{ Form::text('ga_descripcion', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
										{{ Form::label('ga_unidad','Unidad') }}
										{{ Form::text('ga_unidad', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
										{{ Form::label('ga_cantidad','Cantidad') }}
										{{ Form::number('ga_cantidad', null, ['class'=>'form-control','min'=>'0']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
										{{ Form::label('ga_costo_unitario','Costo por unidad') }}
										{{ Form::number('ga_costo_unitario', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
									</div>

									<div class="form-group col-md-4">
										{{ Form::label('','&zwnj;&zwnj;') }}
										<div class="btn btn-primary btn-block" onclick="agregarInfGA()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
									</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Actividad</th>
											<th>Descripcion</th>
											<th>Unidad</th>
											<th>Cantidad</th>
											<th>Costo por unidad</th>
											<th>Subtotal</th>
											<th></th>
										</tr>
										<tbody class="ga_table">
											@if(Input::old('ga_actividades'))
												@foreach(Input::old('ga_actividades') as $key => $req)
													<tr>
														<td><input class="cell" name='ga_actividades[]' value='{{$req}}' readonly/></td>
														<td><input class="cell" name='ga_descripciones[]' value='{{Input::old('ga_descripciones')[$key]}}' readonly/></td>
														<td><input class="cell" name='ga_unidades[]' value='{{Input::old('ga_unidades')[$key]}}' readonly/></td>
														<td><input class="cell" name='ga_cantidades[]' value='{{Input::old('ga_cantidades')[$key]}}' readonly/></td>
														<td><input class="cell" name='ga_costos_unitarios[]' value='{{Input::old('ga_costos_unitarios')[$key]}}' readonly/></td>
														<td><input class="cell" value='{{Input::old('ga_cantidades')[$key] * Input::old('ga_costos_unitarios')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGA(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
										</tbody>
										<th>TOTAL: S/. <input class="cell" name="ga_total" value="{{0+Input::old('ga_total')}}" id="ga_total" readonly/></th>
									</table>
								</div>
							</div>
						</div>
				    </div>

				    <div class="tab-pane" id="tab_create_fase_post">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Recursos Humanos</h3>
							</div>

						  	<div class="panel-body">
						  		<div class="row form-group">
							  		<div class="col-md-4">
							  			{{ Form::label('rh_inversion_post','Inversión disponible') }}
										{{ Form::text('rh_inversion_post', Input::old('rh_inversion_post'), ['id'=>'rh_inversion_post','class'=>'form-control','readonly']) }}
							  		</div>
						  		</div>
						  		<div class="row form-group">
									<div class="form-group col-md-4 @if($errors->first('rh_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('rh_actividad_post','Actividad') }}
										{{ Form::select('rh_actividad_post',[], null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('rh_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('rh_descripcion_post','Descripción') }}
										{{ Form::text('rh_descripcion_post', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('rh_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('rh_unidad_post','Unidad') }}
										{{ Form::text('rh_unidad_post', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('rh_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('rh_cantidad_post','Cantidad') }}
										{{ Form::number('rh_cantidad_post', null, ['class'=>'form-control','min'=>'0']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('rh_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('rh_costo_unitario_post','Costo por unidad') }}
										{{ Form::number('rh_costo_unitario_post', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
									</div>

									<div class="form-group col-md-4">
										{{ Form::label('','&zwnj;&zwnj;') }}
										<div class="btn btn-primary btn-block" onclick="agregarInfRH_post()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
									</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Actividad</th>
											<th>Descripcion</th>
											<th>Unidad</th>
											<th>Cantidad</th>
											<th>Costo por unidad</th>
											<th>Subtotal</th>
											<th></th>
										</tr>
										<tbody class="rh_table_post">
											@if(Input::old('rh_actividades_post'))
												@foreach(Input::old('rh_actividades_post') as $key => $req)
													<tr>
														<td><input class="cell" name='rh_actividades_post[]' value='{{$req}}' readonly/></td>
														<td><input class="cell" name='rh_descripciones_post[]' value='{{Input::old('rh_descripciones_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='rh_unidades_post[]' value='{{Input::old('rh_unidades_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='rh_cantidades_post[]' value='{{Input::old('rh_cantidades_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='rh_costos_unitarios_post[]' value='{{Input::old('rh_costos_unitarios_post')[$key]}}' readonly/></td>
														<td><input class="cell" value='{{Input::old('rh_cantidades_post')[$key]*Input::old('rh_costos_unitarios_post')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfRH_post(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
										</tbody>
										<th>TOTAL: S/. <input class="cell" name="rh_total_post" value="{{0+Input::old('rh_total_post')}}" id="rh_total_post" readonly/></th>
									</table>
								</div>
							</div>

							<div class="panel-heading">
								<h3 class="panel-title">Equipos y bienes duraderos</h3>
							</div>

						  	<div class="panel-body">
						  		<div class="row form-group">
							  		<div class="col-md-4">
							  			{{ Form::label('eq_inversion_post','Inversión disponible') }}
										{{ Form::text('eq_inversion_post', Input::old('eq_inversion_post'), ['id'=>'eq_inversion_post','class'=>'form-control','readonly']) }}
							  		</div>
						  		</div>
						  		<div class="row form-group">
									<div class="form-group col-md-4 @if($errors->first('eq_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('eq_actividad_post','Actividad') }}
										{{ Form::select('eq_actividad_post',[], null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('eq_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('eq_descripcion_post','Descripción') }}
										{{ Form::text('eq_descripcion_post', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('eq_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('eq_unidad_post','Unidad') }}
										{{ Form::text('eq_unidad_post', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('eq_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('eq_cantidad_post','Cantidad') }}
										{{ Form::number('eq_cantidad_post', null, ['class'=>'form-control','min'=>'0']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('eq_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('eq_costo_unitario_post','Costo por unidad') }}
										{{ Form::number('eq_costo_unitario_post', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
									</div>

									<div class="form-group col-md-4">
										{{ Form::label('','&zwnj;&zwnj;') }}
										<div class="btn btn-primary btn-block" onclick="agregarInfEQ_post()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
									</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Actividad</th>
											<th>Descripcion</th>
											<th>Unidad</th>
											<th>Cantidad</th>
											<th>Costo por unidad</th>
											<th>Subtotal</th>
											<th></th>
										</tr>
										<tbody class="eq_table_post">
											@if(Input::old('eq_actividades_post'))
												@foreach(Input::old('eq_actividades_post') as $key => $req)
													<tr>
														<td><input class="cell" name='eq_actividades_post[]' value='{{$req}}' readonly/></td>
														<td><input class="cell" name='eq_descripciones_post[]' value='{{Input::old('eq_descripciones_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='eq_unidades_post[]' value='{{Input::old('eq_unidades_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='eq_cantidades_post[]' value='{{Input::old('eq_cantidades_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='eq_costos_unitarios_post[]' value='{{Input::old('eq_costos_unitarios_post')[$key]}}' readonly/></td>
														<td><input class="cell" value='{{Input::old('eq_cantidades_post')[$key]*Input::old('eq_costos_unitarios_post')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfEQ_post(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
										</tbody>
										<th>TOTAL: S/. <input class="cell" name="eq_total_post" value="{{0+Input::old('eq_total_post')}}" id="eq_total_post" readonly/></th>
									</table>
								</div>
							</div>

							<div class="panel-heading">
								<h3 class="panel-title">Gastos operativos</h3>
							</div>

	  						<div class="panel-body">
						  		<div class="row form-group">
							  		<div class="col-md-4">
							  			{{ Form::label('go_inversion_post','Inversión disponible') }}
										{{ Form::text('go_inversion_post', Input::old('go_inversion_post'), ['id'=>'go_inversion_post','class'=>'form-control','readonly']) }}
							  		</div>
						  		</div>
						  		<div class="row form-group">
									<div class="form-group col-md-4 @if($errors->first('go_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('go_actividad_post','Actividad') }}
										{{ Form::select('go_actividad_post',[], null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('go_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('go_descripcion_post','Descripción') }}
										{{ Form::text('go_descripcion_post', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('go_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('go_unidad_post','Unidad') }}
										{{ Form::text('go_unidad_post', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('go_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('go_cantidad_post','Cantidad') }}
										{{ Form::number('go_cantidad_post', null, ['class'=>'form-control','min'=>'0']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('go_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('go_costo_unitario_post','Costo por unidad') }}
										{{ Form::number('go_costo_unitario_post', null, ['class'=>'form-control','step'=>'0.1','min'=>'0']) }}
									</div>

									<div class="form-group col-md-4">
										{{ Form::label('','&zwnj;&zwnj;') }}
										<div class="btn btn-primary btn-block" onclick="agregarInfGO_post()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
									</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Actividad</th>
											<th>Descripcion</th>
											<th>Unidad</th>
											<th>Cantidad</th>
											<th>Costo por unidad</th>
											<th>Subtotal</th>
											<th></th>
										</tr>
										<tbody class="go_table_post">
											@if(Input::old('go_actividades_post'))
												@foreach(Input::old('go_actividades_post') as $key => $req)
													<tr>
														<td><input class="cell" name='go_actividades_post[]' value='{{$req}}' readonly/></td>
														<td><input class="cell" name='go_descripciones_post[]' value='{{Input::old('go_descripciones_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='go_unidades_post[]' value='{{Input::old('go_unidades_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='go_cantidades_post[]' value='{{Input::old('go_cantidades_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='go_costos_unitarios_post[]' value='{{Input::old('go_costos_unitarios_post')[$key]}}' readonly/></td>
														<td><input class="cell" value='{{Input::old('go_cantidades_post')[$key]*Input::old('go_costos_unitarios_post')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGO_post(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
										</tbody>
										<th>TOTAL: S/. <input class="cell" name="go_total_post" value="{{0+Input::old('go_total_post')}}" id="go_total_post" readonly/></th>
									</table>
								</div>
							</div>

							<div class="panel-heading">
								<h3 class="panel-title">Gastos administrativos y gestión</h3>
							</div>

						  	<div class="panel-body">
						  		<div class="row form-group">
							  		<div class="col-md-4">
							  			{{ Form::label('ga_inversion_post','Inversión disponible') }}
										{{ Form::text('ga_inversion_post', Input::old('ga_inversion_post'), ['id'=>'ga_inversion_post','class'=>'form-control','readonly']) }}
							  		</div>
						  		</div>
						  		<div class="row form-group">
									<div class="form-group col-md-4 @if($errors->first('ga_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('ga_actividad_post','Actividad') }}
										{{ Form::select('ga_actividad_post',[], null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('ga_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('ga_descripcion_post','Descripción') }}
										{{ Form::text('ga_descripcion_post', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('ga_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('ga_unidad_post','Unidad') }}
										{{ Form::text('ga_unidad_post', null, ['class'=>'form-control']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('ga_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('ga_cantidad_post','Cantidad') }}
										{{ Form::number('ga_cantidad_post', null, ['class'=>'form-control','min'=>'0']) }}
									</div>
									<div class="form-group col-md-4 @if($errors->first('ga_actividades_post')) has-error has-feedback @endif">
										{{ Form::label('ga_costo_unitario_post','Costo por unidad') }}
										{{ Form::number('ga_costo_unitario_post', null, ['class'=>'form-control','step'=>'0.01','min'=>'0']) }}
									</div>

									<div class="form-group col-md-4">
										{{ Form::label('','&zwnj;&zwnj;') }}
										<div class="btn btn-primary btn-block" onclick="agregarInfGA_post()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
									</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Actividad</th>
											<th>Descripcion</th>
											<th>Unidad</th>
											<th>Cantidad</th>
											<th>Costo por unidad</th>
											<th>Subtotal</th>
											<th></th>
										</tr>
										<tbody class="ga_table_post">
											@if(Input::old('ga_actividades_post'))
												@foreach(Input::old('ga_actividades_post') as $key => $req)
													<tr>
														<td><input class="cell" name='ga_actividades_post[]' value='{{$req}}' readonly/></td>
														<td><input class="cell" name='ga_descripciones_post[]' value='{{Input::old('ga_descripciones_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='ga_unidades_post[]' value='{{Input::old('ga_unidades_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='ga_cantidades_post[]' value='{{Input::old('ga_cantidades_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='ga_costos_unitarios_post[]' value='{{Input::old('ga_costos_unitarios_post')[$key]}}' readonly/></td>
														<td><input class="cell" value='{{Input::old('ga_cantidades_post')[$key]*Input::old('ga_costos_unitarios_post')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowInfGA_post(event,this)'>Eliminar</a></td></tr>
													</tr>
												@endforeach
											@endif
										</tbody>
										<th>TOTAL: S/. <input class="cell" name="ga_total_post" value="{{0+Input::old('ga_total_post')}}" id="ga_total_post" readonly/></th>
									</table>
								</div>
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