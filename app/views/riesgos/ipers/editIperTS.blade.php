@extends('templates/iperTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte {{$iper_data->codigo_abreviatura}}-{{$iper_data->codigo_tipo}}-{{$iper_data->codigo_correlativo}}-{{$iper_data->codigo_anho}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('periodicidad') }}</strong></p>
			<p><strong>{{ $errors->first('servicio') }}</strong></p>
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

	{{ Form::open(array('url'=>'ipers/submit_edit_iper', 'role'=>'form', 'files'=>true)) }}
		{{Form::hidden('iper_id',$iper_data->id)}}
		{{Form::hidden('tipo',$tipo)}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-2 @if($errors->first('codigo_reporte')) has-error has-feedback @endif">
						{{ Form::label('codigo_reporte','Código de Reporte:') }}
						{{ Form::text('codigo_reporte', $iper_data->codigo_abreviatura.'-'.$iper_data->codigo_tipo.'-'.$iper_data->codigo_correlativo.'-'.$iper_data->codigo_anho,array('class'=>'form-control','readonly'=>'')) }}
					</div>	
					@if($tipo == 1)				
						<div class="form-group col-md-3 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio:') }}
							@if($iper_data->deleted_at)
								{{ Form::select('servicio',array(''=>'Seleccione')+ $servicios,$iper_data->idservicio,['class' => 'form-control','disabled'=>'disabled']) }}
							@else
								{{ Form::select('servicio',array(''=>'Seleccione')+ $servicios,$iper_data->idservicio,['class' => 'form-control']) }}
							@endif
						</div>
					@else
						<div class="form-group col-md-3 @if($errors->first('entorno')) has-error has-feedback @endif">
							{{ Form::label('entorno','Entorno Asistencial:') }}
							@if($iper_data->deleted_at)
								{{ Form::select('entorno',array(''=>'Seleccione')+ $entornos,$iper_data->identorno_asistencial,['class' => 'form-control','disabled'=>'disabled']) }}
							@else
								{{ Form::select('entorno',array(''=>'Seleccione')+ $entornos,$iper_data->identorno_asistencial,['class' => 'form-control']) }}
							@endif
						</div>
					@endif
					<div class="form-group col-md-3 @if($errors->first('usuario')) has-error has-feedback @endif">
						{{ Form::label('usuario','Usuario:') }}
						{{ Form::text('usuario',$iper_data->nombre.' '.$iper_data->apellido_pat.' '.$iper_data->apellido_mat,array('class'=>'form-control','readonly'=>'')) }}
					</div>
					<div class="form-group col-md-2 @if($errors->first('fecha')) has-error has-feedback @endif">
						{{ Form::label('fecha','Fecha') }}
						<div id="datetimepicker1" class="form-group input-group date">
							@if($iper_data->deleted_at)
								{{ Form::text('fecha',null,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('fecha',date('d-m-Y',strtotime($iper_data->fecha)),array('class'=>'form-control','readonly'=>'')) }}
							@endif
							<span class="input-group-addon">
			                    <span class="glyphicon glyphicon-calendar"></span>
			                </span>
						</div>
					</div>
					<div class="form-group col-md-2 @if($errors->first('periodicidad')) has-error has-feedback @endif">
						{{ Form::label('periodicidad','Periodicidad:') }}
						@if($iper_data->deleted_at)
							{{ Form::select('periodicidad',array(''=>'Seleccione')+ $periodicidades,$iper_data->periodicidad,['class' => 'form-control','disabled'=>'disabled']) }}
						@else
							{{ Form::select('periodicidad',array(''=>'Seleccione')+ $periodicidades,$iper_data->periodicidad,['class' => 'form-control']) }}
						@endif
					</div>
				</div>	
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Versiones</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr class="info">
									<th class="text-nowrap text-center">N° de Versión</th>
									<th class="text-nowrap text-center">Archivo</th>
								</tr>
								@foreach($detalles_data as $detalle_data)
								<tr class="@if($detalle_data->deleted_at) bg-danger @endif">									
									<td class="text-nowrap text-center">
										{{$iper_data->codigo_abreviatura}}-{{$iper_data->codigo_tipo}}-{{$iper_data->codigo_correlativo}}-{{$iper_data->codigo_anho}}-{{$detalle_data->numero_version}}
									</td>
									<td class="text-nowrap text-center">
										<div class="row">
											<div class="form-group col-md-6">											
												{{ Form::text('arch_adjunto', $detalle_data->nombre_archivo,array('class'=>'form-control','readonly'=>'')) }}
											</div>
											<div class="form-group col-md-4">												
													@if($detalle_data->url != '')
														<a class="btn btn-success btn-block" href="{{URL::to('/ipers/download_version_iper')}}/{{$detalle_data->id}}" ><span class="glyphicon glyphicon-download"></span> Descargar</a>
													@else
														Sin archivo adjunto
													@endif
											</div>	
										</div>								
									</td>
								</tr>
								@endforeach
							</table>
						</div>
					</div>
				</div>	
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Subir Nueva Versión</h3>
			</div>
			<div class="panel-body">
				<div class="row">					
					<div class="form-group col-md-2 @if($errors->first('numero_version')) has-error has-feedback @endif">
						{{ Form::label('numero_version','Número de Versión:') }}
						{{ Form::number('numero_version',Input::old('numero_version'),array('class'=>'form-control','min'=>'0','max'=>'99999999'))}}
					</div>
					<div class="form-group col-md-10 @if($errors->first('servicio')) has-error has-feedback @endif">
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
		{{ Form::close() }}
			@if($iper_data->deleted_at)
			{{ Form::open(array('url'=>'ipers/submit_enable_iper', 'role'=>'form','id'=>'submit_enable')) }}
				{{ Form::hidden('iper_id', $iper_data->id) }}
				{{ Form::hidden('tipo',$iper_data->idtipo_iper)}}
					<div class="form-group col-md-2 col-md-offset-6">
						{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar', array('id'=>'btnEnable', 'class' => 'btn btn-success btn-block')) }}
					</div>
			{{ Form::close() }}
			@else
			{{ Form::open(array('url'=>'ipers/submit_disable_iper', 'role'=>'form','id'=>'submit_disable')) }}
				{{ Form::hidden('iper_id', $iper_data->id) }}
				{{ Form::hidden('tipo',$iper_data->idtipo_iper)}}
					<div class="form-group col-md-2 col-md-offset-6">
						{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar', array('id'=>'btnDisable', 'class' => 'btn btn-danger btn-block')) }}
					</div>
			{{ Form::close() }}
			@endif
		</div>	
	
	
	<script>
		$("#input-file").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>
	
@stop