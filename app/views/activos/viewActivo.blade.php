@extends('templates/bienesViewTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Equipo: <strong>{{$equipo_info->codigo_patrimonial}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
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
	
	{{ Form::hidden('equipo_id', $equipo_info->idactivo) }}
		<div class="row">			
			<div class="col-md-12">
				<div class="panel panel-default">
		  		<div class="panel-heading">Datos Generales</div>
		  			<div class="panel-body">	
						<div class="form-group row">								
							<div class="col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
								{{ Form::label('servicio_clinico','Servicio Clínico') }}<span style="color:red">*</span>
								{{ Form::select('servicio_clinico',array('' => 'Seleccione') + $servicios,$equipo_info->idservicio,['class' => 'form-control','disabled'])}}								
							</div>
							<div class="col-md-4 @if($errors->first('ubicacion_fisica')) has-error has-feedback @endif">
								{{ Form::label('ubicacion_fisica','Ubicación Física') }}<span style="color:red">*</span>
								{{ Form::select('ubicacion_fisica',array('' => 'Seleccione') + $ubicaciones,$equipo_info->idubicacion_fisica,array('class'=>'form-control','disabled'))}}
							</div>
							<div class="col-md-4 @if($errors->first('grupo')) has-error has-feedback @endif">
								{{ Form::label('grupo','Grupo') }}<span style="color:red">*</span>
								{{ Form::select('grupo',array('' => 'Seleccione') + $grupos,$equipo_info->idgrupo,['class' => 'form-control','disabled'])}}								
							</div>				
						</div>
						<div class="form-group row">							
							<div class="col-md-4 @if($errors->first('marca')) has-error has-feedback @endif">
								{{ Form::label('marca','Marca') }}<span style="color:red">*</span>
								{{ Form::select('marca',array('' => 'Seleccione') + $marcas,$equipo_info->idmarca,['class' => 'form-control','disabled'])}}
							</div>
							<div class="col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
								{{ Form::label('nombre_equipo','Nombre de Equipo') }}<span style="color:red">*</span>
								{{ Form::select('nombre_equipo',array('' => 'Seleccione') + $nombre_equipo,$equipo_info->idfamilia_activo,array('class'=>'form-control','disabled'))}}								
							</div>
							<div class="col-md-4 @if($errors->first('modelo')) has-error has-feedback @endif">
								{{ Form::label('modelo','Modelo') }}<span style="color:red">*</span>
								{{ Form::select('modelo',array('' => 'Seleccione') + $modelo_equipo ,$equipo_info->modelo,array('class'=>'form-control','disabled'))}}								
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 @if($errors->first('numero_serie')) has-error has-feedback @endif">
								{{ Form::label('numero_serie','Número de Serie') }}<span style="color:red">*</span>
								{{ Form::text('numero_serie',$equipo_info->numero_serie,array('class'=>'form-control','placeholder'=>'Numero de Serie','disabled'))}}
							</div>
							<div class="col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
								{{ Form::label('proveedor','Proveedor') }}<span style="color:red">*</span>
								{{ Form::select('proveedor',array('' => 'Seleccione') + $proveedor,$equipo_info->idproveedor,array('class'=>'form-control','disabled'))}}
							</div>
							<div class="col-md-4 @if($errors->first('codigo_patrimonial')) has-error has-feedback @endif">
								{{ Form::label('codigo_patrimonial','Código Patrimonial') }}<span style="color:red">*</span>
								{{ Form::text('codigo_patrimonial',$equipo_info->codigo_patrimonial,array('class'=>'form-control','placeholder'=>'Código Patrimonial','disabled'))}}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
								{{ Form::label('codigo_compra','Código de Compra') }}<span style="color:red">*</span>
								{{ Form::text('codigo_compra',$equipo_info->codigo_compra,array('class'=>'form-control','placeholder'=>'Código de Compra','disabled'))}}
							</div>
							<div class="col-md-4 @if($errors->first('fecha_adquisicion')) has-error has-feedback @endif">
								{{ Form::label('fecha_adquisicion','Fecha de Adquisición') }}<span style="color:red">*</span>
								<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_nacimiento')) has-error has-feedback @endif">
									{{ Form::text('fecha_adquisicion',date('d-m-Y',strtotime($equipo_info->anho_adquisicion)),array('class'=>'form-control','readonly'=>'','disabled')) }}
									<span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
								</div>
							</div>
							<div class="col-md-4 @if($errors->first('costo')) has-error has-feedback @endif">
								{{ Form::label('costo','Precio de Compra (S/.)') }}<span style="color:red">*</span>
								{{ Form::text('costo',$equipo_info->costo,array('class'=>'form-control','placeholder'=>'Precio de Compra (S/.)','disabled'))}}
							</div>							
						</div>						
						<div class="form-group row">
							<div class="col-md-4 @if($errors->first('garantia')) has-error has-feedback @endif">
								{{ Form::label('garantia','Garantía (cantidad de meses)') }}<span style="color:red">*</span>
								{{ Form::text('garantia',$equipo_info->garantia,array('class'=>'form-control','placeholder'=>'Garantía','disabled'))}}
							</div>
							<div class="col-md-4 @if($errors->first('garantia')) has-error has-feedback @endif">
								{{ Form::label('reporte_instalacion','Reporte de Instalación') }}<span style="color:red">*</span>
								{{ Form::text('reporte_instalacion',$reporte_instalacion->numero_reporte_abreviatura.$reporte_instalacion->numero_reporte_correlativo.'-'.$reporte_instalacion->numero_reporte_anho,['class' => 'form-control', 'placeholder'=>'Reporte de Instalación','disabled'])}}								
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Soporte Técnico</div>
		  	<div class="panel-body">
		  		<div class="row">
		  			<div class="container-fluid">		  				
			  			<div class="table-responsive">
							<table class="table">
								<tr class="info">
									<th class="text-nowrap">Nº</th>
									<th class="text-nowrap">Tipo de Documento</th>
									<th class="text-nowrap">Número de Documento</th>
									<th class="text-nowrap">Nombre</th>
									<th class="text-nowrap">Apellido Paterno</th>
									<th class="text-nowrap">Apellido Materno</th>
									<th class="text-nowrap">Especialidad</th>
									<th class="text-nowrap">Teléfono</th>				
									<th class="text-nowrap">E-mail</th>									
								</tr>
								@foreach($soporte_tecnico_info as $index => $soporte_tecnico)
								<tr class="@if($soporte_tecnico->deleted_at) bg-danger @endif">			
									<td class="text-nowrap">
										{{$index + 1}}
									</td>
									<td class="text-nowrap">
										{{$soporte_tecnico->tipo_documento}}
									</td>
									<td class="text-nowrap">
										{{$soporte_tecnico->numero_documento}}
									</td>
									<td class="text-nowrap">
										{{$soporte_tecnico->nombres}}
									</td>
									<td class="text-nowrap">
										{{$soporte_tecnico->apellido_pat}}
									</td>
									<td class="text-nowrap">
										{{$soporte_tecnico->apellido_mat}}
									</td>						
									<td class="text-nowrap">
										{{$soporte_tecnico->especialidad}}
									</td>
									<td class="text-nowrap">
										{{$soporte_tecnico->telefono}}
									</td>
									<td class="text-nowrap">
										{{$soporte_tecnico->email}}
									</td>														
								</tr>
								@endforeach		
							</table>
						</div>
					</div>
				</div>
		  	</div>
		</div>

		<div class="panel panel-default">
		  	<div class="panel-heading">Ficha Técnica del Equipo</div>
		  	<div class="panel-body">

		  		<div class="row">
		  			<div class="container-fluid">
		  				<h4>Accesorios</h4>
			  			<div class="table-responsive">
							<table class="table">
								<tr class="info">
									<th>Nº</th>
									<th>Numero de Pieza</th>
									<th>Nombre</th>
									<th>Modelo</th>				
									<th>Costo (S/.)</th>						
								</tr>
								@foreach($accesorios_info as $index => $accesorio_info)
								<tr>
									<td>
										{{$index + 1}}
									</td>
									<td>
										{{$accesorio_info->numero_pieza}}
									</td>
									<td>
										{{$accesorio_info->nombre}}
									</td>
									<td>
										{{$accesorio_info->modelo}}
									</td>
									<td>
										{{number_format($accesorio_info->costo,2)}}
								</tr>
								@endforeach
							</table>
						</div>
					</div>
		  		</div>

		  		<div class="row">
		  			<div class="container-fluid">
		  				<h4>Componentes</h4>
		  				<div class="table-responsive">
							<table class="table">
								<tr class="info">
									<th>Nº</th>
									<th>Numero de Pieza</th>
									<th>Nombre</th>
									<th>Modelo</th>				
									<th>Costo (S/.)</th>						
								</tr>
								@foreach($componentes_info as $index => $componente_info)
								<tr>
									<td>
										{{$index + 1}}
									</td>
									<td>
										{{$componente_info->numero_pieza}}
									</td>
									<td>
										{{$componente_info->nombre}}
									</td>
									<td>
										{{$componente_info->modelo}}
									</td>
									<td>
										{{number_format($componente_info->costo,2)}}
									</td>						
								</tr>
								@endforeach
							</table>
						</div>
					</div>		  			
		  		</div>

		  		<div class="row">
		  			<div class="container-fluid">
		  				<h4>Consumibles</h4>
		  				<div class="table-responsive">
							<table class="table">
								<tr class="info">
									<th>Nº</th>
									<th>Nombre</th>
									<th>Cantidad</th>				
									<th>Costo (S/.)</th>						
								</tr>
								@foreach($consumibles_info as $index => $consumible_info)
								<tr>
									<td>
										{{$index + 1}}
									</td>
									<td>
										{{$consumible_info->nombre}}
									</td>
									<td>
										{{$consumible_info->cantidad}}
									</td>
									<td>
										{{number_format($consumible_info->costo,2)}}
									</td>						
								</tr>
								@endforeach
							</table>
						</div>
		  			</div>
		  		</div>

			</div>
		</div>
		
		<div class="container-fluid row">			
			<div class="form-group col-md-offset-10 col-md-2">				
				<a class="btn btn-default btn-block" href="{{URL::to('/equipos/list_equipos')}}">
				<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
			</div>
		</div>			
			
@stop