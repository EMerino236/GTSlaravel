@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Marca: <strong>{{$marca_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'marcas/submit_edit_marca', 'role'=>'form')) }}
		{{ Form::hidden('marca_id', $marca_info->idmarca) }}

		<div class="col-xs-6">
			<div class="row">
				<div class="panel panel-default">
			  		<div class="panel-heading">Datos Generales</div>
			  		<div class="panel-body">
						<div class="form-group col-xs-8 @if($errors->first('email')) has-error has-feedback @endif">
							{{ Form::label('nombre','Nombre de Marca') }}
							@if($marca_info->deleted_at)
								{{ Form::text('nombre',$marca_info->nombre,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('nombre',$marca_info->nombre,array('class'=>'form-control')) }}
							@endif
						</div>
					</div>
				</div>
			</div>
			@if(!$marca_info->deleted_at)
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			@endif		
		</div>		
	{{ Form::close() }}
@stop