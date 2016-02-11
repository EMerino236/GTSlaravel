@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Estudio de linea base - Indicador: {{$indicador->nombre}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
			<p><strong>{{ $errors->first('base') }}</strong></p>
			<p><strong>{{ $errors->first('unidad') }}</strong></p>
			<p><strong>{{ $errors->first('definicion') }}</strong></p>
			<p><strong>{{ $errors->first('medio') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	{{ Form::open(['route'=>['reporte_desarrollo.indicador.update',$indicador->id], 'role'=>'form']) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información del indicador</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
							    <h3 class="panel-title">Indicadores</h3>
						  	</div>

						  	<div class="panel-body">

								<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
									{{ Form::label('nombre','Nombre de indicador') }}
									{{ Form::text('nombre', $indicador->nombre, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('base')) has-error has-feedback @endif">
									{{ Form::label('base','Indicador de Base') }}
									{{ Form::text('base', $indicador->base, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('unidad')) has-error has-feedback @endif">
									{{ Form::label('unidad','Unidad') }}
									{{ Form::text('unidad', $indicador->unidad, ['class'=>'form-control']) }}
								</div>
								
								<div class="form-group col-md-4 @if($errors->first('definicion')) has-error has-feedback @endif">
									{{ Form::label('definicion','Definición del indicador') }}
									{{ Form::text('definicion', $indicador->definicion, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('medio')) has-error has-feedback @endif">
									{{ Form::label('medio','Medio de verificación') }}
									{{ Form::text('medio', $indicador->medio, ['class'=>'form-control']) }}
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		

	{{ Form::close() }}
		
			<div class="form-group col-md-2 col-md-offset-6">
				<a class="btn-under" href="{{route('reporte_desarrollo.indicador.destroy',$indicador->id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Borrar', array('class' => 'btn btn-danger btn-block')) }}
				</a>
			</div>

			<div class="form-group col-md-2">
				<a class="btn-under" href="{{route('reporte_desarrollo.edit',$indicador->reporte_id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
				</a>
			</div>
		</div>
@stop