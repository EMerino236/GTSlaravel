<?php

class TipoTareaController extends BaseController {

	public function render_create_tipoTarea()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				return View::make('tipoTarea/createTipoTarea',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_tipoTarea()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:45|unique:users',
							'descripcion' => 'required|max:200',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('tipoTarea/create_tipoTarea')->withErrors($validator)->withInput(Input::all());
				}else{
					$tipoTarea = new tipoTarea;
					$tipoTarea->nombre = Input::get('nombre');
					$tipoTarea->descripcion = Input::get('descripcion');
					$tipoTarea->save();
					Session::flash('message', 'Se registró correctamente el Tipo de Tarea.');
					
					return Redirect::to('tipoTarea/create_tipoTarea');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_tipoTareas()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = null;
				$data["tipoTareas_data"] = TipoTarea::paginate(10);
				return View::make('tipoTarea/listTipoTareas',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_tipoTarea($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $id){
				$data["tipoTarea_info"] = TipoTarea::searchTipoTareaById($id)->get();

				if($data["tipoTarea_info"]->isEmpty()){
					return Redirect::to('tipoTarea/list_tipoTarea');
				}
				$data["tipoTarea_info"] = $data["tipoTarea_info"][0];
				return View::make('tipoTarea/editTipoTarea',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_tipoTarea()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:45|unique:users',
							'descripcion' => 'required|max:200',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$tipoTarea_id = Input::get('tipoTarea_id');
					$url = "tipoTarea/edit_tipoTarea"."/".$tipoTarea_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$tipoTarea_id = Input::get('tipoTarea_id');
					$url = "tipoTarea/edit_tipoTarea"."/".$tipoTarea_id;
					$tipoTarea = TipoTarea::find($tipoTarea_id);
					$tipoTarea->nombre = Input::get('nombre');
					$tipoTarea->descripcion = Input::get('descripcion');
					$tipoTarea->save();
					Session::flash('message', 'Se editó correctamente el Tipo de Tarea.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_tipoTarea()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = Input::get('search');
				$data["tipoTareas_data"] = TipoTarea::searchTipoTareas($data["search"])->paginate(10);
				return View::make('tipoTarea/listTipoTareas',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}