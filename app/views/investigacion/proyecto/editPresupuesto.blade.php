@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Presupuesto:</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('monto') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	{{ Form::open(['route'=>['proyecto.presupuesto.update',$presupuesto->id], 'role'=>'form']) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información del Presupuesto</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
						  	<div class="panel-body">

								<div class="form-group col-md-4 @if($errors->first('descripcion')) has-error has-feedback @endif">
									{{ Form::label('descripcion','Descripción del presupuesto') }}
									{{ Form::text('descripcion', $presupuesto->descripcion, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-4 @if($errors->first('monto')) has-error has-feedback @endif">
									{{ Form::label('monto','Tipo de riesgo') }}
									{{ Form::text('monto', $presupuesto->monto, ['class'=>'form-control']) }}
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
				<a class="btn-under" href="{{route('proyecto.presupuesto.destroy',$presupuesto->id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Borrar', array('class' => 'btn btn-danger btn-block')) }}
				</a>
			</div>

			<div class="form-group col-md-2">
				<a class="btn-under" href="{{route('proyecto.edit',$presupuesto->id_proyecto)}}">
					{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
				</a>
			</div>
		</div>
@stop