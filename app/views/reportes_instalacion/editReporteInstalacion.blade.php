@extends('templates/reporteInstalacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Ver Reporte de Instalación: {{$reporte_instalacion_info->numero_reporte_abreviatura.$reporte_instalacion_info->numero_reporte_correlativo."-".$reporte_instalacion_info->numero_reporte_anho}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>    

    @if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('codigo_compra') }}</strong></p>
			<p><strong>{{ $errors->first('idproveedor') }}</strong></p>
			<p><strong>{{ $errors->first('idarea') }}</strong></p>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('numero_documento1') }}</strong></p>

		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif  

    {{ Form::open(array('url'=>'/rep_instalacion/submit_edit_rep_instalacion','role'=>'form')) }}
    	{{ Form::hidden('reporte_instalacion_id', $reporte_instalacion_info->idreporte_instalacion) }}
		<div class="panel panel-default">
		  	<div class="panel-heading">
		    	<h3 class="panel-title">Datos Generales</h3>
		  	</div>
  			<div class="panel-body">
				<div class="col-md-12">
					<div class="form-group row">
						<div class="form-group col-md-4 @if($errors->first('idtipo_reporte_instalacion')) has-error has-feedback @endif">
							{{ Form::label('idtipo_reporte_instalacion','Tipo de Reporte de Instalación') }}
							{{ Form::select('idtipo_reporte_instalacion',array('' => 'Seleccione') + $tipos_reporte_instalacion,$reporte_instalacion_info->idtipo_reporte_instalacion,['disabled' => 'disabled', 'class' => 'form-control','readonly'=>'']) }}												
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
							{{ Form::label('codigo_compra','Código de Compra') }}
							{{ Form::text('codigo_compra',$reporte_instalacion_info->codigo_compra,array('class'=>'form-control','readonly'=>'')) }}
						</div>
						<div class="form-group col-md-4 @if($errors->first('idarea')) has-error has-feedback @endif">
							{{ Form::label('idarea','Departamento') }}
							@if($reporte_instalacion_info->deleted_at)
								{{ Form::select('idarea',array('' => 'Seleccione') + $areas,$reporte_instalacion_info->idarea,['class' => 'form-control','readonly'=>'']) }}
							@else
								{{ Form::select('idarea',array('' => 'Seleccione') + $areas,$reporte_instalacion_info->idarea,['class' => 'form-control']) }}
							@endif
						</div>
					</div>						
					<div class="form-group row">
						<div class="form-group col-md-4 @if($errors->first('idproveedor')) has-error has-feedback @endif">
							{{ Form::label('idproveedor','Proveedor') }}
							@if($reporte_instalacion_info->deleted_at)
								{{ Form::select('idproveedor',array('' => 'Seleccione') + $proveedores,$reporte_instalacion_info->idproveedor,['class' => 'form-control','readonly'=>'']) }}
							@else
								{{ Form::select('idproveedor',array('' => 'Seleccione') + $proveedores,$reporte_instalacion_info->idproveedor,['class' => 'form-control']) }}
							@endif
						</div>
						<div class="col-md-4">
							{{ Form::label('fecha','Fecha') }}
							<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha')) has-error has-feedback @endif">
								{{ Form::text('fecha',date('d-m-Y',strtotime($reporte_instalacion_info->fecha)),array('class'=>'form-control', 'readonly'=>'')) }}
								@if(!$reporte_instalacion_info->deleted_at)
									<span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                @endif
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							@if($reporte_instalacion_info->deleted_at)
								{{ Form::textarea('descripcion',$reporte_instalacion_info->descripcion,['class' => 'form-control','style'=>'resize:none;','readonly'=>''])}}
							@else
								{{ Form::textarea('descripcion',$reporte_instalacion_info->descripcion,['class' => 'form-control','style'=>'resize:none;'])}}
							@endif
						</div>
					</div>
				</div>	
			</div>
		</div>

		<div class="panel panel-default">
		  	<div class="panel-heading">
		    	<h3 class="panel-title">Detalle de Tarea</h3>
		  	</div>
  			<div class="panel-body">
  				<div class="col-md-12">
					<div class="form-group row">
						<div class="form-group col-md-6 @if($errors->first('nombre_tarea')) has-error has-feedback @endif">
							{{ Form::label('nombre_tarea','Nombre de Tarea') }}
							{{ Form::text('nombre_tarea',Input::old('nombre_tarea'),array('class'=>'form-control')) }}
						</div>
						<div class="form-group col-md-4 @if($errors->first('tarea_realizada')) has-error has-feedback @endif">
							{{ Form::label('tarea_realizada','Estado de Tarea') }}
							{{ Form::select('tarea_realizada',array('1' => 'Realizado','0' => 'No Realizado'),Input::old('tarea_realizada'),['class' => 'form-control']) }}
						</div>
					</div>
				</div>
				<div class="container-fluid row form-group">
					<div class="col-md-2 col-md-offset-8">
							<div class="btn btn-primary btn-block" id="btnAgregarFila"><span class="glyphicon glyphicon-plus"></span>Agregar</div>				
					</div>
					<div class="col-md-2">
							<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span>Limpiar</div>				
					</div>
				</div>
  			</div>
  		</div>

  		<div class="panel panel-default">
		  	<div class="panel-heading">
		    	<h3 class="panel-title">Tareas</h3>
		  	</div>
  			<div class="panel-body">
		  		<table class="table">
					<tr class="info">
						<th>Tarea</th>
						<th>Estado de Tarea</th>
						<th>Eliminar</th>
					</tr>		
					<?php 
						$count = count($tareas_info);	
					?>	
					<?php for($i=0;$i<$count;$i++){ ?>
					<tr>
						<td>
							<input style="border:0" name='details_tarea[]' value='{{ $tareas_info[$i]->nombre_tarea }}' readonly/>
						</td>
						<td>
							<input style="border:0" name='details_estado[]' value='{{ $tareas_info[$i]->tarea_realizada}}' readonly/>
						</td>
						<td>
							<a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a>
						</td>						
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>

		<div class="panel panel-default">
		  	<div class="panel-heading">
		    	<h3 class="panel-title">Datos de personal que da conformidad</h3>
		  	</div>
  			<div class="panel-body">
  				<div class="row">
					<div class="form-group col-md-3 @if($errors->first('numero_documento1')) has-error has-feedback @endif">
						{{ Form::label('numero_documento1','Número Documento') }}
						{{ Form::text('numero_documento1',$usuario_responsable->numero_doc_identidad,['class' => 'form-control','id'=>'numero_documento1'])}}
					</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" onclick="llenar_nombre_responsable(1)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
								<a class="btn btn-default btn-block" onclick="limpiar_nombre_responsable(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
						{{ Form::label('responsable','Responsable de la Revisión') }}
						{{ Form::text('responsable',$usuario_responsable->nombre.' '.$usuario_responsable->apellido_pat.' '.$usuario_responsable->apellido_mat,['class' => 'form-control','id'=>'nombre_responsable1','disabled'=>'disabled'])}}
					</div>
				</div>
  			</div>
  		</div>
  		<div class="row">
			<div class="panel panel-default" id="panel-documentos-relacionados" hidden>
  				<div class="panel-heading">Documentos Relacionados</div>
  				<div class="panel-body">
					<div class="col-md-12">
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('numero_reporte_entorno_concluido')) has-error has-feedback @endif">
								{{ Form::label('numero_reporte_entorno_concluido','N° Rep. Entorno Concluido') }}
								@if($reporte_instalacion_entorno_concluido)
									{{ Form::text('numero_reporte_entorno_concluido',$reporte_instalacion_entorno_concluido->numero_reporte_abreviatura.$reporte_instalacion_entorno_concluido->numero_reporte_correlativo."-".$reporte_instalacion_entorno_concluido->numero_reporte_anho,['readonly'=>'','class' => 'form-control','id'=>'numero_reporte_entorno_concluido'])}}							
								@else
									{{ Form::text('numero_reporte_entorno_concluido','',['class' => 'form-control','id'=>'numero_reporte_entorno_concluido'])}}							
								@endif
							</div>						
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('num_doc_relacionado1')) has-error has-feedback @endif">
								{{ Form::label('num_doc_relacionado1','Cód. Archivamiento') }}
								@if($documento_certificado_funcionalidad != null)
									{{ Form::text('num_doc_relacionado1','$documento_certificado_funcionalidad->codigo_archivamiento',['readonly'=>'','class' => 'form-control','id'=>'num_doc_relacionado1'])}}
								@else
									{{ Form::text('num_doc_relacionado1','',['readonly'=>'','class' => 'form-control','id'=>'num_doc_relacionado1'])}}
								@endif
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
								{{ Form::label('nombre_doc_relacionado1','Cert. de Funcionalidad') }}
								@if($documento_certificado_funcionalidad != null)
									{{ Form::text('nombre_doc_relacionado1',$documento_certificado_funcionalidad->nombre,['class' => 'form-control','id'=>'nombre_doc_relacionado1','disabled'=>'disabled'])}}
								@else
									{{ Form::text('nombre_doc_relacionado1','',['class' => 'form-control','id'=>'nombre_doc_relacionado1','disabled'=>'disabled'])}}
								@endif
							</div>							
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('num_doc_relacionado2')) has-error has-feedback @endif">
								{{ Form::label('num_doc_relacionado2','Cód. Archivamiento') }}
								@if($documento_contrato != null)
									{{ Form::text('num_doc_relacionado2',$documento_contrato->codigo_archivamiento,['readonly'=>'','class' => 'form-control','id'=>'num_doc_relacionado2'])}}
								@else
									{{ Form::text('num_doc_relacionado2','',['readonly'=>'','class' => 'form-control','id'=>'num_doc_relacionado2'])}}
								@endif
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
								{{ Form::label('nombre_doc_relacionado2','Contrato') }}
								@if($documento_contrato != null)
									{{ Form::text('nombre_doc_relacionado2',$documento_contrato->nombre,['class' => 'form-control','id'=>'nombre_doc_relacionado2','disabled'=>'disabled'])}}
								@else							
									{{ Form::text('nombre_doc_relacionado2','',['class' => 'form-control','id'=>'nombre_doc_relacionado2','disabled'=>'disabled'])}}
								@endif
							</div>						
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('num_doc_relacionado3')) has-error has-feedback @endif">
								{{ Form::label('num_doc_relacionado3','Cód. Archivamiento') }}
								@if($documento_manual != null)								
									{{ Form::text('num_doc_relacionado3',$documento_manual->codigo_archivamiento,['readonly'=>'','class' => 'form-control','id'=>'num_doc_relacionado3'])}}
								@else							
									{{ Form::text('num_doc_relacionado3','',['readonly'=>'','class' => 'form-control','id'=>'num_doc_relacionado3'])}}
								@endif
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
								{{ Form::label('nombre_doc_relacionado3','Manual') }}
								@if($documento_manual != null)	
									{{ Form::text('nombre_doc_relacionado3',$documento_manual->nombre,['class' => 'form-control','id'=>'nombre_doc_relacionado3','disabled'=>'disabled'])}}
								@else
									{{ Form::text('nombre_doc_relacionado3','',['class' => 'form-control','id'=>'nombre_doc_relacionado3','disabled'=>'disabled'])}}
								@endif
							</div>	
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('num_doc_relacionado4')) has-error has-feedback @endif">
								{{ Form::label('num_doc_relacionado4','Cód. Archivamiento') }}
								@if($documento_tdr != null)	
									{{ Form::text('num_doc_relacionado4',$documento_tdr->codigo_archivamiento,['readonly'=>'','class' => 'form-control','id'=>'num_doc_relacionado4'])}}
								@else
									{{ Form::text('num_doc_relacionado4','',['readonly'=>'','class' => 'form-control','id'=>'num_doc_relacionado4'])}}
								@endif
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
								{{ Form::label('nombre_doc_relacionado4','Término de Referencia') }}
								@if($documento_tdr != null)	
									{{ Form::text('nombre_doc_relacionado4',$documento_manual->nombre,['class' => 'form-control','id'=>'nombre_doc_relacionado4','disabled'=>'disabled'])}}
								@else
									{{ Form::text('nombre_doc_relacionado4','',['class' => 'form-control','id'=>'nombre_doc_relacionado4','disabled'=>'disabled'])}}
								@endif
							</div>	
						</div>
				</div>
			</div>
		</div>
		<div class="container-fluid row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar',array('id'=>'submit-edit','type' => 'submit', 'class'=>'btn btn-primary btn-block')) }}	
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/rep_instalacion/list_rep_instalacion')}}">Cancelar</a>				
			</div>
		</div>	
	{{ Form::close() }}</br>

	
@stop	