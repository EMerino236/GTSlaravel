@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Centro de Costo: <strong>{{$centro_costo_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('presupuesto') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'centro_costos/submit_edit_centro_costo', 'role'=>'form')) }}
	{{ Form::hidden('centro_id', $centro_costo_info->idcentro_costo) }}
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Datos Generales</div>
				  	<div class="panel-body">	
						<div class="row">								
							<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
								{{ Form::label('nombre','Nombre del Centro Costo') }}
								@if($centro_costo_info->deleted_at)
									{{ Form::text('nombre',$centro_costo_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::text('nombre',$centro_costo_info->nombre,array('class'=>'form-control')) }}
								@endif
							</div>
							<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
								{{ Form::label('descripcion','Descripción') }}
								@if($centro_costo_info->deleted_at)
									{{ Form::text('descripcion',$centro_costo_info->descripcion,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::text('descripcion',$centro_costo_info->descripcion,array('class'=>'form-control')) }}
								@endif							
							</div>
						
							<div class="form-group col-md-4 @if($errors->first('presupuesto')) has-error has-feedback @endif">
								{{ Form::label('presupuesto','Presupuesto') }}
								@if($centro_costo_info->deleted_at)
									{{ Form::text('presupuesto',$centro_costo_info->presupuesto,array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
								@else
									{{ Form::text('presupuesto',$centro_costo_info->presupuesto,array('class'=>'form-control')) }}
								@endif
							</div>				
						</div>
					</div>
				</div>			
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 form-group">
				@if(!$centro_costo_info->deleted_at)
						{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
						{{ HTML::link('/centro_costos/list_centros_costos','Cancelar',array('class'=>'')) }}
				@endif
			</div>
		
	{{ Form::close() }}
		@if($centro_costo_info->deleted_at)
		{{ Form::open(array('url'=>'centro_costos/submit_enable_centro_costo', 'role'=>'form')) }}
			{{ Form::hidden('centro_id', $centro_costo_info->idcentro_costo) }}
				<div class="form-group col-md-2 col-md-offset-6">
					{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
				</div>
		{{ Form::close() }}
		@else
		{{ Form::open(array('url'=>'centro_costos/submit_disable_centro_costo', 'role'=>'form')) }}
			{{ Form::hidden('centro_id', $centro_costo_info->idcentro_costo) }}
				<div class="form-group col-md-2 col-md-offset-6">
					{{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
				</div>
		{{ Form::close() }}
		@endif
@stop