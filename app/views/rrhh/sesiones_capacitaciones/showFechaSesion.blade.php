@extends('templates/recursosHumanosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Sesión N° {{$sesion->numero_sesion}}</h3>
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
			@foreach($errors->all() as $error)
				<p><strong>{{ $error }}</strong></p>
			@endforeach		
		</div>
	@endif

		{{Form::hidden('id_sesion',$sesion->id)}}
	<div class="panel panel-default">
	  	<div class="panel-heading">
	  		Datos Generales
	  	</div>
	  	<div class="panel-body">	
			<div class="form-group row">
				<div class="col-md-4 col-md-offset-2 @if($errors->first('fecha')) has-error has-feedback @endif">
					{{ Form::label('fecha','Fecha') }}<span style="color:red">*</span>
					@if($sesion->fecha == null)
						{{ Form::text('fecha',null,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('fecha',date('d-m-Y',strtotime($sesion->fecha)),array('class'=>'form-control','readonly'=>'')) }}
					@endif				
				</div>		
				<div class="col-md-4 @if($errors->first('hora_inicio')) has-error has-feedback @endif">
					{{ Form::label('hora_inicio','Hora Inicio:') }}<span style="color:red">*</span>
					@if($sesion->fecha == null)
						{{ Form::text('fecha',null,array('class'=>'form-control','readonly'=>'')) }}
					@else
						{{ Form::text('hora_inicio',date('H:i',strtotime($sesion->hora_inicio)),array('class'=>'form-control','readonly'=>'')) }}
					@endif
				</div>
			</div>	
		</div>
	</div>

	<div class="container-fluid row">
		<div class="form-group col-md-2">				
			<a class="btn btn-default btn-primary" style="width:145px" href="{{URL::to('/capacitacion/edit_fecha_sesion')}}/{{$sesion->id}}"><span class="glyphicon glyphicon-floppy-disk"></span> Editar</a>		
		</div>
		<div class="form-group col-md-2 col-md-offset-8">
			<a class="btn btn-default btn-block" style="width:145px" href="{{URL::to('/capacitacion/show_sesiones')}}/{{$sesion->id_capacitacion}}">Regresar</a>				
		</div>
	</div>

	<script type="text/javascript">

		$( document ).ready(function(){


			
		});


	</script>
@stop