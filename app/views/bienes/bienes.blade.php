@extends('templates/bienesTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Sección de gestión de bienes</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    
    <div class="row">
    	<div class="col-md-8">
	    	<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Lista de SOTs que no se han programado como OTM Correctivo</h3>
				</div>
				<div class="panel-body">
					<table class="table">
						<tr class="info">
							<th class="text-nowrap text-center">N°</th>
							<th class="text-nowrap text-center">Número de SOT</th>
							<th class="text-nowrap text-center">Fecha de solicitud</th>
							<th class="text-nowrap text-center">Usuario solicitante</th>
						</tr>
						@foreach($sots_data as $index => $sot_data)
						<tr>
							<td class="text-nowrap text-center">
								{{$index+1}}
							</td>
							<td class="text-nowrap text-center">
								<a href="{{URL::to('/sot/edit_sot/')}}/{{$sot_data->idsolicitud_orden_trabajo}}">{{$sot_data->sot_tipo_abreviatura}}{{$sot_data->sot_correlativo}}{{$sot_data->sot_activo_abreviatura}}</a>
							</td>
							<td class="text-nowrap text-center">
								{{date('d-m-Y',strtotime($sot_data->fecha_solicitud))}}
							</td>
							<td class="text-nowrap text-center">
								{{$sot_data->apellido_pat}} {{$sot_data->apellido_mat}}, {{$sot_data->nombre}}
							</td>
						</tr>
					@endforeach
				</table>
				</div>
			</div>
		</div>
		<div class="col-md-4" style="margin-top:50px;">
			<font size=6 color="#337ab7"><i class="fa fa-wrench fa-fw"></i> Bienes</font>
			<p style="text-align:justify;">El módulo de bienes permite realizar el ingreso, mantenimiento y baja de 
				bienes en el sistema. De la misma forma este módulo administra información de soporte a los procesos 
				relacionados.</p>
		</div>
	</div>
	<div class="row">
    	<div class="col-md-8">
	    	<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Lista de OTM pendientes</h3>
				</div>
				<div class="panel-body">
					<table class="table">
						<tr class="info">
							<th class="text-nowrap text-center">OT</th>
							<th class="text-nowrap text-center">Fecha y hora</th>
							<th class="text-nowrap text-center">Departamento</th>
							<th class="text-nowrap text-center">Servicio</th>
						</tr>
						@foreach($mant_correctivos_data as $mant_correctivo_data)
						<tr>
							<td class="text-nowrap text-center">
								@if($user->idrol == 1 || $user->idrol==2 || $user->idrol==3 || $user->idrol==4)
									@if($mant_correctivo_data->idestado_ot == 9)
										<a href="{{URL::to('/mant_correctivo/create_ot/')}}/{{$mant_correctivo_data->idot_correctivo}}">{{$mant_correctivo_data->ot_tipo_abreviatura}}{{$mant_correctivo_data->ot_correlativo}}{{$mant_correctivo_data->ot_activo_abreviatura}}</a>
									@else
										<a href="{{URL::to('/mant_correctivo/view_ot/')}}/{{$mant_correctivo_data->idot_correctivo}}">{{$mant_correctivo_data->ot_tipo_abreviatura}}{{$mant_correctivo_data->ot_correlativo}}{{$mant_correctivo_data->ot_activo_abreviatura}}</a>
									@endif
								@else
									<a href="{{URL::to('/mant_correctivo/view_ot/')}}/{{$mant_correctivo_data->idot_correctivo}}">{{$mant_correctivo_data->ot_tipo_abreviatura}}{{$mant_correctivo_data->ot_correlativo}}{{$mant_correctivo_data->ot_activo_abreviatura}}</a>
								@endif
							</td>
							<td class="text-nowrap text-center">
								{{date('d-m-Y H:i',strtotime($mant_correctivo_data->fecha_programacion))}}
							</td>
							<td class="text-nowrap text-center">
								{{$mant_correctivo_data->nombre_area}}
							</td>
							<td class="text-nowrap text-center">
								{{$mant_correctivo_data->nombre_servicio}}
							</td>
						</tr>
						@endforeach
					</table>
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