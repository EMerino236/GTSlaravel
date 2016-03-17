@extends('templates/recursosHumanosTemplate')
@section('content')
	
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Acuerdos y convenios de asociación con entidades</h3>
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

    {{ Form::open(array('route'=>'acuerdo_convenio.search','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}	
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Búsqueda</h3>
	  </div>
	  <div class="panel-body">
	    <div class="form-group row">
			<div class="col-md-4">
				{{ Form::label('search_nombre_convenio','Nombre') }}
				{{ Form::text('search_nombre_convenio',$search_nombre_convenio,array('class'=>'form-control','placeholder'=>'Nombre')) }}
			</div>
			<div class="col-md-4">
				{{ Form::label('search_duracion_convenio','Duración de Convenio (En Meses)') }}
				{{ Form::text('search_duracion_convenio',$search_duracion_convenio,array('class'=>'form-control','placeholder'=>'Duración')) }}
			</div>
			<div class="col-md-4">
				
			</div>
		</div>
		<div class="form-group row">			
			<div class="col-md-4">
				{{ Form::label('','Fecha de Firma') }}
				<br>
				{{ Form::label('fecha_ini_firma_convenio','Desde:') }}
				<div id="datetimepicker1" class="form-group input-group date">
					{{ Form::text('fecha_ini_firma_convenio',$fecha_ini_firma_convenio,array('class'=>'form-control','readonly'=>'')) }}
					<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
				</div>				
			</div>
			<div class="col-md-4">
				<br>
				{{ Form::label('fecha_fin_firma_convenio','Hasta:') }}
				<div id="datetimepicker2" class="form-group input-group date">
					{{ Form::text('fecha_fin_firma_convenio',$fecha_fin_firma_convenio,array('class'=>'form-control','readonly'=>'')) }}
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
				<div class="btn btn-default btn-block" style="width:145px" onClick='limpiarCriteriosAcuerdoConvenio()'>Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	
	{{ Form::close() }}	
	<div class="container-fluid form-group row">		
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" style="width:145px" href="{{route('acuerdo_convenio.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>


    <div class="row">
    	<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">						
						<th class="text-nowrap text-center">Nombre</th>
						<th class="text-nowrap text-center">Duración (En Meses)</th>						
						<th class="text-nowrap text-center">Fecha Firma</th>
						<th class="text-nowrap text-center">Fecha de Creación</th>						
						<th class="text-nowrap text-center"></th>
						<th></th>
						@if($user->idrol==1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
						<th></th>
						@endif
						@if($user->idrol==1 || $user->idrol == 2)
						<th></th>
						@endif
					</tr>
					@if($acuerdos_convenios->isEmpty())			
						<tr class="">
						<td><h4 style="color:red">NO HAY REGISTROS EN LA BÚSQUEDA</h4></td>						 
						</tr>					
					@else
					@foreach($acuerdos_convenios as $acuerdo_convenio_data)			
					<tr class="@if(0) bg-danger @endif">			
						<td class="text-nowrap">
							{{$acuerdo_convenio_data->nombre}}
						</td>	
						<td class="text-nowrap text-center">
							{{$acuerdo_convenio_data->duracion}}
						</td>
						<td class="text-nowrap text-center">
							{{ date('d-m-Y',strtotime($acuerdo_convenio_data->fechafirma)) }}
						</td>						
						<td class="text-nowrap  text-center">
							{{$acuerdo_convenio_data->created_at->format('d-m-Y')}}
						</td>
						<td>
							<a class="btn btn-success btn-block btn-sm" style="width:145px; float: right" href="{{route('acuerdo_convenio.download',$acuerdo_convenio_data->id)}}">
							<span class="glyphicon glyphicon-download"></span> Descargar</a>
						</td>
						@if($user->idrol==1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
						<td>
							<a class="btn btn-warning btn-block btn-sm" style="width:145px; float: right" href="{{route('acuerdo_convenio.edit',$acuerdo_convenio_data->id)}}">
							<span class="glyphicon glyphicon-pencil"></span> Editar</a>
						</td>
						@endif
						@if($user->idrol==1 || $user->idrol == 2)
						<td>
							<div class="btn btn-danger btn-block btn-sm" style="width:145px; float: right" data-value="{{$acuerdo_convenio_data->id}}" data-toggle="modal" data-target="#modalDeleteAcuerdoConvenio">
								<span class="glyphicon glyphicon-trash"></span> Eliminar</a>
							</div>
						</td>
						@endif
					@endforeach					
					</tr>	
					@endif				
				</table>
				@if($search_nombre_convenio || $search_duracion_convenio || $fecha_ini_firma_convenio || $fecha_fin_firma_convenio || $row_number)
					{{ $acuerdos_convenios->appends(array('search_nombre_convenio' => $search_nombre_convenio,'search_duracion_convenio' => $search_duracion_convenio, 'fecha_ini_firma_convenio' => $fecha_ini_firma_convenio,
					   'fecha_fin_firma_convenio' => $fecha_fin_firma_convenio,'row_number' => $row_number))->links() }}
				@else	
					{{ $planes_desarrollo->links()}}
				@endif				
			</div>
		</div>
	</div>

	<div id="modalDeleteAcuerdoConvenio" class="modal fade">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header bg-danger">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">ADVERTENCIA</h4>
	      </div>
	      <div class="modal-body">
	        <p>¿Está seguro que desea eliminar el Acuerdo y/o Convenio?</p>
	      </div>
	      <div class="modal-footer">
	        {{ Form::open(array('route'=>'acuerdo_convenio.destroy','role'=>'form')) }}
	        {{ Form::hidden('id_acuerdo_convenio',"",array('id' => 'id_acuerdo_convenio')) }}
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