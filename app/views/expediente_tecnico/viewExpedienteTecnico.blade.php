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
						{{ Form::label('codigo_compra','Código de Compra') }}<span style='color:red'>*</span>
						{{ Form::text('codigo_compra',$expediente_tecnico_info->codigo_compra,['disabled'=>'','class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('codigo_archivamiento')) has-error has-feedback @endif">
						{{ Form::label('codigo_archivamiento','Código de Archivamiento') }}<span style='color:red'>*</span>
						{{ Form::text('codigo_archivamiento',$expediente_tecnico_info->codigo_archivamiento,['disabled'=>'','class' => 'form-control']) }}
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
								{{ Form::select('idtipo_adquisicion_expediente',array(''=>'Seleccione') + $tipos_adquisicion_expediente,$expediente_tecnico_info->idtipo_adquisicion_expediente,['disabled'=>'','class' => 'form-control']) }}
							</div>
							<div class="form-group col-md-4 @if($errors->first('idtipo_compra_expediente')) has-error has-feedback @endif">
								{{ Form::label('idtipo_compra_expediente','Tipo de Compra') }}<span style='color:red'>*</span>
								{{ Form::select('idtipo_compra_expediente',array(''=>'Seleccione') + $tipos_compra_expediente,$expediente_tecnico_info->idtipo_compra_expediente,['disabled'=>'','class' => 'form-control']) }}
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
						</div>
					</div>
				</div>
			{{ Form::close() }}
	    </div>
	    <div class="tab-pane" id="tab_ofertas">
	      	{{ Form::open(array('url'=>'programacion_reportes/submit_create_programacion_reporte_paac', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Ofertas</h3>
					</div>
					<div class="panel-body">
						
					</div>
				</div>
			{{ Form::close() }}
	    </div>
	    <div class="tab-pane" id="tab_reporte_ofertas_evaluadas">
	      	{{ Form::open(array('url'=>'programacion_reportes/submit_create_programacion_reporte_paac', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Reporte de Ofertas Evaluadas</h3>
					</div>
					<div class="panel-body">
						
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
						
					</div>
				</div>
			{{ Form::close() }}
	    </div>
	    <div class="tab-pane" id="tab_observaciones_presentadas">
	      	{{ Form::open(array('url'=>'programacion_reportes/submit_create_programacion_reporte_paac', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Observaciones Presentadas</h3>
					</div>
					<div class="panel-body">
						
					</div>
				</div>
			{{ Form::close() }}
	    </div>
	    <div class="tab-pane" id="tab_adjudicacion">
	      	{{ Form::open(array('url'=>'programacion_reportes/submit_create_programacion_reporte_paac', 'role'=>'form', 'files'=>true)) }}
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Adjudicación</h3>
					</div>
					<div class="panel-body">
						
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
	
@stop