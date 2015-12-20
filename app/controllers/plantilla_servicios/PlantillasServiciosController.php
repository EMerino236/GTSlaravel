<?php

class PlantillasServiciosController extends \BaseController {

	public function list_servicios()
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
				$data["servicios_data"] = FamiliaActivo::GetFamiliaActivosInfo()->paginate(10);
				
				return View::make('investigacion/plantillas/listServicios',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_servicio()
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
					return Redirect::to('plantillas_servicios/list_servicios');
				}

				$data["search_grupo"] = null;
				$data["search_departamento"] = null;
				$data["search_usuario"] = null;
				$data["search_servicio_clinico"] = null;
				
				$data["marcas"] = Marca::all()->lists('nombre','idmarca');
				$data["servicios_data"] = FamiliaActivo::searchFamiliaActivo($data["search_nombre"],$data["search_marca"])->paginate(10);
				return View::make('investigacion/plantillas/listServicios',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function show_servicio($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12 && $id){
				$data["familia_activo"] = FamiliaActivo::find($id);
				$data["tareas"] = TareasOtInspeccionEquipo::where('idfamilia_activo',$data["familia_activo"]->idfamilia_activo)->get();
				return View::make('investigacion/plantillas/showServicio',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_servicio($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 && $id){
				$data["familia_activo"] = FamiliaActivo::find($id);
				$data["tareas"] = TareasOtInspeccionEquipo::where('idfamilia_activo',$data["familia_activo"]->idfamilia_activo)->get();
				return View::make('investigacion/plantillas/createServicio',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_servicio($id=null)
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
					return Redirect::to('plantillas_servicios/create_servicio/'.$id)->withErrors($validator)->withInput(Input::all());
				}else{
					$data['tareas_borradas'] = Input::get('tareas_borradas');
					$data['tareas'] = Input::get('tareas');
				    
				    if(!$data['tareas_borradas'] == ""){
				    	$tareas_borradas = json_decode($data['tareas_borradas']);
				    	foreach ($tareas_borradas as $tarea) {
				    		$tarea_borrar = TareasOtInspeccionEquipo::find($tarea);
				    		$tarea_borrar->borrado_por = $data["user"]->id;
				    		$tarea_borrar->save();
				    		$tarea_borrar->delete();
				    	}
				    }

				    if($data['tareas']!=""){
				    	//crear tareas
				    	$tareas = $data['tareas'];
				    	foreach ($tareas as $key => $tarea) {
				    		$tarea_crear = new TareasOtInspeccionEquipo;
				    		$tarea_crear->nombre = $tarea;
				    		$tarea_crear->idfamilia_activo = $id;
				    		$tarea_crear->creador = $data["user"]->id;
				    		$tarea_crear->save();
				    	}
				    }
				    
					Session::flash('message', 'Se modificaron correctamente las Tareas.');				
					return Redirect::to('plantillas_servicios/show_servicio/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

}