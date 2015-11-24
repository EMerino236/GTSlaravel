<html>
	<head>
		<meta charset="UTF-8">
		<style>
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
				margin-top:60px;
				position:fixed;
			}
			#logo{
				padding:10px 10px 10px 10px;	
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
				margin-left: 10px;
				margin-right: 10px;
			}
			.firma{
				margin-left: 10px;
			}
		</style>
	</head>
	<body>
		<div class="nombre_general"><img id="logo" src="img/logo_uib.jpg" ></img><h2 id="titulo" >Orden de trabajo de mantenimiento correctivo</h2></div>
		<div>
		<h3>Datos de la orden de trabajo</h3>
		<ul class="lista_generales">
			<li><label><strong>Numero Orden de Mantenimiento:</strong></label> {{$ot_correctivo->ot_tipo_abreviatura}}{{$ot_correctivo->ot_correlativo}}{{$ot_correctivo->ot_activo_abreviatura}}</li>				
			<li><label><strong>Solicitante: </strong></label>{{$ot_correctivo->apat_solicitante}} {{$ot_correctivo->amat_solicitante}}, {{$ot_correctivo->nombre_solicitante}}</li>
			<li><label><strong>Ejecutor del mantenimiento: </strong></label>{{$ot_correctivo->apat_ingeniero}} {{$ot_correctivo->amat_ingeniero}}, {{$ot_correctivo->nombre_ingeniero}}</li>
			<li><label><strong>Fecha programada: </strong></label> {{date("d-m-Y H:i",strtotime($ot_correctivo->fecha_programacion))}}</li>						
			<li><label><strong>Servicio hospitalario: </strong></label> {{$ot_correctivo->nombre_servicio}}</li>
			<li><label><strong>Ubicación física: </strong></label> {{$ot_correctivo->nombre_ubicacion}}</li>
		</ul>
		<h3>Datos del equipo</h3>
		<ul class="lista_generales">
			<li><label><strong>Nombre del equipo: </strong></label> {{$ot_correctivo->nombre_equipo}}</li>
			<li><label><strong>Código patrimonial: </strong></label> {{$ot_correctivo->codigo_patrimonial}}</li>
			<li><label><strong>Número de serie: </strong></label> {{$ot_correctivo->numero_serie}}</li>
			<li><label><strong>Marca: </strong></label> {{$ot_correctivo->nombre_marca}}</li>
			<li><label><strong>Modelo: </strong></label> {{$ot_correctivo->modelo}}</li>
		</ul>
		<h3>Datos del reporte de retiro</h3>
		<ul class="lista_generales">
			<li><label><strong>Fecha de baja: </strong></label> {{date('d-m-Y H:i:s',strtotime($ot_correctivo->fecha_baja))}}</li>
			<li><label><strong>Fecha de conformidad: </strong></label> {{($ot_correctivo->fecha_conformidad != null ? date('d-m-Y H:i',strtotime($ot_correctivo->fecha_conformidad)) : 'N/A')}}</li>
		</ul>
		<h3>Estado de la Orden de Trabajo</h3>
		<ul class="lista_generales">
			<li><label><strong>Prioridad: </strong></label> {{$prioridad->nombre}}</li>
			<li><label><strong>Equipo no intervenido: </strong></label> {{$estado_ot->nombre}}</li>
			<li><label><strong>Descripción del problema: </strong></label> {{$ot_correctivo->descripcion_problema}}</li>
		</ul>
		<h3>Datos del Diagnóstico y Programación</h3>
		<ul class="lista_generales">
			<li><label><strong>Tipo de falla: </strong></label> {{$tipo_falla->nombre}}</li>
			<li><label><strong>Estado inicial del activo: </strong></label> {{$estado_inicial_activo->nombre}}</li>
			<li><label><strong>Diagnóstico de la falla: </strong></label> {{$ot_correctivo->diagnostico_falla}}</li>
		</ul>
		</div>
		<div>
			<h3>Datos Generales de la Orden de Trabajo de Retiro de Servicio</h3>
			<ul class="lista_generales">
				<li><label><strong>Fecha de inicio: </strong></label> {{($ot_correctivo->fecha_inicio_ejecucion != null ? date('d-m-Y H:i',strtotime($ot_correctivo->fecha_inicio_ejecucion)) : 'N/A')}}</li>
				<li><label><strong>Fecha de término: </strong></label> {{($ot_correctivo->fecha_termino_ejecucion != null ? date('d-m-Y H:i',strtotime($ot_correctivo->fecha_termino_ejecucion)) : 'N/A')}}</li>
				<li><label><strong>Garantía: </strong></label> {{$ot_correctivo->garantia}}</li>
				<li><label><strong>Estado final del activo: </strong></label> {{($estado_final_activo != null? $estado_final_activo->nombre : 'N/A')}}</li>
				<li><label><strong>Sin interrupción al servicio: </strong></label> {{($ot_correctivo->sin_interrupcion_servicio == 1 ? 'SI' : 'NO')}}</li>
			</ul>
			<table style="width:100%">
				<tr><th>Tarea Realizada</th></tr>
				@foreach($tareas as $tarea)
					<tr><td>{{$tarea->nombre}}</td></tr>
				@endforeach
			</table>
		</div>
		<div>
			<h3>Datos de Repuestos</h3>
			<table style="width:100%">
				<tr><th>Nombre</th><th>Código</th><th>Cantidad</th><th>Costo</th></tr>
				@foreach($repuestos as $repuesto)
					<tr><td>{{$repuesto->nombre}}</td><td>{{$repuesto->codigo}}</td><td>{{$repuesto->cantidad}}</td><td>{{number_format($repuesto->costo,2)}}</td></tr>
				@endforeach
			</table>
			<p>Gasto total en repuestos: S/. {{number_format($ot_correctivo->costo_total_repuestos,2)}}</p>
		</div>
		<div>
			<h3>Datos de Mano de Obra</h3>
			<table style="width:100%"><tr><th>Nombres y apellidos</th><th>Horas trabajadas</th><th>Subtotal</th></tr>
				@foreach($personal as $p)
					<tr><td>{{$p->nombre}}</td><td>{{$p->horas_hombre}}</td><td>{{$p->costo}}</td></tr>
				@endforeach
			</table>
			<p>Gasto total en mano de obra: S/. {{number_format($ot_correctivo->costo_total_personal,2)}}</p>
		</div>
		<div class="firmas"><h4 class="firma firma-izquierda">Firma del Jefe de servicio clinico</h4>
		<h4 class="firma firma-medio">Firma del Ingeniero UIB</h4>
		<h4 class="firma firma-derecha">Firma del Ingeniero de tumimed</h4></div>
		<ul class="lista_generales">
			<li><label><strong>Documento elaborado por: </strong></label> {{$ot_correctivo->apat_elaborador}} {{$ot_correctivo->amat_elaborador}}, {{$ot_correctivo->nombre_elaborador}}</li>
		</ul>
	</body>
</html>