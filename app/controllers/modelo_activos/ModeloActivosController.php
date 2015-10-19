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
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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
					$idfamilia_activo = Input::get('familia_activo_id');
					$url = "familia_activos/edit_familia_activo"."/".$idfamilia_activo;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{		
					$idfamilia_activo = Input::get('familia_activo_id');				
					$url = "familia_activos/edit_familia_activo"."/".$idfamilia_activo;

					$idmodelo = Input::get('modelo_id');
					$modelo_activo = ModeloActivo::find($idmodelo);					
					$modelo_activo->nombre = Input::get('nombre_modelo');
					
					$modelo_activo->save();					
					
					return Redirect::to($url)->with('message','Se actualizó correctamente el Modelo de la Familia de Activo.');
				}
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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

				$data["accesorios_info"] = Accesorio::getAccesorioByModelo($data["modelo_info"]->idmodelo_equipo);				
				
				return View::make('modelo_activos/createAccesorioModeloFamiliaActivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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
				
				return View::make('modelo_activos/createConsumibleModeloFamiliaActivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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
				
				return View::make('modelo_activos/createComponenteModeloFamiliaActivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}