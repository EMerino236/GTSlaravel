<?php

class AreasController extends BaseController
{
	
	public function list_areas()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = null;
				$data["areas_data"] = Area::getAreasInfo()->paginate(10);
				return View::make('areas/listAreas',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_area()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["tipo_areas"] = TipoArea::lists('nombre','idtipo_area');
				return View::make('areas/createArea',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}	
}