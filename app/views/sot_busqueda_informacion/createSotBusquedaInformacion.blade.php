@extends('templates/sotBusquedaInformacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Agregar solicitud de búsqueda de información</h3>
        </div>
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

    @if ($errors->has())
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<p><strong>{{ $errors->first('tipo') }}</strong></p>
		<p><strong>{{ $errors->first('descripcion') }}</strong></p>
		<p><strong>{{ $errors->first('motivo') }}</strong></p>
		<p><strong>{{ $errors->first('detalle') }}</strong></p>
		<p><strong>{{ $errors->first('area') }}</strong></p>		
		<p><strong>{{ $errors->first('usuario_encargado') }}</strong></p>
		<p><strong>{{ $errors->first('fecha_solicitud') }}</strong></p>
	</div>
	@endif

	
	{{ Form::open(array('url'=>'solicitud_busqueda_informacion/submit_sot', 'role'=>'form')) }}
	<div class="row">
			<div class="form-group col-md-12">
				{{ Form::label('solicitante','Usuario solicitante: '.$user->apellido_pat." ".$user->apellido_mat.", ".$user->nombre." ") }}
			</div>
		</div>
    <div class="row">
    	<div class="col-md-12">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos de la Programación</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-md-6 @if($errors->first('tipo')) has-error has-feedback @endif">
							{{ Form::label('tipo','Tipo') }}<span style="color:red"> *</span>
							{{ Form::select('tipo', array('' => 'Seleccione') + $tipos ,Input::old('tipo') ,array('class'=>'form-control')) }}
						</div>
						<div class="form-group col-md-6 @if($errors->first('area')) has-error has-feedback @endif">
							{{ Form::label('area','Departamento') }}
							{{ Form::select('area', array('' => 'Seleccione') + $areas ,Input::old('area') ,array('class'=>'form-control')) }}
						</div>
					</div>	
					<div class="row">						
						<div class="form-group col-md-6">
							{{ Form::label('fecha_solicitud','Fecha Solicitud')}}<span style="color:red"> *</span>
							<div id="datetimepicker_prog_fecha" class="form-group input-group date @if($errors->first('fecha_solicitud')) has-error has-feedback @endif">					
								{{ Form::text('fecha_solicitud',Input::old('fecha'),array('class'=>'form-control','readonly'=>'','id'=>'fecha')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
			            	</div>
			            </div>
			            <div class="form-group col-md-6 @if($errors->first('usuario_encargado')) has-error has-feedback @endif">
							{{ Form::label('usuario_encargado','Usuario Encargado') }}
							<select name="encargado" class="form-control" id="encargados">
								@foreach($encargados as $encargado)
									<option value="{{ $encargado->id }}">{{ $encargado->apellido_pat }} {{ $encargado->apellido_mat }}, {{ $encargado->nombre }}</option>
								@endforeach
							</select>
						</div>
			        </div>						        
					<div class="row">
						<div class="form-group col-md-6 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripcion') }}<span style="color:red"> *</span>
							{{ Form::textarea('descripcion',null,array('class' => 'form-control','placeholder'=>'Descripción de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;')) }}
						</div>
						<div class="form-group col-md-6 @if($errors->first('motivo')) has-error has-feedback @endif">
							{{ Form::label('motivo','Motivo') }}<span style="color:red"> *</span>
							{{ Form::textarea('motivo',null,array('class' => 'form-control','placeholder'=>'Motivo de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;')) }}
						</div>
					</div>					
			        <div class="row">
						<div class="form-group col-md-6 @if($errors->first('detalle')) has-error has-feedback @endif">
							{{ Form::label('detalle','Detalle')}}<span style="color:red"> *</span>
							{{ Form::textarea('detalle',null,array('class' => 'form-control','placeholder'=>'Detalle de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;')) }}
			            </div>
			        </div>
			    </div>				    
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'btnAddProgramacion',  'class' => 'btn btn-primary btn-block', 'type'=>'submit')) }}
		</div>
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::to('/solicitud_busqueda_informacion/list_busqueda_informacion')}}">Cancelar</a>				
		</div>
	</div>	
{{Form::close()}}
	
@stop