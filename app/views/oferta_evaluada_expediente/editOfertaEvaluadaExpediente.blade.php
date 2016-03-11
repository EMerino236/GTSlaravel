@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Evaluación de Oferta</h3>
            @if($expediente_tecnico_data->estado_evaluacion_ofertas_finalizada == 1)
            	<span style='color:red'>El Presidente de Comité ha finalizado la evaluación de ofertas para este expediente técnico. </span>
            @endif
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('evaluacion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'oferta_evaluada_expediente/submit_edit_oferta_evaluada_expediente', 'role'=>'form', 'files'=>true)) }}		
		{{ Form::hidden('idoferta_expediente',$oferta_expediente_data->idoferta_expediente)}}
		{{ Form::hidden('idexpediente_tecnico',$oferta_expediente_data->idexpediente_tecnico)}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la Evaluación</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						<strong><font size="4">Oferta {{$oferta_expediente_data->correlativo_por_expediente}}</font></strong>							
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('tipo_miembro')) has-error has-feedback @endif">
						{{ Form::label('tipo_miembro','Miembro') }}
						{{ Form::text('tipo_miembro',$tipo_miembro,['disabled'=>'','class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('evaluacion')) has-error has-feedback @endif">
						{{ Form::label('evaluacion','Evaluación') }}<span style='color:red'>*</span>
						@if($oferta_evaluada_expediente_data == null)
							{{ Form::textarea('evaluacion',Input::old('evaluacion'),['Placeholder'=>'Evaluación','class' => 'form-control','maxlength'=>500]) }}
						@else
							{{ Form::textarea('evaluacion',$oferta_evaluada_expediente_data->evaluacion,['Placeholder'=>'Evaluación','class' => 'form-control','maxlength'=>500]) }}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_doc_relacionado','Archivo adjunto') }}
						@if($oferta_evaluada_expediente_data == null)
							{{ Form::text('nombre_doc_relacionado','',['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
						@else
							{{ Form::text('nombre_doc_relacionado',$oferta_evaluada_expediente_data->nombre_archivo,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
						@endif
					</div>	
					@if($oferta_evaluada_expediente_data != null)
						@if($oferta_evaluada_expediente_data->deleted_at && $oferta_evaluada_expediente_data->url!='')
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" href="{{URL::to('/oferta_evaluada_expediente/download/')}}/{{$oferta_evaluada_expediente_data->idoferta_evaluada_expediente}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
							</div>
						@elseif($oferta_evaluada_expediente_data->url!='')
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" href="{{URL::to('/oferta_evaluada_expediente/download/')}}/{{$oferta_evaluada_expediente_data->idoferta_evaluada_expediente}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
							</div>
						@endif
					@endif			
					<div class="col-md-6" style="margin-top:5px"> 
						<label class="control-label">Modificar Archivo adjunto
						<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
					</div>				
				</div>
			</div>
		</div>	
		<div class="row">
			@if($expediente_tecnico_data->estado_evaluacion_ofertas_finalizada != 1)
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
			@endif
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/oferta_evaluada_expediente/list_oferta_evaluada_expedientes/')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
			</div>
		</div>
		<div class="row">
			@if($user->id == $expediente_tecnico_data->idpresidente )
				<div class="form-group col-md-6">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Finalizar Evaluación de Ofertas', array('id'=>'submit_finalizar_evaluacion_ofertas', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
			@endif
		</div>	
	{{ Form::close() }}
	
	<script>
		$("#input-file").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>
	
@stop