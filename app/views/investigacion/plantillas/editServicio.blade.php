@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Servicio: <strong>{{$servicio_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('departamento') }}</strong></p>
			<p><strong>{{ $errors->first('servicio_clinico') }}</strong></p>
			<p><strong>{{ $errors->first('grupo') }}</strong></p>
			<p><strong>{{ $errors->first('usuario') }}</strong></p>
			<p><strong>{{ $errors->first('tareas') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'plantillas_servicios/create_servicio', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Servicio</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre del equipo') }}
						{{ Form::text('nombre',$servicio_info->nombre,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::text('departamento',$servicio_info->departamento,array('class'=>'form-control')) }}
					</div>
				</div>		
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::text('servicio_clinico',$servicio_info->servicio_clinico,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('grupo')) has-error has-feedback @endif">
						{{ Form::label('grupo','Grupo') }}
						{{ Form::text('grupo',$servicio_info->grupo,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('usuario')) has-error has-feedback @endif">
						{{ Form::label('usuario','Usuario') }}
						{{ Form::text('usuario',$servicio_info->usuario,array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('tareas')) has-error has-feedback @endif">
						{{ Form::label('nombre_tarea','Nombre de Tarea') }}
						{{ Form::text('nombre_tarea',Input::old('nombre_tarea'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::label('','&zwnj;&zwnj;') }}
						<div class="btn btn-primary btn-block" id="btnAgregarFila"><span class="glyphicon glyphicon-plus"></span> Agregar</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
						  	<div class="panel-heading">
						    	<h3 class="panel-title">Tareas</h3>
						  	</div>
				  			<div class="panel-body">
						  		<table class="table">
									<tr class="info">
										<th>Nombre</th>
										<th></th>
									</tr>		
									<?php 
										//Tengo que juntar las anteriores + las que vienen de bd
										$tareas = Input::old('tareas');
										$count = count($tareas);	
									?>	
									<?php for($i=0;$i<$count;$i++){ ?>
									<tr>
										<td>
											<input style="border:0" name='tareas[]' value='{{ $tareas[$i] }}' readonly/>
										</td>
										<td>
											<a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this)'>Eliminar</a>
										</td>						
									</tr>
									<?php } ?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>		
	{{ Form::close() }}

@stop