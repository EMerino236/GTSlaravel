@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Editar Competencia</h3>
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
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach		
		</div>
	@endif

	{{ Form::open(array('route'=>'capacitacion.update_competencia', 'role'=>'form','files'=>'true')) }}		
		{{Form::hidden('id_competencia',$competencia->id)}}
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos Generales
	  	</div>

	  	<div class="panel-body">	
			<div class="form-group row">
				<div class="col-md-6 @if($errors->first('nombre')) has-error has-feedback @endif">
					{{ Form::label('nombre','Competencia Generada') }}<span style='color:red'>*</span>
					{{ Form::text('nombre',$competencia->nombre,['class' => 'form-control'])}}						
				</div>					
				<div class="col-md-6 @if($errors->first('indicador')) has-error has-feedback @endif">
					{{ Form::label('indicador','Indicador de logro') }}<span style='color:red'>*</span>
					{{ Form::text('indicador',$competencia->indicador,['class' => 'form-control'])}}	
				</div>
			</div>
			
		</div>
	</div>

	<div class="container-fluid row">
		<div class="form-group col-md-2">				
			{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span>  Editar', array('id'=>'submit-create', 'type' => 'submit', 'class' => 'btn btn-primary btn-block', 'style' => '145px')) }}
		</div>
		<div class="form-group col-md-2  col-md-offset-8">
			<a class="btn btn-default btn-block" style="width:145px" href="{{URL::to('/capacitacion/show_competencias')}}/{{$competencia->id_sesion}}">Cancelar</a>				
		</div>
	</div>
	{{ Form::close() }}

	<script type="text/javascript">

		$( document ).ready(function(){

			habilitaCampos();

			
		});


	</script>
@stop