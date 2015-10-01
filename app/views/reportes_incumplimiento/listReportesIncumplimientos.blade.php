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
						{{ Form::text('fecha_desde',Input::old('fecha_desde'),array('class'=>'form-control','readonly'=>'')) }}
						<span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
	        	</div>
	        	<div class="form-group col-xs-2">
				{{ Form::label('fecha_hasta','Fecha Hasta:')}}
					<div id="datetimepicker2" class="form-group input-group date">					
								{{ Form::text('fecha_hasta',Input::old('fecha_hasta'),array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
					</div>
				</div>
				<div class="form-group col-xs-2">					
					{{ Form::label('proveedor','Proveedor:')}}
					{{ Form::select('proveedor',$proveedor, Input::old('idproveedor'),array('class'=>'form-control')) }}
				</div>
				<div class="form-group col-xs-2">
					{{ Form::label('tipo_reporte','Tipo Reporte:')}}
					{{ Form::select('tipo_reporte',['0'=>'--Seleccione--', '1'=>'Por Servicio','2'=>'Por Equipo'], Input::old('idtipo_reporte'),array('class'=>'form-control')) }}
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
							
		</table>
	</div>
	<div class="row">
		<a class="btn btn-primary" href="{{URL::to('/reportes_incumplimiento/create_reporte/')}}">Crear</a>
	</div>
	@if($search)
		{{ $areas_data->appends(array('search' => $search))->links() }}
	@else	
		{{ $areas_data->links()}}
	@endif
@stop