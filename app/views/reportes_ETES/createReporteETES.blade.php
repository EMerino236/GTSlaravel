@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Reporte ETES</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idprogramacion_reporte_etes') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'reporte_etes/submit_create_reporte_etes', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idprogramacion_reporte_etes')) has-error has-feedback @endif">
						{{ Form::label('idprogramacion_reporte_etes','Programaciones No Concluidas') }}<span style='color:red'>*</span>
						{{ Form::select('idprogramacion_reporte_etes',array(''=>'Seleccione') + $programaciones_reporte_etes,$programacion_reporte_etes_id,['class' => 'form-control']) }}
					</div>
				<div class="row">
					<div class="form-group col-md-8">
						@if(!$programaciones_reporte_etes)
							<span style='color:red'>No existen reportes CN programados. </span><a href="{{URL::to('/programacion_reportes/create_programacion_reportes')}}"><span style='color:red'><u>Agregar Programación aquí.</u></span></a>						
						@endif
					</div>
				</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_reporte_select')) has-error has-feedback @endif">
						{{ Form::label('idtipo_reporte_select','Tipo de Reporte') }}
						@if($programacion_reporte_etes)
							{{ Form::select('idtipo_reporte_select',array(''=>'Seleccione') + $tipo_reporte_etes,$programacion_reporte_etes->idtipo_reporte_ETES,['class' => 'form-control','disabled'=>'disabled']) }}
						@else
							{{ Form::select('idtipo_reporte_select',array(''=>'Seleccione') + $tipo_reporte_etes,'',['class' => 'form-control','disabled'=>'disabled']) }}
						@endif
						{{ Form::hidden('idtipo_reporte')}}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-8 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre de Reporte') }}
						@if($programacion_reporte_etes)
							{{ Form::text('nombre',$programacion_reporte_etes->nombre_reporte,['class' => 'form-control','disabled'=>'disabled']) }}
						@else
							{{ Form::text('nombre','',['class' => 'form-control','disabled'=>'disabled']) }}
						@endif
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
					<label class="control-label">Seleccione un Documento<span style='color:red'>*</span></label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>		
			<div class="row">
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/reporte_etes/list_reporte_etes/')}}">Regresar</a>				
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