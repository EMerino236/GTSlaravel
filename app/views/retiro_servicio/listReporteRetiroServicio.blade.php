@extends('templates/reporteRetiroTemplate')
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
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_cod_pat','Código patrimonial') }}
						{{ Form::text('search_cod_pat',$search_cod_pat,array('class'=>'form-control','placeholder'=>'Ingrese código patrimonial')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_equipo','Equipo relacionado') }}
						{{ Form::text('search_equipo',$search_equipo,array('class'=>'form-control','placeholder'=>'Ingrese nombre de equipo')) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_motivo','Motivo') }}
						{{ Form::select('search_motivo',array('0'=>'Seleccione')+ $motivos,Input::old('search_motivo'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						{{ Form::label('search_marca','Marca') }}
						{{ Form::select('search_marca',array('0'=>'Seleccione')+  $marcas,Input::old('search_marca'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_servicio','Servicio') }}
						{{ Form::select('search_servicio',array('0'=>'Seleccione')+  $servicios,Input::old('search_servicio'),['class' => 'form-control']) }}
					</div>
					<div class="form-group col-md-4">
						{{ Form::label('search_proveedor','Proveedor') }}
						{{ Form::select('search_proveedor',array('0'=>'Seleccione')+  $proveedores,Input::old('search_proveedor'),['class' => 'form-control']) }}
					</div>
				</div>
				<div class="container-fluid form-group row">
					<div class="col-md-2 col-md-offset-8">
					{{ Form::button('<span class="glyphicon glyphicon-search"></span> Buscar', array('id'=>'submit-search-form','type' => 'submit', 'class' => 'btn btn-primary btn-block')) }}	
					</div>
					<div class="col-md-2">
						<div class="btn btn-default btn-block" id="btnLimpiar"><span class="glyphicon glyphicon-refresh"></span> Limpiar</div>				
					</div>					
				</div>				
			</div>	
		</div>
	</div>	
	{{ Form::close() }}
	<div class="container-fluid form-group row">
		<div class="col-md-4 col-md-offset-8">
    		<a class="btn btn-primary btn-block" href="{{URL::to('/retiro_servicio/create_reporte_retiro_servicio')}}">
			<span class="glyphicon glyphicon-plus"></span> Agregar Reporte</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Código de Reporte</th>
						<th class="text-nowrap text-center">Código Patrimonial</th>
						<th class="text-nowrap text-center">Nombre de Equipo</th>
						<th class="text-nowrap text-center">Marca</th>
						<th class="text-nowrap text-center">Modelo</th>
						<th class="text-nowrap text-center">Serie</th>
						<th class="text-nowrap text-center">Proveedor</th>
						<th class="text-nowrap text-center">Motivo</th>
						<th class="text-nowrap text-center">Programar OT</th>
					</tr>
						@foreach($reporte_retiros_data as $reporte_retiro_data)
						<tr>
							@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3)
								<td class="text-nowrap text-center">
									<a href="{{URL::to('/retiro_servicio/edit_reporte_retiro_servicio/')}}/{{$reporte_retiro_data->idreporte_retiro}}">{{$reporte_retiro_data->reporte_tipo_abreviatura}}{{$reporte_retiro_data->reporte_correlativo}}{{$reporte_retiro_data->reporte_activo_abreviatura}}</a>
								</td>
							@else
								<td class="text-nowrap text-center">
									<a href="{{URL::to('/retiro_servicio/view_reporte_retiro_servicio/')}}/{{$reporte_retiro_data->idreporte_retiro}}">{{$reporte_retiro_data->reporte_tipo_abreviatura}}{{$reporte_retiro_data->reporte_correlativo}}{{$reporte_retiro_data->reporte_activo_abreviatura}}</a>
								</td>
							@endif
							<td class="text-nowrap text-center">
								{{$reporte_retiro_data->codigo_patrimonial}}
							</td>
							<td class="text-nowrap text-center">
								{{$reporte_retiro_data->nombre_equipo}}
							</td>
							<td class="text-nowrap text-center">
								{{$reporte_retiro_data->nombre_marca}}
							</td>
							<td class="text-nowrap text-center">
								{{$reporte_retiro_data->nombre_modelo}}
							</td>
							<td class="text-nowrap text-center">
								{{$reporte_retiro_data->numero_serie}}
							</td>
							<td class="text-nowrap text-center">
								{{$reporte_retiro_data->nombre_proveedor}}
							</td>
							<td class="text-nowrap text-center">
								{{$reporte_retiro_data->nombre_motivo}}
							</td>
							@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
								<td class="text-nowrap text-center">
									<a class="btn btn-success btn-block" href="{{URL::to('/retiro_servicio/programacion/')}}/{{$reporte_retiro_data->idreporte_retiro}}"><span class="glyphicon glyphicon-time"></span> Programar</a>
								</td>
							@else
								<td class="text-nowrap text-center">-</td>
							@endif
						</tr>
						@endforeach
				</table>
			</div>
		</div>
	</div>
	
	@if($search_motivo || $search_cod_pat || $search_equipo || $search_marca || $search_servicio || $search_proveedor || $search_servicio)
		{{ $reporte_retiros_data->appends(array('search_motivo' => $search_motivo,'search_cod_pat'=>$search_cod_pat,'search_equipo'=>$search_equipo,'search_marca'=>$search_marca,'search_servicio'=>$search_servicio,'search_cod_pat'=>$search_proveedor,'search_servicio'=>$search_servicio))->links() }}
	@else
		{{ $reporte_retiros_data->links() }}
	@endif
@stop