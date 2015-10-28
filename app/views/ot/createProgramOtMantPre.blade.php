@extends('templates/otTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Agregar mantenimientos preventivos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
	{{ Form::open(array('url'=>'mant_correctivo/submit_programacion', 'role'=>'form')) }}
    <div class="row">
    	<div class="col-md-8">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos de la Programación</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-md-6 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('cod_pat','Codigo Patrimonial') }}<span style="color:red"> *</span>
							{{ Form::text('cod_pat',Input::old('cod_pat'),['class' => 'form-control','id'=>'cod_pat'])}}
						</div>
						<div class="form-group col-md-6 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre Equipo') }}
							{{ Form::text('nombre',Input::old('equipo'),['class' => 'form-control','id'=>'nombre_equipo'])}}
						</div>
					</div>							        
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('mes','Programaciones pendientes en el mes') }}
							{{ Form::text('mes',$mes,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('trimestre','Programaciones pendientes en el trimestre') }}
							{{ Form::text('trimestre',$trimestre,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('solicitante','Usuario solicitante') }}
							<select name="solicitante" class="form-control">
								@foreach($solicitantes as $solicitante)
									<option value="{{ $solicitante->id }}">{{ $solicitante->apellido_pat }} {{ $solicitante->apellido_mat }}, {{ $solicitante->nombre }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('fecha','Fecha Programacion')}}<span style="color:red"> *</span>
							<div id="datetimepicker_prog_fecha" class="form-group input-group date @if($errors->first('fecha')) has-error has-feedback @endif">					
								{{ Form::text('fecha',Input::old('fecha'),array('class'=>'form-control','readonly'=>'','id'=>'fecha')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
			            	</div>
			            </div>
			        </div>	
			    </div>				    
			</div>
		</div>
		{{ Form::close() }}
		<div class="col-md-4">
			<h3 class="text-center">Programaciones del mes</h3>
			<!-- Responsive calendar - START -->
			<div class="responsive-calendar">
			  <div class="controls">			     
			      <a class="pull-left" data-go="prev"><div class="btn"><i class="glyphicon glyphicon-chevron-left"></i></div></a>
			      <h4><span data-head-year></span> <span data-head-month></span></h4>
			      <a class="pull-right" data-go="next"><div class="btn"><i class="glyphicon glyphicon-chevron-right"></i></div></a>
			  </div><hr/>
			  <div class="day-headers">
			    <div class="day header">Lun</div>
			    <div class="day header">Mar</div>
			    <div class="day header">Mie</div>
			    <div class="day header">Jue</div>
			    <div class="day header">Vie</div>
			    <div class="day header">Sab</div>
			    <div class="day header">Dom</div>
			  </div>
			  <div class="days" data-group="days">
			    <!-- the place where days will be generated -->
			  </div>
			</div>
			<!-- Responsive calendar - END -->
		</div>
	</div>

	<div class="container-fluid row form-group">
		<div class="col-md-4 col-md-offset-8">
				<div class="btn btn-primary btn-block" id="btnAgregarFila"><span class="glyphicon glyphicon-plus"></span>Agregar</div>				
		</div>
	</div>	
	
	<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="modal_create" role="dialog">
    <div class="modal-dialog modal-md">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-danger" id="modal_header_edit">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Advertencia</h4>
        </div>
        <div class="modal-body" id="modal_create_text">
         	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="btn_close_modal" data-dismiss="modal">Aceptar</button>
        </div>
      </div>      
    </div>
  </div>  
</div>
@stop