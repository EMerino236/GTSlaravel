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
				height: 200px;
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
				<h3>Orden de Trabajo de Busqueda de Informacion: {{$ot->ot_tipo_abreviatura}}{{$ot->ot_correlativo}}{{$ot->ot_activo_abreviatura}}</h3>
			</div>
		</div>
		<div id="datos_otm">
			<div style="padding-left:5px;">
				<h3>DATOS DE LA OTM </h3>
			</div>
			<div class="info_left">
				<label><strong>Usuario Solicitante: </strong></label>   {{$usuario_solicitante->nombre}} {{$usuario_solicitante->apellido_pat}} {{$usuario_solicitante->apellido_mat}}<br>
				<label><strong>Servicio Hospitario: </strong></label>  {{$servicio->nombre}}<br>
				<label><strong>Ubicacion Fisica: </strong></label>  {{$ubicacion->nombre}}
			</div>
			<div class="info_right">
				<label><strong>Documento Elaborado Por: </strong></label>  {{$usuario_elaborador->nombre}} {{$usuario_elaborador->apellido_pat}} {{$usuario_elaborador->apellido_mat}}</p><br>
				<label><strong>Ejecutor del Mantenimiento: </strong></label>  {{$ot->nombre_ejecutor}}<br>
				<label><strong>Numero de Ficha: </strong></label>  {{$ot->numero_ficha}}
			</div>
		</div>
		<div id="datos_equipo">
			<div style="padding-left:5px;">
				<h3>DATOS DEL ACTIVO</h3>
			</div>
			<div class="info_left">
				<label><strong>Nombre del Equipo: </strong></label>  {{$ot->nombre_equipo}}<br>
				<label><strong>Marca: </strong></label>  {{$ot->nombre_marca}}<br>
				<label><strong>Modelo: </strong></label>  {{$ot->modelo}}
			</div>
			<div class="info_right">
				<label><strong>Codigo Patrimonial: </strong></label>  {{$ot->codigo_patrimonial}}</p><br>
				<label><strong>Numero de Serie: </strong></label>  {{$ot->numero_serie}}
			</div>
		</div>
		<div id="datos_solicitud">
			<div style="padding-left:5px;">
				<h3>DATOS DE LA SOLICITUD</h3>
			</div>
			<div class="info_left">
				<label><strong>Fecha Programada: </strong></label>  {{date('d-m-Y',strtotime($ot->fecha_programacion))}}<br>
				@if($ot->fecha_conformidad == null)
					<label><strong>Fecha Conformidad: </strong></label> -
				@else
					<label><strong>Fecha Conformidad: </strong></label>  {{date('d-m-Y',strtotime($ot->fecha_conformidad))}}
				@endif
			</div>
			<div class="info_right">
				<label><strong>Hora Programada: </strong></label>  {{date('H:i',strtotime($ot->fecha_programacion))}}<br>
				@if($ot->fecha_conformidad == null)
					<label><strong>Hora Conformidad: </strong></label> -
				@else
					<label><strong>Hora Conformidad: </strong></label>  {{date('d-m-Y',strtotime($ot->fecha_conformidad))}}
				@endif
			</div>
		</div>
		
		<div id="actividades">
			<div style="padding-left:5px;">
				<h3>ACTIVIDADES</h3>
			</div>
			<div class="info_left">
				@if($ot->fecha_inicio_ejecucion == null)
					<label><strong>Fecha de Inicio: </strong></label> - <br>
				@else
					<label><strong>Fecha de Inicio: </strong></label>  {{date('d-m-Y',strtotime($ot->fecha_inicio_ejecucion))}}<br>
				@endif
				<label><strong>Garantia: </strong></label> {{$ot->garantia}}<br>
				<label><strong>Estado Final del Activo: </strong></label> {{$estado_final->nombre}}
			</div>
			<div class="info_right">
				@if($ot->fecha_termino_ejecucion == null)
					<label><strong>Fecha de Termino: </strong></label> - <br>
				@else
					<label><strong>Fecha de Termino: </strong></label>  {{date('d-m-Y',strtotime($ot->fecha_termino_ejecucion))}}<br>
				@endif
				@if($ot->sin_interrupcion == 0)
					<label><strong>Sin Interrupcion al Servicio: </strong></label> No
				@else
					<label><strong>Sin Interrupcion al Servicio: </strong></label> Si
				@endif
			</div>
			<div  id="table_tareas">
				<table style="width:100%">
					<tr>
						<th>Actividad</th>
						<th>Realizada</th>
					</tr>
					@foreach($tareas as $tarea)
						<tr>
							<td>{{$tarea->nombre_tarea}}</td>
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
				<h3>REPUESTOS</h3>
			</div>
			<div>
				<table style="width:100%">
					<tr>
						<th>Nombre</th>
						<th>Codigo</th>
						<th>Cantidad</th>
						<th>Costo  (S/.)</th>
					</tr>
					@foreach($repuestos_ot as $repuesto)
						<tr>
							<td>{{$repuesto->nombre}}</td>
							<td>{{$repuesto->codigo}}</td>
							<td>{{$repuesto->cantidad}}</td>
							<td>{{$repuesto->costo}}</td>
						</tr>
					@endforeach
				</table>
			</div>
			<div style="padding-left:5px;padding-top:10px;">
				<label><strong>Costo Total Repuestos:</strong></label>		S/.{{number_format($ot->costo_total_repuestos,2)}}
			</div>
		</div>
		<div>
			<div style="padding-left:5px;">
				<h3>MANO DE OBRA</h3>
			</div>
			<div >
				<table style="width:100%">
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
			<div style="padding-left:5px;padding-top:10px;">
				<label><strong>Costo Total Mano de Obra:</strong></label>		S/.{{number_format($ot->costo_total_personal,2)}}
			</div>
		</div>
		<div id="sign_uib" style="border-top:solid;width:200px;margin-top:100px;position:absolute;">
			<p style="text-align:center">Firma Jefe de UIB</p>
		</div>
		<div id="sign_uib" style="border-top:solid;width:200px;margin-left:250px;position:absolute;">
			<p style="text-align:center">Firma Jefe del Servicio</p>
		</div>
		<div id="sign_uib" style="border-top:solid;width:200px;margin-left:500px;">
			<p style="text-align:center">Firma Jefe de Tumimet</p>
		</div>
	</body>
</html>