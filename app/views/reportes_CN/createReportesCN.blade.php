@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Reporte Certificado de Necesidad</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idprogramacion_reporte_cn') }}</strong></p>
			<p><strong>{{ $errors->first('idot_retiro') }}</strong></p>
			<p><strong>{{ $errors->first('archivo') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'reporte_cn/submit_create_reporte_cn', 'role'=>'form', 'files'=>true)) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos del Reporte</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idprogramacion_reporte_cn')) has-error has-feedback @endif">
						{{ Form::label('idprogramacion_reporte_cn','Programaciones No Concluidas') }}<span style='color:red'>*</span>
						{{ Form::select('idprogramacion_reporte_cn',array(''=>'Seleccione') + $programaciones_reporte_cn,$programacion_reporte_cn_id,['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-8">
						@if(!$programaciones_reporte_cn)
							<span style='color:red'>No existen Reportes CN programados. </span><a href="{{URL::to('/programacion_reportes/create_programacion_reportes')}}"><span style='color:red'><u>Agregar Programación aquí.</u></span></a>						
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idtipo_reporte_select')) has-error has-feedback @endif">
						{{ Form::label('idtipo_reporte_select','Tipo de Reporte') }}
						@if($programacion_reporte_cn)
							{{ Form::select('idtipo_reporte_select',array(''=>'Seleccione') + $tipo_reporte_cn,$programacion_reporte_cn->idtipo_reporte_CN,['class' => 'form-control','disabled'=>'disabled']) }}
						@else
							{{ Form::select('idtipo_reporte_select',array(''=>'Seleccione') + $tipo_reporte_cn,'',['class' => 'form-control','disabled'=>'disabled']) }}
						@endif
						{{ Form::hidden('idtipo_reporte')}}
					</div>
					<div class="form-group col-md-4 @if($errors->first('responsable')) has-error has-feedback @endif">
						{{ Form::label('responsable','Responsable') }}
						@if($programacion_reporte_cn)
							{{ Form::text('responsable',$responsable->apellido_pat.' '.$responsable->apellido_mat.' '.$responsable->nombre,['class' => 'form-control','disabled'=>'disabled']) }}
						@else
							{{ Form::text('responsable','',['class' => 'form-control','disabled'=>'disabled']) }}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('idservicio')) has-error has-feedback @endif">
						{{ Form::label('idservicio','Servicio') }}
						@if($programacion_reporte_cn)
							{{ Form::select('idservicio',array(''=>'Seleccione') + $servicios,$programacion_reporte_cn->idservicio,['class' => 'form-control','disabled'=>'disabled']) }}
						@else
							{{ Form::select('idservicio',array(''=>'Seleccione') + $servicios,'',['class' => 'form-control','disabled'=>'disabled']) }}
						@endif
					</div><div class="form-group col-md-4 @if($errors->first('idarea_select')) has-error has-feedback @endif">
						{{ Form::label('idarea_select','Departamento') }}
						@if($programacion_reporte_cn)
							{{ Form::select('idarea_select',array(''=>'Seleccione') + $areas,$programacion_reporte_cn->idarea,['class' => 'form-control','disabled'=>'disabled']) }}	
						@else
							{{ Form::select('idarea_select',array(''=>'Seleccione') + $areas,'',['class' => 'form-control','disabled'=>'disabled']) }}	
						@endif
						{{ Form::hidden('idarea')}}
					</div>
				</div>		
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_ot_retiro')) has-error has-feedback @endif">
						{{ Form::label('codigo_ot_retiro','OT de Baja de Equipo',array('id'=>'codigo_ot_retiro_label')) }}<span style='color:red'>*</span>
						{{ Form::text('codigo_ot_retiro',Input::old('codigo_ot_retiro'),array('placeholder'=>'RS0001TS','class'=>'form-control','maxlength'=>8)) }}
						{{ Form::hidden('idot_retiro')}}
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_equipo()"><span class="glyphicon glyphicon-plus"></span> Agregar OT</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
						<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_equipo()"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_equipo')) has-error has-feedback @endif">
						{{ Form::label('nombre_equipo','Nombre de Equipo',array('id'=>'nombre_equipo_label')) }}
						{{ Form::text('nombre_equipo',Input::old('nombre_equipo'),array('class'=>'form-control','readonly'=>'')) }}
					</div>
				</div>
				<div id="div_etes1" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_etes1')) has-error has-feedback @endif">
						{{ Form::label('codigo_reporte_etes1','Reportes ETES Vinculados',array('id'=>'codigo_reporte_etes_label')) }}
						{{ Form::text('codigo_reporte_etes1',Input::old('codigo_reporte_etes1'),array('placeholder'=>'EC0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('idreporte_etes1')}}
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a id="btn_validar_etes1" class="btn btn-primary btn-block" onclick="validar_etes(1)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
						<a id="btn_limpiar_etes1" class="btn btn-default btn-block" onclick="limpiar_etes(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_etes2" class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_etes2')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_etes2',Input::old('codigo_reporte_etes2'),array('id'=>'codigo_reporte_etes2', 'placeholder'=>'EC0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('idreporte_etes2')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_etes2" class="btn btn-primary btn-block" onclick="validar_etes(2)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_etes2" class="btn btn-default btn-block" onclick="limpiar_etes(2)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_etes3" class="row" hidden>
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_etes3')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_etes3',Input::old('codigo_reporte_etes3'),array('id'=>'codigo_reporte_etes3', 'placeholder'=>'EC0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('idreporte_etes3')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_etes3" class="btn btn-primary btn-block" onclick="validar_etes(3)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_etes3" class="btn btn-default btn-block" onclick="limpiar_etes(3)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_etes4" class="row" hidden>
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_etes4')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_etes4',Input::old('codigo_reporte_etes4'),array('id'=>'codigo_reporte_etes4', 'placeholder'=>'EC0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('idreporte_etes4')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_etes4" class="btn btn-primary btn-block" onclick="validar_etes(4)"><span class="glyphicon glyphicon-plus"></span> Validar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_etes4" class="btn btn-default btn-block" onclick="limpiar_etes(4)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<div id="div_etes5" class="row" hidden>
					<div class="form-group col-md-4 @if($errors->first('codigo_reporte_etes5')) has-error has-feedback @endif">
						{{ Form::text('codigo_reporte_etes5',Input::old('codigo_reporte_etes5'),array('id'=>'codigo_reporte_etes5', 'placeholder'=>'EC0001-16','class'=>'form-control','maxlength'=>9)) }}
						{{ Form::hidden('idreporte_etes5')}}
					</div>
					<div class="form-group col-md-2">
						<a id="btn_validar_etes5" class="btn btn-primary btn-block" onclick="validar_etes(5)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-left:15px">
						<a id="btn_limpiar_etes5" class="btn btn-default btn-block" onclick="limpiar_etes(5)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
				</div>
				<a id="label_agregar_etes">Agregar más Reportes ETES vinculados</a>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Subir Documentos</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<label class="control-label">Seleccione un Documento<span style='color:red'>*</span></label>(png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx)
					<input name="archivo" id="input-file" type="file" class="file file-loading" data-show-upload="false">
				</div>
			</div>
		</div>		
			<div class="row">
				<div class="form-group col-md-2">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/reporte_cn/list_reporte_cn/')}}">Regresar</a>				
				</div>
			</div>		
		</div>	
	{{ Form::close() }}
	
	<script>
		$("#input-file").fileinput({
		    language: "es",
		    allowedFileExtensions: ["png","jpe","jpeg","jpg","gif","bmp","zip","rar","pdf","doc","docx","xls","xlsx","ppt","pptx"]
		});
	</script>
	
@stop