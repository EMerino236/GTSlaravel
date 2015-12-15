@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Familia de Equipo: <strong>{{$familiaactivo_info->nombre_equipo}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre_equipo') }}</strong></p>
			<p><strong>{{ $errors->first('nombre_siga') }}</strong></p>			
			<p><strong>{{ $errors->first('idtipo_activo') }}</strong></p>
			<p><strong>{{ $errors->first('idmarca') }}</strong></p>
		</div>
	@endif

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

	{{ Form::open(array('url'=>'familia_activos/submit_edit_familia_activo', 'role'=>'form')) }}
		{{ Form::hidden('familia_activo_id', $familiaactivo_info->idfamilia_activo) }}
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">
			  		<div class="row">
			  			<div class="form-group col-md-6 @if($errors->first('idtipo_activo')) has-error has-feedback @endif">
							{{ Form::label('idtipo_activo','Tipo de Activo') }}<span style="color:red">*</span>
							@if($familiaactivo_info->deleted_at)
								{{ Form::select('idtipo_activo',array('' => 'Seleccione') + $tipo_activo,$familiaactivo_info->idtipo_activo,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::select('idtipo_activo',array('' => 'Seleccione') + $tipo_activo,$familiaactivo_info->idtipo_activo,array('class'=>'form-control')) }}
							@endif
						</div>
						<div class="form-group col-md-6 @if($errors->first('idmarca')) has-error has-feedback @endif">
							{{ Form::label('idmarca','Marca') }}<span style="color:red">*</span>
							@if($familiaactivo_info->deleted_at)
								{{ Form::select('idmarca',array('' => 'Seleccione') + $marca,$familiaactivo_info->idmarca,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::select('idmarca',array('' => 'Seleccione') + $marca,$familiaactivo_info->idmarca,array('class'=>'form-control')) }}
							@endif
						</div>
			  		</div>

					<div class="row">
						<div class="form-group col-md-6 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
							{{ Form::label('nombre_equipo','Nombre de Equipo') }}<span style="color:red">*</span>
							@if($familiaactivo_info->deleted_at)
								{{ Form::text('nombre_equipo',$familiaactivo_info->nombre_equipo,['class' => 'form-control','readonly'=>'','maxlength'=>'100']) }}
							@else
								{{ Form::text('nombre_equipo',$familiaactivo_info->nombre_equipo,['class' => 'form-control','maxlength'=>'100']) }}
							@endif
						</div>
						<div class="form-group col-md-6 @if($errors->first('nombre_siga')) has-error has-feedback @endif">
							{{ Form::label('nombre_siga','Nombre SIGA') }}<span style="color:red">*</span>
							@if($familiaactivo_info->deleted_at)
								{{ Form::text('nombre_siga',$familiaactivo_info->nombre_siga,['class' => 'form-control','readonly'=>'','maxlength'=>'100']) }}
							@else
								{{ Form::text('nombre_siga',$familiaactivo_info->nombre_siga,['class' => 'form-control','maxlength'=>'100']) }}
							@endif
						</div>					
					</div>					
				</div>
			</div>

		<div class="container-fluid form-group row">
			<div class="col-md-2 col-md-offset-10">
				<a class="btn btn-primary btn-block" href="{{URL::to('/familia_activos/create_modelo_familia_activo')}}/{{$familiaactivo_info->idfamilia_activo}}">
				<span class="glyphicon glyphicon-plus"></span> Agregar Modelo</a>				
			</div>
		</div>

		<div class="table-responsive">
			<table class="table">
				<tr class="info">
					<th>Nº</th>							
					<th>Modelo</th>
					<th class="text-center">Opciones</th>
					<th>Editar</th>					
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
						<div class="text-center">
						<div>					  
						  	<a class="btn btn-success btn-sm" href="{{URL::to('/familia_activos/create_accesorio_modelo_familia_activo')}}/{{$modelo->idmodelo_equipo}}">
							<span class="glyphicon glyphicon-cog"></span> Agregar Accesorio</a>   
						  
						 
						    <a class="btn btn-success btn-sm" href="{{URL::to('/familia_activos/create_componente_modelo_familia_activo')}}/{{$modelo->idmodelo_equipo}}">
							<span class="glyphicon glyphicon-wrench"></span> Agregar Componente</a>
						  
						  
						    <a class="btn btn-success btn-sm" href="{{URL::to('/familia_activos/create_consumible_modelo_familia_activo')}}/{{$modelo->idmodelo_equipo}}">
							<span class="glyphicon glyphicon-tint"></span> Agregar Consumible</a>					  
						</div>
					</td>
					<td>
						<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/familia_activos/edit_modelo_familia_activo')}}/{{$modelo->idmodelo_equipo}}">
						<span class="glyphicon glyphicon-pencil"></span></a>
					</td>
					</div>								
				</tr>
			@endforeach				
			</table>
		</div>

		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">
			@if(!$familiaactivo_info->deleted_at)				
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			@endif
			</div>
			<div class="form-group col-md-2">				
				<a class="btn btn-default btn-block" href="{{URL::to('/familia_activos/list_familia_activos')}}">Cancelar</a>
			</div>
		</div>

	{{ Form::close() }}	
@stop