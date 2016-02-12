@extends('templates/reporteCalibracionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Reporte de Calibración</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('autor') }}</strong></p>
			<p><strong>{{ $errors->first('codigo_archivamiento') }}</strong></p>
			<p><strong>{{ $errors->first('ubicacion') }}</strong></p>
			<p><strong>{{ $errors->first('url') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_documento') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('message') }}</strong>
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>{{ Session::get('error') }}</strong>
		</div>
	@endif

	{{ Form::open(array('url'=>'reportes_calibracion/submit_create_reporte', 'role'=>'form', 'files'=>true)) }}
		{{Form::hidden('cantidad_activos',0,array('id'=>'cantidad_activos'))}}

		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h3 class="panel-title">Criterios de Búsqueda de Activos</h3>
		  </div>
		  <div class="panel-body">
		    <div class="row">				
				<div class="col-md-4 form-group">
					{{ Form::label('codigo_patrimonial','Código Patrimonial:') }}
					{{ Form::text('codigo_patrimonial',Input::old('codigo_patrimonial'),array('class'=>'form-control','placeholder'=>'Código Patrimonial'))  }}
				</div>
				<div class="col-md-4 form-group">
					{{ Form::label('nombre_equipo','Nombre del Equipo:') }}				
					{{ Form::text('nombre_equipo',Input::old('nombre_equipo'),array('class'=>'form-control','placeholder'=>'Nombre del Equipo')) }}
				</div>
				<div class="col-md-4 form-group">
					{{ Form::label('servicio','Servicio Clínico:') }}
					{{ Form::select('servicio',array(''=>'Seleccione')+ $servicios ,Input::old('servicio'),array('class'=>'form-control','placeholder'=>'Servicio Clínico')) }}
				</div>
				<div class="col-md-4 form-group">
					{{ Form::label('area','Departamento:') }}				
					{{ Form::select('area',array(''=>'Seleccione')+ $areas, Input::old('area'),['class' => 'form-control','placeholder'=>'Departamento']) }}				
				</div>
				<div class="col-md-4 form-group">
					{{ Form::label('grupo','Grupo:') }}				
					{{ Form::select('grupo', array(''=>'Seleccione')+ $grupos,Input::old('grupo'),['class' => 'form-control','placeholder'=>'Grupo']) }}				
				</div>				
			</div>
			<div class="row">
				<div class="form-group col-md-2 col-md-offset-8">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'btnBuscar', 'class' => 'btn btn-primary btn-block')) }}				
				</div>
				<div class="form-group col-md-2">
					<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
				</div>
			</div>
		  </div>
		</div>
		<div class="row">
	    	<div class="col-md-12">
				<div class="table-responsive">
					<table class="table" id="table_activos">
						<tr class="info">
							<th class="text-nowrap text-center">Grupo</th>
							<th class="text-nowrap text-center">Servicio Clinico</th>
							<th class="text-nowrap text-center">Nombre de Equipo</th>
							<th class="text-nowrap text-center">Marca</th>
							<th class="text-nowrap text-center">Modelo</th>
							<th class="text-nowrap text-center">Código Patrimonial</th>
							<th class="text-nowrap text-center">Proveedor</th>
							<th class="text-nowrap text-center">Agregar Documento</th>
							<th class="text-nowrap text-center">Eliminar</th>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="form-group col-md-2">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/reportes_calibracion/list_reportes_calibracion')}}">Cancelar</a>				
			</div>
			<div class="form-group col-md-3 col-md-offset-5">
				{{ Form::button('<span class="glyphicon glyphicon-trash"></span> Limpiar Resultados', array('id'=>'btnLimpiarResultados', 'class' => 'btn btn-danger btn-block')) }}				
			</div>
		</div>
		<div id="modals">
		</div>
		<div id="activos_hidden_inputs">
		</div>

	{{ Form::close()}}
	<script>
		$("#input-file").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	
	

	</script>
@stop