@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Tipo de Tarea: <strong>{{$tipoTarea_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'tipoTarea/submit_edit_tipoTarea', 'role'=>'form')) }}
		{{ Form::hidden('tipoTarea_id', $tipoTarea_info->idtipo_tarea) }}

		<div class="col-xs-6">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">

					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre') }}
							@if($tipoTarea_info->deleted_at)
								{{ Form::text('nombre',$tipoTarea_info->nombre,array('class'=>'form-control')) }}
							@else
								{{ Form::text('nombre',$tipoTarea_info->nombre,array('class'=>'form-control')) }}
							@endif
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							@if($tipoTarea_info->deleted_at)
								{{ Form::text('descripcion',$tipoTarea_info->descripcion,array('class'=>'form-control')) }}
							@else
								{{ Form::text('descripcion',$tipoTarea_info->descripcion,array('class'=>'form-control')) }}
							@endif
						</div>
					</div>								
				</div>
			</div>	
		</div>
		<div class="row">
		</div>
	{{ Form::close() }}
		@if($tipoTarea_info->deleted_at)
			{{ Form::open(array('url'=>'tipoTarea/submit_enable_tipoTarea', 'role'=>'form')) }}
				{{ Form::hidden('tipoTarea_id', $tipoTarea_info->idtipo_tarea) }}
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-3">
							{{ Form::submit('Guardar',array('idtipo_tarea'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
						</div>
						<div class="form-group col-xs-8">
							{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
						</div>
					</div>	
				</div>	
			{{ Form::close() }}
			@else
			{{ Form::open(array('url'=>'tipoTarea/submit_disable_tipoTarea', 'role'=>'form')) }}
				{{ Form::hidden('tipoTarea_id', $tipoTarea_info->idtipo_tarea) }}
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-3">
							{{ Form::submit('Guardar',array('idtipo_tarea'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
						</div>
						<div class="form-group col-xs-8">
							{{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
						</div>
					</div>	
				</div>	
			{{ Form::close() }}
		@endif
@stop