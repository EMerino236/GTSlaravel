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

    {{ Form::open(array('route'=>'planteamiento_difusion.search','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_nombre_plan_difusion','Nombre de Plan de Difusión') }}
				{{ Form::text('search_nombre_plan_difusion',$search_nombre_plan_difusion,array('class'=>'form-control','placeholder'=>'Nombre Capacitación')) }}
			</div>
			<div class="col-md-4 hide">
				{{ Form::label('search_responsable_plan_difusion','Responsable') }}
				{{ Form::text('search_responsable_plan_difusion',$search_responsable_plan_difusion,array('class'=>'form-control','placeholder'=>'Nombre Responsable')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_departamento_plan_difusion','Departamento') }}
				{{ Form::select('search_departamento_plan_difusion', array('' => 'Seleccione') + $departamentos,$search_departamento_plan_difusion,['class' => 'form-control', 'onChange'=> 'getServiciosIndexAjax()']) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_servicio_plan_difusion','Servicio') }}				
				{{ Form::select('search_servicio_plan_difusion', array('' => 'Seleccione'),$search_servicio_plan_difusion,['class' => 'form-control']) }}
			</div>
		</div>

		<div class="form-group row">
			<div class="col-md-4 hide">
				{{ Form::label('search_servicio_plan_difusion','Servicio') }}				
				{{ Form::select('search_servicio_plan_difusion', array('' => 'Seleccione'),$search_servicio_plan_difusion,['class' => 'form-control']) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('fecha_ini_plan_difusion','Fecha de Inicio') }}
				<div id="datetimepicker1" class="form-group input-group date">
					{{ Form::text('fecha_ini_plan_difusion',$fecha_ini_plan_difusion,array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>				
			</div>
			<div class="col-md-4">
				{{ Form::label('fecha_fin_plan_difusion','Fecha de Fin') }}
				<div id="datetimepicker2" class="form-group input-group date">
					{{ Form::text('fecha_fin_plan_difusion',$fecha_fin_plan_difusion,array('class'=>'form-control','readonly'=>'')) }}
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
				<div class="btn btn-default btn-block" style="width:145px" onClick="limpiarCriteriosPlanDifusion()">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	
	{{ Form::close() }}
	@if($user->idrol == 1  || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)	
	<div class="container-fluid form-group row">		
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" style="width:145px" href="{{route('planteamiento_difusion.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
	@endif


    <div class="row">
    	<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">						
						<th class="text-nowrap">Nombre</th>						
						<th class="text-nowrap">Departamento</th>
						<th class="text-nowrap">Servicio</th>
						<th class="text-nowrap">Responsable</th>
						<th class="text-nowrap text-center">Fecha Inicio</th>
						<th class="text-nowrap text-center">Fecha Fin</th>
						<th></th>
						@if($user->idrol==1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
						<th></th>
						@endif
						@if($user->idrol==1 || $user->idrol == 2)
						<th></th>
						@endif
					</tr>
					@if($planes_difusion->isEmpty())			
						<tr class="">
						<td><h4 style="color:red">NO HAY REGISTROS EN LA BÚSQUEDA</h4></td>						 
						</tr>					
					@else
					@foreach($planes_difusion as $plan_difusion_data)
					<tr class="@if($plan_difusion_data->deleted_at) bg-danger @endif">			
						<td class="text-nowrap">
							<a href="{{route('planteamiento_difusion.show',$plan_difusion_data->id)}}">{{$plan_difusion_data->nombre}}</a>							
						</td>	
						<td class="text-nowrap">
							{{$plan_difusion_data->departamento->nombre}}
						</td>
						<td class="text-nowrap">
							{{$plan_difusion_data->servicio->nombre}}
						</td>						
						<td class="text-nowrap">
							{{$plan_difusion_data->responsable->apellido_pat}} {{$plan_difusion_data->responsable->apellido_mat}}, {{$plan_difusion_data->responsable->nombre}}
						</td>
						<td class="text-nowrap">							
							{{ date('d-m-Y',strtotime($plan_difusion_data->fechainicio)) }}
						</td>
						<td class="text-nowrap">							
							{{ date('d-m-Y',strtotime($plan_difusion_data->fechafin)) }}
						</td>
						<td>
							<a class="btn btn-success btn-block btn-sm" style="width:145px; float: right" href="{{route('planteamiento_difusion.download',$plan_difusion_data->id)}}">
							<span class="glyphicon glyphicon-download"></span> Descargar</a>							
						</td>
						@if($user->idrol==1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
						<td>
							<a class="btn btn-warning btn-block btn-sm" style="width:145px; float: right" href="{{route('planteamiento_difusion.edit',$plan_difusion_data->id)}}">
							<span class="glyphicon glyphicon-pencil"></span> Editar</a>
						</td>
						@endif
						@if($user->idrol==1 || $user->idrol == 2)
						<td>
							<div class="btn btn-danger btn-block btn-sm" style="width:145px; float: right" data-value="{{$plan_difusion_data->id}}" data-toggle="modal" data-target="#modalDeletePlanDifusion">
								<span class="glyphicon glyphicon-trash"></span> Eliminar</a>
							</div>
						</td>
						@endif
					@endforeach							
					</tr>
					@endif					
				</table>
				@if($search_nombre_plan_difusion || $search_responsable_plan_difusion || $search_departamento_plan_difusion || $search_servicio_plan_difusion || $fecha_ini_plan_difusion || $fecha_fin_plan_difusion || $row_number)
					{{ $planes_difusion->appends(array('search_nombre_plan_difusion' => $search_nombre_plan_difusion,'search_responsable_plan_difusion' => $search_responsable_plan_difusion, 'search_departamento_plan_difusion' => $search_departamento_plan_difusion,
					 'search_servicio_plan_difusion' => $search_servicio_plan_difusion, 'fecha_ini_plan_difusion' => $fecha_ini_plan_difusion, 'fecha_fin_plan_difusion' => $fecha_fin_plan_difusion, 'row_number' => $row_number))->links() }}
				@else	
					{{ $planes_difusion->links()}}
				@endif								
			</div>
		</div>
	</div>

	<div id="modalDeletePlanDifusion" class="modal fade">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header bg-danger">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">ADVERTENCIA</h4>
	      </div>
	      <div class="modal-body">
	        <p>¿Está seguro que desea eliminar el Plan Difusión?</p>
	      </div>
	      <div class="modal-footer">
	        {{ Form::open(array('route'=>'planteamiento_difusion.destroy','role'=>'form')) }}
	        {{ Form::hidden('id_plan_difusion',"",array('id' => 'id_plan_difusion')) }}
	        <div class="row">
	        	<div class="col-md-offset-8 col-md-2">
	        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        	</div>
	        	<div class="col-md-2">
	        		{{ Form::button('Eliminar', array('id'=>'submit-destroy-form','type' => 'submit', 'class' => 'btn btn-danger')) }}
	        	</div>
	        </div>      
	        {{ Form::close() }}
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->	
@stop