@extends('templates/activosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Equipo: <strong>{{$equipo_info->codigo_patrimonial}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('servicio_clinico',"El campo Servicio Clínico es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('ubicacion_fisica',"El campo Ubicación Física es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('grupo',"El campo Grupo es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('marca',"El campo Marca es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('nombre_equipo',"El campo Nombre de Equipo es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('modelo',"El campo Modelo es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('numero_serie',"El campo Número de Serie es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('proveedor',"El campo Proveedor es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('codigo_patrimonial',"El campo Código Patrimonial es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('codigo_compra',"El campo Código de Compra es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('fecha_adquisicion',"El campo Fecha de Adquisición es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('garantia',"El campo Garantía es requerido.") }}</strong></p>
			<p><strong>{{ $errors->first('reporte_instalacion',"El campo Reporte de Instalación es requerido.") }}</strong></p>
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

	{{ Form::open(array('url'=>'equipos/submit_edit_equipo', 'role'=>'form')) }}
	{{ Form::hidden('equipo_id', $equipo_info->idactivo) }}
		<div class="row">			
			<div class="col-md-12">
				<div class="panel panel-default">
		  		<div class="panel-heading">Datos Generales</div>
		  			<div class="panel-body">	
						<div class="form-group row">								
							<div class="col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
								{{ Form::label('servicio_clinico','Servicio Clínico') }}<span style="color:red">*</span>
								{{ Form::select('servicio_clinico',array('' => 'Seleccione') + $servicios,$equipo_info->idservicio,['class' => 'form-control'])}}								
							</div>
							<div class="col-md-4 @if($errors->first('ubicacion_fisica')) has-error has-feedback @endif">
								{{ Form::label('ubicacion_fisica','Ubicación Física') }}<span style="color:red">*</span>
								{{ Form::select('ubicacion_fisica',array('' => 'Seleccione') + $ubicaciones,$equipo_info->idubicacion_fisica,array('class'=>'form-control'))}}
							</div>
							<div class="col-md-4 @if($errors->first('grupo')) has-error has-feedback @endif">
								{{ Form::label('grupo','Grupo') }}<span style="color:red">*</span>
								{{ Form::select('grupo',array('' => 'Seleccione') + $grupos,$equipo_info->idgrupo,['class' => 'form-control'])}}								
							</div>				
						</div>
						<div class="form-group row">							
							<div class="col-md-4 @if($errors->first('marca')) has-error has-feedback @endif">
								{{ Form::label('marca','Marca') }}<span style="color:red">*</span>
								{{ Form::select('marca',array('' => 'Seleccione') + $marcas,$equipo_info->idmarca,['class' => 'form-control'])}}
							</div>
							<div class="col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
								{{ Form::label('nombre_equipo','Nombre de Equipo') }}<span style="color:red">*</span>
								{{ Form::select('nombre_equipo',array('' => 'Seleccione') + $nombre_equipo,$equipo_info->idfamilia_activo,array('class'=>'form-control'))}}								
							</div>
							<div class="col-md-4 @if($errors->first('modelo')) has-error has-feedback @endif">
								{{ Form::label('modelo','Modelo') }}<span style="color:red">*</span>
								{{ Form::select('modelo',array('' => 'Seleccione') + $modelo_equipo ,$equipo_info->modelo,array('class'=>'form-control'))}}								
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 @if($errors->first('numero_serie')) has-error has-feedback @endif">
								{{ Form::label('numero_serie','Número de Serie') }}<span style="color:red">*</span>
								{{ Form::text('numero_serie',$equipo_info->numero_serie,array('class'=>'form-control','placeholder'=>'Numero de Serie'))}}
							</div>
							<div class="col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
								{{ Form::label('proveedor','Proveedor') }}<span style="color:red">*</span>
								{{ Form::select('proveedor',array('' => 'Seleccione') + $proveedor,$equipo_info->idproveedor,array('class'=>'form-control'))}}
							</div>
							<div class="col-md-4 @if($errors->first('codigo_patrimonial')) has-error has-feedback @endif">
								{{ Form::label('codigo_patrimonial','Código Patrimonial') }}<span style="color:red">*</span>
								{{ Form::text('codigo_patrimonial',$equipo_info->codigo_patrimonial,array('class'=>'form-control','placeholder'=>'Código Patrimonial'))}}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
								{{ Form::label('codigo_compra','Código de Compra') }}<span style="color:red">*</span>
								{{ Form::text('codigo_compra',$equipo_info->codigo_compra,array('class'=>'form-control','placeholder'=>'Código de Compra'))}}
							</div>
							<div class="col-md-4 @if($errors->first('fecha_adquisicion')) has-error has-feedback @endif">
								{{ Form::label('fecha_adquisicion','Fecha de Adquisición') }}<span style="color:red">*</span>
								<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
									{{ Form::text('fecha_adquisicion',date('d-m-Y',strtotime($equipo_info->anho_adquisicion)),array('class'=>'form-control','readonly'=>'')) }}
									<span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 @if($errors->first('garantia')) has-error has-feedback @endif">
								{{ Form::label('garantia','Garantía (cantidad de meses)') }}<span style="color:red">*</span>
								{{ Form::text('garantia',$equipo_info->garantia,array('class'=>'form-control','placeholder'=>'Garantía'))}}
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
							<div class="col-md-3 @if($errors->first('reporte_instalacion_edit_activo')) has-error has-feedback @endif">
								{{ Form::label('reporte_instalacion_edit_activo','Reporte de Instalación') }}<span style="color:red">*</span>
								{{ Form::text('reporte_instalacion_edit_activo',$reporte_instalacion->numero_reporte_abreviatura.$reporte_instalacion->numero_reporte_correlativo.'-'.$reporte_instalacion->numero_reporte_anho,['class' => 'form-control', 'placeholder'=>'Reporte de Instalación'])}}								
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
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">				
				<a class="btn btn-default btn-block" href="{{URL::to('/equipos/list_equipos')}}">Cancelar</a>
			</div>
		</div>		
		
				
	{{ Form::close() }}
@stop