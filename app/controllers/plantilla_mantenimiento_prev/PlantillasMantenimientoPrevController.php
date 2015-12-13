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
				//BUSCAR GUIA RELACIONADA A FAMILIA DE ACTIVO
				$data["guia"] = DocumentoInf::where('idfamilia_activo', $id)->first();
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
				$data["guia"] = DocumentoInf::where('idfamilia_activo', $id)->first();
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
							'familia_id' 	=> 'required',
							'archivo'		=> 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('plantillas_mant_preventivo/create_mantenimiento/'.$id)->withErrors($validator)->withInput(Input::all());
				}else{
					$data['tareas_borradas'] = Input::get('tareas_borradas');
					$data['tareas'] = Input::get('tareas');
					$data['usuarios'] = Input::get('usuarios');
				    
				    if(!$data['tareas_borradas'] == ""){
				    	$tareas_borradas = json_decode($data['tareas_borradas']);
				    	foreach ($tareas_borradas as $tarea) {
				    		$tarea_borrar = TareaOtPreventivo::find($tarea);
				    		$tarea_borrar->delete();
				    	}
				    }

				    if($data['tareas']!="" && $data['usuarios']!=""){
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

				    //GUARDAR GUIA DE MANTENIMIENTO
				    if(Input::hasFile('archivo') && Input::get('nombre') && Input::get('autor') && Input::get('codigo_archivamiento') && Input::get('ubicacion')){
				    	$rutaDestino 	='';
					    $nombreArchivo 	='';	
					    if (Input::hasFile('archivo')) {
					        $archivo            		= Input::file('archivo');
					        $rutaDestino 				= 'documentos/investigacion/guias/Guia de mantenimiento preventivo por tipo de TS' .$id. '/';
					        $nombreArchivo        		= $archivo->getClientOriginalName();
					        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
					        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
					    }

					    $doc = DocumentoInf::where('idfamilia_activo', $id)->first();
					    if($doc){
					    	$documento = $doc;
					    }else{
					    	$documento = new DocumentoInf;
					    }
						$documento->nombre = Input::get('nombre');
						if (Input::hasFile('archivo')) {
							$documento->nombre_archivo = $nombreArchivo;
							$documento->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						}
						$documento->descripcion = null;
						$documento->autor = Input::get('autor');
						$documento->codigo_archivamiento = Input::get('codigo_archivamiento');
						$documento->ubicacion = Input::get('ubicacion');
						$documento->url = $rutaDestino;
						$documento->idtipo_documentosinf = 4;
						$documento->idestado = 1;
						$documento->idfamilia_activo = $id;
						$documento->save();
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

	public function download_documento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12){
				$rutaDestino = Input::get('url').Input::get('nombre_archivo_encriptado');
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename(Input::get('nombre_archivo')),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}
