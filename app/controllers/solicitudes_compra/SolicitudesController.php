<?php

class SolicitudesController extends BaseController
{
	public function list_solicitudes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_tipo_solicitud"]=null;
				$data["tipos"] = TipoSolicitudCompra::lists('nombre','idtipo_solicitud_compra');				
				$data["search_servicio"]=null;
				$data["search_estado"]=null;
				$data["search_nombre_equipo"]=null;
				$data["servicios"] = array(0=>"");
				$data["estados"] = array(0=>"");
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
				$data["search_servicio"]=Input::get('search_servicio');
				$data["search_estado"]=Input::get('search_estado');
				$data["search_nombre_equipo"]=Input::get('search_nombre_equipo');
				$data["fecha_desde"] = Input::get('fecha_desde');
				$data["fecha_hasta"] = Input::get('fecha_hasta');
				$data["solicitudes_data"] = SolicitudCompra::searchAreas($data["search_tipo_solicitud"],$data["search_servicio"],
					$data["search_estado"],$data["search_nombre_equipo"],$data["fecha_desde"],$data["fecha_hasta"])->paginate(10);
				//if($data["search"]==0){
					return Redirect::to('solicitudes_compra/list_solicitudes',$data);
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

	public function return_servicio(){
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
				$servicios = Servicio::searchServiciosClinicosByIdArea($data)->get();
			}else{
				$servicios = null;
			}

			return Response::json(array( 'success' => true, 'servicios' => $servicios ),200);
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
				/*$data["tipo_documento"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["servicios"] = Servicio::searchServiciosClinicos(1)->lists('nombre','idservicio');
				$data["search"] = null;
				$data["documento_info"] =null;*/
				return View::make('solicitudes_compra/createSolicitudCompra',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
}