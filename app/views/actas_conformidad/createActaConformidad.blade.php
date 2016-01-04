@extends('templates/actaConformidadTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nueva Acta de Conformidad</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><strong>{{ $errors->first('tipo') }}</strong></p>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor') }}</strong></p>
			<p><strong>{{ $errors->first('numero_acta') }}</strong></p>
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
			{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'actas_conformidad/submit_create_acta', 'role'=>'form','id'=>'submitForm')) }}	
		<div>
			{{ Form::hidden('flag_doc',0,array('id'=>'flag_doc'))}}
		</div>
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/actas_conformidad/list_actas')}}">Cancelar</a>				
			</div>
		</div>	
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  	<div class="panel-heading">Datos</div>
				  	<div class="panel-body">	
						<div class="row">								
							<div class="form-group col-md-4 @if($errors->first('tipo')) has-error has-feedback @endif">
								{{ Form::label('tipo','Tipo de Acta de Conformidad') }}
								{{ Form::select('tipo',array(''=> 'Seleccione') + $tipo_actas,Input::old('tipo'),['class' => 'form-control'])}}
							</div>
							<div class="form-group col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
								{{ Form::label('proveedor','Proveedor') }}
								{{ Form::select('proveedor',array(''=> 'Seleccione') + $proveedores,Input::old('proveedor'),['class' => 'form-control'])}}
							</div>
							<div class="col-md-4">
							{{ Form::label('fecha','Fecha')}}<span style="color:red"> *</span>
								<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha')) has-error has-feedback @endif">					
									{{ Form::text('fecha',Input::old('fecha'),array('class'=>'form-control','readonly'=>'')) }}
									<span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
				       		</div>
						</div>
					</div>			
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
	  				<div class="panel-heading">Acta de Conformidad Relacionada</div>
	  				<div class="panel-body">
						<div class="row">											
							<div class="form-group col-md-2 @if($errors->first('numero_acta')) has-error has-feedback @endif">
								{{ Form::label('numero_acta','Cód. Archivamiento') }}<span style="color:red">*</span>
								{{ Form::text('numero_acta',Input::old('numero_acta'),['class' => 'form-control','id'=>'numero_acta'])}}
							</div>
							<div class="col-md-2" style="margin-top:25px">
								<a class="btn btn-primary btn-block" id="idAgregarActa">
								<span class="glyphicon glyphicon-plus"></span> Agregar</a>
							</div>
							<div class="col-md-2" style="margin-top:25px">
								<div class="btn btn-default btn-block" id="idRemoveActa"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>
							</div>
							<div class="form-group col-md-4">
								{{ Form::label('nombre_acta','Documento') }}
								{{ Form::text('nombre_acta',Input::old('nombre_acta'),['class' => 'form-control','id'=>'nombre_acta','disabled'=>'disabled'])}}
							</div>	
							{{ Form::close()}}									
							<div class="form-group col-md-2">
								{{ Form::open(array('url'=>'actas_conformidad/download_acta', 'role'=>'form')) }}
								{{ Form::hidden('numero_acta_hidden',null)}}
								{{ Form::button('<span class="glyphicon glyphicon-download"></span> Descargar', array('id'=>'btn_descarga', 'type' => 'submit', 'class' => 'btn btn-primary btn-block','style'=>'margin-top:25px')) }}
								{{ Form::close() }}
							</div>									
						</div>
					</div>
				</div>
			</div>
		</div>		
@stop