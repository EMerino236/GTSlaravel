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

	{{ Form::open(array('route'=>'certificacion.update_certificado_personal', 'role'=>'form','files'=>'true')) }}		
		{{Form::hidden('id_capacitacion',$id_capacitacion)}}
		{{Form::hidden('id_personal',$personal->id)}}	

		
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Certificado
	  	</div>
	  	<div class="panel-body">
	  		<div class="form-group row">
	  			@if(!$personal->nombre_archivo == null)
	  				{{Form::hidden('existe_archivo',1,array('id'=>'existe_archivo'))}}
					<div class="col-md-6 form-group col-md-offset-2">
						{{ Form::label('file_documento','Archivo') }}
						{{ Form::text('file_documento',$personal->nombre_archivo,['class' => 'form-control', 'readonly' => 'true'])}}						
					</div>
					<div class="col-md-2 hide">
						<a class="btn btn-success btn-block btn-md" style="width:145px; float: left; margin-top:25px" href="{{route('capacitacion.downloadCertificado',$personal->id)}}">
						<span class="glyphicon glyphicon-download"></span> Descargar</a>
					</div>
					<div class="col-md-2">
						<div class="btn btn-warning btn-block" style="width:145px; float: left; margin-top:25px" id="btnReemplazar" onClick="showAdjuntarCertificado()">
							<span class="glyphicon glyphicon-refresh"></span> Reemplazar</div>				
					</div>
				@else
					{{Form::hidden('existe_archivo',0,array('id'=>'existe_archivo'))}}
				@endif
					<div id="adjuntar_certificado" class="col-md-8 col-md-offset-2 @if($errors->first('archivo')) has-error has-feedback @endif">
						<label class="control-label">Seleccione un Documento </label><span style='color:red'>*</span><span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="right" title="Formatos Permitidos: png, jpe, jpeg, jpg, gif, bmp, zip, rar, pdf, doc, docx, xls, xlsx, ppt, pptx"></span>
						<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
					</div>
			</div>
				
	  	</div>
	</div>

	<div class="container-fluid row">
		<div class="form-group col-md-2">				
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => '145px')) }}
		</div>
		<div class="form-group col-md-2 col-md-offset-8">
			<a class="btn btn-default btn-block" style="width:145px" href="{{URL::to('/certificacion/show_personal')}}/{{$id_capacitacion}}">Cancelar</a>				
		</div>
	</div>

	{{ Form::close() }}

	<script type="text/javascript">

		$( document ).ready(function(){
			existe_archivo = $('#existe_archivo').val();
			if(existe_archivo==0){
				$("#adjuntar_certificado").show();
			}else{
				$("#adjuntar_certificado").hide();
			}
			
		});


	</script>
@stop