@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Expediente Técnico y Económico</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('codigo_compra') }}</strong></p>
			<p><strong>{{ $errors->first('codigo_archivamiento') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_adquisicion_expediente') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_compra_expediente') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_equipo') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('idfamilia_activo') }}</strong></p>
			<p><strong>{{ $errors->first('idarea') }}</strong></p>
			<p><strong>{{ $errors->first('archivo_resolucion') }}</strong></p>
			<p><strong>{{ $errors->first('archivo_tdr') }}</strong></p>
			<p><strong>{{ $errors->first('archivo_bases') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'expediente_tecnico/submit_create_expediente_tecnico', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Expediente Técnico</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
						{{ Form::label('codigo_compra','Código de Compra') }}<span style='color:red'>*</span>
						{{ Form::text('codigo_compra',Input::old('codigo_compra'),['Placeholder'=>'Código de compra','class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('codigo_archivamiento')) has-error has-feedback @endif">
						{{ Form::label('codigo_archivamiento','Código de Archivamiento') }}<span style='color:red'>*</span>
						{{ Form::text('codigo_archivamiento',Input::old('codigo_archivamiento'),['Placeholder'=>'Código de archivamiento','class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_adquisicion_expediente')) has-error has-feedback @endif">
						{{ Form::label('idtipo_adquisicion_expediente','Tipo de Adquisición') }}<span style='color:red'>*</span>
						{{ Form::select('idtipo_adquisicion_expediente',array(''=>'Seleccione') + $tipos_adquisicion_expediente,Input::old('idtipo_adquisicion_expediente'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('idtipo_compra_expediente')) has-error has-feedback @endif">
						{{ Form::label('idtipo_compra_expediente','Tipo de Compra') }}<span style='color:red'>*</span>
						{{ Form::select('idtipo_compra_expediente',array(''=>'Seleccione') + $tipos_compra_expediente,Input::old('idtipo_compra_expediente'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
						{{ Form::label('nombre_equipo','Nombre de Equipo') }}
						<select id="select_nombre_equipo" name="select_nombre_equipo" class="form-control">
							<option value="">Seleccione</option>  
						    <?php foreach($familia_activos as $index => $familia_activo){ ?>
			                    <option value="<?php echo $index; ?>"<?php if(Input::old("select_nombre_equipo") == $familia_activo['nombre_equipo']){echo("selected");} ?>><?php echo $familia_activo['nombre_equipo']; ?></option> 
						    <?php } ?>	
						    <option value="-1">Otros Equipos</option>  					   
    					</select>   
    					{{ Form::hidden('nombre_equipo')}} 					
					</div>
					<div class="form-group col-md-4 @if($errors->first('otros_equipos')) has-error has-feedback @endif">
						{{ Form::label('otros_equipos','Otros Equipos (Especificar)') }}
						{{ Form::text('otros_equipos',Input::old('otros_equipos'),['disabled'=>'','Placeholder'=>'Otros Equipos','class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idservicio')) has-error has-feedback @endif">
						{{ Form::label('idservicio','Servicio') }}
						{{ Form::select('idservicio',array(''=>'Seleccione') + $servicios,Input::old('idservicio'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('idarea_select')) has-error has-feedback @endif">
						{{ Form::label('idarea_select','Departamento') }}<span style='color:red'>*</span>
						{{ Form::select('idarea_select',array(''=>'Seleccione') + $areas,Input::old('idarea_select'),['class' => 'form-control']) }}
						{{ Form::hidden('idarea')}}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}<span style='color:red'>*</span>
						{{ Form::textarea('descripcion',Input::old('descripcion'),['Placeholder'=>'Descripción','class' => 'form-control','maxlength'=>255]) }}
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Subir Documentos</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<label class="control-label">Resolucion<span style='color:red'>*</span></label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo_resolucion" id="input-file_resolucion" type="file" class="file file-loading" data-show-upload="false">
				</div>
				<div class="col-md-8">
					<label class="control-label">Término de Referencia</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo_tdr" id="input-file_tdr" type="file" class="file file-loading" data-show-upload="false">
				</div>
				<div class="col-md-8">
					<label class="control-label">Bases</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo_bases" id="input-file_bases" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>		
			<div class="row">
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/expediente_tecnico/list_expediente_tecnicos/')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
				</div>
			</div>		
		</div>	
	{{ Form::close() }}
	
	<script>
		$("#input-file_resolucion").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
		$("#input-file_tdr").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
		$("#input-file_bases").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>
	
@stop