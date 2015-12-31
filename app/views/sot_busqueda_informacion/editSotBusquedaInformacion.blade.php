@extends('templates/sotBusquedaInformacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Solicitud de búsqueda de información N°: {{$sot_info->sot_tipo_abreviatura}}{{$sot_info->sot_correlativo}}</h3>
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
	
	{{ Form::open(array('url'=>'solicitud_busqueda_informacion/submit_edit_sot', 'role'=>'form')) }}
	{{ Form::hidden('idsot', $sot_info->idsolicitud_busqueda_info) }}	
	<div class="row">
			<div class="form-group col-md-12">
				{{ Form::label('solicitante','Usuario solicitante: '.$sot_info->apat_solicitante." ".$sot_info->amat_solicitante.", ".$sot_info->nombre_user_solicitante." ") }}
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
							@if($sot_info->deleted_at)
								{{ Form::select('tipo', array('' => 'Seleccione') + $tipos ,$sot_info->idtipo_busqueda_info ,array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
							@else
								{{ Form::select('tipo', array('' => 'Seleccione') + $tipos ,$sot_info->idtipo_busqueda_info ,array('class'=>'form-control')) }}
							@endif
						</div>
						<div class="form-group col-md-6 @if($errors->first('area')) has-error has-feedback @endif">
							{{ Form::label('area','Departamento') }}
							@if($sot_info->deleted_at)
								{{ Form::select('area', array('' => 'Seleccione') + $areas ,$sot_info->idarea ,array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
							@else
								{{ Form::select('area', array('' => 'Seleccione') + $areas ,$sot_info->idarea ,array('class'=>'form-control')) }}
							@endif
						</div>
					</div>	
					<div class="row">						
						<div class="form-group col-md-6">
							{{ Form::label('fecha_solicitud','Fecha Solicitud')}}<span style="color:red"> *</span>
							<div id="datetimepicker_prog_fecha" class="form-group input-group date @if($errors->first('fecha_solicitud')) has-error has-feedback @endif">					
								{{ Form::text('fecha_solicitud',date('d-m-Y H:i',strtotime($sot_info->fecha_solicitud)),array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
			            	</div>
			            </div>
			            <div class="form-group col-md-6 @if($errors->first('usuario_encargado')) has-error has-feedback @endif">
							{{ Form::label('usuario_encargado','Usuario Encargado') }}
							<select name="encargado" class="form-control" id="encargados">
								@foreach($encargados as $encargado)
									@if($encargado->id == $sot_info->id_usuarioencargado)
										<option value="{{ $encargado->id }}" selected="selected">{{ $encargado->apellido_pat }} {{ $encargado->apellido_mat }}, {{ $encargado->nombre }}</option>
									@else
										<option value="{{ $encargado->id }}">{{ $encargado->apellido_pat }} {{ $encargado->apellido_mat }}, {{ $encargado->nombre }}</option>
									@endif
								@endforeach
							</select>
						</div>
			        </div>						        
					<div class="row">
						<div class="form-group col-md-6 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripcion') }}<span style="color:red"> *</span>
							@if($sot_info->deleted_at)
								{{ Form::textarea('descripcion',$sot_info->descripcion,array('class' => 'form-control','readonly'=>'','placeholder'=>'Descripción de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;')) }}
							@else
								{{ Form::textarea('descripcion',$sot_info->descripcion,array('class' => 'form-control','placeholder'=>'Descripción de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;')) }}
							@endif
						</div>
						<div class="form-group col-md-6 @if($errors->first('motivo')) has-error has-feedback @endif">
							{{ Form::label('motivo','Motivo') }}<span style="color:red"> *</span>
							@if($sot_info->deleted_at)
								{{ Form::textarea('motivo',$sot_info->motivo,array('class' => 'form-control','placeholder'=>'Motivo de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;','readonly'=>'')) }}
							@else
								{{ Form::textarea('motivo',$sot_info->motivo,array('class' => 'form-control','placeholder'=>'Motivo de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;')) }}
							@endif
						</div>
					</div>					
			        <div class="row">
						<div class="form-group col-md-6 @if($errors->first('detalle')) has-error has-feedback @endif">
							{{ Form::label('detalle','Detalle')}}<span style="color:red"> *</span>
							@if($sot_info->deleted_at)
								{{ Form::textarea('detalle',$sot_info->detalle,array('class' => 'form-control','placeholder'=>'Detalle de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;','readonly'=>'')) }}
			            	@else
			            		{{ Form::textarea('detalle',$sot_info->detalle,array('class' => 'form-control','placeholder'=>'Detalle de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;')) }}
			            	@endif
			            </div>
			        </div>
			    </div>				    
			</div>
		</div>
		
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
		</div>
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::to('/solicitud_busqueda_informacion/list_busqueda_informacion')}}">Cancelar</a>				
		</div>	
	{{Form::close()}}
	@if($sot_info->idestado == 14)
		{{ Form::open(array('url'=>'solicitud_busqueda_informacion/submit_disable_sot', 'role'=>'form','id'=>'submitState')) }}
			{{ Form::hidden('idsot', $sot_info->idsolicitud_busqueda_info) }}
			<div class="form-group col-md-offset-4 col-md-3">
				{{ Form::button('<span class="glyphicon glyphicon-remove"></span> Marcar como Mar Ingreso', array('id'=>'submit-delete', 'class'=>'btn  btn-block btn-danger')) }}	
				
			</div>
		{{ Form::close() }}
	@endif
	</div>	
@stop