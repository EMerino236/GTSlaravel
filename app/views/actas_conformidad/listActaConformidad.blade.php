@extends('templates/actaConformidadTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Actas de Conformidad</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/actas_conformidad/search_acta','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
	    	<h3 class="panel-title">Búsqueda</h3>
	  	</div>	
	  	<div class="panel-body">		
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('fecha_desde','Fecha Desde:')}}
					<div id="search_datetimepicker1" class="input-group date">					
						{{ Form::text('fecha_desde',$fecha_desde,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
	        	</div>
	        	<div class="form-group col-md-4">
					{{ Form::label('fecha_hasta','Fecha Hasta:')}}
					<div id="search_datetimepicker2" class="input-group date">					
						{{ Form::text('fecha_hasta',$fecha_hasta,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
				<div class="col-md-4 form-group">
					{{ Form::label('search_tipo_acta','Tipo Acta:')}}
					{{ Form::select('search_tipo_acta',array('0' => 'Seleccione')+$tipos_acta, $search_tipo_acta,array('class'=>'form-control','id'=>'search_tipo_acta')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('search_proveedor','Proveedor:')}}
					{{ Form::select('search_proveedor',array('0' => 'Seleccione')+$proveedores, $search_proveedor,array('class'=>'form-control','id'=>'search_proveedor')) }}
				</div>				
			</div>
			<div class="row">
				<div class="form-group col-md-2 col-md-offset-8">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
				</div>
				<div class="form-group col-md-2">
					<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
				</div>
			</div>
		</div>
	</div>						
	{{ Form::close() }}
	<div class="container-fluid form-group row">
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" href="{{URL::to('/actas_conformidad/create_acta')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>
 	<div class="row">
 		<div class="col-md-12">
			<table class="table">
				<tr class="info">
					<th>N°</th>
					<th>Fecha Registro</th>
					<th>Cód. Acta Conformidad</th>
					<th>Proveedor</th>
					<th>Editar</th>
				</tr>
				@foreach($actas_data as $index => $acta_data)
					<tr>
						<td>{{$index+1}}</td>					
						<td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $acta_data->fecha_acta)->format('d-m-Y') }}</td>					
						<td>{{$acta_data->codigo_archivamiento}}</td>
						<td>{{$acta_data->nombre_proveedor}}</td>
						<td>
							<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/actas_conformidad/edit_acta/')}}/{{$acta_data->iddocumento}}">
							<span class="glyphicon glyphicon-pencil"></span> Editar</a>
						</td>
					</tr>
				@endforeach				
			</table>
		</div>
	</div>	
@stop