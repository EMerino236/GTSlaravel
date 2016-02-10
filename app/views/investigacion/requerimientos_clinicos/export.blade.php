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
		<div class="nombre_general"><img id="logo" src="img/logo_uib.jpg" ></img><h2 id="titulo" >Requerimiento Clínico y Hospitalario: {{$reporte->id}}</h2></div>
		<div>
		<h3>Datos del reporte:</h3>
		<ul class="lista_generales">
			<li><label><strong>Nombre:</strong></label> {{$reporte->nombre}}</li>				
			<li><label><strong>Categoría: </strong></label>{{$reporte->categoria->nombre}}</li>
			<li><label><strong>Departamento: </strong></label>{{$reporte->departamento->nombre}}</li>
			<li><label><strong>Servicio clínico: </strong></label> {{$reporte->servicio->nombre}}</li>
			<li><label><strong>Responsable: </strong></label> {{$reporte->responsable->apellido_pat}} {{$reporte->responsable->apellido_mat}}, {{$reporte->responsable->nombre}}</li>
			<li><label><strong>Presupuesto total: </strong></label> {{$reporte->presupuesto}}</li>
			<li><label><strong>Tipo: </strong></label> {{$tipos[$reporte->tipo]}}</li>
			<li><label><strong>Fecha de Inicio: </strong></label> {{$reporte->fecha_fin}}</li>
			<li><label><strong>Fecha de Fin: </strong></label> {{$reporte->fecha_ini}}</li>
		</ul>
		
		<h3>Observaciones:</h3>
		<div class="lista_generales">
			{{$reporte->observaciones}}
		</div>

	</body>
</html>