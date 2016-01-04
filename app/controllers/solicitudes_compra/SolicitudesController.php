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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_solicitud(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_tipo_solicitud"] = Input::get('search_tipo_solicitud');				
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipos"] = TipoSolicitudCompra::lists('nombre','idtipo_solicitud_compra');
				$data["search_servicio"]=Input::get('search_servicio');
				$data["search_estado"]=Input::get('search_estado');
				$data["search_nombre_equipo"]=Input::get('search_nombre_equipo');
				$data["fecha_desde"] = Input::get('fecha_desde');
				$data["fecha_hasta"] = Input::get('fecha_hasta');
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				if($data["search_tipo_solicitud"]==0 && $data["search_servicio"]==0 && $data["search_estado"]==0
					&& $data["search_nombre_equipo"]==null && $data["fecha_desde"] == null && $data["fecha_hasta"]==null){
					$data["solicitudes_data"] = SolicitudCompra::getSolicitudesInfo()->paginate(10);
					return View::make('solicitudes_compra/listSolicitudesCompra',$data);
				}else{
					$data["solicitudes_data"] = SolicitudCompra::searchSolicitudes($data["search_tipo_solicitud"],$data["search_servicio"],$data["search_estado"],$data["search_nombre_equipo"],$data["fecha_desde"],$data["fecha_hasta"])->paginate(10);
					return View::make('solicitudes_compra/listSolicitudesCompra',$data);	
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_equipos_ajax(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 ){	
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["tipos"] = TipoSolicitudCompra::lists('nombre','idtipo_solicitud_compra');
				$data["servicios"] = Servicio::searchServiciosClinicos(1)->lists('nombre','idservicio');
				$data["marcas1"] = Marca::lists('nombre','idmarca');
				$data["nombre_equipos1"] = array('0'=>'Seleccione');
				$data["usuarios_responsable"] = User::getJefes()->get();
				return View::make('solicitudes_compra/createSolicitudCompra',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_solicitud($idsolicitud=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9){	
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
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_solicitud($idsolicitud=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){	
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
				return View::make('solicitudes_compra/viewSolicitudCompra',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function return_name_reporte(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			$documento = Documento::searchDocumentoByCodigoArchivamiento($data)->get();
			if(!$documento->isEmpty()){ //existe el doc
				$documento = $documento[0];
				if($documento->idtipo_documento == 8){//si es reporte de necesidad, se valida ahora si el documento ya fue tomado
					$solicitud = SolicitudCompra::getSolicitudCompraByIdDocumento($documento->iddocumento)->get();
					if($solicitud->isEmpty())
						$solicitud = null;
					else
						$solicitud = $solicitud[0];
				}else{
					$documento = null;
					$solicitud = null;
				}				
			}else{
				$solicitud = null;
				$documento = null;
			} 

			return Response::json(array( 'success' => true, 'reporte' => $documento ,'solicitud' => $solicitud),200);
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
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$codigo = Input::get('numero_reporte_hidden');		
				$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo)->get();
				$file= $documento[0]->url.$documento[0]->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($documento[0]->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	
	public function submit_enable_solicitud(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 ){
				$solicitud_id = Input::get('reporte_id');
				$url = "solicitudes_compra/edit_solicitud_compra"."/".$solicitud_id;
				$solicitud = SolicitudCompra::withTrashed()->find($solicitud_id);
				$solicitud->restore();
				Session::flash('message', 'Se habilitó correctamente el requerimiento.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_solicitud(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 ){
				$solicitud_id = Input::get('reporte_id');
				$url = "solicitudes_compra/edit_solicitud_compra"."/".$solicitud_id;
				$solicitud = SolicitudCompra::withTrashed()->find($solicitud_id);
				$solicitud->delete();
				Session::flash('message','Se inhabilitó correctamente el requerimiento.' );
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function export_pdf(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_solicitud()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'numero_ot' => 'Número de OT',
					'servicio' => 'Servicio',
					'nombre_equipo1' => 'Equipo',
					'marca1' => 'Marca',
					'usuario_responsable' => 'Usuario Responsable',
					'tipo' => 'Tipo de Requerimiento',
					'fecha' => 'Fecha',
					'estado' => 'Estado',
					'sustento' => 'Sustento',
					'numero_reporte' => 'Reporte de Necesidad'
				);

				$messages = array();

				$rules = array(
					'numero_ot' => 'required',
					'servicio' => 'required',
					'nombre_equipo1' => 'required',
					'marca1' => 'required',
					'usuario_responsable' => 'required',
					'tipo' => 'required',
					'fecha' => 'required',
					'estado' => 'required',
					'sustento' => 'max:500|alpha_num_spaces_slash_dash_enter',
					'numero_reporte' => 'required',
					'flag_doc' => 'min:1'
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('solicitudes_compra/create_solicitud')->withErrors($validator)->withInput(Input::all());
				}else{
					$count_details = Input::get('count_details');
					if($count_details == 0 ){
						//no se podrá crear nada porque no se ha creado ningún detalle
						Session::flash('error', 'No se cuenta con detalles.');
						return Redirect::to('solicitudes_compra/create_solicitud');
					}else{
						$flag_ot = Input::get('flag_ot');
						$flag_doc = Input::get('flag_doc');
						if($flag_ot == 1){
							Session::flash('error', 'Orden de Mantenimiento no Válido.');
							return Redirect::to('solicitudes_compra/create_solicitud')->withInput(Input::all());;
						}else if($flag_doc == 0){
							Session::flash('error', 'Documento no adjuntado correctamente.');
							return Redirect::to('solicitudes_compra/create_solicitud')->withInput(Input::all());;
						}else{
							//Registramos los datos generales
							//Previamente para no crear la solicitud de compra sin documento,
							//se verifica si el documento existe o es de tipo Reporte de Necesidad
													
							$codigo_archivamiento = Input::get('numero_reporte');
							$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento)->get();
							$documento = $documento[0];
							

							$solicitud = new SolicitudCompra;
							$solicitud->codigo_ot = Input::get('numero_ot');
							$solicitud->idtipo_solicitud_compra = Input::get('tipo');
							$solicitud->idfamilia_activo = Input::get('nombre_equipo1');
							$solicitud->id_responsable = Input::get('usuario_responsable');
							$solicitud->fecha = date("Y-m-d",strtotime(Input::get('fecha')));
							$solicitud->idservicio = Input::get('servicio');
							$solicitud->sustento = Input::get('sustento');
							$solicitud->idestado = Input::get('estado');
							$solicitud->save();

							//Registramos el documento:							
							$documento->idsolicitud_compra = $solicitud->idsolicitud_compra;
							$documento->save();		

							//Registramos el detalle de la solicitud:
							$idsolicitud = $solicitud->idsolicitud_compra;
							$details_descripcion = Input::get('details_descripcion');
							$details_modelo = Input::get('details_modelo');
							$details_marca = Input::get('details_marca');
							$details_serie_parte = Input::get('details_serie');
							$details_cantidad = Input::get('details_cantidad');

							for($i=0;$i<$count_details;$i++){
								$detalle = new DetalleSolicitudCompra;
								$detalle->descripcion = $details_descripcion[$i];								
								$detalle->modelo = $details_modelo[$i];				
								$detalle->marca = $details_marca[$i];
								$detalle->serie_parte = $details_serie_parte[$i];
								$detalle->cantidad = $details_cantidad[$i];
								$detalle->idsolicitud_compra = $idsolicitud;	
								$detalle->save();
							}
						}
					}
					Session::flash('message', 'Se guardó correctamente la información.');
					return Redirect::to('solicitudes_compra/list_solicitudes');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_solicitud()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'numero_ot' => 'Número de OT',
					'servicio' => 'Servicio',
					'nombre_equipo1' => 'Equipo',
					'marca1' => 'Marca',
					'usuario_responsable' => 'Usuario Responsable',
					'tipo' => 'Tipo de Requerimiento',
					'fecha' => 'Fecha',
					'estado' => 'Estado',
					'sustento' => 'Sustento',
					'numero_reporte' => 'Reporte de Necesidad'
				);

				$messages = array();

				$rules = array(
					'numero_ot' => 'required',
					'servicio' => 'required',
					'nombre_equipo1' => 'required',
					'marca1' => 'required',
					'usuario_responsable' => 'required',
					'tipo' => 'required',
					'fecha' => 'required',
					'estado' => 'required',
					'sustento' => 'max:500|alpha_num_spaces_slash_dash_enter',
					'numero_reporte' => 'required',
					'flag_doc' => 'min:1'
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$idsolicitud = Input::get('reporte_id');
					return Redirect::to('solicitudes_compra/edit_solicitud_compra/'.$idsolicitud)->withErrors($validator)->withInput(Input::all());
				}else{
					$count_details = Input::get('count_details');
					$idsolicitud = Input::get('reporte_id');
					if($count_details == 0 ){
						//no se podrá crear nada porque no se ha creado ningún detalle
						Session::flash('error', 'No se cuenta con detalles.');
						return Redirect::to('solicitudes_compra/edit_solicitud_compra/'.$idsolicitud);
					}else{
						$flag_ot = Input::get('flag_ot');
						$flag_doc = Input::get('flag_doc');
						if($flag_ot == 1){
							Session::flash('error', 'Orden de Mantenimiento no Válido.');
							return Redirect::to('solicitudes_compra/edit_solicitud_compra/'.$idsolicitud);
						}else if($flag_doc == 0){
							Session::flash('error', 'Documento no adjuntado correctamente.');
							return Redirect::to('solicitudes_compra/edit_solicitud_compra/'.$idsolicitud);
						}else{
							//Registramos los datos generales
							//Previamente para no crear la solicitud de compra sin documento,
							//se verifica si el documento existe o es de tipo Reporte de Necesidad					
							$codigo_archivamiento = Input::get('numero_reporte');
							$documento_nuevo = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento)->get();
							$documento_nuevo = $documento_nuevo[0];					

							$solicitud = SolicitudCompra::find($idsolicitud);
							$solicitud->codigo_ot = Input::get('numero_ot');
							$solicitud->idtipo_solicitud_compra = Input::get('tipo');
							$solicitud->idfamilia_activo = Input::get('nombre_equipo1');
							$solicitud->id_responsable = Input::get('usuario_responsable');
							$solicitud->fecha = date("Y-m-d",strtotime(Input::get('fecha')));
							$solicitud->idservicio = Input::get('servicio');
							$solicitud->sustento = Input::get('sustento');
							$solicitud->idestado = Input::get('estado');
							$solicitud->save();

							//Registramos el documento:
							$documento_actual = Documento::searchDocumentoByIdSolicitudCompra($solicitud->idsolicitud_compra)->get()[0];							
							if($documento_actual->iddocumento != $documento_nuevo->iddocumento){
								//quiere decir que es nuevo documento
								$documento_nuevo->idsolicitud_compra = $solicitud->idsolicitud_compra;
								$documento_nuevo->save();
								$documento_actual->idsolicitud_compra = null;
								$documento_actual->save();
							}
							

							//Registramos el detalle de la solicitud:
							$idsolicitud = $solicitud->idsolicitud_compra;
							
							DetalleSolicitudCompra::deleteDetalleByIdSolicitudCompra($idsolicitud)->forcedelete();

							$details_descripcion = Input::get('details_descripcion');
							$details_modelo = Input::get('details_modelo');
							$details_marca = Input::get('details_marca');
							$details_serie_parte = Input::get('details_serie');
							$details_cantidad = Input::get('details_cantidad');

							for($i=0;$i<$count_details;$i++){
								$detalle = new DetalleSolicitudCompra;
								$detalle->descripcion = $details_descripcion[$i];								
								$detalle->modelo = $details_modelo[$i];				
								$detalle->marca = $details_marca[$i];
								$detalle->serie_parte = $details_serie_parte[$i];
								$detalle->cantidad = $details_cantidad[$i];
								$detalle->idsolicitud_compra = $idsolicitud;	
								$detalle->save();
							}
						}
					}
					Session::flash('message', 'Se guardó correctamente la información.');
					return Redirect::to('solicitudes_compra/list_solicitudes');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}