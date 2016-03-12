@extends('templates/recursosHumanosTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Presupuesto por Capacitacion: {{$presupuesto->capacitacion->codigo}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach		
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	<div class="panel panel-default">
		
		<div class="panel-body">
			
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('id_capacitacion','Código de Capacitacion') }}
					{{ Form::text('id_capacitacion', $presupuesto->capacitacion->codigo, ['id'=>'id_capacitacion','class'=>'form-control','readonly']) }}
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre', $presupuesto->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('tipo')) has-error has-feedback @endif">
					{{ Form::label('tipo','Tipo') }}
					{{ Form::text('tipo', $presupuesto->tipo->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('modalidad')) has-error has-feedback @endif">
					{{ Form::label('modalidad','Modalidad') }}
					{{ Form::text('modalidad', $presupuesto->modalidad->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento', $presupuesto->departamento->nombre, ['id'=>'departamento','class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::text('servicio_clinico', $presupuesto->servicio->nombre, ['id'=>'servicio_clinico','class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
					{{ Form::label('responsable','Responsable') }}
					{{ Form::text('responsable',$presupuesto->responsable->UserFullName,['class'=>'form-control','readonly'])}}
				</div>

			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Recursos Humanos</h3>
				</div>

			  	<div class="panel-body">

					<div class="col-md-12">
						<table class="table">
							<tr class="info">
								<th>Actividad</th>
								<th>Descripcion</th>
								<th>Unidad</th>
								<th>Cantidad</th>
								<th>Costo por unidad</th>
								<th>Subtotal</th>
								<th></th>
							</tr>
							<tbody class="rh_table">
								@if($presupuesto->actividadesrh)
									@foreach($presupuesto->actividadesrh as $actividad)
										<tr>
											<td>{{$actividad->nombre}}</td>
											<td>{{$actividad->descripcion}}</td>
											<td>{{$actividad->unidad}}</td>
											<td>{{$actividad->cantidad}}</td>
											<td>{{$actividad->costo_unitario}}</td>
											<td>{{$actividad->subtotal}}</td>
										</tr>
									@endforeach
								@endif
							</tbody>
							<th>TOTAL: S/. {{$presupuesto->actividadesrh->sum('subtotal')}}</th>
						</table>
					</div>
				</div>

				<div class="panel-heading">
					<h3 class="panel-title">Equipos y bienes duraderos</h3>
				</div>

			  	<div class="panel-body">
		
					<div class="col-md-12">
						<table class="table">
							<tr class="info">
								<th>Actividad</th>
								<th>Descripcion</th>
								<th>Unidad</th>
								<th>Cantidad</th>
								<th>Costo por unidad</th>
								<th>Subtotal</th>
								<th></th>
							</tr>
							<tbody class="eq_table">
								@if($presupuesto->actividadeseq)
									@foreach($presupuesto->actividadeseq as $actividad)
										<tr>
											<td>{{$actividad->nombre}}</td>
											<td>{{$actividad->descripcion}}</td>
											<td>{{$actividad->unidad}}</td>
											<td>{{$actividad->cantidad}}</td>
											<td>{{$actividad->costo_unitario}}</td>
											<td>{{$actividad->subtotal}}</td>
										</tr>
									@endforeach
								@endif
							</tbody>
							<th>TOTAL: S/. {{$presupuesto->actividadeseq->sum('subtotal')}}</th>
						</table>
					</div>
				</div>

				<div class="panel-heading">
					<h3 class="panel-title">Gastos operativos</h3>
				</div>

			  	<div class="panel-body">

					<div class="col-md-12">
						<table class="table">
							<tr class="info">
								<th>Actividad</th>
								<th>Descripcion</th>
								<th>Unidad</th>
								<th>Cantidad</th>
								<th>Costo por unidad</th>
								<th>Subtotal</th>
								<th></th>
							</tr>
							<tbody class="go_table">
								@if($presupuesto->actividadesgo)
									@foreach($presupuesto->actividadesgo as $actividad)
										<tr>
											<td>{{$actividad->nombre}}</td>
											<td>{{$actividad->descripcion}}</td>
											<td>{{$actividad->unidad}}</td>
											<td>{{$actividad->cantidad}}</td>
											<td>{{$actividad->costo_unitario}}</td>
											<td>{{$actividad->subtotal}}</td>
										</tr>
									@endforeach
								@endif
							</tbody>
							<th>TOTAL: S/. {{$presupuesto->actividadesgo->sum('subtotal')}}</th>
						</table>
					</div>
				</div>

				<div class="panel-heading">
					<h3 class="panel-title">Gastos administrativos y gestión</h3>
				</div>

			  	<div class="panel-body">

					<div class="col-md-12">
						<table class="table">
							<tr class="info">
								<th>Actividad</th>
								<th>Descripcion</th>
								<th>Unidad</th>
								<th>Cantidad</th>
								<th>Costo por unidad</th>
								<th>Subtotal</th>
								<th></th>
							</tr>
							<tbody class="ga_table">
								@if($presupuesto->actividadesga)
									@foreach($presupuesto->actividadesga as $actividad)
										<tr>
											<td>{{$actividad->nombre}}</td>
											<td>{{$actividad->descripcion}}</td>
											<td>{{$actividad->unidad}}</td>
											<td>{{$actividad->cantidad}}</td>
											<td>{{$actividad->costo_unitario}}</td>
											<td>{{$actividad->subtotal}}</td>
										</tr>
									@endforeach
								@endif
							</tbody>
							<th>TOTAL: S/. {{$presupuesto->actividadesga->sum('subtotal')}}</th>
						</table>
					</div>
				</div>
			</div>


		</div>
	</div>

	
	<div class="row">

		<div class="form-group col-md-offset-10 col-md-2">
			<a class="btn btn-default btn-block" href="{{route('presupuesto_capacitacion.index')}}">Regresar</a>				
		</div>
	</div>
@stop