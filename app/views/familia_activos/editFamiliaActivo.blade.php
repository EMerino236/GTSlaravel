@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Familia Activo: <strong>{{$familiaactivo_info->nombre_equipo}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_equipo') }}</strong></p>
			<p><strong>{{ $errors->first('modelo') }}</strong></p>
			<p><strong>{{ $errors->first('idtipo_activo') }}</strong></p>
			<p><strong>{{ $errors->first('idmarca') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'familia_activos/submit_edit_familia_activo', 'role'=>'form')) }}
		{{ Form::hidden('familia_activo_id', $familiaactivo_info->idfamilia_activo) }}
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">

					<div class="col-xs-6">

						<div class="row">
							<div class="form-group col-xs-8 @if($errors->first('idtipo_activo')) has-error has-feedback @endif">
								{{ Form::label('idtipo_activo','Tipo de Activo') }}
								@if($familiaactivo_info->deleted_at)
									{{ Form::select('idtipo_activo',$tipo_activo,$familiaactivo_info->idtipo_activo,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::select('idtipo_activo',$tipo_activo,$familiaactivo_info->idtipo_activo,array('class'=>'form-control')) }}
								@endif
							</div>
						</div>

						<div class="row">
							<div class="form-group col-xs-8 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
								{{ Form::label('nombre_equipo','Nombre de Equipo') }}
								@if($familiaactivo_info->deleted_at)
									{{ Form::text('nombre_equipo',$familiaactivo_info->nombre_equipo,['class' => 'form-control','readonly'=>'']) }}
								@else
									{{ Form::text('nombre_equipo',$familiaactivo_info->nombre_equipo,['class' => 'form-control']) }}
								@endif
							</div>
						</div>
					</div>

					<div class="col-xs-6">

						<div class="row">
							<div class="form-group col-xs-8 @if($errors->first('idmarca')) has-error has-feedback @endif">
								{{ Form::label('idmarca','Marca') }}
								@if($familiaactivo_info->deleted_at)
									{{ Form::select('idmarca',$marca,$familiaactivo_info->idmarca,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{ Form::select('idmarca',$marca,$familiaactivo_info->idmarca,array('class'=>'form-control')) }}
								@endif
							</div>
						</div>

						<div class="row">
							<div class="form-group col-xs-8 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
								{{ Form::label('modelo','Modelo') }}
								@if($familiaactivo_info->deleted_at)
									{{ Form::text('modelo',$familiaactivo_info->modelo,['class' => 'form-control','readonly'=>'']) }}
								@else
									{{ Form::text('modelo',$familiaactivo_info->modelo,['class' => 'form-control']) }}
								@endif
							</div>
						</div>

					</div>
				</div>
			</div>
			
			@if(!$familiaactivo_info->deleted_at)
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}
			@endif	
	{{ Form::close() }}	
@stop