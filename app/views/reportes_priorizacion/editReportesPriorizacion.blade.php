@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Información del Reporte: {{$reporte_priorizacion_info->numero_reporte_abreviatura}}{{$reporte_priorizacion_info->numero_reporte_correlativo}}-{{$reporte_priorizacion_info->numero_reporte_anho}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><stong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'reporte_priorizacion/submit_edit_reporte_priorizacion', 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('idreporte_priorizacion', $reporte_priorizacion_info->idreporte_priorizacion) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idservicio')) has-error has-feedback @endif">
						{{ Form::label('idservicio','Servicio') }}
						{{ Form::select('idservicio',array(''=>'Seleccione') + $servicios,$reporte_priorizacion_info->idservicio,['class' => 'form-control','disabled'=>'disabled']) }}
					</div><div class="form-group col-md-4 @if($errors->first('idarea_select')) has-error has-feedback @endif">
						{{ Form::label('idarea_select','Departamento') }}
						{{ Form::select('idarea_select',array(''=>'Seleccione') + $areas,$reporte_priorizacion_info->idarea,['class' => 'form-control','disabled'=>'disabled']) }}
						{{ Form::hidden('idarea')}}
					</div>
				</div>		
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('num_doc_responsable_priorizacion')) has-error has-feedback @endif">
						{{ Form::label('num_doc_responsable_priorizacion','N° Documento Responsable',array('id'=>'num_doc_responsable_priorizacion_label')) }}
						{{ Form::text('num_doc_responsable_priorizacion',$responsable_info->numero_doc_identidad,array('class'=>'form-control','maxlength'=>8,'readonly'=>'')) }}
						{{ Form::hidden('idresponsable_priorizacion')}}
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_responsable_priorizacion')) has-error has-feedback @endif">
						{{ Form::label('nombre_responsable_priorizacion','Nombre de Responsable',array('id'=>'nombre_responsable_priorizacion_label')) }}
						{{ Form::text('nombre_responsable_priorizacion',$responsable_info->apellido_pat.' '.$responsable_info->apellido_mat.' '.$responsable_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<strong>Reportes de Necesidad Vinculados</strong>  (Los reportes deben tener al menos un Reporte ETES vinculado)
					</div>
				</div>
				<div id="div_cn1" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn1')) has-error has-feedback @endif">					
						@if($reporte_cn_info1)
							{{ Form::text('codigo_reporte_cn1',$reporte_cn_info1->numero_reporte_abreviatura.$reporte_cn_info1->numero_reporte_correlativo.'-'.$reporte_cn_info1->numero_reporte_anho,array('id'=>'codigo_reporte_cn1', 'readonly'=>'','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('idreporte_cn1',$reporte_cn_info1->idreporte_CN)}}
						@else
							{{ Form::text('codigo_reporte_cn1',Input::old('codigo_reporte_cn1'),array('id'=>'codigo_reporte_cn1', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('idreporte_cn1')}}
						@endif
					</div>
					@if(!$reporte_cn_info1)
						<div class="form-group col-md-2">
							<a id="btn_validar_cn1" class="btn btn-primary btn-block" onclick="validar_cn(1)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
						</div>
						<div class="form-group col-md-2" style="margin-left:15px">
							<a id="btn_limpiar_cn1" class="btn btn-default btn-block" onclick="limpiar_cn(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
						</div>
					@endif
				</div>
				<div id="div_cn2" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn2')) has-error has-feedback @endif">					
						@if($reporte_cn_info2)
							{{ Form::text('codigo_reporte_cn2',$reporte_cn_info2->numero_reporte_abreviatura.$reporte_cn_info2->numero_reporte_correlativo.'-'.$reporte_cn_info2->numero_reporte_anho,array('id'=>'codigo_reporte_cn2', 'readonly'=>'','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('idreporte_cn2',$reporte_cn_info2->idreporte_CN)}}
						@else
							{{ Form::text('codigo_reporte_cn2',Input::old('codigo_reporte_cn2'),array('id'=>'codigo_reporte_cn2', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('idreporte_cn2')}}
						@endif
					</div>
					@if(!$reporte_cn_info2)
						<div class="form-group col-md-2">
							<a id="btn_validar_cn2" class="btn btn-primary btn-block" onclick="validar_cn(2)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
						</div>
						<div class="form-group col-md-2" style="margin-left:15px">
							<a id="btn_limpiar_cn2" class="btn btn-default btn-block" onclick="limpiar_cn(2)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
						</div>
					@endif
				</div>
				<div id="div_cn3" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn3')) has-error has-feedback @endif">					
						@if($reporte_cn_info3)
							{{ Form::text('codigo_reporte_cn3',$reporte_cn_info3->numero_reporte_abreviatura.$reporte_cn_info3->numero_reporte_correlativo.'-'.$reporte_cn_info3->numero_reporte_anho,array('id'=>'codigo_reporte_cn3', 'readonly'=>'','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('idreporte_cn3',$reporte_cn_info3->idreporte_CN)}}
						@else
							{{ Form::text('codigo_reporte_cn3',Input::old('codigo_reporte_cn3'),array('id'=>'codigo_reporte_cn3', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('idreporte_cn3')}}
						@endif
					</div>
					@if(!$reporte_cn_info3)
						<div class="form-group col-md-2">
							<a id="btn_validar_cn3" class="btn btn-primary btn-block" onclick="validar_cn(3)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
						</div>
						<div class="form-group col-md-2" style="margin-left:15px">
							<a id="btn_limpiar_cn3" class="btn btn-default btn-block" onclick="limpiar_cn(3)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
						</div>
					@endif
				</div>
				<div id="div_cn4" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn4')) has-error has-feedback @endif">					
						@if($reporte_cn_info4)
							{{ Form::text('codigo_reporte_cn4',$reporte_cn_info4->numero_reporte_abreviatura.$reporte_cn_info4->numero_reporte_correlativo.'-'.$reporte_cn_info4->numero_reporte_anho,array('id'=>'codigo_reporte_cn4', 'readonly'=>'','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('idreporte_cn4',$reporte_cn_info4->idreporte_CN)}}
						@else
							{{ Form::text('codigo_reporte_cn4',Input::old('codigo_reporte_cn4'),array('id'=>'codigo_reporte_cn4', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('idreporte_cn4')}}
						@endif
					</div>
					@if(!$reporte_cn_info4)
						<div class="form-group col-md-2">
							<a id="btn_validar_cn4" class="btn btn-primary btn-block" onclick="validar_cn(4)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
						</div>
						<div class="form-group col-md-2" style="margin-left:15px">
							<a id="btn_limpiar_cn4" class="btn btn-default btn-block" onclick="limpiar_cn(4)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
						</div>
					@endif
				</div>
				<div id="div_cn5" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn5')) has-error has-feedback @endif">					
						@if($reporte_cn_info5)
							{{ Form::text('codigo_reporte_cn5',$reporte_cn_info5->numero_reporte_abreviatura.$reporte_cn_info5->numero_reporte_correlativo.'-'.$reporte_cn_info5->numero_reporte_anho,array('id'=>'codigo_reporte_cn5', 'readonly'=>'','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('idreporte_cn5',$reporte_cn_info5->idreporte_CN)}}
						@else
							{{ Form::text('codigo_reporte_cn5',Input::old('codigo_reporte_cn5'),array('id'=>'codigo_reporte_cn5', 'placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('idreporte_cn5')}}
						@endif
					</div>
					@if(!$reporte_cn_info5)
						<div class="form-group col-md-2">
							<a id="btn_validar_cn5" class="btn btn-primary btn-block" onclick="validar_cn(5)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
						</div>
						<div class="form-group col-md-2" style="margin-left:15px">
							<a id="btn_limpiar_cn5" class="btn btn-default btn-block" onclick="limpiar_cn(5)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
						</div>
					@endif
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
								{{ Form::text('nombre_doc_relacionado',$reporte_priorizacion_info->nombre_archivo,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($reporte_priorizacion_info->deleted_at)
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/reporte_priorizacion/download_documento/')}}/{{$reporte_priorizacion_info->idreporte_priorizacion}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@else
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/reporte_priorizacion/download_documento/')}}/{{$reporte_priorizacion_info->idreporte_priorizacion}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@endif						
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="row">
			@if(!$reporte_priorizacion_info->deleted_at)
				<div class="col-md-2 form-group">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}						
				</div>
			@endif
	{{ Form::close() }}
			<div class="form-group col-md-2">
			@if($reporte_priorizacion_info->deleted_at)
				{{ Form::open(array('url'=>'reporte_priorizacion/submit_enable_reporte_priorizacion', 'role'=>'form')) }}
					{{ Form::hidden('idreporte_priorizacion', $reporte_priorizacion_info->idreporte_priorizacion) }}
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar',array('id'=>'submit-enable', 'type' => 'submit', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'reporte_priorizacion/submit_disable_reporte_priorizacion', 'role'=>'form','id'=>'submitDelete')) }}
					{{ Form::hidden('idreporte_priorizacion', $reporte_priorizacion_info->idreporte_priorizacion) }}
					 {{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar',array('id'=>'submit-delete', 'type' => 'submit', 'class'=>'btn btn-danger')) }}	
			@endif
				{{ Form::close() }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/reporte_priorizacion/list_reporte_priorizacion/')}}">Regresar</a>				
			</div>
		</div>	
@stop