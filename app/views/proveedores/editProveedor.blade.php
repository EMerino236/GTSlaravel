@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Proveedor: <strong>{{$proveedor_info->razon_social}}</strong></h3>
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
			<p><strong>{{ $errors->first('estado') }}</strong></p>
		</div>
	@endif

	{{ Form::open(array('url'=>'proveedores/submit_edit_proveedor', 'role'=>'form')) }}
	{{ Form::hidden('proveedor_id', $proveedor_info->idproveedor) }}
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
						{{ Form::label('proveedor_nombre_contacto','Nombre del contacto') }}
						{{ Form::text('proveedor_nombre_contacto',$proveedor_info->nombre_contacto,array('class'=>'form-control')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('telefono')) has-error has-feedback @endif">
						{{ Form::label('telefono','Teléfono') }}
						{{ Form::text('telefono',$proveedor_info->telefono,array('class'=>'form-control', 'maxlength' => '7')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('email')) has-error has-feedback @endif">
						{{ Form::label('email','E-mail') }}
						{{ Form::text('email',$proveedor_info->email,array('class'=>'form-control')) }}
					</div>							
				</div>
				<div class="form-group row">
					<div class="form-group col-md-4 @if($errors->first('estado')) has-error has-feedback @endif">
						{{ Form::label('estado','Estado') }}
						{{ Form::select('estado', array(''=>'Seleccione') + $estados,$proveedor_info->idestado,['class' => 'form-control']) }}
					</div>
				</div>				
			</div>
		</div>

		<div class="container-fluid row">
			<div class="form-group col-md-offset-8 col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk" ></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}						
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/proveedores/list_proveedores')}}">Cancelar</a>				
			</div>
		</div>
	{{ Form::close() }}

	@if($proveedor_info->deleted_at)
		{{ Form::open(array('url'=>'proveedores/submit_enable_proveedor', 'role'=>'form')) }}
			{{ Form::hidden('proveedor_id', $proveedor_info->idproveedor) }}			
			<div class="form-group col-md-2 hidden">
				{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
				{{ HTML::link('/proveedores/list_proveedores','Cancelar',array('class'=>'')) }}
			</div>
				
		{{ Form::close() }}
	@else
		{{ Form::open(array('url'=>'proveedores/submit_disable_proveedor', 'role'=>'form')) }}
			{{ Form::hidden('proveedor_id', $proveedor_info->idproveedor) }}			
			
			<div class="form-group col-md-2 hidden">
				{{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
			</div>
						
		{{ Form::close() }}
	@endif
@stop