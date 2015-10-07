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

	{{ Form::open(array('url'=>'equipos/submit_create_equipo', 'role'=>'form')) }}	

		<div class="row">			
			<div class="col-md-12">
				<div class="panel panel-default">
		  		<div class="panel-heading">Datos Generales</div>
		  			<div class="panel-body">	
						<div class="form-group row">								
							<div class="col-md-4">
								{{ Form::label('servicio_clinico','Servicio Clínico') }}
								{{ Form::select('servicio_clinico',array('' => 'Seleccione') + $servicios,Input::old('idservicio'),['class' => 'form-control'])}}								
							</div>
							<div class="col-md-4">
								{{ Form::label('ubicacion_fisica','Ubicación Física') }}
								{{ Form::select('ubicacion_fisica',array('' => 'Seleccione'),Input::old('ubicacion_fisica'),array('class'=>'form-control'))}}
							</div>
							<div class="col-md-4">
								{{ Form::label('grupo','Grupo') }}
								{{ Form::select('grupo',array('' => 'Seleccione') + $grupos,Input::old('idgrupo'),['class' => 'form-control'])}}								
							</div>				
						</div>
						<div class="form-group row">							
							<div class="col-md-4">
								{{ Form::label('marca','Marca') }}
								{{ Form::select('marca',array('' => 'Seleccione') + $marcas,Input::old('idmarca'),['class' => 'form-control'])}}
							</div>
							<div class="col-md-4">
								{{ Form::label('nombre_equipo','Nombre de Equipo') }}
								{{ Form::select('nombre_equipo',array('' => 'Seleccione'),Input::old('nombre_equipo'),array('class'=>'form-control'))}}								
							</div>
							<div class="col-md-4">
								{{ Form::label('modelo','Modelo') }}
								{{ Form::text('modelo',Input::old('modelo'),array('class'=>'form-control','placeholder'=>'Modelo','readonly'))}}								
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								{{ Form::label('numero_serie','Número de Serie') }}
								{{ Form::text('numero_serie',Input::old('numero_serie'),array('class'=>'form-control','placeholder'=>'Numero de Serie'))}}
							</div>
							<div class="col-md-4">
								{{ Form::label('proveedor','Proveedor') }}
								{{ Form::select('proveedor',array('' => 'Seleccione') + $proveedor,Input::old('proveedor'),array('class'=>'form-control'))}}
							</div>
							<div class="col-md-4">
								{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
								{{ Form::text('codigo_patrimonial',Input::old('codigo_patrimonial'),array('class'=>'form-control','placeholder'=>'Código Patrimonial'))}}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								{{ Form::label('codigo_compra','Código de Compra') }}
								{{ Form::text('codigo_compra',Input::old('codigo_compra'),array('class'=>'form-control','placeholder'=>'Código de Compra'))}}
							</div>
							<div class="col-md-4">
								{{ Form::label('fecha_adquisicion','Fecha de Adquisición') }}
								<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
									{{ Form::text('fecha_adquisicion',Input::old('fecha_adquisicion'),array('class'=>'form-control','readonly'=>'')) }}
									<span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
								</div>
							</div>
							<div class="col-md-4">
								{{ Form::label('centro_costo','Centro de Costo') }}
								{{ Form::select('centro_costo',array('' => 'Seleccione') + $centro_costos, Input::old('idcentro_costo'),array('class'=>'form-control'))}}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								{{ Form::label('garantia','Garantía (cantidad de meses)') }}
								{{ Form::text('garantia',Input::old('garantia'),array('class'=>'form-control','placeholder'=>'Garantía'))}}
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