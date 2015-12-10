<?php

class PlantillasServiciosController extends \BaseController {

	public function list_servicios()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				
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
			if($data["user"]->idrol == 1){

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

	public function render_create_servicio($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 && $id){
				$data["familia_activo"] = FamiliaActivo::find($id);
				$data["usuarios"] = User::where('idrol',3)->lists('nombre','id');
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
			if($data["user"]->idrol == 1){
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
					var_dump(Input::all());
					$data['tareas_borradas'] = Input::get('tareas_borradas');
					$data['tareas'] = Input::get('tareas');
					$data['usuarios'] = Input::get('usuarios');
				    //DO SOMETHING
				    
				    if(!$data['tareas_borradas'] == ""){
				    	var_dump("borrar");
				    	$tareas_borradas = json_decode($data['tareas_borradas']);
				    	foreach ($tareas_borradas as $tarea) {
				    		$tarea_borrar = TareasOtInspeccionEquipo::find($tarea);
				    		$tarea_borrar->delete();
				    	}
				    }

				    if($data['tareas']!="" && $data['usuarios']!=""){
				    	//crear tareas
				    	var_dump("crear");
				    	$tareas = $data['tareas'];
				    	$usuarios = $data['usuarios'];
				    	foreach ($tareas as $key => $tarea) {
				    		$tarea_crear = new TareasOtInspeccionEquipo;
				    		$tarea_crear->nombre = $tarea;
				    		$tarea_crear->idfamilia_activo = $id;
				    		$tarea_crear->creador = $usuarios[$key];
				    		$tarea_crear->save();
				    	}
				    }
				    
					Session::flash('message', 'Se registraron correctamente las Tareas.');				
					return Redirect::to('plantillas_servicios/create_servicio/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_equipo_ajax(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$equipo = Activo::searchActivosByCodigoPatrimonial($data)->get();
				if(!$equipo->isEmpty()){
					$departamento 		= UbicacionFisica::find($equipo[0]->idubicacion_fisica);
					$servicio_clinico 	= Servicio::find($equipo[0]->idservicio);
					$grupo 				= Grupo::find($equipo[0]->idgrupo);
					$equipo = [
							'nombre_equipo'		=>	$equipo[0]->nombre_equipo,
							'departamento'		=>	$departamento->nombre,
							'servicio_clinico'	=>	$servicio_clinico->nombre,
							'grupo'				=>	$grupo->nombre,
						];
				}else{
				 	$equipo = null;
				}
			}else{
				$equipo = null;
			}

			return Response::json(array( 'success' => true, 'equipo' => $equipo ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}
