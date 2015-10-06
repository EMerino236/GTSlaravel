@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Requerimiento de Compra</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
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
			<div class="form-group col-md-3 col-md-offset-10">
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
			</div>
		</div>	
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">	
					<div class="form-group row">								
						<div class="form-group col-md-4 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('numero_ot','Número de OT:') }}
							{{ Form::text('numero_ot',Input::old('numero_ot'),['class' => 'form-control'])}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio:') }}
							{{ Form::select('servicio',array('0'=> 'Seleccione')+ $servicios,Input::old('servicio'),array('class'=>'form-control'))}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('centro_costo')) has-error has-feedback @endif">
							{{ Form::label('centro_costo','Centro de Costo') }}
							{{ Form::select('centro_costo',array('0'=> 'Seleccione')+ $centro_costos, Input::old('centro_costo'),array('class'=>'form-control'))}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('marca')) has-error has-feedback @endif">
							{{ Form::label('marca','Marca:') }}
							{{ Form::select('marca',array('0'=>'Seleccione')+ $marcas,Input::old('marca'),array('class'=>'form-control','id'=>'marca'))}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
							{{ Form::label('nombre_equipo','Equipo:') }}
							{{ Form::select('nombre_equipo',$nombre_equipos, Input::old('nombre_equipo'), array('class'=>'form-control','id'=>'equipo')) }}
						</div>
						<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
							{{ Form::label('usuario_responsable','Usuario Responsable:') }}
							<select name="usuario_responsable" class="form-control">
								@foreach($usuarios_responsable as $usuario_responsable)
									<option value="{{ $usuario_responsable->id }}">{{ $usuario_responsable->apellido_pat }} {{ $usuario_responsable->apellido_mat }}, {{ $usuario_responsable->nombre }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-4 @if($errors->first('tipo')) has-error has-feedback @endif">
							{{ Form::label('tipo','Tipo de Requerimiento:') }}
							{{ Form::select('tipo',array('0'=>'Seleccione') + $tipos, Input::old('tipo'), array('class'=>'form-control')) }}
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
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos del Detalle de Solicitud</div>
			  	<div class="panel-body">
			  		<div class="form-group row">
			  			<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción:') }}
							{{ Form::text('descripcion',Input::old('descripcion'),['class' => 'form-control'])}}
						</div>
			  		</div>
			  	</div>
			</div>
		</div>
	{{Form::close()}}
@stop