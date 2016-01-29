@extends('templates/planeamientoTemplate')
@section('content')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Sección de Planeamiento</h3>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    
    <div class="row">
    	<div class="col-md-8">
	    	<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Últimos Certificados de Necesidad Elaborados</h3>
				</div>
				<div class="panel-body">
				    <table class="table">
						<tr class="info">
							<th>N° Reporte</th>
							<th>Fecha y Hora</th>
							<th>Usuario</th>
							<th>Nombre de Equipo</th>
							<th>Servicio Clínico</th>
							<th>Departamento</th>
							<th>OT de Baja de Equipo</th>
						</tr>
						@foreach($reportes_cn_data as $reporte_cn_data)
						<tr class="@if($reporte_cn_data->deleted_at) bg-danger @endif">
							<td>
								@if($user->idrol == 1 || $user->idrol == 2 || $user->idrol == 3 || $user->idrol == 4)
									<a href="{{URL::to('/reporte_cn/edit_reporte_cn/')}}/{{$reporte_cn_data->idreporte_CN}}">{{$reporte_cn_data->numero_reporte_abreviatura}}{{$reporte_cn_data->numero_reporte_correlativo}}-{{$reporte_cn_data->numero_reporte_anho}}</a>
								@endif
								@if($user->idrol == 7 || $user->idrol == 8 || $user->idrol == 9 || $user->idrol == 10 || $user->idrol == 11 || $user->idrol == 12)
									<a href="{{URL::to('/reporte_cn/view_reporte_cn/')}}/{{$reporte_cn_data->idreporte_CN}}">{{$reporte_cn_data->numero_reporte_abreviatura}}{{$reporte_cn_data->numero_reporte_correlativo}}-{{$reporte_cn_data->numero_reporte_anho}}</a>
								@endif
							</td>
							<td>
								{{date('d-m-Y H:i',strtotime($reporte_cn_data->created_at))}}
							</td>
							<td>
								{{$reporte_cn_data->apellido_pat}} {{$reporte_cn_data->apellido_mat}} {{$reporte_cn_data->nombre}}
							</td>
							<td>
								{{$reporte_cn_data->nombre_equipo}}
							</td>
							<td>
								{{$reporte_cn_data->nombre_servicio}}
							</td>
							<td>
								{{$reporte_cn_data->nombre_area}}
							</td>	
							<td>
								<a href="{{URL::to('/retiro_servicio/create_ot/')}}/{{$reporte_cn_data->idot_retiro}}">{{$reporte_cn_data->ot_tipo_abreviatura}}{{$reporte_cn_data->ot_correlativo}}{{$reporte_cn_data->ot_activo_abreviatura}}
							</td>		
						</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-4" style="margin-top:50px;">
			<font size=6 color="#337ab7"><i class="fa fa-calendar fa-fw"></i> Planeamiento</font>
			<p style="text-align:justify;">Este módulo muestra la elaboración de documentos necesarios para 
				la adquisición de bienes de tecnología en salud y los argumentos que sustentan la solicitud.</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-11" style="margin-top:50px;" align="center">
			<img heigth= "140" width="140" src="{{asset('img')}}/logo_gts.png"/>
			<font size=7 color="#337ab7" style="display:inline-block;margin-top:15px;font-family:'softwareTest';font-weight:bold;"> GTS SOFTWARE </font>
		</div>
	</div>

@stop