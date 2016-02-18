<?php

class ActivosController extends BaseController
{
	
	public function list_activos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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
				$data["ubicacion"] = UbicacionFisica::lists('nombre','idubicacion_fisica');
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');

				$data["activos_data"] = Activo::getActivosInfo()->paginate(10);
				return View::make('activos/listActivos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_activos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicio"] = Servicio::lists('nombre','idservicio');
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["ubicacion"] = UbicacionFisica::lists('nombre','idubicacion_fisica');

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
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_inventario()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_grupo"] = null;
				$data["search_servicio"] = null;
				$data["search_nombre_equipo"] =null;
				$data["search_marca"] = null;				
				$data["search_modelo"] = null;				
				$data["search_proveedor"] = null;				
				$data["search_codigo_patrimonial"] = null;
				$data["search_servicio"] = null;
				$data["search_ubicacion"] = null;
				$data["fecha_adquisicion_ini"] = null;
				$data["fecha_adquisicion_fin"] = null;
				$data["search_anho_adquisicion"] = null;

				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicio"] = Servicio::lists('nombre','idservicio');
				$data["ubicacion"] = UbicacionFisica::lists('nombre','idubicacion_fisica');
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');

				$data["activos_data"] = Activo::getInventarioInfo()->paginate(10);
				

				foreach ($data["activos_data"] as $value)
				{
					$meses_garantia = $value->garantia;					
					$inicio_garantia = Carbon\Carbon::createFromFormat('Y-m-d', $value->anho_adquisicion);
					$fin_garantia = $inicio_garantia->addMonths($meses_garantia);

					$fecha_actual = Carbon\Carbon::now();
					
					$meses_restantes = $fin_garantia->diff($fecha_actual);					
					$value->garantia = ($meses_restantes);											
					
				}

				return View::make('activos/listActivosInventario',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_inventario()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicio"] = Servicio::lists('nombre','idservicio');
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["ubicacion"] = UbicacionFisica::lists('nombre','idubicacion_fisica');

				$data["search_grupo"] = Input::get('search_grupo');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_ubicacion"] = Input::get('search_ubicacion');
				$data["search_nombre_equipo"] = Input::get('search_nombre_equipo');
				$data["search_marca"] = Input::get('search_marca');
				$data["search_modelo"] = Input::get('search_modelo');
				$data["search_proveedor"] = Input::get('search_proveedor');				
				$data["search_codigo_patrimonial"] = Input::get('search_codigo_patrimonial');
				$data["fecha_adquisicion_ini"] = Input::get('fecha_adquisicion_ini');
				$data["fecha_adquisicion_fin"] = Input::get('fecha_adquisicion_fin');

				$data["activos_data"] = Activo::searchInventario($data["search_grupo"],$data["search_servicio"],$data["search_ubicacion"],$data["search_nombre_equipo"],
										$data["search_marca"],$data["search_modelo"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["fecha_adquisicion_ini"], $data["fecha_adquisicion_fin"])->paginate(10);

				foreach ($data["activos_data"] as $value)
				{
					$meses_garantia = $value->garantia;					
					$inicio_garantia = Carbon\Carbon::createFromFormat('Y-m-d', $value->anho_adquisicion);
					$fin_garantia = $inicio_garantia->addMonths($meses_garantia);

					$fecha_actual = Carbon\Carbon::now();
					
					$meses_restantes = $fin_garantia->diff($fecha_actual);					
					$value->garantia = ($meses_restantes);											
					
				}

				return View::make('activos/listActivosInventario',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["ubicacion"] = UbicacionFisica::lists('nombre','idubicacion_fisica');		
				$data["marcas"]	= Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');			
				return View::make('activos/createActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$attributes=array(
					'servicio_clinico' => 'Servicio Clínico',
					'ubicacion_fisica' => 'Ubicación Física',
					'grupo' => 'Grupo',
					'marca' => 'Marca',
					'nombre_equipo' => 'Nombre del Equipo',
					'modelo' => 'Modelo',
					'numero_serie' => 'Número de Serie',
					'proveedor' => 'Proveedor',
					'codigo_compra' => 'Código de Compra',
					'codigo_patrimonial' => 'Código Patrimonial',
					'fecha_adquisicion' => 'Fecha de Adquisición',
					'garantia' => 'Garantía',
					'idreporte_instalacion' => 'Código de Reporte de Instalación',
					'costo' => 'Costo'
					);

				$messages=array(
					);

				$rules = array(
					'servicio_clinico' => 'required',
					'ubicacion_fisica' => 'required',
					'grupo' => 'required',
					'marca' => 'required',
					'nombre_equipo' => 'required',
					'modelo' => 'required',
					'numero_serie' => 'required|alpha_dash',
					'proveedor' => 'required',
					'codigo_compra' => 'required|digits',
					'codigo_patrimonial' => 'required|digits:12|unique:activos,codigo_patrimonial',
					'fecha_adquisicion' => 'required',
					'garantia' => 'required|numeric',
					'idreporte_instalacion' => 'required',
					'costo' => 'required|numeric'
					);

				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){
					return Redirect::to('equipos/create_equipo')->withErrors($validator)->withInput(Input::all());
				}else{

					$activo = new Activo;
					$activo->codigo_patrimonial = Input::get('codigo_patrimonial');
					$activo->numero_serie = Input::get('numero_serie');
					$activo->anho_adquisicion = date('Y-m-d',strtotime(Input::get('fecha_adquisicion')));
					$activo->garantia = Input::get('garantia');	
					$activo->codigo_compra = Input::get('codigo_compra');
					$activo->idgrupo = Input::get('grupo');
					$activo->idmodelo_equipo = Input::get('modelo');
					$activo->idservicio = Input::get('servicio_clinico');
					$activo->idproveedor = Input::get('proveedor');
					$activo->idreporte_instalacion = Input::get('idreporte_instalacion');
					$activo->idestado = 1;
					$activo->idubicacion_fisica = Input::get('ubicacion_fisica');
					$activo->costo = Input::get('costo');

					$activo->save();

					return Redirect::to('equipos/list_equipos')->with('message', 'Se registró correctamente el activo.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_activo($idequipo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $idequipo){
				$data["equipo_info"] = Activo::searchActivosById($idequipo)->get();

				if($data["equipo_info"]->isEmpty())
				{
					return Redirect::to('equipos/list_equipos');
				}

				$data["equipo_info"] = $data["equipo_info"][0];
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["ubicaciones"] = UbicacionFisica::lists('nombre','idubicacion_fisica');
				$data["nombre_equipo"] = FamiliaActivo::where('idmarca','=',$data["equipo_info"]->idmarca)->lists('nombre_equipo','idfamilia_activo');
				$data["modelo_equipo"] = ModeloActivo::where('idfamilia_activo','=',$data["equipo_info"]->idfamilia_activo)->lists('nombre','idmodelo_equipo');
				$data["reporte_instalacion"] = ReporteInstalacion::where('idreporte_instalacion','=',$data["equipo_info"]->idreporte_instalacion)->get();
				$data["reporte_instalacion"] = $data["reporte_instalacion"][0];				
				
				$data["marcas"]	= Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				return View::make('activos/editActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$attributes=array(
					'servicio_clinico' => 'Servicio Clínico',
					'ubicacion_fisica' => 'Ubicación Física',
					'grupo' => 'Grupo',
					'marca' => 'Marca',
					'nombre_equipo' => 'Nombre del Equipo',
					'modelo' => 'Modelo',
					'numero_serie' => 'Número de Serie',
					'proveedor' => 'Proveedor',
					'codigo_compra' => 'Código de Compra',
					'codigo_patrimonial' => 'Código Patrimonial',
					'fecha_adquisicion' => 'Fecha de Adquisición',
					'garantia' => 'Garantía',
					'idreporte_instalacion' => 'Código de Reporte de Instalación',
					'costo' => 'Costo'
					);

				$messages=array(
					);

				$rules = array(
					'servicio_clinico' => 'required',
					'ubicacion_fisica' => 'required',
					'grupo' => 'required',
					'marca' => 'required',
					'nombre_equipo' => 'required',
					'modelo' => 'required',
					'numero_serie' => 'required',
					'proveedor' => 'required',
					'codigo_compra' => 'required',
					'codigo_patrimonial' => 'required',
					'fecha_adquisicion' => 'required',
					'garantia' => 'required',
					'idreporte_instalacion' => 'required',
					'costo' => 'required|numeric'
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$equipo_id = Input::get('equipo_id');
					$url = "equipos/edit_equipo"."/".$equipo_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$equipo_id = Input::get('equipo_id');
					//$url = "equipos/edit_equipo"."/".$equipo_id;
					$activo = Activo::find($equipo_id);
					$activo->codigo_patrimonial = Input::get('codigo_patrimonial');
					$activo->numero_serie = Input::get('numero_serie');
					$activo->anho_adquisicion = date('Y-m-d',strtotime(Input::get('fecha_adquisicion')));
					$activo->garantia = Input::get('garantia');	
					$activo->codigo_compra = Input::get('codigo_compra');
					$activo->idgrupo = Input::get('grupo');
					$activo->idmodelo_equipo = Input::get('modelo');
					$activo->idservicio = Input::get('servicio_clinico');
					$activo->idproveedor = Input::get('proveedor');
					$activo->idreporte_instalacion = Input::get('idreporte_instalacion');
					$activo->idestado = 1;
					$activo->idubicacion_fisica = Input::get('ubicacion_fisica');
					$activo->costo = Input::get('costo');

					$activo->save();
					
					return Redirect::to('equipos/list_equipos')->with('message', 'Se editó correctamente el equipo.');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_soporte_tecnico_equipo($idequipo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if(($data["user"]->idrol == 1) && $idequipo){
				$data["equipo_info"] = Activo::searchActivosById($idequipo)->get();
				$data["tipo_documento_identidad"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["soporte_tecnico_info"] = SoporteTecnicoxActivo::searchSoporteTecnicoByActivo($idequipo)->get();				
				
				$data["search_tipo_documento_activo"] = null;
				$data["search_numero_documento_soporte_tecnico_activo"] = null;

				if($data["equipo_info"]->isEmpty()){

					return Redirect::to('equipos/list_equipos');
				}

				$data["equipo_info"] = $data["equipo_info"][0];
				
				
				return View::make('soporte_tecnico/createSoporteTecnicoActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_soporte_tecnico_equipo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				
				$attributes = array(
					'idsoporte_tecnico' => 'Soporte Técnico'
				);

				$messages = array(
			    	'idsoporte_tecnico.required' => 'Debe agregar un :attribute existente.',
				);

				$rules = array(					
					'idsoporte_tecnico' => 'required'
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$idequipo = Input::get('idactivo');
					$url = "equipos/create_soporte_tecnico_equipo"."/".$idequipo;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$idequipo = Input::get('idactivo');
					$url = "equipos/create_soporte_tecnico_equipo"."/".$idequipo;

					$soporte_tecnico_activo = new SoporteTecnicoxActivo;
					$soporte_tecnico_activo->idsoporte_tecnico = Input::get('idsoporte_tecnico');
					$soporte_tecnico_activo->idactivo = $idequipo;

					$soporte_tecnico_activo->idestado = 1;					

					$soporte_tecnico_activo->save();
					
					return Redirect::to($url)->with('message', 'Se agregó correctamente el soporte técnico.');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_activo($idequipo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $idequipo){
				$data["equipo_info"] = Activo::searchActivosById($idequipo)->get();
				if($data["equipo_info"]->isEmpty()){
					return Redirect::to('equipos/list_equipos');
				}
				$data["equipo_info"] = $data["equipo_info"][0];
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["ubicaciones"] = UbicacionFisica::lists('nombre','idubicacion_fisica');
				$data["nombre_equipo"] = FamiliaActivo::where('idmarca','=',$data["equipo_info"]->idmarca)->lists('nombre_equipo','idfamilia_activo');
				$data["modelo_equipo"] = ModeloActivo::where('idfamilia_activo','=',$data["equipo_info"]->idfamilia_activo)->lists('nombre','idmodelo_equipo');
				$data["reporte_instalacion"] = ReporteInstalacion::where('idreporte_instalacion','=',$data["equipo_info"]->idreporte_instalacion)->get();
				$data["reporte_instalacion"] = $data["reporte_instalacion"][0];

				$data["soporte_tecnico_info"] = SoporteTecnicoxActivo::searchSoporteTecnicoByActivo($idequipo)->get();

				$data["accesorios_info"] = Accesorio::getAccesorioByModelo($data["equipo_info"]->idmodelo_equipo)->get();
				$data["consumibles_info"] = Consumible::getConsumibleByModelo($data["equipo_info"]->idmodelo_equipo)->get();				
				$data["componentes_info"] = Componente::getComponenteByModelo($data["equipo_info"]->idmodelo_equipo)->get();				
				
				$data["marcas"]	= Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				return View::make('activos/viewActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_activo_inventario($idequipo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $idequipo){
				$data["equipo_info"] = Activo::searchActivosById($idequipo)->get();
				if($data["equipo_info"]->isEmpty()){
					return Redirect::to('equipos/list_equipos');
				}
				$data["equipo_info"] = $data["equipo_info"][0];
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["ubicaciones"] = UbicacionFisica::lists('nombre','idubicacion_fisica');
				$data["nombre_equipo"] = FamiliaActivo::where('idmarca','=',$data["equipo_info"]->idmarca)->lists('nombre_equipo','idfamilia_activo');
				$data["modelo_equipo"] = ModeloActivo::where('idfamilia_activo','=',$data["equipo_info"]->idfamilia_activo)->lists('nombre','idmodelo_equipo');
				$data["reporte_instalacion"] = ReporteInstalacion::where('idreporte_instalacion','=',$data["equipo_info"]->idreporte_instalacion)->get();
				$data["reporte_instalacion"] = $data["reporte_instalacion"][0];

				$data["soporte_tecnico_info"] = SoporteTecnicoxActivo::searchSoporteTecnicoByActivo($idequipo)->get();

				$data["accesorios_info"] = Accesorio::getAccesorioByModelo($data["equipo_info"]->idmodelo_equipo)->get();
				$data["consumibles_info"] = Consumible::getConsumibleByModelo($data["equipo_info"]->idmodelo_equipo)->get();				
				$data["componentes_info"] = Componente::getComponenteByModelo($data["equipo_info"]->idmodelo_equipo)->get();				
				
				$data["marcas"]	= Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				return View::make('activos/viewActivoInventario',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
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
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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

	public function validate_numero_reporte_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('numero_reporte');
			
			$abreviatura = mb_substr($data,0,2);
			$correlativo = mb_substr($data,2,4);
			$anho = mb_substr($data,7,2);
			$reporte = ReporteInstalacion::searchReporteInstalacionByNumeroReporte($abreviatura,$correlativo,$anho)->get();

			return Response::json(array( 'success' => true,'data' => $reporte),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_soporte_tecnico_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			console.log('AQUI LLEGO');
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$idtipo_documento = Input::get('idtipo_documento');
			$numero_documento_identidad = Input::get('numero_documento_identidad');
					
			$soporte_tecnico = SoporteTecnico::searchSoporteTecnicoByNumeroDocumento($idtipo_documento,$numero_documento_identidad)->get();
			
			return Response::json(array( 'success' => true,'data' => $soporte_tecnico),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_delete_soporte_tecnico_equipo_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)
			{				
				$idsoporte_tecnico_activo = Input::get('idsoporte_tecnico');				
				$soporte_tecnico_activo = SoporteTecnicoxActivo::find($idsoporte_tecnico_activo);
				$soporte_tecnico_activo->delete();
				
				Session::flash('message', 'Se eliminó correctamente el soporte técnico.');
				return Response::json(array( 'success' => true),200);				
			}
			else{
				return Response::json(array( 'success' => false),200);				
			}		
		}
	}
	
}