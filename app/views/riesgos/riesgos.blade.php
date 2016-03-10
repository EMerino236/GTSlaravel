@extends('templates/riesgosTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Sección de Riesgos</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
    	<div class="col-md-8">
	    	<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Últimos eventos adversos</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
							    <table class="table">
									<tr class="info">
										<th class="text-nowrap text-center">N° de Reporte</th>
										<th class="text-nowrap text-center">Tipo de Evento Adverso</th>
										<th class="text-nowrap text-center">Usuario Reportante</th>
										<th class="text-nowrap text-center">Fecha de Reporte</th>
									</tr>
									@foreach($eventos_adversos_data as $evento_adverso)
									<tr class="@if($evento_adverso->deleted_at) bg-danger @endif">
										<td class="text-nowrap text-center">
											<a href="{{URL::to('/eventos_adversos/view_evento_adverso/')}}/{{$evento_adverso->id}}">
												{{$evento_adverso->codigo_abreviatura}}-{{$evento_adverso->codigo_correlativo}}-{{$evento_adverso->codigo_anho}}
											</a>
										</td>
										<td class="text-nowrap text-center">
												{{$evento_adverso->nombre_incidente}}
										</td>
										<td class="text-nowrap text-center">
												{{$evento_adverso->nombre_reportante}}
										</td>
										<td class="text-nowrap text-center">
												{{date('d-m-Y',strtotime($evento_adverso->fecha_reporte))}}
										</td>
									</tr>
									@endforeach		
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4" style="margin-top:50px;">
			<font size=6 color="#337ab7"><i class="fa fa-bomb fa-fw"></i> Riesgos</font>
			<p style="text-align:justify;">El módulo de riesgos realiza un análisis de los riesgos y 
				la gestión de las calibraciones.</p>
		</div>
	</div>
	<div class="row">
    	<div class="col-md-8">
	    	<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Lista de calibraciones pendientes</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
							    <table class="table">
							    	<tr class="info">
										<th class="text-nowrap text-center">Reporte de Calibración</th>
										<th class="text-nowrap text-center">Grupo</th>
										<th class="text-nowrap text-center">Servicio Clínico</th>
										<th class="text-nowrap text-center">Nombre de Equipo</th>
										<th class="text-nowrap text-center">Marca</th>
										<th class="text-nowrap text-center">Modelo</th>
										<th class="text-nowrap text-center">Código Patrimonial</th>
										<th class="text-nowrap text-center">Proveedor de Calibracion</th>
									</tr>
									@foreach($reportes_data as $reporte_data)
									<tr class="@if($reporte_data->deleted_at) bg-danger @endif">
										<td class="text-nowrap text-center"  id="{{$reporte_data->id}}">
											<a href="" onclick="show_modal_documentos(event,this)">{{$reporte_data->codigo_abreviatura}}-{{$reporte_data->codigo_correlativo}}-{{$reporte_data->codigo_anho}}</a>
										</td>						
										<td class="text-nowrap text-center">
											{{$reporte_data->nombre_grupo}}
										</td>
										<td class="text-nowrap text-center">
											{{$reporte_data->nombre_servicio}}
										</td>
										<td class="text-nowrap text-center">
											{{$reporte_data->nombre_familia}}
										</td>
										<td class="text-nowrap text-center">
											{{$reporte_data->nombre_marca}}
										</td>
										<td class="text-nowrap text-center">
											{{$reporte_data->nombre_modelo}}
										</td>
										<td class="text-nowrap text-center">
											{{$reporte_data->codigo_patrimonial}}
										</td>
										<td class="text-nowrap text-center">
											{{$reporte_data->nombre_proveedor}}
										</td>
									</tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-11" style="margin-top:50px;" align="center">
			<img heigth= "140" width="140" src="{{asset('img')}}/logo_gts.png"/>
			<font size=7 color="#337ab7" style="display:inline-block;margin-top:15px;font-family:'softwareTest';font-weight:bold;"> GTS SOFTWARE </font>
		</div>
	</div>
@stop