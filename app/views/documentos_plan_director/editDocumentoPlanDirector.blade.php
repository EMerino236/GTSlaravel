@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Documento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idtipo_documento') }}</strong></p>
			<p><strong>{{ $errors->first('anho') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'plan_director/submit_edit_documento_plan_director', 'role'=>'form', 'files'=>true)) }}
	{{ Form::hidden('iddocumentosPlanDirector', $documento_plan_director_info->iddocumentosPlanDirector) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_documento')) has-error has-feedback @endif">
						{{ Form::label('idtipo_documento','Tipo de Documento') }}<span style="color:red">*</span>
						{{ Form::select('idtipo_documento',array(''=>'Seleccione') + $tipo_documento,$documento_plan_director_info->idtipo_documentosPlanDirector,['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}<span style="color:red">*</span>
						{{ Form::text('nombre',$documento_plan_director_info->nombre,['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('anho')) has-error has-feedback @endif">
						{{ Form::label('anho','Año') }}<span style="color:red">*</span>
						<div id="datetimepicker_cotizacion" class="input-group date">
							{{ Form::text('anho',$documento_plan_director_info->anho,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
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
								{{ Form::text('nombre_doc_relacionado',$documento_plan_director_info->nombre_archivo,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($documento_plan_director_info->deleted_at)
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/plan_director/download_documento/')}}/{{$documento_plan_director_info->iddocumentosPlanDirector}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@else
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/plan_director/download_documento/')}}/{{$documento_plan_director_info->iddocumentosPlanDirector}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@endif						
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="row">
			@if(!$documento_plan_director_info->deleted_at)
				<div class="form-group col-md-1">
					{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			@endif
	{{ Form::close() }}
			<div class="form-group col-md-2">
			@if($documento_plan_director_info->deleted_at)
				{{ Form::open(array('url'=>'plan_director/submit_enable_documento_plan_director', 'role'=>'form')) }}
					{{ Form::hidden('iddocumentosPlanDirector', $documento_plan_director_info->iddocumentosPlanDirector) }}
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar',array('id'=>'submit-enable', 'type' => 'submit', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'plan_director/submit_disable_documento_plan_director', 'role'=>'form','id'=>'submitDelete')) }}
					{{ Form::hidden('iddocumentosPlanDirector', $documento_plan_director_info->iddocumentosPlanDirector) }}
					 {{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar',array('id'=>'submit-delete', 'type' => 'submit', 'class'=>'btn btn-danger')) }}	
			@endif
				{{ Form::close() }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/plan_director/list_documento_plan_director/')}}">Regresar</a>				
			</div>
		</div>	
@stop