<?php

class PlantillasMantenimientoPrevController extends \BaseController {

	public function list_mantenimientos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12){
				
				$data["search_nombre"] = null;
				$data["search_marca"] = null;
				
				$data["search_grupo"] = null;
				$data["search_departamento"] = null;
				$data["search_usuario"] = null;
				$data["search_servicio_clinico"] = null;
				
				$data["marcas"] = Marca::all()->lists('nombre','idmarca');
				$data["mantenimientos_data"] = FamiliaActivo::GetFamiliaActivosInfo()->paginate(10);
				
				return View::make('investigacion/plantillas/mantenimiento/listMantenimientos',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_mantenimiento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12){

				$data["search_nombre"] = Input::get('search_nombre');
				$data["search_marca"] = Input::get('search_marca');

				if($data["search_nombre"]==null && $data["search_marca"] == "0"){
					return Redirect::to('plantillas_mant_preventivo/list_mantenimientos');
				}

				$data["search_grupo"] = null;
				$data["search_departamento"] = null;
				$data["search_usuario"] = null;
				$data["search_servicio_clinico"] = null;
				
				$data["marcas"] = Marca::all()->lists('nombre','idmarca');
				$data["mantenimientos_data"] = FamiliaActivo::searchFamiliaActivo($data["search_nombre"],$data["search_marca"])->paginate(10);
				return View::make('investigacion/plantillas/mantenimiento/listMantenimientos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function show_mantenimiento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12 && $id){
				$data["familia_activo"] = FamiliaActivo::find($id);
				$data["tareas"] = TareaOtPreventivo::where('idfamilia_activo',$data["familia_activo"]->idfamilia_activo)->get();
				return View::make('investigacion/plantillas/mantenimiento/showMantenimiento',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_mantenimiento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 && $id){
				$data["familia_activo"] = FamiliaActivo::find($id);
				$data["usuarios"] = User::where('idrol',3)->lists('nombre','id');
				$data["tareas"] = TareaOtPreventivo::where('idfamilia_activo',$data["familia_activo"]->idfamilia_activo)->get();
				return View::make('investigacion/plantillas/mantenimiento/createMantenimiento',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_mantenimiento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$rules = array(
							'familia_id' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('plantillas_mant_preventivo/create_mantenimiento/'.$id)->withErrors($validator)->withInput(Input::all());
				}else{
					var_dump(Input::all());
					$data['tareas_borradas'] = Input::get('tareas_borradas');
					$data['tareas'] = Input::get('tareas');
					$data['usuarios'] = Input::get('usuarios');
				    //DO SOMETHING
				    
				    if(!$data['tareas_borradas'] == ""){
				    	var_dump("borrar");
				    	$tareas_borradas = json_decode($data['tareas_borradas']);
				    	foreach ($tareas_borradas as $tarea) {
				    		$tarea_borrar = TareaOtPreventivo::find($tarea);
				    		$tarea_borrar->delete();
				    	}
				    }

				    if($data['tareas']!="" && $data['usuarios']!=""){
				    	//crear tareas
				    	var_dump("crear");
				    	$tareas = $data['tareas'];
				    	$usuarios = $data['usuarios'];
				    	foreach ($tareas as $key => $tarea) {
				    		$tarea_crear = new TareaOtPreventivo;
				    		$tarea_crear->nombre = $tarea;
				    		$tarea_crear->idfamilia_activo = $id;
				    		$tarea_crear->creador = $usuarios[$key];
				    		$tarea_crear->save();
				    	}
				    }
				    
					Session::flash('message', 'Se modificaron correctamente las Tareas.');				
					return Redirect::to('plantillas_mant_preventivo/show_mantenimiento/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}
}
