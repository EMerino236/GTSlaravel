@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Familia de Equipo: <strong>{{$familiaactivo_info->nombre_equipo}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_equipo') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_siga') }}</strong></p>			
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
			  		<div class="row">
			  			<div class="form-group col-md-6 @if($errors->first('idtipo_activo')) has-error has-feedback @endif">
							{{ Form::label('idtipo_activo','Tipo de Activo') }}
							@if($familiaactivo_info->deleted_at)
								{{ Form::select('idtipo_activo',array('' => 'Seleccione') + $tipo_activo,$familiaactivo_info->idtipo_activo,array('class'=>'form-control','disabled'=>'')) }}
							@else
								{{ Form::select('idtipo_activo',array('' => 'Seleccione') + $tipo_activo,$familiaactivo_info->idtipo_activo,array('class'=>'form-control','disabled'=>'')) }}
							@endif
						</div>
						<div class="form-group col-md-6 @if($errors->first('idmarca')) has-error has-feedback @endif">
							{{ Form::label('idmarca','Marca') }}
							@if($familiaactivo_info->deleted_at)
								{{ Form::select('idmarca',array('' => 'Seleccione') + $marca,$familiaactivo_info->idmarca,array('class'=>'form-control','disabled'=>'')) }}
							@else
								{{ Form::select('idmarca',array('' => 'Seleccione') + $marca,$familiaactivo_info->idmarca,array('class'=>'form-control','disabled'=>'')) }}
							@endif
						</div>
			  		</div>

					<div class="row">
						<div class="form-group col-md-6 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
							{{ Form::label('nombre_equipo','Nombre de Equipo') }}
							@if($familiaactivo_info->deleted_at)
								{{ Form::text('nombre_equipo',$familiaactivo_info->nombre_equipo,['class' => 'form-control','readonly'=>'']) }}
							@else
								{{ Form::text('nombre_equipo',$familiaactivo_info->nombre_equipo,['class' => 'form-control','readonly'=>'']) }}
							@endif
						</div>
						<div class="form-group col-md-6 @if($errors->first('nombre_siga')) has-error has-feedback @endif">
							{{ Form::label('nombre_siga','Nombre SIGA') }}
							@if($familiaactivo_info->deleted_at)
								{{ Form::text('nombre_siga',$familiaactivo_info->nombre_siga,['class' => 'form-control','readonly'=>'']) }}
							@else
								{{ Form::text('nombre_siga',$familiaactivo_info->nombre_siga,['class' => 'form-control','readonly'=>'']) }}
							@endif
						</div>					
					</div>					
				</div>
			</div>

		<div class="table-responsive">
			<table class="table">
				<tr class="info">
					<th>Nº</th>							
					<th>Modelo</th>
					<th>Fecha Creación</th>					
				</tr>
				@foreach($modelo_equipo_info as $index => $modelo)
				<tr class="@if($modelo->deleted_at) bg-danger @endif">			
					<td>
						{{$index + 1}}
					</td>
					<td>
						{{$modelo->nombre}}
					</td>
					<td>
						{{$modelo->created_at->format('d-m-Y')}}
					</td>				
				</tr>
			@endforeach				
			</table>
		</div>

		<div class="container-fluid row">
			<div class="form-group col-md-offset-10 col-md-2">				
				<a class="btn btn-default btn-block" href="{{URL::to('/familia_activos/list_familia_activos')}}">
				<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
			</div>
		</div>

	{{ Form::close() }}	
@stop