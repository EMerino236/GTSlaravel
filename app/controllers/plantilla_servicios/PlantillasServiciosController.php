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
				$data["search_grupo"] = null;
				$data["search_departamento"] = null;
				$data["search_usuario"] = null;
				$data["search_servicio_clinico"] = null;
				//USAR MODELO
				$data["servicios_data"] = DocumentoInf::getDocumentosInfo()->paginate(10);
				
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
				$data["search_grupo"] = Input::get('search_grupo');
				$data["search_departamento"] = Input::get('search_departamento');
				$data["search_usuario"] = Input::get('search_usuario');
				$data["search_servicio_clinico"] = Input::get('search_servicio_clinico');
				//HACER UNA BUSQUEDA PARA EL NUEVO MODELO
				$data["servicios_data"] = DocumentoInf::getDocumentosInfo()->paginate(10);
				//$data["servicios_data"] = DocumentoInf::searchDocumentos($data["search_nombre"],$data["search_autor"],$data["search_codigo_archivamiento"],
				//						$data["search_ubicacion"],$data["search_tipo_documento"])->paginate(10);
				return View::make('investigacion/plantillas/listServicios',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["usuarios"] = User::where('idrol',3)->lists('nombre','id');
				return View::make('investigacion/plantillas/createServicio',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100',
							'departamento' => 'required|max:100',
							'servicio_clinico' => 'required|max:100',
							'grupo' => 'required|max:100',
							'usuario' => 'required|max:100',	
							'tareas' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('plantillas_servicios/create_servicio')->withErrors($validator)->withInput(Input::all());
				}else{

				    //DO SOMETHING
					Session::flash('message', 'Se registró correctamente el Documento.');				
					return Redirect::to('plantillas_servicios/create_servicio');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_servicio($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $id){
				$data["documento_info"] = DocumentoInf::searchDocumentoById($id)->get();
				if($data["documento_info"]->isEmpty()){
					return Redirect::to('plantillas_servicios/list_servicios');
				}
				$data["documento_info"] = $data["documento_info"][0];
				return View::make('investigacion/plantillas/editServicio',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_show_servicio($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $id){
				$data["documento_info"] = DocumentoInf::searchDocumentoById($id)->get();
				if($data["documento_info"]->isEmpty()){
					return Redirect::to('plantillas_servicios/list_servicios');
				}
				$data["documento_info"] = $data["documento_info"][0];
				return View::make('investigacion/plantillas/showServicio',$data);
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
