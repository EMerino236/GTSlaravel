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

	{{ Form::open(array('route'=>['registro_perfil.update',$perfil->id], 'role'=>'form', 'files'=>'true')) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombres')) has-error has-feedback @endif">
					{{ Form::label('nombres','Nombres') }}
					{{ Form::text('nombres',$perfil->nombres,['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('apellido_paterno')) has-error has-feedback @endif">
					{{ Form::label('apellido_paterno','Apellido Paterno') }}
					{{ Form::text('apellido_paterno',$perfil->apellido_paterno,['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('apellido_materno')) has-error has-feedback @endif">
					{{ Form::label('apellido_materno','Apellido Materno') }}
					{{ Form::text('apellido_materno',$perfil->apellido_materno,['class' => 'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('dni')) has-error has-feedback @endif">
					{{ Form::label('dni','DNI') }}
					{{ Form::number('dni',$perfil->dni,['class' => 'form-control','min'=>'10000000', 'max'=>'99999999'])}}
				</div>

				<div class="col-md-4 @if($errors->first('pais_nacimiento')) has-error has-feedback @endif">
					{{ Form::label('pais_nacimiento','Pais de nacimiento') }}
					{{ Form::select('pais_nacimiento',$paises,$perfil->id_pais_nacimiento,['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('genero')) has-error has-feedback @endif">
					{{ Form::label('genero','Genero') }}
					{{ Form::select('genero',$generos,$perfil->id_genero,['class' => 'form-control'])}}
				</div>
			</div>
	
			<div class="row">
				<div class="form-group col-md-4 @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
					{{ Form::label('fecha_nacimiento','Fecha de nacimiento') }}
					<div id="datetimepicker3" class="form-group input-group date">
						{{ Form::text('fecha_nacimiento',date('dd-mm-YYYY',strtotime($perfil->fecha_nacimiento)),array('class'=>'form-control', 'readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>

				<div class="col-md-4 @if($errors->first('pais_residencia')) has-error has-feedback @endif">
					{{ Form::label('pais_residencia','Pais de residencia') }}
					{{ Form::select('pais_residencia',$paises,$perfil->id_pais_residencia,['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('domicilio')) has-error has-feedback @endif">
					{{ Form::label('domicilio','Domicilio') }}
					{{ Form::text('domicilio',$perfil->domicilio,['class' => 'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Telefono') }}
					{{ Form::number('telefono',$perfil->telefono,['class' => 'form-control','min'=>'1000000', 'max'=>'9999999'])}}
				</div>

				<div class="col-md-4 @if($errors->first('celular')) has-error has-feedback @endif">
					{{ Form::label('celular','Celular') }}
					{{ Form::number('celular',$perfil->celular,['class' => 'form-control','min'=>'100000000', 'max'=>'999999999'])}}
				</div>

				<div class="col-md-4 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','Email') }}
					{{ Form::email('email',$perfil->email,['class' => 'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('web')) has-error has-feedback @endif">
					{{ Form::label('web','Web Personal') }}
					{{ Form::text('web',$perfil->web,['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('institucion')) has-error has-feedback @endif">
					{{ Form::label('institucion','Institución donde pertenece') }}
					{{ Form::text('institucion',$perfil->institucion,['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('rol')) has-error has-feedback @endif">
					{{ Form::label('rol','Rol donde pertenece') }}
					{{ Form::select('rol', $roles,$perfil->id_rol,['class' => 'form-control'])}}
				</div>
			</div>
		</div>

		<div class="panel-heading">Formación Academica</div>
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('fa_grados') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_grado','Grado Obtenido') }}
					{{ Form::select('fa_grado',$grados,Input::old('fa_grado'),['id'=>'fa_grado','class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('fa_grados') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_nombre_grado','Nombre del titulo o grado') }}
					{{ Form::text('fa_nombre_grado',Input::old('fa_nombre_grado'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('fa_grados') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_centro_estudios','Centro de estudios') }}
					{{ Form::text('fa_centro_estudios',Input::old('fa_centro_estudios'),['class' => 'form-control'])}}
				</div>
			</div>

			<div class="row">
				<div class="col-md-4 @if($errors->first('fa_grados') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_pais_estudios','Pais de Estudios') }}
					{{ Form::select('fa_pais_estudios',$paises,Input::old('fa_pais_estudios'),['id'=>'fa_pais_estudios','class' => 'form-control'])}}
				</div>

				<div class="form-group col-md-4 @if($errors->first('fa_grados') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_fecha_inicio','Fecha Inicio') }}
					<div id="datetimepicker1" class="form-group input-group date">
						{{ Form::text('fa_fecha_inicio',Input::old('fa_fecha_inicio'),array('class'=>'form-control', 'readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>

				<div class="form-group col-md-4 @if($errors->first('fa_grados') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_fecha_fin','Fecha Fin') }}
					<div id="datetimepicker2" class="form-group input-group date">
						{{ Form::text('fa_fecha_fin',Input::old('fa_fecha_fin'),array('class'=>'form-control', 'readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="form-group col-md-offset-8 col-md-4">
					<div class="btn btn-primary btn-block" onclick="agregarFormacionAcademica()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
				</div>

				<div class="col-md-12">
					<table class="table fix">
						<tr class="info">
							<th>Grado Obtenido</th>
							<th>Nombre del titulo</th>
							<th>Centro de estudios</th>
							<th>Pais de estudios</th>
							<th>Fecha de Inicio</th>
							<th>Fecha de Fin</th>
							<th></th>
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
										<a class="btn-under" href="{{route('registro_perfil.academica.edit',$formacion->id)}}">
											{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', ['class' => 'btn btn-primary btn-block']) }}
										</a>
									</td>
								</tr>
							@endforeach
							@if(Input::old('fa_grados'))
								@foreach(Input::old('fa_grados') as $key => $data)
									<tr>
										<td>{{$grados[$data]}}<input type="hidden" class="cell" name='fa_grados[]' value='{{$data}}'/></td>
										<td><input class="cell" name='fa_titulos[]' value='{{Input::old('fa_titulos')[$key]}}' readonly/></td>
										<td><input class="cell" name='fa_centros[]' value='{{Input::old('fa_centros')[$key]}}' readonly/></td>
										<td>{{$paises[Input::old('fa_paises')[$key]]}}<input type="hidden" class="cell" name='fa_paises[]' value='{{Input::old('fa_paises')[$key]}}'/></td>
										<td><input class="cell" name='fa_fechas_ini[]' value='{{Input::old('fa_fechas_ini')[$key]}}' readonly/></td>
										<td><input class="cell" name='fa_fechas_fin[]' value='{{Input::old('fa_fechas_fin')[$key]}}' readonly/></td>
										<td style='overflow:auto'><input type='file' name='archivos[]' value='{{Input::old('archivos')[$key]}}' readonly/></td>
										<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="panel-heading">Formación continua</div>
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('fc_nombres_capacitacion')) has-error has-feedback @endif">
					{{ Form::label('fc_nombre_capacitacion','Nombre de Capacitacion, curso o diplomado') }}
					{{ Form::text('fc_nombre_capacitacion',Input::old('fc_nombre_capacitacion'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('fc_nombres_capacitacion')) has-error has-feedback @endif">
					{{ Form::label('fc_centro_estudios','Centro de estudios') }}
					{{ Form::text('fc_centro_estudios',Input::old('fc_centro_estudios'),['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('fc_nombres_capacitacion')) has-error has-feedback @endif">
					{{ Form::label('fc_pais_estudios','Pais de Estudios') }}
					{{ Form::select('fc_pais_estudios',$paises,Input::old('fc_pais_estudios'),['id'=>'fc_pais_estudios','class' => 'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="form-group col-md-offset-8 col-md-4">
					<div class="btn btn-primary btn-block" onclick="agregarFormacionContinua()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
				</div>

				<div class="col-md-12">
					<table class="table fix">
						<tr class="info">
							<th>Nombre de capacitacion</th>
							<th>Centro de estudios</th>
							<th>Pais de estudios</th>
							<th></th>
						</tr>
						<tbody class="fc_table">
							@foreach($perfil->formacionesContinuas as $formacion)
								<tr>
									<td>{{$formacion->nombre}}</td>
									<td>{{$formacion->centro}}</td>
									<td>{{$formacion->pais->nombre}}</td>
									<td>
										<a class="btn-under" href="{{route('registro_perfil.continua.edit',$formacion->id)}}">
											{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', ['class' => 'btn btn-primary btn-block']) }}
										</a>
									</td>
								</tr>
							@endforeach
							@if(Input::old('fc_nombres_capacitacion'))
								@foreach(Input::old('fc_nombres_capacitacion') as $key => $data)
									<tr>
										<td><input class="cell" name='fc_nombres_capacitacion[]' value='{{$data}}' readonly/></td>
										<td><input class="cell" name='fc_centros[]' value='{{Input::old('fc_centros')[$key]}}' readonly/></td>
										<td>{{$paises[Input::old('fc_paises')[$key]]}}<input type="hidden" class="cell" name='fc_paises[]' value='{{Input::old('fc_paises')[$key]}}' readonly/></td>
										<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="panel-heading">Idioma</div>
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombres_idioma')) has-error has-feedback @endif">
					{{ Form::label('nombre_idioma','Idioma') }}
					{{ Form::select('nombre_idioma',$idiomas,Input::old('nombre_idioma'),['id'=>'nombre_idioma','class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('nombres_idioma')) has-error has-feedback @endif">
					{{ Form::label('lectura','Lectura') }}
					{{ Form::select('lectura',$niveles_idioma,Input::old('lectura'),['id'=>'lectura','class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('nombres_idioma')) has-error has-feedback @endif">
					{{ Form::label('conversacion','Conversacion') }}
					{{ Form::select('conversacion',$niveles_idioma,Input::old('conversacion'),['id'=>'conversacion','class' => 'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombres_idioma')) has-error has-feedback @endif">
					{{ Form::label('escritura','Escritura') }}
					{{ Form::select('escritura',$niveles_idioma,Input::old('escritura'),['id'=>'escritura','class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('nombres_idioma')) has-error has-feedback @endif">
					{{ Form::label('forma_aprendizaje','Forma de aprendizaje') }}
					{{ Form::select('forma_aprendizaje',$formas_idioma,Input::old('forma_aprendizaje'),['id'=>'forma_aprendizaje','class' => 'form-control'])}}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('','&zwnj;&zwnj;') }}
					<div class="btn btn-primary btn-block" onclick="agregarIdioma()"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-12">
					<table class="table fix">
						<tr class="info">
							<th>Idioma</th>
							<th>Lectura</th>
							<th>Conversacion</th>
							<th>Escritura</th>
							<th>Forma de Aprendizaje</th>
							<th></th>
						</tr>
						<tbody class="idioma_table">
							@foreach($perfil->idiomas as $idioma)
								<tr>
									<td>{{$idioma->nombre->nombre}}</td>
									<td>{{$niveles_idioma[$idioma->id_lectura]}}</td>
									<td>{{$niveles_idioma[$idioma->id_conversacion]}}</td>
									<td>{{$niveles_idioma[$idioma->id_escritura]}}</td>
									<td>{{$formas_idioma[$idioma->id_forma]}}</td>
									<td>
										<a class="btn-under" href="{{route('registro_perfil.idioma.edit',$idioma->id)}}">
											{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', ['class' => 'btn btn-primary btn-block']) }}
										</a>
									</td>
								</tr>
							@endforeach
							@if(Input::old('nombres_idioma'))
								@foreach(Input::old('nombres_idioma') as $key => $data)
									<tr>
										<td>{{$idiomas[Input::old('nombres_idioma')[$key]]}}<input type="hidden" class="cell" name='nombres_idioma[]' value='{{$data}}' readonly/></td>
										<td>{{$niveles_idioma[Input::old('lecturas')[$key]]}}<input type="hidden" class="cell" name='lecturas[]' value='{{Input::old('lecturas')[$key]}}'/></td>
										<td>{{$niveles_idioma[Input::old('conversaciones')[$key]]}}<input type="hidden" class="cell" name='conversaciones[]' value='{{Input::old('conversaciones')[$key]}}'/></td>
										<td>{{$niveles_idioma[Input::old('escrituras')[$key]]}}<input type="hidden" class="cell" name='escrituras[]' value='{{Input::old('escrituras')[$key]}}'/></td>
										<td>{{$formas_idioma[Input::old('formas')[$key]]}}<input type="hidden" class="cell" name='formas[]' value='{{Input::old('formas')[$key]}}'/></td>
										<td><a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a></td></tr>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-6 col-md-offset-3 @if($errors->first('idioma_materno')) has-error has-feedback @endif">
					{{ Form::label('idioma_materno','Lengua Materna') }}
					{{ Form::select('idioma_materno',$idiomas,$perfil->id_idioma_materno,['class' => 'form-control'])}}
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Adjuntar CV</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-8 form-group @if($errors->first('archivo')) has-error has-feedback @endif">
				<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
				<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
			</div>
			<div class="col-md-8 form-group">
				{{ Form::label('archivo_subido','Archivo Subido') }}
				{{ Form::text('archivo_subido', $perfil->nombre_archivo, ['class'=>'form-control','readonly']) }}
			</div>
		</div>	
	</div>

	<div class="row">
		<div class="form-group col-md-2">
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
		</div>
		<div class="form-group col-md-offset-8 col-md-2">
			<a class="btn btn-default btn-block" href="{{route('registro_perfil.index')}}">Cancelar</a>				
		</div>
	</div>

	
	{{ Form::close() }}

	<script>
	$("#input-file").fileinput({
	    language: "es",
	    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
	});
	</script>
@stop