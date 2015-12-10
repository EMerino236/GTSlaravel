@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Reporte: {{$reporte_cn_info->numero_reporte_abreviatura}}{{$reporte_cn_info->numero_reporte_correlativo}}-{{$reporte_cn_info->numero_reporte_anho}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('codigo_ot_retiro') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_reporte') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_reporte')) has-error has-feedback @endif">
						{{ Form::label('idtipo_reporte','Tipo de Reporte') }}
						{{ Form::select('idtipo_reporte',array(''=>'Seleccione') + $tipo_reporte_cn,$programacion_reporte_cn_info->idtipo_reporte_CN,['class' => 'form-control','disabled'=>'disabled']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idservicio')) has-error has-feedback @endif">
						{{ Form::label('idservicio','Servicio') }}
						{{ Form::select('idservicio',array(''=>'Seleccione') + $servicios,$programacion_reporte_cn_info->idservicio,['class' => 'form-control','disabled'=>'disabled']) }}
					</div><div class="form-group col-md-4 @if($errors->first('idarea_select')) has-error has-feedback @endif">
						{{ Form::label('idarea_select','Departamento') }}
						{{ Form::select('idarea_select',array(''=>'Seleccione') + $areas,$programacion_reporte_cn_info->idarea,['class' => 'form-control','disabled'=>'disabled']) }}
						{{ Form::hidden('idarea')}}
					</div>
				</div>		
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_ot_retiro')) has-error has-feedback @endif">
						{{ Form::label('codigo_ot_retiro','OT de Baja de Equipo') }}
						{{ Form::text('codigo_ot_retiro',$otretiro_info->ot_tipo_abreviatura.$otretiro_info->ot_correlativo.$otretiro_info->ot_activo_abreviatura,array('placeholder'=>'RS0001TS','class'=>'form-control','maxlength'=>8,'readonly'=>'')) }}
						{{ Form::hidden('idot_retiro')}}
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
						{{ Form::label('nombre_equipo','Nombre de Equipo') }}
						{{ Form::text('nombre_equipo',$otretiro_info->nombre_equipo,array('class'=>'form-control','readonly'=>'')) }}
					</div>
				</div>	
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default" id="panel-documentos-relacionados">
	  				<div class="panel-heading">Documento Relacionado</div>
	  				<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-4">
								{{ Form::label('nombre_doc_relacionado','Nombre de Documento') }}
								{{ Form::text('nombre_doc_relacionado',$reporte_cn_info->nombre_archivo,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($reporte_cn_info->deleted_at)
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/reporte_cn/download_documento/')}}/{{$reporte_cn_info->idreporte_CN}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@else
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/reporte_cn/download_documento/')}}/{{$reporte_cn_info->idreporte_CN}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@endif						
						</div>
					</div>
				</div>
			</div>
		</div>	
	{{ Form::close() }}
		<div class="row">
			<div class="form-group col-md-2">
			@if($reporte_cn_info->deleted_at)
				{{ Form::open(array('url'=>'reporte_cn/submit_enable_reporte_cn', 'role'=>'form')) }}
					{{ Form::hidden('idreporte_CN', $reporte_cn_info->idreporte_CN) }}
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar',array('id'=>'submit-enable', 'type' => 'submit', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'reporte_cn/submit_disable_reporte_cn', 'role'=>'form','id'=>'submitDelete')) }}
					{{ Form::hidden('idreporte_CN', $reporte_cn_info->idreporte_CN) }}
					 {{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar',array('id'=>'submit-delete', 'type' => 'submit', 'class'=>'btn btn-danger')) }}	
			@endif
				{{ Form::close() }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/reporte_cn/list_reporte_cn/')}}">Regresar</a>				
			</div>
		</div>	
@stop