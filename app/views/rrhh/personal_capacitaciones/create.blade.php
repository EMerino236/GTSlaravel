@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nuevo Personal</h3>
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
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach		
		</div>
	@endif

	{{ Form::open(array('route'=>'capacitacion.store_personal', 'role'=>'form','files'=>'true')) }}		
		{{Form::hidden('id_capacitacion',$id_capacitacion)}}
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos Generales
	  	</div>

	  	<div class="panel-body">	
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Nombres') }}<span style='color:red'>*</span>
					{{ Form::text('nombre',Input::old('nombre'),['class' => 'form-control'])}}						
				</div>								
				<div class="col-md-4 @if($errors->first('apellidos')) has-error has-feedback @endif">
					{{ Form::label('apellidos','Apellidos') }}<span style='color:red'>*</span>
					{{ Form::text('apellidos',Input::old('apellidos'),['class' => 'form-control'])}}	
				</div>
				<div class="form-group col-md-4 @if($errors->first('departamento')) has-error has-feedback @endif">
					{{ Form::label('departamento','Departamento') }}<span style='color:red'>*</span>
					{{ Form::select('departamento', array('' => 'Seleccione') + $departamentos, Input::old('departamento'), ['id'=>'departamento','class'=>'form-control','onChange'=>'getServicios(this)']) }}
				</div>

				<div class="form-group col-md-4 @if($errors->first('servicio_clinico')) has-error has-feedback @endif">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}<span style='color:red'>*</span>
					{{ Form::select('servicio_clinico', array('' => 'Seleccione') + $servicios, Input::old('servicio_clinico'), ['id'=>'servicio_clinico','class'=>'form-control']) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('tipo_documento')) has-error has-feedback @endif">
					{{ Form::label('tipo_documento','Tipo Documento') }}<span style='color:red'>*</span>
					{{ Form::select('tipo_documento', array('' => 'Seleccione') + $tipos_documentos, Input::old('tipo_documento'), ['class'=>'form-control']) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('numero_documento')) has-error has-feedback @endif">
					{{ Form::label('numero_documento','Número de Documento') }}<span style='color:red'>*</span>
					{{ Form::text('numero_documento',Input::old('numero_documento'),['class' => 'form-control'])}}
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid row">
		<div class="form-group col-md-2 col-md-offset-8">				
			{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => '145px')) }}
		</div>
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" style="width:145px" href="{{URL::to('/capacitacion/show_personal')}}/{{$id_capacitacion}}">Cancelar</a>				
		</div>
	</div>
	{{ Form::close() }}

	<script type="text/javascript">

		$( document ).ready(function(){

			habilitaCampos();

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