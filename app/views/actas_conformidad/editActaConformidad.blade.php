@extends('templates/actaConformidadTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Acta de Conformidad: {{$documento_info->codigo_archivamiento}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('tipo') }}</strong></p>
			<p><strong>{{ $errors->first('fecha') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor') }}</strong></p>
			<p><strong>{{ $errors->first('documento') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'actas_conformidad/submit_edit_acta', 'role'=>'form')) }}	
	{{ Form::hidden('acta_id', $documento_info->iddocumento) }}
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-8">				
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_edit_solicitud', 'type'=>'submit', 'class' => 'btn btn-primary btn-block')) }}
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
								{{ Form::label('tipo','Tipo de Acta') }}								
								@if($documento_info->deleted_at)
									{{Form::select('tipo',$tipo_actas,$documento_info->idtipo_acta,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{Form::select('tipo',$tipo_actas,$documento_info->idtipo_acta,array('class'=>'form-control')) }}
								@endif
							</div>
							<div class="form-group col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
								{{ Form::label('proveedor','Proveedor') }}
								@if($documento_info->deleted_at)
									{{Form::select('proveedor',array('0'=> 'Seleccione')+$proveedores,$documento_info->idproveedor,array('class'=>'form-control','readonly'=>'')) }}
								@else
									{{Form::select('proveedor',array('0'=> 'Seleccione')+$proveedores,$documento_info->idproveedor,array('class'=>'form-control')) }}
								@endif
							</div>
							<div class="col-md-4">
							{{ Form::label('fecha','Fecha')}}<span style="color:red"> *</span>
								<div id="datetimepicker1" class="form-group input-group date @if($errors->first('fecha')) has-error has-feedback @endif">					
									{{ Form::text('fecha',date('d-m-Y',strtotime($documento_info->fecha_acta)),array('class'=>'form-control','readonly'=>'')) }}
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
	  				<div class="panel-heading">Documento Relacionado</div>
	  				<div class="panel-body">
						<div class="row">											
							<div class="form-group col-md-2 @if($errors->first('numero_acta')) has-error has-feedback @endif">
								{{ Form::label('numero_acta','Cód. Archivamiento') }}<span style="color:red">*</span>
								@if($documento_info->deleted_at)
									{{ Form::text('numero_acta',$documento_info->codigo_archivamiento,array('class'=>'form-control','readonly'=>'','id'=>'numero_acta')) }}
								@else
									{{ Form::text('numero_acta',$documento_info->codigo_archivamiento,array('class'=>'form-control','id'=>'numero_acta','readonly'=>'')) }}
								@endif
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