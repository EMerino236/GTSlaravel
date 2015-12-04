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
			.#titulo{
				text-align:center;
				margin-top:30px;
				position:fixed;
			}
			.#logo{
				padding:10px 10px 10px 10px;
				width: 80px;
			}
		</style>
	</head>
	<body>
		<div class="nombre_general"><img id="logo" src="img/logo_uib.jpg" ></img>
			<h2 id="titulo" >OT de Verificacion Metrologica: {{$ot_vm->ot_tipo_abreviatura}}{{$ot_vm->ot_correlativo}}{{$ot_vm->ot_activo_abreviatura}}</h2>
		</div>
		<div>
			<h3>Datos de la orden de trabajo</h3>
			<ul class="lista_generales">
				<li><label><strong>Usuario Solicitante: </strong></label> {{$usuarioSolicitante->apellido_pat}} {{$usuarioSolicitante->apellido_mat}} {{$usuarioSolicitante->nombre}}</li>					
				<li><label><strong>Servicio Hospitalario: </strong></label> {{$servicio->nombre}}</li>
				<li><label><strong>Ejecutor del Mantenimiento: </strong></label> {{$ejecutor}}</li>							
				<li><label><strong>Ubicacion Fisica: </strong></label> {{$ubicacion->nombre}}</li>
				<li><label><strong>Numero de Ficha: </strong></label> {{$numero_ficha}}</li>
			</ul>
		</div>	
		<div>
			<h3>Datos del equipo</h3>
			<ul class="lista_generales">
				<li><label><strong>Nombre del Equipo: </strong></label> {{$familia->nombre_equipo}}</li>						
				<li><label><strong>Codigo Patrimonial: </strong></label> {{$activo->codigo_patrimonial}}</li>
				<li><label><strong>Marca: </strong></label> {{$marca->nombre}}</li>
				<li><label><strong>Numero de Serie: </strong></label> {{$activo->numero_serie}}</li>							
				<li><label><strong>Modelo: </strong></label> {{$modelo->nombre}}</li>
			</ul>
		</div>	
		<div>
			<h3>Datos del reporte de Verificacion Metrologica</h3>
			<ul class="lista_generales">
				<li><label><strong>Fecha y Hora de Programacion: </strong></label> {{$fecha_programacion}}</li>						
				<li><label><strong>Fecha y Hora de Conformidad: </strong></label> {{$fecha_conformidad}}</li>
			</ul>
		</div>				
		<div>
			<h3>Datos de Mano de Obra</h3>
			<table style="width:100%"><tr><th>Nombres y apellidos</th><th>Horas trabajadas</th><th>Sub Total</th></tr>
				@foreach($personal_data as $p)
					<tr><td>{{$p->nombre}}</td><td>{{$p->horas_hombre}}</td><td>{{$p->costo}}</td></tr>
				@endforeach
			</table>
			<p>Gasto Total Mano de Obra: S/. {{number_format($ot_vm->costo_total,2)}}</p>
		</div>
		<ul class="lista_generales">
			<li><label><strong>Documento elaborado por: </strong></label> {{$usuarioElaborador->apellido_pat}} {{$usuarioElaborador->apellido_mat}} {{$usuarioElaborador->nombre}}</li>
		</ul>
	</body>
.</html>