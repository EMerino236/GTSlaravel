@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Capacitación: {{$capacitacion->codigo}}</h3>
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
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
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

	{{ Form::open(array('route'=>['capacitacion.update',$capacitacion->id], 'role'=>'form','files'=>'true')) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos Generales
	  	</div>

	  	<div class="panel-body">	
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombre_capacitacion')) has-error has-feedback @endif">
					{{ Form::label('nombre_capacitacion','Nombre de Capacitación') }}<span style='color:red'>*</span>
					{{ Form::text('nombre_capacitacion', $capacitacion->nombre,['class' => 'form-control'])}}						
				</div>								
				<div class="col-md-4 @if($errors->first('tipo_capacitacion')) has-error has-feedback @endif">
					{{ Form::label('tipo_capacitacion','Tipo de Capacitación') }}<span style='color:red'>*</span>
					{{ Form::select('tipo_capacitacion',$tipos, $capacitacion->id_tipo,array('class'=>'form-control','onChange'=>'habilitaCampos(this)'))}}
				</div>
				<div class="col-md-4 @if($errors->first('modalidad_capacitacion')) has-error has-feedback @endif">
					{{ Form::label('modalidad_capacitacion','Modalidad de Capacitación') }}<span style='color:red'>*</span>
					{{ Form::select('modalidad_capacitacion',$modalidades, $capacitacion->id_modalidad,array('class'=>'form-control'))}}
				</div>
			</div>	

			<div class="form-group row">
				<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripción (MAX: 200 Caracteres)') }}
					{{ Form::textarea('descripcion', $capacitacion->descripcion,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
				</div>
			</div>			

			<div class="form-group row" id="collapseCampos">
				<div class="form-group col-md-6 @if($errors->first('codigo_patrimonial')) has-error has-feedback @endif">
					{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
					{{ Form::text('codigo_patrimonial', $codigo_patrimonial, ['class'=>'form-control']) }}
				</div>

				<div class="form-group col-md-6 @if($errors->first('equipo_relacionado')) has-error has-feedback @endif">
					{{ Form::label('equipo_relacionado','Equipo Relacionado') }}
					{{ Form::text('equipo_relacionado', $equipo_relacionado, ['class'=>'form-control','readonly'=>'']) }}
				</div>	
			</div>

			<div class="form-group row">
				<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::select('departamento', $departamentos, $departamento->idarea, ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::select('servicio_clinico', $servicios, $capacitacion->id_servicio_clinico, ['id'=>'servicio_clinico','class'=>'form-control']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
					{{ Form::label('responsable','Responsable') }}
					{{ Form::select('responsable',$usuarios, $capacitacion->id_responsable,['class'=>'form-control'])}}
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
					{{ Form::label('fecha_ini_capacitacion','Fecha de Inicio') }}<span style="color:red">*</span>
					<div id="datetimepicker1" class="form-group input-group date">
						{{ Form::text('fecha_ini',date('dd-mm-YYYY',strtotime($capacitacion->fecha_ini)),array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
				<div class="col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
					{{ Form::label('fecha_fin_capacitacion','Fecha de Fin') }}<span style="color:red">*</span>
					<div id="datetimepicker2" class="form-group input-group date">
						{{ Form::text('fecha_fin',date('dd-mm-YYYY',strtotime($capacitacion->fecha_fin)),array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos de las Sesiones de la Capacitación
	  	</div>
	  	<div class="panel-body">	
		  	<div class="form-group row">
				<div class="form-group col-md-6 @if($errors->first('numero_sesiones')) has-error has-feedback @endif">
					{{ Form::label('numero_sesiones','Número de Sesiones') }}
					{{ Form::text('numero_sesiones',$capacitacion->numero_sesiones,['class' => 'form-control','readonly'=>''])}}
				</div>
				<div class="form-group col-md-6 @if($errors->first('horasxsesion')) has-error has-feedback @endif">
					{{ Form::label('horasxsesion','Horas Por Sesión') }}
					{{ Form::text('horasxsesion',$capacitacion->horasxsesiones,['class' => 'form-control'])}}
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Plan de Capacitación
	  	</div>
	  	<div class="panel-body">	
		  	<div class="form-group row">
				<div class="form-group col-md-12 @if($errors->first('objetivo')) has-error has-feedback @endif">
					{{ Form::label('objetivo','Objetivo (MAX: 200 Caracteres)') }}
					{{ Form::textarea('objetivo',$capacitacion->objetivo,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
				</div>
			</div>
			<div class="form-group row">
				<div class="form-group col-md-12 @if($errors->first('personas_involucradas')) has-error has-feedback @endif">
					{{ Form::label('personas_involucradas','Personas Involucradas (MAX: 200 Caracteres)') }}
					{{ Form::textarea('personas_involucradas',$capacitacion->personal_involucrado,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
				</div>
			</div>
			<div class="form-group row">
				<div class="form-group col-md-12 @if($errors->first('competencias_requeridas')) has-error has-feedback @endif">
					{{ Form::label('competencias_requeridas','Competencias Requeridas (MAX: 200 Caracteres)') }}
					{{ Form::textarea('competencias_requeridas',$capacitacion->competencia,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Personal Externo Involucrado
	  	</div>
	  	<div class="panel-body">	
		  	<div class="form-group row">
				<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombres') }}
					{{ Form::text('nombre',Input::old('nombre'),['class' => 'form-control'])}}
				</div>
				<div class="form-group col-md-4 @if($errors->first('descripcion_personal')) has-error has-feedback @endif">
					{{ Form::label('descripcion_personal','Descripcion') }}
					{{ Form::text('descripcion_personal',Input::old('descripcion_personal'),['class' => 'form-control'])}}
				</div>
				<div class="form-group col-md-4 @if($errors->first('rol')) has-error has-feedback @endif">
					{{ Form::label('rol','Rol') }}
					{{ Form::text('rol',Input::old('rol'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
				</div>
				<div class="form-group col-md-4 @if($errors->first('institucion')) has-error has-feedback @endif">
					{{ Form::label('institucion','Institución') }}
					{{ Form::text('institucion',Input::old('institucion'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
				</div>
				<div class="form-group col-md-2 col-md-offset-4">				
					{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar', array('id'=>'add-personal',  'class' => 'btn btn-primary btn-block', 'style' => '145px;margin-top:25px','onclick'=>'agregarPersonalInvolucrado()')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" style="width:145px;margin-top:25px" onclick="limpiarPersonalExterno()">Limpiar</a>				
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table">
							<tr class="info">						
								<th class="text-nowrap text-center">Nombre</th>
								<th class="text-nowrap text-center">Descripción</th>						
								<th class="text-nowrap text-center">Rol</th>
								<th class="text-nowrap text-center">Institución</th>
								<th class="text-nowrap text-center">Eliminar</th>
							</tr>	
							<?php 								
								$count = count($details_personas);	
							?>	
							<?php for($i=0;$i<$count;$i++){ ?>
							<tr>
								<td>
									<input style="border:0" name='details_nombre[]' value='{{ $details_personas[$i]->nombre }}' readonly/>
								</td>
								<td>
									<input style="border:0" name='details_descripcion[]' value='{{ $details_personas[$i]->descripcion }}' readonly/>
								</td>
								<td>
									<input style="border:0" name='details_rol[]' value='{{ $details_personas[$i]->rol }}' readonly/>
								</td>
								<td>
									<input style="border:0" name='details_institucion[]' value='{{ $details_personas[$i]->institucion }}' readonly/>
								</td>
								<td>
									<a href='' class='btn btn-danger delete-detail' onclick='deleteRow(event,this)'><span class="glyphicon glyphicon-trash"></span></a>
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
	  		Documento Adjunto del Plan de Capacitación
	  	</div>
	  	<div class="panel-body">
	  		<div class="row" >
    			<div class="col-md-4 form-group">
    				{{ Form::label('label_doc','Plan de Capacitación:') }}
    				{{ Form::text('nombre_doc',$capacitacion->nombre_archivo,array('class'=>'form-control','id'=>'file'))}}								
   				</div>
   				<div class="col-md-2" style="margin-top:25px;">
   					@if($capacitacion->url != '')
						<a class="btn btn-success btn-block" href="{{URL::to('/capacitacion/download')}}/{{$capacitacion->id}}" ><span class="glyphicon glyphicon-download"></span> Descargar</a>
					@else
						Sin archivo adjunto
					@endif
   				</div>
   				<div class="col-md-6 form-group @if($errors->first('archivo')) has-error has-feedback @endif">
    				{{ Form::label('label_doc','Reemplazar Plan de Capacitacion:') }}{{ Form::checkbox('seleccionado',0,false,array('id'=>'seleccionado','class'=>'checkbox-metodo')) }}
					<input name="archivo" disabled id="input-file" type="file" class="file file-loading" data-show-upload="false">
   				</div>
   			</div>
	  	</div>
	</div>
	
	<div class="row">
		<div class="form-group col-md-2">				
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
		</div>
		<div class="form-group col-md-2 col-md-offset-8">
			<a class="btn btn-default btn-block" href="{{route('capacitacion.show',$capacitacion->id)}}">Cancelar</a>				
		</div>
	</div>
	{{ Form::close() }}

	<script type="text/javascript">

		$( document ).ready(function(){

			habilitaCampos();

			 $('.checkbox-metodo').change(function(){
		        if($('.checkbox-metodo').is(':checked')){
		            $('#file').prop('readonly',true);
		            $('#input-file').fileinput('enable');
		            $('#input-file').fileinput('clear');   
		        }else{
		            $('#file').prop('readonly',false);            
		            $('#input-file').fileinput('clear');
		            $('#input-file').fileinput('disable');
		        }
		    });

		});

	</script>
@stop