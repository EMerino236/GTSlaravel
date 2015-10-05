@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reportes de Incumplimiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
	{{ Form::open(array('url'=>'/solicitudes_compra/search_solicitudes','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
		<div class="searchbar">
			<div class="row">
				<div class="col-xs-4">
					<div class="form-group row">
						{{ Form::label('search_tipo_solicitud','Tipo:')}}
						{{ Form::select('search_tipo_solicitud',array('0' => 'Seleccione')+$tipos, $search_tipo_solicitud,array('class'=>'form-control')) }}
					</div>
					<div class="form-group row">
						{{ Form::label('search_marca','Marca:')}}
						{{ Form::select('search_marca',array('0' => 'Seleccione')+$marcas, $search_marca,array('class'=>'form-control')) }}
					</div>
					<div class="form-group row">
						{{ Form::label('search_nombre_equipo','Nombre de Equipo:')}}
						{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Ingrese Nombre de Equipo')) }}
					</div>
					<div class="form-group row">
						{{ Form::label('search_modelo','Modelo:')}}
						{{ Form::text('search_modelo',$search_modelo,array('class'=>'form-control','placeholder'=>'Ingrese Nombre del Modelo')) }}
					</div>
				</div>
				<div class="col-xs-1"></div>
				<div class="col-xs-4">
					<div class="form-group row">
						{{ Form::label('search_serie','Número de Serie:')}}
						{{ Form::text('search_serie',$search_serie,array('class'=>'form-control','placeholder'=>'Ingrese Número de Serie')) }}
					</div>
					<div class="form-group row">
						{{ Form::label('search_departamento','Departamento:')}}
						{{ Form::select('search_departamento',array('0' => 'Seleccione')+$departamentos, $search_departamento,array('class'=>'form-control','id'=>'departamento',"onchange"=>"fill_select_servicio_clinico()")) }}
					</div>
					<div class="form-group row">
						{{ Form::label('search_servicio','Servicio Clínico:')}}
						{{ Form::select('search_servicio',array('0' => 'Seleccione')+$servicios, $search_servicio,array('class'=>'form-control','id'=>'servicio_clinico')) }}
					</div>
					<div class="form-group row">
						{{ Form::label('search_estado','Estado:')}}
						{{ Form::select('search_estado',array('0' => 'Seleccione')+$estados, $search_estado,array('class'=>'form-control')) }}
					</div>
				</div>			
			</div>	
			<div class="row">
				<div class="form-group col-xs-4" style="margin-top:25px">	
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}			
				</div>
			</div>			
	{{ Form::close() }}
	</br>
	<table class="table">
		<tr class="info">
			<th>Tipo</th>
			<th>Descripción</th>
			<th>Número de Requerimiento</th>
			<th>Nombre de Equipo</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Serie</th>
			<th>Cantidad</th>
			<th>Departamento</th>
			<th>Servicio Clínico</th>
			<th>Número OT</th>
			<th>Reporte que certifique la necesidad</th>
			<th>Estado</th>	
		</tr>
	</table>
@stop