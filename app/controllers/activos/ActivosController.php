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
				$data["search"] = null;
				$data["activos_data"] = Activo::getActivosInfo()->paginate(10);
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