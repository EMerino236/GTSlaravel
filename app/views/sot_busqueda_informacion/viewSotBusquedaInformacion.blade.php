@extends('templates/sotBusquedaInformacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Solicitud de búsqueda de información N°: {{$sot_info->sot_tipo_abreviatura}}{{$sot_info->sot_correlativo}}</h3>
        </div>
    </div>


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
							{{ Form::label('tipo','Tipo') }}
							{{ Form::select('tipo', array('0' => 'Seleccione') + $tipos ,$sot_info->idtipo_busqueda_info ,array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
						</div>
						<div class="form-group col-md-6 @if($errors->first('area')) has-error has-feedback @endif">
							{{ Form::label('area','Departamento') }}
							{{ Form::select('area', array('0' => 'Seleccione') + $areas ,$sot_info->idarea ,array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
						</div>
					</div>	
					<div class="row">						
						<div class="form-group col-md-6">
							{{ Form::label('fecha_solicitud','Fecha Solicitud')}}
							{{ Form::text('fecha_solicitud',date('d-m-Y H:i',strtotime($sot_info->fecha_solicitud)),array('class'=>'form-control','readonly'=>'','id'=>'fecha_view')) }}
			            </div>
			            <div class="form-group col-md-6 @if($errors->first('usuario_encargado')) has-error has-feedback @endif">
							{{ Form::label('usuario_encargado','Usuario Encargado') }}
							<select name="encargado" class="form-control" id="encargados" disabled="disabled">
								@foreach($encargados as $encargado)
									@if($encargado->id == $sot_info->id_usuarioencargado)
										<option value="{{ $encargado->id }}" selected="selected" >{{ $encargado->apellido_pat }} {{ $encargado->apellido_mat }}, {{ $encargado->nombre }}</option>
									@else
										<option value="{{ $encargado->id }}">{{ $encargado->apellido_pat }} {{ $encargado->apellido_mat }}, {{ $encargado->nombre }}</option>
									@endif
								@endforeach
							</select>
						</div>
			        </div>						        
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('descripcion','Descripcion') }}
							{{ Form::textarea('descripcion',$sot_info->descripcion,array('class' => 'form-control','placeholder'=>'Descripción de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;','readonly'=>'')) }}
						</div>
						<div class="form-group col-md-6">
							{{ Form::label('motivo','Motivo') }}
							{{ Form::textarea('motivo',$sot_info->motivo,array('class' => 'form-control','placeholder'=>'Motivo de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;','readonly'=>'')) }}
						</div>
					</div>					
			        <div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('detalle','Detalle')}}
							{{ Form::textarea('detalle',$sot_info->detalle,array('class' => 'form-control','placeholder'=>'Detalle de la solicitud','rows'=>'3','maxlength'=>'500','style'=>'resize:none;','readonly'=>'')) }}
			            </div>
			        </div>
			    </div>				    
			</div>
		</div>
		
	</div>
	<div class="row">		
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::previous()}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
		</div>
	</div>	
	
@stop