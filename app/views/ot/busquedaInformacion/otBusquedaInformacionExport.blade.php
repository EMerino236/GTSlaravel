<html>
	<head>
		<meta charset="UTF-8">
		<style type="text/css">
			body{
				font-size: 10px;
			}
			#logo {
				padding:10px 10px 10px 10px;
			}
			#header .titulo{
				height:20px;
				width:500px;
				position:absolute;
				text-align: center;
				padding-left:200px;
				padding-top:50px;
				font-size: 20px;
			}

			.info_right{
				margin-left: 350px;
				padding-top:-40px;
				padding-bottom: 5px;
				padding-left: 5px;
				padding-right: 5px;
			}
			.info_left{
				padding-top:5px;
				padding-bottom: 5px;
				padding-left: 5px;
				padding-right: 5px;
			}

			#datos_solicitud .info_right{
				margin-left: 350px;
				padding-top:-40px;
				padding-bottom: 5px;
				padding-left: 5px;
				padding-right: 5px;
			}

			#estado_inicial .info_right{
				margin-left: 350px;
				padding-top:-23px;
				padding-bottom: 5px;
				padding-left: 5px;
				padding-right: 5px;
			}

			table{
				width: 600px;
			}

			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
				
			}
			th, td {
				text-align: center;
			}



		</style>
	</head>
	<body>
		<div id="header">
			<div class="img">
				<img id="logo" src="img/logo_uib.jpg" ></img>
			</div>
			<div class="titulo">
				<h3>Orden de Trabajo de Busqueda de Informacion: {{$ot_info->ot_tipo_abreviatura}}{{$ot_info->ot_correlativo}}{{$ot_info->ot_activo_abreviatura}}</h3>
			</div>
		</div>
		<div id="datos_otm">
			<div style="padding-left:5px;">
				<h3>DATOS DE LA OTM </h3>
			</div>
			<div class="info_left">
				<label><strong>Usuario Solicitante: </strong></label>  {{$ot_info->nombre_solicitante}} {{$ot_info->apat_solicitante}} {{$ot_info->amat_solicitante}} <br>
				<label><strong>Tipo: </strong></label> {{$tipo->nombre}} <br>
				<label><strong>Departamento: </strong></label> {{$ot_info->nombre_area}}
			</div>
			<div class="info_right">
				<label><strong>Documento Elaborado Por: </strong></label> {{$ot_info->nombre_elaborador}} {{$ot_info->apat_elaborador}} {{$ot_info->amat_elaborador}}  <br>
				<label><strong>Ejecutor del Mantenimiento: </strong></label>  {{$ot_info->nombre_encargado}} {{$ot_info->apat_encargado}} {{$ot_info->amat_encargado}} <br>
				<label><strong>Numero de Solicitud: </strong></label>  {{$ot_info->sot_tipo_abreviatura}}{{$ot_info->sot_correlativo}}
			</div>
		</div>
		<div id="datos_solicitud">
			<div style="padding-left:5px;">
				<h3>DATOS DE LA SOLICITUD</h3>
			</div>
			<div class="info_left">
				<label><strong>Fecha Programada: </strong></label>  {{date('d-m-Y',strtotime($ot_info->fecha_programacion))}}<br>
				@if($ot_info->fecha_conformidad == null)
					<label><strong>Fecha Conformidad: </strong></label> -
				@else
					<label><strong>Fecha Conformidad: </strong></label>  {{date('d-m-Y',strtotime($ot_info->fecha_conformidad))}}
				@endif
			</div>
			<div class="info_right">
				<label><strong>Hora Programada: </strong></label>  {{date('H:i',strtotime($ot_info->fecha_programacion))}}<br>
				@if($ot_info->fecha_conformidad == null)
					<label><strong>Hora Conformidad: </strong></label> -
				@else
					<label><strong>Hora Conformidad: </strong></label>  {{date('d-m-Y',strtotime($ot_info->fecha_conformidad))}}
				@endif
			</div>
		</div>

		<div id="datos_solicitud">
			<div style="padding-left:5px;">
				<h3>DESCRIPCION DE LA SOLICITUD DE LA OTM</h3>
			</div>
			<div class="info_left">
				<label><strong>Descripcion: </strong></label>  {{$ot_info->descripcion}}<br>
				<label><strong>Motivo: </strong></label>  {{$ot_info->motivo}}<br>
				<label><strong>Detalle: </strong></label>  {{$ot_info->detalle}}<br>
			</div>			
		</div>
		<div >
			<div style="padding-left:5px;">
				<h3>ACTIVIDADES</h3>
			</div>			
			<div  >
				<table style="width:100%">
					<tr>
						<th>Actividad</th>
						<th>Realizada</th>
					</tr>
					@foreach($tareas as $tarea)
						<tr>
							<td>{{$tarea->nombre}}</td>
							@if($tarea->idestado_realizado == 22)
								<td>Realizado</td>
							@else
								<td>No Realizado</td>
							@endif
						</tr>
					@endforeach
				</table>
			</div>
		</div>
		<div>
			<div style="padding-left:5px;">
				<h3>MANO DE OBRA</h3>
			</div>
			<div >
				<table style="width:100%" class="mano_obra">
					<tr>
						<th>Nombres y Apellidos</th>
						<th>Horas Trabajadas (Horas)</th>
						<th>Subtotal (S/.)</th>
					</tr>
					@foreach($personal_data as $personal)
						<tr>
							<td>{{$personal->nombre}}</td>
							<td>{{$personal->horas_hombre}}</td>
							<td>{{$personal->costo}}</td>
						</tr>
					@endforeach
				</table>
			</div>
			<div style="padding-left:5px;padding-top:20px;">
				<label><strong>Costo Total Mano de Obra:</strong></label>		S/.{{number_format($ot_info->costo_total_personal,2)}}
			</div>
		</div>		
		<div  style="border-top:solid;width:200px;margin-top:100px;position:absolute;">
			<p style="text-align:center">Firma Jefe de UIB</p>
		</div>
		<div  style="border-top:solid;width:200px;margin-left:250px;position:absolute;">
			<p style="text-align:center">Firma Jefe del Servicio</p>
		</div>
		<div style="border-top:solid;width:200px;margin-left:500px;position:absolute;">
			<p style="text-align:center">Firma Jefe de Tumimed</p>
		</div>
	</body>
</html>