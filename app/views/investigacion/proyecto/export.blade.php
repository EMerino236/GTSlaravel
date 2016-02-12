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
		<div class="nombre_general">
			<img id="logo" src="img/logo_uib.jpg" ></img>
			<h2 id="titulo" >Proyecto: {{$reporte->codigo}}</h2>
		</div>

		<h3>Datos del Proyecto</h3>
		<ul class="lista_generales">
			<li><label><strong>Nombre:</strong></label> {{$reporte->nombre}}</li>				
			<li><label><strong>Categoría: </strong></label>{{$reporte->categoria->nombre}}</li>
			<li><label><strong>Departamento: </strong></label>{{$reporte->departamento->nombre}}</li>
			<li><label><strong>Servicio clínico: </strong></label> {{$reporte->servicio->nombre}}</li>
			<li><label><strong>Responsable: </strong></label> {{$reporte->responsable->apellido_pat}} {{$reporte->responsable->apellido_mat}}, {{$reporte->responsable->nombre}}</li>
			<li><label><strong>Fecha de inicio: </strong></label> {{$reporte->fecha_ini}}</li>	
			<li><label><strong>Fecha de fin: </strong></label> {{$reporte->fecha_fin}}</li>			
		</ul>

		<h3>Propósito - Justificación</h3>
		<div class="lista_generales">
			{{$reporte->proposito}}
		</div>

		<h3>Objetivos del proyecto</h3>
		<div class="lista_generales">
			{{$reporte->objetivos}}
		</div>

		<h3>Metodología</h3>
		<div class="lista_generales">
			{{$reporte->metodologia}}
		</div>

		<h3>Requerimientos</h3>
		<div>
		<table style="width:100%">
			<tr>
				<th>Requerimiento</th>
			</tr>
			<tbody>
				@foreach($reporte->requerimientos as $req)
					<tr>
						<td>{{$req->descripcion}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>

		<h3>Asunciones</h3>
		<div>
		<table style="width:100%">
			<tr>
				<th>Asunción</th>
			</tr>
			<tbody>
				@foreach($reporte->asunciones as $data)
					<tr>
						<td>{{$data->descripcion}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>

		<h3>Restricciones</h3>
		<div>
		<table style="width:100%">
			<tr>
				<th>Restricción</th>
			</tr>
			<tbody>
				@foreach($reporte->restricciones as $data)
					<tr>
						<td>{{$data->descripcion}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>

		<h3>Riesgos</h3>
		<div>
		<table style="width:100%">
			<tr>
				<th>Descripción</th>
				<th>Tipo</th>
			</tr>
			<tbody>
				@foreach($reporte->riesgos as $data)
					<tr>
						<td>{{$data->descripcion}}</td>
						<td>{{$data->tipo}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>

		<h3>Descripción</h3>
		<div class="lista_generales">
			{{$reporte->descripcion}}
		</div>

		<h3>Resumen del Cronograma</h3>
		<div>
		<table style="width:100%">
			<tr>
				<th>Descripción</th>
				<th>Fecha Inicio</th>
				<th>Fecha Fin</th>
			</tr>
			<tbody>
				@foreach($reporte->cronogramas as $data)
					<tr>
						<td>{{$data->descripcion}}</td>
						<td>{{$data->fecha_ini}}</td>
						<td>{{$data->fecha_fin}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>

		<h3>Resumen de Presupuesto</h3>
		<div>
		<table style="width:100%">
			<tr>
				<th>Descripción</th>
				<th>Monto</th>
			</tr>
			<tbody>
				@foreach($reporte->presupuestos as $data)
					<tr>
						<td>{{$data->descripcion}}</td>
						<td>{{number_format($data->monto,2)}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>

		<h3>Personal involucrado</h3>
		<div>
		<table style="width:100%">
			<tr>
				<th>Nombre</th>
				<th>Rol</th>
				<th>Area</th>
			</tr>
			<tbody>
				@foreach($reporte->personal as $data)
					<tr>
						<td>{{$data->persona->nombre}} {{$data->persona->apellido_pat}} {{$data->persona->apellido_mat}}</td>
						<td>{{$data->persona->rol->nombre}}</td>
						<td>{{$data->persona->area->nombre}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>

		<h3>Entidades o Grupos involucrados</h3>
		<div>
		<table style="width:100%">
			<tr>
				<th>Entidad</th>
			</tr>
			<tbody>
				@foreach($reporte->entidades as $data)
					<tr>
						<td>{{$data->nombre}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>

		<h3>Aprobaciones necesarias</h3>
		<div>
		<table style="width:100%">
			<tr>
				<th>Nombre</th>
				<th>Rol</th>
				<th>Area</th>
			</tr>
			<tbody>
				@foreach($reporte->aprobaciones as $data)
					<tr>
						<td>{{$data->persona->nombre}} {{$data->persona->apellido_pat}} {{$data->persona->apellido_mat}}</td>
						<td>{{$data->persona->rol->nombre}}</td>
						<td>{{$data->persona->area->nombre}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>

	</body>
</html>