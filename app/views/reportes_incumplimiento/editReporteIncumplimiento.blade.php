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

	{{ Form::open(array('url'=>'reportes_incumplimiento/submit_edit_reporte', 'role'=>'form')) }}
		{{Form::hidden('reporte_id',$reporte_data->idreporte_incumplimiento) }}
		<div class="row">
			<div class="form-group col-xs-3 col-xs-offset-10">
				{{ Form::submit('Guardar',array('idreporte'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
			</div>
		</div>	
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('numero_ot','Número de OT') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_ot',$reporte_data->idordenes_trabajo,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('numero_ot',$reporte_data->idordenes_trabajo,array('class'=>'form-control')) }}
							@endif
							
						</div>
						<div class="form-group col-xs-2 @if($errors->first('tipo_reporte')) has-error has-feedback @endif">
							{{ Form::label('tipo_reporte','Tipo') }}
							@if($reporte_data->deleted_at)
								{{ Form::select('tipo_reporte',['0'=>'Seleccione','1'=>'Por Servicio','2'=>'Por Equipo'],$reporte_data->tipo_reporte,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::select('tipo_reporte',['0'=>'Seleccione','1'=>'Por Servicio','2'=>'Por Equipo'],$reporte_data->tipo_reporte,array('class'=>'form-control')) }}
							@endif
							
						</div>						
					</div>
					<div class="row">
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('numero_doc1')) has-error has-feedback @endif">
							{{ Form::label('numero_doc1','Número Documento') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_doc1',$usuario_revision->numero_doc_identidad,array('class'=>'form-control','readonly'=>'','id'=>'numero_doc1')) }}
							@else
								{{ Form::text('numero_doc1',$usuario_revision->numero_doc_identidad,array('class'=>'form-control','id'=>'numero_doc1')) }}
							@endif							
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default" onclick="fill_name_responsable(1)">Agregar</a>
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default" onclick="clean_name_responsable(1)">Limpiar</a>
						</div>
						<div class="form-group col-xs-5">
							{{ Form::label('responsable','Responsable de la Revisión') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('responsable',$usuario_revision->nombre,array('class'=>'form-control','readonly'=>'','id'=>'nombre_responsable1')) }}
							@else
								{{ Form::text('responsable',$usuario_revision->nombre,array('class'=>'form-control','id'=>'nombre_responsable1')) }}
							@endif							
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-1">
							{{ Form::label('fecha','Fecha')}}
							<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha')) has-error has-feedback @endif">					
								{{ Form::text('fecha',date('d-m-Y',strtotime($reporte_data->fecha)),array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>
				        </div>
		        	</div>
		        	<div class="row">		        		
						<div class="col-xs-4 col-xs-offset-1 @if($errors->first('descripcion_corta')) has-error has-feedback @endif">
		        			{{ Form::label('descripcion_corta','Descripción Corta') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('descripcion_corta',$reporte_data->descripcion_corta,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('descripcion_corta',$reporte_data->descripcion_corta,array('class'=>'form-control')) }}
							@endif		        			
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('descripcion')) has-error has-feedback @endif">
			        		{{ Form::label('descripcion','Descripción del Servicio o Producto no conforme') }}
							@if($reporte_data->deleted_at)
								{{ Form::textarea('descripcion',$reporte_data->descripcion_servicio,array('class'=>'form-control','readonly'=>'','style'=>'resize:none;')) }}
							@else
								{{ Form::textarea('descripcion',$reporte_data->descripcion_servicio,array('class'=>'form-control','style'=>'resize:none;')) }}
							@endif
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
		        		<div class="form-group col-xs-4 col-xs-offset-1 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio Clínico') }}
							@if($reporte_data->deleted_at)
								{{ Form::select('servicio',array('0'=> 'Seleccione')+$servicios,$reporte_data->idservicio,array('class'=>'form-control','readonly'=>'',"onchange" => "fill_responsable_servicio()",'id'=>'servicio')) }}
							@else
								{{ Form::select('servicio',array('0'=> 'Seleccione')+$servicios,$reporte_data->idservicio,array('class'=>'form-control',"onchange" => "fill_responsable_servicio()",'id'=>'servicio')) }}
							@endif
						</div>
						<div class="form-group col-xs-4  @if($errors->first('responsable_servicio')) has-error has-feedback @endif">
							{{ Form::label('responsable_servicio','Responsable del Servicio') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('responsable_servicio',Input::old('idresponsable'),array('class'=>'form-control','readonly'=>'','disabled'=>'disabled','id'=>'servicio_resp')) }}
							@else
								{{ Form::text('responsable_servicio',Input::old('idresponsable'),array('class'=>'form-control','disabled'=>'disabled','id'=>'servicio_resp')) }}
							@endif							
						</div>
		        	</div>
		        	<div class="row">
		        		<div class="form-group col-xs-4 col-xs-offset-1 @if($errors->first('proveedor')) has-error has-feedback @endif">
							{{ Form::label('proveedor','Proveedor') }}
							@if($reporte_data->deleted_at)
								{{ Form::select('proveedor',array('0'=> 'Seleccione')+$proveedor,$reporte_data->idproveedor,array('class'=>'form-control','readonly'=>'',"onchange" => "fill_contacto_proveedor()",'id'=>'proveedor')) }}
							@else
								{{ Form::select('proveedor',array('0'=> 'Seleccione')+$proveedor,$reporte_data->idproveedor,array('class'=>'form-control',"onchange" => "fill_contacto_proveedor()",'id'=>'proveedor')) }}
							@endif							
						</div>
						<div class="form-group col-xs-4  @if($errors->first('contacto_proveedor')) has-error has-feedback @endif">
							{{ Form::label('contacto_proveedor','Contacto de Proveedor') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('contacto_proveedor',Input::old('contacto_proveedor'),array('class'=>'form-control','readonly'=>'','id'=>'contacto_proveedor','disabled'=>'disabled')) }}
							@else
								{{ Form::text('contacto_proveedor',Input::old('contacto_proveedor'),array('class'=>'form-control','id'=>'contacto_proveedor','disabled'=>'disabled')) }}
							@endif
						</div>
		        	</div>
		        	<div class="row">
						<div class="col-xs-4 col-xs-offset-1 @if($errors->first('costo')) has-error has-feedback @endif">
			        		{{ Form::label('costo','Costos Generados') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('costo',$reporte_data->costo_generado,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('costo',$reporte_data->costo_generado,array('class'=>'form-control')) }}
							@endif
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('accion_generada')) has-error has-feedback @endif">
			        		{{ Form::label('accion_generada','Acción Correctiva Generada') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('accion_generada',$reporte_data->accion_correctiva,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('accion_generada',$reporte_data->accion_correctiva,array('class'=>'form-control')) }}
							@endif
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('reincidente')) has-error has-feedback @endif">
			        		{{ Form::label('reincidente','¿Es reincidente?') }}
			        			@if($reporte_data->flag_reincidente == 1)
			        				{{ Form::radio('reincidente', '1',true) }}SI{{ Form::radio('reincidente', '0') }}NO
			        			@else
			        				{{ Form::radio('reincidente', '1') }}SI{{ Form::radio('reincidente', '0', true) }}NO
								@endif
							
						</div> 
					</div>

					<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('acciones')) has-error has-feedback @endif">
			        		{{ Form::label('acciones','Acciones a seguir de acuerdo a la disposición determinada') }}
							@if($reporte_data->deleted_at)
								{{ Form::textarea('acciones',$reporte_data->acciones,array('class'=>'form-control','readonly'=>'','style'=>'resize:none;')) }}
							@else
								{{ Form::textarea('acciones',$reporte_data->acciones,array('class'=>'form-control','style'=>'resize:none;')) }}
							@endif
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('resultados')) has-error has-feedback @endif">
			        		{{ Form::label('resultados','Resultados / Conclusiones con respecto al servicio') }}
							@if($reporte_data->deleted_at)
								{{ Form::textarea('resultados',$reporte_data->resultados,array('class'=>'form-control','readonly'=>'','style'=>'resize:none;')) }}
							@else
								{{ Form::textarea('resultados',$reporte_data->resultados,array('class'=>'form-control','style'=>'resize:none;')) }}
							@endif
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="col-xs-8 col-xs-offset-1 @if($errors->first('documento')) has-error has-feedback @endif">
			        		{{ Form::label('documento','Documento Contrato') }}
							{{ Form::file('documento',array('class'=>'form-group')) }}
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('numero_doc2')) has-error has-feedback @endif">
							{{ Form::label('numero_doc2','Número Documento') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_doc2',$usuario_autorizado->numero_doc_identidad,array('class'=>'form-control','readonly'=>'','id'=>'numero_doc2')) }}
							@else
								{{ Form::text('numero_doc2',$usuario_autorizado->numero_doc_identidad,array('class'=>'form-control','id'=>'numero_doc2')) }}
							@endif	
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default" onclick="fill_name_responsable(2)">Agregar</a>
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default" onclick="clean_name_responsable(2)">Limpiar</a>
						</div>
						<div class="form-group col-xs-5">
							{{ Form::label('autorizado','Autorizado por') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('autorizado',$usuario_autorizado->nombre,array('class'=>'form-control','readonly'=>'','id'=>'nombre_responsable2')) }}
							@else
								{{ Form::text('autorizado',$usuario_autorizado->nombre,array('class'=>'form-control','id'=>'nombre_responsable2')) }}
							@endif
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('numero_doc3')) has-error has-feedback @endif">
							{{ Form::label('numero_doc3','Número Documento') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_doc3',$usuario_elaborado->numero_doc_identidad,array('class'=>'form-control','readonly'=>'','id'=>'numero_doc3')) }}
							@else
								{{ Form::text('numero_doc3',$usuario_elaborado->numero_doc_identidad,array('class'=>'form-control','id'=>'numero_doc3')) }}
							@endif

						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default" onclick="fill_name_responsable(3)">Agregar</a>
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default"onclick="clean_name_responsable(3)">Limpiar</a>
						</div>
						<div class="form-group col-xs-5">
							{{ Form::label('elaborado','Elaborado por') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('elaborado',$usuario_elaborado->nombre,array('class'=>'form-control','readonly'=>'','id'=>'nombre_responsable3')) }}
							@else
								{{ Form::text('elaborado',$usuario_elaborado->nombre,array('class'=>'form-control','id'=>'nombre_responsable3')) }}
							@endif
						</div>
					</div>
				</div>			
			</div>
		</div>
	{{ Form::close() }}
@stop