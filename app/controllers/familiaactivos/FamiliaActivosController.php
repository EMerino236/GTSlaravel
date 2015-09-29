<?php

class FamiliaActivosController extends BaseController
{

	public function list_familiaactivos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = null;
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["familiaactivos_data"] = FamiliaActivo::getFamiliaActivosInfo()->paginate(10);
				return View::make('familiaactivos/listFamiliaActivos',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_familiaactivos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = Input::get('search');
				$data["familiaactivos_data"] = FamiliaActivo::searchFamiliaActivo($data["search"])->paginate(10);
				return View::make('familiaactivos/listFamiliaActivos',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_familiaactivo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){	
				$data["tipo_activo"] = TipoActivo::lists('nombre','idtipo_activo');
				$data["marca"] = Marca::lists('nombre','idmarca');			
				return View::make('familiaactivos/createFamiliaActivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_familiaactivo()
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
					return Redirect::to('familiaactivos/create_familiaactivo')->withErrors($validator)->withInput(Input::all());
				}else{					
					$famila_activo = new FamiliaActivo;
					$famila_activo->nombre_equipo = Input::get('nombre_equipo');
					$famila_activo->modelo = Input::get('modelo');
					$famila_activo->idtipo_activo = Input::get('idtipo_activo');
					$famila_activo->idmarca = Input::get('idmarca');
					$famila_activo->idestado = 1;
					$famila_activo->save();
										
					Session::flash('message', 'Se registró correctamente la Familia de Activo.');
					
					return Redirect::to('familiaactivos/create_familiaactivo');
				}
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_familiaactivo($idfamilia_activo=null)
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
					return Redirect::to('familiaactivos/list_familiaactivos');
				}
				$data["familiaactivo_info"] = $data["familiaactivo_info"][0];
				return View::make('familiaactivos/editFamiliaActivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_familiaactivo()
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
					$url = "familiaactivos/edit_familiaactivo"."/".$familia_activo_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$familia_activo_id = Input::get('familia_activo_id');
					$url = "familiaactivos/edit_familiaactivo"."/".$familia_activo_id;
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