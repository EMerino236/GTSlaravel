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
				$data["search_nombre_siga"] = null;
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
				$data["search_nombre_siga"] = Input::get('search_nombre_siga');
				$data["search_serie"] = Input::get('search_serie');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["search_codigo_compra"] = Input::get('search_codigo_compra');
				$data["search_codigo_patrimonial"] = Input::get('search_codigo_patrimonial');

				$data["activos_data"] = Activo::searchActivos($data["search_grupo"],$data["search_servicio"],$data["search_ubicacion"],$data["search_nombre_siga"],$data["search_nombre_equipo"],
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
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1){
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicios"] = Servicio::lists('nombre','idservicio');			
				$data["marcas"]	= Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["centro_costos"]	= CentroCosto::lists('nombre','idcentro_costo');			
				return View::make('activos/createActivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol	== 1){

				$rules = array(
					'servicio_clinico' => 'required',
					'ubicacion_fisica' => 'required',
					'grupo' => 'required',
					'marca' => 'required',
					'nombre_equipo' => 'required',
					'numero_serie' => 'required',
					'proveedor' => 'required',
					'codigo_compra' => 'required',
					'codigo_patrimonial' => 'required',
					'fecha_adquisicion' => 'required',
					'centro_costo' => 'required',
					'garantia' => 'required'
					);

				$validator = Validator::make(Input::all(), $rules);

				if($validator->fails()){
					return Redirect::to('equipos/create_equipo')->withErrors($validator)->withInput(Input::all());
				}else{

					$activo = new Activo;
					$activo->codigo_patrimonial = Input::get('codigo_patrimonial');
					$activo->numero_serie = Input::get('numero_serie');
					$activo->anho_adquisicion = Input::get('fecha_adquisicion');
					$activo->garantia = Input::get('garantia');	
					$activo->codigo_compra = Input::get('codigo_compra');
					$activo->idgrupo = Input::get('grupo');
					$activo->idfamilia_activo = Input::get('nombre_equipo');
					$activo->idservicio = Input::get('servicio_clinico');
					$activo->idcentro_costo = Input::get('centro_costo');
					$activo->idproveedor = Input::get('proveedor');
					$activo->idreporte_instalacion = 1;
					$activo->idestado = 1;
					$activo->idubicacion_fisica = Input::get('ubicacion_fisica');

					$activo->save();

					Session::flash('message', 'Se registró correctamente el activo.');

					return Redirect::to('equipos/create_equipo');
				}
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_marca($idequipo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idequipo){
				$data["equipo_info"] = Activo::searchActivosById($idequipo)->get();
				if($data["equipo_info"]->isEmpty()){
					return Redirect::to('equipos/list_equipos');
				}
				$data["equipo_info"] = $data["equipo_info"][0];
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["ubicaciones"] = UbicacionFisica::where('idservicio','=',$data["equipo_info"]->idservicio)->lists('nombre','idubicacion_fisica');
				$data["nombre_equipo"] = FamiliaActivo::where('idmarca','=',$data["equipo_info"]->idmarca)->lists('nombre_equipo','idfamilia_activo');
				$data["marcas"]	= Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["centro_costos"]	= CentroCosto::lists('nombre','idcentro_costo');
				return View::make('activos/editActivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_equipo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
					'servicio_clinico' => 'required',
					'ubicacion_fisica' => 'required',
					'grupo' => 'required',
					'marca' => 'required',
					'nombre_equipo' => 'required',
					'numero_serie' => 'required',
					'proveedor' => 'required',
					'codigo_compra' => 'required',
					'codigo_patrimonial' => 'required',
					'fecha_adquisicion' => 'required',
					'centro_costo' => 'required',
					'garantia' => 'required'
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$equipo_id = Input::get('equipo_id');
					$url = "equipos/edit_equipo"."/".$equipo_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$equipo_id = Input::get('equipo_id');
					$url = "equipos/edit_equipo"."/".$equipo_id;
					$activo = Activo::find($equipo_id);
					$activo->codigo_patrimonial = Input::get('codigo_patrimonial');
					$activo->numero_serie = Input::get('numero_serie');
					$activo->anho_adquisicion = Input::get('fecha_adquisicion');
					$activo->garantia = Input::get('garantia');	
					$activo->codigo_compra = Input::get('codigo_compra');
					$activo->idgrupo = Input::get('grupo');
					$activo->idfamilia_activo = Input::get('nombre_equipo');
					$activo->idservicio = Input::get('servicio_clinico');
					$activo->idcentro_costo = Input::get('centro_costo');
					$activo->idproveedor = Input::get('proveedor');
					$activo->idreporte_instalacion = 1;
					$activo->idestado = 1;
					$activo->idubicacion_fisica = Input::get('ubicacion_fisica');	

					$activo->save();
					Session::flash('message', 'Se editó correctamente el equipo.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
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

	public function search_nombre_equipo_ajax()
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
				$familia_activo = FamiliaActivo::searchFAmiliaActivoByMarca($data)->get();
			}else{
				$familia_activo = array();
			}

			return Response::json(array( 'success' => true, 'nombre_equipo' => $familia_activo ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_modelo_equipo_ajax()
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
				$modelo_equipo = ModeloActivo::getModeloByFamiliaActivo($data)->get();
			}else{
				$modelo_equipo = array();
			}

			return Response::json(array( 'success' => true, 'modelo_equipo' => $modelo_equipo ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	
}