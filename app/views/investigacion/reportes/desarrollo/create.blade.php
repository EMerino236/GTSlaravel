@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Estudio de linea base</h3>
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
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('objetivos') }}</strong></p>
			<p><strong>{{ $errors->first('indicadores') }}</strong></p>
			<p><strong>{{ $errors->first('ind_nombres') }}</strong></p>
			<p><strong>{{ $errors->first('ind_bases') }}</strong></p>
			<p><strong>{{ $errors->first('ind_unidades') }}</strong></p>
			<p><strong>{{ $errors->first('ind_definiciones') }}</strong></p>
			<p><strong>{{ $errors->first('ind_verificaciones') }}</strong></p>

		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>'reporte_desarrollo.store', 'role'=>'form')) }}
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
						{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Validar', array('id'=>'submit_create', 'class' => 'btn btn-primary btn-block','onClick'=>'validarReporteDesarrollo()')) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', Input::old('categoria'), ['class'=>'form-control']) }}
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
			</div>

			<div class="panel-heading">
				<h3 class="panel-title">Contenido de estudio de linea base</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción de estudio de linea base') }}
						{{ Form::textarea('descripcion', Input::old('descripcion'), ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('indicadores')) has-error has-feedback @endif">
						{{ Form::label('indicadores','Indicadores de efecto e impacto') }}
						{{ Form::textarea('indicadores', Input::old('indicadores'), ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('objetivos')) has-error has-feedback @endif">
						{{ Form::label('objetivos','Objetivos del proyecto') }}
						{{ Form::textarea('objetivos', Input::old('objetivos'), ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>
			</div>			

			
			<div class="panel-heading">
				<h3 class="panel-title">Indicadores de linea base relacionados directamente a las actividades del proyecto</h3>
			</div>
			<div class="panel-body">
				@foreach($dimensiones as $dimension)
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="input-group">
							<span class="input-group-addon"><b>Dimensión</b></span>
							{{ Form::text('dimension'.$dimension->id, $dimension->nombre, ['class'=>'form-control','readonly']) }}
						</div>
					</div>
					<div class="panel-body">
						<div class="row">

							<div class="form-group col-md-4">
								{{ Form::label('ind_nombre'.$dimension->id,'Nombre de indicador') }}
								{{ Form::text('ind_nombre'.$dimension->id, null, ['class'=>'form-control']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('ind_base'.$dimension->id,'Indicador de base') }}
								{{ Form::text('ind_base'.$dimension->id, null, ['class'=>'form-control']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('ind_unidad'.$dimension->id,'Unidad') }}
								{{ Form::text('ind_unidad'.$dimension->id, null, ['class'=>'form-control']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('ind_definicion'.$dimension->id,'Definición del indicador') }}
								{{ Form::text('ind_definicion'.$dimension->id, null, ['class'=>'form-control']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('ind_verificacion'.$dimension->id,'Medio de verificación') }}
								{{ Form::text('ind_verificacion'.$dimension->id, null, ['class'=>'form-control']) }}
							</div>

							<div class="form-group col-md-4">
								{{ Form::label('','&zwnj;&zwnj;') }}
								<button class="btn btn-primary btn-block" type="button" onClick="agregaFila(this,{{$dimension->id}})"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
							</div>

							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Nombre</th>
										<th>Base</th>
										<th>Unidad</th>
										<th>Definición</th>
										<th>Medio</th>
										<th></th>
									</tr>
									<tbody class="ind_table{{$dimension->id}}">
										@if(isset(Input::old('ind_nombres')[$dimension->id]))
											@foreach(Input::old('ind_nombres')[$dimension->id] as $keyD => $dato)
												<tr>
													<td><input class="cell" name='ind_nombres[{{$dimension->id}}][]' value='{{$dato}}' readonly/></td>
													<td><input class="cell" name='ind_bases[{{$dimension->id}}][]' value='{{Input::old('ind_bases')[$dimension->id][$keyD]}}' readonly/></td>
													<td><input class="cell" name='ind_unidades[{{$dimension->id}}][]' value='{{Input::old('ind_unidades')[$dimension->id][$keyD]}}' readonly/></td>
													<td><input class="cell" name='ind_definiciones[{{$dimension->id}}][]' value='{{Input::old('ind_definiciones')[$dimension->id][$keyD]}}' readonly/></td>
													<td><input class="cell" name='ind_verificaciones[{{$dimension->id}}][]' value='{{Input::old('ind_verificaciones')[$dimension->id][$keyD]}}' readonly/></td>
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
				@endforeach
			</div>	
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>

	{{ Form::close() }}


@stop