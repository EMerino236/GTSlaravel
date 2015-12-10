@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Reporte de Instalación</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idprogramacion_reporte_paac') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'reporte_paac/submit_create_reporte_paac', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idprogramacion_reporte_paac')) has-error has-feedback @endif">
						{{ Form::label('idprogramacion_reporte_paac','Programaciones No Concluidas') }}
						{{ Form::select('idprogramacion_reporte_paac',array(''=>'Seleccione') + $programaciones_reporte_paac,$programacion_reporte_paac_id,['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_reporte_select')) has-error has-feedback @endif">
						{{ Form::label('idtipo_reporte_select','Tipo de Reporte') }}
						@if($programacion_reporte_paac)
							{{ Form::select('idtipo_reporte_select',array(''=>'Seleccione') + $tipo_reporte_paac,$programacion_reporte_paac->idtipo_reporte_PAAC,['class' => 'form-control','disabled'=>'disabled']) }}
						@else
							{{ Form::select('idtipo_reporte_select',array(''=>'Seleccione') + $tipo_reporte_paac,'',['class' => 'form-control','disabled'=>'disabled']) }}
						@endif
						{{ Form::hidden('idtipo_reporte')}}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idservicio')) has-error has-feedback @endif">
						{{ Form::label('idservicio','Servicio') }}
						@if($programacion_reporte_paac)
							{{ Form::select('idservicio',array(''=>'Seleccione') + $servicios,$programacion_reporte_paac->idservicio,['class' => 'form-control','disabled'=>'disabled']) }}
						@else
							{{ Form::select('idservicio',array(''=>'Seleccione') + $servicios,'',['class' => 'form-control','disabled'=>'disabled']) }}
						@endif
					</div><div class="form-group col-md-4 @if($errors->first('idarea_select')) has-error has-feedback @endif">
						{{ Form::label('idarea_select','Departamento') }}
						@if($programacion_reporte_paac)
							{{ Form::select('idarea_select',array(''=>'Seleccione') + $areas,$programacion_reporte_paac->idarea,['class' => 'form-control','disabled'=>'disabled']) }}
						@else
							{{ Form::select('idarea_select',array(''=>'Seleccione') + $areas,'',['class' => 'form-control','disabled'=>'disabled']) }}
						@endif
						{{ Form::hidden('idarea')}}
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
					<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>		
			<div class="row">
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/reporte_paac/list_reporte_paac/')}}">Regresar</a>				
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