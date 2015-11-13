@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Proveedor: <strong>{{$proveedor_info->razon_social}}</strong></h3>
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
			<p><strong>{{ $errors->first('proveedor_ruc') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor_razon_social') }}</strong></p>
			<p><strong>{{ $errors->first('proveedor_nombre_contacto') }}</strong></p>			
			<p><strong>{{ $errors->first('telefono') }}</strong></p>
			<p><strong>{{ $errors->first('email') }}</strong></p>
		</div>
	@endif
	
	<div class="panel panel-default">
		<div class="panel-heading">Datos Generales</div>
		<div class="panel-body">
			<div class="form-group row">
				<div class="form-group col-md-4 @if($errors->first('proveedor_ruc')) has-error has-feedback @endif">
				{{ Form::label('proveedor_ruc','RUC') }}
				{{ Form::text('proveedor_ruc',$proveedor_info->ruc,array('class'=>'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('proveedor_razon_social')) has-error has-feedback @endif">					
				{{ Form::label('proveedor_razon_social','Razón Social') }}
				{{ Form::text('proveedor_razon_social',$proveedor_info->razon_social,array('class'=>'form-control','readonly'=>'')) }}
				</div>
			</div>
			<div class="form-group row">
				<div class="form-group col-md-4 @if($errors->first('proveedor_nombre_contacto')) has-error has-feedback @endif">
					{{ Form::label('proveedor_nombre_contacto','Nombre del contácto') }}
					{{ Form::text('proveedor_nombre_contacto',$proveedor_info->nombre_contacto,array('class'=>'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('telefono')) has-error has-feedback @endif">
					{{ Form::label('telefono','Teléfono') }}
					{{ Form::text('telefono',$proveedor_info->telefono,array('class'=>'form-control','readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4 @if($errors->first('email')) has-error has-feedback @endif">
					{{ Form::label('email','E-mail') }}
					{{ Form::text('email',$proveedor_info->email,array('class'=>'form-control','readonly'=>'')) }}
				</div>							
			</div>				
		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading">Soporte Técnico</div>
		<div class="panel-body">
			<div class="table-responsive">
				<div class="table-responsive">
				<table class="table">
					<tr class="info">						
						<th class="text-nowrap text-center">Nº</th>						
						<th class="text-nowrap text-center">Tipo de Documento</th>
						<th class="text-nowrap text-center">Número de Documento</th>
						<th class="text-nowrap text-center">Nombre</th>
						<th class="text-nowrap text-center">Apellido Paterno</th>
						<th class="text-nowrap text-center">Apellido Materno</th>						
						<th class="text-nowrap text-center">Especialidad</th>
						<th class="text-nowrap text-center">Teléfono</th>				
						<th class="text-nowrap text-center">E-mail</th>
						<th class="text-nowrap text-center">Editar</th>
						<th class="text-nowrap text-center">Eliminar</th>											
					</tr>
					@foreach($soportes_tecnico_data as $index => $soporte_tecnico)
					<tr class="@if($soporte_tecnico->deleted_at) bg-danger @endif">			
						<td class="text-nowrap text-center">
							{{$index + 1}}
						</td>
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->tipo_documento}}
						</td>
						<td class="text-nowrap text-center">
							<a href="{{URL::to('/proveedores/view_soporte_tecnico_proveedor')}}/{{$soporte_tecnico->idsoporte_tecnico}}">{{$soporte_tecnico->numero_doc_identidad}}</a>							
						</td>	
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->nombres}}
						</td>
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->apellido_pat}}
						</td>
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->apellido_mat}}
						</td>											
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->especialidad}}
						</td>
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->telefono}}
						</td>
						<td class="text-nowrap text-center">
							{{$soporte_tecnico->email}}
						</td>
						<td>
							<a class="btn btn-warning btn-block btn-sm" href="{{URL::to('/proveedores/edit_soporte_tecnico_proveedor/')}}/{{$soporte_tecnico->idsoporte_tecnico}}">
							<span class="glyphicon glyphicon-pencil"></span> Editar</a>
						</td>											
						<td>
							<button class="btnEliminarSoporteTecnicoProveedor btn btn-danger btn-block btn-sm" data-value="{{$soporte_tecnico->idsoporte_tecnico}}">
							<span class="glyphicon glyphicon-trash"></span> Eliminar</button>
						</td>
					</tr>
					@endforeach							
				</table>
				</div>
			</div>
								
		</div>				
	</div>
	

		<div class="container-fluid row">			
			<div class="form-group col-md-offset-10 col-md-2">
				<a class="btn btn-default btn-block" href="{{URL::to('/proveedores/list_proveedores')}}">
				<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>				
			</div>
		</div>		
	{{ Form::close() }}

<div id="modal_delete_soporte_tecnico_proveedor" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ADVERTENCIA</h4>
      </div>
      <div class="modal-body">
        <p>¿Está seguro que desea eliminar el Soporte Técnico?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="modal_btnEliminarSoporteTecnicoProveedor btn btn-danger">Eliminar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop