@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Crear Modelo: <strong>{{$familia_activo_info->nombre_equipo}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre_modelo') }}</strong></p>			
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	{{ Form::open(array('url'=>'familia_activos/submit_create_modelo_familia_activo', 'role'=>'form')) }}
	{{ Form::hidden('familia_activo_id', $familia_activo_info->idfamilia_activo) }}
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">
			  		<div class="row">
			  			<div class="form-group col-md-6 @if($errors->first('nombre_modelo')) has-error has-feedback @endif">
							{{ Form::label('nombre_modelo','Modelo') }}
							{{ Form::text('nombre_modelo',Input::old('nombre_modelo'),array('class'=>'form-control','maxlength'=>'100')) }}
						</div>
			  		</div>
				</div>
			</div>			

			<div class="container-fluid row">
				<div class="form-group col-md-2 col-md-offset-8">				
					{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/familia_activos/edit_familia_activo')}}/{{$familia_activo_info->idfamilia_activo}}">Cancelar</a>				
				</div>
			</div>
	{{ Form::close() }}
@stop