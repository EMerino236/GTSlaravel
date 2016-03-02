@extends('templates/reporteCalibracionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte de Calibración {{$reporte_calibracion->codigo_abreviatura}}-{{$reporte_calibracion->codigo_correlativo}}-{{$reporte_calibracion->codigo_anho}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('input-file-0') }}</strong></p>
			<p><strong>{{ $errors->first('input-file-1') }}</strong></p>
			<p><strong>{{ $errors->first('input-file-2') }}</strong></p>
			<p><strong>{{ $errors->first('input-file-3') }}</strong></p>
			<p><strong>{{ $errors->first('input-file-4') }}</strong></p>
			<p><strong>{{ $errors->first('input-file-5') }}</strong></p>
			<p><strong>{{ $errors->first('input-file-6') }}</strong></p>			
			<p><strong>{{ $errors->first('input-file-7') }}</strong></p>
			<p><strong>{{ $errors->first('input-file-8') }}</strong></p>
			<p><strong>{{ $errors->first('input-file-9') }}</strong></p>
			<p><strong>{{ $errors->first('input-file-10') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_calibracion') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_proximo') }}</strong></p>
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

	{{ Form::open(array('url'=>'reportes_calibracion/submit_edit_reporte', 'role'=>'form', 'files'=> true)) }}
		{{Form::hidden('type_form',1,array('id'=>'type_form'))}}
		{{Form::hidden('reporte_id',$reporte_calibracion->id)}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Documentos del Reporte</h3>
			</div>
			<div class="panel-body">
				{{Form::hidden('cantidad_detalle',count($detalles_reporte_calibracion),array('id'=>'cantidad_detalle'))}}
				@foreach($detalles_reporte_calibracion as $index => $detalle)
					<div class="row" >
	        			<div class="col-md-4 form-group">
	        				{{ Form::label('label_doc',($index+1).') Certificado de Calibración:') }}
	        				{{ Form::text('nombre_doc',$detalle->nombre_archivo,array('class'=>'form-control','id'=>'file-'.$index))}}								
	       				</div>
	       				<div class="col-md-2" style="margin-top:25px;">
	       					@if($detalle->url != '')
								<a class="btn btn-success btn-block" id="btn-{{$index}}" href="{{URL::to('/reportes_calibracion/download_documento_anexo')}}/{{$detalle->id}}" ><span class="glyphicon glyphicon-download"></span> Descargar</a>
							@else
								Sin archivo adjunto
							@endif
	       				</div>
	       				<div class="col-md-6 form-group @if($errors->first('input-file-'.$index)) has-error has-feedback @endif">
	        				{{ Form::label('label_doc','Reemplazar Certificado de Calibración:') }}{{ Form::checkbox('seleccionado-'.$index,$index,false,array('id'=>'seleccionado-'.$index,'class'=>'checkbox-metodo')) }}
							<input name="input-file-{{$index}}" disabled id="input-file-{{$index}}" type="file" class="file file-loading" data-show-upload="false">
	       				</div>
	       			</div>
	       			@endforeach
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-md-offset-4 form-group">
				¿Desea agregar nuevos archivos? {{ Form::checkbox('cb_nuevos_documentos',0,false,array('id'=>'cb_nuevos_documentos')) }}
			</div>
		</div>
		<div id="div_nuevos_documentos" style="display:none;">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Nuevos Documentos</h3>
				</div>
				<div class="panel-body">
					@for($i = count($detalles_reporte_calibracion) ; $i < 10 ; $i++ )
						<div class="row" style="@if($i>count($detalles_reporte_calibracion)) display:none; @endif" id="div_file_{{$i}}" >
		        			<div class="col-md-8 col-md-offset-2 form-group">
		        				{{ Form::label('label_doc',($i+1).') Certificado de Calibración/Reporte de Calibración:') }}
								<input name="input-file-{{$i}}" id="input-file-{{$i}}" type="file" class="file file-loading" data-show-upload="false">
		       				</div>
		       				@if($i>count($detalles_reporte_calibracion))
		       				<div class="col-md-2" style="margin-top:25px;">
		       					<a href='' class='btn btn-danger delete-detail' onclick='hide_div_edit(event,{{$i}})'><span class="glyphicon glyphicon-remove"></span></a>
		       				</div>
		       				@endif
		       			</div>
		       		@endfor
		       		<div class="row"> 
			       		<div class="form-group col-md-3">
							<a class="btn btn-success btn-block" onclick="show_files_edit(event)"><span class="glyphicon glyphicon-plus"></span> Agregar Documentos</a>				
						</div>
		       		</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Fechas de Calibración</h3>
			</div>
			<div class="panel-body">
				<div class="row">
       				<div class="form-group col-md-6">
						{{ Form::label('fecha_calibracion','Fecha de Calibracion') }}
						<div id="fecha_calibracion_datetimepicker" class=" input-group date @if($errors->first('fecha_calibracion')) has-error has-feedback @endif">
							{{ Form::text('fecha_calibracion',date('d-m-Y',strtotime($reporte_calibracion->fecha_calibracion)),array('class'=>'form-control','readonly'=>'','id'=>'fecha_calibracion')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="form-group col-md-6">
						{{ Form::label('fecha_proximo','Fecha Próxima de Calibración') }}
						<div id="fecha_proximo_datetimepicker" class=" input-group date @if($errors->first('fecha_proximo')) has-error has-feedback @endif">
							{{ Form::text('fecha_proximo',date('d-m-Y',strtotime($reporte_calibracion->fecha_proxima_calibracion)),array('class'=>'form-control','readonly'=>'','id'=>'fecha_proximo')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
       			</div>
			</div>
		</div>
			<div class="row">
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('reportes_calibracion/list_reportes_calibracion')}}">Cancelar</a>				
				</div>
	{{ Form::close() }}
			@if($reporte_calibracion->idestado == 27)
			{{ Form::open(array('url'=>'reportes_calibracion/submit_terminado_reporte', 'role'=>'form','id'=>'submit_terminado')) }}
				{{ Form::hidden('reporte_id', $reporte_calibracion->id) }}
					<div class="form-group col-md-3 col-md-offset-3">
						{{ Form::button('<span class="glyphicon glyphicon-ok"></span> Terminar Calibración', array('id'=>'btnTerminado', 'class' => 'btn btn-success btn-block')) }}
					</div>
			{{ Form::close() }}
			{{ Form::open(array('url'=>'reportes_calibracion/submit_disable_reporte', 'role'=>'form','id'=>'submit_disable')) }}
				{{ Form::hidden('reporte_id', $reporte_calibracion->id) }}
					<div class="form-group col-md-2">
						{{ Form::button('<span class="glyphicon glyphicon-remove"></span> Anular Reporte', array('id'=>'btnDisable', 'class' => 'btn btn-danger btn-block')) }}
					</div>
			{{ Form::close() }}
			@endif

			</div>
	
	<script>
		for(i=0;i<10;i++){
			$("#input-file-"+i).fileinput({
			    language: "es",
			    maxFileSize: 15360,
			    allowedFileExtensions: ["png","jpe","jpeg","jpg","pdf","doc","docx","xls","xlsx","ppt","pptx"]
			});
		}
	</script>
	
@stop