@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte que certifica la problemática e identificación de financiamiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Información del proyecto</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre', $reporte->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('categoria','Categoría') }}
					{{ Form::text('categoria', $reporte->id_categoria, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento', $reporte->departamento->nombre,['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::text('servicio_clinico', $reporte->servicio->nombre, ['class'=>'form-control', 'readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('responsable','Responsable') }}
					{{ Form::text('responsable',$reporte->responsable->UserFullName,['class'=>'form-control','readonly'])}}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6">
					{{ Form::label('descripcion','Descripción') }}
					{{ Form::textarea('descripcion', $reporte->descripcion, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
				<div class="form-group col-md-6">
					{{ Form::label('objetivos','Objetivos') }}
					{{ Form::textarea('objetivos', $reporte->objetivos, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>

			
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
						    	<h3 class="panel-title">Cronograma</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Descripción</th>
										<th>Fecha Inicio</th>
										<th>Fecha Fin</th>
										<th>Duración</th>
									</tr>
									<tbody class="crono_table">
										@foreach($reporte->cronogramas as $cronograma)
											<tr>
												<td>{{$cronograma->descripcion}}</td>
												<td>{{$cronograma->fecha_ini}}</td>
												<td>{{$cronograma->fecha_fin}}</td>
												<td>{{$cronograma->duracion}}</td>
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
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
					    	<h3 class="panel-title">Diagrama de Gantt</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">

								<div class="row">

									<script type="text/javascript">
									    google.charts.load('current', {'packages':['gantt'], 'language': 'es'});
									    google.charts.setOnLoadCallback(drawChart);

									    function daysToMilliseconds(days) {
									    	return days * 24 * 60 * 60 * 1000;
									    }

									    function drawChart() {

											var data = new google.visualization.DataTable();
											data.addColumn('string', 'Task ID');
											data.addColumn('string', 'Task Name');
											data.addColumn('string', 'Resource');
											data.addColumn('date', 'Start Date');
											data.addColumn('date', 'End Date');
											data.addColumn('number', 'Duration');
											data.addColumn('number', 'Percent Complete');
											data.addColumn('string', 'Dependencies');

											//ID, Titulo, Grupo, Fecha Inicio, Fecha Fin, Duracion en ms, Porcentaje, Dependencia
											var infos = {{$reporte->cronogramas}};
											for(key in infos){
												//console.log(infos[key]);
												data.addRows([
													[
														'T'+infos[key].id, 
														infos[key].descripcion, 
														null, 
														new Date(infos[key].fecha_ini), 
														new Date(infos[key].fecha_fin), 
														null, 
														0, 
														null
													],
												]);
											}
											
											var options = {
												height: 'auto',
												gantt: {
													criticalPathEnabled: false,
													criticalPathStyle: {
													  stroke: '#e64a19',
													  strokeWidth: 5
													},
													/*
													arrow: {
														angle: 100,
														width: 5,
														color: 'green',
														radius: 0
													}
													*/
												}
											};

											var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

											chart.draw(data, options);
									    }
									</script>
								 
								    <div id="chart_div"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-6">
					{{ Form::label('impacto','Impacto') }}
					{{ Form::textarea('impacto', $reporte->impacto, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
				<div class="form-group col-md-6">
					{{ Form::label('costo_beneficio','Costo Beneficio') }}
					{{ Form::textarea('costo_beneficio', $reporte->costo_beneficio, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
					    	<h3 class="panel-title">Inversión</h3>
					  	</div>

					  	<div class="panel-body">
							<div class="col-md-12">
								<table class="table">
									<tr class="info">
										<th>Descripción</th>
										<th>Costo</th>
									</tr>
									<tbody class="inv_table">
										@foreach($reporte->inversiones as $inversion)
											<tr>
												<td>{{$inversion->descripcion}}</td>
												<td>{{round($inversion->costo,2)}}</td>
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
			<a href="{{URL::to('/reporte_financiamiento/edit')}}/{{$reporte->id}}">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('class' => 'btn btn-primary btn-block')) }}
			</a>
		</div>
	</div>	

@stop