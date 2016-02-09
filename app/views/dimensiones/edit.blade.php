@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Dimensión: <strong>{{$dimension->nombre}}</strong></h3>
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
			<p><strong>{{ $errors->first('nombre') }}</strong></p>
		</div>
	@endif

	{{ Form::open(array('route'=>['dimensiones.edit',$dimension->id], 'role'=>'form')) }}
		<div class="row">
			<div class="panel panel-default">
			  	<div class="panel-heading">Datos Generales</div>
			  	<div class="panel-body">	
					<div class="row">								
						<div class="form-group col-md-4 @if($errors->first('nombre')) has-error has-feedback @endif">
							{{ Form::label('nombre_grupo','Nombre del Grupo') }}<span style="color:red">*</span>
							@if($dimension->deleted_at)
								{{ Form::text('nombre',$dimension->nombre,array('class'=>'form-control','readonly'=>'','maxlength'=>'100')) }}
							@else
								{{ Form::text('nombre',$dimension->nombre,array('class'=>'form-control','maxlength'=>'100')) }}
							@endif
						</div>
					</div>
				</div>			
			</div>
		</div>

		<div class="row">
			@if(!$dimension->deleted_at)
			<div class="col-md-2 form-group">
				{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('id'=>'submit-edit', 'type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}						
			</div>
			@endif
			<div class="col-md-2 form-group">
				<a class="btn btn-default btn-block" href="{{route('dimensiones.index')}}">Cancelar</a>
			</div>
		
	{{ Form::close() }}

		
		@if($dimension->deleted_at)
			<div class="form-group col-md-2 col-md-offset-8">
				<a style="text-decoration: none" href="{{route('dimensiones.restore',$dimension->id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-up"></span> Habilitar', array('class' => 'btn btn-success btn-block')) }}
				</a>
			</div>
		@else
			<div class="form-group col-md-2 col-md-offset-6">
				<a style="text-decoration: none" href="{{route('dimensiones.destroy',$dimension->id)}}">
					{{ Form::button('<span class="glyphicon glyphicon-circle-arrow-down"></span> Inhabilitar', array('class' => 'btn btn-danger btn-block')) }}
				</a>
			</div>
		@endif
		</div>
@stop