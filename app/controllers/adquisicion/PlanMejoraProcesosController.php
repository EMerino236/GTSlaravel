<?php

class PlanMejoraProcesosController extends BaseController {

	public function render_create_plan_mejora_proceso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$data["tipo_documentos"] = TipoDocumentos::orderBy('nombre','asc')->lists('nombre','idtipo_documento');
				return View::make('plan_mejora_procesos/createPlanMejoraProceso',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_plan_mejora_proceso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'nombre' => 'Nombre del Documento',
					'descripcion' => 'Descripción',
					'autor' => 'Autor',
					'codigo_archivamiento' => 'Código de Archivamiento',
					'ubicacion' => 'Ubicación',	
					'archivo' => 'Archivo',			
				);

				$messages = array();

				$rules = array(
					'nombre' => 'required|max:100|unique:documentos|alpha_num_spaces',
					'descripcion' => 'required|max:200|alpha_num_spaces',
					'autor' => 'required|max:100|alpha_num_spaces',
					'codigo_archivamiento' => 'required|max:100|unique:documentos|alpha_num',
					'ubicacion' => 'required|max:100|alpha_num_spaces',	
					'archivo' => 'max:15360',			
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('plan_mejora_procesos/create_plan_mejora_procesos')->withErrors($validator)->withInput(Input::all());
				}else{
				    $data["tipo_documentos"] = TipoDocumentos::searchTipoDocumentosById(Input::get('idtipo_documento'))->get();	
				    $rutaDestino ='';
				    $nombreArchivo        ='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/adquisicion/' . $data["tipo_documentos"][0]->nombre . '/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    	$plan_mejora_proceso = new PlanMejoraProceso;
						$plan_mejora_proceso->nombre = Input::get('nombre');
						$plan_mejora_proceso->nombre_archivo = $nombreArchivo;
						$plan_mejora_proceso->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$plan_mejora_proceso->descripcion = Input::get('descripcion');
						$plan_mejora_proceso->autor = Input::get('autor');
						$plan_mejora_proceso->codigo_archivamiento = Input::get('codigo_archivamiento');
						$plan_mejora_proceso->ubicacion = Input::get('ubicacion');
						$plan_mejora_proceso->url = $rutaDestino;
						$plan_mejora_proceso->idtipo_documento = Input::get('idtipo_documento');
						$plan_mejora_proceso->save();
				    }else{
				    	$plan_mejora_proceso = new PlanMejoraProceso;
						$plan_mejora_proceso->nombre = Input::get('nombre');
						$plan_mejora_proceso->descripcion = Input::get('descripcion');
						$plan_mejora_proceso->autor = Input::get('autor');
						$plan_mejora_proceso->codigo_archivamiento = Input::get('codigo_archivamiento');
						$plan_mejora_proceso->ubicacion = Input::get('ubicacion');
						$plan_mejora_proceso->idtipo_documento = Input::get('idtipo_documento');
						$plan_mejora_proceso->save();
				    }

					
					Session::flash('message', 'Se registró correctamente el Plan de Mejora de Procesos.');				
					return Redirect::to('plan_mejora_proceso/list_plan_mejora_procesos');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_plan_mejora_proceso($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $id){
				$data["tipo_documentos"] = TipoDocumentos::lists('nombre','idtipo_documento');
				$data["plan_mejora_proceso_info"] = PlanMejoraProceso::searchPlanMejoraProcesoById($id)->get();
				$data["archivo"] = basename($data["plan_mejora_proceso_info"][0]->url);
				if($data["plan_mejora_proceso_info"]->isEmpty()){
					return Redirect::to('plan_mejora_proceso/list_plan_mejora_procesos');
				}
				$data["plan_mejora_proceso_info"] = $data["plan_mejora_proceso_info"][0];
				return View::make('plan_mejora_procesos/editPlanMejoraProceso',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_plan_mejora_proceso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$iddocumento = Input::get('documento_id');
				$attributes = array(
					'nombre' => 'Nombre del Documento',
					'descripcion' => 'Descripción',
					'autor' => 'Autor',
					'codigo_archivamiento' => 'Código de Archivamiento',
					'ubicacion' => 'Ubicación'	
				);

				$messages = array();

				$rules = array(
					'nombre' => 'required|max:100|alpha_num_spaces|unique:plan_mejora_procesos,nombre,'.$iddocumento.',iddocumento',
					'descripcion' => 'required|max:200|alpha_num_spaces',
					'autor' => 'required|max:100|alpha_num_spaces',
					'codigo_archivamiento' => 'required|max:100|alpha_num|unique:plan_mejora_procesos,codigo_archivamiento,'.$iddocumento.',iddocumento',
					'ubicacion' => 'required|max:100|alpha_num_spaces'
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$iddocumento = Input::get('documento_id');
					$url = "plan_mejora_proceso/edit_plan_mejora_proceso"."/".$iddocumento;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$iddocumento = Input::get('documento_id');
					$url = "plan_mejora_proceso/edit_plan_mejora_proceso"."/".$iddocumento;
					$plan_mejora_proceso = PlanMejoraProceso::find($iddocumento);
					$plan_mejora_proceso->nombre = Input::get('nombre');
					$plan_mejora_proceso->descripcion = Input::get('descripcion');
					$plan_mejora_proceso->autor = Input::get('autor');
					$plan_mejora_proceso->codigo_archivamiento = Input::get('codigo_archivamiento');
					$plan_mejora_proceso->ubicacion = Input::get('ubicacion');
					$plan_mejora_proceso->save();
					Session::flash('message', 'Se editó correctamente el Plan de Mejora de Procesos.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_plan_mejora_procesos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				$data["tipo_documentos"] = TipoDocumentos::orderBy('nombre','asc')->lists('nombre','idtipo_documento');

				$data["search_nombre"] = null;
				$data["search_autor"] = null;
				$data["search_codigo_archivamiento"] = null;
				$data["search_ubicacion"] = null;
				$data["search_tipo_documento"] = null;
				$data["plan_mejora_procesos_data"] = PlanMejoraProceso::getPlanMejoraProcesosInfo()->paginate(10);
				return View::make('plan_mejora_procesos/listPlanMejoraProcesos',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_plan_mejora_proceso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["tipo_documentos"] = TipoDocumentos::lists('nombre','idtipo_documento');

				$data["search_nombre"] = Input::get('search_nombre');
				$data["search_autor"] = Input::get('search_autor');
				$data["search_codigo_archivamiento"] = Input::get('search_codigo_archivamiento');
				$data["search_ubicacion"] = Input::get('search_ubicacion');
				$data["search_tipo_documento"] = Input::get('search_tipo_documento');

				
				if($data["search_nombre"]==null && $data["search_autor"] == null && $data["search_codigo_archivamiento"]==null &&
					$data["search_ubicacion"] == null && $data["search_tipo_documento"]==null){
					$data["plan_mejora_procesos_data"] = PlanMejoraProceso::getPlanMejoraProcesosInfo()->paginate(10);
				}else{
					$data["plan_mejora_procesos_data"] = PlanMejoraProceso::searchPlanMejoraProcesos($data["search_nombre"],$data["search_autor"],$data["search_codigo_archivamiento"],
										$data["search_ubicacion"],$data["search_tipo_documento"])->paginate(10);
				}

				return View::make('plan_mejora_procesos/listPlanMejoraProcesos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_plan_mejora_proceso(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$documento_id = Input::get('documento_id');
				$url = "plan_mejora_proceso/edit_plan_mejora_proceso"."/".$documento_id;
				$plan_mejora_procesos = PlanMejoraProceso::withTrashed()->find($documento_id);
				$plan_mejora_procesos->restore();
				Session::flash('message', 'Se habilitó correctamente el plan de mejora de procesos.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_plan_mejora_proceso(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$documento_id = Input::get("documento_id");
				$url = "plan_mejora_proceso/edit_plan_mejora_proceso"."/".$documento_id;
				$plan_mejora_procesos = PlanMejoraProceso::find($documento_id);
				$plan_mejora_procesos->delete();
				Session::flash('message','Se inhabilitó correctamente el plan de mejora de procesos.' );					
				return Redirect::to($url);
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
			
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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

	public function render_view_plan_mejora_proceso($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12  ) && $id){
				$data["tipo_documentos"] = TipoDocumentos::lists('nombre','idtipo_documento');
				$data["plan_mejora_proceso_info"] = PlanMejoraProceso::searchPlanMejoraProcesoById($id)->get();
				$data["archivo"] = basename($data["plan_mejora_proceso_info"][0]->url);
				if($data["plan_mejora_proceso_info"]->isEmpty()){
					return Redirect::to('plan_mejora_procesos/list_plan_mejora_procesos');
				}
				$data["plan_mejora_proceso_info"] = $data["plan_mejora_proceso_info"][0];
				return View::make('plan_mejora_procesos/viewPlanMejoraProceso',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	
}