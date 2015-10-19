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
				$data["search"] = null;
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
				$data["search"] = Input::get('search');
				$data["marcas_data"] = Marca::SearchMarcasByNombre($data["search"])->paginate(10);
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
				$rules = array(
							'nombre' => 'required|min:1|max:100|unique:marcas'							
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('marcas/create_marca')->withErrors($validator)->withInput(Input::all());
				}else{					
					$marca = new Marca;
					$marca->nombre = Input::get('nombre');
					$marca->idestado = 1;
					$marca->save();
										
					Session::flash('message', 'Se registró correctamente la marca.');
					
					return Redirect::to('marcas/create_marca');
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
					$marca_id = Input::get('marca_id');
					$url = "marcas/edit_marca"."/".$marca_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$marca_id = Input::get('marca_id');
					$url = "marcas/edit_marca"."/".$marca_id;
					$marca = Marca::find($marca_id);
					$marca->nombre = Input::get('nombre');
					$marca->save();
					Session::flash('message', 'Se editó correctamente la marca.');
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