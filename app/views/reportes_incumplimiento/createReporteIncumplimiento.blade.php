@extends('templates/reporteIncumplimientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Nuevo Reporte de Incumplimiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('numero_ot') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_reporte') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc1') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_reporte') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_corta') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('servicio') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor') }}</strong></p>
			<p><strong>{{ $errors->first('costo') }}</strong></p>
			<p><strong>{{ $errors->first('accion_generada') }}</strong></p>
			<p><strong>{{ $errors->first('reincidente') }}</strong></p>
			<p><strong>{{ $errors->first('resultados') }}</strong></p>
			<p><strong>{{ $errors->first('acciones') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc2') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc3') }}</strong></p>
			<p><strong>{{ $errors->first('numero_contrato') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}</strong>
		</div>
	@endif

	{{ Form::open(array('url'=>'reportes_incumplimiento/submit_reporte', 'role'=>'form')) }}
		{{ Form::hidden('tipo_ot',null,array('id'=>'tipo_ot'))}}
		<div>						
			{{ Form::hidden('flag_ot',1,array('id'=>'flag_ot'))}}
			{{ Form::hidden('flag_doc',0,array('id'=>'flag_doc'))}}
			{{ Form::hidden('type_solicitud',0,array('id'=>'type_solicitud'))}}
		</div>
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/reportes_incumplimiento/list_reportes')}}">Cancelar</a>				
			</div>
		</div>	
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos</div>
			  	<div class="panel-body">	
					<div class="row">		
						<div class="form-group col-md-4 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('numero_ot','Código de OT') }}<span style="color:red"> *</span>
							{{ Form::text('numero_ot',Input::old('numero_ot'),['class' => 'form-control','placeholder'=>'Número de OTM','id'=>'numero_ot'])}}
						</div>
						<div class="col-md-2" style="margin-top:25px">
							<div class="btn btn-success btn-block" id="btnValidate"><span class="glyphicon glyphicon-ok"></span> Validar</div>
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<div class="btn btn-default btn-block" onclick="clean_ot()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>
					</div>
					<div class="row">		
						<div class="form-group col-md-4 @if($errors->first('tipo_reporte')) has-error has-feedback @endif">
							{{ Form::label('tipo_reporte','Tipo de Reporte') }}<span style="color:red"> *</span>
							{{ Form::select('tipo_reporte',[''=>'Seleccione','1'=>'Por Servicio','2'=>'Por Equipo'],Input::old('tipo_reporte'),['class' => 'form-control'])}}
						</div>
						<div class="col-md-4">
							{{ Form::label('fecha','Fecha')}}<span style="color:red"> *</span>
							<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_reporte')) has-error has-feedback @endif">					
								{{ Form::text('fecha_reporte',Input::old('fecha_reporte'),array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>
				        </div>					
					</div>
					<div class="row">
						<div class="form-group col-md-2 @if($errors->first('tipo_documento_identidad1')) has-error has-feedback @endif">
							{{ Form::label('tipo_documento_identidad1','Tipo de Documento') }}<span style="color:red">*</span>
							{{ Form::select('tipo_documento_identidad1', array('' => 'Seleccione') + $tipo_documento_identidad,Input::old('tipo_documento_identidad1'),['class' => 'form-control']) }}						
						</div>
						<div class="form-group col-md-3 @if($errors->first('numero_doc1')) has-error has-feedback @endif">
							{{ Form::label('numero_doc1','Documento de Identidad') }}<span style="color:red"> *</span>
							{{ Form::text('numero_doc1',Input::old('numero_doc1'),['class' => 'form-control','id'=>'numero_doc1','placeholder'=>'N° de Doc.','readonly'=>''])}}
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<a class="btn btn-primary btn-block" onclick="fill_name_responsable(1)">
							<span class="glyphicon glyphicon-plus"></span> Agregar</a>
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<div class="btn btn-default btn-block" onclick="clean_name_responsable(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>
						<div class="form-group col-md-3">
							{{ Form::label('responsable','Responsable de la Revisión') }}
							{{ Form::text('responsable',Input::old('responsable'),['class' => 'form-control','id'=>'nombre_responsable1','disabled'=>'disabled','placeholder'=>'Nombre de Usuario'])}}
						</div>
					</div>
				    <div class="row">  		
						<div class="col-md-8 form-group @if($errors->first('descripcion_corta')) has-error has-feedback @endif">
		        			{{ Form::label('descripcion_corta','Descripción Corta') }}<span style="color:red"> *</span>
							{{ Form::text('descripcion_corta',Input::old('descripcion_corta'),['class' => 'form-control','placeholder'=>'Ingrese una descripción corta'])}}
		        		</div>
		        	</div>      
		        	<div class="row">
						<div class="col-md-8 form-group @if($errors->first('descripcion')) has-error has-feedback @endif">
			        		{{ Form::label('descripcion','Descripción del Servicio o Producto no conforme') }}<span style="color:red"> *</span>
							{{ Form::textarea('descripcion',Input::old('descripcion'),['class' => 'form-control','style'=>'resize:none;','placeholder'=>'Ingrese descripción'])}}
		        		</div>
		        	</div>
		        	<div class="row">
		        		<div class="form-group col-md-4 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio Clínico') }}<span style="color:red"> *</span>
							{{ Form::select('servicio',array(''=> 'Seleccione')+$servicios,$servicios,['class' => 'form-control',"onchange" => "fill_responsable_servicio()",'id'=>'servicio'])}}
						</div>
						<div class="form-group col-md-4  @if($errors->first('responsable_servicio')) has-error has-feedback @endif">
							{{ Form::label('responsable_servicio','Responsable del Servicio') }}
							{{ Form::text('responsable_servicio',Input::old('idresponsable'),['class' => 'form-control','id'=>'servicio_resp','disabled'=>'disabled','placeholder'=>'Responsable del servicio'])}}
						</div>
		        	</div>
		        	<div class="row">
		        		<div class="form-group col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
							{{ Form::label('proveedor','Proveedor') }}<span style="color:red"> *</span>
							{{ Form::select('proveedor',array(''=> 'Seleccione')+$proveedor,Input::old('idproveedor'),['class' => 'form-control',"onchange" => "fill_contacto_proveedor()",'id'=>'proveedor'])}}
						</div>
						<div class="form-group col-md-4  @if($errors->first('contacto_proveedor')) has-error has-feedback @endif">
							{{ Form::label('contacto_proveedor','Contacto de Proveedor') }}
							{{ Form::text('contacto_proveedor',Input::old('contacto_proveedor'),['class' => 'form-control','id'=>'contacto_proveedor','disabled'=>'disabled','placeholder'=>'Contacto'])}}
						</div>
		        	</div>
		        	<div class="row">
						<div class="col-md-2 form-group @if($errors->first('costo')) has-error has-feedback @endif">
			        		{{ Form::label('costo','Costos Generados') }}<span style="color:red"> *</span>
							{{ Form::text('costo',Input::old('costo'),['class' => 'form-control','placeholder'=>'Ingrese costo'])}}
		        		</div>
						<div class="col-md-8 form-group @if($errors->first('accion_generada')) has-error has-feedback @endif">
			        		{{ Form::label('accion_generada','Acción Correctiva Generada') }}<span style="color:red"> *</span>
							{{ Form::text('accion_generada',Input::old('accion_generada'),['class' => 'form-control','placeholder'=>'Ingrese acción generada'])}}
		        		</div>
	        		</div>
		        	<div class="row">
						<div class="col-md-8 form-group @if($errors->first('reincidente')) has-error has-feedback @endif">
			        		{{ Form::label('reincidente','¿Es reincidente?') }}<span style="color:red"> *</span>
							{{ Form::radio('reincidente', '1') }}SI{{ Form::radio('reincidente', '0', true) }}NO
						</div> 
					</div>
					<div class="row">
						<div class="col-md-8 @if($errors->first('acciones')) has-error has-feedback @endif">
			        		{{ Form::label('acciones','Acciones a seguir de acuerdo a la disposición determinada') }}<span style="color:red"> *</span>
							{{ Form::textarea('acciones',Input::old('acciones'),['class' => 'form-control','style'=>'resize:none;','placeholder'=>'Ingrese acciones'])}}
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-md-8 @if($errors->first('resultados')) has-error has-feedback @endif">
			        		{{ Form::label('resultados','Resultados / Conclusiones con respecto al servicio') }}<span style="color:red"> *</span>
							{{ Form::textarea('resultados',Input::old('resultados'),['class' => 'form-control','style'=>'resize:none;','placeholder'=>'Ingrese resultados'])}}
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="form-group col-md-2 @if($errors->first('tipo_documento_identidad2')) has-error has-feedback @endif">
							{{ Form::label('tipo_documento_identidad2','Tipo de Documento') }}<span style="color:red">*</span>
							{{ Form::select('tipo_documento_identidad2', array('' => 'Seleccione') + $tipo_documento_identidad,Input::old('tipo_documento_identidad2'),['class' => 'form-control']) }}						
						</div>
						<div class="form-group col-md-3 @if($errors->first('numero_doc2')) has-error has-feedback @endif">
							{{ Form::label('numero_doc2','Documento de Identidad') }}<span style="color:red"> *</span>
							{{ Form::text('numero_doc2',Input::old('numero_doc2'),['class' => 'form-control','id'=>'numero_doc2','placeholder'=>'N° de Doc.','readonly'=>''])}}
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<a class="btn btn-primary btn-block" onclick="fill_name_responsable(2)">
							<span class="glyphicon glyphicon-plus"></span> Agregar</a>
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<div class="btn btn-default btn-block" onclick="clean_name_responsable(2)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>

						<div class="form-group col-md-3">
							{{ Form::label('autorizado','Autorizado por') }}
							{{ Form::text('autorizado',Input::old('autorizado'),['class' => 'form-control','id'=>'nombre_responsable2','disabled'=>'disabled','placeholder'=>'Nombre de Usuario'])}}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-2 @if($errors->first('tipo_documento_identidad3')) has-error has-feedback @endif">
							{{ Form::label('tipo_documento_identidad3','Tipo de Documento') }}<span style="color:red">*</span>
							{{ Form::select('tipo_documento_identidad3', array('' => 'Seleccione') + $tipo_documento_identidad,Input::old('tipo_documento_identidad3'),['class' => 'form-control']) }}						
						</div>
						<div class="form-group col-md-3 @if($errors->first('numero_doc3')) has-error has-feedback @endif">
							{{ Form::label('numero_doc3','Documento de Identidad') }}<span style="color:red"> *</span>
							{{ Form::text('numero_doc3',Input::old('numero_doc3'),['class' => 'form-control','id'=>'numero_doc3','placeholder'=>'N° de Doc.','readonly'=>''])}}
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<a class="btn btn-primary btn-block" onclick="fill_name_responsable(3)">
							<span class="glyphicon glyphicon-plus"></span> Agregar</a>
						</div>
						<div class="form-group col-md-2" style="margin-top:25px">
							<div class="btn btn-default btn-block" onclick="clean_name_responsable(3)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
						</div>
						<div class="form-group col-md-3">
							{{ Form::label('elaborado','Elaborado por') }}
							{{ Form::text('elaborado',Input::old('elaborado'),['class' => 'form-control','id'=>'nombre_responsable3','disabled'=>'disabled','placeholder'=>'Nombre de Usuario'])}}
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
				  				<div class="panel-heading">Documento Relacionado</div>
				  				<div class="panel-body">
									<div class="row">											
										<div class="form-group col-md-2 @if($errors->first('numero_contrato')) has-error has-feedback @endif">
											{{ Form::label('numero_contrato','Cód. Archivamiento') }}<span style="color:red">*</span>
											{{ Form::text('numero_contrato',Input::old('numero_contrato'),['class' => 'form-control','id'=>'numero_contrato','placeholder'=>'Código'])}}
										</div>
										<div class="col-md-2" style="margin-top:25px">
											<a class="btn btn-primary btn-block" id="btnAddDoc">
											<span class="glyphicon glyphicon-plus"></span> Agregar</a>
										</div>
										<div class="col-md-2" style="margin-top:25px">
											<div class="btn btn-default btn-block" onclick="clean_name_contrato()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>
										</div>
										<div class="form-group col-md-4">
											{{ Form::label('nombre_contrato','Contrato de Proveedor') }}
											{{ Form::text('nombre_contrato',Input::old('nombre_contrato'),['class' => 'form-control','id'=>'nombre_contrato','disabled'=>'disabled','placeholder'=>'Nombre del Documento'])}}
										</div>	
										{{ Form::close()}}									
										<div class="form-group col-md-2">
											{{ Form::open(array('url'=>'reportes_incumplimiento/download_contrato', 'role'=>'form')) }}
											{{ Form::hidden('numero_contrato_hidden',null)}}
											{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', array('id'=>'btn_descarga', 'type' => 'submit', 'class' => 'btn btn-primary btn-block','style'=>'margin-top:25px')) }}
											{{ Form::close() }}
										</div>									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>	
		
		
@stop