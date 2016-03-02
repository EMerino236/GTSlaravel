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
			<h2 id="titulo" >Precios Referenciales</h2>
		</div>
		<div>
			<h3>Datos del Equipo</h3>
			<ul class="lista_generales">
				<li><label><strong>Nombre de Equipo: </strong></label> {{$cotizacion_data->nombre_equipo}}</li>					
				<li><label><strong>Nombre Detallado: </strong></label> {{$cotizacion_data->nombre_detallado}}</li>
			</ul>
		</div>			
		<div>
			<h3>Compras INMP</h3>
			<table style="width:100%"><tr><th>Código de Compra</th><th>Marca</th><th>Modelo</th><th>Proveedor</th><th>Enlace</th><th>{{$anho_actual}}</th></tr>
				@foreach($activos_precio_historico as $activo_precio_historico)
			<tr>
				<td>
					{{$activo_precio_historico->codigo_compra}}
				</td>
				<td>
					{{$activo_precio_historico->marca}}
				</td>
				<td>
					{{$activo_precio_historico->modelo_equipo}}
				</td>
				<td>
					{{$activo_precio_historico->proveedor}}
				</td>
				<td>
					{{$activo_precio_historico->enlace_seace}}
				</td>
				<td>
					{{$activo_precio_historico->precio6}}
				</td>
			</tr>
			@endforeach
			</table>
		</div>
		<div>
			<h3>Cotizaciones</h3>
			<table style="width:100%"><tr>
				<th>Código Cotización</th>
				<th>Marca</th>
				<th>Modelo</th>
				<th>Proveedor</th>
				<th>Enlace</th>
				<th>{{$anho_actual}}</th>
			</tr>
			@foreach($cotizaciones_historico as $cotizacion_historico)
			<tr>
				<td>
					{{$cotizacion_historico->codigo_cotizacion}}
				</td>
				<td>
					{{$cotizacion_historico->marca}}
				</td>
				<td>
					{{$cotizacion_historico->modelo_equipo}}
				</td>
				<td>
					{{$cotizacion_historico->proveedor}}
				</td>
				<td>
					{{$cotizacion_historico->enlace_seace}}
				</td>
				<td>
					{{$cotizacion_historico->precio6}}
				</td>
			</tr>
			@endforeach
			</table>
		</div>
		<div>
			<h3>Referencias Seace</h3>
			<table style="width:100%"><tr>
				<th>Referencia Seace</th>
				<th>Marca</th>
				<th>Modelo</th>
				<th>Proveedor</th>
				<th>Enlace</th>
				<th>{{$anho_actual}}</th>
			</tr>
			@foreach($referencias_seace_historico as $referencia_seace_historico)
			<tr>
				<td>
					-
				</td>
				<td>
					{{$referencia_seace_historico->marca}}
				</td>
				<td>
					{{$referencia_seace_historico->modelo_equipo}}
				</td>
				<td>
					{{$referencia_seace_historico->proveedor}}
				</td>
				<td>
					{{$referencia_seace_historico->enlace_seace}}
				</td>
				<td>
					{{$referencia_seace_historico->precio6}}
				</td>
			</tr>
			@endforeach
			</table>
		</div>
	</body>
.</html>