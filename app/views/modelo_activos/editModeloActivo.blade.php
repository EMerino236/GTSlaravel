@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-md-12">
            <h3 class="page-header">Editar Modelo: <strong>{{$familia_activo_info->nombre_equipo}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_modelo') }}</strong></p>			
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif

	{{ Form::open(array('url'=>'familia_activos/submit_edit_modelo_familia_activo', 'role'=>'form')) }}
	{{ Form::hidden('familia_activo_id',$familia_activo_info->idfamilia_activo)}}
	{{ Form::hidden('modelo_id', $modelo_info->idmodelo_equipo) }}
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">
			  		<div class="row">
			  			<div class="form-group col-md-6 @if($errors->first('nombre_modelo')) has-error has-feedback @endif">
							{{ Form::label('nombre_modelo','Modelo') }}<span style="color:red">*</span>
							{{ Form::text('nombre_modelo',$modelo_info->nombre,array('class'=>'form-control')) }}
						</div>
			  		</div>
				</div>
			</div>			

			<div class="container-fluid row">				
				<div class="form-group col-md-2 col-md-offset-6">				
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
				</div>
				<div class="form-group col-md-2 ">
					<div class="btn btn-danger btn-block" id="btnEliminar"><span class="glyphicon glyphicon-trash"></span> Eliminar</div>
				</div>
				<div class="form-group col-md-2">
					<a class="btn btn-default btn-block" href="{{URL::to('/familia_activos/edit_familia_activo')}}/{{$familia_activo_info->idfamilia_activo}}">Cancelar</a>				
				</div>
			</div>
	{{ Form::close() }}
@stop