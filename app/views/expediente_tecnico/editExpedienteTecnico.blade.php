@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Expediente Técnico y Económico</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idtipo_reporte_cn') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_reporte_etes') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_reporte_paac') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_cn') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_etes') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_paac') }}</strong></p>
			<p><strong>{{ $errors->first('idarea_cn') }}</strong></p>
			<p><strong>{{ $errors->first('idarea_etes') }}</strong></p>
			<p><strong>{{ $errors->first('idarea_paac') }}</strong></p>
			<p><strong>{{ $errors->first('num_doc_responsable_cn') }}</strong></p>
			<p><strong>{{ $errors->first('num_doc_responsable_etes') }}</strong></p>
			<p><strong>{{ $errors->first('num_doc_responsable_paac') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_cn') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_etes') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_paac') }}</strong></p>
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

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Datos Generales</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
					{{ Form::label('codigo_compra','Código de Compra') }}
					{{ Form::text('codigo_compra',$expediente_tecnico_info->codigo_compra,['disabled'=>'','class' => 'form-control']) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('codigo_archivamiento')) has-error has-feedback @endif">
					{{ Form::label('codigo_archivamiento','Código de Archivamiento') }}
					{{ Form::text('codigo_archivamiento',$expediente_tecnico_info->codigo_archivamiento,['disabled'=>'','class' => 'form-control']) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
					{{ Form::label('nombre_equipo','Nombre de Equipo') }}
					@if($expediente_tecnico_info->nombre_equipo != '')
						{{ Form::text('nombre_equipo',$expediente_tecnico_info->nombre_equipo,['disabled'=>'','class' => 'form-control']) }}
					@else
						{{ Form::text('nombre_equipo',$expediente_tecnico_info->otros_equipos,['disabled'=>'','class' => 'form-control']) }}
					@endif
				</div>
			</div>
		</div>
	</div>

	<div id="tab_menu">
	  <ul class="nav nav-pills">
	    <li class="active">
	      	<a href="#tab_bases_compra" data-toggle="tab">Bases de Compra</a>
	    </li>
	    <li>
	    	<a href="#tab_ofertas" data-toggle="tab">Ofertas</a>
	    </li>
	    <li>
	    	<a href="#tab_reporte_ofertas_evaluadas" data-toggle="tab">Reporte de Ofertas Evaluadas</a>
	    </li>
	    <li>
	    	<a href="#tab_miembros_comite" data-toggle="tab">Miembros de Comité</a>
	    </li>
	    <li>
	    	<a href="#tab_observaciones_presentadas" data-toggle="tab">Observaciones Presentadas</a>
	    </li>
	    <li>
	    	<a href="#tab_adjudicacion" data-toggle="tab">Adjudicación</a>
	    </li>
	  </ul>

	  <div class="tab-content clearfix">
	    <div class="tab-pane active" id="tab_bases_compra">
		    {{ Form::open(array('url'=>'expediente_tecnico/submit_edit_expediente_tecnico', 'role'=>'form', 'files'=>true)) }}
				{{ Form::hidden('idexpediente_tecnico', $expediente_tecnico_info->idexpediente_tecnico) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Bases de compra</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-4 @if($errors->first('idtipo_adquisicion_expediente')) has-error has-feedback @endif">
								{{ Form::label('idtipo_adquisicion_expediente','Tipo de Adquisición') }}<span style='color:red'>*</span>
								{{ Form::select('idtipo_adquisicion_expediente',array(''=>'Seleccione') + $tipos_adquisicion_expediente,$expediente_tecnico_info->idtipo_adquisicion_expediente,['class' => 'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('idtipo_compra_expediente')) has-error has-feedback @endif">
								{{ Form::label('idtipo_compra_expediente','Tipo de Compra') }}<span style='color:red'>*</span>
								{{ Form::select('idtipo_compra_expediente',array(''=>'Seleccione') + $tipos_compra_expediente,$expediente_tecnico_info->idtipo_compra_expediente,['class' => 'form-control']) }}
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-4 @if($errors->first('idservicio')) has-error has-feedback @endif">
								{{ Form::label('idservicio','Servicio') }}
								{{ Form::select('idservicio',array(''=>'Seleccione') + $servicios,$expediente_tecnico_info->idservicio,['class' => 'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('idarea_select')) has-error has-feedback @endif">
								{{ Form::label('idarea_select','Departamento') }}<span style='color:red'>*</span>
								{{ Form::select('idarea_select',array(''=>'Seleccione') + $areas,$expediente_tecnico_info->idarea,['class' => 'form-control']) }}
								{{ Form::hidden('idarea',$expediente_tecnico_info->idarea)}}
							</div>
						</div>	
						<div class="row">
							<div class="form-group col-md-12 @if($errors->first('descripcion')) has-error has-feedback @endif">
								{{ Form::label('descripcion','Descripción') }}<span style='color:red'>*</span>
								{{ Form::textarea('descripcion',$expediente_tecnico_info->descripcion,['Placeholder'=>'Descripción','class' => 'form-control','maxlength'=>255]) }}
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-4">
								{{ Form::label('nombre_doc_relacionado','Resolución') }}
								{{ Form::text('nombre_doc_relacionado',$expediente_tecnico_info->nombre_archivo_resolucion,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($expediente_tecnico_info->deleted_at)
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/expediente_tecnico/download_resolucion/')}}/{{$expediente_tecnico_info->idexpediente_tecnico}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@else
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/expediente_tecnico/download_resolucion/')}}/{{$expediente_tecnico_info->idexpediente_tecnico}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@endif		
							<div class="col-md-6" style="margin-top:5px">
								<label class="control-label">Modificar Archivo adjunto
								<input name="archivo_resolucion" id="input-file_resolucion" type="file" class="file file-loading" data-show-upload="false">
							</div>				
						</div>
						<div class="row">
							<div class="form-group col-md-4">
								{{ Form::label('nombre_doc_relacionado','Términos de Referencia') }}
								{{ Form::text('nombre_doc_relacionado',$expediente_tecnico_info->nombre_archivo_tdr,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($expediente_tecnico_info->deleted_at)
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/expediente_tecnico/download_tdr/')}}/{{$expediente_tecnico_info->idexpediente_tecnico}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@else
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/expediente_tecnico/download_tdr/')}}/{{$expediente_tecnico_info->idexpediente_tecnico}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@endif	
							<div class="col-md-6" style="margin-top:5px">
								<label class="control-label">Modificar Archivo adjunto
								<input name="archivo_tdr" id="input-file_tdr" type="file" class="file file-loading" data-show-upload="false">
							</div>					
						</div>
						<div class="row">
							<div class="form-group col-md-4">
								{{ Form::label('nombre_doc_relacionado','Bases') }}
								{{ Form::text('nombre_doc_relacionado',$expediente_tecnico_info->nombre_archivo_bases,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($expediente_tecnico_info->deleted_at)
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/expediente_tecnico/download_bases/')}}/{{$expediente_tecnico_info->idexpediente_tecnico}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@else
								<div class="form-group col-md-2" style="margin-top:25px">
									<a class="btn btn-primary btn-block" href="{{URL::to('/expediente_tecnico/download_bases/')}}/{{$expediente_tecnico_info->idexpediente_tecnico}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
								</div>
							@endif		
							<div class="col-md-6" style="margin-top:5px">
								<label class="control-label">Modificar Archivo adjunto
								<input name="archivo_bases" id="input-file_bases" type="file" class="file file-loading" data-show-upload="false">
							</div>				
						</div>
						<div class="row">
							<div class="form-group col-md-2">
								{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
							</div>
						</div>
					</div>
				</div>
			{{ Form::close() }}
	    </div>
	    <div class="tab-pane" id="tab_ofertas">
	      	{{ Form::open(array('url'=>'', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Ofertas</h3>
					</div>
					<div class="panel-body">
						@foreach($ofertas_expediente_data as $oferta_expediente_data)
							<div class="row">
								<div class="form-group col-md-4">
									<strong><font size="4">Oferta {{$oferta_expediente_data->correlativo_por_expediente}}</font></strong>							
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-4 @if($errors->first('idproveedor')) has-error has-feedback @endif">
									{{ Form::label('idproveedor','Proveedor') }}
									{{ Form::text('idproveedor',$oferta_expediente_data->nombre_proveedor,['disabled' => '','class' => 'form-control']) }}
								</div>
								<div class="form-group col-md-4 @if($errors->first('precio')) has-error has-feedback @endif">
									{{ Form::label('precio','Precio (S/.)') }}
									{{ Form::text('precio',$oferta_expediente_data->precio,['disabled' => '','Placeholder'=>'Precio','class' => 'form-control']) }}
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-12 @if($errors->first('caracteristicas')) has-error has-feedback @endif">
									{{ Form::label('caracteristicas','Características Principales') }}
									{{ Form::textarea('caracteristicas',$oferta_expediente_data->caracteristicas,['disabled' => '','Placeholder'=>'Características Principales','class' => 'form-control','maxlength'=>255]) }}
								</div>
							</div>
						@endforeach
					</div>
				</div>
			{{ Form::close() }}
	    </div>
	    <div class="tab-pane" id="tab_reporte_ofertas_evaluadas">
	      	{{ Form::open(array('url'=>'', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Reporte de Ofertas Evaluadas</h3>
					</div>
					<div class="panel-body">
						@foreach($ofertas_expediente_data as $oferta_expediente_data)							
							<div class="row">
								<div class="form-group col-md-4">
									<strong><font size="4">Oferta {{$oferta_expediente_data->correlativo_por_expediente}}</font></strong>							
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-2 @if($errors->first('usuario')) has-error has-feedback @endif">
									{{ Form::label('usuario','Miembro') }}
								</div>
								<div class="form-group col-md-10 @if($errors->first('evaluacion')) has-error has-feedback @endif">									
									{{ Form::label('usuario','Evaluación') }}
								</div>
							</div>
							@foreach($ofertas_evaluada_expediente_data as $oferta_evaluada_expediente_data)
								@if($oferta_expediente_data->idoferta_expediente == $oferta_evaluada_expediente_data->idoferta_expediente
									&& $oferta_evaluada_expediente_data->tipo_miembro == 1)
									<div class="row">
										<div class="form-group col-md-2 @if($errors->first('usuario')) has-error has-feedback @endif">
											{{ Form::text('usuario','Presidente',['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-10 @if($errors->first('evaluacion')) has-error has-feedback @endif">																									
											{{ Form::textarea('evaluacion',$oferta_evaluada_expediente_data->evaluacion,['disabled' => '','Placeholder'=>'Precio','class' => 'form-control']) }}
										</div>
									</div>
								@endif
							@endforeach
							@foreach($ofertas_evaluada_expediente_data as $oferta_evaluada_expediente_data)
								@if($oferta_expediente_data->idoferta_expediente == $oferta_evaluada_expediente_data->idoferta_expediente
									&& $oferta_evaluada_expediente_data->tipo_miembro == 2)
									<div class="row">
										<div class="form-group col-md-2 @if($errors->first('usuario')) has-error has-feedback @endif">
											{{ Form::text('usuario','Miembro 1',['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-10 @if($errors->first('evaluacion')) has-error has-feedback @endif">																									
											{{ Form::textarea('evaluacion',$oferta_evaluada_expediente_data->evaluacion,['disabled' => '','Placeholder'=>'Precio','class' => 'form-control']) }}
										</div>
									</div>
								@endif
							@endforeach
							@foreach($ofertas_evaluada_expediente_data as $oferta_evaluada_expediente_data)
								@if($oferta_expediente_data->idoferta_expediente == $oferta_evaluada_expediente_data->idoferta_expediente
									&& $oferta_evaluada_expediente_data->tipo_miembro == 3)
									<div class="row">
										<div class="form-group col-md-2 @if($errors->first('usuario')) has-error has-feedback @endif">
											{{ Form::text('usuario','Miembro 2',['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-10 @if($errors->first('evaluacion')) has-error has-feedback @endif">																									
											{{ Form::textarea('evaluacion',$oferta_evaluada_expediente_data->evaluacion,['disabled' => '','Placeholder'=>'Precio','class' => 'form-control']) }}
										</div>
									</div>
								@endif
							@endforeach
							@foreach($ofertas_evaluada_expediente_data as $oferta_evaluada_expediente_data)
								@if($oferta_expediente_data->idoferta_expediente == $oferta_evaluada_expediente_data->idoferta_expediente
									&& $oferta_evaluada_expediente_data->tipo_miembro == 4)
									<div class="row">
										<div class="form-group col-md-2 @if($errors->first('usuario')) has-error has-feedback @endif">
											{{ Form::text('usuario','Miembro 3',['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-10 @if($errors->first('evaluacion')) has-error has-feedback @endif">																									
											{{ Form::textarea('evaluacion',$oferta_evaluada_expediente_data->evaluacion,['disabled' => '','Placeholder'=>'Precio','class' => 'form-control']) }}
										</div>
									</div>
								@endif
							@endforeach
						@endforeach
					</div>
				</div>
			{{ Form::close() }}
	    </div>
	    <div class="tab-pane" id="tab_miembros_comite">
	      	{{ Form::open(array('url'=>'programacion_reportes/submit_create_programacion_reporte_paac', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Miembros de Comité</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('usuario_presidente')) has-error has-feedback @endif">
								{{ Form::label('usuario_presidente','Presidente',array('id'=>'usuario_presidente_label')) }}
								 @if($presidente_data != null)
									{{ Form::text('usuario_presidente',$presidente_data->username,array('disabled' => '','placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>8)) }}
									{{ Form::hidden('idpresidente',$presidente_data->id)}}
								@else
									{{ Form::text('usuario_presidente',Input::old('usuario_presidente'),array('disabled' => '','placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>8)) }}
									{{ Form::hidden('idpresidente')}}
								@endif
							</div>
							<div class="form-group col-md-4 @if($errors->first('nombre_presidente')) has-error has-feedback @endif">
								{{ Form::label('nombre_presidente','Nombre de Presidente',array('id'=>'nombre_presidente_label')) }}
								@if($presidente_data != null)
									{{ Form::text('nombre_presidente',$presidente_data->apellido_pat.' '.$presidente_data->apellido_mat.' '.$presidente_data->nombre,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::text('nombre_presidente',Input::old('nombre_presidente'),array('class'=>'form-control','readonly'=>'')) }}
								@endif
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('usuario_miembro1')) has-error has-feedback @endif">
								{{ Form::label('usuario_miembro1','Miembro 1',array('id'=>'usuario_miembro1_label')) }}
								 @if($miembro1_data != null)
									{{ Form::text('usuario_miembro1',$miembro1_data->username,array('disabled' => '','placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>8)) }}
									{{ Form::hidden('idpresidente',$miembro1_data->id)}}
								@else
									{{ Form::text('usuario_miembro1',Input::old('usuario_miembro1'),array('disabled' => '','placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>8)) }}
									{{ Form::hidden('idpresidente')}}
								@endif
							</div>
							<div class="form-group col-md-4 @if($errors->first('nombre_miembro1')) has-error has-feedback @endif">
								{{ Form::label('nombre_miembro1','Nombre de Miembro 1',array('id'=>'nombre_miembro1_label')) }}
								@if($miembro1_data != null)
									{{ Form::text('nombre_miembro1',$miembro1_data->apellido_pat.' '.$miembro1_data->apellido_mat.' '.$miembro1_data->nombre,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::text('nombre_miembro1',Input::old('nombre_miembro1'),array('class'=>'form-control','readonly'=>'')) }}
								@endif
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('usuario_miembro2')) has-error has-feedback @endif">
								{{ Form::label('usuario_miembro2','Miembro 2',array('id'=>'usuario_miembro2_label')) }}
								 @if($miembro2_data != null)
									{{ Form::text('usuario_miembro2',$miembro2_data->username,array('disabled' => '','placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>8)) }}
									{{ Form::hidden('idpresidente',$miembro2_data->id)}}
								@else
									{{ Form::text('usuario_miembro2',Input::old('usuario_miembro2'),array('disabled' => '','placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>8)) }}
									{{ Form::hidden('idpresidente')}}
								@endif
							</div>
							<div class="form-group col-md-4 @if($errors->first('nombre_miembro2')) has-error has-feedback @endif">
								{{ Form::label('nombre_miembro2','Nombre de Miembro 2',array('id'=>'nombre_miembro2_label')) }}
								@if($miembro2_data != null)
									{{ Form::text('nombre_miembro2',$miembro2_data->apellido_pat.' '.$miembro2_data->apellido_mat.' '.$miembro2_data->nombre,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::text('nombre_miembro2',Input::old('nombre_miembro2'),array('class'=>'form-control','readonly'=>'')) }}
								@endif
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3 @if($errors->first('usuario_miembro3')) has-error has-feedback @endif">
								{{ Form::label('usuario_miembro3','Miembro 3',array('id'=>'usuario_miembro3_label')) }}
								 @if($miembro3_data != null)
									{{ Form::text('usuario_miembro3',$miembro3_data->username,array('disabled' => '','placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>8)) }}
									{{ Form::hidden('idpresidente',$miembro3_data->id)}}
								@else
									{{ Form::text('usuario_miembro3',Input::old('usuario_miembro3'),array('disabled' => '','placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>8)) }}
									{{ Form::hidden('idpresidente')}}
								@endif
							</div>
							<div class="form-group col-md-4 @if($errors->first('nombre_miembro3')) has-error has-feedback @endif">
								{{ Form::label('nombre_miembro3','Nombre de Miembro 3',array('id'=>'nombre_miembro3_label')) }}
								@if($miembro3_data != null)
									{{ Form::text('nombre_miembro3',$miembro3_data->apellido_pat.' '.$miembro3_data->apellido_mat.' '.$miembro3_data->nombre,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::text('nombre_miembro3',Input::old('nombre_miembro3'),array('class'=>'form-control','readonly'=>'')) }}
								@endif
							</div>
						</div>
					</div>
				</div>
			{{ Form::close() }}
	    </div>
	    <div class="tab-pane" id="tab_observaciones_presentadas">
	      	{{ Form::open(array('url'=>'', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Observaciones Presentadas</h3>
					</div>
					<div class="panel-body">
						@foreach($ofertas_expediente_data as $oferta_expediente_data)
							<div class="row">
								<div class="form-group col-md-12">
									<strong><font size="4">Observaciones Presentadas para la Oferta {{$oferta_expediente_data->correlativo_por_expediente}}</font></strong>							
								</div>
							</div>
							@foreach($observaciones_expediente_data as $observacion_expediente_data)
								@if($oferta_expediente_data->idoferta_expediente == $observacion_expediente_data->idoferta_expediente
									&& $observacion_expediente_data->tipo_miembro == 1)
									<div class="row">
										<div class="form-group col-md-2 @if($errors->first('usuario')) has-error has-feedback @endif">
											{{ Form::label('usuario','Miembro') }}
											{{ Form::text('usuario','Presidente',['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-3 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
											{{ Form::label('tipo_documento','Tipo de Observación') }}
											{{ Form::text('tipo_documento',$observacion_expediente_data->tipo_observacion,['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-3 @if($errors->first('documento_adjunto')) has-error has-feedback @endif">
											{{ Form::label('documento_adjunto','Archivo Adjunto') }}
											{{ Form::text('documento_adjunto',$observacion_expediente_data->nombre_archivo,['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-2" style="margin-top:25px">
											<a class="btn btn-primary btn-block" href="{{URL::to('/observacion_expediente/download/')}}/{{$observacion_expediente_data->idobservacion_expediente}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-10 @if($errors->first('descripcion')) has-error has-feedback @endif">																									
											{{ Form::label('descripcion','Descripción') }}
											{{ Form::textarea('descripcion',$observacion_expediente_data->descripcion,['disabled' => '','Placeholder'=>'Precio','class' => 'form-control']) }}
										</div>
									</div>
								@endif
							@endforeach
							@foreach($observaciones_expediente_data as $observacion_expediente_data)
								@if($oferta_expediente_data->idoferta_expediente == $observacion_expediente_data->idoferta_expediente
									&& $observacion_expediente_data->tipo_miembro == 2)
									<div class="row">
										<div class="form-group col-md-2 @if($errors->first('usuario')) has-error has-feedback @endif">
											{{ Form::label('usuario','Miembro') }}
											{{ Form::text('usuario','Miembro 1',['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-3 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
											{{ Form::label('tipo_documento','Tipo de Observación') }}
											{{ Form::text('tipo_documento',$observacion_expediente_data->tipo_observacion,['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-3 @if($errors->first('documento_adjunto')) has-error has-feedback @endif">
											{{ Form::label('documento_adjunto','Archivo Adjunto') }}
											{{ Form::text('documento_adjunto',$observacion_expediente_data->nombre_archivo,['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-2" style="margin-top:25px">
											<a class="btn btn-primary btn-block" href="{{URL::to('/observacion_expediente/download/')}}/{{$observacion_expediente_data->idobservacion_expediente}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-10 @if($errors->first('descripcion')) has-error has-feedback @endif">																									
											{{ Form::label('descripcion','Descripción') }}
											{{ Form::textarea('descripcion',$observacion_expediente_data->descripcion,['disabled' => '','Placeholder'=>'Precio','class' => 'form-control']) }}
										</div>
									</div>
								@endif
							@endforeach
							@foreach($observaciones_expediente_data as $observacion_expediente_data)
								@if($oferta_expediente_data->idoferta_expediente == $observacion_expediente_data->idoferta_expediente
									&& $observacion_expediente_data->tipo_miembro == 3)
									<div class="row">
										<div class="form-group col-md-2 @if($errors->first('usuario')) has-error has-feedback @endif">
											{{ Form::label('usuario','Miembro') }}
											{{ Form::text('usuario','Miembro 2',['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-3 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
											{{ Form::label('tipo_documento','Tipo de Observación') }}
											{{ Form::text('tipo_documento',$observacion_expediente_data->tipo_observacion,['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-3 @if($errors->first('documento_adjunto')) has-error has-feedback @endif">
											{{ Form::label('documento_adjunto','Archivo Adjunto') }}
											{{ Form::text('documento_adjunto',$observacion_expediente_data->nombre_archivo,['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-2" style="margin-top:25px">
											<a class="btn btn-primary btn-block" href="{{URL::to('/observacion_expediente/download/')}}/{{$observacion_expediente_data->idobservacion_expediente}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-10 @if($errors->first('descripcion')) has-error has-feedback @endif">																									
											{{ Form::label('descripcion','Descripción') }}
											{{ Form::textarea('descripcion',$observacion_expediente_data->descripcion,['disabled' => '','Placeholder'=>'Precio','class' => 'form-control']) }}
										</div>
									</div>
								@endif
							@endforeach
							@foreach($observaciones_expediente_data as $observacion_expediente_data)
								@if($oferta_expediente_data->idoferta_expediente == $observacion_expediente_data->idoferta_expediente
									&& $observacion_expediente_data->tipo_miembro == 4)
									<div class="row">
										<div class="form-group col-md-2 @if($errors->first('usuario')) has-error has-feedback @endif">
											{{ Form::label('usuario','Miembro') }}
											{{ Form::text('usuario','Miembro 3',['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-3 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
											{{ Form::label('tipo_documento','Tipo de Observación') }}
											{{ Form::text('tipo_documento',$observacion_expediente_data->tipo_observacion,['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-3 @if($errors->first('documento_adjunto')) has-error has-feedback @endif">
											{{ Form::label('documento_adjunto','Archivo Adjunto') }}
											{{ Form::text('documento_adjunto',$observacion_expediente_data->nombre_archivo,['disabled' => '','class' => 'form-control']) }}
										</div>
										<div class="form-group col-md-2" style="margin-top:25px">
											<a class="btn btn-primary btn-block" href="{{URL::to('/observacion_expediente/download/')}}/{{$observacion_expediente_data->idobservacion_expediente}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
										</div>
									</div>
									<div class="row">
										<div class="form-group col-md-10 @if($errors->first('descripcion')) has-error has-feedback @endif">																									
											{{ Form::label('descripcion','Descripción') }}
											{{ Form::textarea('descripcion',$observacion_expediente_data->descripcion,['disabled' => '','Placeholder'=>'Precio','class' => 'form-control']) }}
										</div>
									</div>
								@endif
							@endforeach
						@endforeach
					</div>
				</div>
			{{ Form::close() }}
	    </div>
	    <div class="tab-pane" id="tab_adjudicacion">
	      	{{ Form::open(array('url'=>'', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Adjudicación</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-6 @if($errors->first('idproveedor_ganador')) has-error has-feedback @endif">
								{{ Form::label('idproveedor_ganador','Proveedor') }}						
								{{ Form::text('idproveedor_ganador',$expediente_tecnico_info->nombre_proveedor,['disabled' => '','class' => 'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('precio_ganador')) has-error has-feedback @endif">
								{{ Form::label('precio_ganador','Precio (S/.)') }}
								{{ Form::text('precio_ganador',$expediente_tecnico_info->precio,['disabled' => '','class' => 'form-control']) }}								
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-4">
								{{ Form::label('nombre_doc_relacionado','Contrato') }}
								{{ Form::text('nombre_doc_relacionado',$expediente_tecnico_info->nombre_archivo_contrato,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($expediente_tecnico_info->nombre_archivo_contrato != '')
								@if($expediente_tecnico_info->deleted_at)
									<div class="form-group col-md-2" style="margin-top:25px">
										<a class="btn btn-primary btn-block" href="{{URL::to('/adjudicacion_expediente/download_contrato/')}}/{{$expediente_tecnico_info->idexpediente_tecnico}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
									</div>
								@else
									<div class="form-group col-md-2" style="margin-top:25px">
										<a class="btn btn-primary btn-block" href="{{URL::to('/adjudicacion_expediente/download_contrato/')}}/{{$expediente_tecnico_info->idexpediente_tecnico}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
									</div>
								@endif		
							@endif				
						</div>
						<div class="row">
							<div class="form-group col-md-4">
								{{ Form::label('nombre_doc_relacionado','Documentos Adicionales') }}
								{{ Form::text('nombre_doc_relacionado',$expediente_tecnico_info->nombre_archivo_documento_adicional,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
							</div>	
							@if($expediente_tecnico_info->nombre_archivo_documento_adicional != '')
								@if($expediente_tecnico_info->deleted_at)
									<div class="form-group col-md-2" style="margin-top:25px">
										<a class="btn btn-primary btn-block" href="{{URL::to('/adjudicacion_expediente/download_documento_adicional/')}}/{{$expediente_tecnico_info->idexpediente_tecnico}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
									</div>
								@else
									<div class="form-group col-md-2" style="margin-top:25px">
										<a class="btn btn-primary btn-block" href="{{URL::to('/adjudicacion_expediente/download_documento_adicional/')}}/{{$expediente_tecnico_info->idexpediente_tecnico}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
									</div>
								@endif	
							@endif				
						</div>
					</div>
				</div>
			{{ Form::close() }}
	    </div>
	  </div>
	</div>
	
	<div class="row">
		<div class="col-md-2 form-group">
			<a class="btn btn-default btn-block" href="{{URL::to('/expediente_tecnico/list_expediente_tecnicos')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
		</div>	
	<div>
	
	<script>
		$("#input-file_resolucion").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
		$("#input-file_tdr").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
		$("#input-file_bases").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>
@stop