@extends('templates/otInspeccionEquiposTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Agregar Inspecciones de Equipos</h3>
        </div>
    </div>

    @if ($errors->has())
	<div class="alert alert-danger" role="alert">
		<p><strong>{{ $errors->first('fecha_programacion') }}</strong></p>
		<p><strong>{{ $errors->first('solicitante') }}</strong></p>
	</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	
	{{Form::hidden('mes_ini',$mes_ini,array('id'=>'mes_ini'))}}
	{{Form::hidden('mes_fin',$mes_fin,array('id'=>'mes_fin'))}}
	{{Form::hidden('trimestre_ini',$trimestre_ini,array('id'=>'trimestre_ini'))}}
	{{Form::hidden('trimestre_fin',$trimestre_fin,array('id'=>'trimestre_fin'))}}
    <div class="row">
    	<div class="col-md-8">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos de la Programación</div>
			  	<div class="panel-body">	
					<div class="row">
						<div class="form-group col-md-6 @if($errors->first('servicio')) has-error has-feedback @endif">
							{{ Form::label('servicio','Servicio:') }}
							{{ Form::select('servicio',array('0' => 'Seleccione') + $servicios,Input::old('servicio'),['class' => 'form-control','id'=>'idservicio'])}}
							{{ Form::hidden('cantidad_activos',null,array('id'=>'cantidad_activos'))}}
						</div>
					</div>							        
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('mes','Programaciones pendientes en el mes') }}
							{{ Form::text('mes',null,array('class' => 'form-control','readonly'=>'','id'=>'mes')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('trimestre','Programaciones pendientes en el trimestre') }}
							{{ Form::text('trimestre',null,array('class' => 'form-control','readonly'=>'','id'=>'trimestre')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('ingeniero','Ingeniero de la inspección:') }}
							<select name="solicitante" class="form-control" id="solicitantes">
								@foreach($ingenieros as $ingeniero)
									<option value="{{ $ingeniero->id }}">{{ $ingeniero->apellido_pat }} {{ $ingeniero->apellido_mat }}, {{ $ingeniero->nombre }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('fecha_programacion','Fecha Programacion')}}<span style="color:red"> *</span>
							<div id="datetimepicker_prog_fecha" class="form-group input-group date @if($errors->first('fecha')) has-error has-feedback @endif">					
								{{ Form::text('fecha_programacion',Input::old('fecha'),array('class'=>'form-control','readonly'=>'','id'=>'fecha')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
			            	</div>
			            </div>
			        </div>
			        <div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('hora_programacion_inicio','Hora Programacion Inicio')}}<span style="color:red"> *</span>
							<div id="datetimepicker_prog_hora_inicio" class="form-group input-group date @if($errors->first('fecha_inicio')) has-error has-feedback @endif">					
								{{ Form::text('hora_programacion_inicio',Input::old('hora_inicio'),array('class'=>'form-control','readonly'=>'','id'=>'hora_inicio')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
			            	</div>
			            </div>
			        </div>
			        <div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('hora_programacion_fin','Hora Programacion Fin')}}<span style="color:red"> *</span>
							<div id="datetimepicker_prog_hora_fin" class="form-group input-group date @if($errors->first('fecha_fin')) has-error has-feedback @endif">					
								{{ Form::text('hora_programacion_fin',Input::old('hora_fin'),array('class'=>'form-control','readonly'=>'','id'=>'hora_fin')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
			            	</div>
			            </div>
			        </div>
			        <div class="row">
						<div class="form-group col-md-4">
							{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar Programacion', array('id'=>'btnAddProgramacion',  'class' => 'btn btn-primary btn-block')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::button('<span class="glyphicon glyphicon-refresh"></span> Limpiar', array('id'=>'btnLimpiar',  'class' => 'btn btn-default btn-block')) }}			
						</div>
					</div>	
			    </div>				    
			</div>
		</div>
		
		<div class="col-md-4">
			<h3 class="text-center">Programaciones del mes</h3>
			<!-- Responsive calendar - START -->
			<div class="responsive-calendar">
			  <div class="controls">			     
			      <a class="pull-left" data-go="prev"><div class="btn"><i class="glyphicon glyphicon-chevron-left"></i></div></a>
			      <h4><span data-head-year></span> <span data-head-month id="nombre_mes"></span></h4>
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

	<div class="form-group row">
		<div class="table-responsive">
			<div class="col-md-12">
				<table class="table" id="table_programacion">
					<tr class="info">
						<th class="text-nowrap text-center">Servicio</th>
						<th class="text-nowrap text-center">Programaciones del mes </th>
						<th class="text-nowrap text-center">Programaciones del trimestre</th>
						<th class="text-nowrap text-center">Fecha Programación</th>
						<th class="text-nowrap text-center">Hora Inicio</th>
						<th class="text-nowrap text-center">Hora Fin</th>
						<th class="text-nowrap text-center">Usuario Responsable</th>
						<th class="text-nowrap text-center">Operacion</th>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="form-group col-md-2 col-md-offset-8">
			{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit_create_ots', 'class' => 'btn btn-primary btn-block')) }}
		</div>
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::to('/inspec_equipos/list_inspec_equipos')}}">Cancelar</a>				
		</div>
	</div>	


<div class="container" >
  <!-- Modal -->
  <div class="modal fade" id="modal_ot"  role="dialog">
    <div class="modal-dialog modal-md">    
      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-header" id="modal_header_ot">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Órdenes de Trabajo de Mantenimiento Programados</h4>
        </div>
        <div class="modal-body" id="modal_text_ot" style="height:150px; overflow: auto;">
         	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="btn_close_modal_confirm" data-dismiss="modal">Aceptar</button>
        </div>
      </div>      
    </div>
  </div>  
</div>
@stop