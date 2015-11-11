@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Crear Nueva Marca</h3>
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
		<div class="alert alert-success alert-dissmisable">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			{{ Session::get('error') }}
		</div>
	@endif

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
			<p><strong>{{ $errors->first('nombre_marca') }}</strong></p>
		</div>
	@endif	

	{{ Form::open(array('url'=>'marcas/submit_create_marca', 'role'=>'form-group')) }}
		
	<div class="panel panel-default">
  		<div class="panel-heading">Datos Generales</div>
  		<div class="panel-body">
			<div class="form-group col-xs-4 @if($errors->first('nombre_marca')) has-error has-feedback @endif">
				{{ Form::label('nombre_marca','Nombre de Marca') }}<span style="color:red">*</span>
				{{ Form::text('nombre_marca',Input::old('nombre_marca'),array('class'=>'form-control')) }}
			</div>
		</div>
	</div>
	
	<div class="container-fluid row">
		<div class="form-group col-md-2 col-md-offset-8">				
			{{ Form::button('<span class="glyphicon glyphicon-plus"></span> Crear', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}
		</div>
		<div class="form-group col-md-2">
			<a class="btn btn-default btn-block" href="{{URL::to('/marcas/list_marcas')}}">Cancelar</a>				
		</div>
	</div>		
	{{ Form::close() }}
@stop