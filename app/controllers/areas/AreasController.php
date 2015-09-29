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
				$data["search"] = null;
				$data["tipo_area"] = TipoArea::lists('nombre','idtipo_area');
				array_unshift($data["tipo_area"], "Todos");
				/*echo '<pre>';
				print_r($data["tipo_area"]);
				exit;*/
				$data["areas_data"] = Area::getAreasInfo()->paginate(10);
				return View::make('areas/listAreas',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_area(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = Input::get('search');
				$data["tipo_area"] = TipoArea::lists('nombre','idtipo_area'); 
				array_unshift($data["tipo_area"], "Todos");
				$data["areas_data"] = Area::searchAreas($data["search"])->paginate(10);
				if($data["search"]==0){
					return Redirect::to('areas/list_areas');
				}else{
					return View::make('areas/listAreas',$data);	
				}
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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
				$data["centro_costos"] = CentroCosto::lists('nombre','idcentro_costo');
				array_unshift($data["tipo_areas"], "");
				array_unshift($data["centro_costos"], "");
				return View::make('areas/createArea',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_area($idarea=null){
		
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idarea)
			{	
				$data["tipo_areas"] = TipoArea::lists('nombre','idtipo_area');
				$data["centro_costos"] = CentroCosto::lists('nombre','idcentro_costo');
				$data["area_info"] = Area::searchAreaById($idarea)->get();
				$data["personal"] = User::searchPersonalByIdArea($idarea)->get();
				if($data["area_info"]->isEmpty()){
					return Redirect::to('areas/list_areas');
				}
				$data["area_info"] = $data["area_info"][0];

				return View::make('areas/editArea',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}

	}

	public function submit_create_area(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100|unique:areas',
							'descripcion' => 'required|max:200',
							'tipo_area' => 'required',
							'centro_costo' => 'required',						
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('areas/create_area')->withErrors($validator)->withInput(Input::all());
				}else{
					$area = new Area;
					$area->nombre = Input::get('nombre');
					$area->descripcion = Input::get('descripcion');
					$area->idtipo_area = Input::get('tipo_area');
					$area->idcentro_costo = Input::get('centro_costo');
					$area->idestado = 1;
					$area->save();
					Session::flash('message', 'Se registró correctamente el area.');
					
					return Redirect::to('areas/list_areas');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}	

	public function submit_edit_area(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100',
							'descripcion' => 'required|max:200',
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
					$area->nombre = Input::get('nombre');
					$area->descripcion = Input::get('descripcion');
					$area->save();
					Session::flash('message', 'Se editó correctamente el area.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_enable_area(){
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
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_disable_area(){
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
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}