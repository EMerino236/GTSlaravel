@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Observacion para la Oferta {{$oferta_expediente_data->correlativo_por_expediente}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idtipo_observacion_expediente') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'observacion_expediente/submit_create_observacion_expediente', 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('idoferta_expediente',$oferta_expediente_data->idoferta_expediente)}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la Observación</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre_usuario')) has-error has-feedback @endif">
						{{ Form::label('nombre_usuario','Usuario') }}
						{{ Form::text('nombre_usuario',$user->username,['disabled'=>'','class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						@if($last_observacion_por_oferta == null)
							<strong><font size="4">Observación 1</font></strong>
							{{ Form::hidden('correlativo',1)}}
						@else
							<strong><font size="4">Observación {{$last_observacion_por_oferta->correlativo_por_oferta+1}}</font></strong>
							{{ Form::hidden('correlativo',$last_observacion_por_oferta->correlativo_por_oferta+1)}}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_observacion_expediente')) has-error has-feedback @endif">
						{{ Form::label('idtipo_observacion_expediente','Tipo de Observación') }}<span style='color:red'>*</span>
						{{ Form::select('idtipo_observacion_expediente',array(''=>'Seleccione') + $tipo_observacion_expediente,Input::old('idtipo_observacion'),['class' => 'form-control']) }}
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
					<a class="btn btn-default btn-block" href="{{URL::to('/observacion_expediente/list_observacion_expedientes/')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
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
	{{ Form::close() }}
	
@stop