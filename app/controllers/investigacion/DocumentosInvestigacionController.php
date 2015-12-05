<?php

class DocumentosInvestigacionController extends \BaseController {

	public function list_documentos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				
				$data["tipo_documentos"] = TipoDocumentoInf::orderBy('nombre','asc')->lists('nombre','idtipo_documentosinf');

				$data["search_nombre"] = null;
				$data["search_autor"] = null;
				$data["search_codigo_archivamiento"] = null;
				$data["search_ubicacion"] = null;
				$data["search_tipo_documento"] = null;
				$data["documentos_data"] = DocumentoInf::getDocumentosInfo()->paginate(10);
				
				return View::make('investigacion/documentos/listDocumentos',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_documento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){

				$data["tipo_documentos"] = TipoDocumentoInf::orderBy('nombre','asc')->lists('nombre','idtipo_documentosinf');
				return View::make('investigacion/documentos/createDocumento',$data);
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
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100|unique:documentosinf',
							'descripcion' => 'required|max:200',
							'autor' => 'required|max:100',
							'codigo_archivamiento' => 'required|max:100|unique:documentosinf',
							'ubicacion' => 'required|max:100',	
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('documento_investigacion/create_documento')->withErrors($validator)->withInput(Input::all());
				}else{
				    $data["tipo_documentos"] = TipoDocumentoInf::searchTipoDocumentosById(Input::get('idtipo_documento'))->get();	
				    $rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'documentos/investigacion/' . $data["tipo_documentos"][0]->nombre . '/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }

					$documento = new DocumentoInf;
					$documento->nombre = Input::get('nombre');
					if (Input::hasFile('archivo')) {
						$documento->nombre_archivo = $nombreArchivo;
						$documento->nombre_archivo_encriptado = $nombreArchivoEncriptado;
					}
					$documento->descripcion = Input::get('descripcion');
					$documento->autor = Input::get('autor');
					$documento->codigo_archivamiento = Input::get('codigo_archivamiento');
					$documento->ubicacion = Input::get('ubicacion');
					$documento->url = $rutaDestino;
					$documento->idtipo_documentosinf = Input::get('idtipo_documento');
					$documento->idestado = 1;
					$documento->save();
					Session::flash('message', 'Se registró correctamente el Documento.');				
					return Redirect::to('documento_investigacion/create_documento');
				}
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
			if($data["user"]->idrol == 1){
				$data["tipo_documentos"] = TipoDocumentoInf::lists('nombre','idtipo_documentosinf');

				$data["search_nombre"] = Input::get('search_nombre');
				$data["search_autor"] = Input::get('search_autor');
				$data["search_codigo_archivamiento"] = Input::get('search_codigo_archivamiento');
				$data["search_ubicacion"] = Input::get('search_ubicacion');
				$data["search_tipo_documento"] = Input::get('search_tipo_documento');
				//HACER UNA BUSQUEDA PARA EL NUEVO MODELO
				$data["documentos_data"] = DocumentoInf::searchDocumentos($data["search_nombre"],$data["search_autor"],$data["search_codigo_archivamiento"],
										$data["search_ubicacion"],$data["search_tipo_documento"])->paginate(10);
				return View::make('investigacion/documentos/listDocumentos',$data);
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
			if(($data["user"]->idrol == 1) && $id){
				$data["tipo_documentos"] = TipoDocumentoInf::lists('nombre','idtipo_documentosinf');
				$data["documento_info"] = DocumentoInf::searchDocumentoById($id)->get();
				$data["archivo"] = basename($data["documento_info"][0]->url);
				if($data["documento_info"]->isEmpty()){
					return Redirect::to('documento_investigacion/list_documentos');
				}
				$data["documento_info"] = $data["documento_info"][0];
				return View::make('investigacion/documentos/editDocumento',$data);
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
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100',
							'descripcion' => 'required|max:200',
							'autor' => 'required|max:100',
							'codigo_archivamiento' => 'required|max:100',
							'ubicacion' => 'required|max:100',	
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$iddocumento = Input::get('documento_id');
					$url = "documento_investigacion/edit_documento"."/".$iddocumento;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$data["tipo_documentos"] = TipoDocumentoInf::searchTipoDocumentosById(Input::get('idtipo_documento'))->get();
					$data["documento_info"] = DocumentoInf::searchDocumentoById(Input::get('documento_id'))->get();

					$iddocumento = Input::get('documento_id');
					$url = "documento_investigacion/edit_documento"."/".$iddocumento;
					$rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'documentos/investigacion/' . $data["tipo_documentos"][0]->nombre . '/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }
					$documento = DocumentoInf::find($iddocumento);
					$documento->nombre = Input::get('nombre');
					if (Input::hasFile('archivo')) {
						$documento->nombre_archivo = $nombreArchivo;
						$documento->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$documento->url = $rutaDestino;
					}
					$documento->descripcion = Input::get('descripcion');
					$documento->autor = Input::get('autor');
					$documento->codigo_archivamiento = Input::get('codigo_archivamiento');
					$documento->ubicacion = Input::get('ubicacion');
					$documento->idtipo_documentosinf = $data["documento_info"][0]->idtipo_documentosinf;
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

	public function download_documento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
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

	public function submit_enable_documento(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$documento_id = Input::get('documento_id');
				$url = "documento_investigacion/edit_documento"."/".$documento_id;
				$documento = DocumentoInf::withTrashed()->find($documento_id);
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
			if($data["user"]->idrol == 1){
				$documento_id = Input::get("documento_id");
				$url = "documento_investigacion/edit_documento"."/".$documento_id;
				$documento = DocumentoInf::find($documento_id);
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
}