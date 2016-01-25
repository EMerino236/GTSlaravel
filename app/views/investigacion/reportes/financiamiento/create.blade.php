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
			<p><strong>{{ $errors->first('costo_beneficio') }}</strong></p>
			<p><strong>{{ $errors->first('cronograma_desc') }}</strong></p>
			<p><strong>{{ $errors->first('cronograma_ini') }}</strong></p>
			<p><strong>{{ $errors->first('cronograma_fin') }}</strong></p>
			<p><strong>{{ $errors->first('inversion_desc') }}</strong></p>
			<p><strong>{{ $errors->first('inversion_costo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>'reporte_financiamiento.store', 'role'=>'form')) }}
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
						{{ Form::text('categoria', null, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::text('servicio_clinico', null, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::text('departamento', null, ['class'=>'form-control']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable') }}
						{{ Form::text('responsable', null, ['class'=>'form-control']) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}
						{{ Form::textarea('nombre', null, ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('objetivos')) has-error has-feedback @endif">
						{{ Form::label('objetivos','Objetivos') }}
						{{ Form::textarea('objetivos', null, ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						{{ Form::label('cronograma','Cronograma del Proyecto') }}
						<div class="table-responsive">
							<table class="table">
								<tr class="info">
									<th class="text-nowrap text-center">Descripción</th>
									<th class="text-nowrap text-center">Fecha Inicio</th>
									<th class="text-nowrap text-center">Fecha Fin</th>
								</tr>
								<tr>
									<td class="text-nowrap text-center">
										{{ Form::text('cronograma_desc[]', null, ['class'=>'form-control']) }}
									</td>
									<td class="text-nowrap text-center">
										{{ Form::text('cronograma_ini[]', null, ['class'=>'form-control']) }}
									</td>
									<td class="text-nowrap text-center">
										{{ Form::text('cronograma_fin[]', null, ['class'=>'form-control']) }}
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('impacto')) has-error has-feedback @endif">
						{{ Form::label('impacto','Impacto') }}
						{{ Form::textarea('impacto', null, ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						{{ Form::label('inversion','Inversión') }}
						<div class="table-responsive">
							<table class="table">
								<tr class="info">
									<th class="text-nowrap text-center">Descripción</th>
									<th class="text-nowrap text-center">Costo</th>
								</tr>
								<tr>
									<td class="text-nowrap text-center">
										{{ Form::text('inversion_desc[]', null, ['class'=>'form-control']) }}
									</td>
									<td class="text-nowrap text-center">
										{{ Form::text('inversion_costo[]', null, ['class'=>'form-control']) }}
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('costo_beneficio')) has-error has-feedback @endif">
						{{ Form::label('costo_beneficio','Costo Beneficio') }}
						{{ Form::textarea('costo_beneficio', null, ['class'=>'form-control','rows'=>5]) }}
					</div>
				</div>

				<!--
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('fecha_publicacion')) has-error has-feedback @endif">
						{{ Form::label('fecha_publicacion','Año de publicación') }}
						<div id="datetimepicker_create_gpc" class="form-group input-group date @if($errors->first('fecha_publicacion')) has-error has-feedback @endif">
							{{ Form::text('fecha_publicacion',Input::old('fecha_publicacion'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>

					<div class="form-group col-md-4 @if($errors->first('autor')) has-error has-feedback @endif">
						{{ Form::label('autor','Autor') }}
						
						{{ Form::text('autor',$user->nombre." ".$user->apellido_pat." ".$user->apellido_mat,array('class'=>'form-control','readonly')) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre de Documento') }}
						
						{{ Form::text('nombre', null,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}
						{{ Form::text('descripcion',Input::old('descripcion'),array('class'=>'form-control')) }}
					</div>
				</div>
				-->
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>

	{{ Form::close() }}	

@stop