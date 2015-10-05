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
				$data["search_marca"]=null;
				$data["search_departamento"]=null;
				$data["search_servicio"]=null;
				$data["search_estado"]=null;
				$data["search_modelo"]=null;
				$data["search_nombre_equipo"]=null;
				$data["search_serie"]=null;
				$data["marcas"]=Marca::lists('nombre','idmarca');
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = array(0=>"");
				$data["estados"] = array(0=>"");

				//$data["areas_data"] = Area::getAreasInfo()->paginate(10);
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
				/*$data["search"] = Input::get('search');
				$data["tipo_area"] = TipoArea::lists('nombre','idtipo_area'); 
				$data["areas_data"] = Area::searchAreas($data["search"])->paginate(10);*/
				if($data["search"]==0){
					return Redirect::to('areas/list_areas');
				}else{
					return View::make('areas/listAreas',$data);	
				}
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
}