<?php

class ActivosController extends BaseController
{
	
	public function list_activos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_grupo"] = null;
				$data["search_servicio"] = null;
				$data["search_nombre_equipo"] =null;
				$data["search_marca"] = null;
				$data["search_modelo"] = null;
				$data["search_serie"] = null;

				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicio"] = Servicio::lists('nombre','idservicio');
				$data["marca"] = Marca::lists('nombre','idmarca');

				$data["activos_data"] = Activo::getActivosInfo()->paginate(10);
				return View::make('activos/listActivos',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_activos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicio"] = Servicio::lists('nombre','idservicio');
				$data["marca"] = Marca::lists('nombre','idmarca');

				$data["search_grupo"] = Input::get('search_grupo');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_nombre_equipo"] = Input::get('search_nombre_equipo');
				$data["search_marca"] = Input::get('search_marca');
				$data["search_modelo"] = Input::get('search_modelo');
				$data["search_serie"] = Input::get('search_serie');

				$data["activos_data"] = Activo::searchActivos($data["search_grupo"],$data["search_servicio"],$data["search_nombre_equipo"],
										$data["search_marca"],$data["search_modelo"],$data["search_serie"])->paginate(10);
				return View::make('activos/listActivos',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_activo()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		if($data["user"]->idrol == 1){
			$data["grupos"] = Grupo::lists('nombre','idgrupo');
			$data["servicios"] = Servicio::lists('nombre','idservicio');
			$data["marcas"]	= Marca::lists('nombre','idmarca');
			$data["centro_costos"]	= CentroCosto::lists('nombre','idcentro_costo');
			$data["tipo_documento"] = TipoDocumento::lists('nombre','idtipo_documento');	
			return View::make('activos/createActivo',$data);
		}
		
	}

	public function submit_create_activo()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		return View::make('activos/createActivo',$data);
	}


	
}