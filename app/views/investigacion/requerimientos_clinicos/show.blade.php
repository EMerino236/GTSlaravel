@extends('templates/investigacionTemplate')
@section('content')

	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Requerimiento Clínico y Hospitalario: {{$requerimiento->codigo}}</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Información del proyecto</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('nombre','Nombre') }}
					{{ Form::text('nombre', $requerimiento->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('categoria','Categoría') }}
					{{ Form::text('categoria', $requerimiento->categoria->nombre, ['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('departamento','Departamento') }}
					{{ Form::text('departamento', $requerimiento->departamento->nombre,['class'=>'form-control','readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('servicio_clinico','Servicio Clínico') }}
					{{ Form::text('servicio_clinico', $requerimiento->servicio->nombre, ['class'=>'form-control', 'readonly']) }}
				</div>

				<div class="form-group col-md-4">
					{{ Form::label('responsable','Responsable') }}
					{{ Form::text('responsable',$requerimiento->responsable->UserFullName,['class'=>'form-control','readonly'])}}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('presupuesto','Presupuesto Total') }}
					{{ Form::number('presupuesto',$requerimiento->presupuesto,['class'=>'form-control','step'=>'0.01','min'=>'0','readonly'])}}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('tipo','Tipo') }}
					{{ Form::text('tipo',$tipos[$requerimiento->tipo],array('class'=>'form-control','readonly')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('fecha_ini','Fecha Inicio') }}
					{{ Form::text('fecha_ini',$requerimiento->fecha_ini,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
				<div class="form-group col-md-4">
					{{ Form::label('fecha_fin','Fecha Fin') }}
					{{ Form::text('fecha_fin',$requerimiento->fecha_fin,array('class'=>'form-control', 'readonly'=>'')) }}
				</div>
			</div>

			<div class="row">
				<div class="form-group col-md-12">
					{{ Form::label('observaciones','Observaciones') }}
					{{ Form::textarea('observaciones',$requerimiento->observaciones,['class'=>'form-control','rows'=>5,'readonly'])}}
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Estado del proyecto</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-4">
					{{ Form::label('estado','Estado') }}
					{{ Form::text('estado', $estados[$requerimiento->id_estado], ['class'=>'form-control','readonly']) }}
				</div>
				@if($requerimiento->id_modificador)
				<div class="form-group col-md-4">
					{{ Form::label('modificador','Modificado por:') }}
					{{ Form::text('modificador',$usuarios[$requerimiento->id_modificador],['class'=>'form-control','readonly'])}}				
				</div>
				@endif
			</div>

			<div class="row">
				<div class="form-group col-md-8">
					{{ Form::label('observaciones','Observaciones') }}
					{{ Form::textarea('observaciones',$requerimiento->observaciones,['class'=>'form-control','rows'=>5,'readonly'])}}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		@if($user->id == $requerimiento->id_responsable && (!$requerimiento->id_modificador || $requerimiento->id_estado == 3))
		
			<div class="form-group col-md-2">
				<a href="{{URL::to('/requerimientos_clinicos/edit')}}/{{$requerimiento->id}}">
					{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Editar', array('class' => 'btn btn-primary btn-block')) }}
				</a>
			</div>
		
		@endif

		<div class="form-group col-md-2">
			<a class="btn-under" href="{{route('requerimientos_clinicos.export',$requerimiento->id)}}">
				{{ Form::button('<span class="glyphicon glyphicon-export"></span> Exportar', array('id'=>'exportar','class' => 'btn btn-success btn-block')) }}
			</a>
		</div>
	</div>
@stop