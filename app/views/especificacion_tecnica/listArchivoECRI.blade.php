@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Archivos ECRI</h3>            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Lista de Archivos</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-8 ">
						{{ Form::label('nombre_archivo','Nombre de Archivo') }}
					</div>
					<div class="form-group col-md-2">
						{{ Form::label('descargar','Descargar') }}
					</div>				
				</div>
				@foreach($archivos_ECRI_data as $index => $archivo_ECRI_data)
					<div class="row">
						<div class="form-group col-md-8 ">
							{{ Form::text('nombre_archivo',($index+1).'. '.$archivo_ECRI_data->nombre_archivo,['disabled'=>'','class' => 'form-control']) }}
						</div>
						<div class="form-group col-md-2">
							<a class="btn btn-primary btn-block" href="{{URL::to('/especificacion_tecnica/download_archivo_ECRI/')}}/{{$archivo_ECRI_data->idarchivos_ECRI}}"><span class="glyphicon glyphicon-download"></span> Descargar</a>
						</div>			
					</div>
				@endforeach
			</div>
		</div>
		<div class="row">
			<div class="col-md-2 form-group">
				<a class="btn btn-default btn-block" href="{{URL::to('/especificacion_tecnica/list_especificacion_tecnica')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
			</div>	
		<div>
	{{ Form::close() }}				

@stop