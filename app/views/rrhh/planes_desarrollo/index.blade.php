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

    {{ Form::open(array('url'=>'#','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}	
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
				<div class="btn btn-default btn-block" style="width:145px" id="btnlimpiar_list_capacitaciones">Limpiar</div>				
			</div>
		</div>
	  </div>
	</div>
	
	{{ Form::close() }}	
	<div class="container-fluid form-group row">		
		<div class="col-md-2 col-md-offset-10">
			<a class="btn btn-primary btn-block" style="width:145px" href="{{route('plan_desarrollo.create')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar</a>
		</div>
	</div>


    <div class="row">
    	<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">						
						<th class="text-nowrap text-center">Nombre de Documento</th>
						<th class="text-nowrap text-center">Autor</th>						
						<th class="text-nowrap text-center">Código de Archivamiento</th>
						<th class="text-nowrap text-center">Fecha de Creación</th>
						<th class="text-nowrap text-center"></th>
						<th class="text-nowrap text-center"></th>						
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
					</tr>					
				</table>				
			</div>
		</div>
	</div>	
@stop