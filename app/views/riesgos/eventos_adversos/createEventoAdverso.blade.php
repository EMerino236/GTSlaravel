@extends('templates/eventosAdversosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Registro de Evento Adverso</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre_paciente') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_documento') }}</strong></p>
			<p><strong>{{ $errors->first('numero_documento') }}</strong></p>
			<p><strong>{{ $errors->first('edad') }}</strong></p>
			<p><strong>{{ $errors->first('sexo') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_reporte') }}</strong></p>		
			<p><strong>{{ $errors->first('fecha_incidente') }}</strong></p>
			<p><strong>{{ $errors->first('frecuencia') }}</strong></p>	
			<p><strong>{{ $errors->first('tipo_incidente') }}</strong></p>	
			<p><strong>{{ $errors->first('subtipopadre_incidente') }}</strong></p>		
			<p><strong>{{ $errors->first('subtipohijo_incidente') }}</strong></p>	
			<p><strong>{{ $errors->first('subtipohijo2_incidente') }}</strong></p>		
			<p><strong>{{ $errors->first('tipo_danho') }}</strong></p>	
			<p><strong>{{ $errors->first('grado_danho') }}</strong></p>
			<p><strong>{{ $errors->first('impacto_socioeconomico') }}</strong></p>			
			<p><strong>{{ $errors->first('origen') }}</strong></p>	
			<p><strong>{{ $errors->first('implicancia') }}</strong></p>
			<p><strong>{{ $errors->first('procedimiento') }}</strong></p>
			<p><strong>{{ $errors->first('diagnostico') }}</strong></p>		
			<p><strong>{{ $errors->first('causa') }}</strong></p>	
			<p><strong>{{ $errors->first('medidas') }}</strong></p>
			<p><strong>{{ $errors->first('codigo_patrimonial') }}</strong></p>	
			<p><strong>{{ $errors->first('informacion') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_reportante') }}</strong></p>	
			<p><strong>{{ $errors->first('profesion') }}</strong></p>	
			<p><strong>{{ $errors->first('direccion') }}</strong></p>	
			<p><strong>{{ $errors->first('email') }}</strong></p>	
			<p><strong>{{ $errors->first('disciplina') }}</strong></p>
			<p><strong>{{ $errors->first('factor') }}</strong></p>
			<p><strong>{{ $errors->first('proceso') }}</strong></p>
			<p><strong>{{ $errors->first('entorno_asistencial') }}</strong></p>
			<p><strong>{{ $errors->first('danho_bienes') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_servicio') }}</strong></p>
			<p><strong>{{ $errors->first('etapa_servicio') }}</strong></p>
			<p><strong>{{ $errors->first('comentario') }}</strong></p>

		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('message') }}</strong>
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('error') }}</strong>
		</div>
	@endif

	{{ Form::open(array('url'=>'eventos_adversos/submit_create_evento_adverso', 'role'=>'form')) }}
		{{ Form::hidden('flag_edit',0,array('id'=>'flag_edit'))}}
		{{ Form::hidden('flag_tipoHijo',0,array('id'=>'flag_tipoHijo'))}}
		{{ Form::hidden('flag_entornoAsistencial',0,array('id'=>'flag_entornoAsistencial'))}}
		{{ Form::hidden('cantidad_tipo_implicados',0,array('id'=>'cantidad_tipo_implicados'))}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Identificación del Paciente</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre_paciente')) has-error has-feedback @endif">
						{{ Form::label('nombre_paciente','Nombre del Paciente') }}
						{{ Form::text('nombre_paciente',Input::old('nombre_paciente'),array('class'=>'form-control','placeholder'=>'Nombre del Paciente')) }}
					</div>
					<div class="form-group col-md-2 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
						{{ Form::label('tipo_documento','Tipo de Documento') }}
						{{ Form::select('tipo_documento',array(''=>'Seleccione')+ $tipo_documentos,Input::old('tipo_documento'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-2 @if($errors->first('numero_documento')) has-error has-feedback @endif">
						{{ Form::label('numero_documento','N° de Documento') }}
						{{ Form::text('numero_documento',Input::old('numero_documento'),array('class'=>'form-control','placeholder'=>'N° de Documento')) }}
					</div>
					<div class="form-group col-md-2 @if($errors->first('edad')) has-error has-feedback @endif">
						{{ Form::label('edad','Edad') }}
						{{ Form::text('edad',Input::old('edad'),array('class'=>'form-control','placeholder'=>'edad')) }}
					</div>
					<div class="form-group col-md-2 @if($errors->first('sexo')) has-error has-feedback @endif">
						{{ Form::label('sexo','Sexo:') }}
						{{ Form::select('sexo',array(''=>'Seleccione')+ $sexos,Input::old('sexo'),['class' => 'form-control']) }}
					</div>
				</div>
			</div>
		</div>		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Motivos de Consulta</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('procedimiento')) has-error has-feedback @endif">
						{{ Form::label('procedimiento','Procedimiento: (MAX: 500 caracteres)') }}
						{{ Form::textarea('procedimiento',Input::old('procedimiento'),array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Procedimiento')) }}
					</div>
					<div class="form-group col-md-12 @if($errors->first('diagnostico')) has-error has-feedback @endif">
						{{ Form::label('diagnostico','Diagnóstico Principal del Paciente: (MAX: 500 caracteres)') }}
						{{ Form::textarea('diagnostico',Input::old('diagnostico'),array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Diagnóstico')) }}
					</div>				
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos Principales de la Clasificación</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('fecha_reporte','Fecha del Reporte') }}
						<div id="fecha_reporte_datetimepicker" class=" input-group date @if($errors->first('fecha_reporte')) has-error has-feedback @endif">
							{{ Form::text('fecha_reporte',Input::old('fecha_reporte'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="col-md-4 @if($errors->first('frecuencia')) has-error has-feedback @endif">
						{{ Form::label('frecuencia','Frecuencia:') }}
						{{ Form::select('frecuencia',array(''=>'Seleccione')+ $tipos_frecuencias,Input::old('frecuencia'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('tipo_incidente')) has-error has-feedback @endif">
						{{ Form::label('tipo_incidente','Tipo Incidente:') }}
						{{ Form::select('tipo_incidente',array(''=>'Seleccione')+ $tipos_incidentes,Input::old('tipo_incidente'),['class' => 'form-control','id'=>'tipo_incidente']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('subtipopadre_incidente')) has-error has-feedback @endif">
						{{ Form::label('subtipopadre_incidente','Subclasificación 1 de Tipo de Incidente:') }}
						{{ Form::select('subtipopadre_incidente',array(''=>'Seleccione'),Input::old('subtipopadre_incidente'),['class' => 'form-control','id'=>'subtipopadre']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('subtipohijo_incidente')) has-error has-feedback @endif">
						{{ Form::label('subtipohijo_incidente_lbl','Subclasificación 2 de Tipo de Incidente:',['id'=>'subtipohijo_lbl']) }}
						{{ Form::select('subtipohijo_incidente',array(''=>'Seleccione'),Input::old('subtipohijo_incidente'),['class' => 'form-control','id'=>'subtipohijo']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('subtipohijo2_incidente')) has-error has-feedback @endif" style="display:none" id="div_elemento_caida">
						{{ Form::label('subtipohijo2_incidente','Elemento implicado en la caida:',['id'=>'subtipohijo2_lbl']) }}
						{{ Form::select('subtipohijo2_incidente',array(''=>'Seleccione'),Input::old('subtipohijo2_incidente'),['class' => 'form-control','id'=>'subtipohijo2']) }}
					</div>						
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Resultados del Paciente</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-6 @if($errors->first('tipo_danho')) has-error has-feedback @endif">
						{{ Form::label('tipo_danho','Tipo de Daño') }}
						{{ Form::text('tipo_danho',Input::old('tipo_danho'),['class' => 'form-control','placeholder'=>'Tipo de Daño']) }}
					</div>
					<div class="form-group col-md-6 @if($errors->first('grado_danho')) has-error has-feedback @endif">
						{{ Form::label('grado_danho','Grado de Daño') }}
						{{ Form::select('grado_danho',array(''=>'Seleccione')+ $grados_danhos,Input::old('grado_danho'),['class' => 'form-control']) }}
					</div>					
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Impacto Social y/o Económico</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('impacto_socioeconomico')) has-error has-feedback @endif">
						{{ Form::label('impacto_socioeconomico','Descripción: (MAX: 500 caracteres)') }}
						{{ Form::textarea('impacto_socioeconomico',Input::old('impacto_socioeconomico'),array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Impacto socioeconómico')) }}
					</div>				
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Características del Incidente</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('fecha_incidente','Fecha del Incidente') }}
						<div id="fecha_incidente_datetimepicker" class=" input-group date @if($errors->first('fecha_incidente')) has-error has-feedback @endif">
							{{ Form::text('fecha_incidente',Input::old('fecha_incidente'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					
					<div class="form-group col-md-4 @if($errors->first('entorno_asistencial')) has-error has-feedback @endif">
						{{ Form::label('entorno_asistencial','Entorno Asistencial:') }}
						{{ Form::select('entorno_asistencial',array(''=>'Seleccione')+ $entorno_asistenciales,Input::old('entorno_asistencial'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('tipo_servicio')) has-error has-feedback @endif" id="div_tipo_servicio">
						{{ Form::label('tipo_servicio','Tipo de Servicio:') }}
						{{ Form::select('tipo_servicio',array(''=>'Seleccione'),Input::old('tipo_servicio'),['class' => 'form-control','id'=>'tipo_servicio']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('etapa_servicio')) has-error has-feedback @endif" id="div_etapa_servicio">
						{{ Form::label('etapa_servicio','Etapa de Servicio:',['id'=>'subtipohijo_lbl']) }}
						{{ Form::select('etapa_servicio',array(''=>'Seleccione'),Input::old('etapa_servicio'),['class' => 'form-control','id'=>'etapa_servicio']) }}
					</div>
					<div class="form-group col-md-12 @if($errors->first('comentario')) has-error has-feedback @endif" style="display:none" id="div_comentario">
						{{ Form::label('comentario','Observación:',['id'=>'comentarios_lbl']) }}
						{{ Form::text('comentario',Input::old('comentario'),['class' => 'form-control','id'=>'comentario','placeholder'=>'Ingrese Comentario']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('disciplina')) has-error has-feedback @endif" id="div_etapa_servicio">
						{{ Form::label('disciplina','Disciplina/Especialidad:') }}
						{{ Form::text('disciplina',Input::old('disciplina'),['class' => 'form-control','placeholder'=>'Disciplina/Especialidad']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('factor')) has-error has-feedback @endif">
						{{ Form::label('factor','Factores Contribuyentes:') }}
						{{ Form::select('factor',array(''=>'Seleccione')+ $factores,Input::old('factor'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('proceso')) has-error has-feedback @endif">
						{{ Form::label('proceso','Proceso:') }}
						{{ Form::select('proceso',array(''=>'Seleccione')+ $procesos,Input::old('proceso'),['class' => 'form-control']) }}
					</div>			
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Detección</h3>
			</div>
			<div class="panel-body">
				<div class="row">						
					<div class="form-group col-md-6 @if($errors->first('implicancia')) has-error has-feedback @endif">
						{{ Form::label('implicancia','Personas Implicadas:') }}
						{{ Form::select('implicancia',array(''=>'Seleccione')+ $implicancias,Input::old('implicancia'),['class' => 'form-control','id'=>'implicancia']) }}
					</div>
					<div class="form-group col-md-3 @if($errors->first('cantidad')) has-error has-feedback @endif" id="div_etapa_servicio">
						{{ Form::label('cantidad','Cantidad de personas:') }}
						{{ Form::number('cantidad',Input::old('cantidad'),['class' => 'form-control','id'=>'cantidad_personas','min'=>'0']) }}
					</div>
					<div class="form-group col-md-2" style="margin-top:25px;">				
						{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar', array('id'=>'btnAgregar',  'class' => 'btn btn-primary btn-block')) }}
					</div>				
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr class="info">
									<th class="text-nowrap text-center">Tipo de Persona</th>
									<th class="text-nowrap text-center">Cantidad</th>
									<th class="text-nowrap text-center">Eliminar</th>
								</tr>
								<?php 
									$personas_implicadas = Input::old('persona_implicada');
									$cantidades = Input::old('cantidad');
									$count = count($personas_implicadas);	
								?>	
								<?php for($i=0;$i<$count;$i++){ ?>
								<tr>
									<td>
										<input style="border:0" name='personas_implicadas[]' value='{{ $personas_implicadas[$i] }}' readonly/>
									</td>
									<td>
										<input style="border:0" name='cantidades[]' value='{{ $cantidades[$i] }}' readonly/>
									</td>
									<td>
										<a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a>
									</td>						
								</tr>
								<?php } ?>								
							</table>		
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Resultados para la Organización</h3>
			</div>
			<div class="panel-body">
				<div class="row">						
					<div class="form-group col-md-12 @if($errors->first('danho_bienes')) has-error has-feedback @endif">
						{{ Form::label('danho_bienes','Daño a Bienes:') }}
						{{ Form::textarea('danho_bienes',Input::old('danho_bienes'),array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Daño a Bienes')) }}
					</div>		
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Descripción del Incidente</h3>
			</div>
			<div class="panel-body">
				<div class="row">						
					<div class="form-group col-md-12 @if($errors->first('causa')) has-error has-feedback @endif">
						{{ Form::label('causa','Causas: (MAX: 500 caracteres)') }}
						{{ Form::textarea('causa',Input::old('causa'),array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Causas')) }}
					</div>	
					<div class="form-group col-md-12 @if($errors->first('medidas')) has-error has-feedback @endif">
						{{ Form::label('medidas','Medidas A Tomar: (MAX: 500 caracteres)') }}
						{{ Form::textarea('medidas',Input::old('medidas'),array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Medidas')) }}
					</div>	
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información del Equipo Médico Involucrado</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_patrimonial')) has-error has-feedback @endif">
						{{ Form::label('codigo_patrimonial','Código Patrimonial:') }}
						{{ Form::text('codigo_patrimonial',Input::old('codigo_patrimonial'),array('class'=>'form-control','id'=>'codigo_patrimonial','placeholder'=>'Código Patrimonial')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('servicio')) has-error has-feedback @endif">
						{{ Form::label('servicio','Servicio Clínico:') }}
						{{ Form::text('servicio',Input::old('servicio'),array('class'=>'form-control','readonly'=>'','id'=>'servicio')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('ubicacion_fisica')) has-error has-feedback @endif">
						{{ Form::label('ubicacion_fisica','Ubicación Física:') }}
						{{ Form::text('ubicacion_fisica',Input::old('ubicacion_fisica'),array('class'=>'form-control','readonly'=>'','id'=>'ubicacion_fisica')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('serie')) has-error has-feedback @endif">
						{{ Form::label('serie','Número de Serie:') }}
						{{ Form::text('serie',Input::old('serie'),array('class'=>'form-control','readonly'=>'','id'=>'serie')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
						{{ Form::label('nombre_equipo','Nombre del Equipo:') }}
						{{ Form::text('nombre_equipo',Input::old('nombre_equipo'),array('class'=>'form-control','readonly'=>'','id'=>'nombre_equipo')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('modelo')) has-error has-feedback @endif">
						{{ Form::label('modelo','Modelo:') }}
						{{ Form::text('modelo',Input::old('modelo'),array('class'=>'form-control','readonly'=>'','id'=>'modelo')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
						{{ Form::label('proveedor','Proveedor:') }}
						{{ Form::text('proveedor',Input::old('proveedor'),array('class'=>'form-control','readonly'=>'','id'=>'proveedor')) }}
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información Adicional</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('informacion')) has-error has-feedback @endif">
						{{ Form::label('informacion','Información Adicional: (MAX: 500 caracteres)') }}
						{{ Form::textarea('informacion',Input::old('informacion'),array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Características físicas del dispositivo,acciones correctivas, peso del paciente o cualquier condición del paciente que sea relevante.')) }}
					</div>	
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Identificación del Reportante</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre_reportante')) has-error has-feedback @endif">
						{{ Form::label('nombre_reportante','Nombre Reportante:') }}
						{{ Form::text('nombre_reportante',Input::old('nombre_reportante'),array('class'=>'form-control','placeholder'=>'Nombre')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('profesion')) has-error has-feedback @endif">
						{{ Form::label('profesion','Profesión o Cargo:') }}
						{{ Form::text('profesion',Input::old('profesion'),array('class'=>'form-control','placeholder'=>'Profesión o Cargo')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('direccion')) has-error has-feedback @endif">
						{{ Form::label('direccion','Dirección:') }}
						{{ Form::text('direccion',Input::old('direccion'),array('class'=>'form-control','placeholder'=>'Dirección')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('email')) has-error has-feedback @endif">
						{{ Form::label('email','E-mail:') }}
						{{ Form::text('email',Input::old('email'),array('class'=>'form-control','placeholder'=>'E-mail')) }}
					</div>			
				</div>
			</div>
		</div>
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/eventos_adversos/list_eventos_adversos')}}">Cancelar</a>				
			</div>
		</div>
	{{Form::close()}}
@stop
