@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Nuevo Reporte de Incumplimiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('numero_ot') }}</strong></p>
			<p><strong>{{ $errors->first('tipo_reporte') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc1') }}</strong></p>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion_corta') }}</strong></p>
			<p><strong>{{ $errors->first('descripcion') }}</strong></p>
			<p><strong>{{ $errors->first('servicio') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor') }}</strong></p>
			<p><strong>{{ $errors->first('costo') }}</strong></p>
			<p><strong>{{ $errors->first('accion_generada') }}</strong></p>
			<p><strong>{{ $errors->first('reincidente') }}</strong></p>
			<p><strong>{{ $errors->first('resultados') }}</strong></p>
			<p><strong>{{ $errors->first('acciones') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc2') }}</strong></p>
			<p><strong>{{ $errors->first('numero_doc3') }}</strong></p>

		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'reportes_incumplimiento/submit_reporte', 'role'=>'form')) }}
		<div class="row">
			<div class="form-group col-xs-3 col-xs-offset-10">
				{{ Form::submit('Guardar',array('id'=>'submit-edit', 'class'=>'btn btn-primary')) }}	
			</div>
		</div>	
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-xs-2 col-xs-offset-1 @if($errors->first('numero_ot')) has-error has-feedback @endif">
							{{ Form::label('numero_ot','Número de OT') }}
							@if($reporte_data->deleted_at)
								{{ Form::text('numero_ot',$reporte_data->idordenes_trabajo,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::text('numero_ot',$reporte_data->idordenes_trabajo,array('class'=>'form-control')) }}
							@endif
							
						</div>
						<div class="form-group col-xs-2 @if($errors->first('tipo_reporte')) has-error has-feedback @endif">
							{{ Form::label('tipo_reporte','Tipo') }}
							@if($reporte_data->deleted_at)
								{{ Form::select('tipo_reporte',['0'=>'','1'=>'Por Servicio','2'=>'Por Equipo'],$reporte_data->tipo_reporte,array('class'=>'form-control','readonly'=>'')) }}
							@else
								{{ Form::select('tipo_reporte',['0'=>'','1'=>'Por Servicio','2'=>'Por Equipo'],$reporte_data->tipo_reporte,array('class'=>'form-control')) }}
							@endif
							
						</div>						
					</div>
					
				</div>			
			</div>
		</div>
		{{ Form::close() }}
@stop