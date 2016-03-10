@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Programación de Compra</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('codigo_compra') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_corta') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_compra') }}</strong></p>
			<p><strong>{{ $errors->first('cantidad') }}</strong></p>
			<p><strong>{{ $errors->first('idunidad_medida') }}</strong></p>
			<p><strong>{{ $errors->first('costo_aproximado') }}</strong></p>
			<p><strong>{{ $errors->first('idusuario') }}</strong></p>
			<p><strong>{{ $errors->first('idarea') }}</strong></p>
			<p><strong>{{ $errors->first('idservicio') }}</strong></p>
			<p><strong>{{ $errors->first('idresponsable') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_inicio_evaluacion') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_aproximada_adquisicion') }}</strong></p>
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

	{{ Form::open(array('url'=>'programacion_compra/submit_create_programacion_compra', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de la Programacion de Compra</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
						{{ Form::label('codigo_compra','Código de Compra') }}<span style='color:red'>*</span>
						{{ Form::text('codigo_compra',Input::old('codigo_compra'),array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8 @if($errors->first('descripcion_corta')) has-error has-feedback @endif">
						{{ Form::label('descripcion_corta','Descripción corta') }}<span style='color:red'>*</span>
						{{ Form::text('descripcion_corta',Input::old('descripcion_corta'),array('class'=>'form-control')) }}
					</div>
				</div>		
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_compra')) has-error has-feedback @endif">
						{{ Form::label('idtipo_compra','Elemento de Compra') }}<span style='color:red'>*</span>
						{{ Form::select('idtipo_compra',array(''=>'Seleccione') + $tipo_compra,Input::old('idtipo_compra'),['class' => 'form-control']) }}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('cantidad')) has-error has-feedback @endif">
						{{ Form::label('cantidad','Cantidad') }}<span style='color:red'>*</span>
						{{ Form::text('cantidad',Input::old('cantidad'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('idunidad_medida')) has-error has-feedback @endif">
						{{ Form::label('idunidad_medida','Unidad de Medida') }}<span style='color:red'>*</span>
						{{ Form::select('idunidad_medida',array(''=>'Seleccione') + $unidad_medida,Input::old('idunidad_medida'),['class' => 'form-control']) }}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('costo_aproximado')) has-error has-feedback @endif">
						{{ Form::label('costo_aproximado','Costo aproximado') }}<span style='color:red'>*</span>
						{{ Form::text('costo_aproximado',Input::old('costo_aproximado'),array('class'=>'form-control')) }}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idservicio')) has-error has-feedback @endif">
						{{ Form::label('idservicio','Servicio') }}<span style='color:red'>*</span>
						{{ Form::select('idservicio',array(''=>'Seleccione') + $servicios,Input::old('idservicio'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('idarea_select')) has-error has-feedback @endif">
						{{ Form::label('idarea_select','Departamento') }}<span style='color:red'>*</span>
						{{ Form::select('idarea_select',array(''=>'Seleccione') + $areas,Input::old('idarea_select'),['class' => 'form-control']) }}
						{{ Form::hidden('idarea')}}
					</div>
				</div>	
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('num_doc_usuario')) has-error has-feedback @endif">
						{{ Form::label('num_doc_usuario','N° Documento Usuario Solicitante',array('id'=>'num_doc_usuario_label')) }}<span style='color:red'>*</span>
						{{ Form::text('num_doc_usuario',Input::old('num_doc_usuario'),array('placeholder'=>'N° Documento de Identidad','class'=>'form-control','maxlength'=>8)) }}
						{{ Form::hidden('idusuario')}}
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_usuario()"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
						<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_usuario()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_usuario')) has-error has-feedback @endif">
						{{ Form::label('nombre_usuario','Nombre de Usuario Solicitante',array('id'=>'nombre_usuario_label')) }}
						{{ Form::text('nombre_usuario',Input::old('nombre_usuario'),array('class'=>'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('num_doc_responsable')) has-error has-feedback @endif">
						{{ Form::label('num_doc_responsable','N° Documento Responsable',array('id'=>'num_doc_responsable_label')) }}<span style='color:red'>*</span>
						{{ Form::text('num_doc_responsable',Input::old('num_doc_responsable'),array('placeholder'=>'N° Documento de Identidad','class'=>'form-control','maxlength'=>8)) }}
						{{ Form::hidden('idresponsable')}}
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_responsable()"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
						<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_responsable()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_responsable')) has-error has-feedback @endif">
						{{ Form::label('nombre_responsable','Nombre de Responsable',array('id'=>'nombre_responsable_label')) }}
						{{ Form::text('nombre_responsable',Input::old('nombre_responsable'),array('class'=>'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
						{{ Form::label('descripcion','Descripción') }}<span style='color:red'>*</span>
						{{ Form::textarea('descripcion',Input::old('descripcion'),array('class'=>'form-control')) }}
					</div>
				</div>	
				<div class="row">
					<div class="col-md-4">
						{{ Form::label('fecha_inicio_evaluacion','Fecha de Inicio de Evaluación') }}<span style='color:red'>*</span>
						<div id="datetimepicker_fecha_inicio_evaluacion" class="form-group input-group date @if($errors->first('fecha_inicio_evaluacion')) has-error has-feedback @endif">
							{{ Form::text('fecha_inicio_evaluacion',Input::old('fecha_inicio_evaluacion'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
					<div class="col-md-4">
						{{ Form::label('fecha_aproximada_adquisicion','Fecha Aproximada de Adquisición') }}<span style='color:red'>*</span>
						<div id="datetimepicker_fecha_aproximada_adquisicion" class="form-group input-group date @if($errors->first('fecha_aproximada_adquisicion')) has-error has-feedback @endif">
							{{ Form::text('fecha_aproximada_adquisicion',Input::old('fecha_aproximada_adquisicion'),array('class'=>'form-control', 'readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>
					</div>
				</div>
			</div>	
		</div>
		<div>
			<div class="row">
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>	
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/programacion_compra/list_programacion_compras/')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
				</div>
			</div>
		</div>
	{{ Form::close() }}
	
@stop