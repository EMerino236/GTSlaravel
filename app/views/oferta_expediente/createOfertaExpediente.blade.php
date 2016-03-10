@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Oferta</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idproveedor') }}</strong></p>
			<p><strong>{{ $errors->first('precio') }}</strong></p>
			<p><strong>{{ $errors->first('caracteristicas') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'oferta_expediente/submit_create_oferta_expediente', 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('idexpediente_tecnico',$expediente_tecnico_data->idexpediente_tecnico)}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la Oferta</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
						{{ Form::label('codigo_compra','Código de Compra') }}
						{{ Form::text('codigo_compra',$expediente_tecnico_data->codigo_compra,['disabled'=>'','class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						@if($last_oferta_por_expediente == null)
							<strong><font size="4">Oferta 1</font></strong>
							{{ Form::hidden('correlativo',1)}}
						@else
							<strong><font size="4">Oferta {{$last_oferta_por_expediente->correlativo_por_expediente+1}}</font></strong>
							{{ Form::hidden('correlativo',$last_oferta_por_expediente->correlativo_por_expediente+1)}}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idproveedor')) has-error has-feedback @endif">
						{{ Form::label('idproveedor','Proveedor') }}<span style='color:red'>*</span>
						{{ Form::select('idproveedor',array(''=>'Seleccione') + $proveedores,Input::old('idproveedor'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('precio')) has-error has-feedback @endif">
						{{ Form::label('precio','Precio (S/.)') }}<span style='color:red'>*</span>
						{{ Form::text('precio',Input::old('precio'),['Placeholder'=>'Precio','class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('caracteristicas')) has-error has-feedback @endif">
						{{ Form::label('caracteristicas','Características Principales') }}<span style='color:red'>*</span>
						{{ Form::textarea('caracteristicas',Input::old('caracteristicas'),['Placeholder'=>'Características Principales','class' => 'form-control','maxlength'=>255]) }}
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
					<label class="control-label">Archivo Adjunto<span style='color:red'>*</span></label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>		
			<div class="row">
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/oferta_expediente/list_oferta_expedientes/')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
				</div>
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