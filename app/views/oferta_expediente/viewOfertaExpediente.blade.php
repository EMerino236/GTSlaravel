@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Ver Oferta</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('precio') }}</strong></p>
			<p><strong>{{ $errors->first('caracteristicas') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'oferta_expediente/submit_edit_oferta_expediente', 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('idexpediente_tecnico',$oferta_expediente_data->idexpediente_tecnico)}}
		{{ Form::hidden('idoferta_expediente',$oferta_expediente_data->idoferta_expediente)}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la Oferta</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
						{{ Form::label('codigo_compra','Código de Compra') }}
						{{ Form::text('codigo_compra',$expediente_tecnico_data->codigo_compra,['disabled'=>'','class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<strong><font size="4">Oferta {{$oferta_expediente_data->correlativo_por_expediente}}</font></strong>							
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idproveedor')) has-error has-feedback @endif">
						{{ Form::label('idproveedor','Proveedor') }}<span style='color:red'>*</span>
						{{ Form::select('idproveedor',array(''=>'Seleccione') + $proveedores,$oferta_expediente_data->idproveedor,['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('precio')) has-error has-feedback @endif">
						{{ Form::label('precio','Precio (S/.)') }}<span style='color:red'>*</span>
						{{ Form::text('precio',$oferta_expediente_data->precio,['Placeholder'=>'Precio','class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12 @if($errors->first('caracteristicas')) has-error has-feedback @endif">
						{{ Form::label('caracteristicas','Características Principales') }}<span style='color:red'>*</span>
						{{ Form::textarea('caracteristicas',$oferta_expediente_data->caracteristicas,['Placeholder'=>'Características Principales','class' => 'form-control','maxlength'=>255]) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('nombre_doc_relacionado','Archivo adjunto') }}
						{{ Form::text('nombre_doc_relacionado',$oferta_expediente_data->nombre_archivo,['class' => 'form-control','id'=>'nombre_doc_relacionado','disabled'=>'disabled'])}}
					</div>	
					@if($oferta_expediente_data->deleted_at)
						<div class="form-group col-md-2" style="margin-top:25px">
							<a class="btn btn-primary btn-block" href="{{URL::to('/oferta_expediente/download/')}}/{{$oferta_expediente_data->idoferta_expediente}}" disabled><span class="glyphicon glyphicon-download"></span> Descargar</a>
						</div>
					@else
						<div class="form-group col-md-2" style="margin-top:25px">
							<a class="btn btn-primary btn-block" href="{{URL::to('/oferta_expediente/download/')}}/{{$oferta_expediente_data->idoferta_expediente}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
						</div>
					@endif				
				</div>
			</div>
		</div>	
		<div class="row">
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/oferta_expediente/list_oferta_expedientes/')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
			</div>
		</div>		
		</div>	
	{{ Form::close() }}
	
@stop