@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Adjudicación y Contrato Firmado</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idproveedor_ganador') }}</strong></p>
			<p><strong>{{ $errors->first('precio_ganador') }}</strong></p>
			<p><strong>{{ $errors->first('archivo_contrato') }}</strong></p>
			<p><strong>{{ $errors->first('archivo_adicional') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'adjudicacion_expediente/submit_edit_adjudicacion_expediente', 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('idexpediente_tecnico',$expediente_tecnico_data->idexpediente_tecnico)}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Expediente Técnico</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
						{{ Form::label('codigo_compra','Código de Compra') }}
						{{ Form::text('codigo_compra',$expediente_tecnico_data->codigo_compra,['disabled'=>'','class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('codigo_archivamiento')) has-error has-feedback @endif">
						{{ Form::label('codigo_archivamiento','Código de Archivamiento') }}
						{{ Form::text('codigo_archivamiento',$expediente_tecnico_data->codigo_archivamiento,['disabled'=>'','class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
						{{ Form::label('nombre_equipo','Nombre de Equipo') }}
						@if($expediente_tecnico_data->nombre_equipo != 0)
							{{ Form::text('nombre_equipo',$expediente_tecnico_data->nombre_equipo,['disabled'=>'','class' => 'form-control']) }}
						@else
							{{ Form::text('nombre_equipo',$expediente_tecnico_data->otros_equipos,['disabled'=>'','class' => 'form-control']) }}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}
						{{ Form::textarea('descripcion',$expediente_tecnico_data->descripcion,['disabled'=>'','class' => 'form-control']) }}
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la Adjudicación y Contrato Firmado</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idproveedor_ganador')) has-error has-feedback @endif">
						{{ Form::label('idproveedor_ganador','Proveedor') }}<span style='color:red'>*</span>						
						{{ Form::hidden('proveedor_selected',$expediente_tecnico_data->idproveedor_ganador)}}
						<select name="idproveedor_ganador" class="form-control">
							<option value="">Seleccione</option>  
						    <?php foreach($proveedores as $proveedor){ ?>
			                    <option value="<?php echo $proveedor['idproveedor']; ?>" <?php if(Input::old("idproveedor_ganador") == $proveedor['idproveedor']){echo("selected");} elseif( $expediente_tecnico_data['idproveedor_ganador'] == $proveedor['idproveedor']){echo("selected");}?>><?php echo $proveedor['nombre_proveedor']; ?></option> 
						    <?php } ?>						   
    					</select>	
					</div>
					<div class="form-group col-md-4 @if($errors->first('precio_ganador')) has-error has-feedback @endif">
						{{ Form::label('precio_ganador','Precio (S/.)') }}<span style='color:red'>*</span>
						@if($expediente_tecnico_data->precio_ganador != '')
							{{ Form::text('precio_ganador',$expediente_tecnico_data->precio_ganador,['Placeholder'=>'Precio','class' => 'form-control']) }}
						@else
							{{ Form::text('precio_ganador',Input::old('precio_ganador'),['Placeholder'=>'Precio','class' => 'form-control']) }}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_doc_relacionado','Contrato') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_doc_relacionado',$expediente_tecnico_data->nombre_archivo_contrato,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
					</div>	
					@if($expediente_tecnico_data->nombre_archivo_contrato != '')
						@if($expediente_tecnico_data->deleted_at)
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" href="{{URL::to('/adjudicacion_expediente/download_contrato/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
							</div>
						@else
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" href="{{URL::to('/adjudicacion_expediente/download_contrato/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
							</div>
						@endif		
					@endif	
					<div class="col-md-6" style="margin-top:5px"> 
						<label class="control-label">Modificar Archivo adjunto
						<input name="archivo_contrato" id="input-file_contrato" type="file" class="file file-loading" data-show-upload="false">
					</div>				
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_doc_relacionado','Documentos Adicionales') }}
						{{ Form::text('nombre_doc_relacionado',$expediente_tecnico_data->nombre_archivo_documento_adicional,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
					</div>	
					@if($expediente_tecnico_data->nombre_archivo_documento_adicional != '')
						@if($expediente_tecnico_data->deleted_at)
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" href="{{URL::to('/adjudicacion_expediente/download_documento_adicional/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
							</div>
						@else
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" href="{{URL::to('/adjudicacion_expediente/download_documento_adicional/')}}/{{$expediente_tecnico_data->idexpediente_tecnico}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
							</div>
						@endif	
					@endif		
					<div class="col-md-6" style="margin-top:5px"> 
						<label class="control-label">Modificar Archivo adjunto
						<input name="archivo_adicional" id="input-file_adicional" type="file" class="file file-loading" data-show-upload="false">
					</div>				
				</div>
			</div>
		</div>	
		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/adjudicacion_expediente/list_adjudicacion_expedientes/')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
			</div>
		</div>		
		</div>	
	{{ Form::close() }}
	
	<script>
		$("#input-file_contrato").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
		$("#input-file_adicional").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>
	
@stop