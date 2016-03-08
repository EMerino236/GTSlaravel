@extends('templates/recursosHumanosTemplate')
@section('content')
	
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Planteamiento de Difusión</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

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

    {{ Form::open(array('url'=>'#','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_nombre_capacitacion','Nombre de Capacitación') }}
				{{ Form::text('search_nombre_capacitacion',$search_nombre_capacitacion,array('class'=>'form-control','placeholder'=>'Nombre Capacitación')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_responsable_capacitacion','Responsable') }}
				{{ Form::text('search_responsable_capacitacion',$search_responsable_capacitacion,array('class'=>'form-control','placeholder'=>'Nombre Responsable')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_departamento_capacitacion','Departamento') }}
				{{ Form::select('search_departamento_capacitacion', array('' => 'Seleccione') + $departamentos,$search_departamento_capacitacion,['class' => 'form-control']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_servicio_capacitacion','Servicio') }}				
				{{ Form::select('search_servicio_capacitacion', array('' => 'Seleccione') + $servicios,$search_servicio_capacitacion,['class' => 'form-control']) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('fecha_ini_capacitacion','Fecha de Inicio') }}
				<div id="datetimepicker1" class="form-group input-group date">
					{{ Form::text('fecha_ini_capacitacion',$fecha_ini_capacitacion,array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>				
			</div>
			<div class="col-md-4">
				{{ Form::label('fecha_fin_capacitacion','Fecha de Fin') }}
				<div id="datetimepicker2" class="form-group input-group date">
					{{ Form::text('fecha_fin_capacitacion',$fecha_fin_capacitacion,array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('row_number','Registros por Página') }}
				{{ Form::select('row_number', array('10' => '10 Registros','30' => '30 Registros','60' => '60 Registros','120' => '120 Registros'),$row_number,['class' => 'form-control']) }}								
			</div>
		</div>	

		<div class="row">
			<div class="form-group col-md-2 col-md-offset-8">
				{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => 'width:145px')) }}				
			</div>
			<div class="form-group col-md-2">
				<div class="btn btn-default btn-block" style="width:145px" id="btnlimpiar_list_capacitaciones">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	
	{{ Form::close() }}	
	<div class="container-fluid form-group row">		
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" style="width:145px" href="{{route('planteamiento_difusion.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>


    <div class="row">
    	<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">						
						<th class="text-nowrap text-center">Nombre</th>						
						<th class="text-nowrap text-center">Departamento</th>
						<th class="text-nowrap text-center">Servicio</th>
						<th class="text-nowrap text-center">Responsable</th>
						<th class="text-nowrap text-center">Fecha Inicio</th>
						<th class="text-nowrap text-center">Fecha Fin</th>
						<th class="text-nowrap text-center">Plan de Difusión</th>
					</tr>
					
					<tr class="@if(0) bg-danger @endif">			
						<td class="text-nowrap">
							
						</td>	
						<td class="text-nowrap">
							
						</td>
						<td class="text-nowrap">
							
						</td>						
						<td class="text-nowrap">
							
						</td>
						<td class="text-nowrap">
							
						</td>
						<td class="text-nowrap">
							
						</td>
						<td class="text-nowrap">
							
						</td>						
					</tr>					
				</table>				
			</div>
		</div>
	</div>	
@stop