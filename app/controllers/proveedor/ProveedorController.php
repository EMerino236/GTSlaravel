<?php

class ProveedorController extends BaseController {

	private static $nombre_tabla = 'estado_general';	

	public function list_proveedores()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_proveedor_ruc"] = null;
				$data["search_proveedor_razon_social"] = null;
				$data["proveedores_data"] = Proveedor::getProveedoresInfo()->paginate(10);
				return View::make('proveedores/listProveedores',$data);
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
				$data["search_proveedor_ruc"] = Input::get('search_proveedor_ruc');
				$data["search_proveedor_razon_social"] = Input::get('search_proveedor_razon_social');
				$data["proveedores_data"] = Proveedor::searchProveedores($data["search_proveedor_ruc"], $data["search_proveedor_razon_social"])->paginate(10);
				return View::make('proveedores/listProveedores',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_proveedor()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){				
				return View::make('proveedores/createProveedor',$data);
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
				$attributes = array(
					'proveedor_ruc' => 'Número de RUC',
					'proveedor_razon_social' => 'Razón Social',
					'proveedor_nombre_contacto' => 'Nombre de Contacto',
					'email' => 'E-mail',
					'telefono' => 'Teléfono',
					);

				$messages = array(
					);

				$rules = array(
							'proveedor_ruc' => 'required|numeric|digits:11',
							'proveedor_razon_social' => 'required|max:100|unique:proveedores,razon_social',
							'proveedor_nombre_contacto' => 'required|max:200',
							'email' => 'required|email|max:45',
							'telefono' => 'required|digits:7|max:45',							
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proveedores/create_proveedor')->withErrors($validator)->withInput(Input::all());
				}else{
					$proveedor = new Proveedor;
					$proveedor->razon_social = Input::get('proveedor_razon_social');
					$proveedor->nombre_contacto = Input::get('proveedor_nombre_contacto');
					$proveedor->email = Input::get('email');
					$proveedor->telefono = Input::get('telefono');
					$proveedor->ruc = Input::get('proveedor_ruc');
					$proveedor->idestado = 1;
					$proveedor->save();
					
					return Redirect::to('proveedores/list_proveedores')->with('message', 'Se creó correctamente el proveedor.');
				}
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
					return Redirect::to('proveedores/list_proveedores');
				}
				$data["proveedor_info"] = $data["proveedor_info"][0];
				return View::make('proveedores/editProveedor',$data);
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
				$attributes = array(
					'proveedor_ruc' => 'Número de RUC',
					'proveedor_razon_social' => 'Razón Social',
					'proveedor_nombre_contacto' => 'Nombre de Contacto',
					'email' => 'E-mail',
					'telefono' => 'Teléfono',
					'estado' => 'Estado',
					);

				$messages = array(
					);
				$rules = array(
					'proveedor_ruc' => 'required|numeric|digits:11',
					'proveedor_razon_social' => 'required',
					'proveedor_nombre_contacto' => 'required|max:200',
					'email' => 'required|email|max:45',
					'telefono' => 'required|digits:7|max:45',					
					'estado' => 'required',
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$proveedor_id = Input::get('proveedor_id');
					$url = "proveedores/edit_proveedor/".$proveedor_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$proveedor_id = Input::get('proveedor_id');
					$url = "proveedores/edit_proveedor/".$proveedor_id;
					
					$proveedor = Proveedor::find($proveedor_id);					
					$proveedor->razon_social = Input::get('proveedor_razon_social');
					$proveedor->nombre_contacto = Input::get('proveedor_nombre_contacto');
					$proveedor->email = Input::get('email');
					$proveedor->telefono = Input::get('telefono');
					$proveedor->ruc = Input::get('proveedor_ruc');
					$proveedor->idestado = Input::get('estado');
					$proveedor->save();
					

					return Redirect::to('proveedores/list_proveedores')->with('message', 'Se editó correctamente el proveedor con RUC: '.$proveedor->ruc);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_view_proveedor($idproveedor=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idproveedor){

				$data["proveedor_info"] = Proveedor::searchProveedorById($idproveedor)->get();

				if($data["proveedor_info"]->isEmpty())
				{
					return Redirect::to('user/list_proveedores');
				}

				$data["proveedor_info"] = $data["proveedor_info"][0];

				return View::make('proveedores/viewProveedor',$data);
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
	
	
}