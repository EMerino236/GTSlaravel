@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reportes de Incumplimiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    {{ Form::open(array('url'=>'/reportes_incumplimiento/search_reporte','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	
		<div class="searchbar">
			<div class="row">
				<div class="form-group col-xs-2">
					{{ Form::label('fecha_desde','Fecha Desde:')}}
					<div id="datetimepicker1" class="form-group input-group date">					
						{{ Form::text('fecha_desde',$fecha_desde,array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
	        	</div>
	        	<div class="form-group col-xs-2">
				{{ Form::label('fecha_hasta','Fecha Hasta:')}}
					<div id="datetimepicker2" class="form-group input-group date">					
								{{ Form::text('fecha_hasta',$fecha_hasta,array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
					</div>
				</div>
				<div class="form-group col-xs-2">					
					{{ Form::label('search_proveedor','Proveedor:')}}
					{{ Form::select('search_proveedor',array('0' => 'Seleccione')+$proveedor, $search_proveedor,array('class'=>'form-control')) }}
				</div>
				<div class="form-group col-xs-2">
					{{ Form::label('search_tipo_reporte','Tipo Reporte:')}}
					{{ Form::select('search_tipo_reporte',['0'=>'Seleccione', '1'=>'Por Servicio','2'=>'Por Equipo'], $search_tipo_reporte,array('class'=>'form-control')) }}
				</div>
				<div class="form-group col-xs-4" style="margin-top:25px">	
					{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}			
				</div>
			</div>	
				
			
	{{ Form::close() }}</br>
 	<div class="row">
		<table class="table">
			<tr class="info">
				<th>N°</th>
				<th>Código de Reporte</th>
				<th>Fecha de Registro</th>
				<th>Servicio</th>
				<th>Proveedor</th>
			</tr>
			@foreach($reportes_data as $index => $reporte_data)
				<tr>
					<td>{{$index+1}}</td>
					<td>
						<a href="{{URL::to('/reportes_incumplimiento/edit_reporte/')}}/{{$reporte_data->idreporte_incumplimiento}}">
						{{$reporte_data->idreporte_incumplimiento}}
						</a>
					</td>
					
					<td>{{$reporte_data->created_at}}</td>
					<td>{{$reporte_data->nomb_servicio}}</td>
					<td>{{$reporte_data->nomb_proveedor}}</td>
				</tr>
			@endforeach				
		</table>
	</div>
	<div class="row">
		<a class="btn btn-primary" href="{{URL::to('/reportes_incumplimiento/create_reporte/')}}">Crear</a>
	</div>
	
@stop