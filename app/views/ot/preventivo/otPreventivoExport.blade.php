<html>
	<head>
		<meta charset="UTF-8">
		<style type="text/css">
			body{
				font-size: 10px;
			}
			
			#header .titulo{
				height:20px;
				width:500px;
				position:absolute;
				text-align: center;
				padding-left:150px;
				padding-top: 20px;
				font-size: 20px;
			}
			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
			}
			th, td {
				text-align: center;
			}
			.lista_generales{
				list-style-type:none;
				border:1px solid black;
				width:100%;
			}
			li{
				margin-bottom:5px;
				margin-left:-15px;
			}
			.nombre_general{
				width:100%;
			}
			#titulo{
				text-align:center;
				margin-top:30px;
				position:fixed;
			}
			#logo{
				padding:10px 10px 10px 10px;
				width: 120px;
			}
			.firmas{
				margin:100px 0 20px 0;
			}
			.firma{
				display: inline;
				border-top: 1px solid #000000;
			}
			.firma{
				margin-right: 10px;
			}
			.firma{
				margin-left: 85px;
				margin-right: 85px;
			}
			.firma{
				margin-left: 10px;
			}

		</style>
	</head>
	<body>
		<div id="header">
			<div class="img">
				<img id="logo" src="img/logo_uib.jpg" ></img>
			</div>
			<div class="titulo">
				<h3>Orden de Trabajo de Mantenimiento Preventivo: {{$ot->ot_tipo_abreviatura}}{{$ot->ot_correlativo}}{{$ot->ot_activo_abreviatura}}</h3>
			</div>
		</div>
		<h3>Datos de la orden de trabajo</h3>
		<ul class="lista_generales">
			<li><label><strong>Usuario Solicitante: </strong></label>   {{$usuario_solicitante->nombre}} {{$usuario_solicitante->apellido_pat}} {{$usuario_solicitante->apellido_mat}}</li>
			<li><label><strong>Servicio Hospitario: </strong></label>  {{$servicio->nombre}}</li>
			<li><label><strong>Ubicacion Fisica: </strong></label>  {{$ubicacion->nombre}}</li>
			<li><label><strong>Documento Elaborado Por: </strong></label>  {{$usuario_elaborador->nombre}} {{$usuario_elaborador->apellido_pat}} {{$usuario_elaborador->apellido_mat}}</p></li>
			@if($ot->nombre_ejecutor==null)
				<li><label><strong>Ejecutor del Mantenimiento: </strong></label></li>
			@else
				<li><label><strong>Ejecutor del Mantenimiento: </strong></label>  {{$ot->nombre_ejecutor}}</li>
			@endif
			@if($ot->numero_ficha==null)
				<li><label><strong>Numero de Ficha: </strong></label>  -</li>
			@else
				<li><label><strong>Numero de Ficha: </strong></label>  {{$ot->numero_ficha}}</li>
			@endif
		</ul>
		<h3>Datos del Equipo</h3>
		<ul class="lista_generales">
			<li><label><strong>Nombre del Equipo: </strong></label>  {{$ot->nombre_equipo}}</li>
			<li><label><strong>Marca: </strong></label>  {{$ot->nombre_marca}}</li>
			<li><label><strong>Modelo: </strong></label>  {{$ot->modelo}}</li>
			<li><label><strong>Codigo Patrimonial: </strong></label>  {{$ot->codigo_patrimonial}}</li>
			<li><label><strong>Numero de Serie: </strong></label>  {{$ot->numero_serie}}</li>
		</ul>
		<h3>Datos de la Solicitud</h3>
		<ul class="lista_generales">
			<li><label><strong>Fecha Programada: </strong></label>  {{date('d-m-Y',strtotime($ot->fecha_programacion))}}</li>
			@if($ot->fecha_conformidad == null)
				<li><label><strong>Fecha Conformidad: </strong></label> -</li>
			@else
				<li><label><strong>Fecha Conformidad: </strong></label>  {{date('d-m-Y',strtotime($ot->fecha_conformidad))}}</li>
			@endif
			<li><label><strong>Hora Programada: </strong></label>  {{date('H:i',strtotime($ot->fecha_programacion))}}</li>
			@if($ot->fecha_conformidad == null)
				<li><label><strong>Hora Conformidad: </strong></label> -</li>
			@else
				<li><label><strong>Hora Conformidad: </strong></label>  {{date('d-m-Y',strtotime($ot->fecha_conformidad))}}</li>
			@endif
		</ul>
		<h3>Estado Inicial del Equipo</h3>
		<ul class="lista_generales">
			@if($estado_inicial == null)
				<li><label><strong>Estado Inicial del Activo: </strong></label> -</li>
			@else
				<li><label><strong>Estado Inicial del Activo: </strong></label> {{$estado_inicial->nombre}}</li>
			@endif
			<li><label><strong>Equipo No Intervenido: </strong></label>	{{$equipo_no_intervenido->nombre}}</li>
		</ul>
		<h3>Estado Final del Equipo</h3>
		<ul class="lista_generales">
			@if($ot->fecha_inicio_ejecucion == null)
				<li><label><strong>Fecha de Inicio: </strong></label> - </li>
			@else
				<li><label><strong>Fecha de Inicio: </strong></label>  {{date('d-m-Y',strtotime($ot->fecha_inicio_ejecucion))}}</li>
			@endif
			<li><label><strong>Garantia: </strong></label> {{$ot->garantia}}</li>
			@if($estado_final==null)
				<li><label><strong>Estado Final del Activo: </strong></label> -</li>
			@else
				<li><label><strong>Estado Final del Activo: </strong></label> {{$estado_final->nombre}}</li>
			@endif
			@if($ot->fecha_termino_ejecucion == null)
				<li><label><strong>Fecha de Termino: </strong></label> - </li>
			@else
				<li><label><strong>Fecha de Termino: </strong></label>  {{date('d-m-Y',strtotime($ot->fecha_termino_ejecucion))}}</li>
			@endif
			@if($ot->sin_interrupcion == 0)
				<li><label><strong>Sin Interrupcion al Servicio: </strong></label> No</li>
			@else
				<li><label><strong>Sin Interrupcion al Servicio: </strong></label> Si</li>
			@endif
		</ul>
		<div id="actividades">
			<div style="padding-left:5px;">
				<h3>ACTIVIDADES</h3>
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
		<div style="border-top:solid;width:200px;margin-top:100px;position:absolute;">
			<p style="text-align:center">Firma Jefe de UIB</p>
		</div>
		<div style="border-top:solid;width:200px;margin-left:250px;position:absolute;">
			<p style="text-align:center">Firma Jefe del Servicio</p>
		</div>
		<div style="border-top:solid;width:200px;margin-left:500px;">
			<p style="text-align:center">Firma Jefe de Tumimed</p>
		</div>
	</body>
</html>