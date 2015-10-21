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

		<div class="col-md-6">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">

					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre') }}
							@if($tipoTarea_info->deleted_at)
								{{ Form::text('nombre',$tipoTarea_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('nombre',$tipoTarea_info->nombre,array('class'=>'form-control')) }}
							@endif
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-8 @if($errors->first('descripcion')) has-error has-feedback @endif">
							{{ Form::label('descripcion','Descripción') }}
							@if($tipoTarea_info->deleted_at)
								{{ Form::text('descripcion',$tipoTarea_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
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

		<div class="container-fluid row">			
			@if(!$tipoTarea_info->deleted_at)
			<div class="col-md-2 form-group">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}						
			</div>
			@endif
			<div class="col-md-2 form-group">
				<a class="btn btn-default btn-block" href="{{URL::to('/tipoTarea/list_tipoTareas')}}">Cancelar</a>
			</div>	
	{{ Form::close() }}
		@if($tipoTarea_info->deleted_at)
		{{ Form::open(array('url'=>'tipoTarea/submit_enable_tipoTarea', 'role'=>'form')) }}
			{{ Form::hidden('tipoTarea_id', $tipoTarea_info->idtipo_tarea) }}
				<div class="form-group col-md-2 col-md-offset-8">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar', array('id'=>'submit-delete', 'type' => 'submit', 'class' => 'btn btn-success btn-block')) }}
				</div>
		{{ Form::close() }}
		@else
		{{ Form::open(array('url'=>'tipoTarea/submit_disable_tipoTarea', 'role'=>'form')) }}
			{{ Form::hidden('tipoTarea_id', $tipoTarea_info->idtipo_tarea) }}
				<div class="form-group col-md-2 col-md-offset-6">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar', array('id'=>'submit-delete', 'type' => 'submit', 'class' => 'btn btn-danger btn-block')) }}
				</div>
		{{ Form::close() }}
		@endif
		</div>
@stop