@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Actividades Sesión N° {{$sesion->numero_sesion}}</h3>
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
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach		
		</div>
	@endif

	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Actividades
	  	</div>
	  	<div class="panel-body">	
	  		<div class="row">
		    	<div class="col-md-12">
					<div class="table-responsive">
						<table class="table">
							<tr class="info">				
								<th class="text-nowrap text-center">Actividad</th>
								<th class="text-nowrap text-center">Duración</th>
								<th class="text-nowrap text-center">Servicio Involucrado</th>
								<th class="text-nowrap text-center">Fecha</th>
								<th class="text-nowrap text-center"></th>
							</tr>

							@foreach($actividades_data as $index => $actividad)
								<tr>
									<td  class="text-nowrap text-center">
										<a href="{{route('capacitacion.editActividad',$actividad->id)}}">{{$actividad->nombre}}</a>
									</td>
									<td  class="text-nowrap text-center">
										{{$actividad->duracion}} hora(s)
									</td>
									<td  class="text-nowrap text-center">
										{{$actividad->nombre_servicio}}
									</td>
									<td  class="text-nowrap text-center">
										{{$actividad->fecha}}
									</td>
									<td  class="text-nowrap text-center">
										<button class="btn btn-danger" onclick="eliminar_actividad(event,{{$actividad->id}})" type="button"><span class="glyphicon glyphicon-trash"></span> Eliminar</button>
									</td>
								</tr>	
							@endforeach
						</table>
					</div>
				</div>
			</div>
	  	</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			<a class="btn btn-primary btn-block"  href="{{URL::to('/capacitacion/create_actividad/')}}/{{$sesion->id}}"><span class="glyphicon glyphicon-plus"></span> Agregar</a>				
		</div>
		<div class="form-group col-md-2 col-md-offset-8">
			<a class="btn btn-default btn-block"  href="{{URL::to('/capacitacion/show_sesiones/')}}/{{$sesion->id_capacitacion}}">Regresar</a>				
		</div>
	</div>
	
	
	<script type="text/javascript">

		$( document ).ready(function(){
			
			habilitaCampos();

		});

	</script>
@stop