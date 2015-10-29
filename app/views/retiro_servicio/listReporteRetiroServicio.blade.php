@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Reportes de Retiro de Servicios</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    {{ Form::open(array('url'=>'/retiro_servicio/search_reporte_retiro_servicio','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Búsqueda</h3>
			</div>
			<div class="panel-body">
			<div class="search_bar">
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_motivo','Motivo') }}
							{{ Form::select('search_motivo', $motivos,Input::old('search_motivo'),['class' => 'form-control']) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_cod_pat','Código patrimonial') }}
							{{ Form::text('search_cod_pat',$search_cod_pat,array('class'=>'form-control')) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_equipo','Equipo relacionado') }}
							{{ Form::text('search_equipo',$search_equipo,array('class'=>'form-control')) }}
						</div>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_marca','Marca') }}
							{{ Form::select('search_marca', $marcas,Input::old('search_marca'),['class' => 'form-control']) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_servicio','Servicio') }}
							{{ Form::select('search_servicio', $servicios,Input::old('search_servicio'),['class' => 'form-control']) }}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::label('search_proveedor','Proveedor') }}
							{{ Form::select('search_proveedor', $proveedores,Input::old('search_proveedor'),['class' => 'form-control']) }}
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="row">
						<div class="form-group col-xs-8">
							{{ Form::submit('Buscar',array('id'=>'submit-search-form','class'=>'btn btn-info')) }}
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>	
	{{ Form::close() }}</br>

	<table class="table">
		<tr class="info">
			<th>Código Patrimonial</th>
			<th>Nombre de Equipo</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Serie</th>
			<th>Código de Reporte de Retiro</th>
			<th>Proveedor</th>
			<th>Motivo</th>
			<th>Programar OT</th>
		</tr>
			@foreach($reporte_retiros_data as $reporte_retiro_data)
			<tr>
				<td>
					{{$reporte_retiro_data->codigo_patrimonial}}
				</td>
				<td>
					{{$reporte_retiro_data->nombre_equipo}}
				</td>
				<td>
					{{$reporte_retiro_data->nombre_marca}}
				</td>
				<td>
					{{$reporte_retiro_data->nombre_modelo}}
				</td>
				<td>
					{{$reporte_retiro_data->numero_serie}}
				</td>
				<td><a href="{{URL::to('/mant_correctivo/create_ot/')}}/{{$reporte_retiro_data->idmotivo_retiro}}">{{$reporte_retiro_data->idmotivo_retiro}}</a>
				</td>
				<td>
					{{$reporte_retiro_data->nombre_proveedor}}
				</td>
				<td>
					{{$reporte_retiro_data->nombre_motivo}}
				</td>
			</tr>
			@endforeach
	</table>
	@if($search_motivo || $search_cod_pat || $search_equipo || $search_marca || $search_servicio || $search_proveedor || $search_servicio)
		{{ $reporte_retiros_data->appends(array('search_motivo' => $search_motivo,'search_cod_pat'=>$search_cod_pat,'search_equipo'=>$search_equipo,'search_marca'=>$search_marca,'search_servicio'=>$search_servicio,'search_cod_pat'=>$search_proveedor,'search_servicio'=>$search_servicio))->links() }}
	@else
		{{ $reporte_retiros_data->links() }}
	@endif
@stop