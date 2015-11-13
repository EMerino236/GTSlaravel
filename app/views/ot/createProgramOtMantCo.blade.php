@extends('templates/otMantenimientoCorrectivoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Programar mantenimiento correctivo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('fecha_programacion') }}</strong></p>
			<p><strong>{{ $errors->first('numero_ficha') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'mant_correctivo/submit_programacion', 'role'=>'form')) }}
		{{ Form::hidden('idactivo', $sot_info->idactivo) }}
		{{ Form::hidden('sot_id', $sot_info->idsolicitud_orden_trabajo) }}
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
						<div class="form-group col-md-6">
							{{ Form::label('sot','Número de SOT') }}
							{{ Form::text('sot',$sot_info->idsolicitud_orden_trabajo,array('class' => 'form-control','readonly'=>'')) }}
						</div>
						<div class="form-group col-md-6">
							{{ Form::label('codigo_patrimonial','Código patrimonial del activo') }}
							{{ Form::text('codigo_patrimonial',$sot_info->codigo_patrimonial,array('class' => 'form-control','readonly'=>'')) }}
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
						<div class="form-group col-md-6">
							{{ Form::label('fecha_programacion','Ingrese fecha de programación') }}
							<div class="fecha-hora form-group input-group date @if($errors->first('fecha_programacion')) has-error has-feedback @endif">
								{{ Form::text('fecha_programacion',null,array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('mes','Programaciones pendientes en el mes') }}
							{{ Form::text('mes',$mes,array('class' => 'form-control','readonly'=>'')) }}
						</div>
						<div class="form-group col-md-6">
							{{ Form::label('trimestre','Programaciones pendientes en el trimestre') }}
							{{ Form::text('trimestre',$trimestre,array('class' => 'form-control','readonly'=>'')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('numero_ficha','Número de ficha') }}
							{{ Form::text('numero_ficha',Input::old('idprioridad'),array('class' => 'form-control')) }}
						</div>
						<div class="form-group col-md-6">
							{{ Form::label('idprioridad','Prioridad') }}
							{{ Form::select('idprioridad', $prioridades,Input::old('idprioridad'),['class' => 'form-control']) }}			
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{{ Form::label('idtipo_falla','Tipo de falla') }}
							{{ Form::select('idtipo_falla', $tipo_fallas,Input::old('idtipo_falla'),['class' => 'form-control']) }}			
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							{{ Form::submit('Programar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
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
	{{ Form::close() }}

<div class="container" >
  <!-- Modal -->
  <div class="modal fade" id="modal_ot"  role="dialog">
    <div class="modal-dialog modal-md">    
      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-header" id="modal_header_ot">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Órdenes de Trabajo de Mantenimiento Correctivo</h4>
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

<script src="{{ asset('js/sot/program-ot.js') }}"></script>
@stop