@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte de Retiro de Servicio</h3>
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

	{{ Form::open(array('url'=>'retiro_servicio/submit_disable_reporte_retiro_servicio', 'role'=>'form')) }}
	{{ Form::hidden('idreporte_retiro', $reporte_info->idreporte_retiro) }}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Información de Activo</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('codigo_patrimonial','Código Patrimonial') }}
					{{ Form::text('codigo_patrimonial',$reporte_info->codigo_patrimonial,array('class' => 'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('nombre_equipo','Nombre de Equipo') }}
					{{ Form::text('nombre_equipo',$reporte_info->nombre_equipo,array('class' => 'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('servicio_clinico','Servicio clínico') }}
					{{ Form::text('servicio_clinico',$reporte_info->nombre_servicio,array('class' => 'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('modelo','Modelo') }}
					{{ Form::text('modelo',$reporte_info->nombre_modelo,array('class' => 'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('serie','Serie') }}
					{{ Form::text('serie',$reporte_info->numero_serie,array('class' => 'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('proveedor','Proveedor') }}
					{{ Form::text('proveedor',$reporte_info->nombre_proveedor,array('class' => 'form-control','readonly'=>'')) }}
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
					{{ Form::label('motivo','Motivo') }}
					{{ Form::text('motivo',$reporte_info->nombre_motivo,array('class' => 'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('costo','Costo') }}
					{{ Form::text('costo',$reporte_info->costo,array('class' => 'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('fecha_baja','Fecha de Baja') }}
					{{ Form::text('fecha_baja',date('d-m-Y H:i:s',strtotime($reporte_info->fecha_baja)),array('class' => 'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-12">
					<div class="form-group @if($errors->first('descripcion')) has-error has-feedback @endif">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::textarea('descripcion',$reporte_info->descripcion,array('class'=>'form-control','maxlength'=>'200','rows'=>'3','readonly'=>'')) }}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-6">
			<div class="form-group">
			{{ Form::submit('Eliminar',array('id'=>'submit-edit', 'class'=>'btn btn-danger')) }}
			{{ HTML::link('/retiro_servicio/list_reporte_retiro_servicio','Cancelar',array('class'=>'')) }}
			</div>
		</div>
	</div>
	{{ Form::close() }}
@stop