<?php

class FamiliaActivosController extends BaseController
{

	public function list_familia_activos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_nombreequipo"] = null;
				$data["search_marca"] = null;
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["familiaactivos_data"] = FamiliaActivo::getFamiliaActivosInfo()->paginate(10);
				return View::make('familia_activos/listFamiliaActivos',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_familia_activos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["search_nombreequipo"] = Input::get('search_nombreequipo');
				$data["search_marca"] = Input::get('search_marca');
				$data["familiaactivos_data"] = FamiliaActivo::searchFamiliaActivo($data["search_nombreequipo"],$data["search_marca"])->paginate(10);
				return View::make('familia_activos/listFamiliaActivos',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_familia_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){	
				$data["tipo_activo"] = TipoActivo::lists('nombre','idtipo_activo');
				$data["marca"] = Marca::lists('nombre','idmarca');			
				return View::make('familia_activos/createFamiliaActivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_familia_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre_equipo' => 'required|min:1|max:100',
							'modelo' => 'required|min:1|max:100',
							'idtipo_activo' => 'required',
							'idmarca' =>'required',

						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('familia_activos/create_familia_activo')->withErrors($validator)->withInput(Input::all());
				}else{					
					$famila_activo = new FamiliaActivo;
					$famila_activo->nombre_equipo = Input::get('nombre_equipo');
					$famila_activo->modelo = Input::get('modelo');
					$famila_activo->idtipo_activo = Input::get('idtipo_activo');
					$famila_activo->idmarca = Input::get('idmarca');
					$famila_activo->idestado = 1;
					$famila_activo->save();
										
					Session::flash('message', 'Se registró correctamente la Familia de Activo.');
					
					return Redirect::to('familia_activos/create_familia_activo');
				}
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_familia_activo($idfamilia_activo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idfamilia_activo){
				$data["tipo_activo"] = TipoActivo::lists('nombre','idtipo_activo');
				$data["marca"] = Marca::lists('nombre','idmarca');			
				$data["familiaactivo_info"] = FamiliaActivo::searchFamiliaActivoById($idfamilia_activo)->get();
				if($data["familiaactivo_info"]->isEmpty()){
					return Redirect::to('familia_activos/list_familia_activos');
				}
				$data["familiaactivo_info"] = $data["familiaactivo_info"][0];
				return View::make('familia_activos/editFamiliaActivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_familia_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre_equipo' => 'required|min:1|max:100',
							'modelo' => 'required|min:1|max:100',
							'idtipo_activo' => 'required',
							'idmarca' =>'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$familia_activo_id = Input::get('familia_activo_id');
					$url = "familia_activos/edit_familia_activo"."/".$familia_activo_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$familia_activo_id = Input::get('familia_activo_id');
					$url = "familia_activos/edit_familia_activo"."/".$familia_activo_id;
					$familia_activo = FamiliaActivo::find($familia_activo_id);
					$familia_activo->nombre_equipo = Input::get('nombre_equipo');
					$familia_activo->modelo = Input::get('modelo');
					$familia_activo->idtipo_activo = Input::get('idtipo_activo');
					$familia_activo->idmarca = Input::get('idmarca');
					$familia_activo->save();
					Session::flash('message', 'Se editó correctamente la Familia de Activo.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

}