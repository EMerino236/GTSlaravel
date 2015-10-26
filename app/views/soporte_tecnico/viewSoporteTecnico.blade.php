@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Soporte Técnico: <strong>{{$soporte_tecnico_info->apellido_pat}} {{$soporte_tecnico_info->apellido_mat}} ,{{$soporte_tecnico_info->nombres}}</strong> </h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">		
		</div>
	@endif

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

	{{ Form::open(array('url'=>'soportes_tecnico/submit_edit_soporte_tecnico', 'role'=>'form')) }}
	{{ Form::hidden('idsoporte_tecnico', $soporte_tecnico_info->idsoporte_tecnico) }}
		<div class="panel panel-default">
		  	<div class="panel-heading">Datos Generales</div>
		  	<div class="panel-body">
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('tipo_documento_identidad')) has-error has-feedback @endif">
						{{ Form::label('tipo_documento_identidad','Tipo de Documento') }}<span style="color:red">*</span>
						{{ Form::select('tipo_documento_identidad', array('' => 'Seleccione') + $tipo_documento_identidad,$soporte_tecnico_info->idtipo_documento,['class' => 'form-control', 'readonly']) }}						
					</div>
					<div class="form-group col-md-4 @if($errors->first('numero_documento_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('numero_documento_soporte_tecnico','Número de Documento') }}<span style="color:red">*</span>
						{{ Form::text('numero_documento_soporte_tecnico',$soporte_tecnico_info->numero_doc_identidad,array('class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-2">
						
					</div>										
		  		</div>
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('nombre_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('nombre_soporte_tecnico','Nombre') }}<span style="color:red">*</span>
						{{ Form::text('nombre_soporte_tecnico',$soporte_tecnico_info->nombres,array('class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('apPaterno_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('apPaterno_soporte_tecnico','Apellido Paterno') }}<span style="color:red">*</span>
						{{ Form::text('apPaterno_soporte_tecnico',$soporte_tecnico_info->apellido_pat,array('class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('apMaterno_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('apMaterno_soporte_tecnico','Apellido Materno') }}<span style="color:red">*</span>
						{{ Form::text('apMaterno_soporte_tecnico',$soporte_tecnico_info->apellido_mat,array('class'=>'form-control','readonly')) }}
					</div>
		  		</div>
		  		<div class="row">
		  			<div class="form-group col-md-4 @if($errors->first('especialidad_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('especialidad_soporte_tecnico','Especialidad') }}<span style="color:red">*</span>
						{{ Form::text('especialidad_soporte_tecnico',$soporte_tecnico_info->especialidad,array('class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('telefono_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('telefono_soporte_tecnico','Telefono') }}<span style="color:red">*</span>
						{{ Form::text('telefono_soporte_tecnico',$soporte_tecnico_info->telefono,array('class'=>'form-control','readonly')) }}
					</div>
					<div class="form-group col-md-4 @if($errors->first('email_soporte_tecnico')) has-error has-feedback @endif">
						{{ Form::label('email_soporte_tecnico','E-mail') }}<span style="color:red">*</span>
						{{ Form::text('email_soporte_tecnico',$soporte_tecnico_info->email,array('class'=>'form-control','readonly')) }}
					</div>
		  		</div>		  		
			</div>
		</div>			

	<div class="container-fluid row">
		<div class="form-group col-md-offset-10 col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::to('/soportes_tecnico/list_soporte_tecnico')}}">
			<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
		</div>
	</div>			
@stop