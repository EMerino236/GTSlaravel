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

			<!--WIP FALTAN MAs -->
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
				<div class="row">
					<div class="form-group col-md-8">
						<div class="input-group">
							<span class="input-group-addon">Dimensión</span>
							{{ Form::text('dimension', null, ['class'=>'form-control']) }}
						</div>
					</div>
				</div>

				<div class="row">

					<div class="form-group col-md-4">
						{{ Form::label('ind_nombre','Nombre de indicador') }}
						{{ Form::text('ind_nombre', null, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4">
						{{ Form::label('ind_base','Indicador de base') }}
						{{ Form::text('ind_base', null, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4">
						{{ Form::label('ind_unidad','Unidad') }}
						{{ Form::text('ind_unidad', null, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4">
						{{ Form::label('ind_definicion','Definición del indicador') }}
						{{ Form::text('ind_definicion', null, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4">
						{{ Form::label('ind_verificacion','Medio de verificación') }}
						{{ Form::text('ind_verificacion', null, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4">
						{{ Form::label('','&zwnj;&zwnj;') }}
						<div class="btn btn-primary btn-block" id="btnAgregarInd"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
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
							<tbody class="ind_table">
								@if(Input::old('ind_nombres'))
									@foreach(Input::old('ind_nombres') as $key => $nomb)
										<tr>
											<td><input class="cell" name='ind_nombres[]' value='{{$nomb}}' readonly/></td>
											<td><input class="cell" name='ind_bases[]' value='{{Input::old('bases')[$key]}}' readonly/></td>
											<td><input class="cell" name='ind_unidades[]' value='{{Input::old('unidades')[$key]}}' readonly/></td>
											<td><input class="cell" name='ind_definiciones[]' value='{{Input::old('definiciones')[$key]}}' readonly/></td>
											<td><input class="cell" name='ind_verificaciones[]' value='{{Input::old('verificaciones')[$key]}}' readonly/></td>
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

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>

	{{ Form::close() }}


@stop