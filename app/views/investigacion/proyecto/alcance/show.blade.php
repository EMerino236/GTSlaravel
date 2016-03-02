@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Alcance de proyecto</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Informacion general del proyecto</h3>
		</div>
		<div class="panel-body">

			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre', $alcance->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('categoria','Categoría') }}
					{{ Form::text('categoria', $categorias[$alcance->id_categoria], ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento', $departamentos[$alcance->id_departamento], ['id'=>'departamento','class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::text('servicio_clinico', $servicios[$alcance->id_servicio_clinico], ['id'=>'servicio_clinico','class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('responsable','Responsable') }}
					{{ Form::text('responsable',$usuarios[$alcance->id_responsable],['class'=>'form-control','readonly'])}}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-4 @if($errors->first('fecha_ini')) has-error has-feedback @endif">
					{{ Form::label('fecha_ini','Fecha Inicio') }}
					{{ Form::text('fecha_ini',$alcance->fecha_ini,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('fecha_fin')) has-error has-feedback @endif">
					{{ Form::label('fecha_fin','Fecha Fin') }}
					{{ Form::text('fecha_fin',$alcance->fecha_fin,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
			</div>
						
			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
					    	<h3 class="panel-title">Descripción de alcance</h3>
					  	</div>

					  	<div class="panel-body">
							
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Requerimiento</th>
										<th>Caracteristicas</th>
									</tr>
									<tbody class="desc_table">
										@foreach($alcance->requerimientos as $key => $req)
											<tr>
												<td>{{$req->descripcion}}</td>
												<td>{{$alcance->caracteristicas[$key]->descripcion}}</td>
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
						    	<h3 class="panel-title">Criterios de aceptacion</h3>
					  	</div>

					  	<div class="panel-body">
							
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Criterio</th>
									</tr>
									<tbody class="crit_table">
										@foreach($alcance->criterios as $data)
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
						    	<h3 class="panel-title">Entregables</h3>
					  	</div>

					  	<div class="panel-body">
							
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Entregable</th>
									</tr>
									<tbody class="ent_table">
										@foreach($alcance->entregables as $data)
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
						    	<h3 class="panel-title">Exclusiones</h3>
					  	</div>

					  	<div class="panel-body">
							
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Exclusion</th>
									</tr>
									<tbody class="ex_table">
										@foreach($alcance->exclusiones as $data)
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
										<th></th>
									</tr>
									<tbody class="res_table">
										@foreach($alcance->restricciones as $data)
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
						    	<h3 class="panel-title">Asunciones</h3>
					  	</div>

					  	<div class="panel-body">
							
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Asunción</th>
										<th></th>
									</tr>
									<tbody class="asu_table">
										@foreach($alcance->asunciones as $data)
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

		</div>
	</div>
	{{--
	<div class="row">
		<div class="form-group col-md-2">
			<a href="{{route('proyecto_alcance.edit',$alcance->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('class' => 'btn btn-primary btn-block')) }}
			</a>
		</div>
	</div>
	--}}


@stop