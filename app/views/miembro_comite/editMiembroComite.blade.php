@extends('templates/adquisicionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Miembros de Comité</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('idpresidente') }}</strong></p>
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger"><strong>{{ Session::get('error') }}</strong></div>
	@endif

	{{ Form::open(array('url'=>'miembro_comite/submit_edit_miembro_comite', 'role'=>'form', 'files'=>true)) }}
		{{ Form::hidden('idexpediente_tecnico',$expediente_tecnico_data->idexpediente_tecnico)}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Datos de los miembros de comité</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-4 @if($errors->first('codigo_compra')) has-error has-feedback @endif">
						{{ Form::label('codigo_compra','Código de Compra') }}
						{{ Form::text('codigo_compra',$expediente_tecnico_data->codigo_compra,['disabled'=>'','class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-3 @if($errors->first('usuario_presidente')) has-error has-feedback @endif">
						{{ Form::label('usuario_presidente','Presidente',array('id'=>'usuario_presidente_label')) }}<span style='color:red'>*</span>
						 @if($presidente_data != null)
							{{ Form::text('usuario_presidente',$presidente_data->username,array('placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>20)) }}
							{{ Form::hidden('idpresidente',$presidente_data->id)}}
						@else
							{{ Form::text('usuario_presidente',Input::old('usuario_presidente'),array('placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>20)) }}
							{{ Form::hidden('idpresidente')}}
						@endif
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_miembro_comite(1)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
						<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_miembro_comite(1)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_presidente')) has-error has-feedback @endif">
						{{ Form::label('nombre_presidente','Nombre de Presidente',array('id'=>'nombre_presidente_label')) }}
						@if($presidente_data != null)
							{{ Form::text('nombre_presidente',$presidente_data->apellido_pat.' '.$presidente_data->apellido_mat.' '.$presidente_data->nombre,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('nombre_presidente',Input::old('nombre_presidente'),array('class'=>'form-control','readonly'=>'')) }}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-3 @if($errors->first('usuario_miembro1')) has-error has-feedback @endif">
						{{ Form::label('usuario_miembro1','Miembro 1',array('id'=>'usuario_miembro1_label')) }}
						 @if($miembro1_data != null)
							{{ Form::text('usuario_miembro1',$miembro1_data->username,array('placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>20)) }}
							{{ Form::hidden('idmiembro1',$miembro1_data->id)}}
						@else
							{{ Form::text('usuario_miembro1',Input::old('usuario_miembro1'),array('placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>20)) }}
							{{ Form::hidden('idmiembro1')}}
						@endif
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_miembro_comite(2)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
						<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_miembro_comite(2)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_miembro1')) has-error has-feedback @endif">
						{{ Form::label('nombre_miembro1','Nombre de Miembro 1',array('id'=>'nombre_miembro1_label')) }}
						@if($miembro1_data != null)
							{{ Form::text('nombre_miembro1',$miembro1_data->apellido_pat.' '.$miembro1_data->apellido_mat.' '.$miembro1_data->nombre,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('nombre_miembro1',Input::old('nombre_miembro1'),array('class'=>'form-control','readonly'=>'')) }}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-3 @if($errors->first('usuario_miembro2')) has-error has-feedback @endif">
						{{ Form::label('usuario_miembro2','Miembro 2',array('id'=>'usuario_miembro2_label')) }}
						 @if($miembro2_data != null)
							{{ Form::text('usuario_miembro2',$miembro2_data->username,array('placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>20)) }}
							{{ Form::hidden('idmiembro2',$miembro2_data->id)}}
						@else
							{{ Form::text('usuario_miembro2',Input::old('usuario_miembro2'),array('placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>20)) }}
							{{ Form::hidden('idmiembro2')}}
						@endif
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_miembro_comite(3)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
						<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_miembro_comite(3)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_miembro2')) has-error has-feedback @endif">
						{{ Form::label('nombre_miembro2','Nombre de Miembro 2',array('id'=>'nombre_miembro2_label')) }}
						@if($miembro2_data != null)
							{{ Form::text('nombre_miembro2',$miembro2_data->apellido_pat.' '.$miembro2_data->apellido_mat.' '.$miembro2_data->nombre,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('nombre_miembro2',Input::old('nombre_miembro2'),array('class'=>'form-control','readonly'=>'')) }}
						@endif
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-3 @if($errors->first('usuario_miembro3')) has-error has-feedback @endif">
						{{ Form::label('usuario_miembro3','Miembro 3',array('id'=>'usuario_miembro3_label')) }}
						 @if($miembro3_data != null)
							{{ Form::text('usuario_miembro3',$miembro3_data->username,array('placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>20)) }}
							{{ Form::hidden('idmiembro3',$miembro3_data->id)}}
						@else
							{{ Form::text('usuario_miembro3',Input::old('usuario_miembro3'),array('placeholder'=>'Nombre de usuario','class'=>'form-control','maxlength'=>20)) }}
							{{ Form::hidden('idmiembro3')}}
						@endif
					</div>
					<div class="form-group col-md-2" style="margin-top:25px">
						<a id="btn_agregar" class="btn btn-primary btn-block" onclick="llenar_nombre_miembro_comite(4)"><span class="glyphicon glyphicon-plus"></span> Agregar</a>
					</div>
					<div class="form-group col-md-2" style="margin-top:25px; margin-left:15px">
						<a id="btn_limpiar" class="btn btn-default btn-block" onclick="limpiar_nombre_miembro_comite(4)"><span class="glyphicon glyphicon-refresh"></span> Limpiar</a>
					</div>
					<div class="form-group col-md-4 @if($errors->first('nombre_miembro3')) has-error has-feedback @endif">
						{{ Form::label('nombre_miembro3','Nombre de Miembro 3',array('id'=>'nombre_miembro3_label')) }}
						@if($miembro3_data != null)
							{{ Form::text('nombre_miembro3',$miembro3_data->apellido_pat.' '.$miembro3_data->apellido_mat.' '.$miembro3_data->nombre,array('class'=>'form-control','readonly'=>'')) }}
						@else
							{{ Form::text('nombre_miembro3',Input::old('nombre_miembro3'),array('class'=>'form-control','readonly'=>'')) }}
						@endif
					</div>
				</div>
			</div>
		</div>		
		<div class="row">
			<div class="form-group col-md-2">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit_create', 'type'=>'submit','class' => 'btn btn-primary btn-block')) }}
			</div>
			<div class="form-group col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/miembro_comite/list_miembro_comites/')}}"><span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
			</div>
		</div>
	{{ Form::close() }}

@stop