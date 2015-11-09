<?php

class SolicitudesController extends BaseController


{
	private static $nombre_tabla = 'estado_solicitud_compra';
	public function list_solicitudes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search_tipo_solicitud"]=null;
				$data["tipos"] = TipoSolicitudCompra::lists('nombre','idtipo_solicitud_compra');				
				$data["search_servicio"]=null;
				$data["search_estado"]=null;
				$data["search_nombre_equipo"]=null;
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["fecha_desde"] = null;
				$data["fecha_hasta"] = null;
				$data["solicitudes_data"] = SolicitudCompra::getSolicitudesInfo()->paginate(10);
				return View::make('solicitudes_compra/listSolicitudesCompra',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_solicitud(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_tipo_solicitud"] = Input::get('search_tipo_solicitud');				
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipos"] = TipoSolicitudCompra::lists('nombre','idtipo_solicitud_compra');
				$data["search_servicio"]=Input::get('search_servicio');
				$data["search_estado"]=Input::get('search_estado');
				$data["search_nombre_equipo"]=Input::get('search_nombre_equipo');
				$data["fecha_desde"] = Input::get('fecha_desde');
				$data["fecha_hasta"] = Input::get('fecha_hasta');
				$data["solicitudes_data"] = SolicitudCompra::searchSolicitudes($data["search_tipo_solicitud"],$data["search_servicio"],$data["search_estado"],$data["search_nombre_equipo"],$data["fecha_desde"],$data["fecha_hasta"])->paginate(10);
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				//if($data["search"]==0){
					return View::make('solicitudes_compra/listSolicitudesCompra',$data);
				/*}else{
					return View::make('areas/listAreas',$data);	
				}*/
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_equipos_ajax(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !=0){
				$equipos = FamiliaActivo::searchFamiliaActivo("",$data)->get();
			}else{
				$equipos = null;
			}

			return Response::json(array( 'success' => true, 'list_equipos' => $equipos ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_activos_ajax(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !=0){
				$activos = Activo::searchActivosByFamilia($data)->get();
			}else{
				$activos = null;
			}

			return Response::json(array( 'success' => true, 'list_activos' => $activos ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}


	public function render_create_solicitud(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){	
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["tipos"] = TipoSolicitudCompra::lists('nombre','idtipo_solicitud_compra');
				$data["servicios"] = Servicio::searchServiciosClinicos(1)->lists('nombre','idservicio');
				$data["marcas1"] = Marca::lists('nombre','idmarca');
				$data["nombre_equipos1"] = array('0'=>'Seleccione');
				$data["usuarios_responsable"] = User::getJefes()->get();
				return View::make('solicitudes_compra/createSolicitudCompra',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_solicitud($idsolicitud=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){	
				$data["reporte_data"] = SolicitudCompra::getSolicitudCompraById($idsolicitud)->get();
				if($data["reporte_data"]->isEmpty()){
					return Redirect::to('solicitudes_compra/list_solicitudes');
				}
				$data["reporte_data"] = $data["reporte_data"][0];	
				$data["documento_info"] = Documento::searchDocumentoByIdSolicitudCompra($data["reporte_data"]->idsolicitud_compra)->get();
				$data["documento_info"] = $data["documento_info"][0];
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["tipos"] = TipoSolicitudCompra::lists('nombre','idtipo_solicitud_compra');
				$data["servicios"] = Servicio::searchServiciosClinicos(1)->lists('nombre','idservicio');
				$familia = FamiliaActivo::find($data["reporte_data"]->idfamilia_activo);
				$data["marcas1"] = Marca::lists('nombre','idmarca');
				$data["nombre_equipos1"] = FamiliaActivo::searchFamiliaActivoByMarca($familia->idmarca)->lists('nombre_equipo','idfamilia_activo');
				$data["usuarios_responsable"] = User::getJefes()->get();
				$data["detalles_solicitud"] = DetalleSolicitudCompra::getDetalleSolicitudCompra($data["reporte_data"]->idsolicitud_compra)->get();
				return View::make('solicitudes_compra/editSolicitudCompra',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function return_name_reporte(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$documento = Documento::searchDocumentoByCodigoArchivamiento($data)->get();
				
			}else{
				$documento = null;
			}

			return Response::json(array( 'success' => true, 'reporte' => $documento ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function validate_ot(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data!="vacio"){
				$ot = OrdenesTrabajo::searchOtById($data)->get();
			}else{
				$ot = null;
			}

			return Response::json(array( 'success' => true, 'ot' => $ot ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function download_reporte()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$codigo = Input::get('numero_reporte_hidden');		
				$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo)->get();
				$file= $documento[0]->url;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($file),$headers);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_solicitud(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			
			$idtipo_solicitud_compra = Input::get('tipo_solicitud');
			$fecha_actual = date('Y-m-d');
			$fecha = date('Y-m-d H:i:s',strtotime(Input::get('fecha')));
			$numero_ot = Input::get('numero_ot');
			$equipo = Input::get('equipo');
			$sustento = Input::get('sustento');
			$usuario_responsable = Input::get('usuario_responsable');
			$servicio = Input::get('servicio');
			$estado = Input::get('estado');			
			$codigo_archivamiento = Input::get('numero_reporte');
			$array_detalles = Input::get('matrix_detalle');
			$row_size = count($array_detalles);

			if($idtipo_solicitud_compra==0 || $fecha=="" || $numero_ot=="" || $equipo==0 || $usuario_responsable==0 || $servicio==0 || $estado==0 || $codigo_archivamiento == "" || $row_size==0){				
				$message = "No se guardaron los cambios del Requerimiento. Completar campos obligatorios.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}			
			$solicitud = new SolicitudCompra;
			$solicitud->idtipo_solicitud_compra = $idtipo_solicitud_compra;
			//validar fecha 
			if($fecha_actual>$fecha){
				$message = "No se guardaron los cambios del Requerimiento. No se puede registrar fecha pasada.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}
			$solicitud->fecha = $fecha;
			$solicitud->codigo_ot = $numero_ot;
			$solicitud->idfamilia_activo = $equipo;
			$solicitud->sustento = $sustento;
			$solicitud->id_responsable = $usuario_responsable;	
			$solicitud->idservicio = $servicio;
			$solicitud->idestado = $estado;
			//Agregar Detalle
			
			if($row_size > 0){				
				$message = "Se guardaron los cambios del Requerimiento de Compra";
				$type_message = "bg-success";
				$solicitud->save();	
				for( $i = 0; $i<$row_size; $i++ ){
					$array_detalle = $array_detalles[$i];					
					$detalle_solicitud = new DetalleSolicitudCompra;
					$detalle_solicitud->descripcion = $array_detalle[1];
					$detalle_solicitud->modelo = $array_detalle[2];
					$detalle_solicitud->marca = $array_detalle[3];
					$detalle_solicitud->serie_parte = $array_detalle[4];
					$detalle_solicitud->cantidad = $array_detalle[5];
					$detalle_solicitud->idsolicitud_compra = $solicitud->idsolicitud_compra;
					$detalle_solicitud->save();			
				}							
			}else{
				$message = "No se guardaron los cambios del Requerimiento. No hay detalles del Requerimiento.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}
			//Agregar documentos
			
			$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento)->get();
			if($documento->isEmpty()){
				$type_message = "bg-danger";
				$message = "No se pudo registrar los cambios, el documento no existe";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'type_message' => $type_message, 'message' => $mensaje ),200);
			}
			$documento = $documento[0];
			$documento->idsolicitud_compra = $solicitud->idsolicitud_compra;
			$documento->save();		
			return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_edit_solicitud(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$idsolicitud_compra = Input::get('idsolicitud');
			$idtipo_solicitud_compra = Input::get('tipo_solicitud');
			$fecha = date('Y-m-d H:i:s',strtotime(Input::get('fecha')));
			$fecha_actual = date('Y-m-d');
			$numero_ot = Input::get('numero_ot');
			$equipo = Input::get('equipo');
			$sustento = Input::get('sustento');
			$usuario_responsable = Input::get('usuario_responsable');
			$servicio = Input::get('servicio');
			$estado = Input::get('estado');			
			$codigo_archivamiento = Input::get('numero_reporte');
			$array_detalles = Input::get('matrix_detalle');
			$row_size = count($array_detalles);

			if($idtipo_solicitud_compra==0 || $fecha=="" || $numero_ot=="" || $equipo==0 || $usuario_responsable==0 || $servicio==0 || $estado==0 || $codigo_archivamiento == "" || $row_size==0){				
				$message = "No se guardaron los cambios del Requerimiento. No se puede registrar fecha pasada.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}
			
			$solicitud = SolicitudCompra::find($idsolicitud_compra);
			$solicitud->idtipo_solicitud_compra = Input::get('tipo_solicitud');
			if($fecha_actual > $fecha){
				$message = "No se guardaron los cambios del Requerimiento. Completar campos obligatorios.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}
			$solicitud->fecha = $fecha;
			$solicitud->codigo_ot = Input::get('numero_ot');
			$solicitud->idfamilia_activo = Input::get('equipo');
			$solicitud->sustento = Input::get('sustento');
			$solicitud->id_responsable = Input::get('usuario_responsable');	
			$solicitud->idservicio = Input::get('servicio');
			$solicitud->idestado = Input::get('estado');
			//Editar documentos
			$documento_actual = Documento::searchDocumentoByIdSolicitudCompra($solicitud->idsolicitud_compra)->get();
			$documento_actual = $documento_actual[0];
			
			$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento)->get();
			if($documento->isEmpty()){
				$type_message = "bg-danger";
				$message = "No se pudo registrar los cambios, el documento no existe";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'type_message' => $type_message, 'message' => $message ),200);
			}
			$documento = $documento[0];
			//se realizará la modificación siempre y cuando se cambie el documento por otro.
			if($documento_actual->iddocumento<>$documento->iddocumento){
				$documento_actual->idsolicitud_compra = null;
				$documento->idsolicitud_compra = $solicitud->idsolicitud_compra;
				$documento_actual->save();
				$documento->save();
			}
			//Editar Detalle			
			if($row_size > 0){				
				$message = "Se guardaron los cambios del Requerimiento de Compra";
				$type_message = "bg-success";
				for( $i = 0; $i<$row_size; $i++ ){
					$array_detalle = $array_detalles[$i];
					$detalle_solicitud = DetalleSolicitudCompra::getDetalleSolicitudCompraById($array_detalle[0])->get();
					if($detalle_solicitud->isEmpty()==false){ 
						//quiere decir que el detalle existe, entonces leemos los datos y hacemos el save
						$detalle_solicitud = $detalle_solicitud[0];
						$detalle_solicitud->descripcion = $array_detalle[1];
						$detalle_solicitud->modelo = $array_detalle[2];
						$detalle_solicitud->marca = $array_detalle[3];
						$detalle_solicitud->serie_parte = $array_detalle[4];
						$detalle_solicitud->cantidad = $array_detalle[5];
						$detalle_solicitud->save();
					}else{
						$detalle_solicitud = new DetalleSolicitudCompra;
						$detalle_solicitud->descripcion = $array_detalle[1];
						$detalle_solicitud->modelo = $array_detalle[2];
						$detalle_solicitud->marca = $array_detalle[3];
						$detalle_solicitud->serie_parte = $array_detalle[4];
						$detalle_solicitud->cantidad = $array_detalle[5];
						$detalle_solicitud->idsolicitud_compra = $idsolicitud_compra;
						$detalle_solicitud->save();
					}					
				}
				//Para los detalles que se van a borrar
				$array_detalle_toDelete = Input::get('matrix_detalle_delete');
				$size_delete = Input::get('size_delete');
				if($size_delete>0){
					for( $j=0 ;$j<$size_delete;$j++){
						$array_detalle = $array_detalle_toDelete[$j];
						$detalle_solicitud_toDelete = DetalleSolicitudCompra::getDetalleSolicitudCompraById($array_detalle[0])->get();
						if($detalle_solicitud_toDelete->isEmpty()==false){
							$detalle_solicitud_toDelete = $detalle_solicitud_toDelete[0];
							$detalle_solicitud_toDelete->forceDelete();
						}
					}
				}
				$solicitud->save();
			}else{
				$message = "No se guardaron los cambio del Requerimiento. No hay detalles del Requerimiento.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}
			return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_enable_solicitud(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$solicitud_id = Input::get('reporte_id');
				$url = "solicitudes_compra/edit_solicitud_compra"."/".$solicitud_id;
				$solicitud = SolicitudCompra::withTrashed()->find($solicitud_id);
				$solicitud->restore();
				Session::flash('message', 'Se habilitó correctamente el requerimiento.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_disable_solicitud(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$solicitud_id = Input::get('reporte_id');
				$url = "solicitudes_compra/edit_solicitud_compra"."/".$solicitud_id;
				$solicitud = SolicitudCompra::withTrashed()->find($solicitud_id);
				$solicitud->delete();
				Session::flash('message','Se inhabilitó correctamente el requerimiento.' );
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function export_pdf(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$solicitud_id = Input::get('solicitud_id');
				$solicitud = SolicitudCompra::find($solicitud_id);

				if($solicitud==null){
					$url = "solicitudes_compra/edit_solicitud_compra"."/".$solicitud_id;
					return Redirect::to($url);
				}
				$servicio = Servicio::find($solicitud->idservicio);
				$familia = FamiliaActivo::find($solicitud->idfamilia_activo);
				$usuario = User::find($solicitud->id_responsable);
				$tipo_solicitud = TipoSolicitudCompra::find($solicitud->idtipo_solicitud_compra);
				$estado = Estado::find($solicitud->idestado);
				$documento = Documento::searchDocumentoByIdSolicitudCompra($solicitud_id)->get();
				$documento = $documento[0];
				$detalle_solicitud = DetalleSolicitudCompra::getDetalleSolicitudCompra($solicitud_id)->get();
				$size = count($detalle_solicitud);
				$table = '<table style="width:100%">'
						.'<tr><th>Descripcion</th><th>Marca</th><th>Modelo</th><th>Serie/Numero Parte</th><th>Cantidad</th></tr>';
				for($i = 0; $i < $size; $i++){
					$detalle = $detalle_solicitud[$i];
					$table = $table.'<tr>'.'<td>'.$detalle->descripcion.'</td>'.
							'<td>'.$detalle->modelo.'</td>'.
							'<td>'.$detalle->marca.'</td>'.
							'<td>'.$detalle->serie_parte.'</td>'.
							'<td>'.$detalle->cantidad.'</td>'.

							'</tr>';
				}
				$table=$table.'</table>';
				$html = '<html><head><style>'.
						'table, th, td {
    						border: 1px solid black;
    						border-collapse: collapse;
						}'.
						'th, td {
							text-align: center;
						}'
						.'.lista_generales{
							list-style-type:none;
							border:1px solid black;
							width:100%;
						}'
						.'li{
							margin-bottom:5px;
							margin-left:-15px;
						}'
						.'.nombre_general{
							width:100%;
						}'
						.'#titulo{
							text-align:center;
							margin-top:60px;
							position:fixed;
						}'
						.'#logo{
							padding:10px 10px 10px 10px;	
						}'
						.'</style>
						</head>'.
						'<div class="nombre_general"><img id="logo" src="img/logo_uib.jpg" ></img><h2 id="titulo" >Requerimiento de Compra: N°'.$solicitud->idsolicitud_compra.'</h2></div>'
						.'<div>'
						.'<ul class="lista_generales">'
							.'<li><label><strong>Numero Orden de Mantenimiento</strong></label>: OT N° '.$solicitud->idordenes_trabajo.'</li>'						
							.'<li><label><strong>Servicio: </strong></label>'.$servicio->nombre.'</li>'
							.'<li><label><strong>Nombre del Equipo: </strong></label>'.$familia->nombre_equipo.'</li>'
							.'<li><label><strong>Usuario Responsable: </strong></label>'.$usuario->apellido_pat.' '.$usuario->apellido_mat.', '.$usuario->nombre.'</li>'							
							.'<li><label><strong>Tipo de Requerimiento: </strong></label>'.$tipo_solicitud->nombre.'</li>'
							.'<li><label><strong>Fecha: </strong></label>'.$solicitud->fecha.'</li>'
							.'<li><label><strong>Estado: </strong></label>'.$estado->nombre.'</li>'
							.'<li><label><strong>Sustento: </strong></label>'.$solicitud->sustento.'</li>'
							.'<li><label><strong>Reporte de Necesidad: </strong></label>'.$documento->codigo_archivamiento.'</li>'
						.'</ul></div>'						
						.'<div>'.$table.'</div>'	
						.'</html>';
				
				return PDF::load($html,"A4","portrait")->show();
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}