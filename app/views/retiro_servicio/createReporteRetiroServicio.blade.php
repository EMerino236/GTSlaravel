@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Agregar Reporte de Retiro de Servicio</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idactivo') }}</strong></p>
			<p><strong>{{ $errors->first('idmotivo_retiro') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('costo') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_baja') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'retiro_servicio/submit_create_reporte_retiro_servicio', 'role'=>'form')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Información de Activo</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-6">
					<div class="form-group @if($errors->first('idactivo')) has-error has-feedback @endif">
						{{ Form::label('idactivo','Activo') }}
						{{ Form::select('idactivo',$activos,Input::old('idactivo'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="form-group">
						{{ Form::label('nombre_equipo','Nombre de Equipo') }}
						{{ Form::text('nombre_equipo',Input::old('nombre_equipo'),array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<div class="form-group">
						{{ Form::label('fabricante','Fabricante') }}
						{{ Form::text('fabricante',Input::old('fabricante'),array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="form-group">
						{{ Form::label('modelo','Modelo') }}
						{{ Form::text('modelo',Input::old('modelo'),array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<div class="form-group">
						{{ Form::label('serie','Serie') }}
						{{ Form::text('serie',Input::old('serie'),array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="form-group">
						{{ Form::label('proveedor','Proveedor') }}
						{{ Form::text('proveedor',Input::old('proveedor'),array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					<div class="form-group">
						{{ Form::label('servicio_clinico','Servicio clínico') }}
						{{ Form::text('servicio_clinico',Input::old('servicio_clinico'),array('class' => 'form-control','readonly'=>'')) }}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Información de Reporte</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-6">
					<div class="form-group @if($errors->first('idmotivo_retiro')) has-error has-feedback @endif">
						{{ Form::label('idmotivo_retiro','Motivo') }}
						{{ Form::select('idmotivo_retiro',$motivos,Input::old('idmotivo_retiro'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="form-group col-md-6">
					<div class="form-group @if($errors->first('costo')) has-error has-feedback @endif">
						{{ Form::label('costo','Costo') }}
						{{ Form::text('costo',Input::old('costo'),array('class' => 'form-control')) }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-6">
					{{ Form::label('fecha_baja','Fecha de baja') }}
					<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha_baja')) has-error has-feedback @endif">
						{{ Form::text('fecha_baja',Input::old('fecha_baja'),array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<div class="form-group @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::textarea('descripcion',Input::old('descripcion'),array('class'=>'form-control','maxlength'=>'200','rows'=>'3')) }}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<div class="form-group">
			{{ Form::submit('Crear',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			{{ HTML::link('/retiro_servicio/list_reporte_retiro_servicio','Cancelar',array('class'=>'')) }}
			</div>
		</div>
	</div>
	{{ Form::close() }}
@stop