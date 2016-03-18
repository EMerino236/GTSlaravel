@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Acuerdos y convenios de asociación con entidades</h3>
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
			<p><strong>{{ $errors->first('nombre_convenio') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_firma_convenio') }}</strong></p>
			<p><strong>{{ $errors->first('duracion_convenio') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_convenio') }}</strong></p>
			<p><strong>{{ $errors->first('objetivo_convenio') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>			
			<p><strong>{{ $errors->first('') }}</strong></p>
			<p><strong>{{ $errors->first('') }}</strong></p>
			<p><strong>{{ $errors->first('') }}</strong></p>
		</div>
	@endif

	{{ Form::open(array('route'=>['acuerdo_convenio.update',$acuerdo_convenio->id], 'role'=>'form', 'files'=>true)) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('nombre_convenio')) has-error has-feedback @endif">
						{{ Form::label('nombre_convenio','Nombre de Convenio') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_convenio',$acuerdo_convenio->nombre,['class' => 'form-control'])}}
					</div>					
				</div>
				<div class="form-group row">
					<div class="col-md-4">
						{{ Form::label('fecha_firma_convenio','Fecha de Firma') }}<span style='color:red'>*</span>					
						<div id="datetimepicker1" class="form-group input-group date">
							{{ Form::text('fecha_firma_convenio',date('d-m-Y',strtotime($acuerdo_convenio->fechafirma)),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>				
					</div>					
					<div class="col-md-4 @if($errors->first('duracion_convenio')) has-error has-feedback @endif">
						{{ Form::label('duracion_convenio','Duración de Convenio (En Meses)') }}<span style='color:red'>*</span>
						{{ Form::text('duracion_convenio',$acuerdo_convenio->duracion,['class' => 'form-control'])}}
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('descripcion_convenio')) has-error has-feedback @endif">
						{{ Form::label('descripcion_convenio','Descripción (MAX:200 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('descripcion_convenio',$acuerdo_convenio->descripcion,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('objetivo_convenio')) has-error has-feedback @endif">
						{{ Form::label('objetivo_convenio','Principales Objetivos (MAX:200 Caracteres)') }}<span style='color:red'>*</span>
						{{ Form::textarea('objetivo_convenio',$acuerdo_convenio->objetivo,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-4">
						{{ Form::label('file_documento','Archivo') }}<span style='color:red'>*</span>
						{{ Form::text('file_documento',$acuerdo_convenio->nombre_archivo,['class' => 'form-control', 'readonly' => 'true'])}}						
					</div>
					<div class="col-md-2 hide">
						<a class="btn btn-success btn-block btn-md" style="width:145px; float: left; margin-top:25px" href="{{route('acuerdo_convenio.download',$acuerdo_convenio->id)}}">
						<span class="glyphicon glyphicon-download"></span> Descargar</a>
					</div>
					<div class="col-md-2">
						<div class="btn btn-warning btn-block" style="width:145px; float: left; margin-top:25px" id="btnReemplazar" onClick="showAdjuntarAcuerdoConvenio()">
							<span class="glyphicon glyphicon-refresh"></span> Reemplazar</div>				
					</div>
				</div>		
			</div>
		</div>

		<div id="adjuntar_acuerdo_convenio"  class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Adjuntar Archivo</h3>
		</div>
		<div class="panel-body">
			<div class="col-md-8 @if($errors->first('archivo')) has-error has-feedback @endif">
				<label class="control-label">Seleccione un Documento </label><span style='color:red'>*</span><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="right" title="Formatos Permitidos: png, jpe, jpeg, jpg, gif, bmp, zip, rar, pdf, doc, docx, xls, xlsx, ppt, pptx"></span>
				<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
			</div>
		</div>	
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Instituciones relacionadas<span style='color:red'>*</span></h3>
			</div>
			<div class="panel-body">
				<div class="form-group row">
					<div class="col-md-4">
					{{ Form::label('institucion_convenio','Nombre de Institución') }}
					{{ Form::text('institucion_convenio',Input::old('institucion_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
						<a class="btn btn-primary btn-block" style="width:145px; margin-top:25px">
						<span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr class="info">												
									<th class="text-nowrap text-center">Nombre</th>
									<th></th>																				
								</tr>								
								<tr>			
									<td class="text-nowrap">							
									</td>
									<td></td>											
								</tr>					
							</table>				
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Representantes institucionales<span style='color:red'>*</span></h3>
			</div>
			<div class="panel-body">
				<div class="form-group row">
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr class="info">												
									<th class="text-nowrap text-center">Nombre</th>												
									<th class="text-nowrap text-center">Departamento</th>												
									<th class="text-nowrap text-center">Rol</th>
									<th></th>												
								</tr>								
								<tr>			
									<td class="text-nowrap">							
									</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>					
							</table>				
						</div>
					</div>				
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Representantes de entidad asociada<span style='color:red'>*</span></h3>
			</div>
			<div class="panel-body">
				<div class="form-group row">
					<div class="col-md-4">
					{{ Form::label('nombre_representante_convenio','Nombre') }}
					{{ Form::text('nombre_representante_convenio',Input::old('nombre_representante_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
					{{ Form::label('appat_representante_convenio','Apellido Paterno') }}
					{{ Form::text('appat_representante_convenio',Input::old('appat_representante_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
					{{ Form::label('apmat_representante_convenio','Apellido Materno') }}
					{{ Form::text('apmat_representante_convenio',Input::old('apmat_representante_convenio'),['class' => 'form-control'])}}
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-4">
					{{ Form::label('area_representante_convenio','Área') }}
					{{ Form::text('area_representante_convenio',Input::old('area_representante_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
					{{ Form::label('rol_representante_convenio','Rol') }}
					{{ Form::text('rol_representante_convenio',Input::old('rol_representante_convenio'),['class' => 'form-control'])}}
					</div>
					<div class="col-md-4">
						<a class="btn btn-primary btn-block" style="width:145px; margin-top:25px">
						<span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>				
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr class="info">												
									<th class="text-nowrap text-center">Nombre</th>
									<th class="text-nowrap text-center">Área</th>												
									<th class="text-nowrap text-center">Rol</th>
									<th></th>											
								</tr>								
								<tr>			
									<td class="text-nowrap">							
									</td>
									<td></td>											
									<td></td>
									<td></td>
								</tr>					
							</table>				
						</div>
					</div>				
				</div>
			</div>
		</div>		
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => 'width:145px')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" style="width:145px" href="{{route('acuerdo_convenio.index')}}">Cancelar</a>				
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