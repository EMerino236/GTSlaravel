@extends('templates/bienesIRETemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Equipo: <strong>{{$equipo_info->codigo_patrimonial}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>			
			<p><strong>{{ $errors->first('fe') }}</strong></p>
			<p><strong>{{ $errors->first('ac') }}</strong></p>
			<p><strong>{{ $errors->first('rm') }}</strong></p>
			<p><strong>{{ $errors->first('hie') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('message') }}
		</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	{{ Form::open(array('url'=>'estado_ts/submit_edit_activo_ire', 'role'=>'form')) }}
	{{ Form::hidden('idequipo', $equipo_info->idactivo) }}
		<div class="row">			
			<div class="col-md-12">
				<div class="panel panel-default">
		  		<div class="panel-heading">Datos Generales</div>
		  			<div class="panel-body">						
						<div class="form-group row">								
							<div class="col-md-4">
								{{ Form::label('nombre_equipo','Nombre Equipo') }}
								{{ Form::text('nombre_equipo',$equipo_info->modelo->familiaActivo->nombre_equipo,array('class'=>'form-control','readonly'))}}								
							</div>
							<div class="col-md-4">
								{{ Form::label('modelo_equipo','Modelo') }}
								{{ Form::text('modelo_equipo',$equipo_info->modelo->nombre,array('class'=>'form-control','readonly'))}}								
							</div>
							<div class="col-md-4">
								{{ Form::label('numero_serie_equipo','Número de Serie') }}
								{{ Form::text('numero_serie_equipo',$equipo_info->numero_serie,array('class'=>'form-control','readonly'))}}								
							</div>													
						</div>	
						<div class="form-group row">
							<div class="col-md-4">
								{{ Form::label('marca_equipo','Marca') }}
								{{ Form::text('marca_equipo',$equipo_info->modelo->familiaActivo->marca->nombre,array('class'=>'form-control','readonly'))}}								
							</div>	
						</div>					
					</div>
				</div>			
			</div>
		</div>

		<div clas="row">			
				<div class="panel panel-default">
					<div class="panel-heading">Indicadores</div>
					<div class="panel-body">
						<div class="form-group row">
							<div class="col-md-4">
								{{ Form::label('fe','Funciol del Equipo') }}<span style="color:red">*</span>
								{{ Form::number('fe',$equipo_info->fe,array('class'=>'form-control', 'min'=>'2', 'max'=>'10'))}}
							</div>
							<div class="col-md-4">
								{{ Form::label('ac','Aplicación Clínica') }}<span style="color:red">*</span>
								{{ Form::number('ac',$equipo_info->ac,array('class'=>'form-control', 'min'=>'1', 'max'=>'5'))}}
							</div>
							<div class="col-md-4">
								{{ Form::label('rm','Requerimiento de Mantenimiento') }}<span style="color:red">*</span>
								{{ Form::number('rm',$equipo_info->rm,array('class'=>'form-control', 'min'=>'1', 'max'=>'5'))}}
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-4">
								{{ Form::label('hie','Historial de Incidentes del Equipo') }}<span style="color:red">*</span>
								{{ Form::number('hie',$equipo_info->hie,array('class'=>'form-control', 'min'=>'-2', 'max'=>'2'))}}
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>

						<div class="form-group row">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								{{ Form::label('ge','GE') }}
								{{ Form::text('ge',$equipo_info->ge,array('class'=>'form-control','readonly'))}}
							</div>
							<div class="col-md-4">
								{{ Form::label('fm','Frecuencia de Mantenimiento') }}
								{{ Form::text('fm','',array('class'=>'form-control','readonly'))}}
							</div>
						</div>
					</div>
				</div>
			</div>	
		
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
			</div>						
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('estado_ts/view_ire_servicio/')}}/{{$equipo_info->idservicio}}">Cancelar</a>
			</div>	
	{{ Form::close() }}		
		</div>
@stop