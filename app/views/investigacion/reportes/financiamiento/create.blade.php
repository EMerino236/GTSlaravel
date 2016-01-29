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
						<div class="panel panel-default">
							<div class="panel-heading">
							    	<h3 class="panel-title">Cronograma</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-3">
									{{ Form::label('descripcion','Descripción') }}
									{{ Form::text('descripcion', null, ['class'=>'form-control']) }}
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
										<tbody class="crono_table"></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{Form::hidden('crono_desc')}}
				{{Form::hidden('crono_fecha_ini')}}
				{{Form::hidden('crono_fecha_fin')}}

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
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>

	{{ Form::close() }}	

@stop