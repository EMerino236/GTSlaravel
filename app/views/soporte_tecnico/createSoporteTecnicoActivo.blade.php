@extends('templates/activosTemplate')
@section('content')
	<div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Agregar Soporte Técnico</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">			
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	{{ Form::open(array('url'=>'', 'role'=>'form')) }}
	{{ Form::hidden('idmodelo_equipo', $equipo_info->idactivo,array('id' => 'idmodelo_equipo')) }}
		<div class="panel panel-default">
		  	<div class="panel-heading">Buscar Soporte Técnico</div>
		  	<div class="panel-body">
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('tipo_documento_identidad')) has-error has-feedback @endif">
						{{ Form::label('tipo_documento_identidad','Tipo de Documento') }}
						{{ Form::select('tipo_documento_identidad', array('' => 'Seleccione') + $tipo_documento_identidad,$search_tipo_documento,['class' => 'form-control']) }}						
					</div>
					<div class="form-group col-md-4 @if($errors->first('numero_documento_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('numero_documento_soporte_tecnico','Número de Documento') }}
						{{ Form::text('numero_documento_soporte_tecnico',Input::old('numero_documento_soporte_tecnico'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-2">
						<button class="btn btn-primary btn-block" type="button" style="margin-top:25px"><span class="glyphicon glyphicon-search"></span> Buscar</button>
					</div>										
		  		</div>
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('nombre_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('nombre_soporte_tecnico','Nombre') }}
						{{ Form::text('nombre_soporte_tecnico',Input::old('nombre_soporte_tecnico'),array('class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('apPaterno_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('apPaterno_soporte_tecnico','Apellido Paterno') }}
						{{ Form::text('apPaterno_soporte_tecnico',Input::old('apPaterno_soporte_tecnico'),array('class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('apMaterno_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('apMaterno_soporte_tecnico','Apellido Materno') }}
						{{ Form::text('apMaterno_soporte_tecnico',Input::old('apMaterno_soporte_tecnico'),array('class'=>'form-control','readonly')) }}
					</div>
		  		</div>
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('especialidad_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('especialidad_soporte_tecnico','Especialidad') }}
						{{ Form::text('especialidad_soporte_tecnico',Input::old('especialidad_soporte_tecnico'),array('class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('telefono_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('telefono_soporte_tecnico','Telefono') }}
						{{ Form::text('telefono_soporte_tecnico',Input::old('telefono_soporte_tecnico'),array('class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('email_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('email_soporte_tecnico','E-mail') }}
						{{ Form::text('email_soporte_tecnico',Input::old('email_soporte_tecnico'),array('class'=>'form-control','readonly')) }}
					</div>
		  		</div>
		  		<div class="row">
		  			<div class="form-group col-md-offset-8 col-md-2">
		  				{{ Form::button('<span class="glyphicon glyphicon-plus" ></span> Agregar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}						
					</div>
		  			<div class="form-group col-md-2">
						<button class="btn btn-default btn-block" type="button" ><span class="glyphicon glyphicon-refresh"></span> Limpiar</button>
					</div>
		  		</div>
			</div>
		</div>			

	{{ Form::close() }}	
	<div class="table-responsive">
		<table class="table">
			<tr class="info">
				<th>Nº</th>
				<th>Nombre</th>
				<th>Apellido Paterno</th>
				<th>Apellido Materno</th>
				<th>Especialidad</th>
				<th>Teléfono</th>				
				<th>E-mail</th>
				<th>Eliminar</th>
			</tr>			
		</table>
	</div>
	<div class="container-fluid row">
		<div class="form-group col-md-offset-10 col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::to('/equipos/list_equipos/')}}">Cancelar</a>				
		</div>
	</div>
@stop