@extends('templates/recursosHumanosTemplate')
@section('content')
	
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Plan de Desarrollo de RRHH</h3>
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

    {{ Form::open(array('route'=>'plan_desarrollo.search','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_codigo_documento','Codigo de Archivamiento') }}
				{{ Form::text('search_codigo_documento',$search_codigo_documento,array('class'=>'form-control','placeholder'=>'Código de Archivamiento')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_nombre_documento','Nombre de Documento') }}
				{{ Form::text('search_nombre_documento',$search_nombre_documento,array('class'=>'form-control','placeholder'=>'Nombre de Documento')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_autor_documento','Autor') }}
				{{ Form::text('search_autor_documento',$search_autor_documento,array('class'=>'form-control','placeholder'=>'Autor')) }}
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
				<div class="btn btn-default btn-block" style="width:145px" id="btnlimpiar" onClick="limpiarCriteriosPlanDesarrollo()">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	
	{{ Form::close() }}
	@if($user->idrol == 1  || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
	<div class="container-fluid form-group row">		
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" style="width:145px" href="{{route('plan_desarrollo.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
	@endif

    <div class="row">
    	<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">						
						<th class="text-nowrap text-center">Código</th>
						<th class="text-nowrap">Nombre de Documento</th>
						<th class="text-nowrap">Autor de Documento</th>						
						<th class="text-nowrap">Fecha de Creación</th>						
						<th></th>
						@if($user->idrol==1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
						<th></th>
						@endif
						@if($user->idrol==1 || $user->idrol == 2)
						<th></th>
						@endif						
					</tr>					
					@if($planes_desarrollo->isEmpty())			
						<tr class="">
						<td><h4 style="color:red">NO HAY REGISTROS EN LA BÚSQUEDA</h4></td>						 
						</tr>					
					@else					
					@foreach($planes_desarrollo as $plan_desarrollo_data)
					<tr class="@if($plan_desarrollo_data->deleted_at) bg-danger @endif">			
						<td class="text-nowrap text-center">							
							<a href="{{route('plan_desarrollo.show',$plan_desarrollo_data->id)}}">{{$plan_desarrollo_data->codigo_archivamiento}}</a>							
						</td>						
						<td class="text-nowrap">
							{{$plan_desarrollo_data->nombre}}
						</td>	
						<td class="text-nowrap">
							{{$plan_desarrollo_data->autor}}
						</td>
						<td class="text-nowrap">
							{{$plan_desarrollo_data->created_at->format('d-m-Y')}}
						</td>
						<td>
							<a class="btn btn-success btn-block btn-sm" style="width:145px; float: right" href="{{route('plan_desarrollo.download',$plan_desarrollo_data->id)}}">
							<span class="glyphicon glyphicon-download"></span> Descargar</a>
						</td>
						@if($user->idrol==1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
						<td>
							<a class="btn btn-warning btn-block btn-sm" style="width:145px; float: right" href="{{route('plan_desarrollo.edit',$plan_desarrollo_data->id)}}">
							<span class="glyphicon glyphicon-pencil"></span> Editar</a>
						</td>
						@endif
						@if($user->idrol==1 || $user->idrol == 2)
						<td>
							<div class="btn btn-danger btn-block btn-sm" style="width:145px; float: right" data-value="{{$plan_desarrollo_data->id}}" data-toggle="modal" data-target="#modalDeletePlanDesarrollo">
								<span class="glyphicon glyphicon-trash"></span> Eliminar</a>
							</div>
						</td>
						@endif
					@endforeach					
					</tr>					
					@endif					
				</table>
				@if($search_codigo_documento || $search_nombre_documento || $search_autor_documento || $row_number)
					{{ $planes_desarrollo->appends(array('search_codigo_documento' => $search_codigo_documento,'search_nombre_documento' => $search_nombre_documento, 'search_autor_documento' => $search_autor_documento,
					   'row_number' => $row_number))->links() }}
				@else	
					{{ $planes_desarrollo->links()}}
				@endif				
			</div>
		</div>
	</div>

	<div id="modalDeletePlanDesarrollo" class="modal fade">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header bg-danger">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">ADVERTENCIA</h4>
	      </div>
	      <div class="modal-body">
	        <p>¿Está seguro que desea eliminar el Plan de Desarrollo de RRHH?</p>
	      </div>
	      <div class="modal-footer">
	        {{ Form::open(array('route'=>'plan_desarrollo.destroy','role'=>'form')) }}
	        {{ Form::hidden('id_plan_desarrollo',"",array('id' => 'id_plan_desarrollo')) }}
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