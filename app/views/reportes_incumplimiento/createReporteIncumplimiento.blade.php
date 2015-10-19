@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Nuevo Reporte de Incumplimiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('numero_ot') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_reporte') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc1') }}</strong></p>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
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

		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'reportes_incumplimiento/submit_reporte', 'role'=>'form')) }}
		<div class="row">
			<div class="form-group col-xs-3 col-xs-offset-10">
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
			</div>
		</div>	
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('numero_ot','Número de OT') }}
							{{ Form::text('numero_ot',Input::old('numero_ot'),['class' => 'form-control'])}}
						</div>
						<div class="form-group col-xs-2 @if($errors->first('tipo_reporte')) has-error has-feedback @endif">
							{{ Form::label('tipo_reporte','Tipo') }}
							{{ Form::select('tipo_reporte',['0'=>'','1'=>'Por Servicio','2'=>'Por Equipo'],Input::old('idtipo_reporte'),['class' => 'form-control'])}}
						</div>						
					</div>
					<div class="row">
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('numero_doc1')) has-error has-feedback @endif">
							{{ Form::label('numero_doc1','Número Documento') }}
							{{ Form::text('numero_doc1',Input::old('numero_doc1'),['class' => 'form-control','id'=>'numero_doc1'])}}
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default" onclick="fill_name_responsable(1)">Agregar</a>
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default" onclick="clean_name_responsable(1)">Limpiar</a>
						</div>
						<div class="form-group col-xs-3">
							{{ Form::label('responsable','Responsable de la Revisión') }}
							{{ Form::text('responsable',Input::old('responsable'),['class' => 'form-control','id'=>'nombre_responsable1','disabled'=>'disabled'])}}
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-1">
							{{ Form::label('fecha','Fecha')}}
							<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha')) has-error has-feedback @endif">					
								{{ Form::text('fecha',Input::old('fecha'),array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>
				        </div>
		        	</div>
		        	<div class="row">		        		
						<div class="col-xs-4 col-xs-offset-1 @if($errors->first('descripcion_corta')) has-error has-feedback @endif">
		        			{{ Form::label('descripcion_corta','Descripción Corta') }}
							{{ Form::text('descripcion_corta',Input::old('descripcion_corta'),['class' => 'form-control'])}}
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('descripcion')) has-error has-feedback @endif">
			        		{{ Form::label('descripcion','Descripción del Servicio o Producto no conforme') }}
							{{ Form::textarea('descripcion',Input::old('descripcion'),['class' => 'form-control','style'=>'resize:none;'])}}
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
		        		<div class="form-group col-xs-4 col-xs-offset-1 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio Clínico') }}
							{{ Form::select('servicio',array('0'=> 'Seleccione')+$servicios,$servicios,['class' => 'form-control',"onchange" => "fill_responsable_servicio()",'id'=>'servicio'])}}
						</div>
						<div class="form-group col-xs-4  @if($errors->first('responsable_servicio')) has-error has-feedback @endif">
							{{ Form::label('responsable_servicio','Responsable del Servicio') }}
							{{ Form::text('responsable_servicio',Input::old('idresponsable'),['class' => 'form-control','id'=>'servicio_resp','disabled'=>'disabled'])}}
						</div>
		        	</div>
		        	<div class="row">
		        		<div class="form-group col-xs-4 col-xs-offset-1 @if($errors->first('proveedor')) has-error has-feedback @endif">
							{{ Form::label('proveedor','Proveedor') }}
							{{ Form::select('proveedor',array('0'=> 'Seleccione')+$proveedor,Input::old('idproveedor'),['class' => 'form-control',"onchange" => "fill_contacto_proveedor()",'id'=>'proveedor'])}}
						</div>
						<div class="form-group col-xs-4  @if($errors->first('contacto_proveedor')) has-error has-feedback @endif">
							{{ Form::label('contacto_proveedor','Contacto de Proveedor') }}
							{{ Form::text('contacto_proveedor',Input::old('contacto_proveedor'),['class' => 'form-control','id'=>'contacto_proveedor','disabled'=>'disabled'])}}
						</div>
		        	</div>
		        	<div class="row">
						<div class="col-xs-4 col-xs-offset-1 @if($errors->first('costo')) has-error has-feedback @endif">
			        		{{ Form::label('costo','Costos Generados') }}
							{{ Form::text('costo',Input::old('costo'),['class' => 'form-control'])}}
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('accion_generada')) has-error has-feedback @endif">
			        		{{ Form::label('accion_generada','Acción Correctiva Generada') }}
							{{ Form::text('accion_generada',Input::old('accion_generada'),['class' => 'form-control'])}}
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('reincidente')) has-error has-feedback @endif">
			        		{{ Form::label('reincidente','¿Es reincidente?') }}
							{{ Form::radio('reincidente', '1') }}SI{{ Form::radio('reincidente', '0', true) }}NO
						</div> 
					</div>

					<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('acciones')) has-error has-feedback @endif">
			        		{{ Form::label('acciones','Acciones a seguir de acuerdo a la disposición determinada') }}
							{{ Form::textarea('acciones',Input::old('acciones'),['class' => 'form-control','style'=>'resize:none;'])}}
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('resultados')) has-error has-feedback @endif">
			        		{{ Form::label('resultados','Resultados / Conclusiones con respecto al servicio') }}
							{{ Form::textarea('resultados',Input::old('resultados'),['class' => 'form-control','style'=>'resize:none;'])}}
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('numero_doc2')) has-error has-feedback @endif">
							{{ Form::label('numero_doc2','Número Documento') }}
							{{ Form::text('numero_doc2',Input::old('numero_doc2'),['class' => 'form-control','id'=>'numero_doc2'])}}
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default" onclick="fill_name_responsable(2)">Agregar</a>
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default" onclick="clean_name_responsable(2)">Limpiar</a>
						</div>
						<div class="form-group col-xs-3">
							{{ Form::label('autorizado','Autorizado por') }}
							{{ Form::text('autorizado',Input::old('autorizado'),['class' => 'form-control','id'=>'nombre_responsable2','disabled'=>'disabled'])}}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('numero_doc3')) has-error has-feedback @endif">
							{{ Form::label('numero_doc3','Número Documento') }}
							{{ Form::text('numero_doc3',Input::old('numero_doc3'),['class' => 'form-control','id'=>'numero_doc3'])}}
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default" onclick="fill_name_responsable(3)">Agregar</a>
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default"onclick="clean_name_responsable(3)">Limpiar</a>
						</div>
						<div class="form-group col-xs-3">
							{{ Form::label('elaborado','Elaborado por') }}
							{{ Form::text('elaborado',Input::old('elaborado'),['class' => 'form-control','id'=>'nombre_responsable3','disabled'=>'disabled'])}}
						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-1"></div>
						<div class="col-xs-10">
							<div class="panel panel-default">
				  				<div class="panel-heading">Documento Relacionado</div>
				  				<div class="panel-body">
									<div class="row">
											
										<div class="form-group col-xs-3 @if($errors->first('numero_contrato')) has-error has-feedback @endif">
											{{ Form::label('numero_contrato','Cód. Archivamiento') }}
											{{ Form::text('numero_contrato',Input::old('numero_contrato'),['class' => 'form-control','id'=>'numero_contrato'])}}
										</div>
										<div class="form-group col-xs-1" style="margin-top:25px">
											<a class="btn btn-default" onclick="fill_name_contrato()">Agregar</a>
										</div>
										<div class="form-group col-xs-1" style="margin-top:25px; margin-left:15px">
											<a class="btn btn-default" onclick="clean_name_contrato()">Limpiar</a>
										</div>
										<div class="form-group col-xs-3"  style="margin-left:15px">
											{{ Form::label('nombre_contrato','Documento') }}
											{{ Form::text('nombre_contrato',Input::old('nombre_contrato'),['class' => 'form-control','id'=>'nombre_contrato','disabled'=>'disabled'])}}
										</div>	
										{{ Form::close()}}									
										<div class="form-group col-xs-2">
											{{ Form::open(array('url'=>'reportes_incumplimiento/download_contrato', 'role'=>'form')) }}
											{{ Form::hidden('numero_contrato_hidden',null)}}
											{{ Form::submit('Descargar',array('id'=>'btn_descarga', 'class'=>'btn btn-primary','style'=>'margin-top:25px;')) }}
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