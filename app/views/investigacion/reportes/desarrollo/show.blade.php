@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Estudio de linea base: {{$reporte->codigo}}</h3>
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
					{{ Form::text('responsable', $reporte->responsable->UserFullName,['class'=>'form-control','readonly'])}}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('fecha_ini','Fecha Inicio') }}
					{{ Form::text('fecha_ini',$reporte->fecha_ini,['class'=>'form-control', 'readonly'=>'']) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('fecha_fin','Fecha Fin') }}
					{{ Form::text('fecha_fin',$reporte->fecha_fin,['class'=>'form-control', 'readonly'=>'']) }}
				</div>
			</div>
		</div>

		<div class="panel-heading">
			<h3 class="panel-title">Contenido de estudio de linea base</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-12">
					{{ Form::label('descripcion','Descripción de estudio de linea base') }}
					{{ Form::textarea('descripcion', $reporte->descripcion, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-12">
					{{ Form::label('indicadores','Indicadores de efecto e impacto') }}
					{{ Form::textarea('indicadores', $reporte->indicadores, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-12">
					{{ Form::label('objetivos','Objetivos del proyecto') }}
					{{ Form::textarea('objetivos', $reporte->objetivos, ['class'=>'form-control','rows'=>5,'readonly']) }}
				</div>
			</div>
		</div>			

		
		<div class="panel-heading">
			<h3 class="panel-title">Indicadores de linea base relacionados directamente a las actividades del proyecto</h3>
		</div>
		<div class="panel-body">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table">
								<tr class="info">
									<th>Dimensión</th>
									<th>Nombre</th>
									<th>Base</th>
									<th>Unidad</th>
									<th>Definición</th>
									<th>Medio</th>
								</tr>
								<tbody class="ind_table">
									@foreach($reporte->indicador as $indicador)
										<tr>
											<td>{{$indicador->dimension->nombre}}</td>
											<td>{{$indicador->nombre}}</td>
											<td>{{$indicador->base}}</td>
											<td>{{$indicador->unidad}}</td>
											<td>{{$indicador->definicion}}</td>
											<td>{{$indicador->medio}}</td>
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
	
	<div class="row">
		<div class="form-group col-md-2">
			<a href="{{route('reporte_desarrollo.edit',$reporte->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('class' => 'btn btn-primary btn-block')) }}
			</a>
		</div>
	</div>
@stop