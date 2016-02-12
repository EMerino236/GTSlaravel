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

		{{ Form::hidden('flag_tipoHijo',$flag_tipoHijo,array('id'=>'flag_tipoHijo'))}}
		{{ Form::hidden('flag_edit',1,array('id'=>'flag_edit'))}}
		{{ Form::hidden('evento_adverso_id', $evento_adverso_info->id) }}
		{{ Form::hidden('tipoincidente_id', $subtipohijo_info->idtipo_incidente,array('id'=>'tipoincidente_id')) }}
		{{ Form::hidden('subtipopadre_id', $subtipohijo_info->idsubtipopadre_incidente,array('id'=>'subtipopadre_id')) }}
		{{ Form::hidden('subtipohijo_id', $subtipohijo_info->idsubtipohijo_incidente,array('id'=>'subtipohijo_id')) }}
		@if($subtipohijo_nieto1==null && $subtipohijo_nieto2==null )
			{{ Form::hidden('subtiponieto1_id', null,array('id'=>'subtiponieto1_id')) }}
			{{ Form::hidden('subtiponieto2_id', null,array('id'=>'subtiponieto2_id')) }}
		@else
			{{ Form::hidden('subtiponieto1_id', $subtipohijo_nieto1->idsubtiponieto_incidente,array('id'=>'subtiponieto1_id')) }}
			{{ Form::hidden('subtiponieto2_id', $subtipohijo_nieto2->idsubtiponieto_incidente,array('id'=>'subtiponieto2_id')) }}
		@endif
		

		@if($evento_adverso_info->idetapa_servicio == null)
			{{ Form::hidden('identorno_asistencial', $entorno_asistencial->identorno,array('id'=>'identorno_asistencial')) }}
			{{ Form::hidden('comentario_entorno', $entorno_asistencial->comentario,array('id'=>'comentario_entorno')) }}
		@else
			{{ Form::hidden('identorno_asistencial',$etapa_servicio->identorno,array('id'=>'identorno_asistencial'))}}
			{{ Form::hidden('idtipo_servicio',$etapa_servicio->idtipo_servicio,array('id'=>'idtipo_servicio'))}}
			{{ Form::hidden('idetapa_servicio',$etapa_servicio->id,array('id'=>'idetapa_servicio'))}}
			{{ Form::hidden('comentario_entorno', null,array('id'=>'comentario_entorno')) }}
		@endif
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Identificación del Paciente</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre_paciente')) has-error has-feedback @endif">
						{{ Form::label('nombre_paciente','Nombre del Paciente') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::text('nombre_paciente',$evento_adverso_info->nombre_paciente,array('class'=>'form-control','placeholder'=>'Nombre del Paciente','readonly'=>'')) }}
						@else
							{{ Form::text('nombre_paciente',$evento_adverso_info->nombre_paciente,array('class'=>'form-control','placeholder'=>'Nombre del Paciente','readonly'=>'')) }}
						@endif
					</div>
					<div class="form-group col-md-2 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
						{{ Form::label('tipo_documento','Tipo de Documento') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::select('tipo_documento',array(''=>'Seleccione')+ $tipo_documentos,$evento_adverso_info->idtipo_documento,['class' => 'form-control','readonly'=>'']) }}
						@else
							{{ Form::select('tipo_documento',array(''=>'Seleccione')+ $tipo_documentos,$evento_adverso_info->idtipo_documento,['class' => 'form-control','readonly'=>'']) }}
						@endif

					</div>
					<div class="form-group col-md-2 @if($errors->first('numero_documento')) has-error has-feedback @endif">
						{{ Form::label('numero_documento','N° de Documento') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::text('numero_documento',$evento_adverso_info->numero_documento,array('class'=>'form-control','placeholder'=>'N° de Documento','readonly'=>'')) }}
						@else
							{{ Form::text('numero_documento',$evento_adverso_info->numero_documento,array('class'=>'form-control','placeholder'=>'N° de Documento','readonly'=>'')) }}
						@endif
					</div>
					<div class="form-group col-md-2 @if($errors->first('edad')) has-error has-feedback @endif">
						{{ Form::label('edad','Edad') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::text('edad',$evento_adverso_info->edad,array('class'=>'form-control','placeholder'=>'edad','readonly'=>'')) }}
						@else
							{{ Form::text('edad',$evento_adverso_info->edad,array('class'=>'form-control','placeholder'=>'edad','readonly'=>'')) }}
						@endif						
					</div>
					<div class="form-group col-md-2 @if($errors->first('sexo')) has-error has-feedback @endif">
						{{ Form::label('sexo','Sexo:') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::select('sexo',array(''=>'Seleccione')+ $sexos,$evento_adverso_info->sexo,['class' => 'form-control','readonly'=>'']) }}
						@else
							{{ Form::select('sexo',array(''=>'Seleccione')+ $sexos,$evento_adverso_info->sexo,['class' => 'form-control','readonly'=>'']) }}
						@endif
						
					</div>
				</div>
			</div>
		</div>	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Motivos de Consulta</h3>
			</div>
			<div class="panel-body">
				<div class="form-group col-md-12 @if($errors->first('procedimiento')) has-error has-feedback @endif">
					{{ Form::label('procedimiento','Procedimiento: (MAX: 500 caracteres)') }}
					@if($evento_adverso_info->deleted_at)
						{{ Form::textarea('procedimiento',$evento_adverso_info->procedimiento,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Procedimiento','readonly'=>'')) }}
					@else
						{{ Form::textarea('procedimiento',$evento_adverso_info->procedimiento,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Procedimiento','readonly'=>'')) }}
					@endif						
				</div>
				<div class="form-group col-md-12 @if($errors->first('diagnostico')) has-error has-feedback @endif">
					{{ Form::label('diagnostico','Diagnóstico: (MAX: 500 caracteres)') }}
					@if($evento_adverso_info->deleted_at)
						{{ Form::textarea('diagnostico',$evento_adverso_info->diagnostico,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Diagnostico','readonly'=>'')) }}
					@else
						{{ Form::textarea('diagnostico',$evento_adverso_info->diagnostico,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Diagnostico','readonly'=>'')) }}
					@endif						
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
							@if($evento_adverso_info->deleted_at)
								{{ Form::text('fecha_reporte',null,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('fecha_reporte',date('d-m-Y',strtotime($evento_adverso_info->fecha_reporte)),array('class'=>'form-control','readonly'=>'')) }}
							@endif							
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="col-md-4 @if($errors->first('frecuencia')) has-error has-feedback @endif">
						{{ Form::label('frecuencia','Frecuencia:') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::select('frecuencia',array(''=>'Seleccione')+ $tipos_frecuencias,$evento_adverso_info->idfrecuencia,['class' => 'form-control','readonly'=>'']) }}
						@else
							{{ Form::select('frecuencia',array(''=>'Seleccione')+ $tipos_frecuencias,$evento_adverso_info->idfrecuencia,['class' => 'form-control','readonly'=>'']) }}
						@endif
					</div>
					<div class="form-group col-md-4 @if($errors->first('tipo_incidente')) has-error has-feedback @endif">
						{{ Form::label('tipo_incidente','Tipo Incidente:') }}
						{{ Form::select('tipo_incidente',array(''=>'Seleccione')+ $tipos_incidentes,Input::old('tipo_incidente'),['class' => 'form-control','id'=>'tipo_incidente','readonly'=>'']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('subtipopadre_incidente')) has-error has-feedback @endif">
						{{ Form::label('subtipopadre_incidente','Subclasificación 1 de Tipo de Incidente:') }}
						{{ Form::select('subtipopadre_incidente',array(''=>'Seleccione'),Input::old('subtipopadre_incidente'),['class' => 'form-control','id'=>'subtipopadre','readonly'=>'']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('subtipohijo_incidente')) has-error has-feedback @endif">
						{{ Form::label('subtipohijo_incidente_lbl','Subclasificación 2 de Tipo de Incidente:',['id'=>'subtipohijo_lbl']) }}
						{{ Form::select('subtipohijo_incidente',array(''=>'Seleccione'),Input::old('subtipohijo_incidente'),['class' => 'form-control','id'=>'subtipohijo','readonly'=>'']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('subtipohijo2_incidente')) has-error has-feedback @endif" style="display:none" id="div_elemento_caida">
						{{ Form::label('subtipohijo2_incidente','Elemento implicado en la caida:',['id'=>'subtipohijo2_lbl']) }}
						{{ Form::select('subtipohijo2_incidente',array(''=>'Seleccione'),Input::old('subtipohijo2_incidente'),['class' => 'form-control','id'=>'subtipohijo2','readonly'=>'']) }}
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
						@if($evento_adverso_info->deleted_at)
							{{ Form::text('tipo_danho',$evento_adverso_info->tipo_danho,['class' => 'form-control','readonly'=>'']) }}
						@else
							{{ Form::text('tipo_danho',$evento_adverso_info->tipo_danho,['class' => 'form-control','readonly'=>'']) }}
						@endif
					</div>
					<div class="form-group col-md-6 @if($errors->first('grado_danho')) has-error has-feedback @endif">
						{{ Form::label('grado_danho','Grado de Daño') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::select('grado_danho',array(''=>'Seleccione')+ $grados_danhos,$evento_adverso_info->idgrado_danho,['class' => 'form-control','readonly'=>'']) }}
						@else
							{{ Form::select('grado_danho',array(''=>'Seleccione')+ $grados_danhos,$evento_adverso_info->idgrado_danho,['class' => 'form-control','readonly'=>'']) }}
						@endif
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
						@if($evento_adverso_info->deleted_at)
							{{ Form::textarea('impacto_socioeconomico',$evento_adverso_info->impacto_socioeconomico,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Impacto socioeconómico','readonly'=>'')) }}
						@else
							{{ Form::textarea('impacto_socioeconomico',$evento_adverso_info->impacto_socioeconomico,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Impacto socioeconómico','readonly'=>'')) }}
						@endif
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
							@if($evento_adverso_info->deleted_at)
								{{ Form::text('fecha_incidente',null,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('fecha_incidente',date('d-m-Y H:i:s',strtotime($evento_adverso_info->fecha_incidente)),array('class'=>'form-control','readonly'=>'')) }}
							@endif
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>					
					
					<div class="form-group col-md-4 @if($errors->first('entorno_asistencial')) has-error has-feedback @endif">
						{{ Form::label('entorno_asistencial','Entorno Asistencial:') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::select('entorno_asistencial',array(''=>'Seleccione')+ $entorno_asistenciales,Input::old('entorno_asistencial'),['class' => 'form-control','disabled'=>'disabled']) }}
						@else
							{{ Form::select('entorno_asistencial',array(''=>'Seleccione')+ $entorno_asistenciales,Input::old('entorno_asistencial'),['class' => 'form-control','disabled'=>'disabled']) }}
						@endif
						
					</div>
					<div class="form-group col-md-4 @if($errors->first('tipo_servicio')) has-error has-feedback @endif" id="div_tipo_servicio">
						{{ Form::label('tipo_servicio','Tipo de Servicio:') }}
						{{ Form::select('tipo_servicio',array(''=>'Seleccione'),Input::old('tipo_servicio'),['class' => 'form-control','id'=>'tipo_servicio','disabled'=>'disabled']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('etapa_servicio')) has-error has-feedback @endif" id="div_etapa_servicio">
						{{ Form::label('etapa_servicio','Etapa de Servicio:',['id'=>'subtipohijo_lbl']) }}
						{{ Form::select('etapa_servicio',array(''=>'Seleccione'),Input::old('etapa_servicio'),['class' => 'form-control','id'=>'etapa_servicio','disabled'=>'disabled']) }}
					</div>
					<div class="form-group col-md-12 @if($errors->first('comentario')) has-error has-feedback @endif" style="display:none" id="div_comentario">
						{{ Form::label('comentario','Observación:',['id'=>'comentarios_lbl']) }}
						{{ Form::text('comentario',Input::old('comentario'),['class' => 'form-control','id'=>'comentario','placeholder'=>'Ingrese Comentario','readonly'=>'']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('disciplina')) has-error has-feedback @endif" id="div_etapa_servicio">
						{{ Form::label('disciplina','Disciplina/Especialidad:') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::text('disciplina',$evento_adverso_info->disciplina,['class' => 'form-control','readonly'=>'','placeholder'=>'Disciplina/Especialidad']) }}
						@else
							{{ Form::text('disciplina',$evento_adverso_info->disciplina,['class' => 'form-control','placeholder'=>'Disciplina/Especialidad','readonly'=>'']) }}
						@endif						
					</div>
					<div class="form-group col-md-4 @if($errors->first('factor')) has-error has-feedback @endif">
						{{ Form::label('factor','Factores Contribuyentes:') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::select('factor',array(''=>'Seleccione')+ $factores,$evento_adverso_info->idfactor,['class' => 'form-control','readonly'=>'']) }}
						@else
							{{ Form::select('factor',array(''=>'Seleccione')+ $factores,$evento_adverso_info->idfactor,['class' => 'form-control','readonly'=>'']) }}
						@endif
					</div>
					<div class="form-group col-md-4 @if($errors->first('proceso')) has-error has-feedback @endif">
						{{ Form::label('proceso','Proceso:') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::select('proceso',array(''=>'Seleccione')+ $procesos,$evento_adverso_info->idproceso,['class' => 'form-control','readonly'=>'']) }}
						@else
							{{ Form::select('proceso',array(''=>'Seleccione')+ $procesos,$evento_adverso_info->idproceso,['class' => 'form-control','readonly'=>'']) }}
						@endif						
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
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr class="info">
									<th class="text-nowrap text-center">Tipo de Persona</th>
									<th class="text-nowrap text-center">Cantidad</th>
									<th class="text-nowrap text-center">Eliminar</th>
								</tr>
								<?php 
									$count = count($personas_implicadas);	
								?>	
								<?php for($i=0;$i<$count;$i++){ ?>
								<tr>
									<td class="text-nowrap text-center">
										<input style="border:0;text-align:center" name='personas_implicadas[]' value='{{ $personas_implicadas[$i]->nombre_tipo }}' readonly/>
									</td>
									<td class="text-nowrap text-center">
										<input style="border:0;text-align:center" name='cantidades[]' value='{{ $personas_implicadas[$i]->cantidad }}' readonly/>
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
						@if($evento_adverso_info->deleted_at)
							{{ Form::textarea('danho_bienes',$evento_adverso_info->danho_bienes,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','readonly'=>'')) }}
						@else
							{{ Form::textarea('danho_bienes',$evento_adverso_info->danho_bienes,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','readonly'=>'')) }}
						@endif
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
						@if($evento_adverso_info->deleted_at)
							{{ Form::textarea('causa',$evento_adverso_info->causa,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Causas','readonly'=>'')) }}
						@else
							{{ Form::textarea('causa',$evento_adverso_info->causa,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Causas','readonly'=>'')) }}
						@endif
					</div>	
					<div class="form-group col-md-12 @if($errors->first('medidas')) has-error has-feedback @endif">
						{{ Form::label('medidas','Medidas A Tomar: (MAX: 500 caracteres)') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::textarea('medidas',$evento_adverso_info->medidas,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Medidas','readonly'=>'')) }}
						@else
							{{ Form::textarea('medidas',$evento_adverso_info->medidas,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Medidas','readonly'=>'')) }}
						@endif						
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
						@if($evento_adverso_info->deleted_at)
							{{ Form::text('codigo_patrimonial',$activo_info->codigo_patrimonial,array('class'=>'form-control','id'=>'codigo_patrimonial','placeholder'=>'Código Patrimonial','readonly'=>'')) }}
						@else
							{{ Form::text('codigo_patrimonial',$activo_info->codigo_patrimonial,array('class'=>'form-control','id'=>'codigo_patrimonial','placeholder'=>'Código Patrimonial','readonly'=>'')) }}
						@endif
					</div>
					<div class="form-group col-md-4 @if($errors->first('servicio')) has-error has-feedback @endif">
						{{ Form::label('servicio','Servicio Clínico:') }}
						{{ Form::text('servicio',$activo_info->nombre_servicio,array('class'=>'form-control','readonly'=>'','id'=>'servicio')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('ubicacion_fisica')) has-error has-feedback @endif">
						{{ Form::label('ubicacion_fisica','Ubicación Física:') }}
						{{ Form::text('ubicacion_fisica',$activo_info->nombre_ubicacion_fisica,array('class'=>'form-control','readonly'=>'','id'=>'ubicacion_fisica')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('serie')) has-error has-feedback @endif">
						{{ Form::label('serie','Número de Serie:') }}
						{{ Form::text('serie',$activo_info->numero_serie,array('class'=>'form-control','readonly'=>'','id'=>'serie')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
						{{ Form::label('nombre_equipo','Nombre del Equipo:') }}
						{{ Form::text('nombre_equipo',$activo_info->nombre_equipo,array('class'=>'form-control','readonly'=>'','id'=>'nombre_equipo')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('modelo')) has-error has-feedback @endif">
						{{ Form::label('modelo','Modelo:') }}
						{{ Form::text('modelo',$activo_info->nombre_modelo,array('class'=>'form-control','readonly'=>'','id'=>'modelo')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
						{{ Form::label('proveedor','Proveedor:') }}
						{{ Form::text('proveedor',$activo_info->razon_social,array('class'=>'form-control','readonly'=>'','id'=>'proveedor')) }}
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
						@if($evento_adverso_info->deleted_at)
							{{ Form::textarea('informacion',$evento_adverso_info->informacion,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Características físicas del dispositivo,acciones correctivas, peso del paciente o cualquier condición del paciente que sea relevante.','readonly'=>'')) }}
						@else
							{{ Form::textarea('informacion',$evento_adverso_info->informacion,array('class'=>'form-control','maxlength'=>'500','rows'=>5,'style'=>'resize:none;','placeholder'=>'Características físicas del dispositivo,acciones correctivas, peso del paciente o cualquier condición del paciente que sea relevante.','readonly'=>'')) }}
						@endif
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
						@if($evento_adverso_info->deleted_at)
							{{ Form::text('nombre_reportante',$evento_adverso_info->nombre_reportante,array('class'=>'form-control','placeholder'=>'Nombre','readonly'=>'')) }}
						@else
							{{ Form::text('nombre_reportante',$evento_adverso_info->nombre_reportante,array('class'=>'form-control','placeholder'=>'Nombre','readonly'=>'')) }}
						@endif
					</div>
					<div class="form-group col-md-4 @if($errors->first('profesion')) has-error has-feedback @endif">
						{{ Form::label('profesion','Profesión o Cargo:') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::text('profesion',$evento_adverso_info->profesion,array('class'=>'form-control','placeholder'=>'Profesión o Cargo','readonly'=>'')) }}
						@else
							{{ Form::text('profesion',$evento_adverso_info->profesion,array('class'=>'form-control','placeholder'=>'Profesión o Cargo','readonly'=>'')) }}
						@endif
					</div>
					<div class="form-group col-md-4 @if($errors->first('direccion')) has-error has-feedback @endif">
						{{ Form::label('direccion','Dirección:') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::text('direccion',$evento_adverso_info->direccion,array('class'=>'form-control','placeholder'=>'Dirección','readonly'=>'')) }}
						@else
							{{ Form::text('direccion',$evento_adverso_info->direccion,array('class'=>'form-control','placeholder'=>'Dirección','readonly'=>'')) }}
						@endif
					</div>
					<div class="form-group col-md-4 @if($errors->first('email')) has-error has-feedback @endif">
						{{ Form::label('email','E-mail:') }}
						@if($evento_adverso_info->deleted_at)
							{{ Form::text('email',$evento_adverso_info->email,array('class'=>'form-control','placeholder'=>'E-mail','readonly'=>'')) }}
						@else
							{{ Form::text('email',$evento_adverso_info->email,array('class'=>'form-control','placeholder'=>'E-mail','readonly'=>'')) }}
						@endif
					</div>			
				</div>
			</div>
		</div>
		<div class="container-fluid row">
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/eventos_adversos/list_eventos_adversos')}}"><span class="glyphicon glyphicon-menu-left"></span>Regresar</a>				
			</div>
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::open(array('url'=>'eventos_adversos/export_pdf', 'role'=>'form')) }}
				{{ Form::hidden('evento_adverso_id', $evento_adverso_info->id) }}
				{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar', 'type'=>'submit' ,'class' => 'btn btn-success btn-block')) }}
				{{ Form::close() }}
			</div>
		</div>
	
@stop
