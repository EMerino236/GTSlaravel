@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Mantenimiento Preventivo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('usuarios') }}</strong></p>
			<p><strong>{{ $errors->first('tareas') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'plantillas_mant_preventivo/create_mantenimiento/'.$familia_activo->idfamilia_activo,'files'=>true, 'role'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Mantenimiento</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre de Familia') }}
						{{ Form::text('nombre',$familia_activo->nombre_equipo,array('id'=>'nombre','class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('marca','Marca') }}
						{{ Form::text('marca', $familia_activo->marca->nombre,array('id'=>'marca','class'=>'form-control','readonly')) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('tipo','Tipo') }}
						{{ Form::text('tipo', $familia_activo->tipo->nombre,array('id'=>'tipo','class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('estado','Estado') }}
						{{ Form::text('estado', $familia_activo->estado->nombre,array('id'=>'estado','class'=>'form-control','readonly')) }}
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Adjuntar Archivo</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="form-group col-md-4">
								{{ Form::label('autor','Autor') }}
								@if($guia)
								{{ Form::text('autor',$guia->autor,array('class'=>'form-control')) }}
								@else
								{{ Form::text('autor',Input::old('autor'),array('class'=>'form-control')) }}
								@endif
							</div>
							<div class="form-group col-md-4">
								{{ Form::label('ubicacion','Ubicación') }}
								@if($guia)
								{{ Form::text('ubicacion',$guia->ubicacion,array('class'=>'form-control')) }}
								@else
								{{ Form::text('ubicacion',Input::old('ubicacion'),array('class'=>'form-control')) }}
								@endif
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-4">
								{{ Form::label('nombre','Nombre de Documento') }}
								@if($guia)
								{{ Form::text('nombre',$guia->nombre,array('class'=>'form-control')) }}
								@else
								{{ Form::text('nombre',Input::old('nombre'),array('class'=>'form-control')) }}
								@endif
							</div>
							<div class="form-group col-md-4">
								{{ Form::label('codigo_archivamiento','Código de Archivamiento') }}
								@if($guia)
								{{ Form::text('codigo_archivamiento',$guia->codigo_archivamiento,array('class'=>'form-control')) }}
								@else
								{{ Form::text('codigo_archivamiento',Input::old('codigo_archivamiento'),array('class'=>'form-control')) }}
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
								<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('tareas')) has-error has-feedback @endif">
						{{ Form::label('nombre_tarea','Nombre de Tarea') }}
						{{ Form::text('nombre_tarea',Input::old('nombre_tarea'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('usuario')) has-error has-feedback @endif">
						{{ Form::label('usuario','Usuario') }}
						{{ Form::select('usuario',$usuarios,Input::old('usuario'),array('id'=>'usuario','class'=>'form-control')) }}
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
						  			<thead>
										<tr class="info">
											<th>Nombre</th>
											<th>Usuario</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									@foreach($tareas as $tarea)
										<tr>
											<td>
												<input style="border:0" value='{{ $tarea->nombre }}' readonly/>
											</td>
											<td>
												@if($tarea->usuario)
												<input style="border:0" value='{{$tarea->usuario->nombre}}' readonly/>
												@else
												<input style="border:0" value='' readonly/>
												@endif
											</td>
											<td>
												<a href='' class='btn btn-default delete-detail' onclick='deleteRow(event,this, {{$tarea->idtareas_ot_preventivo}})'>Eliminar</a>
											</td>						
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		{{ Form::hidden('familia_id',$familia_activo->idfamilia_activo)}}
		{{ Form::hidden('tareas_borradas', null)}}
		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>		
	{{ Form::close() }}
	
	<script>
		$("#input-file").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>
@stop