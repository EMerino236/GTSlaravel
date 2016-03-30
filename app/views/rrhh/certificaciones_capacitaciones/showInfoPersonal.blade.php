@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Personal: {{$personal->apellidos}}, {{$personal->nombre}}</h3>
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
		<div class="alert alert-danger alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach		
		</div>
	@endif

		
		
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos Generales
	  	</div>
	  	<div class="panel-body">	
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombres') }}
					{{ Form::text('nombre',$personal->nombre,['class' => 'form-control','readonly'=>''])}}						
				</div>								
				<div class="col-md-4 @if($errors->first('apellidos')) has-error has-feedback @endif">
					{{ Form::label('apellidos','Apellidos') }}
					{{ Form::text('apellidos',$personal->apellidos,['class' => 'form-control','readonly'=>''])}}	
				</div>
				<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento',$personal->nombre_area,['class' => 'form-control','readonly'=>''])}}
				</div>
				<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::text('servicio_clinico',$personal->nombre_servicio,['class' => 'form-control','readonly'=>''])}}
				</div>
				<div class="form-group col-md-4 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
					{{ Form::label('tipo_documento','Tipo Documento') }}
					{{ Form::text('tipo_documento',$personal->nombre_tipo_documento,['class' => 'form-control','readonly'=>''])}}
				</div>
				<div class="form-group col-md-4 @if($errors->first('numero_documento')) has-error has-feedback @endif">
					{{ Form::label('numero_documento','Número de Documento') }}
					{{ Form::text('numero_documento',$personal->numero_documento,['class' => 'form-control','readonly'=>''])}}
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Sesiones
	  	</div>
	  	<div class="panel-body">
	  		<div class="form-group col-md-4 @if($errors->first('sesiones_asistidas')) has-error has-feedback @endif">
				{{ Form::label('sesiones_asistidas','Sesiones Asistidas') }}
				{{ Form::text('sesiones_asistidas',$personal->sesiones_asistidas,['class' => 'form-control','readonly'=>''])}}
			</div>
			<div class="form-group col-md-2">				
				<a class="btn btn-default btn-primary" style="width:145px;margin-top:25px;" href="{{URL::to('/certificacion/edit_info_personal')}}/{{$personal->id}}"> <span class="glyphicon glyphicon-floppy-disk"></span> Editar</a>				
			</div>
	  	</div>
	</div>

	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Certificado
	  	</div>
	  	<div class="panel-body">
	  		@if($personal->nombre_archivo == null)
	  			<h4 style="color:red;text-align:center" >Personal no cuenta con certificado registrado</h4>
	  		@else
	  			<div class="form-group col-md-6 col-md-offset-2 @if($errors->first('archivo')) has-error has-feedback @endif">
					{{ Form::label('archivo','Certificado de la Capacitacion') }}
					{{ Form::text('archivo',$personal->nombre_archivo,['class' => 'form-control','readonly'=>''])}}
				</div>
				<div class="form-group col-md-2" style="margin-top:25px;">
					<a class="btn btn-success btn-block btn-sm"  href="{{URL::to('/capacitacion/downloadCertificado')}}/{{$personal->id}}" ><span class="glyphicon glyphicon-download"></span> Descargar</a>
				</div>
	  		@endif
	  	</div>
	</div>

	<div class="container-fluid row">
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" style="width:145px" href="{{URL::to('/certificacion/show_personal')}}/{{$id_capacitacion}}">Regresar</a>				
		</div>
	</div>
	{{ Form::close() }}

	<script type="text/javascript">

		$( document ).ready(function(){

			
			$('#tipo_documento').change(function(){
			    $('#numero_documento').prop('readonly',false);
			    tipo_documento = $('#tipo_documento').val();
			    if(tipo_documento == 1){
			        $('#numero_documento').val(null);
			        $('#numero_documento').prop('maxlength',8);
			    }else if(tipo_documento == 2 || tipo_documento == 3){            
			        $('#numero_documento').val(null);
			        $('#numero_documento').prop('maxlength',12);
			    }else{            
			        $('#numero_documento').val(null);
			        $('#numero_documento').prop('readonly',true);
			    }        
			});
		});


	</script>
@stop