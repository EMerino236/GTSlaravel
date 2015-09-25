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
			<p><strong>{{ $errors->first('grupo') }}</strong></p>
			<p><strong>{{ $errors->first('servicio_clinico') }}</strong></p>
			<p><strong>{{ $errors->first('ubicacion_fisica') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_equipo') }}</strong></p>
			<p><strong>{{ $errors->first('marca') }}</strong></p>
			<p><strong>{{ $errors->first('modelo') }}</strong></p>
			<p><strong>{{ $errors->first('idproveedor') }}</strong></p>
			<p><strong>{{ $errors->first('codigopatrimonial') }}</strong></p>
			<p><strong>{{ $errors->first('codigocompra') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_adquisicion') }}</strong></p>
			<p><strong>{{ $errors->first('idcentro_costo') }}</strong></p>
			<p><strong>{{ $errors->first('garantia') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'equipos/submitEquipo', 'role'=>'form')) }}
		<div class="row">
			<div class="form-group col-xs-3 col-xs-offset-10">
				{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
			</div>
		</div>	
		<div class="row">
			<div class="panel panel-default">
		  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="row">								
					<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('group')) has-error has-feedback @endif">
						{{ Form::label('grupo','Grupo') }}
						{{ Form::select('grupo',$grupos,Input::old('idgrupo'),['class' => 'form-control'])}}
					</div>
					<div class="form-group col-xs-4">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::select('servicio_clinico',$servicios,Input::old('idservicio'),['class' => 'form-control'])}}
					</div>
					<div class="form-group col-xs-4">
						{{ Form::label('ubicacion_fisica','Ubicación Física') }}
						{{ Form::text('ubicacion_fisica',Input::old('ubicacion_fisica'),array('class'=>'form-control'))}}
					</div>				
				</div>
				<div class="row">
					<div class="col-xs-4 col-xs-offset-1">
							<div class="form-group row">
								{{ Form::label('nombre_equipo','Nombre de Equipo') }}
								{{ Form::text('nombre_equipo',Input::old('nombre_equipo'),['class' => 'form-control'])}}
							</div>
							<div class="form-group row">
								{{ Form::label('marca','Marca') }}
								{{ Form::select('marca',$marcas,Input::old('idmarca'),['class' => 'form-control'])}}
							</div>
							<div class="form-group row">
								{{ Form::label('modelo','Modelo') }}
								{{ Form::text('modelo',Input::old('modelo'),array('class'=>'form-control'))}}
							</div>
							<div class="form-group row">
								{{ Form::label('numero_serie','Número de Serie') }}
								{{ Form::text('numero_serie',Input::old('numero_serie'),array('class'=>'form-control'))}}
							</div>
							<div class="form-group row">
								{{ Form::label('proveedor','Proveedor') }}
								{{ Form::text('proveedor',Input::old('proveedor'),array('class'=>'form-control'))}}
							</div>
							<div class="form-group row">
								{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
								{{ Form::text('codigo_patrimonial',Input::old('codigo_patrimonial'),array('class'=>'form-control'))}}
							</div>
							<div class="form-group row">
								{{ Form::label('codigo_compra','Código de Compra') }}
								{{ Form::text('codigo_compra',Input::old('codigo_compra'),array('class'=>'form-control'))}}
							</div>
							<div class="form-group row">
								{{ Form::label('fecha_adquisicion','Fecha de Adquisición') }}
								<div id="datetimepicker1" class="form-group input-group date col-xs-8 @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
									{{ Form::text('fecha_adquisicion',Input::old('fecha_adquisicion'),array('class'=>'form-control','readonly'=>'')) }}
									<span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
								</div>
							</div>
							<div class="form-group row">
								{{ Form::label('centro_costo','Centro de Costo') }}
								{{ Form::select('centro_costo',$centro_costos, Input::old('idcentro_costo'),array('class'=>'form-control'))}}
							</div>
							<div class="form-group row">
								{{ Form::label('garantia','Garantía (cantidad de meses)') }}
								{{ Form::text('garantia',Input::old('garantia'),array('class'=>'form-control'))}}
							</div>					
					</div>
				</div>
				<div class="row">

				</div>
			</div>
			
			</div>
		</div>
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">Soporte Técnico</div>
				<table class="table table-bordered">
						<tr class="info">
							<th><strong>Nombres</strong></th>
							<th><strong>Especialidad</strong></th>
							<th><strong>Telefono</strong></th>
							<th><strong>E-mail</strong></th>
						</tr>
					</table>
			</div>
		</div>
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">Ficha Técnica del Equipo</div>
				<br>	
				<div class="row">
					<div class="col-xs-2"></div>
					<div class="col-xs-8">
						<table class="table table-bordered">
								<tr class="info">
									<th><strong>Componentes del Equipo</strong></th>
									<th><strong>Marca</strong></th>
									<th><strong>Modelo</strong></th>
									<th><strong>Número Parte</strong></th>
									<th><strong>Costo</strong></th>
								</tr>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2"></div>
					<div class="col-xs-8">
						<table class="table table-bordered">
								<tr class="info">
									<th><strong>Accesorios del Equipo</strong></th>
									<th><strong>Marca</strong></th>
									<th><strong>Modelo</strong></th>
									<th><strong>Número Parte</strong></th>
									<th><strong>Costo</strong></th>
								</tr>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-2"></div>
					<div class="col-xs-8">
						<table class="table table-bordered">
								<tr class="info">
									<th><strong>Consumibles del Equipo</strong></th>
									<th><strong>Descripción</strong></th>
									<th><strong>Cantidad</strong></th>
									<th><strong>Número Parte</strong></th>
									<th><strong>Costo</strong></th>
								</tr>
						</table>
					</div>
				</div>	
			</div>
		</div>
		

				
	{{ Form::close() }}
@stop