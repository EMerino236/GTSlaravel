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
				$data["search_proveedor"] = null;
				$data["search_codigo_compra"] = null;
				$data["search_codigo_patrimonial"] = null;
				$data["search_servicio"] = null;
				$data["search_ubicacion"] = null;

				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicio"] = Servicio::lists('nombre','idservicio');
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');

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
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');

				$data["search_grupo"] = Input::get('search_grupo');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_ubicacion"] = Input::get('search_ubicacion');
				$data["search_nombre_equipo"] = Input::get('search_nombre_equipo');
				$data["search_marca"] = Input::get('search_marca');
				$data["search_modelo"] = Input::get('search_modelo');
				$data["search_serie"] = Input::get('search_serie');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["search_codigo_compra"] = Input::get('search_codigo_compra');
				$data["search_codigo_patrimonial"] = Input::get('search_codigo_patrimonial');

				$data["activos_data"] = Activo::searchActivos($data["search_grupo"],$data["search_servicio"],$data["search_ubicacion"],$data["search_nombre_equipo"],
										$data["search_marca"],$data["search_modelo"],$data["search_serie"],$data["search_proveedor"],
										$data["search_codigo_compra"],$data["search_codigo_patrimonial"])->paginate(10);
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
			$data["ubicacion_fisica"] = UbicacionFisica::lists('nombre','idUbicacion_fisica');
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

	public function search_ubicacion_ajax()
	{

		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');			
			if($data !=0){
				$ubicacion = UbicacionFisica::searchUbicacionByServicio($data)->get();
			}else{
				$ubicacion = array();
			}

			return Response::json(array( 'success' => true, 'ubicacion' => $ubicacion ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	
}