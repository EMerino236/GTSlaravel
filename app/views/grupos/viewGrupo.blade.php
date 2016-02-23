@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Grupo: <strong>{{$grupo_info->nombre}}</strong></h3>
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
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('nombre_grupo') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_grupo') }}</strong></p>
			<p><strong>{{ $errors->first('usuario_responsable') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::hidden('grupo_id', $grupo_info->idgrupo) }}
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-md-4 @if($errors->first('nombre_grupo')) has-error has-feedback @endif">
							{{ Form::label('nombre_grupo','Nombre del Grupo') }}<span style="color:red">*</span>
							@if($grupo_info->deleted_at)
								{{ Form::text('nombre_grupo',$grupo_info->nombre,array('class'=>'form-control','disabled'=>'')) }}
							@else
								{{ Form::text('nombre_grupo',$grupo_info->nombre,array('class'=>'form-control','disabled'=>'')) }}
							@endif
						</div>
						<div class="form-group col-md-4 @if($errors->first('usuario_responsable')) has-error has-feedback @endif">
							{{ Form::label('usuario_responsable','Usuario Responsable') }}<span style="color:red">*</span>
							@if($grupo_info->deleted_at)
								{{ Form::text('usuario_responsable',$grupo_info->usuario_responsable,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::select('usuario_responsable',$usuario_responsable,$grupo_info->id_responsable,array('class'=>'form-control','readonly'=>'','disabled'=> '')) }}
							@endif						
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12 @if($errors->first('descripcion_grupo')) has-error has-feedback @endif">
							{{ Form::label('descripcion_grupo','Descripción (MAX:200 Caracteres)') }}							
							@if($grupo_info->deleted_at)
								{{ Form::textarea('descripcion_grupo',$grupo_info->descripcion,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none','disabled'=>''])}}								
							@else
								{{ Form::textarea('descripcion_grupo',$grupo_info->descripcion,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none','disabled'=>''])}}								
							@endif							
						</div>						
					</div>
				</div>			
			</div>
		</div>

		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Lista de Equipos</div>
			  	<div class="panel-body">
			  		<div class="row">
			  			<div class="col-md-1"></div>
			  			<div class="col-md-10">
				  			<div class="table-responsive">
					  			<table class="table">
					  				<tr class="info">
					  					<th class="text-nowrap">Nº</th>
					  					<th class="text-nowrap">Código Patrimonial</th>
					  					<th class="text-nowrap">Nombre de Equipo</th>
					  					<th class="text-nowrap">Modelo</th>
					  					<th class="text-nowrap">Marca</th>					  					
					  					<th class="text-nowrap">Número de Serie</th>
					  				</tr>
					  				@foreach($activos_grupo as $index => $activo_grupo)
					  				<tr>
					  					<td class="text-nowrap">{{$index + 1}}</td>
					  					<td class="text-nowrap">{{$activo_grupo->codigo_patrimonial}}</td>
					  					<td class="text-nowrap">{{$activo_grupo->modelo->familiaActivo->nombre_equipo}}</td>
					  					<td class="text-nowrap">{{$activo_grupo->modelo->nombre}}</td>
					  					<td class="text-nowrap">{{$activo_grupo->modelo->familiaActivo->marca->nombre}}</td>
					  					<td class="text-nowrap">{{$activo_grupo->numero_serie}}</td>
					  				</tr>
					  				@endforeach
				  				</table>
				  			</div>
			  			</div>
			  		</div>
			  		{{ $activos_grupo->links()}}
			  	</div>
			</div>
		</div>
		<div class="container-fluid row">			
			<div class="col-md-2 col-md-offset-10 form-group">
				<a class="btn btn-default btn-block" href="{{URL::to('/grupos/list_grupos')}}">
				<span class="glyphicon glyphicon-menu-left"></span>	Regresar</a>
			</div>
		</div>
@stop