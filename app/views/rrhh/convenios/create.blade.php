@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Acuerdos y convenios de asociación con entidades</h3>
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

	{{ Form::open(array('url'=>'#', 'role'=>'form')) }}		
	<div class="panel panel-default">
	  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">	
				<div class="form-group row">
					<div class="col-md-4 @if($errors->first('nombre_convenio')) has-error has-feedback @endif">
						{{ Form::label('nombre_convenio','Nombre de Convenio') }}<span style='color:red'>*</span>
						{{ Form::text('nombre_convenio',Input::old('nombre_convenio'),['class' => 'form-control'])}}
					</div>					
				</div>
				<div class="form-group row">
					<div class="col-md-4">
						{{ Form::label('fecha_firma_convenio','Fecha de Firma') }}						
						<div id="datetimepicker1" class="form-group input-group date">
							{{ Form::text('fecha_firma_convenio',Input::old('fecha_firma_convenio'),array('class'=>'form-control','readonly'=>'')) }}
							<span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
						</div>				
					</div>					
					<div class="col-md-4 @if($errors->first('duracion_convenio')) has-error has-feedback @endif">
						{{ Form::label('duracion_convenio','Duración de Convenio') }}<span style='color:red'>*</span>
						{{ Form::text('duracion_convenio',Input::old('duracion_convenio'),['class' => 'form-control'])}}
					</div>
				</div>
				<div class="form-group row">						
					<div class="col-md-12 @if($errors->first('descripcion_documento')) has-error has-feedback @endif">
						{{ Form::label('descripcion_documento','Descripción (MAX:200 Caracteres)') }}
						{{ Form::textarea('descripcion_documento',Input::old('descripcion_documento'),['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none'])}}
					</div>
				</div>				
			</div>
		</div>
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => 'width:145px')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" style="width:145px" href="{{route('convenio.index')}}">Cancelar</a>				
			</div>
		</div>
		{{ Form::close() }}
@stop