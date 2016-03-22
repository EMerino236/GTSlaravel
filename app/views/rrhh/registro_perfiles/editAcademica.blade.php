@extends('templates/recursosHumanosTemplate')
@section('content')	

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Formacion Academica: {{$academica->titulo}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach	
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('route'=>['registro_perfil.academica.update',$academica->id], 'role'=>'form', 'files'=>'true')) }}

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Informacion general</h3>
		</div>
	
	  	<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-4 @if($errors->first('fa_grado') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_grado','Grado Obtenido') }}
					{{ Form::select('fa_grado',$grados, $academica->id_grado,['id'=>'fa_grado','class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('fa_nombre_grado') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_nombre_grado','Nombre del titulo o grado') }}
					{{ Form::text('fa_nombre_grado',$academica->titulo,['class' => 'form-control'])}}
				</div>

				<div class="col-md-4 @if($errors->first('fa_centro_estudios') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_centro_estudios','Centro de estudios') }}
					{{ Form::text('fa_centro_estudios',$academica->centro,['class' => 'form-control'])}}
				</div>
			</div>

			<div class="row">
				<div class="col-md-4 @if($errors->first('fa_pais_estudios') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_pais_estudios','Pais de Estudios') }}
					{{ Form::select('fa_pais_estudios',$paises,$academica->id_pais,['id'=>'fa_pais_estudios','class' => 'form-control'])}}
				</div>

				<div class="form-group col-md-4 @if($errors->first('fa_fecha_inicio') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_fecha_inicio','Fecha Inicio') }}
					<div id="datetimepicker1" class="form-group input-group date">
						{{ Form::text('fa_fecha_inicio',date('dd-mm-YYYY',strtotime($academica->fecha_ini)),array('class'=>'form-control', 'readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>

				<div class="form-group col-md-4 @if($errors->first('fa_fecha_fin') || Session::has('error')) has-error has-feedback @endif">
					{{ Form::label('fa_fecha_fin','Fecha Fin') }}
					<div id="datetimepicker2" class="form-group input-group date">
						{{ Form::text('fa_fecha_fin',date('dd-mm-YYYY',strtotime($academica->fecha_fin)),array('class'=>'form-control', 'readonly'=>'')) }}
						<span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Adjuntar Certificado</h3>
				</div>
				<div class="panel-body">
					<div class="col-md-8 form-group @if($errors->first('archivo')) has-error has-feedback @endif">
						<label class="control-label">Seleccione un Documento</label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
						<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
					</div>
					<div class="col-md-8 form-group">
						{{ Form::label('archivo_subido','Archivo Subido') }}
						{{ Form::text('archivo_subido', $academica->nombre_archivo, ['class'=>'form-control','readonly']) }}
					</div>
				</div>	
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group col-md-2">
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
		</div>

		<div class="form-group col-md-2">
			<a class="btn-under" href="{{route('registro_perfil.academica.destroy',$academica->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Eliminar', array('class' => 'btn btn-danger btn-block')) }}
			</a>
		</div>

		<div class="form-group col-md-offset-6 col-md-2">
			<a class="btn-under" href="{{route('registro_perfil.edit',$academica->id_perfil)}}">
				{{ Form::button('<span class="glyphicon glyphicon-repeat"></span> Regresar', array('class' => 'btn btn-primary btn-block')) }}
			</a>
		</div>
	</div>

	{{Form::close()}}
@stop
