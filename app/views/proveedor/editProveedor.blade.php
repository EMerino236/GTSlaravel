@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Proveedor: <strong>{{$proveedor_info->razon_social}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('ruc') }}</strong></p>
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
			<p><strong>{{ $errors->first('idestado') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'proveedores/submit_edit_proveedor', 'role'=>'form')) }}
		{{ Form::hidden('proveedor_id', $proveedor_info->idproveedor) }}

		<div class="col-xs-6">

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('ruc')) has-error has-feedback @endif">
					{{ Form::label('ruc','RUC') }}
					@if($proveedor_info->deleted_at)
						{{ Form::text('ruc',$proveedor_info->ruc,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('ruc',$proveedor_info->ruc,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('idestado')) has-error has-feedback @endif">
					{{ Form::label('idestado','Área') }}
					@if($proveedor_info->deleted_at)
						{{ Form::select('idestado', $estados,$proveedor_info->idestado,['class' => 'form-control','readonly'=>'']) }}
					@else
						{{ Form::select('idestado', $estados,$proveedor_info->idestado,['class' => 'form-control']) }}
					@endif
				</div>
			</div>
			@if(!$proveedor_info->deleted_at)
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
				{{ HTML::link('/proveedores/list_proveedores','Cancelar',array('class'=>'')) }}
			@endif

		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Teléfono') }}
					@if($proveedor_info->deleted_at)
						{{ Form::text('telefono',$proveedor_info->telefono,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('telefono',$proveedor_info->telefono,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>
			<div class="row">
				<div class="form-group col-xs-8 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','E-mail') }}
					@if($proveedor_info->deleted_at)
						{{ Form::text('email',$proveedor_info->email,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('email',$proveedor_info->email,array('class'=>'form-control')) }}
					@endif
				</div>
			</div>
		</div>
	{{ Form::close() }}
	@if($proveedor_info->deleted_at)
		{{ Form::open(array('url'=>'proveedores/submit_enable_proveedor', 'role'=>'form')) }}
			{{ Form::hidden('proveedor_id', $proveedor_info->idproveedor) }}
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::submit('Habilitar',array('id'=>'submit-delete', 'class'=>'btn btn-success')) }}
						{{ HTML::link('/proveedores/list_proveedores','Cancelar',array('class'=>'')) }}
					</div>
				</div>	
			</div>	
		{{ Form::close() }}
	@else
		{{ Form::open(array('url'=>'proveedores/submit_disable_proveedor', 'role'=>'form')) }}
			{{ Form::hidden('proveedor_id', $proveedor_info->idproveedor) }}
			<div class="col-xs-6">
				<div class="row">
					<div class="form-group col-xs-8">
						{{ Form::submit('Inhabilitar',array('id'=>'submit-delete', 'class'=>'btn btn-danger')) }}	
					</div>
				</div>	
			</div>	
		{{ Form::close() }}
	@endif
@stop