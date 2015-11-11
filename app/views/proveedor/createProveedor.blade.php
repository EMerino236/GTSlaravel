@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Agregar Proveedor</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('proveedor_ruc') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor_razon_social') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor_nombre_contacto') }}</strong></p>			
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	{{ Form::open(array('url'=>'proveedores/submit_create_proveedor', 'role'=>'form')) }}
		<div class="panel panel-default">
		<div class="panel-heading">Datos Generales</div>
			<div class="panel-body">
				<div class="form-group row">
					<div class="form-group col-md-4 @if($errors->first('proveedor_ruc')) has-error has-feedback @endif">
					{{ Form::label('proveedor_ruc','RUC') }}
					{{ Form::text('proveedor_ruc',Input::old('proveedor_ruc'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('proveedor_razon_social')) has-error has-feedback @endif">					
					{{ Form::label('proveedor_razon_social','Razón Social') }}
					{{ Form::text('proveedor_razon_social',Input::old('proveedor_razon_social'),array('class'=>'form-control')) }}
					</div>
				</div>
				<div class="form-group row">
					<div class="form-group col-md-4 @if($errors->first('proveedor_nombre_contacto')) has-error has-feedback @endif">
						{{ Form::label('proveedor_nombre_contacto','Nombre del contácto') }}
						{{ Form::text('proveedor_nombre_contacto',Input::old('proveedor_nombre_contacto'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('telefono')) has-error has-feedback @endif">
						{{ Form::label('telefono','Teléfono') }}
						{{ Form::text('telefono',Input::old('telefono'),array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('email')) has-error has-feedback @endif">
						{{ Form::label('email','E-mail') }}
						{{ Form::text('email',Input::old('email'),array('class'=>'form-control')) }}
					</div>							
				</div>				
			</div>
		</div>

		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/proveedores/list_proveedores')}}">Cancelar</a>				
			</div>
		</div>			
		
	{{ Form::close() }}
@stop