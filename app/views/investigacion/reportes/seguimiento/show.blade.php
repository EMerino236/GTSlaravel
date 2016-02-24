@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte de seguimiento</h3>
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
						{{ Form::label('id_proyecto','Código de proyecto') }}
						{{ Form::text('id_proyecto', $reporte->proyecto->codigo, ['id'=>'id_reporte','class'=>'form-control','readonly']) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
						{{ Form::label('nombre','Nombre') }}
						{{ Form::text('nombre', $reporte->nombre, ['class'=>'form-control','readonly']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
						{{ Form::label('departamento','Departamento') }}
						{{ Form::text('departamento', $reporte->departamento->nombre, ['id'=>'departamento','class'=>'form-control','readonly']) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
						{{ Form::label('servicio_clinico','Servicio Clínico') }}
						{{ Form::text('servicio_clinico', $reporte->servicio->nombre,  ['id'=>'servicio_clinico','class'=>'form-control','readonly']) }}
					</div>

					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable de elaboración') }}
						{{ Form::text('responsable',$reporte->responsable->UserFullName, ['class'=>'form-control','readonly'])}}
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
							    	<h3 class="panel-title">Archivo Adjunto</h3>
						  	</div>

						  	<div class="panel-body">
								<div class="form-group col-md-6">
									{{ Form::text('archivo', $reporte->nombre_archivo, ['class'=>'form-control','readonly']) }}
								</div>

								<div class="form-group col-md-2">
									<a class="btn-under" href="{{route('reporte_seguimiento.download',$reporte->id)}}">
										{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', ['class' => 'btn btn-success btn-block']) }}
									</a>
								</div>
						  	</div>
						  </div>
					</div>
				</div>

			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				<a class="btn-under" href="{{route('reporte_seguimiento.edit',$reporte->id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', ['class' => 'btn btn-primary btn-block']) }}
				</a>
			</div>


			<div class="form-group col-md-offset-8 col-md-2">
				<a class="btn-under" href="{{route('reporte_seguimiento.index')}}">
					{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
				</a>
			</div>

		</div>

	{{ Form::close() }}

@stop