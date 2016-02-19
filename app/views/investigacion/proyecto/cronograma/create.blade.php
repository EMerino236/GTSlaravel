@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Cronograma</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('actividades') }}</strong></p>
			<p><strong>{{ $errors->first('descripciones') }}</strong></p>
			<p><strong>{{ $errors->first('duraciones') }}</strong></p>
			<p><strong>{{ $errors->first('actividades_previas') }}</strong></p>
			<p><strong>{{ $errors->first('fechas_ini') }}</strong></p>
			<p><strong>{{ $errors->first('fechas_fin') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>['proyecto_cronograma.store',$proyecto->id], 'role'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Informacion general del proyecto</h3>
			</div>
			<div class="panel-body">
				
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('id_reporte','Código de proyecto') }}
						{{ Form::text('codigo', $proyecto->codigo, ['class'=>'form-control','readonly']) }}
						{{ Form::hidden('id_reporte', $proyecto->id)}}
					</div>
				</div>
				
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', $proyecto->nombre, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('categoria')) has-error has-feedback @endif">
						{{ Form::label('categoria','Categoría') }}
						{{ Form::select('categoria', $categorias, $proyecto->id_categoria, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::select('departamento', $departamentos, $proyecto->id_departamento, ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::select('servicio_clinico', $servicios, $proyecto->id_servicio_clinico, ['id'=>'servicio_clinico','class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable') }}
						{{ Form::select('responsable',$usuarios, $proyecto->id_responsable,['class'=>'form-control'])}}
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
							{{ Form::text('fecha_ini',date('dd-mm-YYYY',strtotime($proyecto->fecha_ini)),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="form-group col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
						{{ Form::label('fecha_fin','Fecha Fin') }}
						<div id="datetimepicker_desarrollo_fin" class="form-group input-group date">
							{{ Form::text('fecha_fin',date('dd-mm-YYYY',strtotime($proyecto->fecha_fin)),array('class'=>'form-control', 'readonly'=>'')) }}
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
								<h3 class="panel-title">Actividades</h3>
							</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4 @if($errors->first('actividades')) has-error has-feedback @endif">
									{{ Form::label('actividad','Actividad') }}
									{{ Form::text('actividad', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('descripciones')) has-error has-feedback @endif">
									{{ Form::label('descripcion','Descripción') }}
									{{ Form::text('descripcion', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('actividades_previas')) has-error has-feedback @endif">
									{{ Form::label('actividad_previa','Actividad Previa') }}
									{{ Form::select('actividad_previa', [0=>'Seleccione'], null, ['id'=>'actividad_previa','class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('fechas_ini')) has-error has-feedback @endif">
									{{ Form::label('crono_fecha_ini','Fecha Inicio') }}
									<div id="datetimepicker_crono_ini" class="form-group input-group date">
										{{ Form::text('crono_fecha_ini', null,array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>

								<div class="form-group col-md-4 @if($errors->first('fechas_fin')) has-error has-feedback @endif">
									{{ Form::label('crono_fecha_fin','Fecha Fin') }}
									<div id="datetimepicker_crono_fin" class="form-group input-group date">
										{{ Form::text('crono_fecha_fin', null,array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>
								

								<div class="form-group col-md-4">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" onclick="agregarCrono()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>N°</th>
											<th>Actividad</th>
											<th>Descripcion</th>
											<th>Fecha Inicio</th>
											<th>Fecha Fin</th>
											<th>Duración</th>
											<th>Actividad Previa</th>
											<th></th>
										</tr>
										<tbody class="table_pre">
											@if(Input::old('actividades'))
												@foreach(Input::old('actividades') as $key => $req)
													<tr>
														<td><input class="cell" name='actividades[]' value='{{$req}}' readonly/></td>
														<td><input class="cell" name='descripciones[]' value='{{Input::old('descripciones')[$key]}}' readonly/></td>
														<td><input class="cell" name='fechas_ini[]' value='{{Input::old('fechas_ini')[$key]}}' readonly/></td>
														<td><input class="cell" name='fechas_fin[]' value='{{Input::old('fechas_fin')[$key]}}' readonly/></td>
														<td><input class="cell" name='duraciones[]' value='{{Input::old('duraciones')[$key]}}' readonly/></td>
														<td><input class="cell" name='actividades_previas[]' value='{{Input::old('actividades_previas')[$key]}}' readonly/></td>
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

				    <div class="tab-pane" id="tab_create_fase_post">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Actividades</h3>
							</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4 @if($errors->first('actividades_post')) has-error has-feedback @endif">
									{{ Form::label('actividades_post','Actividad') }}
									{{ Form::text('actividades_post', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('descripciones_post')) has-error has-feedback @endif">
									{{ Form::label('descripcion_post','Descripción') }}
									{{ Form::text('descripcion_post', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('actividades_previas_post')) has-error has-feedback @endif">
									{{ Form::label('actividad_previa_post','Actividad Previa') }}
									{{ Form::text('actividad_previa_post', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('fechas_ini_post')) has-error has-feedback @endif">
									{{ Form::label('crono_fecha_ini_post','Fecha Inicio') }}
									<div id="datetimepicker_crono_ini_post" class="form-group input-group date">
										{{ Form::text('crono_fecha_ini_post', null,array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>

								<div class="form-group col-md-4 @if($errors->first('fechas_fin_post')) has-error has-feedback @endif">
									{{ Form::label('crono_fecha_fin_post','Fecha Fin') }}
									<div id="datetimepicker_crono_fin_post" class="form-group input-group date">
										{{ Form::text('crono_fecha_fin_post', null,array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>
								

								<div class="form-group col-md-4">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" onclick="agregarCronoPost()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Actividad</th>
											<th>Descripcion</th>
											<th>Fecha Inicio</th>
											<th>Fecha Fin</th>
											<th>Duración</th>
											<th>Actividad Previa</th>
											<th></th>
										</tr>
										<tbody class="table_post">
											@if(Input::old('actividades_post'))
												@foreach(Input::old('actividades_post') as $key => $req)
													<tr>
														<td><input class="cell" name='actividades_post[]' value='{{$req}}' readonly/></td>
														<td><input class="cell" name='descripciones_post[]' value='{{Input::old('descripciones_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='fechas_ini_post[]' value='{{Input::old('fechas_ini_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='fechas_fin_post[]' value='{{Input::old('fechas_fin_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='duraciones_post[]' value='{{Input::old('duraciones_post')[$key]}}' readonly/></td>
														<td><input class="cell" name='actividades_previas_post[]' value='{{Input::old('actividades_previas_post')[$key]}}' readonly/></td>
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
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>

	{{ Form::close() }}


@stop