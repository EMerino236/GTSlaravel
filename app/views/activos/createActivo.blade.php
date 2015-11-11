@extends('templates/activosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Activo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('servicio_clinico') }}</strong></p>
			<p><strong>{{ $errors->first('ubicacion_fisica') }}</strong></p>
			<p><strong>{{ $errors->first('grupo') }}</strong></p>
			<p><strong>{{ $errors->first('marca') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_equipo') }}</strong></p>
			<p><strong>{{ $errors->first('modelo') }}</strong></p>
			<p><strong>{{ $errors->first('numero_serie') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor') }}</strong></p>
			<p><strong>{{ $errors->first('codigo_patrimonial') }}</strong></p>
			<p><strong>{{ $errors->first('codigo_compra') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_adquisicion') }}</strong></p>
			<p><strong>{{ $errors->first('garantia') }}</strong></p>
			<p><strong>{{ $errors->first('reporte_instalacion') }}</strong></p>
			<p><strong>{{ $errors->first('idreporte_instalacion',"Ingrese un número de reporte válido. ") }}</strong></p>
		</div>
	@endif

	 @if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	{{ Form::open(array('url'=>'equipos/submit_create_equipo', 'role'=>'form')) }}
		<div class="row">			
			<div class="col-md-12">
				<div class="panel panel-default">
		  		<div class="panel-heading">Datos Generales</div>
		  			<div class="panel-body">	
						<div class="form-group row">								
							<div class="col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
								{{ Form::label('servicio_clinico','Servicio Clínico') }}<span style="color:red">*</span>
								{{ Form::select('servicio_clinico',array('' => 'Seleccione') + $servicios,Input::old('idservicio'),['class' => 'form-control'])}}								
							</div>
							<div class="col-md-4 @if($errors->first('ubicacion_fisica')) has-error has-feedback @endif">
								{{ Form::label('ubicacion_fisica','Ubicación Física') }}<span style="color:red">*</span>
								{{ Form::select('ubicacion_fisica',array('' => 'Seleccione') + $ubicacion,Input::old('ubicacion_fisica'),array('class'=>'form-control'))}}
							</div>
							<div class="col-md-4 @if($errors->first('grupo')) has-error has-feedback @endif">
								{{ Form::label('grupo','Grupo') }}<span style="color:red">*</span>
								{{ Form::select('grupo',array('' => 'Seleccione') + $grupos,Input::old('idgrupo'),['class' => 'form-control'])}}								
							</div>				
						</div>
						<div class="form-group row">							
							<div class="col-md-4 @if($errors->first('marca')) has-error has-feedback @endif">
								{{ Form::label('marca','Marca') }}<span style="color:red">*</span>
								{{ Form::select('marca',array('' => 'Seleccione') + $marcas,Input::old('idmarca'),['class' => 'form-control'])}}
							</div>
							<div class="col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
								{{ Form::label('nombre_equipo','Nombre de Equipo') }}<span style="color:red">*</span>
								{{ Form::select('nombre_equipo',array('' => 'Seleccione'),Input::old('nombre_equipo'),array('class'=>'form-control'))}}								
							</div>
							<div class="col-md-4 @if($errors->first('modelo')) has-error has-feedback @endif">
								{{ Form::label('modelo','Modelo') }}<span style="color:red">*</span>
								{{ Form::select('modelo',array('' => 'Seleccione'),Input::old('modelo'),array('class'=>'form-control'))}}								
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 @if($errors->first('numero_serie')) has-error has-feedback @endif">
								{{ Form::label('numero_serie','Número de Serie') }}<span style="color:red">*</span>
								{{ Form::text('numero_serie',Input::old('numero_serie'),array('class'=>'form-control','placeholder'=>'Numero de Serie'))}}
							</div>
							<div class="col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
								{{ Form::label('proveedor','Proveedor') }}<span style="color:red">*</span>
								{{ Form::select('proveedor',array('' => 'Seleccione') + $proveedor,Input::old('proveedor'),array('class'=>'form-control'))}}
							</div>
							<div class="col-md-4 @if($errors->first('codigo_patrimonial')) has-error has-feedback @endif">
								{{ Form::label('codigo_patrimonial','Código Patrimonial') }}<span style="color:red">*</span>
								{{ Form::text('codigo_patrimonial',Input::old('codigo_patrimonial'),array('class'=>'form-control','placeholder'=>'Código Patrimonial'))}}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
								{{ Form::label('codigo_compra','Código de Compra') }}<span style="color:red">*</span>
								{{ Form::text('codigo_compra',Input::old('codigo_compra'),array('class'=>'form-control','placeholder'=>'Código de Compra'))}}
							</div>
							<div class="col-md-4 @if($errors->first('fecha_adquisicion')) has-error has-feedback @endif">
								{{ Form::label('fecha_adquisicion','Fecha de Adquisición') }}<span style="color:red">*</span>
								<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
									{{ Form::text('fecha_adquisicion',Input::old('fecha_adquisicion'),array('class'=>'form-control','readonly'=>'')) }}
									<span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
								</div>
							</div>
							<div class="col-md-4 @if($errors->first('garantia')) has-error has-feedback @endif">
								{{ Form::label('garantia','Garantía (cantidad de meses)') }}<span style="color:red">*</span>
								{{ Form::text('garantia',Input::old('garantia'),array('class'=>'form-control','placeholder'=>'Garantía'))}}
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>

		<div class="row">			
			<div class="col-md-12">
				<div class="panel panel-default">
		  		<div class="panel-heading">Reporte de Instalación</div>
		  			<div class="panel-body">	
						<div class="form-group row">								
							<div class="col-md-3 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
								{{ Form::label('reporte_instalacion','Reporte de Instalación') }}<span style="color:red">*</span>
								{{ Form::text('reporte_instalacion',Input::old('reporte_instalacion'),['class' => 'form-control', 'placeholder'=>'Reporte de Instalación'])}}								
							</div>
							<div class="col-md-3">
								<button id="btnValidarNumReporte" class="btn btn-primary btn-block" type="button" style="margin-top:25px"><span class="glyphicon glyphicon-search"></span> Buscar</button>
							</div>
							<div class="col-md-3">
								<button id="btnLimpiarNumReporte" class="btn btn-default btn-block" type="button" style="margin-top:25px"><span class="glyphicon glyphicon-refresh"></span> Limpiar</button>						
							</div>
							<div class="col-md-3">
								{{ Form::label('mensaje_validacion','Validación') }}
								{{ Form::text('mensaje_validacion',Input::old('mensaje_validacion'),['class' => 'form-control'])}}
								{{ Form::hidden('idreporte_instalacion') }}								
							</div>			
						</div>
					</div>
				</div>			
			</div>
		</div>

		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/equipos/list_equipos')}}">Cancelar</a>				
			</div>
		</div>		
		
				
	{{ Form::close() }}
@stop