@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Proveedor: <strong>{{$proveedor_info->razon_social}}</strong></h3>
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
		<div class="alert alert-danger alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('proveedor_ruc') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor_razon_social') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor_nombre_contacto') }}</strong></p>			
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
		</div>
	@endif
	
	<div class="panel panel-default">
		<div class="panel-heading">Datos Generales</div>
		<div class="panel-body">
			<div class="form-group row">
				<div class="form-group col-md-4 @if($errors->first('proveedor_ruc')) has-error has-feedback @endif">
				{{ Form::label('proveedor_ruc','RUC') }}
				{{ Form::text('proveedor_ruc',$proveedor_info->ruc,array('class'=>'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('proveedor_razon_social')) has-error has-feedback @endif">					
				{{ Form::label('proveedor_razon_social','Razón Social') }}
				{{ Form::text('proveedor_razon_social',$proveedor_info->razon_social,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="form-group row">
				<div class="form-group col-md-4 @if($errors->first('proveedor_nombre_contacto')) has-error has-feedback @endif">
					{{ Form::label('proveedor_nombre_contacto','Nombre del contácto') }}
					{{ Form::text('proveedor_nombre_contacto',$proveedor_info->nombre_contacto,array('class'=>'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',$proveedor_info->telefono,array('class'=>'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','E-mail') }}
					{{ Form::text('email',$proveedor_info->email,array('class'=>'form-control','readonly'=>'')) }}
				</div>							
			</div>				
		</div>
	</div>

		<div class="container-fluid row">			
			<div class="form-group col-md-offset-10 col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/proveedores/list_proveedores')}}">
				<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
			</div>
		</div>		
	{{ Form::close() }}
@stop