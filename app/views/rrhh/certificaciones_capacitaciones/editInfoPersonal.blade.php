@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Personal: {{$personal->apellidos}}, {{$personal->nombre}}</h3>
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

	{{ Form::open(array('route'=>'certificacion.update_info_personal', 'role'=>'form','files'=>'true')) }}		
		{{Form::hidden('id_capacitacion',$id_capacitacion)}}
		{{Form::hidden('id_personal',$personal->id)}}
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos Generales
	  	</div>

	  	<div class="panel-body">	
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombres') }}<span style='color:red'>*</span>
					{{ Form::text('nombre',$personal->nombre,['class' => 'form-control','readonly'=>''])}}						
				</div>								
				<div class="col-md-4 @if($errors->first('apellidos')) has-error has-feedback @endif">
					{{ Form::label('apellidos','Apellidos') }}<span style='color:red'>*</span>
					{{ Form::text('apellidos',$personal->apellidos,['class' => 'form-control','readonly'=>''])}}	
				</div>
				<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
					{{ Form::label('departamento','Departamento') }}<span style='color:red'>*</span>
					{{ Form::select('departamento', array('' => 'Seleccione') + $departamentos, $personal->id_departamento, ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)','readonly'=>'']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}<span style='color:red'>*</span>
					{{ Form::select('servicio_clinico', array('' => 'Seleccione') + $servicios, $personal->id_servicio, ['id'=>'servicio_clinico','class'=>'form-control','readonly'=>'']) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
					{{ Form::label('tipo_documento','Tipo Documento') }}<span style='color:red'>*</span>
					{{ Form::select('tipo_documento', array('' => 'Seleccione') + $tipos_documentos, $personal->id_tipodocumento, ['class'=>'form-control','readonly'=>'']) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('numero_documento')) has-error has-feedback @endif">
					{{ Form::label('numero_documento','Número de Documento') }}<span style='color:red'>*</span>
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
				{{ Form::text('sesiones_asistidas',$personal->sesiones_asistidas,['class' => 'form-control'])}}
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
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => '145px')) }}
		</div>
		<div class="form-group col-md-2 col-md-offset-8">
			<a class="btn btn-default btn-block" style="width:145px" href="{{URL::to('/certificacion/show_info_personal')}}/{{$personal->id}}">Cancelar</a>				
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

			if($('#existe_archivo').val()==1)
			   $("#adjuntar_certificado").hide();
			else{
				$("#adjuntar_certificado").show();
			}
		});

		$("#input-file").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});

	</script>
@stop