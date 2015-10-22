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
		  			<div class="form-group col-md-3 @if($errors->first('tipo_documento_identidad')) has-error has-feedback @endif">
						{{ Form::label('tipo_documento_identidad','Tipo de Documento') }}
						{{ Form::text('tipo_documento_identidad',Input::old('tipo_documento_identidad'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-3 @if($errors->first('especialidad_soporte_tecnico_create')) has-error has-feedback @endif">
						{{ Form::label('especialidad_soporte_tecnico_create','Especialidad') }}
						{{ Form::text('especialidad_soporte_tecnico_create',Input::old('especialidad_soporte_tecnico_create'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-3 @if($errors->first('telefono_soporte_tecnico_create')) has-error has-feedback @endif">
						{{ Form::label('telefono_soporte_tecnico_create','Teléfono') }}
						{{ Form::text('telefono_soporte_tecnico_create',Input::old('telefono_soporte_tecnico_create'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-3 @if($errors->first('email_soporte_tecnico_create')) has-error has-feedback @endif">
		  				{{ Form::label('email_soporte_tecnico_create','Email') }}
						{{ Form::email('email_soporte_tecnico_create',Input::old('email_soporte_tecnico_create'),array('class'=>'form-control')) }}
		  			</div>
		  		</div>
			</div>
		</div>			

		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Agregar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/equipos/list_equipos/')}}">Cancelar</a>				
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
@stop