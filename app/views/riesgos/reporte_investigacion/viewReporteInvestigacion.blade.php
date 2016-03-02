@extends('templates/reporteInvestigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Reporte de Investigación y Tomas de Acciones</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

		{{Form::hidden('flag_evento',1,array('id'=>'flag_evento'))}}
		{{Form::hidden('array_tipos',$reportextipos,array('id'=>'array_tipos'))}}
		<div class="row">
			<div class="form-group col-md-12">
				{{ Form::label('solicitante','Usuario: '.$reporte_data->apellido_pat." ".$reporte_data->apellido_mat.", ".$reporte_data->nombre." ") }}
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Reporte de Evento Adverso Anexo</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_evento')) has-error has-feedback @endif">
						{{ Form::label('codigo_evento','Código de Evento Adverso') }}						
						{{ Form::text('codigo_evento',$reporte_data->evento_abreviatura.'-'.$reporte_data->evento_correlativo.'-'.$reporte_data->evento_anho,array('class'=>'form-control','placeholder'=>'Ejemplo: EA-1234-16','id'=>'codigo_evento','readonly')) }}
					</div>
				</div>
				
			</div>
		</div>		
		<div class="div_documento">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Documento del Reporte</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group col-md-6 col-md-offset-2">
							{{ Form::label('arch_adjunto','Archivo Adjunto') }}
							{{ Form::text('arch_adjunto', $reporte_data->nombre_archivo,array('class'=>'form-control','readonly'=>'')) }}
						</div>
						<div class="form-group col-md-2" style="margin-top:25px;">
							{{ Form::open(array('url'=>'/documento/download_documento','role'=>'form')) }}
								@if($reporte_data->url != '')
									{{ Form::hidden('url', $reporte_data->url) }}
									{{ Form::hidden('nombre_archivo', $reporte_data->nombre_archivo) }}
									{{ Form::hidden('nombre_archivo_encriptado', $reporte_data->nombre_archivo_encriptado) }}
									{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', array('id'=>'submit-search-form', 'type' => 'submit', 'class' => 'btn btn-success btn-block')) }}
								@else
									{{ Form::label('mensaje','Sin archivo adjunto') }}
								@endif
							{{ Form::close()}}
						</div>	
					</div>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Método de Difusion</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
						<table class="table">
							<tr class="info">
								<th class="text-nowrap text-center">Método</th>
								<th class="text-nowrap text-center">Archivo Anexo</th>	
							@foreach($reportexmetodos as $index => $reportexmetodo)
							<tr>						
								<td class="text-nowrap  text-center">
									{{$reportexmetodo->nombre_metodo}}
								</td>
								<td class="text-nowrap text-center">
									<div id="show-browser-{{$index}}">
										<div class="row">
											<div class="form-group col-md-8">
												{{ Form::text('arch_adjunto', $reportexmetodo->nombre_archivo,array('class'=>'form-control','readonly'=>'')) }}
											</div>
											<div class="form-group col-md-4">
												{{ Form::open(array('url'=>'/documento/download_documento','role'=>'form')) }}
													@if($reportexmetodo->url != '')
														{{ Form::hidden('url', $reportexmetodo->url) }}
														{{ Form::hidden('nombre_archivo', $reportexmetodo->nombre_archivo) }}
														{{ Form::hidden('nombre_archivo_encriptado', $reportexmetodo->nombre_archivo_encriptado) }}
														{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', array('id'=>'submit-search-form', 'type' => 'submit', 'class' => 'btn btn-success btn-block')) }}
													@else
														{{ Form::label('mensaje','Sin archivo adjunto') }}
													@endif
												{{ Form::close()}}
											</div>	
										</div>
									</div>
								</td>			
							</tr>
							@endforeach
						</table>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Tipos de Capacitación</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table">
							<tr class="info">
								<th class="text-nowrap text-center">Tipos</th>
								<th class="text-nowrap text-center">Selección</th>	
							@foreach($tipos_capacitacion as $index => $tipo)
							<tr>						
								<td class="text-nowrap">
									{{$tipo->nombre}}
								</td>
								<td class="text-nowrap text-center">
									@foreach($reportextipos as $reportextipo)
									@endforeach
									{{ Form::checkbox('seleccionado-tipo-'.($index+1),($index+1),false,array('id'=>'seleccionado-tipo-'.($index+1),'class'=>'checkbox-tipo','disabled'=>'disabled')) }}
								</td>	
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>

	<div class="container-fluid row">
		@if($reporte_data->deleted_at)
			{{ Form::open(array('url'=>'reportes_investigacion/submit_enable_reporte', 'role'=>'form','id'=>'submit_enable')) }}
				{{ Form::hidden('reporte_id', $reporte_data->id) }}
					<div class="form-group col-md-2">
						{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar', array('id'=>'btnEnable', 'class' => 'btn btn-success btn-block')) }}
					</div>
			{{ Form::close() }}
			@else
			{{ Form::open(array('url'=>'reportes_investigacion/submit_disable_reporte', 'role'=>'form','id'=>'submit_disable')) }}
				{{ Form::hidden('reporte_id', $reporte_data->id) }}
					<div class="form-group col-md-2">
						{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar', array('id'=>'btnDisable', 'class' => 'btn btn-danger btn-block')) }}
					</div>
			{{ Form::close() }}
			@endif
		<div class="form-group col-md-2 col-md-offset-8">
			<a class="btn btn-default btn-block" href="{{URL::to('/reportes_investigacion/list_reportes_investigacion')}}">Cancelar</a>				
		</div>
	</div>	
		
	
	
	<script>
		$("#input-file").fileinput({
			    language: "es",
			    maxFileSize: 15360,
			    allowedFileExtensions: ["png","jpe","jpeg","jpg","pdf","doc","docx","xls","xlsx","ppt","pptx"]
			});

		for(i=0;i<5;i++){
			$("#input-file-"+i).fileinput({
			    language: "es",
			    maxFileSize: 15360,
			    allowedFileExtensions: ["png","jpe","jpeg","jpg","pdf","doc","docx","xls","xlsx","ppt","pptx"]
			});
		}

	 	array_tipos = $('#array_tipos').val();	 	
	 	json = JSON.parse(array_tipos);
		size = json.length;
		for(i=0;i<size;i++){
			$('#seleccionado-tipo-'+json[i]['idtipo']).attr('checked',true);
		}
	</script>
	
@stop