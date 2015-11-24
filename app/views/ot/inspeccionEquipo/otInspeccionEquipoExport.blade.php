<html>
	<head>
		<style type="text/css">
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
			}

			.info_right{
				margin-left: 350px;
				padding-top:-63px;
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

			#table_tareas{
				padding:20px 0px 0px 40px;
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
				<h3>Orden de Trabajo de Inspeccion de Equipos: {{$ot_info->ot_tipo_abreviatura}}{{$ot_info->ot_correlativo}}</h3>
			</div>
		</div>
		<div id="datos_otm">
			<div style="padding-left:5px;">
				<h3>DATOS DE LA OTM </h3>
			</div>
			<div class="info_left">
				<label><strong>Numero de OTM: </strong></label>  {{$ot_info->ot_tipo_abreviatura}}{{$ot_info->ot_correlativo}}	<br>
				<label><strong>Servicio Hospitario: </strong></label> {{$ot_info->nombre_servicio}}<br>
				<label><strong>Fecha de Inicio: </strong></label> {{date('d-m-Y H:i',strtotime($ot_info->fecha_inicio))}}  
			</div>
			<div class="info_right">
				<label><strong>Ejecutor del Mantenimiento: </strong></label>{{$ot_info->nombre_ingeniero}} {{$ot_info->apat_ingeniero}} {{$ot_info->amat_ingeniero}}  <br>
				<label><strong>Numero de Ficha: </strong></label> <br>{{$ot_info->numero_ficha}}
				<label><strong>Fecha Fin: </strong></label> {{date('d-m-Y H:i',strtotime($ot_info->fecha_fin))}} 
			</div>
		</div>
		<div>
			<div style="padding-left:5px;">
				<h3>EQUIPOS ASOCIADOS AL SERVICIO</h3>
			</div>
			<div>
				<table style="width:100%">
					<tr>
						<th>Equipo</th>
						<th>Modelo</th>
						<th>Codigo Patrimonial</th>
					</tr>
					@foreach($activos_info as $activo)
						<tr>
							<td>{{$activo->nombre_familia}}</td>
							<td>{{$activo->nombre_modelo}}</td>
							<td>{{$activo->codigo_patrimonial}}</td>
						</tr>
					@endforeach
				</table>
			</div>			
		</div>
		<div>
			<div style="padding-left:5px;">
				<h3>INSPECCION POR EQUIPO</h3>
			</div>
			@foreach($activosxot_info as $i => $otxactivo)
				<div style="padding-left:5px;">
					<h3>{{$i+1}}. {{$otxactivo->nombre_equipo}} - {{$otxactivo->nombre_modelo}} - Codigo Patrimonial: {{$otxactivo->codigo_patrimonial}} </h3>
				</div>
				<div>
					<table style="width:100%">
						<tr>
							<th>Tarea</th>
							<th>Estado</th>
						</tr>
						@foreach($tareas_activos[$i] as $tarea)
						<tr>
							<td>{{$tarea->nombre_tarea}}</td>
							<td>
							@if($tarea->idestado_realizado == 23)
								No Realizada
							@else
								Realizada
							@endif
							</td>						
						</tr>
						@endforeach
					</table>
				</div>
				<div style="padding-top:20px;">
					<div style="width:300px;height:300px">
						<label><strong>Observaciones del Equipo:</strong></label>
						{{ Form::textarea('observaciones_equipo'.$i,$otxactivo->observaciones) }}
					</div>	
					<div style="border:solid;width:300px;height:200px;margin-left:400px;position:absolute;">
						@if($otxactivo->imagen_url!= null && $otxactivo->nombre_archivo!=null)
							<img style="max-width:100%;max-height:100%;width:100%;height:100%;" src={{$otxactivo->imagen_url.$otxactivo->nombre_archivo_encriptado}}>
						@endif
					</div>
				</div>					
			@endforeach	
		</div>
		<div style="border-top:solid;width:200px;margin-top:100px;position:absolute;">
			<p style="text-align:center">Firma Jefe de UIB</p>
		</div>
		<div style="border-top:solid;width:200px;margin-left:250px;position:absolute;">
			<p style="text-align:center">Firma Jefe del Servicio</p>
		</div>
		<div style="border-top:solid;width:200px;margin-left:500px;position:absolute;">
			<p style="text-align:center">Firma Jefe de Tumimet</p>
		</div>
	</body>
</html>