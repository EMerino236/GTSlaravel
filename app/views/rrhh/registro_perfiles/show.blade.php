@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Registro de perfiles profesionales</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger alert-dissmisable" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ Session::get('error') }}</strong></p>
		</div>
	@endif

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach					
		</div>
	@endif

	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombres')) has-error has-feedback @endif">
					{{ Form::label('nombres','Nombres') }}
					{{ Form::text('nombres',$perfil->nombres,['class' => 'form-control', 'readonly'])}}
				</div>

				<div class="col-md-4 @if($errors->first('apellido_paterno')) has-error has-feedback @endif">
					{{ Form::label('apellido_paterno','Apellido Paterno') }}
					{{ Form::text('apellido_paterno', $perfil->apellido_paterno,['class' => 'form-control', 'readonly'])}}
				</div>

				<div class="col-md-4 @if($errors->first('apellido_materno')) has-error has-feedback @endif">
					{{ Form::label('apellido_materno','Apellido Materno') }}
					{{ Form::text('apellido_materno', $perfil->apellido_materno,['class' => 'form-control', 'readonly'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('dni')) has-error has-feedback @endif">
					{{ Form::label('dni','DNI') }}
					{{ Form::text('dni',$perfil->dni,['class' => 'form-control', 'readonly'])}}
				</div>

				<div class="col-md-4 @if($errors->first('pais_nacimiento')) has-error has-feedback @endif">
					{{ Form::label('pais_nacimiento','Pais de nacimiento') }}
					{{ Form::text('pais_nacimiento', $perfil->paisNacimiento->nombre,['class' => 'form-control', 'readonly'])}}
				</div>

				<div class="col-md-4 @if($errors->first('genero')) has-error has-feedback @endif">
					{{ Form::label('genero','Genero') }}
					{{ Form::text('genero',$generos[$perfil->id_genero],['class' => 'form-control', 'readonly'])}}
				</div>
			</div>
	
			<div class="row">
				<div class="form-group col-md-4 @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
					{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
					{{ Form::text('fecha_nacimiento', $perfil->fecha_nacimiento,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>

				<div class="col-md-4 @if($errors->first('pais_residencia')) has-error has-feedback @endif">
					{{ Form::label('pais_residencia','Pais de residencia') }}
					{{ Form::text('pais_residencia',$perfil->paisResidencia->nombre,['class' => 'form-control', 'readonly'])}}
				</div>

				<div class="col-md-4 @if($errors->first('domicilio')) has-error has-feedback @endif">
					{{ Form::label('domicilio','Domicilio') }}
					{{ Form::text('domicilio', $perfil->domicilio,['class' => 'form-control', 'readonly'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Telefono') }}
					{{ Form::text('telefono',$perfil->telefono,['class' => 'form-control', 'readonly'])}}
				</div>

				<div class="col-md-4 @if($errors->first('celular')) has-error has-feedback @endif">
					{{ Form::label('celular','Celular') }}
					{{ Form::text('celular',$perfil->celular,['class' => 'form-control', 'readonly'])}}
				</div>

				<div class="col-md-4 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','Email') }}
					{{ Form::text('email',$perfil->email,['class' => 'form-control', 'readonly'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('web')) has-error has-feedback @endif">
					{{ Form::label('web','Web Personal') }}
					{{ Form::text('web',$perfil->web,['class' => 'form-control', 'readonly'])}}
				</div>

				<div class="col-md-4 @if($errors->first('institucion')) has-error has-feedback @endif">
					{{ Form::label('institucion','Institución donde pertenece') }}
					{{ Form::text('institucion',$perfil->institucion,['class' => 'form-control', 'readonly'])}}
				</div>

				<div class="col-md-4 @if($errors->first('rol')) has-error has-feedback @endif">
					{{ Form::label('rol','Rol donde pertenece') }}
					{{ Form::text('rol', $roles[$perfil->id_rol],['class' => 'form-control', 'readonly'])}}
				</div>
			</div>
		</div>

		<div class="panel-heading">Formación Academica</div>
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-12">
					<table class="table fix">
						<tr class="info">
							<th>Grado Obtenido</th>
							<th>Nombre del titulo</th>
							<th>Centro de estudios</th>
							<th>Pais de estudios</th>
							<th>Fecha de Inicio</th>
							<th>Fecha de Fin</th>
							<th>Archivo</th>
						</tr>
						<tbody class="form_table">
							@foreach($perfil->formacionesAcademicas as $formacion)
								<tr>
									<td>{{$grados[$formacion->id_grado]}}</td>
									<td>{{$formacion->titulo}}</td>
									<td>{{$formacion->centro}}</td>
									<td>{{$formacion->pais->nombre}}</td>
									<td>{{$formacion->fecha_ini}}</td>
									<td>{{$formacion->fecha_fin}}</td>
									<td>
										<a class="btn-under" href="{{route('registro_perfil.downloadFormacion',$formacion->id)}}">
											{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', ['class' => 'btn btn-success btn-block']) }}
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="panel-heading">Formación continua</div>
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-12">
					<table class="table fix">
						<tr class="info">
							<th>Nombre de capacitacion</th>
							<th>Centro de estudios</th>
							<th>Pais de estudios</th>
						</tr>
						<tbody class="fc_table">
							@foreach($perfil->formacionesContinuas as $formacion)
								<tr>
									<td>{{$formacion->nombre}}</td>
									<td>{{$formacion->centro}}</td>
									<td>{{$formacion->pais->nombre}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="panel-heading">Idioma</div>
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-12">
					<table class="table fix">
						<tr class="info">
							<th>Idioma</th>
							<th>Lectura</th>
							<th>Conversacion</th>
							<th>Escritura</th>
							<th>Forma de Aprendizaje</th>
						</tr>
						<tbody class="idioma_table">
							@foreach($perfil->idiomas as $idioma)
								<tr>
									<td>{{$idioma->nombre->nombre}}</td>
									<td>{{$niveles_idioma[$idioma->id_lectura]}}</td>
									<td>{{$niveles_idioma[$idioma->id_conversacion]}}</td>
									<td>{{$niveles_idioma[$idioma->id_escritura]}}</td>
									<td>{{$formas_idioma[$idioma->id_forma]}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-6 col-md-offset-3 @if($errors->first('idioma_materno')) has-error has-feedback @endif">
					{{ Form::label('idioma_materno','Lengua Materna') }}
					{{ Form::text('idioma_materno',$perfil->idiomaMaterno->nombre,['class' => 'form-control', 'readonly'])}}
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Adjuntar CV</h3>
		</div>
		<div class="panel-body">
			<div class="form-group col-md-6">
				{{ Form::text('archivo', $perfil->nombre_archivo, ['class'=>'form-control','readonly']) }}
			</div>

			<div class="form-group col-md-2">
				<a class="btn-under" href="{{route('registro_perfil.download',$perfil->id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', ['class' => 'btn btn-success btn-block']) }}
				</a>
			</div>
		</div>	
	</div>

	<div class="row">
		<div class="form-group col-md-2">
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('id'=>'submit-create','class' => 'btn btn-primary btn-block')) }}
		</div>
		<div class="form-group col-md-offset-8 col-md-2">
			<a class="btn btn-default btn-block" href="{{route('registro_perfil.index')}}">Regresar</a>				
		</div>
	</div>

@stop