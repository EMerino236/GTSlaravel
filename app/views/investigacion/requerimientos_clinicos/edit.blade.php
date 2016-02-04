@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Requerimiento Clínico y Hospitalario</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('estado') }}</strong></p>
			<p><strong>{{ $errors->first('observaciones') }}</strong></p>
			<p><strong>{{ $errors->first('modificador') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>['requerimientos_clinicos.update',$requerimiento->id], 'role'=>'form')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información del proyecto</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('estado','Estado') }}
						{{ Form::select('estado', $estados, $requerimiento->id_estado, ['class'=>'form-control']) }}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('observaciones','Observaciones') }}
						{{ Form::textarea('observaciones',$requerimiento->observaciones,['class'=>'form-control','rows'=>5])}}
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('modificador','Modificado por:') }}
						{{ Form::select('modificador',$usuarios, $requerimiento->id_modificador,['class'=>'form-control'])}}				
					</div>
				</div>

			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
		</div>

	{{Form::close()}}
@stop