@extends('templates/registroHistoricoOtTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Registro Histórico de Ordenes de Trabajo de Mantenimiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    @if (Session::has('message'))
		<div class="alert alert-success">{{ Session::get('message') }}</div>
	@endif
    
    {{ Form::open(array('url'=>'/registro_historico_otm/search_ot','method'=>'get' ,'role'=>'form', 'id'=>'search-form','class' => 'form-group')) }}
	<div class="container-fluid form-group row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Búsqueda</h3>
				</div>
				<div class="panel-body">
					<div class="container-fluid form-group row">
						<div class="form-group col-md-4">
							{{ Form::label('search_nombre_equipo','Nombre de Equipo') }}
							{{ Form::text('search_nombre_equipo',$search_nombre_equipo,array('class'=>'form-control','placeholder'=>'Nombre de Equipo')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_marca','Marca') }}
							{{ Form::select('search_marca',array('0'=>'Seleccione') + $marcas,$search_marca,array('class'=>'form-control')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_grupo','Grupo') }}
							{{ Form::text('search_grupo',$search_grupo,array('class'=>'form-control','placeholder'=>'Grupo')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_modelo','Modelo') }}
							{{ Form::text('search_modelo',$search_modelo,array('class'=>'form-control','placeholder'=>'Modelo de Equipo')) }}
						</div>					
						<div class="form-group col-md-4">
							{{ Form::label('search_serie','Número de Serie') }}
							{{ Form::text('search_serie',$search_serie,array('class'=>'form-control','placeholder'=>'Número de Serie')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_proveedor','Proveedor') }}
							{{ Form::text('search_proveedor',$search_proveedor,array('class'=>'form-control','placeholder'=>'RUC, Razón social o Nombre de contacto')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_codigo_patrimonial','Código Patrimonial') }}
							{{ Form::text('search_codigo_patrimonial',$search_codigo_patrimonial,array('class'=>'form-control','placeholder'=>'Código Patrimonial')) }}
						</div>					
						<div class="form-group col-md-4">
							{{ Form::label('search_ini','Fecha inicio') }}
							<div id="search_datetimepicker1" class="input-group date">
								{{ Form::text('search_ini',$search_ini,array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
							</div>
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_fin','Fecha fin') }}
							<div id="search_datetimepicker2" class="input-group date">
								{{ Form::text('search_fin',$search_fin,array('class'=>'form-control','readonly'=>'')) }}
								<span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
							</div>
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_tipo','Tipo de OTM') }}
							{{ Form::select('search_tipo',$tipos,$search_tipo,array('class'=>'form-control','id'=>'tipo_ot')) }}
						</div>
						<div class="form-group col-md-4">
							{{ Form::label('search_codigo_ot','Código OTM') }}
							{{ Form::text('search_codigo_ot',$search_codigo_ot,array('class'=>'form-control','placeholder'=>'Código OTM')) }}
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
	@if($search_tipo==1 || $search_tipo == 0)
	<div class="row">
		<div class="col-md-12">
			<h3>Ordenes de Mantenimiento Correctivo </h3>
			@if(count($correctivos)>0)
				<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Fecha de Programación</th>
						<th class="text-nowrap text-center">Código de OTM</th>
						<th class="text-nowrap text-center">Servicio Clínico</th>
						<th class="text-nowrap text-center">Nombre del Equipo</th>
						<th class="text-nowrap text-center">Marca</th>
						<th class="text-nowrap text-center">Grupo</th>
						<th class="text-nowrap text-center">Modelo</th>
						<th class="text-nowrap text-center">Serie</th>
						<th class="text-nowrap text-center">Proveedor</th>
						<th class="text-nowrap text-center">Código Patrimonial</th>
						<th class="text-nowrap text-center">Estado (OTM)</th>
					</tr>
					@foreach($correctivos as $correctivo)
						<tr>
							<td class="text-nowrap text-center">{{date('d-m-Y',strtotime($correctivo->fecha_programacion))}}</td>
							<td class="text-nowrap text-center" >
								@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
									@if($correctivo->idestado_ot == 9)
										<a href="{{URL::to('/mant_correctivo/create_ot/')}}/{{$correctivo->idot_correctivo}}">{{$correctivo->ot_tipo_abreviatura}}{{$correctivo->ot_correlativo}}{{$correctivo->ot_activo_abreviatura}}</a>
									@else
										<a href="{{URL::to('/mant_correctivo/view_ot/')}}/{{$correctivo->idot_correctivo}}">{{$correctivo->ot_tipo_abreviatura}}{{$correctivo->ot_correlativo}}{{$correctivo->ot_activo_abreviatura}}</a>
									@endif
								@else
									<a href="{{URL::to('/mant_correctivo/view_ot/')}}/{{$correctivo->idot_correctivo}}">{{$correctivo->ot_tipo_abreviatura}}{{$correctivo->ot_correlativo}}{{$correctivo->ot_activo_abreviatura}}</a>
								@endif
								
							</td>
							<td class="text-nowrap text-center">{{$correctivo->nombre_servicio}}</td>	
							<td class="text-nowrap text-center">{{$correctivo->nombre_equipo}}</td>
							<td class="text-nowrap text-center">{{$correctivo->nombre_marca}}</td>
							<td class="text-nowrap text-center">{{$correctivo->nombre_grupo}}</td>
							<td class="text-nowrap text-center">{{$correctivo->nombre_modelo}}</td>
							<td class="text-nowrap text-center">{{$correctivo->serie}}</td>
							<td class="text-nowrap text-center">{{$correctivo->nombre_proveedor}}
							<td class="text-nowrap text-center">{{$correctivo->codigo_patrimonial}}</td>
							<td class="text-nowrap text-center">{{$correctivo->nombre_estado}}</td>						
						</tr>
					@endforeach
				</table>
				</div>
			@else
				<h4 style="color:red;">No hay Registros Encontrados</h4>
			@endif
		</div>		
	</div>
	@endif
	@if($search_tipo==2 || $search_tipo==0)
	<div class="row">
		<div class="col-md-12">
			<h3>Ordenes de Mantenimiento Preventivo </h3>
			@if(count($preventivos)>0)
				<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Fecha de Programación</th>
						<th class="text-nowrap text-center">Código de OTM</th>
						<th class="text-nowrap text-center">Servicio Clínico</th>
						<th class="text-nowrap text-center">Nombre del Equipo</th>
						<th class="text-nowrap text-center">Marca</th>
						<th class="text-nowrap text-center">Grupo</th>
						<th class="text-nowrap text-center">Modelo</th>
						<th class="text-nowrap text-center">Serie</th>
						<th class="text-nowrap text-center">Proveedor</th>
						<th class="text-nowrap text-center">Código Patrimonial</th>
						<th class="text-nowrap text-center">Estado (OTM)</th>
					</tr>
					@foreach($preventivos as $preventivo)
						<tr>
							<td class="text-nowrap text-center">{{date('d-m-Y',strtotime($preventivo->fecha_programacion))}}</td>
							<td class="text-nowrap text-center">
								@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
									@if($preventivo->idestado_ot == 9)
										<a href="{{URL::to('/mant_preventivo/create_ot_preventivo/')}}/{{$preventivo->idot_preventivo}}">{{$preventivo->ot_tipo_abreviatura}}{{$preventivo->ot_correlativo}}{{$preventivo->ot_activo_abreviatura}}</a>
									@else
										<a href="{{URL::to('/mant_preventivo/view_ot_preventivo/')}}/{{$preventivo->idot_preventivo}}">{{$preventivo->ot_tipo_abreviatura}}{{$preventivo->ot_correlativo}}{{$preventivo->ot_activo_abreviatura}}</a>
									@endif
								@else
									<a href="{{URL::to('/mant_preventivo/view_ot_preventivo/')}}/{{$preventivo->idot_preventivo}}">{{$preventivo->ot_tipo_abreviatura}}{{$preventivo->ot_correlativo}}{{$preventivo->ot_activo_abreviatura}}</a>
								@endif
							</td>
							<td class="text-nowrap text-center">{{$preventivo->nombre_servicio}}</td>	
							<td class="text-nowrap text-center">{{$preventivo->nombre_equipo}}</td>
							<td class="text-nowrap text-center">{{$preventivo->nombre_marca}}</td>
							<td class="text-nowrap text-center">{{$preventivo->nombre_grupo}}</td>
							<td class="text-nowrap text-center">{{$preventivo->nombre_modelo}}</td>
							<td class="text-nowrap text-center">{{$preventivo->serie}}</td>
							<td class="text-nowrap text-center">{{$preventivo->nombre_proveedor}}
							<td class="text-nowrap text-center">{{$preventivo->codigo_patrimonial}}</td>
							<td class="text-nowrap text-center">{{$preventivo->nombre_estado}}</td>						
						</tr>
					@endforeach
				</table>
				</div>
			@else
				<h4 style="color:red;">No hay Registros Encontrados</h4>
			@endif
		</div>		
	</div>
	@endif
	@if($search_tipo==3 || $search_tipo==0)
	<div class="row">
		<div class="col-md-12">
			<h3>Ordenes de Verificación Metrológica </h3>
			@if(count($verificaciones)>0)
				<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Fecha de Programación</th>
						<th class="text-nowrap text-center">Código de OTM</th>
						<th class="text-nowrap text-center">Servicio Clínico</th>
						<th class="text-nowrap text-center">Nombre del Equipo</th>
						<th class="text-nowrap text-center">Marca</th>
						<th class="text-nowrap text-center">Grupo</th>
						<th class="text-nowrap text-center">Modelo</th>
						<th class="text-nowrap text-center">Serie</th>
						<th class="text-nowrap text-center">Proveedor</th>
						<th class="text-nowrap text-center">Código Patrimonial</th>
						<th class="text-nowrap text-center">Estado (OTM)</th>
					</tr>
					@foreach($verificaciones as $verificacion)
						<tr>
							<td class="text-nowrap text-center">{{date('d-m-Y',strtotime($verificacion->fecha_programacion))}}</td>
							<td class="text-nowrap text-center">
								@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol == 4)
									@if($verificacion->idestado_ot==9)
										<a href="{{URL::to('/verif_metrologica/create_ot_verif_metrologica/')}}/{{$verificacion->idot_vmetrologica}}">{{$verificacion->ot_tipo_abreviatura}}{{$verificacion->ot_correlativo}}{{$verificacion->ot_activo_abreviatura}}</a>
									@else
										<a href="{{URL::to('/verif_metrologica/view_ot_verif_metrologica/')}}/{{$verificacion->idot_vmetrologica}}">{{$verificacion->ot_tipo_abreviatura}}{{$verificacion->ot_correlativo}}{{$verificacion->ot_activo_abreviatura}}</a>
									@endif
								@else
									<a href="{{URL::to('/verif_metrologica/view_ot_verif_metrologica/')}}/{{$verificacion->idot_vmetrologica}}">{{$verificacion->ot_tipo_abreviatura}}{{$verificacion->ot_correlativo}}{{$verificacion->ot_activo_abreviatura}}</a>
								@endif
								
							</td>
							<td class="text-nowrap text-center">{{$verificacion->nombre_servicio}}</td>	
							<td class="text-nowrap text-center">{{$verificacion->nombre_equipo}}</td>
							<td class="text-nowrap text-center">{{$verificacion->nombre_marca}}</td>
							<td class="text-nowrap text-center">{{$verificacion->nombre_grupo}}</td>
							<td class="text-nowrap text-center">{{$verificacion->nombre_modelo}}</td>
							<td class="text-nowrap text-center">{{$verificacion->serie}}</td>
							<td class="text-nowrap text-center">{{$verificacion->nombre_proveedor}}
							<td class="text-nowrap text-center">{{$verificacion->codigo_patrimonial}}</td>
							<td class="text-nowrap text-center">{{$verificacion->nombre_estado}}</td>						
						</tr>
					@endforeach
				</table>
				</div>
			@else
				<h4 style="color:red;">No hay Registros Encontrados</h4>
			@endif
		</div>		
	</div>
	@endif
	@if($search_tipo == 4 || $search_tipo == 0)
	<div class="row">
		<div class="col-md-12">
			<h3>Ordenes de Inspección de Equipos </h3>
			@if(count($inspecciones)>0)
				<div class="table-responsive">
					<table class="table">
						<tr class="info">
							<th class="text-nowrap text-center">Fecha de Programación</th>
							<th class="text-nowrap text-center">Hora Inicio</th>
							<th class="text-nowrap text-center">Hora Fin</th>
							<th class="text-nowrap text-center">Código de OTM</th>
							<th class="text-nowrap text-center">Servicio Clínico</th>
							<th class="text-nowrap text-center">Estado (OTM)</th>
						</tr>
						@foreach($inspecciones as $inspeccion)
							<tr>
								<td class="text-nowrap text-center">{{date('d-m-Y',strtotime($inspeccion->fecha_inicio))}}</td>
								<td class="text-nowrap text-center">{{date('H:i',strtotime($inspeccion->fecha_inicio))}}</td>
								<td class="text-nowrap text-center">{{date('H:i',strtotime($inspeccion->fecha_fin))}}</td>
								<td class="text-nowrap text-center">
									@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
										@if($inspeccion->idestado == 9)
											<a href="{{URL::to('/inspec_equipos/create_ot_inspeccion_equipos/')}}/{{$inspeccion->idot_inspec_equipo}}">{{$inspeccion->ot_tipo_abreviatura}}{{$inspeccion->ot_correlativo}}</a>
										@else
											<a href="{{URL::to('/inspec_equipos/view_ot_inspeccion_equipos/')}}/{{$inspeccion->idot_inspec_equipo}}">{{$inspeccion->ot_tipo_abreviatura}}{{$inspeccion->ot_correlativo}}</a>
										@endif
									@else
										<a href="{{URL::to('/inspec_equipos/view_ot_inspeccion_equipos/')}}/{{$inspeccion->idot_inspec_equipo}}">{{$inspeccion->ot_tipo_abreviatura}}{{$inspeccion->ot_correlativo}}</a>
									@endif									
								</td>
								<td class="text-nowrap text-center">{{$inspeccion->nombre_servicio}}</td>	
								<td class="text-nowrap text-center">{{$inspeccion->nombre_estado}}</td>						
							</tr>
						@endforeach
					</table>
				</div>
			@else
				<h4 style="color:red;">No hay Registros Encontrados</h4>
			@endif
		</div>		
	</div>
	@endif
	@if($search_tipo==5 || $search_tipo==0)
	<div class="row">
		<div class="col-md-12">
			<h3>Ordenes de Retiro de Servicio </h3>
			@if(count($retiros)>0)
				<div class="table-responsive">
				<table class="table">
					<tr class="info">
						<th class="text-nowrap text-center">Fecha de Programación</th>
						<th class="text-nowrap text-center">Código de OTM</th>
						<th class="text-nowrap text-center">Servicio Clínico</th>
						<th class="text-nowrap text-center">Nombre del Equipo</th>
						<th class="text-nowrap text-center">Marca</th>
						<th class="text-nowrap text-center">Grupo</th>
						<th class="text-nowrap text-center">Modelo</th>
						<th class="text-nowrap text-center">Serie</th>
						<th class="text-nowrap text-center">Proveedor</th>
						<th class="text-nowrap text-center">Código Patrimonial</th>
						<th class="text-nowrap text-center">Estado (OTM)</th>
					</tr>
					@foreach($retiros as $retiro)
						<tr>
							<td class="text-nowrap text-center">{{date('d-m-Y',strtotime($retiro->fecha_programacion))}}</td>
							<td class="text-nowrap text-center">
								@if($user->idrol==1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
										@if($retiro->idestado_ot == 9)
											<a href="{{URL::to('/retiro_servicio/create_ot/')}}/{{$retiro->idot_retiro}}">{{$retiro->ot_tipo_abreviatura}}{{$retiro->ot_correlativo}}{{$retiro->ot_activo_abreviatura}}</a>
										@else
											<a href="{{URL::to('/retiro_servicio/view_ot/')}}/{{$retiro->idot_retiro}}">{{$retiro->ot_tipo_abreviatura}}{{$retiro->ot_correlativo}}{{$retiro->ot_activo_abreviatura}}</a>
										@endif
									@else
										<a href="{{URL::to('/retiro_servicio/view_ot/')}}/{{$retiro->idot_retiro}}">{{$retiro->ot_tipo_abreviatura}}{{$retiro->ot_correlativo}}{{$retiro->ot_activo_abreviatura}}</a>
									@endif								
							</td>
							<td class="text-nowrap text-center">{{$retiro->nombre_servicio}}</td>	
							<td class="text-nowrap text-center">{{$retiro->nombre_equipo}}</td>
							<td class="text-nowrap text-center">{{$retiro->nombre_marca}}</td>
							<td class="text-nowrap text-center">{{$retiro->nombre_grupo}}</td>
							<td class="text-nowrap text-center">{{$retiro->nombre_modelo}}</td>
							<td class="text-nowrap text-center">{{$retiro->serie}}</td>
							<td class="text-nowrap text-center">{{$retiro->nombre_proveedor}}
							<td class="text-nowrap text-center">{{$retiro->codigo_patrimonial}}</td>
							<td class="text-nowrap text-center">{{$retiro->nombre_estado}}</td>						
						</tr>
					@endforeach
				</table>
				</div>
			@else
				<h4 style="color:red;">No hay Registros Encontrados</h4>
			@endif
		</div>		
	</div>
	@endif
	@if($search_tipo == 0 || $search_tipo == 1)
		{{ $correctivos->links()}}
	@elseif($search_tipo==2)
		{{ $preventivos->links()}}
	@elseif($search_tipo==3)
		{{ $verificaciones->links()}}
	@elseif($search_tipo==4)
		{{ $inspecciones->links()}}
	@elseif($search_tipo==5)
		{{ $retiros->links()}}
	@endif
	
@stop
