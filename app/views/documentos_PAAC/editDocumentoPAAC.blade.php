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
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'documentos_PAAC/submit_edit_documento_paac', 'role'=>'form', 'files'=>true)) }}
	{{ Form::hidden('iddocumentosPAAC', $documento_paac_info->iddocumentosPAAC) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_documento')) has-error has-feedback @endif">
						{{ Form::label('idtipo_documento','Tipo de Documento') }}<span style="color:red">*</span>
						{{ Form::select('idtipo_documento',array(''=>'Seleccione') + $tipo_documento,$documento_paac_info->idtipo_documentosPAAC,['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}<span style="color:red">*</span>
						{{ Form::text('nombre',$documento_paac_info->nombre,['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('anho')) has-error has-feedback @endif">
						{{ Form::label('anho','Año') }}<span style="color:red">*</span>
						<div id="datetimepicker_cotizacion" class="input-group date">
							{{ Form::text('anho',$documento_paac_info->anho,array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-12">
						<strong>Reportes Vinculados</strong>   (Puede ser de Reporte de Necesidad de inmediato o mediano plazo (Con Reporte de Priorizacion) y Reporte PAAC O PAAC COMPLEMENTARIO)
					</div>
				</div>
				<div id="div_paac1" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn_paac1')) has-error has-feedback @endif">
						@if($documento_paac_info->cod_reporte_cn_paac1 != '')
							{{ Form::text('codigo_reporte_cn_paac1',$documento_paac_info->cod_reporte_cn_paac1,array('id'=>'codigo_reporte_cn_paac1','readonly'=>'','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('cod_reporte_cn_paac1',$documento_paac_info->cod_reporte_cn_paac1)}}
						@else
							{{ Form::text('codigo_reporte_cn_paac1',Input::old('codigo_reporte_cn_paac1'),array('id'=>'codigo_reporte_cn_paac1','placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('cod_reporte_cn_paac1')}}
						@endif
					</div>
					@if($documento_paac_info->cod_reporte_cn_paac1 == '' && !$documento_paac_info->deleted_at)
						<div class="form-group col-md-2">
							<a id="btn_validar_cn_paac1" class="btn btn-primary btn-block" onclick="validar_cn_paac(1)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
						</div>
						<div class="form-group col-md-2" style="margin-left:15px">
							<a id="btn_limpiar_cn_paac1" class="btn btn-default btn-block" onclick="limpiar_cn_paac(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
						</div>
					@endif
				</div>
				<div id="div_paac2" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn_paac2')) has-error has-feedback @endif">
						@if($documento_paac_info->cod_reporte_cn_paac2 != '')
							{{ Form::text('codigo_reporte_cn_paac2',$documento_paac_info->cod_reporte_cn_paac2,array('id'=>'codigo_reporte_cn_paac2','readonly'=>'','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('cod_reporte_cn_paac2',$documento_paac_info->cod_reporte_cn_paac2)}}
						@else
							{{ Form::text('codigo_reporte_cn_paac2',Input::old('codigo_reporte_cn_paac2'),array('id'=>'codigo_reporte_cn_paac2','placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('cod_reporte_cn_paac2')}}
						@endif
					</div>
					@if($documento_paac_info->cod_reporte_cn_paac2 == '' && !$documento_paac_info->deleted_at)
						<div class="form-group col-md-2">
							<a id="btn_validar_cn_paac2" class="btn btn-primary btn-block" onclick="validar_cn_paac(2)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
						</div>
						<div class="form-group col-md-2" style="margin-left:15px">
							<a id="btn_limpiar_cn_paac2" class="btn btn-default btn-block" onclick="limpiar_cn_paac(2)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
						</div>
					@endif
				</div>
				<div id="div_paac3" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn_paac3')) has-error has-feedback @endif">
						@if($documento_paac_info->cod_reporte_cn_paac3 != '')
							{{ Form::text('codigo_reporte_cn_paac3',$documento_paac_info->cod_reporte_cn_paac3,array('id'=>'codigo_reporte_cn_paac3','readonly'=>'','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('cod_reporte_cn_paac3',$documento_paac_info->cod_reporte_cn_paac3)}}
						@else
							{{ Form::text('codigo_reporte_cn_paac3',Input::old('codigo_reporte_cn_paac3'),array('id'=>'codigo_reporte_cn_paac3','placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('cod_reporte_cn_paac3')}}
						@endif
					</div>
					@if($documento_paac_info->cod_reporte_cn_paac3 == '' && !$documento_paac_info->deleted_at)
						<div class="form-group col-md-2">
							<a id="btn_validar_cn_paac3" class="btn btn-primary btn-block" onclick="validar_cn_paac(3)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
						</div>
						<div class="form-group col-md-2" style="margin-left:15px">
							<a id="btn_limpiar_cn_paac3" class="btn btn-default btn-block" onclick="limpiar_cn_paac(3)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
						</div>
					@endif
				</div>
				<div id="div_paac4" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn_paac4')) has-error has-feedback @endif">
						@if($documento_paac_info->cod_reporte_cn_paac4 != '')
							{{ Form::text('codigo_reporte_cn_paac4',$documento_paac_info->cod_reporte_cn_paac4,array('id'=>'codigo_reporte_cn_paac4','readonly'=>'','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('cod_reporte_cn_paac4',$documento_paac_info->cod_reporte_cn_paac4)}}
						@else
							{{ Form::text('codigo_reporte_cn_paac4',Input::old('codigo_reporte_cn_paac4'),array('id'=>'codigo_reporte_cn_paac4','placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('cod_reporte_cn_paac4')}}
						@endif
					</div>
					@if($documento_paac_info->cod_reporte_cn_paac4 == '' && !$documento_paac_info->deleted_at)
						<div class="form-group col-md-2">
							<a id="btn_validar_cn_paac4" class="btn btn-primary btn-block" onclick="validar_cn_paac(4)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
						</div>
						<div class="form-group col-md-2" style="margin-left:15px">
							<a id="btn_limpiar_cn_paac4" class="btn btn-default btn-block" onclick="limpiar_cn_paac(4)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
						</div>
					@endif
				</div>
				<div id="div_paac5" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_cn_paac5')) has-error has-feedback @endif">
						@if($documento_paac_info->cod_reporte_cn_paac5 != '')
							{{ Form::text('codigo_reporte_cn_paac5',$documento_paac_info->cod_reporte_cn_paac5,array('id'=>'codigo_reporte_cn_paac5','readonly'=>'','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('cod_reporte_cn_paac5',$documento_paac_info->cod_reporte_cn_paac5)}}
						@else
							{{ Form::text('codigo_reporte_cn_paac5',Input::old('codigo_reporte_cn_paac5'),array('id'=>'codigo_reporte_cn_paac5','placeholder'=>'NI0001-16','class'=>'form-control','maxlength'=>9)) }}
							{{ Form::hidden('cod_reporte_cn_paac5')}}
						@endif
					</div>
					@if($documento_paac_info->cod_reporte_cn_paac5 == '' && !$documento_paac_info->deleted_at)
						<div class="form-group col-md-2">
							<a id="btn_validar_cn_paac5" class="btn btn-primary btn-block" onclick="validar_cn_paac(5)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
						</div>
						<div class="form-group col-md-2" style="margin-left:15px">
							<a id="btn_limpiar_cn_paac5" class="btn btn-default btn-block" onclick="limpiar_cn_paac(5)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
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
								{{ Form::text('nombre_doc_relacionado',$documento_paac_info->nombre_archivo,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($documento_paac_info->deleted_at)
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/documentos_PAAC/download_documento/')}}/{{$documento_paac_info->iddocumentosPAAC}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@else
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/documentos_PAAC/download_documento/')}}/{{$documento_paac_info->iddocumentosPAAC}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@endif						
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="row">
			@if(!$documento_paac_info->deleted_at)
				<div class="form-group col-md-1">
					{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
				</div>
			@endif
	{{ Form::close() }}
			<div class="form-group col-md-2">
			@if($documento_paac_info->deleted_at)
				{{ Form::open(array('url'=>'documentos_PAAC/submit_enable_documento_paac', 'role'=>'form')) }}
					{{ Form::hidden('iddocumentosPAAC', $documento_paac_info->iddocumentosPAAC) }}
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar',array('id'=>'submit-enable', 'type' => 'submit', 'class'=>'btn btn-success')) }}
			@else
				{{ Form::open(array('url'=>'documentos_PAAC/submit_disable_documento_paac', 'role'=>'form','id'=>'submitDelete')) }}
					{{ Form::hidden('iddocumentosPAAC', $documento_paac_info->iddocumentosPAAC) }}
					 {{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar',array('id'=>'submit-delete', 'type' => 'submit', 'class'=>'btn btn-danger')) }}	
			@endif
				{{ Form::close() }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/documentos_PAAC/list_documento_paac/')}}">Regresar</a>				
			</div>
		</div>	
@stop