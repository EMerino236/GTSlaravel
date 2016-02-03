@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reporte que certifica la problemática e identificación de financiamiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('costo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif
	{{ Form::open(['route'=>['reporte_financiamiento.inversion.update',$inversion->id], 'role'=>'form']) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Información de la inversión</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
							    <h3 class="panel-title">Inversiones</h3>
						  	</div>

						  	<div class="panel-body">

								<div class="form-group col-md-6 @if($errors->first('descripcion')) has-error has-feedback @endif">
									{{ Form::label('descripcion','Descripción') }}
									{{ Form::text('descripcion', $inversion->descripcion, ['class'=>'form-control']) }}
								</div>

								<div class="form-group col-md-6 @if($errors->first('costo')) has-error has-feedback @endif">
									{{ Form::label('costo','Costo') }}
									{{ Form::number('costo', round($inversion->costo,2), ['class'=>'form-control','step'=>'0.01','min'=>'0']) }}
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
		</div>	

	{{ Form::close() }}

@stop