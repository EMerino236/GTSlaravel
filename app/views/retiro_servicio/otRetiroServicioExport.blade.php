<html>
	<head>
		<meta charset="UTF-8">
		<style>
			body{
				font-size: 10px;
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
				width: 80px;	
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
		<div class="nombre_general"><img id="logo" src="img/logo_uib.jpg" ></img><h2 id="titulo" >Orden de trabajo de retiro de servicio</h2></div>
		<div>
		<h3>Datos de la orden de trabajo</h3>
		<ul class="lista_generales">
			<li><label><strong>Número Orden de Mantenimiento:</strong></label> {{$ot_retiro->ot_tipo_abreviatura}}{{$ot_retiro->ot_correlativo}}{{$ot_retiro->ot_activo_abreviatura}}</li>				
			<li><label><strong>Solicitante: </strong></label>{{$ot_retiro->apat_solicitante}} {{$ot_retiro->amat_solicitante}}, {{$ot_retiro->nombre_solicitante}}</li>
			<li><label><strong>Ejecutor del mantenimiento: </strong></label>{{$ot_retiro->apat_ingeniero}} {{$ot_retiro->amat_ingeniero}}, {{$ot_retiro->nombre_ingeniero}}</li>
			<li><label><strong>Fecha programada: </strong></label> {{date("d-m-Y H:i",strtotime($ot_retiro->fecha_programacion))}}</li>						
			<li><label><strong>Servicio hospitalario: </strong></label> {{$ot_retiro->nombre_servicio}}</li>
			<li><label><strong>Ubicación física: </strong></label> {{$ot_retiro->nombre_ubicacion}}</li>
		</ul>
		<h3>Datos del equipo</h3>
		<ul class="lista_generales">
			<li><label><strong>Nombre del equipo: </strong></label> {{$ot_retiro->nombre_equipo}}</li>
			<li><label><strong>Código patrimonial: </strong></label> {{$ot_retiro->codigo_patrimonial}}</li>
			<li><label><strong>Número de serie: </strong></label> {{$ot_retiro->numero_serie}}</li>
			<li><label><strong>Marca: </strong></label> {{$ot_retiro->nombre_marca}}</li>
			<li><label><strong>Modelo: </strong></label> {{$ot_retiro->modelo}}</li>
		</ul>
		<h3>Datos del reporte de retiro</h3>
		<ul class="lista_generales">
			<li><label><strong>Fecha de baja: </strong></label> {{date('d-m-Y H:i:s',strtotime($ot_retiro->fecha_baja))}}</li>
			<li><label><strong>Fecha de conformidad: </strong></label> {{($ot_retiro->fecha_conformidad != null ? date('d-m-Y H:i',strtotime($ot_retiro->fecha_conformidad)) : 'N/A')}}</li>
		</ul>
		<h3>Estado de la Orden de Trabajo</h3>
		<ul class="lista_generales">
			<li><label><strong>Equipo no intervenido: </strong></label> {{$estado_ot->nombre}}</li>
		</ul>
		<h3>Datos del Diagnóstico y Programación</h3>
		<ul class="lista_generales">
			<li><label><strong>Estado inicial del activo: </strong></label> {{$estado_inicial_activo->nombre}}</li>
			<li><label><strong>Estado final del activo: </strong></label> {{($estado_final_activo != null ? $estado_final_activo->nombre : 'N/A')}}</li>
		</ul></div>
		<div>
			<h3>Datos Generales de la Orden de Trabajo de Retiro de Servicio</h3>
			<table style="width:100%">
				<tr><th>Tarea Realizada</th></tr>
				@foreach($tareas as $tarea)
					<tr><td>{{$tarea->nombre}}</td></tr>
				@endforeach
			</table>
		</div>
		<div>
			<h3>Datos de Mano de Obra</h3>
			<table style="width:100%"><tr><th>Nombres y apellidos</th><th>Horas trabajadas</th><th>Costo</th></tr>
				@foreach($personal as $p)
					<tr><td>{{$p->nombre}}</td><td>{{$p->horas_hombre}}</td><td>{{$p->costo}}</td></tr>
				@endforeach
			</table>
			<p>Gasto total en mano de obra: S/. {{number_format($ot_retiro->costo_total_personal,2)}}</p>
		</div>
		<div class="firmas"><h4 class="firma firma-izquierda">Firma del Jefe de servicio clinico</h4>
		<h4 class="firma firma-medio">Firma del Ingeniero UIB</h4>
		<h4 class="firma firma-derecha">Firma del Ingeniero de tumimed</h4></div>
		<ul class="lista_generales">
			<li><label><strong>Documento elaborado por: </strong></label> {{$ot_retiro->apat_elaborador}} {{$ot_retiro->amat_elaborador}}, {{$ot_retiro->nombre_elaborador}}</li>
		</ul>
	</body>
</html>