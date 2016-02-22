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

	{{ Form::open(array('url'=>'reportes_investigacion/submit_create_reporte_investigacion', 'role'=>'form', 'files'=>true)) }}
		{{Form::hidden('flag_evento',1,array('id'=>'flag_evento'))}}
		<div class="row">
			<div class="form-group col-md-12">
				{{ Form::label('solicitante','Usuario: '.$user->apellido_pat." ".$user->apellido_mat.", ".$user->nombre." ") }}
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
						{{ Form::hidden('id_evento',null,array('id'=>'id_evento'))}}
						{{ Form::text('codigo_evento',Input::old('codigo_evento'),array('class'=>'form-control','placeholder'=>'Ejemplo: EA-1234-16','id'=>'codigo_evento')) }}
					</div>
					<div class="col-md-2" style="margin-top:25px">
						<div class="btn btn-success btn-block" id="btnValidate"><span class="glyphicon glyphicon-ok"></span> Validar</div>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<div class="btn btn-default btn-block" onclick="clean_evento()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
					</div>
				</div>
				
			</div>
		</div>		
		<div class="div_documento" style="display:none;">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Documento Anexo al Reporte</h3>
				</div>
				<div class="panel-body">
					<div class="col-md-12">
						<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,pdf,doc,docx,xls,xlsx,ppt,pptx)
						<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
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
								<th class="text-nowrap text-center">Selección</th>	
							@foreach($metodos as $index => $metodo)
							<tr>						
								<td class="text-nowrap">
									{{$metodo->nombre}}
								</td>
								<td class="text-nowrap text-center">
									{{ Form::checkbox('seleccionado-metodo-'.$index,$index,false,array('id'=>'seleccionado-metodo-'.$index,'class'=>'checkbox-metodo','disabled'=>'disabled')) }}
								</td>
								<td class="text-nowrap text-center">
									<div id="show-browser-{{$index}}" style="display:none;">
										<div class="row">
											<div class="col-md-9">
												<input name="archivo-{{$index}}" id="input-file-{{$index}}" type="file" class="file file-loading" data-show-upload="false">
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
									{{ Form::checkbox('seleccionado-tipo-'.$index,$index,false,array('id'=>'seleccionado-tipo-'.$index,'class'=>'checkbox-tipo','disabled'=>'disabled')) }}
								</td>	
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>

	<div class="container-fluid row">
		<div class="form-group col-md-2 col-md-offset-8">				
			{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block','disabled'=>'disabled')) }}
		</div>
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::to('/reportes_investigacion/list_reportes_investigacion')}}">Cancelar</a>				
		</div>
	</div>	
		
	{{ Form::close() }}
	
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
		
	</script>
	
@stop