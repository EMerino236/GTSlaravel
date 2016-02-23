@extends('templates/bienesIRETemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Servicio: <strong>{{$servicio_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>			
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

	{{ Form::open(array('url'=>'#', 'role'=>'form')) }}	
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Lista de Equipos</div>
				  	<div class="panel-body">
				  		<div class="row">
				  			<div class="col-md-1"></div>
				  			<div class="col-md-12">
				  				<div class="table-responsive">
						  			<table class="table">
						  				<tr class="info">
						  					<th class="text-nowrap text-center">Nº</th>
						  					<th class="text-nowrap">Código Patrimonial</th>
						  					<th class="text-nowrap">Nombre de Equipo</th>
						  					<th class="text-nowrap">Marca</th>
						  					<th class="text-nowrap">Modelo</th>
						  					<th class="text-nowrap">Número de Serie</th>						  					
						  					<th class="text-nowrap text-center">FE</th>
						  					<th class="text-nowrap text-center">AC</th>
						  					<th class="text-nowrap text-center">RM</th>
						  					<th class="text-nowrap text-center">HIE</th>
						  					<th class="text-nowrap text-center">GE</th>
						  					<th class="text-nowrap text-center">Freq. Mantenimiento</th>
						  					<th class="text-nowrap"></th>
						  				</tr>
						  				@foreach($equipo_info as $index => $equipo)
						  				<tr>
						  					<td class="text-nowrap">{{$index + 1}}</td>
						  					<td class="text-nowrap">{{$equipo->codigo_patrimonial}}</td>
						  					<td class="text-nowrap">{{$equipo->modelo->familiaActivo->nombre_equipo}}</td>
						  					<td class="text-nowrap">{{$equipo->modelo->familiaActivo->marca->nombre}}</td>
						  					<td class="text-nowrap">{{$equipo->modelo->nombre}}</td>
						  					<td class="text-nowrap">{{$equipo->numero_serie}}</td>
						  					<td class="text-nowrap text-center">{{$equipo->fe}}</td>
						  					<td class="text-nowrap text-center">{{$equipo->ac}}</td>
						  					<td class="text-nowrap text-center">{{$equipo->rm}}</td>
						  					<td class="text-nowrap text-center">{{$equipo->hie}}</td>
						  					<td class="text-nowrap text-center">{{$equipo->ge}}</td>
						  					<td class="text-nowrap text-center">
						  						@if($equipo->ge < 12)
						  							N
					  							@elseif($equipo->ge >= 12 && $equipo->ge <= 15)
					  								A
				  								@elseif($equipo->ge > 15 && $equipo->ge <= 18)
				  									S
			  									@else($equipo->ge > 18)
			  										T
		  										@endif
						  					</td>

						  					@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
												<td>
													<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/estado_ts/edit_ire_activo/')}}/{{$equipo->idactivo}}">
													<span class="glyphicon glyphicon-pencil"></span> Editar</a>
												</td>
											@endif
						  				</tr>
						  				@endforeach
					  				</table>
				  				</div>
				  			</div>
				  		</div>
				  		{{ $equipo_info->links()}}
				  	</div>
				</div>
			</div>
		</div>		
		
		<div class="container-fluid row">						
			<div class="form-group col-md-offset-10 col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/estado_ts/list_ire')}}">
				<span class="glyphicon glyphicon-menu-left"></span>Regresar</a>
			</div>	
	{{ Form::close() }}		
		</div>
@stop