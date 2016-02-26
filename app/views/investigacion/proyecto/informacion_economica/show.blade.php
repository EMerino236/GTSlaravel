@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Informacion economica</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Informacion general del proyecto</h3>
		</div>
		<div class="panel-body">
			
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('id_reporte','Código de proyecto') }}
					{{ Form::text('codigo', $presupuesto->proyecto->codigo, ['class'=>'form-control','readonly']) }}
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-md-4 ">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre', $presupuesto->nombre, ['class'=>'form-control', 'readonly']) }}
				</div>

				<div class="form-group col-md-4 ">
					{{ Form::label('categoria','Categoría') }}
					{{ Form::text('categoria', $categorias[$presupuesto->id_categoria], ['class'=>'form-control', 'readonly']) }}
				</div>

				<div class="form-group col-md-4 ">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento', $departamentos[$presupuesto->id_departamento], ['id'=>'departamento','class'=>'form-control', 'readonly']) }}
				</div>

				<div class="form-group col-md-4 ">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::text('servicio_clinico', $servicios[$presupuesto->id_servicio_clinico], ['id'=>'servicio_clinico','class'=>'form-control', 'readonly']) }}
				</div>

				<div class="form-group col-md-4 ">
					{{ Form::label('responsable','Responsable') }}
					{{ Form::text('responsable',$usuarios[$presupuesto->id_responsable],['class'=>'form-control', 'readonly'])}}
				</div>

			</div>

			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('fecha_ini','Fecha Inicio') }}
					{{ Form::text('fecha_ini',$presupuesto->fecha_ini,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('fecha_fin','Fecha Fin') }}
					{{ Form::text('fecha_fin',$presupuesto->fecha_fin,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
			</div>

			<div id="tab_menu">
				<ul class="nav nav-pills">
					<li class="active">
					  	<a href="#tab_create_fase" data-toggle="tab">Fase de inversión</a>
					</li>
					<li>
						<a href="#tab_create_fase_post" data-toggle="tab">Fase de post inversión</a>
					</li>
				</ul>

			    <div class="tab-content clearfix">
				    <div class="tab-pane active" id="tab_create_fase">
				    	@if($presupuesto->actividadesrh->isEmpty())
							<div class="panel panel-default">
								<div class="panel-body">
						    		<div class="col-md-3">
							    		<a class="btn-under" href="{{route('informacion_economica.edit',[$presupuesto->id,0])}}">
											{{ Form::button('<span class="glyphicon glyphicon-upload"></span> Crear', ['class' => 'btn btn-success btn-block']) }}
										</a>
									</div>
								</div>
							</div>
				    	@else
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
						@endif
				    </div>

				    <div class="tab-pane" id="tab_create_fase_post">
				    	@if($presupuesto->actividadesrhpost->isEmpty())
							<div class="panel panel-default">
								<div class="panel-body">
						    		<div class="col-md-3">
							    		<a class="btn-under" href="{{route('informacion_economica.edit',[$presupuesto->id,1])}}">
											{{ Form::button('<span class="glyphicon glyphicon-upload"></span> Crear', ['class' => 'btn btn-success btn-block']) }}
										</a>
									</div>
								</div>
							</div>
						@else
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
											<tbody class="rh_table_post">
												@if($presupuesto->actividadesrhpost)
													@foreach($presupuesto->actividadesrhpost as $actividad)
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
											<th>TOTAL: S/. {{$presupuesto->actividadesrhpost->sum('subtotal')}}</th>
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
											<tbody class="eq_table_post">
												@if($presupuesto->actividadeseqpost)
													@foreach($presupuesto->actividadeseqpost as $actividad)
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
											<th>TOTAL: S/. {{$presupuesto->actividadeseqpost->sum('subtotal')}}</th>
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
											<tbody class="go_table_post">
												@if($presupuesto->actividadesgopost)
													@foreach($presupuesto->actividadesgopost as $actividad)
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
											<th>TOTAL: S/. {{$presupuesto->actividadesgopost->sum('subtotal')}}</th>
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
											<tbody class="ga_table_post">
												@if($presupuesto->actividadesgapost)
													@foreach($presupuesto->actividadesgapost as $actividad)
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
											<th>TOTAL: S/. {{$presupuesto->actividadesgapost->sum('subtotal')}}</th>
										</table>
									</div>
								</div>
							</div>
				    	@endif

				    </div>

			    </div>
			</div>				

		</div>
	</div>

@stop