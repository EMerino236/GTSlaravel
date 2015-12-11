<?php

class DocumentoController extends BaseController {

	public function render_create_documento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$data["tipo_documentos"] = TipoDocumentos::orderBy('nombre','asc')->lists('nombre','idtipo_documento');
				return View::make('documentos/createDocumento',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_documento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100|unique:documentos',
							'descripcion' => 'required|max:200',
							'autor' => 'required|max:100',
							'codigo_archivamiento' => 'required|max:100|unique:documentos',
							'ubicacion' => 'required|max:100',	
							'archivo' => 'max:15360',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('documento/create_documento')->withErrors($validator)->withInput(Input::all());
				}else{
				    $data["tipo_documentos"] = TipoDocumentos::searchTipoDocumentosById(Input::get('idtipo_documento'))->get();	
				    $rutaDestino ='';
				    $nombreArchivo        ='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            = Input::file('archivo');
				        $rutaDestino = 'documentos/bienes/' . $data["tipo_documentos"][0]->nombre . '/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }


					$documento = new Documento;
					$documento->nombre = Input::get('nombre');
					$documento->nombre_archivo = $nombreArchivo;
					$documento->nombre_archivo_encriptado = $nombreArchivoEncriptado;
					$documento->descripcion = Input::get('descripcion');
					$documento->autor = Input::get('autor');
					$documento->codigo_archivamiento = Input::get('codigo_archivamiento');
					$documento->ubicacion = Input::get('ubicacion');
					$documento->url = $rutaDestino;
					$documento->idtipo_documento = Input::get('idtipo_documento');
					$documento->idestado = 1;
					$documento->save();
					Session::flash('message', 'Se registró correctamente el Documento.');				
					return Redirect::to('documento/create_documento');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_documento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $id){
				$data["tipo_documentos"] = TipoDocumentos::lists('nombre','idtipo_documento');
				$data["documento_info"] = Documento::searchDocumentoById($id)->get();
				$data["archivo"] = basename($data["documento_info"][0]->url);
				if($data["documento_info"]->isEmpty()){
					return Redirect::to('documento/list_documento');
				}
				$data["documento_info"] = $data["documento_info"][0];
				return View::make('documentos/editDocumento',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_documento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$rules = array(
							'descripcion' => 'required|max:200',
							'autor' => 'required|max:100',
							'codigo_archivamiento' => 'required|max:100',
							'ubicacion' => 'required|max:100',				
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$iddocumento = Input::get('documento_id');
					$url = "documento/edit_documento"."/".$iddocumento;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$data["tipo_documentos"] = TipoDocumentos::searchTipoDocumentosById(Input::get('idtipo_documento'))->get();
					$data["documento_info"] = Documento::searchDocumentoById(Input::get('documento_id'))->get();
					/*
					if(!Input::file('archivo')){
						$archivo = readfile($data["documento_info"][0]->url);
						echo "<pre>";						
						print_r($archivo);
						exit;
				        $rutaDestino = 'documentos/' . $data["tipo_documentos"][0]->nombre . '/';
				        $nombreArchivo        = basename($data["documento_info"][0]->url);
				        $uploadSuccess   = $archivo->move($rutaDestino, $nombreArchivo);
					}
				    $rutaDestino ='';
				    $nombreArchivo        ='';		    
				    if (Input::hasFile('archivo')) {
				        $archivo            = Input::file('archivo');
				        $rutaDestino = 'documentos/' . $data["tipo_documentos"][0]->nombre . '/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $uploadSuccess   = $archivo->move($rutaDestino, $nombreArchivo);
				    }
				    */

					$iddocumento = Input::get('documento_id');
					$url = "documento/edit_documento"."/".$iddocumento;
					$documento = Documento::find($iddocumento);
					$documento->nombre = Input::get('nombre');
					$documento->descripcion = Input::get('descripcion');
					$documento->autor = Input::get('autor');
					$documento->codigo_archivamiento = Input::get('codigo_archivamiento');
					$documento->ubicacion = Input::get('ubicacion');
					$documento->url = $data["documento_info"][0]->url;
					$documento->idtipo_documento = $data["documento_info"][0]->idtipo_documento;
					$documento->idestado = 1;
					$documento->save();
					Session::flash('message', 'Se editó correctamente el Documento.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_documentos()
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
				$data["documentos_data"] = Documento::getDocumentosInfo()->paginate(10);
				return View::make('documentos/listDocumentos',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_documento()
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
					$data["documentos_data"] = Documento::getDocumentosInfo()->paginate(10);
				}else{
					$data["documentos_data"] = Documento::searchDocumentos($data["search_nombre"],$data["search_autor"],$data["search_codigo_archivamiento"],
										$data["search_ubicacion"],$data["search_tipo_documento"])->paginate(10);
				}

				return View::make('documentos/listDocumentos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_documento(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$documento_id = Input::get('documento_id');
				$url = "documento/edit_documento"."/".$documento_id;
				$documento = Documento::withTrashed()->find($documento_id);
				$documento->restore();
				Session::flash('message', 'Se habilitó correctamente el documento.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_documento(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$documento_id = Input::get("documento_id");
				$url = "documento/edit_documento"."/".$documento_id;
				$documento = Documento::find($documento_id);
				$documento->delete();
				Session::flash('message','Se inhabilitó correctamente el documento.' );					
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

	public function render_view_documento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12  ) && $id){
				$data["tipo_documentos"] = TipoDocumentos::lists('nombre','idtipo_documento');
				$data["documento_info"] = Documento::searchDocumentoById($id)->get();
				$data["archivo"] = basename($data["documento_info"][0]->url);
				if($data["documento_info"]->isEmpty()){
					return Redirect::to('documento/list_documento');
				}
				$data["documento_info"] = $data["documento_info"][0];
				return View::make('documentos/viewDocumento',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	
}