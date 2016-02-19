@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Presupuesto</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			<p><strong>{{ $errors->first('rh_actividades') }}</strong></p>
			<p><strong>{{ $errors->first('rh_descripciones') }}</strong></p>
			<p><strong>{{ $errors->first('rh_unidades') }}</strong></p>
			<p><strong>{{ $errors->first('rh_cantidades') }}</strong></p>
			<p><strong>{{ $errors->first('rh_costos_unitarios') }}</strong></p>

			<p><strong>{{ $errors->first('eq_actividades') }}</strong></p>
			<p><strong>{{ $errors->first('eq_descripciones') }}</strong></p>
			<p><strong>{{ $errors->first('eq_unidades') }}</strong></p>
			<p><strong>{{ $errors->first('eq_cantidades') }}</strong></p>
			<p><strong>{{ $errors->first('eq_costos_unitarios') }}</strong></p>

			<p><strong>{{ $errors->first('go_actividades') }}</strong></p>
			<p><strong>{{ $errors->first('go_descripciones') }}</strong></p>
			<p><strong>{{ $errors->first('go_unidades') }}</strong></p>
			<p><strong>{{ $errors->first('go_cantidades') }}</strong></p>
			<p><strong>{{ $errors->first('go_costos_unitarios') }}</strong></p>

			<p><strong>{{ $errors->first('ga_actividades') }}</strong></p>
			<p><strong>{{ $errors->first('ga_descripciones') }}</strong></p>
			<p><strong>{{ $errors->first('ga_unidades') }}</strong></p>
			<p><strong>{{ $errors->first('ga_cantidades') }}</strong></p>
			<p><strong>{{ $errors->first('ga_costos_unitarios') }}</strong></p>

		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>['proyecto_presupuesto.update',$presupuesto->id], 'role'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informacion general del presupuesto</h3>
			</div>
			<div class="panel-body">
				
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('id_reporte','Código de proyecto') }}
						{{ Form::text('codigo', $presupuesto->proyecto->codigo, ['class'=>'form-control','readonly']) }}
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-4 ">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', $presupuesto->nombre, ['class'=>'form-control', 'readonly']) }}
					</div>

					<div class="form-group col-md-4 ">
						{{ Form::label('categoria','Categoría') }}
						{{ Form::text('categoria', $categorias[$presupuesto->id_categoria], ['class'=>'form-control', 'readonly']) }}
					</div>

					<div class="form-group col-md-4 ">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::text('departamento', $departamentos[$presupuesto->id_departamento], ['id'=>'departamento','class'=>'form-control', 'readonly']) }}
					</div>

					<div class="form-group col-md-4 ">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::text('servicio_clinico', $servicios[$presupuesto->id_servicio_clinico], ['id'=>'servicio_clinico','class'=>'form-control', 'readonly']) }}
					</div>

					<div class="form-group col-md-4 ">
						{{ Form::label('responsable','Responsable') }}
						{{ Form::text('responsable',$usuarios[$presupuesto->id_responsable],['class'=>'form-control', 'readonly'])}}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('tipo','Tipo') }}
						{{ Form::text('tipo',$tipos[$id_tipo],['class'=>'form-control','readonly'])}}
						{{ Form::hidden('id_tipo',$id_tipo)}}
					</div>

				</div>

				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('fecha_ini','Fecha Inicio') }}
						{{ Form::text('fecha_ini',$presupuesto->fecha_ini,array('class'=>'form-control', 'readonly'=>'')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('fecha_fin','Fecha Fin') }}
						{{ Form::text('fecha_fin',$presupuesto->fecha_fin,array('class'=>'form-control', 'readonly'=>'')) }}
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-4 form-group">
						{{ Form::label('total_inversion','Total disponible por inversion') }}
						{{ Form::text('total_inversion', 0+$presupuesto->monto_restante ,['id'=>'total_inv','class'=>'form-control','readonly'])}}	
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Recursos Humanos</h3>
					</div>

				  	<div class="panel-body">
						<div class="form-group col-md-4 @if($errors->first('rh_actividades')) has-error has-feedback @endif">
							{{ Form::label('rh_actividad','Actividad') }}
							{{ Form::text('rh_actividad', null, ['class'=>'form-control']) }}
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
							<div class="btn btn-primary btn-block" onclick="agregarProyRH()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
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
												<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyRH(event,this)'>Eliminar</a></td></tr>
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
						<div class="form-group col-md-4 @if($errors->first('eq_actividades')) has-error has-feedback @endif">
							{{ Form::label('eq_actividad','Actividad') }}
							{{ Form::text('eq_actividad', null, ['class'=>'form-control']) }}
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
							<div class="btn btn-primary btn-block" onclick="agregarProyEQ()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
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
												<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyEQ(event,this)'>Eliminar</a></td></tr>
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
						<div class="form-group col-md-4 @if($errors->first('go_actividades')) has-error has-feedback @endif">
							{{ Form::label('go_actividad','Actividad') }}
							{{ Form::text('go_actividad', null, ['class'=>'form-control']) }}
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
							<div class="btn btn-primary btn-block" onclick="agregarProyGO()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
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
												<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyGO(event,this)'>Eliminar</a></td></tr>
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
						<div class="form-group col-md-4 @if($errors->first('ga_actividades')) has-error has-feedback @endif">
							{{ Form::label('ga_actividad','Actividad') }}
							{{ Form::text('ga_actividad', null, ['class'=>'form-control']) }}
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
							<div class="btn btn-primary btn-block" onclick="agregarProyGA()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
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
												<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowProyGA(event,this)'>Eliminar</a></td></tr>
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
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>

			<div class="form-group col-md-2">
				<a class="btn-under" href="{{route('proyecto_presupuesto.show',$presupuesto->id_proyecto)}}">
					{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
				</a>
			</div>
		</div>

	{{ Form::close() }}


@stop