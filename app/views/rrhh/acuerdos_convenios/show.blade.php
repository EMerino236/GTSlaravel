@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Acuerdos y convenios de asociación con entidades</h3>
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
				<div class="col-md-4 @if($errors->first('nombre_convenio')) has-error has-feedback @endif">
					{{ Form::label('nombre_convenio','Nombre de Convenio') }}
					{{ Form::text('nombre_convenio',$acuerdo_convenio->nombre,['class' => 'form-control', 'readonly' => 'true'])}}
				</div>					
			</div>
			<div class="form-group row">
				<div class="col-md-4">
					{{ Form::label('fecha_firma_convenio','Fecha de Firma') }}						
					<div id="datetimepicker1" class="form-group input-group date">
						{{ Form::text('fecha_firma_convenio',date('d-m-Y',strtotime($acuerdo_convenio->fechafirma)),array('class'=>'form-control','readonly'=>'', 'disabled'=>'true')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>				
				</div>					
				<div class="col-md-4 @if($errors->first('duracion_convenio')) has-error has-feedback @endif">
					{{ Form::label('duracion_convenio','Duración de Convenio (En Meses)') }}
					{{ Form::text('duracion_convenio',$acuerdo_convenio->duracion,['class' => 'form-control', 'readonly' => 'true'])}}
				</div>
			</div>
			<div class="form-group row">						
				<div class="col-md-12 @if($errors->first('descripcion_convenio')) has-error has-feedback @endif">
					{{ Form::label('descripcion_convenio','Descripción (MAX:200 Caracteres)') }}
					{{ Form::textarea('descripcion_convenio',$acuerdo_convenio->descripcion,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none', 'readonly' => 'true'])}}
				</div>
			</div>
			<div class="form-group row">						
				<div class="col-md-12 @if($errors->first('objetivo_convenio')) has-error has-feedback @endif">
					{{ Form::label('objetivo_convenio','Principales Objetivos (MAX:200 Caracteres)') }}
					{{ Form::textarea('objetivo_convenio',$acuerdo_convenio->objetivo,['class' => 'form-control','maxlength'=>'200','rows'=>'4','style'=>'resize:none', 'readonly' => 'true'])}}
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-4">
					{{ Form::label('file_documento','Archivo') }}
					{{ Form::text('file_documento',$acuerdo_convenio->nombre_archivo,['class' => 'form-control', 'readonly' => 'true'])}}						
				</div>
				<div class="col-md-2">
					<a class="btn btn-success btn-block btn-md" style="width:145px; float: left; margin-top:25px" href="{{route('acuerdo_convenio.download',$acuerdo_convenio->id)}}">
					<span class="glyphicon glyphicon-download"></span> Descargar</a>
				</div>					
			</div>		
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Instituciones relacionadas</h3>
		</div>
		<div class="panel-body">				
			<div class="row">
				<div class="col-md-6">
					<div class="table-responsive">
						<table class="table">
							<tr class="info">												
								<th class="text-nowrap">Nombre</th>
																												
							</tr>
							@foreach($instituciones as $institucion)							
							<tr>			
								<td class="text-nowrap">{{$institucion->nombre}}</td>																		
							</tr>
							@endforeach					
						</table>				
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Representantes institucionales</h3>
		</div>
		<div class="panel-body">
			<div class="form-group row">
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table">
							<tr class="info">												
								<th class="text-nowrap">Nombre</th>												
								<th class="text-nowrap">Departamento</th>												
								<th class="text-nowrap">Rol</th>								
							</tr>
							@foreach($reprsentantes_institucionales as $reprsentante_institucional)								
							<tr>			
								<td>{{$reprsentante_institucional->user->apellido_pat}} {{$reprsentante_institucional->user->apellido_mat}}, {{$reprsentante_institucional->user->nombre}}</td>
								<td>{{$reprsentante_institucional->user->area->nombre}}</td>
								<td>{{$reprsentante_institucional->user->rol->nombre}}</td>								
							</tr>
							@endforeach						
						</table>				
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Representantes de entidad asociada</h3>
		</div>
		<div class="panel-body">								
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table">
							<tr class="info">												
								<th class="text-nowrap">Nombre</th>
								<th class="text-nowrap">Área</th>												
								<th class="text-nowrap">Rol</th>								
							</tr>
							@foreach($representantes_convenio as $representante_convenio)							
							<tr>			
								<td>{{$representante_convenio->ap_paterno}} {{$representante_convenio->ap_materno}}, {{$representante_convenio->nombre}}</td>
								<td>{{$representante_convenio->area}}</td>											
								<td>{{$representante_convenio->rol}}</td>								
							</tr>
							@endforeach					
						</table>				
					</div>
				</div>				
			</div>
		</div>
	</div>


	<div class="form-group row">
		<div class="col-md-offset-8 col-md-4">
			<a class="btn btn-default btn-block btn-md" style="width:145px; float: right" href="{{route('acuerdo_convenio.index')}}">
			<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
		</div>
	</div>

@stop