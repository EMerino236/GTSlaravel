@extends('templates/solicitudCompraTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Requerimiento de Compra</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('numero_ot') }}</strong></p>
			<p><strong>{{ $errors->first('servicio') }}</strong></p>
			<p><strong>{{ $errors->first('centro_costo') }}</strong></p>
			<p><strong>{{ $errors->first('marca1') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_equipo1') }}</strong></p>
			<p><strong>{{ $errors->first('usuario_responsable') }}</strong></p>
			<p><strong>{{ $errors->first('tipo') }}</strong></p>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('numero_reporte') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'solicitudes_comprar/submit_create_solicitud', 'role'=>'form')) }}		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">	
					<div class="form-group row">								
						<div class="form-group col-md-4 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('numero_ot','Número de OT:') }}
							{{ Form::text('numero_ot',Input::old('numero_ot'),['class' => 'form-control','id'=>'numero_ot'])}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio:') }}
							{{ Form::select('servicio',array('0'=> 'Seleccione')+ $servicios,Input::old('servicio'),array('class'=>'form-control','id'=>'servicio'))}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('centro_costo')) has-error has-feedback @endif">
							{{ Form::label('centro_costo','Centro de Costo') }}
							{{ Form::select('centro_costo',array('0'=> 'Seleccione')+ $centro_costos, Input::old('centro_costo'),array('class'=>'form-control','id'=>'centro_costo'))}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('marca1')) has-error has-feedback @endif">
							{{ Form::label('marca1','Marca:') }}
							{{ Form::select('marca1',array('0'=>'Seleccione')+ $marcas1,Input::old('marca1'),array('class'=>'form-control','id'=>'marca1'))}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('nombre_equipo1')) has-error has-feedback @endif">
							{{ Form::label('nombre_equipo1','Equipo:') }}
							{{ Form::select('nombre_equipo1',$nombre_equipos1, Input::old('nombre_equipo1'), array('class'=>'form-control','id'=>'equipo1')) }}
						</div>
						<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
							{{ Form::label('usuario_responsable','Usuario Responsable:') }}
							<select name="usuario_responsable" class="form-control" id="usuario_responsable">
								@foreach($usuarios_responsable as $usuario_responsable)
									<option value="{{ $usuario_responsable->id }}">{{ $usuario_responsable->apellido_pat }} {{ $usuario_responsable->apellido_mat }}, {{ $usuario_responsable->nombre }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-4 @if($errors->first('tipo')) has-error has-feedback @endif">
							{{ Form::label('tipo','Tipo de Requerimiento:') }}
							{{ Form::select('tipo',array('0'=>'Seleccione') + $tipos, Input::old('tipo'), array('class'=>'form-control','id'=>'tipo')) }}
						</div>
						<div class="col-md-4">
							{{ Form::label('fecha','Fecha:')}}
							<div id="datetimepicker1" class="form-group input-group date">					
								{{ Form::text('fecha',null,array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>
        				</div>
					</div>
				</div>			
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Sustento</div>
				  	<div class="panel-body">
				  		<div class="form-group row">
				  			<div class="form-group col-md-12 @if($errors->first('sustento')) has-error has-feedback @endif">
					  			{{ Form::label('sustento','Sustento de la solicitud:') }}
								{{ Form::textarea('sustento',Input::old('sustento'),['class' => 'form-control','style'=>'resize:none;','placeholder'=>'Texto para explicar nueva adquisición','id'=>'sustento'])}}
				  			</div>
				  		</div>
				  	</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
	  				<div class="panel-heading">Documento Relacionado</div>
	  				<div class="panel-body">
						<div class="row">								
							<div class="form-group col-md-2 @if($errors->first('numero_reporte')) has-error has-feedback @endif">
								{{ Form::label('numero_reporte','N° Reporte:') }}
								{{ Form::text('numero_reporte',Input::old('numero_reporte'),['class' => 'form-control','id'=>'numero_reporte'])}}
							</div>
							<div class="form-group col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" id="btnAgregarReporte">
								<span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="form-group col-md-2" style="margin-top:25px;">
								<div class="btn btn-default btn-block" id="btnLimpiarReporte"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>
							</div>
							<div class="form-group col-md-4"  style="margin-left:15px">
								{{ Form::label('nombre_reporte','Documento') }}
								{{ Form::text('nombre_reporte',Input::old('nombre_reporte'),['class' => 'form-control','id'=>'nombre_reporte','disabled'=>'disabled'])}}
							</div>	
							{{ Form::close()}}									
							<div class="form-group col-md-2">
								{{ Form::open(array('url'=>'solicitudes_compra/download_reporte', 'role'=>'form')) }}
								{{ Form::hidden('numero_reporte_hidden',null)}}
								{{ Form::submit('Descargar',array('id'=>'btn_descarga', 'class'=>'btn btn-primary','style'=>'margin-top:25px;')) }}
								{{ Form::close() }}
							</div>									
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
			  	<div class="panel-heading">Datos del Detalle de Solicitud</div>
			  	<div class="panel-body">
			  		<div class="form-group row">
			  			<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción:') }}
							{{ Form::text('descripcion',Input::old('descripcion'),['class' => 'form-control','id'=>'descripcion'])}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('marca2')) has-error has-feedback @endif">
							{{ Form::label('marca2','Marca:') }}
							{{ Form::text('marca2',Input::old('marca2'),array('class'=>'form-control','id'=>'marca2'))}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('nombre_equipo2')) has-error has-feedback @endif">
							{{ Form::label('nombre_equipo2','Equipo:') }}
							{{ Form::text('nombre_equipo2', Input::old('nombre_equipo2'), array('class'=>'form-control','id'=>'nombre_equipo2')) }}
						</div>
						<div class="form-group col-md-4 @if($errors->first('serie_parte')) has-error has-feedback @endif">
							{{ Form::label('serie_parte','Número de Serie / Parte:') }}
							{{ Form::text('serie_parte', Input::old('numero_serie'), array('class'=>'form-control','id'=>'serie_parte')) }}
						</div>
						<div class="form-group col-md-4 @if($errors->first('cantidad')) has-error has-feedback @endif">
							{{ Form::label('cantidad','Cantidad:') }}
							{{ Form::text('cantidad',Input::old('cantidad'),['class' => 'form-control','id'=>'cantidad'])}}
						</div>
			  		</div>
			  	</div>
				</div>
			</div>
		</div>
		<div class="container-fluid row form-group">
			<div class="col-md-2 col-md-offset-8">
					<div class="btn btn-primary btn-block" id="btnAgregar"><span class="glyphicon glyphicon-plus"></span>Agregar</div>				
			</div>
			<div class="col-md-2">
					<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span>Limpiar</div>				
			</div>
		</div>
		<div class="container-fluid row">
			<div class="col-md-12">
				<div class="table-responsive">
				<table class="table" id="table_solicitud">
					<tr class="info">
						<th>Descripción</th>
						<th>Marca</th>
						<th>Modelo</th>
						<th>Serie/Número de Parte</th>
						<th>Cantidad</th>
					</tr>
				</table>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/solicitudes_compra/list_solicitudes')}}">Cancelar</a>				
			</div>
		</div>	
	{{Form::close()}}		
@stop
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Advertencia</h4>
        </div>
        <div class="modal-body">
          <p>Ingresar todos los campos completos.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>      
    </div>
  </div>  
</div>
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="modalOT" role="dialog">
    <div class="modal-dialog modal-md">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Advertencia</h4>
        </div>
        <div class="modal-body">
          <p>Orden de Trabajo de Mantenimiento no existe. Ingrese una Orden de Trabajo de Mantenimiento válido</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>      
    </div>
  </div>  
</div>