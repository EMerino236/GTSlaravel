<?php

class ModeloActivosController extends BaseController
{
	/* MODELO */
	public function render_create_modelo_familia_activo($idfamilia_activo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 && $idfamilia_activo){	
				$data["tipo_activo"] = TipoActivo::lists('nombre','idtipo_activo');
				$data["marca"] = Marca::lists('nombre','idmarca');	
				$data["familia_activo_info"] = FamiliaActivo::find($idfamilia_activo);

				if($data["familia_activo_info"] == null){
					return Redirect::to('familia_activos/list_familia_activos');
				}
				$data["familia_activo_info"] = $data["familia_activo_info"];
				return View::make('modelo_activos/createModeloActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_modelo_familia_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre_modelo' => 'required|min:1|max:100',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('familia_activos/create_modelo_familia_activo')->withErrors($validator)->withInput(Input::all());
				}else{		

					$modelo_activo = new ModeloActivo;
					$modelo_activo->nombre = Input::get('nombre_modelo');
					$modelo_activo->idfamilia_activo = Input::get('familia_activo_id');
					$url = "familia_activos/edit_familia_activo"."/".$modelo_activo->idfamilia_activo;

					$modelo_activo->save();					
					
					return Redirect::to($url)->with('message','Se registró correctamente el Modeo de la Familia de Activo.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_modelo_familia_activo($idmodelo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 && $idmodelo){

				$data["modelo_info"] = ModeloActivo::find($idmodelo);	

				if($data["modelo_info"] == null){
					return Redirect::to('familia_activos/list_familia_activos');
				}
				
				$data["familia_activo_info"] = FamiliaActivo::find($data["modelo_info"]->idfamilia_activo);								
				return View::make('modelo_activos/editModeloActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_modelo_familia_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre_modelo' => 'required|min:1|max:100',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$idmodelo_equipo = Input::get('idmodelo_equipo');
					$url = "familia_activos/edit_modelo_familia_activo"."/".$idmodelo_equipo;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{		
					$idfamilia_activo = Input::get('familia_activo_id');				
					$url = "familia_activos/edit_familia_activo"."/".$idfamilia_activo;

					$idmodelo = Input::get('idmodelo_equipo');
					$modelo_activo = ModeloActivo::find($idmodelo);				

					$modelo_activo->nombre = Input::get('nombre_modelo');
					
					$modelo_activo->save();					
					
					return Redirect::to($url)->with('message','Se actualizó correctamente el Modelo de la Familia de Activo.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	/* ACCESORIO */
	public function render_create_accesorio_modelo_familia_activo($idmodelo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 && $idmodelo){

				$data["modelo_info"] = ModeloActivo::find($idmodelo);				

				if($data["modelo_info"] == null){
					return Redirect::to('familia_activos/list_familia_activos');
				}

				$data["familia_activo_info"] = FamiliaActivo::find($data["modelo_info"]->idfamilia_activo);

				if($data["familia_activo_info"] == null){
					return Redirect::to('familia_activos/list_familia_activos');
				}

				$data["accesorios_info"] = Accesorio::getAccesorioByModelo($data["modelo_info"]->idmodelo_equipo)->get();
				
				return View::make('modelo_activos/createAccesorioModeloFamiliaActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_accesorio_modelo_familia_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre_accesorio' => 'required|min:1|max:100',
							'modelo_accesorio' => 'required|min:1|max:100',
							'costo_accesorio' => 'required|numeric',
							'numero_pieza' => 'required|min:1|max:100',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$idmodelo_equipo= Input::get('idmodelo_equipo');
					$url = "familia_activos/create_accesorio_modelo_familia_activo"."/".$idmodelo_equipo;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{		
					$idmodelo_equipo= Input::get('idmodelo_equipo');
					$url = "familia_activos/create_accesorio_modelo_familia_activo"."/".$idmodelo_equipo;

					$nombre_accesorio = Input::get('nombre_accesorio');
					$modelo_accesorio = Input::get('modelo_accesorio');
					$costo_accesorio = Input::get('costo_accesorio');
					$numero_pieza = Input::get('numero_pieza');

					$accesorio = new Accesorio;
					$accesorio->numero_pieza = $numero_pieza;
					$accesorio->nombre = $nombre_accesorio;
					$accesorio->modelo = $modelo_accesorio;
					$accesorio->costo = $costo_accesorio;
					$accesorio->idmodelo_equipo = $idmodelo_equipo;

					$accesorio->save();					
					
					return Redirect::to($url)->with('message','Se registro correctamente el accesorio.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	/* CONSUMIBLE */
	public function render_create_consumible_modelo_familia_activo($idmodelo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 && $idmodelo){

				$data["modelo_info"] = ModeloActivo::find($idmodelo);				

				if($data["modelo_info"] == null){
					return Redirect::to('familia_activos/list_familia_activos');
				}

				$data["familia_activo_info"] = FamiliaActivo::find($data["modelo_info"]->idfamilia_activo);

				if($data["familia_activo_info"] == null){
					return Redirect::to('familia_activos/list_familia_activos');
				}

				$data["consumibles_info"] = Consumible::getConsumibleByModelo($data["modelo_info"]->idmodelo_equipo)->get();				
				
				return View::make('modelo_activos/createConsumibleModeloFamiliaActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_consumible_modelo_familia_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre_consumible' => 'required|min:1|max:100',
							'cantidad_consumible' => 'required|min:1|max:100',
							'costo_consumible' => 'required|numeric',							
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$idmodelo_equipo= Input::get('idmodelo_equipo');
					$url = "familia_activos/create_consumible_modelo_familia_activo"."/".$idmodelo_equipo;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{		
					$idmodelo_equipo= Input::get('idmodelo_equipo');
					$url = "familia_activos/create_consumible_modelo_familia_activo"."/".$idmodelo_equipo;

					$nombre_consumible = Input::get('nombre_consumible');
					$cantidad_consumible = Input::get('cantidad_consumible');
					$costo_consumible = Input::get('costo_consumible');					

					$consumible = new Consumible;					
					$consumible->nombre = $nombre_consumible;
					$consumible->cantidad = $cantidad_consumible;
					$consumible->costo = $costo_consumible;
					$consumible->idmodelo_equipo = $idmodelo_equipo;

					$consumible->save();					
					
					return Redirect::to($url)->with('message','Se registro correctamente el accesorio.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	/* COMPONENTE */
	public function render_create_componente_modelo_familia_activo($idmodelo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 && $idmodelo){

				$data["modelo_info"] = ModeloActivo::find($idmodelo);				

				if($data["modelo_info"] == null){
					return Redirect::to('familia_activos/list_familia_activos');
				}

				$data["familia_activo_info"] = FamiliaActivo::find($data["modelo_info"]->idfamilia_activo);

				if($data["familia_activo_info"] == null){
					return Redirect::to('familia_activos/list_familia_activos');
				}

				$data["componentes_info"] = Componente::getComponenteByModelo($data["modelo_info"]->idmodelo_equipo)->get();
				
				return View::make('modelo_activos/createComponenteModeloFamiliaActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_componente_modelo_familia_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre_componente' => 'required|min:1|max:100',
							'modelo_componente' => 'required|min:1|max:100',
							'costo_componente' => 'required|numeric',
							'numero_pieza' => 'required|min:1|max:100',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$idmodelo_equipo= Input::get('idmodelo_equipo');
					$url = "familia_activos/create_componente_modelo_familia_activo"."/".$idmodelo_equipo;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{		
					$idmodelo_equipo= Input::get('idmodelo_equipo');
					$url = "familia_activos/create_componente_modelo_familia_activo"."/".$idmodelo_equipo;

					$nombre_componente = Input::get('nombre_componente');
					$modelo_componente = Input::get('modelo_componente');
					$costo_componente = Input::get('costo_componente');
					$numero_pieza = Input::get('numero_pieza');

					$componente = new Componente;
					$componente->numero_pieza = $numero_pieza;
					$componente->nombre = $nombre_componente;
					$componente->modelo = $modelo_componente;
					$componente->costo = $costo_componente;
					$componente->idmodelo_equipo = $idmodelo_equipo;

					$componente->save();					
					
					return Redirect::to($url)->with('message','Se registro correctamente el componente.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_modelo_familia_activo($idmodelo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idmodelo){
				
				$data["modelo_equipo_info"] = ModeloActivo::find($idmodelo);				

				$data["accesorios_info"] = Accesorio::getAccesorioByModelo($data["modelo_equipo_info"]->idmodelo_equipo)->get();
				$data["consumibles_info"] = Consumible::getConsumibleByModelo($data["modelo_equipo_info"]->idmodelo_equipo)->get();				
				$data["componentes_info"] = Componente::getComponenteByModelo($data["modelo_equipo_info"]->idmodelo_equipo)->get();

				return View::make('modelo_activos/viewModeloActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}