<?php

class DocumentoPlanDirectorController extends BaseController
{
	public function render_create_documento_plan_director()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["tipo_documento"] = TipoDocumentoPlanDirector::lists('nombre','idtipo_documentosPlanDirector');
				$data["documento_plan_director_info"] = null;
				return View::make('documentos_plan_director/createDocumentoPlanDirector',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_documento_plan_director(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	

				$attributes = array(
							'idtipo_documento' => 'Tipo de Documento',
							'nombre' => 'Nombre',
							'anho' => 'Año',
							'archivo' => 'Documento adjunto',	
				);

				$messages = array();
	
				$rules = array(
							'idtipo_documento' => 'required',
							'nombre' => 'required|unique:documentosplandirector',
							'anho' => 'required',
							'archivo' => 'required|max:15360',											
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('plan_director/create_documento_plan_director')->withErrors($validator)->withInput(Input::all());					
				}else{
				    $rutaDestino ='';
				    $nombreArchivo ='';	
				    if (Input::hasFile('archivo')) {
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/planeamiento/DocumentosPlanDirector/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }
					$documento_plan_director = new DocumentoPlanDirector;
					$documento_plan_director->nombre = Input::get('nombre');	
					$documento_plan_director->url = $rutaDestino;
					$documento_plan_director->nombre_archivo = $nombreArchivo;
					$documento_plan_director->nombre_archivo_encriptado = $nombreArchivoEncriptado;
					$documento_plan_director->idtipo_documentosPlanDirector = Input::get('idtipo_documento');
					$documento_plan_director->anho = Input::get('anho');				
					$documento_plan_director->save();
					
					Session::flash('message', 'Se registró correctamente el Documento Plan Director.');
					return Redirect::to('plan_director/create_documento_plan_director');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_documento_plan_director($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["tipo_documento"] = TipoDocumentoPlanDirector::lists('nombre','idtipo_documentosPlanDirector');
				$data["documento_plan_director_info"] = DocumentoPlanDirector::withTrashed()->find($id);
				return View::make('documentos_plan_director/editDocumentoPlanDirector',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_documento_plan_director(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$iddocumentosPlanDirector = Input::get('iddocumentosPlanDirector');
				// Validate the info, create rules for the inputs	
				$rules = array(
							'idtipo_documento' => 'required',
							'nombre' => 'required|unique:documentosplandirector,nombre,'.$iddocumentosPlanDirector.',iddocumentosPlanDirector',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$url = "plan_director/edit_documento_plan_director"."/".$iddocumentosPlanDirector;
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());					
				}else{
					$documento_plan_director = DocumentoPlanDirector::find($iddocumentosPlanDirector);
					$documento_plan_director->nombre = Input::get('nombre');	
					$documento_plan_director->idtipo_documentosPlanDirector = Input::get('idtipo_documento');
					$documento_plan_director->anho = Input::get('anho');				
					$documento_plan_director->save();
					
					Session::flash('message', 'Se editó correctamente el Documento para Plan Director.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_documento_plan_director($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["tipo_documento"] = TipoDocumentoPlanDirector::lists('nombre','idtipo_documentosPlanDirector');
				$data["documento_plan_director_info"] = DocumentoPlanDirector::withTrashed()->find($id);
				return View::make('documentos_plan_director/viewDocumentoPlanDirector',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_Documento_plan_director()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_fecha_ini"] = null;			
				$data["search_fecha_fin"] = null;	
				$data["tipo_documento"] = TipoDocumentoPlanDirector::lists('nombre','idtipo_documentosPlanDirector');
				$data["search_tipo_documento"] = null;		

				$data["plan_director_data"] = DocumentoPlanDirector::getDocumentosPlanDirectorInfo()->paginate(10);
				return View::make('documentos_plan_director/listDocumentoPlanDirector',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_documento_plan_director()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');			
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');	
				$data["tipo_documento"] = TipoDocumentoPlanDirector::lists('nombre','idtipo_documentosPlanDirector');
				$data["search_tipo_documento"] = Input::get('search_tipo_documento');	

				$data["plan_director_data"] = DocumentoPlanDirector::searchDocumentosPlanDirector($data["search_fecha_ini"],$data["search_fecha_fin"],$data["search_tipo_documento"])->paginate(10);
				return View::make('documentos_plan_director/listDocumentoPlanDirector',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	

	public function download_documento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$reporte_paac = DocumentoPlanDirector::find($id);
				$file= $reporte_paac->url.$reporte_paac->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($reporte_paac->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_documento_plan_director()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$iddocumentosPlanDirector = Input::get('iddocumentosPlanDirector');
				$url = "plan_director/edit_documento_plan_director/".$iddocumentosPlanDirector;
				$reporte_paac = DocumentoPlanDirector::find($iddocumentosPlanDirector);
				$reporte_paac->delete();

				Session::flash('message', 'Se inhabilitó correctamente el Documento.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_documento_plan_director()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$iddocumentosPlanDirector = Input::get('iddocumentosPlanDirector');
				$url = "plan_director/edit_documento_plan_director/".$iddocumentosPlanDirector;
				$reporte_paac = DocumentoPlanDirector::withTrashed()->find($iddocumentosPlanDirector);
				$reporte_paac->restore();

				Session::flash('message', 'Se habilitó correctamente el Documento.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}