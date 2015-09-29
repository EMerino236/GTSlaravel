<?php

class ActivosController extends BaseController
{
	
	public function home()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		return View::make('activos/listActivos',$data);
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