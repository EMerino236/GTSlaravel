@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte que certifica la problemática e identificación de financiamiento</h3>
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
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('objetivos') }}</strong></p>
			<p><strong>{{ $errors->first('impacto') }}</strong></p>
			<p><strong>{{ $errors->first('duracion') }}</strong></p>
			<p><strong>{{ $errors->first('costo_beneficio') }}</strong></p>
			<p><strong>{{ $errors->first('crono_descripciones') }}</strong></p>
			<p><strong>{{ $errors->first('fechas_ini') }}</strong></p>
			<p><strong>{{ $errors->first('fechas_fin') }}</strong></p>
			<p><strong>{{ $errors->first('inv_descripciones') }}</strong></p>
			<p><strong>{{ $errors->first('costos') }}</strong></p>
			<p><strong>{{ $errors->first('duraciones') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>'reporte_financiamiento.store', 'role'=>'form','id'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información del proyecto</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', null, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('categoria')) has-error has-feedback @endif">
						{{ Form::label('categoria','Categoría') }}
						{{ Form::select('categoria', $categorias, null, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::select('departamento', $departamentos, null, ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::select('servicio_clinico', [], null, ['id'=>'servicio_clinico','class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable') }}
						{{ Form::select('responsable',$usuarios,null,['class'=>'form-control'])}}
					</div>
					<div class="form-group col-md-4 @if($errors->first('duracion')) has-error has-feedback @endif">
						{{ Form::label('duracion','Duración') }}
						{{ Form::number('duracion',null,['class'=>'form-control','readonly'])}}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}
						{{ Form::textarea('descripcion', null, ['class'=>'form-control','rows'=>5]) }}
					</div>
					<div class="form-group col-md-6 @if($errors->first('objetivos')) has-error has-feedback @endif">
						{{ Form::label('objetivos','Objetivos') }}
						{{ Form::textarea('objetivos', null, ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
							    	<h3 class="panel-title">Cronograma</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-3">
									{{ Form::label('crono_descripcion','Descripción') }}
									{{ Form::text('crono_descripcion', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-3">
									{{ Form::label('fecha_ini','Fecha Inicio') }}
									<div id="datetimepicker_cronograma_ini" class="form-group input-group date">
										{{ Form::text('fecha_ini',Input::old('cronograma_ini'),array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>

								<div class="form-group col-md-3">
									{{ Form::label('fecha_fin','Fecha Fin') }}
									<div id="datetimepicker_cronograma_fin" class="form-group input-group date">
										{{ Form::text('fecha_fin',Input::old('cronograma_fin'),array('class'=>'form-control', 'readonly'=>'')) }}
										<span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
									</div>
								</div>

								<div class="form-group col-md-3">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" id="btnAgregarCrono"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Descripción</th>
											<th>Fecha Inicio</th>
											<th>Fecha Fin</th>
											<th>Duración</th>
											<th></th>
										</tr>
										<tbody class="crono_table">
											@if(Input::old('crono_descripciones'))
												@foreach(Input::old('crono_descripciones') as $key => $desc)
													<tr>
														<td><input style="border:0" name='crono_descripciones[]' value='{{$desc}}' readonly/></td>
														<td><input style="border:0" name='fechas_ini[]' value='{{Input::old('fechas_ini')[$key]}}' readonly/></td>
														<td><input style="border:0" name='fechas_fin[]' value='{{Input::old('fechas_fin')[$key]}}' readonly/></td>
														<td><input style="border:0" name='duraciones[]' value='{{Input::old('duraciones')[$key]}}' readonly/></td>
														<td><a href='' class='btn btn-default delete-detail' onclick='deleteRowCrono(event,this)'>Eliminar</a></td></tr>
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
					<div class="form-group col-md-6 @if($errors->first('impacto')) has-error has-feedback @endif">
						{{ Form::label('impacto','Impacto') }}
						{{ Form::textarea('impacto', null, ['class'=>'form-control','rows'=>5]) }}
					</div>
					<div class="form-group col-md-6 @if($errors->first('costo_beneficio')) has-error has-feedback @endif">
						{{ Form::label('costo_beneficio','Costo Beneficio') }}
						{{ Form::textarea('costo_beneficio', null, ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
							    	<h3 class="panel-title">Inversión</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-4">
									{{ Form::label('inv_descripcion','Descripción') }}
									{{ Form::text('inv_descripcion', null, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('costo','Costo') }}
									{{ Form::number('costo',Input::old('costo'),array('class'=>'form-control')) }}
								</div>

								<div class="form-group col-md-4">
									{{ Form::label('','&zwnj;&zwnj;') }}
									<div class="btn btn-primary btn-block" id="btnAgregarInv"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
								</div>

								<div class="col-md-12">
									<table class="table">
										<tr class="info">
											<th>Descripción</th>
											<th>Costo</th>
											<th></th>
										</tr>
										<tbody class="inv_table">
											@if(Input::old('inv_descripciones'))
												@foreach(Input::old('inv_descripciones') as $key => $desc)
													<tr>
														<td><input style="border:0" name='inv_descripciones[]' value='{{$desc}}' readonly/></td>
														<td><input style="border:0" name='costos[]' value='{{Input::old('costos')[$key]}}' readonly/></td>
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

	<script type="text/javascript">
		window.onload = function() {
	        getServicios(document.getElementById("departamento"));
	    };
	</script>

@stop