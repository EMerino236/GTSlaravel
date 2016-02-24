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
			<h2 id="titulo" >Guia de Aprendizaje - Proyecto: {{$plan->proyecto->codigo}}</h2>
		</div>

		<h3>Datos de la guia</h3>
		<ul class="lista_generales">
			<li><label><strong>Nombre:</strong></label> {{$plan->nombre}}</li>				
			<li><label><strong>Categoría: </strong></label>{{$plan->categoria->nombre}}</li>
			<li><label><strong>Departamento: </strong></label>{{$plan->departamento->nombre}}</li>
			<li><label><strong>Servicio clínico: </strong></label> {{$plan->servicioClinico->nombre}}</li>
			<li><label><strong>Responsable: </strong></label> {{$plan->responsable->apellido_pat}} {{$plan->responsable->apellido_mat}}, {{$plan->responsable->nombre}}</li>
		</ul>

		<h3>Descripción</h3>
		<div class="lista_generales">
			{{$plan->descripcion}}
		</div>

		<h3>Objetivo</h3>
		<div class="lista_generales">
			{{$plan->objetivo}}
		</div>

		<h3>Personal involucrado</h3>
		<div class="lista_generales">
			{{$plan->personal}}
		</div>

		<h3>Competencias requeridas</h3>
		<div class="lista_generales">
			{{$plan->competencias_requeridas}}
		</div>

		<h3>Actividades</h3>
		<div>
			<table style="width:100%">
				<tr>
					<th>Actividad</th>
					<th>Descripción</th>
					<th>Servicio Involucrado</th>
					<th>Fecha</th>
					<th>Duración</th>
				</tr>
				<tbody>
					@foreach($plan->actividades as $actividad)
						<tr>
							<td>{{$actividad->nombre}}</td>
							<td>{{$actividad->descripcion}}</td>
							<td>{{$actividad->servicio}}</td>
							<td>{{$actividad->fecha}}</td>
							<td>{{$actividad->duracion}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<h3>Recursos Necesarios</h3>

		<h3>Infraestructura</h3>
		<div class="lista_generales">
			{{$plan->infraestructura}}
		</div>

		<h3>Equipos</h3>
		<div class="lista_generales">
			{{$plan->equipos}}
		</div>

		<h3>Herramientas</h3>
		<div class="lista_generales">
			{{$plan->herramientas}}
		</div>

		<h3>Insumos</h3>
		<div class="lista_generales">
			{{$plan->insumos}}
		</div>

		<h3>Equipo Personal</h3>
		<div class="lista_generales">
			{{$plan->equipo_personal}}
		</div>

		<h3>Condiciones de seguridad</h3>
		<div class="lista_generales">
			{{$plan->condiciones}}
		</div>

		<div>
			<table style="width:100%">
				<tr>
					<th>Competencia Generada</th>
					<th>Indicador de logro</th>
				</tr>
				<tbody>
					@foreach($plan->recursos as $recurso)
						<tr>
							<td>{{$recurso->competencia_generada}}</td>
							<td>{{$recurso->indicador}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</body>
</html>