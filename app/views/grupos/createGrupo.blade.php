@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Grupo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

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

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre_grupo') }}</strong></p>
			<p><strong>{{ $errors->first('usuario_responsable') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_grupo') }}</strong></p>
		</div>
	@endif
	
	{{ Form::open(array('url'=>'grupos/submit_grupo', 'role'=>'form')) }}	
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-md-4 @if($errors->first('nombre_grupo')) has-error has-feedback @endif">
							{{ Form::label('nombre_grupo','Nombre del Grupo') }}<span style="color:red">*</span>
							{{ Form::text('nombre_grupo',Input::old('nombre_grupo'),['class' => 'form-control','maxlength'=>'100'])}}
						</div>
						<div class="form-group col-md-4 @if($errors->first('usuario_responsable')) has-error has-feedback @endif">
							{{ Form::label('usuario_responsable','Usuario Responsable') }}<span style="color:red">*</span>
							{{ Form::select('usuario_responsable',array('' => 'Seleccione') + $usuario_responsable, Input::old('usuario_responsable'),array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12 @if($errors->first('descripcion_grupo')) has-error has-feedback @endif">
							{{ Form::label('descripcion_grupo','Descripción (MAX:200 Caracteres)') }}
							{{ Form::textarea('descripcion_grupo',Input::old('descripcion_grupo'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
						</div>						
					</div>
					
				</div>			
			</div>
		</div>
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/grupos/list_grupos')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}
@stop