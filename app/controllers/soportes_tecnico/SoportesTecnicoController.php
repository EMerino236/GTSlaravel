<?php

class SoportesTecnicoController extends BaseController
{
	public function list_soporte_tecnico()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["tipo_documento_identidad"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["search_tipo_documento"] = null;
				$data["search_proveedor"] = null;
				$data["search_numero_documento"] = null;
				$data["search_nombre"] = null;
				$data["search_apPaterno"] = null;
				$data["search_apMaterno"] = null;

				$data["soportes_tecnico_data"] = SoporteTecnico::getSoportesTecnicoInfo()->paginate(10);
				
				return View::make('soporte_tecnico/listSoporteTecnico',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_soporte_tecnico()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["tipo_documento_identidad"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				
				$data["search_proveedor"] = Input::get('proveedor');
				$data["search_tipo_documento"] = Input::get('tipo_documento_identidad');
				$data["search_numero_documento"] = Input::get('numero_documento_soporte_tecnico');
				$data["search_nombre"] = Input::get('nombre_soporte_tecnico');
				$data["search_apPaterno"] = Input::get('apPaterno_soporte_tecnico');
				$data["search_apMaterno"] = Input::get('apMaterno_soporte_tecnico');				

				$data["soportes_tecnico_data"] = SoporteTecnico::searchSoporteTecnico($data["search_proveedor"],$data["search_tipo_documento"], $data["search_numero_documento"],
					$data["search_nombre"], $data["search_apPaterno"], $data["search_apMaterno"])->paginate(10);
				return View::make('soporte_tecnico/listSoporteTecnico',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_soporte_tecnico($idsoporte_tecnico=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idsoporte_tecnico){

				$data["soporte_tecnico_info"] = SoporteTecnico::find($idsoporte_tecnico)->get();
				$data["soporte_tecnico_info"] = $data["soporte_tecnico_info"][0];
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				
				if($data["soporte_tecnico_info"] == null)
				{
					return Redirect::to('soportes_tecnicos/list_soporte_tecnico');
				}
				
				$data["tipo_documento_identidad"] = TipoDocumento::lists('nombre','idtipo_documento');				

				return View::make('soporte_tecnico/viewSoporteTecnico',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	/*public function render_create_soporte_tecnico()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1){				
				$data["tipo_documento_identidad"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');				
				
				return View::make('soporte_tecnico/createSoporteTecnico',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
	*/

	/*public function submit_create_soporte_tecnico()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol	== 1){

				$attributes = array(
					'proveedor' => 'Proveedor',
					'tipo_documento_identidad' => 'Tipo de Documento',
					'numero_documento_soporte_tecnico' => 'Número de Documento',
					'nombre_soporte_tecnico' => 'Nombre',
					'apPaterno_soporte_tecnico' => 'Apellido Paterno',
					'apMaterno_soporte_tecnico' => 'Apellido Materno',
					'especialidad_soporte_tecnico' => 'Especialidad',
					'telefono_soporte_tecnico' => 'Telefono',
					'email_soporte_tecnico' => 'E-mail'				
				);

				$messages = array(
			    	//'numero_documento_soporte_tecnico.unique' => 'El :attribute ya existe.',
				);

				$rules = array(
					'proveedor' => 'required',
					'tipo_documento_identidad' => 'required',
					'numero_documento_soporte_tecnico' => 'required | unique:soporte_tecnicos,numero_doc_identidad',
					'nombre_soporte_tecnico' => 'required',
					'apPaterno_soporte_tecnico' => 'required',
					'apMaterno_soporte_tecnico' => 'required',
					'especialidad_soporte_tecnico' => 'required',
					'telefono_soporte_tecnico' => 'required',
					'email_soporte_tecnico' => 'required'
					);

				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);

				if($validator->fails()){

					return Redirect::to('soportes_tecnico/create_soporte_tecnico')->withErrors($validator)->withInput(Input::all());
				}else{

					$soporte_tecnico = new SoporteTecnico;
					$soporte_tecnico->idproveedor = Input::get('proveedor');
					$soporte_tecnico->idtipo_documento = Input::get('tipo_documento_identidad');
					$soporte_tecnico->numero_doc_identidad = Input::get('numero_documento_soporte_tecnico');
					$soporte_tecnico->nombres = Input::get('nombre_soporte_tecnico');
					$soporte_tecnico->apellido_pat = Input::get('apPaterno_soporte_tecnico');	
					$soporte_tecnico->apellido_mat = Input::get('apMaterno_soporte_tecnico');
					$soporte_tecnico->telefono = Input::get('telefono_soporte_tecnico');
					$soporte_tecnico->email = Input::get('email_soporte_tecnico');
					$soporte_tecnico->especialidad = Input::get('especialidad_soporte_tecnico');					

					$soporte_tecnico->save();

					return Redirect::to('soportes_tecnico/list_soporte_tecnico')->with('message', 'Se registró correctamente al soporte técnico.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
	*/

	/*public function render_edit_soporte_tecnico($idsoporte_tecnico=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idsoporte_tecnico){

				$data["soporte_tecnico_info"] = SoporteTecnico::find($idsoporte_tecnico)->get();
				$data["soporte_tecnico_info"] = $data["soporte_tecnico_info"][0];
				
				if($data["soporte_tecnico_info"] == null)
				{
					return Redirect::to('soportes_tecnicos/list_soporte_tecnico');
				}
				
				$data["tipo_documento_identidad"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');

				return View::make('soporte_tecnico/editSoporteTecnico',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
	*/

	/*public function submit_edit_soporte_tecnico()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol	== 1){

				$attributes = array(
					'tipo_documento_identidad' => 'Tipo de Documento',
					'numero_documento_soporte_tecnico' => 'Número de Documento',
					'nombre_soporte_tecnico' => 'Nombre',
					'apPaterno_soporte_tecnico' => 'Apellido Paterno',
					'apMaterno_soporte_tecnico' => 'Apellido Materno',
					'especialidad_soporte_tecnico' => 'Especialidad',
					'telefono_soporte_tecnico' => 'Telefono',
					'email_soporte_tecnico' => 'E-mail'				
				);

				$messages = array(
			    	//'numero_documento_soporte_tecnico.unique' => 'El :attribute ya existe.',
				);

				$rules = array(
					'nombre_soporte_tecnico' => 'required',
					'apPaterno_soporte_tecnico' => 'required',
					'apMaterno_soporte_tecnico' => 'required',
					'especialidad_soporte_tecnico' => 'required',
					'telefono_soporte_tecnico' => 'required',
					'email_soporte_tecnico' => 'required'
					);

				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);

				if($validator->fails()){
					$idsoporte_tecnico = Input::get('idsoporte_tecnico');
					$url = "soportes_tecnico/edit_soporte_tecnico"."/".$idsoporte_tecnico;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$idsoporte_tecnico = Input::get('idsoporte_tecnico');

					$soporte_tecnico = SoporteTecnico::find($idsoporte_tecnico);					
					
					$soporte_tecnico->nombres = Input::get('nombre_soporte_tecnico');
					$soporte_tecnico->apellido_pat = Input::get('apPaterno_soporte_tecnico');	
					$soporte_tecnico->apellido_mat = Input::get('apMaterno_soporte_tecnico');
					$soporte_tecnico->telefono = Input::get('telefono_soporte_tecnico');
					$soporte_tecnico->email = Input::get('email_soporte_tecnico');
					$soporte_tecnico->especialidad = Input::get('especialidad_soporte_tecnico');					

					$soporte_tecnico->save();

					return Redirect::to('soportes_tecnico/list_soporte_tecnico')->with('message', 'Se editó correctamente al soporte técnico.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
	*/	
	
}