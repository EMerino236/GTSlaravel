@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Proyecto: {{$reporte->codigo}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Datos generales del proyecto</h3>
		</div>
		<div class="panel-body">

			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre', $reporte->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('categoria','Categoría') }}
					{{ Form::text('categoria', $reporte->categoria->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento', $reporte->departamento->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::text('servicio_clinico', $reporte->servicio->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('responsable','Responsable de elaboración de linea base') }}
					{{ Form::text('responsable',$reporte->responsable->UserFullName,['class'=>'form-control','readonly'])}}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('fecha_ini','Fecha Inicio') }}
					{{ Form::text('fecha_ini',$reporte->fecha_ini,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('fecha_fin','Fecha Fin') }}
					{{ Form::text('fecha_fin',$reporte->fecha_fin,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-8">
					{{ Form::label('proposito','Propósito - Justificación') }}
					{{ Form::textarea('proposito', $reporte->proposito, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-8">
					{{ Form::label('objetivos','Objetivos del proyecto') }}
					{{ Form::textarea('objetivos', $reporte->objetivos, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-8">
					{{ Form::label('metodologia','Metodología') }}
					{{ Form::textarea('metodologia', $reporte->metodologia, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
					    	<h3 class="panel-title">Principales Requerimientos</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Requerimiento</th>
									</tr>
									<tbody class="req_table">
										@foreach($reporte->requerimientos as $req)
											<tr>
												<td>{{$req->descripcion}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
					    	<h3 class="panel-title">Asunciones</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Asunción</th>
									</tr>
									<tbody class="asu_table">
										@foreach($reporte->asunciones as $data)
											<tr>
												<td>{{$data->descripcion}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>	
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
						    	<h3 class="panel-title">Restricciones</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Restricción</th>
									</tr>
									<tbody class="res_table">
										@foreach($reporte->restricciones as $data)
											<tr>
												<td>{{$data->descripcion}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
					    	<h3 class="panel-title">Riesgos</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Descripción</th>
										<th>Tipo</th>
									</tr>
									<tbody class="ries_table">
										@foreach($reporte->riesgos as $data)
											<tr>
												<td>{{$data->descripcion}}</td>
												<td>{{$data->tipo}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8 form-group">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::textarea('descripcion', $reporte->descripcion, ['class'=>'form-control','rows'=>8,'readonly']) }}
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
						    	<h3 class="panel-title">Resumen del Cronograma</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Descripción</th>
										<th>Fecha Inicio</th>
										<th>Fecha Fin</th>
									</tr>
									<tbody class="crono_table">
										@foreach($reporte->cronogramas as $data)
											<tr>
												<td>{{$data->descripcion}}</td>
												<td>{{$data->fecha_ini}}</td>
												<td>{{$data->fecha_fin}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
						    	<h3 class="panel-title">Resumen de Presupuesto</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Descripción</th>
										<th>Monto</th>
									</tr>
									<tbody class="pre_table">
										@foreach($reporte->presupuestos as $data)
											<tr>
												<td>{{$data->descripcion}}</td>
												<td>{{$data->monto}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
						    	<h3 class="panel-title">Personal involucrado</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Nombre</th>
										<th>Rol</th>
										<th>Area</th>
									</tr>
									<tbody class="pers_table">
										@foreach($reporte->personal as $data)
											<tr>
												<td>{{$data->persona->nombre}} {{$data->persona->apellido_pat}} {{$data->persona->apellido_mat}}</td>
												<td>{{$data->persona->rol->nombre}}</td>
												<td>{{$data->persona->area->nombre}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
						    	<h3 class="panel-title">Entidades o Grupos involucrados</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Entidad</th>
									</tr>
									<tbody class="ent_table">
										@foreach($reporte->entidades as $data)
											<tr>
												<td>{{$data->nombre}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
						    	<h3 class="panel-title">Aprobaciones necesarias</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Nombre</th>
										<th>Rol</th>
										<th>Area</th>
									</tr>
									<tbody class="apro_table">
										@foreach($reporte->aprobaciones as $data)
											<tr>
												<td>{{$data->persona->nombre}} {{$data->persona->apellido_pat}} {{$data->persona->apellido_mat}}</td>
												<td>{{$data->persona->rol->nombre}}</td>
												<td>{{$data->persona->area->nombre}}</td>
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

	</div>
	
	<div class="row">
		<div class="form-group col-md-2">
			<a href="{{route('proyecto.edit',$reporte->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('class' => 'btn btn-primary btn-block')) }}
			</a>
		</div>

		<div class="form-group col-md-2">
			<a class="btn-under" href="{{route('proyecto.export',$reporte->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar','class' => 'btn btn-success btn-block')) }}
			</a>
		</div>
	</div>
@stop