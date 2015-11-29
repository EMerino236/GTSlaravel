<?php

class AreasController extends BaseController
{	
	public function list_areas()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){

				$data["search_tipo_area"] = null;
				$data["search_nombre_area"] = null;

				$data["tipo_area"] = TipoArea::lists('nombre','idtipo_area');				
				$data["areas_data"] = Area::getAreasInfo()->paginate(10);
				return View::make('areas/listAreas',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_area()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1)
			{
				$data["search_tipo_area"] = Input::get('search_tipo_area');
				$data["search_nombre_area"] = Input::get('search_nombre_area');

				$data["tipo_area"] = TipoArea::lists('nombre','idtipo_area');

				$data["areas_data"] = Area::searchAreas($data["search_tipo_area"],$data["search_nombre_area"])->paginate(10);
				
				return View::make('areas/listAreas',$data);	
				
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_area()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){

				$data["tipo_areas"] = TipoArea::lists('nombre','idtipo_area');
				
				return View::make('areas/createArea',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_area()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'nombre_area' => 'Nombre del Área',
					'descripción_area' => 'Descripción del Área',
					'tipo_area' => 'Tipo del Área',
					);

				$messages = array(
					);

				$rules = array(
							'nombre_area' => 'required|max:100|unique:areas,nombre',
							'descripcion_area' => 'max:200',
							'tipo_area' => 'required',						
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('areas/create_area')->withErrors($validator)->withInput(Input::all());
				}else{
					$area = new Area;
					$area->nombre = Input::get('nombre_area');
					$area->descripcion = Input::get('descripcion_area');
					$area->idtipo_area = Input::get('tipo_area');
					$area->idestado = 1;
					$area->save();					
					
					return Redirect::to('areas/list_areas')->with('message', 'Se registró correctamente el área: '.$area->nombre);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_area($idarea=null)
	{
		
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idarea)
			{	
				$data["tipo_areas"] = TipoArea::lists('nombre','idtipo_area');
				$data["area_info"] = Area::searchAreaById($idarea)->get();
				$data["personal"] = User::searchPersonalByIdArea($idarea)->paginate(10);

				if($data["area_info"]->isEmpty()){
					return Redirect::to('areas/list_areas');
				}
				$data["area_info"] = $data["area_info"][0];

				return View::make('areas/editArea',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}		

	public function submit_edit_area()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'nombre_area' => 'Nombre del Área',
					'descripcion_area' => 'Descripción del Área',
					'tipo_area' => 'Tipo del Área',
					);

				$messages = array(
					);

				$rules = array(
							'nombre_area' => 'required|max:100',
							'descripcion_area' => 'max:200',
							'tipo_area' => 'required',	
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$area_id = Input::get('area_id');
					$url = "areas/edit_area"."/".$area_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{	
					$area_id = Input::get('area_id');				
					$url = "areas/edit_area"."/".$area_id;					
					$area = Area::find($area_id);
					$area->nombre = Input::get('nombre_area');
					$area->descripcion = Input::get('descripcion_area');
					$area->idtipo_area = Input::get('tipo_area');
					$area->save();
					
					return Redirect::to('areas/list_areas')->with('message', 'Se editó correctamente el área: '.$area->nombre);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_area($idarea=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idarea)
			{	
				$data["tipo_areas"] = TipoArea::lists('nombre','idtipo_area');
				$data["area_info"] = Area::searchAreaById($idarea)->get();
				$data["personal"] = User::searchPersonalByIdArea($idarea)->paginate(10);

				if($data["area_info"]->isEmpty()){
					return Redirect::to('areas/list_areas');
				}
				$data["area_info"] = $data["area_info"][0];

				return View::make('areas/viewArea',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_area()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$area_id = Input::get('area_id');
				$url = "areas/edit_area"."/".$area_id;
				$area = Area::withTrashed()->find($area_id);
				$area->restore();
				Session::flash('message', 'Se habilitó correctamente el área.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_area()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$area_id = Input::get("area_id");
				$url = "areas/edit_area"."/".$area_id;
				$area = Area::find($area_id);
				$usuarios_activos = User::searchPersonalActivoByIdArea($area_id)->get();
				if(count($usuarios_activos)==0){
										
					$area->delete();
					Session::flash('message','Se inhabilitó correctamente el área.' );
				}
				else{
					Session::flash('error', 'El área cuenta con personal activo. Acción no realizada.' );
				}				
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}