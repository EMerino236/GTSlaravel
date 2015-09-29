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
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_area') }}</strong></p>
			<p><strong>{{ $errors->first('centro_costo') }}</strong></p>
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
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
							{{ Form::label('tipo_documento','Tipo Documento') }}
							{{ Form::select('tipo_documento',$tipo_documento,Input::old('idtipo_documento'),['class' => 'form-control'])}}
						</div>
						<div class="form-group col-xs-2 @if($errors->first('numero_doc')) has-error has-feedback @endif">
							{{ Form::label('numero_doc','Número Documento') }}
							{{ Form::text('numero_doc',Input::old('numero_doc'),['class' => 'form-control'])}}
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default">Agregar</a>
						</div>
						<div class="form-group col-xs-1" style="margin-top:25px">
							<a class="btn btn-default">Limpiar</a>
						</div>
						<div class="form-group col-xs-5">
							{{ Form::label('responsable','Responsable') }}
							{{ Form::text('responsable',Input::old('responsable'),['class' => 'form-control'])}}
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-1">
							{{ Form::label('fecha','Fecha')}}
							<div id="datetimepicker1" class="form-group input-group date">					
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
							{{ Form::textarea('descripcion',Input::old('descripcion'),['class' => 'form-control'])}}
		        		</div>
		        	</div>
		        	<br>
		        	<div class="row">
		        		<div class="form-group col-xs-4 col-xs-offset-1 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio Clínico') }}
							{{ Form::select('servicio',$servicios,Input::old('idservicio'),['class' => 'form-control',"onchange" => "fill_responsable_servicio()",'id'=>'servicio'])}}
						</div>
						<div class="form-group col-xs-4  @if($errors->first('responsable_servicio')) has-error has-feedback @endif">
							{{ Form::label('responsable_servicio','Responsable del Servicio') }}
							{{ Form::text('responsable_servicio',Input::old('idresponsable'),['class' => 'form-control','id'=>'servicio_resp','disabled'=>'disabled'])}}
						</div>
		        	</div>
		        	<div class="row">
		        		<div class="form-group col-xs-4 col-xs-offset-1 @if($errors->first('proveedor')) has-error has-feedback @endif">
							{{ Form::label('proveedor','Proveedor') }}
							{{ Form::select('proveedor',$proveedor,Input::old('idproveedor'),['class' => 'form-control',"onchange" => "fill_contacto_proveedor()",'id'=>'proveedor'])}}
						</div>
						<div class="form-group col-xs-4  @if($errors->first('contacto_proveedor')) has-error has-feedback @endif">
							{{ Form::label('contacto_proveedor','Contacto de Proveedor') }}
							{{ Form::text('contacto_proveedor',Input::old('contacto_proveedor'),['class' => 'form-control','id'=>'contacto_proveedor'])}}
						</div>
		        	</div>
				</div>			
			</div>
		</div>
		{{ Form::close() }}
@stop