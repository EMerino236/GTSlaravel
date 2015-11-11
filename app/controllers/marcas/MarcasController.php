<?php

class MarcasController extends BaseController
{
	
	public function list_marcas()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_nombre_marca"] = null;
				$data["marcas_data"] = Marca::getMarcasInfo()->paginate(10);
				return View::make('marcas/listMarcas',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_marcas()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_nombre_marca"] = Input::get('search_nombre_marca');
				$data["marcas_data"] = Marca::SearchMarcasByNombre($data["search_nombre_marca"])->paginate(10);
				return View::make('marcas/listMarcas',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_marca()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){				
				return View::make('marcas/createMarca',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_marca()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'nombre_marca' => 'Nombre de Marca',
					);
				$messages = array(
					);
				$rules = array(
					'nombre_marca' => 'required|min:1|max:100|unique:marcas,nombre'							
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messa,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('marcas/create_marca')->withErrors($validator)->withInput(Input::all());
				}else{					
					$marca = new Marca;
					$marca->nombre = Input::get('nombre_marca');
					$marca->idestado = 1;
					$marca->save();
										
					return Redirect::to('marcas/list_marcas')->with('message', 'Se registró correctamente la marca: '.$marca->nombre);
				}
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	} 

	public function render_edit_marca($idmarca=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idmarca){
				$data["marca_info"] = Marca::SearchMarcasById($idmarca)->get();
				if($data["marca_info"]->isEmpty()){
					return Redirect::to('marcas/list_marcas');
				}
				$data["marca_info"] = $data["marca_info"][0];
				return View::make('marcas/editMarca',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_marca()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'nombre_marca'=>'Nombre de Marca',
					);
				$messages = array(
					);
				$rules = array(
					'nombre_marca' => 'required|min:1|max:100'
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$attributes,$messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$marca_id = Input::get('marca_id');
					$url = "marcas/edit_marca"."/".$marca_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$marca_id = Input::get('marca_id');
					$url = "marcas/edit_marca"."/".$marca_id;
					$marca = Marca::find($marca_id);
					$marca->nombre = Input::get('nombre_marca');
					$marca->save();
					
					return Redirect::to('marcas/list_marcas')->with('message', 'Se editó correctamente la marca: '.$marca->nombre);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

}