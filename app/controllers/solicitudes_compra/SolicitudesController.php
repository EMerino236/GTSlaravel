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

	public function render_create_solicitud(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){	
				$data["tipos"] = TipoSolicitudCompra::lists('nombre','idtipo_solicitud_compra');
				$data["servicios"] = Servicio::searchServiciosClinicos(1)->lists('nombre','idservicio');
				$data["centro_costos"] = CentroCosto::lists('nombre','idcentro_costo');
				$data["marcas"] = Marca::lists('nombre','idmarca');
				$data["nombre_equipos"] = array('0'=>'Seleccione');
				$data["usuarios_responsable"] = User::getJefes()->get();
				return View::make('solicitudes_compra/createSolicitudCompra',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}