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
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('cod_pat') }}</strong></p>
			<p><strong>{{ $errors->first('idmotivo_retiro') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('costo') }}</strong></p>
			<p><strong>{{ $errors->first('fecha_baja') }}</strong></p>
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

	{{ Form::open(array('url'=>'retiro_servicio/submit_create_reporte_retiro_servicio', 'role'=>'form')) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Información de Activo</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-4">
					<div class="form-group @if($errors->first('cod_pat')) has-error has-feedback @endif">
						{{ Form::label('cod_pat','Activo') }}
						{{ Form::text('cod_pat',null,array('class' => 'form-control','id'=>'cod_pat')) }}
					</div>
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('nombre_equipo','Nombre de Equipo') }}
					{{ Form::text('nombre_equipo',null,array('class' => 'form-control','id'=>'nombre_equipo','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('servicio_clinico','Servicio clínico') }}
					{{ Form::text('servicio_clinico',null,array('class' => 'form-control','id'=>'servicio_clinico','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('modelo','Modelo') }}
					{{ Form::text('modelo',null,array('class' => 'form-control','id'=>'modelo','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('serie','Serie') }}
					{{ Form::text('serie',null,array('class' => 'form-control','id'=>'serie','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('proveedor','Proveedor') }}
					{{ Form::text('proveedor',null,array('class' => 'form-control','id'=>'proveedor','readonly'=>'')) }}
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
				<div class="form-group col-md-4">
					<div class="form-group @if($errors->first('idmotivo_retiro')) has-error has-feedback @endif">
						{{ Form::label('idmotivo_retiro','Motivo') }}
						{{ Form::select('idmotivo_retiro',$motivos,Input::old('idmotivo_retiro'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="form-group col-md-4">
					<div class="form-group @if($errors->first('costo')) has-error has-feedback @endif">
						{{ Form::label('costo','Costo') }}
						{{ Form::text('costo',Input::old('costo'),array('class' => 'form-control')) }}
					</div>
				</div>
				<div class="form-group col-md-4">
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
					{{ Form::textarea('descripcion',Input::old('descripcion'),array('class'=>'form-control','maxlength'=>'200','rows'=>'3','style'=>'resize:none;')) }}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		@if($user->idrol ==1 || $user->idrol==2 || $user->idrol==3)
		<div class="form-group col-md-2">			
			{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-edit','type'=>'submit', 'class' => 'btn btn-primary btn-block')) }}
		</div>
		@endif
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::to('/retiro_servicio/list_reporte_retiro_servicio')}}">Cancelar</a>				
		</div>	
	</div>
	{{ Form::close() }}

    <script src="{{ asset('js/retiro_servicio/retiro_servicio.js') }}"></script>  
@stop