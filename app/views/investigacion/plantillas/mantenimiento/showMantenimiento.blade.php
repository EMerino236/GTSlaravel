@extends('templates/investigacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Ver Mantenimiento Preventivo</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('usuarios') }}</strong></p>
			<p><strong>{{ $errors->first('tareas') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Datos del Mantenimiento</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre de Familia') }}
					{{ Form::text('nombre',$familia_activo->nombre_equipo,array('id'=>'nombre','class'=>'form-control','readonly')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('marca','Marca') }}
					{{ Form::text('marca', $familia_activo->marca->nombre,array('id'=>'marca','class'=>'form-control','readonly')) }}
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('tipo','Tipo') }}
					{{ Form::text('tipo', $familia_activo->tipo->nombre,array('id'=>'tipo','class'=>'form-control','readonly')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('estado','Estado') }}
					{{ Form::text('estado', $familia_activo->estado->nombre,array('id'=>'estado','class'=>'form-control','readonly')) }}
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
					  	<div class="panel-heading">
					    	<h3 class="panel-title">Tareas</h3>
					  	</div>
			  			<div class="panel-body">
					  		<table class="table">
					  			<thead>
									<tr class="info">
										<th>Nombre</th>
										<th>Usuario</th>
									</tr>
								</thead>
								<tbody>
								@foreach($tareas as $tarea)
									<tr>
										<td>
											<input style="border:0; width:100%" value='{{ $tarea->nombre }}' readonly/>
										</td>
										<td>
											@if($tarea->usuario)
											<input style="border:0; width:100%" value='{{$tarea->usuario->nombre}}' readonly/>
											@else
											<input style="border:0; width:100%" value='' readonly/>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{ Form::hidden('familia_id',$familia_activo->idfamilia_activo)}}
	{{ Form::hidden('tareas_borradas', null)}}
	<div class="row">
		<div class="form-group col-md-2">
			<a href="{{URL::to('/plantillas_mant_preventivo/create_mantenimiento/')}}/{{$familia_activo->idfamilia_activo}}">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</a>
		</div>
	</div>		

@stop