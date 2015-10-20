@extends('templates/configuracionesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Modelo: <strong>{{$modelo_equipo_info->nombre}}</strong></h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>

	@if ($errors->has())
		<div class="alert alert-danger" role="alert">
		</div>
	@endif

	@if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
	@if (Session::has('error'))
		<div class="alert alert-danger">{{ Session::get('error') }}</div>
	@endif	
		
		<div class="panel panel-default">
		  	<div class="panel-heading">Accesorios</div>
		  	<div class="panel-body">
			  	<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th>Nº</th>
						<th>Numero de Pieza</th>
						<th>Nombre</th>
						<th>Modelo</th>				
						<th>Costo (S/.)</th>						
					</tr>
					@foreach($accesorios_info as $index => $accesorio_info)
					<tr>
						<td>
							{{$index + 1}}
						</td>
						<td>
							{{$accesorio_info->numero_pieza}}
						</td>
						<td>
							{{$accesorio_info->nombre}}
						</td>
						<td>
							{{$accesorio_info->modelo}}
						</td>
						<td>
							{{number_format($accesorio_info->costo,2)}}
					</tr>
					@endforeach
				</table>
			</div>
			</div>
		</div>

		<div class="panel panel-default">
		  	<div class="panel-heading">Componente</div>
		  	<div class="panel-body">
			  	<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th>Nº</th>
						<th>Numero de Pieza</th>
						<th>Nombre</th>
						<th>Modelo</th>				
						<th>Costo (S/.)</th>						
					</tr>
					@foreach($componentes_info as $index => $componente_info)
					<tr>
						<td>
							{{$index + 1}}
						</td>
						<td>
							{{$componente_info->numero_pieza}}
						</td>
						<td>
							{{$componente_info->nombre}}
						</td>
						<td>
							{{$componente_info->modelo}}
						</td>
						<td>
							{{number_format($componente_info->costo,2)}}
						</td>						
					</tr>
					@endforeach
				</table>
			</div>
			</div>
		</div>
				
		<div class="panel panel-default">
		  	<div class="panel-heading">Consumible</div>
		  	<div class="panel-body">
			  	<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th>Nº</th>
						<th>Nombre</th>
						<th>Cantidad</th>				
						<th>Costo (S/.)</th>						
					</tr>
					@foreach($consumibles_info as $index => $consumible_info)
					<tr>
						<td>
							{{$index + 1}}
						</td>
						<td>
							{{$consumible_info->nombre}}
						</td>
						<td>
							{{$consumible_info->cantidad}}
						</td>
						<td>
							{{number_format($consumible_info->costo,2)}}
						</td>						
					</tr>
					@endforeach
				</table>
				</div>
			</div>
		</div>


		<div class="container-fluid row">
			<div class="form-group col-md-offset-10 col-md-2">				
				<a class="btn btn-default btn-block" href="{{URL::to('/familia_activos/list_familia_activos')}}">
				<span class="glyphicon glyphicon-menu-left"></span> Regresar</a>
			</div>
		</div>

	{{ Form::close() }}	
@stop