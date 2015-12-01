@extends('templates/actaConformidadTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Acta de Conformidad: {{$documento_info->codigo_archivamiento}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	{{ Form::hidden('acta_id', $documento_info->iddocumento) }}
		<div class="container-fluid row">
			<div class="form-group col-md-2 col-md-offset-10">
				<a class="btn btn-default btn-block" href="{{URL::to('/actas_conformidad/list_actas')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
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
									{{Form::select('tipo',$tipo_actas,$documento_info->idtipo_acta,array('class'=>'form-control','readonly'=>'','disabled' =>'disabled')) }}
								@else
									{{Form::select('tipo',$tipo_actas,$documento_info->idtipo_acta,array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
								@endif
							</div>
							<div class="form-group col-md-4 @if($errors->first('proveedor')) has-error has-feedback @endif">
								{{ Form::label('proveedor','Proveedor') }}
								@if($documento_info->deleted_at)
									{{Form::select('proveedor',array('0'=> 'Seleccione')+$proveedores,$documento_info->idproveedor,array('class'=>'form-control','readonly'=>'','disabled'=>'disabled')) }}
								@else
									{{Form::select('proveedor',array('0'=> 'Seleccione')+$proveedores,$documento_info->idproveedor,array('class'=>'form-control','disabled'=>'disabled')) }}
								@endif
							</div>
							<div class="col-md-4">
								{{ Form::label('fecha','Fecha')}}<span style="color:red"> *</span>
								{{ Form::text('fecha',date('d-m-Y',strtotime($documento_info->fecha_acta)),array('class'=>'form-control','readonly'=>'')) }}
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
							<div class="form-group col-md-4">
								{{ Form::label('nombre_acta','Documento') }}
								{{ Form::text('nombre_acta',Input::old('nombre_acta'),['class' => 'form-control','id'=>'nombre_acta','disabled'=>'disabled'])}}
							</div>	
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