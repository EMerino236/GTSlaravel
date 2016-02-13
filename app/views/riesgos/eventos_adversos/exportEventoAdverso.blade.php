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
		<div class="nombre_general"><img id="logo" src="img/logo_uib.jpg" ></img><h2 id="titulo" >Reporte de Evento Adverso {{$evento_adverso_info->codigo_abreviatura}}-{{$evento_adverso_info->codigo_correlativo}}</h2></div>
		<div>
		<h3>Identificacion del Paciente</h3>
		<ul class="lista_generales">
			<li><label><strong>Nombre del Paciente:</strong></label> {{$evento_adverso_info->nombre_paciente}}</li>				
			<li><label><strong>Tipo de Documento: </strong></label>{{$tipo_documento->nombre}}</li>
			<li><label><strong>Número de Documeto: </strong></label>{{$evento_adverso_info->numero_documento}}</li>
			<li><label><strong>Sexo: </strong></label> {{$sexo}}</li>
			<li><label><strong>Edad: </strong></label> {{$evento_adverso_info->edad}}</li>
		</ul>
		<h3>Motivos de Consulta</h3>
		<ul class="lista_generales">
			<li><label><strong>Procedimiento:</strong></label> {{$evento_adverso_info->procedimiento}}</li>
			<li><label><strong>Diagnóstico:</strong></label> {{$evento_adverso_info->diagnostico}}</li>
		</ul>
		<h3>Datos Principales de la Clasificación</h3>
		<ul class="lista_generales">
			<li><label><strong>Fecha de Reporte:</strong></label> {{date('d-m-Y',strtotime($evento_adverso_info->fecha_reporte))}}</li>	
			<li><label><strong>Fecha del Incidente: </strong></label>{{date('d-m-Y',strtotime($evento_adverso_info->fecha_incidente))}}</li>
			<li><label><strong>Frecuencia: </strong></label>{{$tipos_frecuencias->nombre}}</li>
			<li><label><strong>Tipo de Incidente: </strong></label>{{$tipo_incidente->nombre}}</li>
			<li><label><strong>Subclasificación 1 de Tipo de Incidente: </strong></label>{{$padre->nombre}}</li>
			@if($flag_tipoHijo == 1)
				<li><label><strong>Tipo de Caída: </strong></label>{{$nieto1->nombre}}</li>
				<li><label><strong>Elemento Implicado en la Caída: </strong></label>{{$nieto2->nombre}}</li>
			@else
				<li><label><strong>Subclasificación 2 de Tipo de Incidente: </strong></label>{{$hijo->nombre}}</li>
			@endif
		</ul>
		<h3>Resultados del Paciente</h3>
		<ul class="lista_generales">
			<li><label><strong>Tipo de Daño:</strong></label> {{$evento_adverso_info->tipo_danho}}</li>
			<li><label><strong>Grado de Daño: </strong></label>{{$grados_danhos->nombre}}</li>
		</ul>
		<h3>Impacto Social y/o Económico</h3>
		<ul class="lista_generales">
			<li><label><strong>Impacto Socioeconómico:</strong></label> {{$evento_adverso_info->impacto_socioeconomico}}</li>
		</ul>
		<h3>Caracteristicas del Incidente</h3>
		<ul class="lista_generales">
			
			@if($evento_adverso_info->idetapa_servicio == null)
			<li><label><strong>Entorno Asistencial:</strong></label> {{$entorno_asistencial->nombre}}</li>
				<li><label><strong>Observacion:</strong></label> {{$entorno_asistencial->comentario}}</li>
			@else
				<li><label><strong>Entorno Asistencial:</strong></label> {{$entorno_asistencial->nombre}}</li>
				<li><label><strong>Tipo de Servicio:</strong></label> {{$etapa_servicio->nombre_tipo_servicio}}</li>
				<li><label><strong>Etapa de Servicio:</strong></label> {{$etapa_servicio->nombre}}</li>
			@endif
			<li><label><strong>Disciplina/Especialidad:</strong></label> {{$evento_adverso_info->disciplina}}</li>
			<li><label><strong>Factor Contribuyente:</strong></label> {{$factores->nombre}}</li>
			<li><label><strong>Proceso:</strong></label> {{$procesos->nombre}}</li>
		</ul>

		<h3>Descripción del Incidente</h3>
		<ul class="lista_generales">			
			<li><label><strong>Causas:</strong></label> {{$evento_adverso_info->causa}}</li>
			<li><label><strong>Medidas a Tomar:</strong></label> {{$evento_adverso_info->medidas}}</li>
		</ul>

		<h3>Resultados para la Organización</h3>
		<ul class="lista_generales">			
			<li><label><strong>Daño de Bienes:</strong></label> {{$evento_adverso_info->danho_bienes}}</li>
		</ul>

		<h3>Información del Equipo Médico Involucrado</h3>
		<ul class="lista_generales">
			<li><label><strong>Código Patrimonial:</strong></label> {{$activo_info->codigo_patrimonial}}</li>
			<li><label><strong>Servicio Clínico:</strong></label> {{$activo_info->nombre_servicio}}</li>
			<li><label><strong>Ubicación Física:</strong></label> {{$activo_info->nombre_ubicacion_fisica}}</li>
			<li><label><strong>Número de Serie:</strong></label> {{$activo_info->numero_serie}}</li>
			<li><label><strong>Nombre del Equipo:</strong></label> {{$activo_info->nombre_equipo}}</li>
			<li><label><strong>Modelo:</strong></label> {{$activo_info->nombre_modelo}}</li>
			<li><label><strong>Proveedor:</strong></label> {{$activo_info->razon_social}}</li>
		</ul>
		<h3>Información Adicional</h3>
		<ul class="lista_generales">
			<li><label><strong>Información:</strong></label> {{$evento_adverso_info->informacion}}</li>
		</ul>
		<h3>Identificación del Reportante</h3>
		<ul class="lista_generales">
			<li><label><strong>Nombre del Reportante:</strong></label> {{$evento_adverso_info->nombre_reportante}}</li>
			<li><label><strong>Profesión:</strong></label> {{$evento_adverso_info->profesion}}</li>
			<li><label><strong>Dirección:</strong></label> {{$evento_adverso_info->direccion}}</li>
			<li><label><strong>E-mail:</strong></label> {{$evento_adverso_info->email}}</li>
		</ul>
		
		
	</body>
</html>