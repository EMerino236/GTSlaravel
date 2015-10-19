@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Grupo: <strong>{{$grupo_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('usuario_responsable') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'grupos/submit_edit_grupo', 'role'=>'form')) }}
	{{ Form::hidden('grupo_id', $grupo_info->idgrupo) }}
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre del Grupo') }}
							@if($grupo_info->deleted_at)
								{{ Form::text('nombre',$grupo_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('nombre',$grupo_info->nombre,array('class'=>'form-control')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							@if($grupo_info->deleted_at)
								{{ Form::text('descripcion',$grupo_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('descripcion',$grupo_info->descripcion,array('class'=>'form-control')) }}
							@endif							
						</div>
						<div class="form-group col-md-4 @if($errors->first('usuario_responsable')) has-error has-feedback @endif">
							{{ Form::label('usuario_responsable','Usuario Responsable') }}
							@if($grupo_info->deleted_at)
								{{ Form::text('usuario_responsable',$grupo_info->usuario_responsable,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::select('usuario_responsable',$usuario_responsable,$grupo_info->id_responsable,array('class'=>'form-control')) }}
							@endif						
						</div>
					</div>
				</div>			
			</div>
		</div>

		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Lista de Equipos</div>
			  	<div class="panel-body">
			  		<div class="row">
			  			<div class="col-md-1"></div>
			  			<div class="col-md-10">
				  			<table class="table">
				  				<tr>
				  					<th>Código Patrimonial</th>
				  					<th>Número de Serie</th>
				  					<th>Nombre de Equipo</th>
				  				</tr>
				  				@foreach($activos_grupo as $index => $activo_grupo)
				  				<tr>
				  					<td>{{$activo_grupo->codigo_patrimonial}}</td>
				  					<td>{{$activo_grupo->numero_serie}}</td>
				  					<td>{{$activo_grupo->nombre_equipo}}</td>

				  				</tr>
				  				@endforeach
			  				</table>
			  			</div>
			  		</div>
			  	</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 form-group">
				@if(!$grupo_info->deleted_at)
						{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
						{{ HTML::link('/grupos/list_grupos','Cancelar',array('class'=>'')) }}
				@endif
			</div>
	{{ Form::close() }}
		@if($grupo_info->deleted_at)
		{{ Form::open(array('url'=>'grupos/submit_enable_grupo', 'role'=>'form')) }}
			{{ Form::hidden('grupo_id', $grupo_info->idgrupo) }}
				<div class="form-group col-md-2 col-md-offset-6">
					{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
				</div>
		{{ Form::close() }}
		@else
		{{ Form::open(array('url'=>'grupos/submit_disable_grupo', 'role'=>'form')) }}
			{{ Form::hidden('grupo_id', $grupo_info->idgrupo) }}
				<div class="form-group col-md-2 col-md-offset-6">
					{{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
				</div>
		{{ Form::close() }}
		@endif
		</div>
@stop