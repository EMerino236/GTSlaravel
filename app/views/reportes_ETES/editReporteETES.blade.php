@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Reporte: {{$reporte_etes_info->numero_reporte_abreviatura}}{{$reporte_etes_info->numero_reporte_correlativo}}-{{$reporte_etes_info->numero_reporte_anho}}</h3>
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
						{{ Form::select('idtipo_reporte',array(''=>'Seleccione') + $tipo_reporte_etes,$programacion_reporte_etes_info->idtipo_reporte_ETES,['class' => 'form-control','disabled'=>'disabled']) }}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-8 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre de Reporte') }}
						{{ Form::text('nombre',$programacion_reporte_etes_info->nombre_reporte,['class' => 'form-control','readonly'=>'']) }}
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
								{{ Form::text('nombre_doc_relacionado',$reporte_etes_info->nombre_archivo,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($reporte_etes_info->deleted_at)
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/reporte_etes/download_documento/')}}/{{$reporte_etes_info->idreporte_ETES}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@else
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/reporte_etes/download_documento/')}}/{{$reporte_etes_info->idreporte_ETES}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
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
			@if($reporte_etes_info->deleted_at)
				{{ Form::open(array('url'=>'reporte_etes/submit_enable_reporte_etes', 'role'=>'form')) }}
					{{ Form::hidden('idreporte_ETES', $reporte_etes_info->idreporte_ETES) }}
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar',array('id'=>'submit-enable', 'type' => 'submit', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'reporte_etes/submit_disable_reporte_etes', 'role'=>'form','id'=>'submitDelete')) }}
					{{ Form::hidden('idreporte_ETES', $reporte_etes_info->idreporte_ETES) }}
					 {{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar',array('id'=>'submit-delete', 'type' => 'submit', 'class'=>'btn btn-danger')) }}	
			@endif
				{{ Form::close() }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/reporte_etes/list_reporte_etes/')}}">Regresar</a>				
			</div>
		</div>	
@stop