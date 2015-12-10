@extends('templates/sotBusquedaInformacionTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Búsqueda de Información</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
		<div class="container-fluid form-group row">
			<div class="col-md-4 col-md-offset-8">
				<a class="btn btn-primary btn-block" href="{{URL::to('/solicitud_busqueda_informacion/create_sot')}}">
				<span class="glyphicon glyphicon-plus"></span> Agregar Solicitud</a>
			</div>
		</div>
    {{ Form::open(array('url'=>'/busqueda_informacion/search_ot_busqueda_informacion','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Búsqueda</h3>
				</div>
				<div class="panel-body">
					<div class="container-fluid form-group row">
						<div class="form-group col-md-4">
							{{ Form::label('search_tipo','Tipo') }}
							{{ Form::select('search_tipo', array('0' => 'Seleccione') + $tipos ,$search_tipo ,array('class'=>'form-control')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_area','Departamento') }}
							{{ Form::select('search_area', array('0' => 'Seleccione') + $areas ,$search_area ,array('class'=>'form-control')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_encargado','Encargado:') }}
							{{ Form::text('search_encargado',$search_encargado,array('class'=>'form-control','placeholder'=>'Encargado')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_ini','Fecha inicio') }}
							<div id="search_datetimepicker1" class="form-group input-group date">
								{{ Form::text('search_ini',$search_ini,array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
							</div>
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_fin','Fecha fin') }}
							<div id="search_datetimepicker2" class="form-group input-group date">
								{{ Form::text('search_fin',$search_fin,array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
							</div>
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_ot','Orden de Trabajo de Mantenimiento') }}
							{{ Form::text('search_ot',$search_ot,array('class'=>'form-control','placeholder'=>'Número de OT')) }}
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
	</div>
	{{ Form::close() }}	
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table" id="table_ot">
				<tr class="info">
					<th class="text-nowrap text-center">Tipo</th>
					<th class="text-nowrap text-center">Descripcion</th>
					<th class="text-nowrap text-center">Motivo</th>
					<th class="text-nowrap text-center">Departamento</th>
					<th class="text-nowrap text-center">Encargado</th>
					<th class="text-nowrap text-center">Código SBI</th>
					<th class="text-nowrap text-center">Fecha Solicitud</th>
					<th class="text-nowrap text-center">Estado SOT</th>
					<th class="text-nowrap text-center">Número de OT</th>
					<th class="text-nowrap text-center">Estado OT</th>
					<th class="text-nowrap text-center">Eliminar OT</th>
				</tr>
				@foreach($busquedas as $index => $busqueda)
					{{Form::hidden('idsot',$busqueda->idsolicitud_busqueda_info,array('id'=>'idsot'.$index))}}
					<tr>
						<td class="text-nowrap text-center">{{$busqueda->nombre_tipo}}</td>
						<td class="text-nowrap text-center">{{$busqueda->descripcion}}</td>
						<td class="text-nowrap text-center">{{$busqueda->motivo}}</td>
						<td class="text-nowrap text-center">{{$busqueda->nombre_area}}</td>
						<td class="text-nowrap text-center">{{$busqueda->apat}} {{$busqueda->amat}}, {{$busqueda->nombre_user}}</td>
						@if($busqueda->idot == null && $busqueda->idestado==14 && ($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4 ))
							<td class="text-nowrap text-center">
								<a href="{{URL::to('/solicitud_busqueda_informacion/edit_sot_busqueda_informacion/')}}/{{$busqueda->idsolicitud_busqueda_info}}">{{$busqueda->sot_tipo_abreviatura}}{{$busqueda->sot_correlativo}}</a></td>
						@else
							<td class="text-nowrap text-center">
								<a href="{{URL::to('/solicitud_busqueda_informacion/view_sot_busqueda_informacion/')}}/{{$busqueda->idsolicitud_busqueda_info}}">{{$busqueda->sot_tipo_abreviatura}}{{$busqueda->sot_correlativo}}</a></td>
						@endif
							<td class="text-nowrap text-center">{{date('d-m-Y H:i',strtotime($busqueda->fecha_solicitud))}}</td>
							<td class="text-nowrap text-center">{{$busqueda->nombre_estado}}</td>
						
						@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
							@if($busqueda->idot == null)
								@if($busqueda->idestado != 26)
									<td class="text-nowrap text-center">
										<a class="btn btn-success btn-block btn-sm" onclick="setSotId(event,this)">
										<span class="glyphicon glyphicon-plus"></span> Crear OTM</a>
									</td>
									<td class="text-nowrap text-center"> - </td>
									<td class="text-nowrap text-center"> - </td>
								@else
									<td class="text-nowrap text-center">
										-
									</td>
									<td class="text-nowrap text-center"> - </td>
									<td class="text-nowrap text-center"> - </td>
								@endif
							@elseif($busqueda->idestado == 26)								
								<td class="text-nowrap text-center">
									-
								</td>
								<td class="text-nowrap text-center">
									{{$busqueda->nombre_estado_ot}}
								</td>
								<td class="text-nowrap text-center"> - </td>
							@else
								@if($busqueda->idestado_ot !=25)
									{{Form::hidden('idot_busqueda_info',$busqueda->idot,array('id'=>'idot_busqueda_info'.$index))}}
									
									<td class="text-nowrap text-center">
										<a href="{{URL::to('/busqueda_informacion/create_ot_busqueda_informacion/')}}/{{$busqueda->idot}}">{{$busqueda->ot_tipo_abreviatura}}{{$busqueda->ot_correlativo}}</a>
									</td>
									<td class="text-nowrap text-center">
										{{$busqueda->nombre_estado_ot}}
									</td>
									<td class="text-nowrap text-center">
										<div class="btn btn-danger btn-block" onclick='eliminar_ot(event,this)'><span class="glyphicon glyphicon-trash"></span></div>
									</td>
								@else
									{{Form::hidden('idot_busqueda_info',$busqueda->idot,array('id'=>'idot_busqueda_info'.$index))}}
									<td class="text-nowrap text-center">
										<a href="{{URL::to('/busqueda_informacion/view_ot_busqueda_informacion/')}}/{{$busqueda->idot}}">{{$busqueda->ot_tipo_abreviatura}}{{$busqueda->ot_correlativo}}</a>
									</td>
									<td class="text-nowrap text-center">
										{{$busqueda->nombre_estado_ot}}
									</td>									
									<td class="text-nowrap text-center">
										-
									</td>
								@endif
							@endif
						@else
							@if($busqueda->idot == null || $busqueda->idestado == 26)
								<td class="text-nowrap text-center">
									-
								</td>
								<td class="text-nowrap text-center"> - </td>
							@else
								<td class="text-nowrap text-center">
									<a href="{{URL::to('/busqueda_informacion/view_ot_busqueda_informacion/')}}/{{$busqueda->idot}}">{{$busqueda->ot_tipo_abreviatura}}{{$busqueda->ot_correlativo}}</a>
								</td>
								<td class="text-nowrap text-center">
									{{$busqueda->nombre_estado_ot}}
								</td>
								<td class="text-nowrap text-center"> - </td>
							@endif
						@endif
					</tr>
				@endforeach				
				</table>
				@if($search_tipo || $search_area || $search_encargado || $search_ini || $search_fin || $search_ot)
					{{ $busquedas->appends(array('search_tipo' => $search_tipo,'search_area' => $search_area, 'search_encargado' => $search_encargado,
						'search_ini' => $search_ini, 'search_fin' => $search_fin, 'search_ot' => $search_ot))->links() }}
				@else	
					{{ $busquedas->links()}}
				@endif
			</div>
		</div>
	</div>
	{{Form::hidden('idsot',null,array('id'=>'idsot'))}}

	
@stop
