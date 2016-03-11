@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Observacion para la Oferta {{$oferta_expediente_data->correlativo_por_expediente}}</h3>
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

	{{ Form::open(array('url'=>'observacion_expediente/submit_edit_observacion_expediente', 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('idoferta_expediente',$oferta_expediente_data->idoferta_expediente)}}
		{{ Form::hidden('idobservacion_expediente',$observacion_expediente_data->idobservacion_expediente)}}
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
							<strong><font size="4">Observación {{$observacion_expediente_data->correlativo_por_oferta}}</font></strong>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_observacion_expediente')) has-error has-feedback @endif">
						{{ Form::label('idtipo_observacion_expediente','Tipo de Observación') }}<span style='color:red'>*</span>
						{{ Form::select('idtipo_observacion_expediente',array(''=>'Seleccione') + $tipo_observacion_expediente,$observacion_expediente_data->idtipo_observacion_expediente,['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}<span style='color:red'>*</span>
						{{ Form::textarea('descripcion',$observacion_expediente_data->descripcion,['Placeholder'=>'Descripción','class' => 'form-control','maxlength'=>255]) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_doc_relacionado','Archivo adjunto') }}
						{{ Form::text('nombre_doc_relacionado',$observacion_expediente_data->nombre_archivo,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
					</div>	
					@if($observacion_expediente_data->deleted_at)
						<div class="form-group col-md-2" style="margin-top:25px">
							<a class="btn btn-primary btn-block" href="{{URL::to('/observacion_expediente/download/')}}/{{$observacion_expediente_data->idobservacion_expediente}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
						</div>
					@else
						<div class="form-group col-md-2" style="margin-top:25px">
							<a class="btn btn-primary btn-block" href="{{URL::to('/observacion_expediente/download/')}}/{{$observacion_expediente_data->idobservacion_expediente}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
						</div>
					@endif			
					<div class="col-md-6" style="margin-top:5px"> 
						<label class="control-label">Modificar Archivo adjunto
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
				<a class="btn btn-default btn-block" href="{{URL::to('/observacion_expediente/list_observacion_expedientes/')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
			</div>
		</div>	
	{{ Form::close() }}
	{{ Form::close() }}
	
@stop