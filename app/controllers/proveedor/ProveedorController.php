<?php

class ProveedorController extends BaseController {

	private static $nombre_tabla = 'estado_general';

	public function render_create_proveedor()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				return View::make('proveedor/createProveedor',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_proveedor()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'razon_social' => 'required|max:100|unique:proveedores',
							'email' => 'required|email|max:45',
							'telefono' => 'required|max:45',
							'ruc' => 'required|numeric|digits_between:8,16',
							'idestado' => 'required'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proveedores/create_proveedor')->withErrors($validator)->withInput(Input::all());
				}else{
					$proveedor = new Proveedor;
					$proveedor->razon_social = Input::get('razon_social');
					$proveedor->email = Input::get('email');
					$proveedor->telefono = Input::get('telefono');
					$proveedor->ruc = Input::get('ruc');
					$proveedor->idestado = Input::get('idestado');
					$proveedor->save();
					Session::flash('message', 'Se creó correctamente el proveedor.');
					return Redirect::to('proveedores/create_proveedor');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_proveedores()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = null;
				$data["proveedores_data"] = Proveedor::getProveedoresInfo()->paginate(10);
				return View::make('proveedor/listProveedores',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_proveedor($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $id){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["proveedor_info"] = Proveedor::searchProveedorById($id)->get();
				if($data["proveedor_info"]->isEmpty()){
					return Redirect::to('user/list_proveedores');
				}
				$data["proveedor_info"] = $data["proveedor_info"][0];
				return View::make('proveedor/editProveedor',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_proveedor()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'email' => 'required|email|max:45',
							'telefono' => 'required|max:45',
							'ruc' => 'required|numeric|digits_between:8,16',
							'idestado' => 'required'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$proveedor_id = Input::get('proveedor_id');
					$url = "proveedores/edit_proveedor/".$proveedor_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$proveedor_id = Input::get('proveedor_id');
					$url = "proveedores/edit_proveedor/".$proveedor_id;
					$proveedor = Proveedor::find($proveedor_id);
					$proveedor->email = Input::get('email');
					$proveedor->telefono = Input::get('telefono');
					$proveedor->ruc = Input::get('ruc');
					$proveedor->idestado = Input::get('idestado');
					$proveedor->save();
					Session::flash('message', 'Se editó correctamente el proveedor.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_disable_proveedor()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$proveedor_id = Input::get('proveedor_id');
				$url = "proveedores/edit_proveedor/".$proveedor_id;
				$proveedor = Proveedor::find($proveedor_id);
				$proveedor->delete();
				Session::flash('message', 'Se inhabilitó correctamente al proveedor.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_enable_proveedor()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$proveedor_id = Input::get('proveedor_id');
				$url = "proveedores/edit_proveedor/".$proveedor_id;
				$proveedor = Proveedor::withTrashed()->find($proveedor_id);
				$proveedor->restore();
				Session::flash('message', 'Se habilitó correctamente al proveedor.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_proveedor()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = Input::get('search');
				$data["proveedores_data"] = Proveedor::searchProveedores($data["search"])->paginate(10);
				return View::make('proveedor/listProveedores',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}