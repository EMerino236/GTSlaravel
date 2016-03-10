@extends('templates/iperTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Nuevo Reporte</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('periodicidad') }}</strong></p>
			<p><strong>{{ $errors->first('servicio') }}</strong></p>
			<p><strong>{{ $errors->first('entorno') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
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

	{{ Form::open(array('url'=>'ipers/submit_create_iper', 'role'=>'form', 'files'=>true)) }}
		{{Form::hidden('tipo',$tipo)}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-3 col-md-offset-2 @if($errors->first('fecha')) has-error has-feedback @endif">
						{{ Form::label('fecha','Fecha') }}
						<div id="datetimepicker1" class="form-group input-group date">
							{{ Form::text('fecha',Input::old('fecha'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="form-group col-md-2 @if($errors->first('periodicidad')) has-error has-feedback @endif">
						{{ Form::label('periodicidad','Periodicidad:') }}
						{{ Form::select('periodicidad',array(''=>'Seleccione')+ $periodicidades,'I',['class' => 'form-control','disabled'=>'disabled']) }}
					</div>
					@if($tipo==1)
						<div class="form-group col-md-3 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio:') }}
							{{ Form::select('servicio',array(''=>'Seleccione')+ $servicios,Input::old('servicio'),['class' => 'form-control']) }}
						</div>
					@else
						<div class="form-group col-md-3 @if($errors->first('entorno')) has-error has-feedback @endif">
							{{ Form::label('entorno','Entorno Asistencial:') }}
							{{ Form::select('entorno',array(''=>'Seleccione')+ $entornos,Input::old('entorno'),['class' => 'form-control']) }}
						</div>
					@endif
				</div>	
				<div class="row">
					<div class="form-group col-md-8 col-md-offset-2 @if($errors->first('archivo')) has-error has-feedback @endif">
						<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,pdf,doc,docx,xls,xlsx,ppt,pptx)
						<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
					</div>
				</div>	
			</div>
		</div>
			<div class="row">
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/ipers/list_ipers')}}/{{$tipo}}">Cancelar</a>				
				</div>
			</div>		
		</div>	
	{{ Form::close() }}
	
	<script>
		$("#input-file").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>
	
@stop