@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Plan de Desarrollo de RRHH</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    @if (Session::has('message'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>			
		</div>
	@endif

	
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('nombre_documento')) has-error has-feedback @endif">
						{{ Form::label('','Nombre de Documento') }}
						{{ Form::text('nombre_documento',$plan_desarrollo->nombre,['class' => 'form-control', 'readonly' => 'true'])}}						
					</div>								
					<div class="col-md-4 @if($errors->first('autor_documento')) has-error has-feedback @endif">
						{{ Form::label('autor_documento','Autor') }}
						{{ Form::text('autor_documento',$plan_desarrollo->autor,['class' => 'form-control', 'readonly' => 'true'])}}						
					</div>
					<div class="col-md-4 @if($errors->first('codigo_documento')) has-error has-feedback @endif">
						{{ Form::label('codigo_documento','Código de Archivamiento') }}
						{{ Form::text('codigo_documento',$plan_desarrollo->codigo_archivamiento,['class' => 'form-control', 'readonly' => 'true'])}}						
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('descripcion_documento')) has-error has-feedback @endif">
						{{ Form::label('descripcion_documento','Descripción (MAX:200 Caracteres)') }}
						{{ Form::textarea('descripcion_documento',$plan_desarrollo->descripcion,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none', 'readonly' => 'true'])}}
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-4">
						{{ Form::label('file_documento','Archivo') }}
						{{ Form::text('file_documento',$plan_desarrollo->nombre_archivo,['class' => 'form-control', 'readonly' => 'true'])}}						
					</div>
					<div class="col-md-4">
						<a class="btn btn-success btn-block btn-md" style="width:145px; float: left; margin-top:25px" href="{{route('plan_desarrollo.download',$plan_desarrollo->id)}}">
						<span class="glyphicon glyphicon-download"></span> Descargar</a>
					</div>
				</div>				
			</div>
	</div>

	<div class="form-group row">
		<div class="col-md-offset-8 col-md-4">
			<a class="btn btn-default btn-block btn-md" style="width:145px; float: right" href="{{route('plan_desarrollo.index')}}">
			<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
		</div>
	</div>
		
@stop