<?php

class GruposController extends BaseController
{
	public function list_grupos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = null;
				$data["grupos_data"] = Grupo::getGruposInfo()->paginate(10);
				return View::make('grupos/listGrupos',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_grupo(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = Input::get('search'); 
				$data["grupos_data"] = Grupo::searchGrupos($data["search"])->paginate(10);
				if($data["search"]==0){
					return Redirect::to('grupos/list_grupos');
				}else{
					return View::make('grupos/listGrupos',$data);	
				}
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_grupo($idgrupo=null){
		
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idgrupo)
			{	
				$data["grupo_info"] = Grupo::searchGrupoById($idgrupo)->get();
				$data["usuario_responsable"] = Grupo::getUserList();
				$data["activos_grupo"] = Activo::getActivosByGrupoId($idgrupo)->get();
				if($data["grupo_info"]->isEmpty()){
					return Redirect::to('grupos/list_grupos');
				}
				$data["grupo_info"] = $data["grupo_info"][0];

				return View::make('grupos/editGrupo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}

	}

	public function render_create_grupo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){						
				$data["usuario_responsable"] = Grupo::getUserList();
				
				return View::make('grupos/createGrupo',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_grupo(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100|unique:grupos',
							'descripcion' => 'required|max:200',
							'usuario_responsable'=>'required',				
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('grupos/create_grupo')->withErrors($validator)->withInput(Input::all());
				}else{
					$grupo = new Grupo;
					$grupo->nombre = Input::get('nombre');
					$grupo->descripcion = Input::get('descripcion');
					$grupo->id_responsable = Input::get('usuario_responsable');
					$grupo->idestado = 1;
					$grupo->save();
					Session::flash('message', 'Se registró correctamente el grupo.');
					
					return Redirect::to('grupos/list_grupos');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}	

	public function submit_edit_grupo(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100',
							'descripcion' => 'required|max:200',
							'usuario_responsable' =>'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$grupo_id = Input::get('grupo_id');
					$url = "grupos/edit_grupo"."/".$grupo_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{	
					$grupo_id = Input::get('grupo_id');	
					$url = "grupos/edit_grupo"."/".$grupo_id;					
					$grupo = Grupo::find($grupo_id);
					$grupo->nombre = Input::get('nombre');
					$grupo->descripcion = Input::get('descripcion');
					$grupo->id_responsable = Input::get('usuario_responsable');
					$grupo->save();
					Session::flash('message', 'Se editó correctamente el grupo.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
	
	public function submit_enable_grupo(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$grupo_id = Input::get('grupo_id');
				$url = "grupos/edit_grupo"."/".$grupo_id;
				$grupo = Grupo::withTrashed()->find($grupo_id);
				$grupo->restore();
				Session::flash('message', 'Se habilitó correctamente el grupo.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_disable_grupo(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$grupo_id = Input::get('grupo_id');
				$url = "grupos/edit_grupo"."/".$grupo_id;
				$grupo = Grupo::find($grupo_id);
				$activos = Activo::getEquiposActivosByGrupoId($grupo_id)->get();	
				if(count($activos)==0){					
					$grupo->delete();
					Session::flash('message','Se inhabilitó correctamente el grupo.' );
				}
				else{
					Session::flash('error', 'El grupo cuenta con equipos activos. Acción no realizada.' );
				}				
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}