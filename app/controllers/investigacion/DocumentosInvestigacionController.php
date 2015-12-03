<?php

class DocumentosInvestigacionController extends \BaseController {

	public function list_documentos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				
				//PREGUNTAR DE DONDE JALO LOS NUEVOS TIPOS SOLO DE INVESTIGACION
				$data["tipo_documentos"] = TipoDocumentos::orderBy('nombre','asc')->lists('nombre','idtipo_documento');

				$data["search_nombre"] = null;
				$data["search_autor"] = null;
				$data["search_codigo_archivamiento"] = null;
				$data["search_ubicacion"] = null;
				$data["search_tipo_documento"] = null;
				$data["documentos_data"] = Documento::getDocumentosInfo()->paginate(10);
				
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

				//PREGUNTAR DE DONDE JALO LOS NUEVOS TIPOS SOLO DE INVESTIGACION
				$data["tipo_documentos"] = TipoDocumentos::orderBy('nombre','asc')->lists('nombre','idtipo_documento');
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
							'nombre' => 'required|max:100|unique:documentos',
							'descripcion' => 'required|max:200',
							'autor' => 'required|max:100',
							'codigo_archivamiento' => 'required|max:100|unique:documentos',
							'ubicacion' => 'required|max:100',	
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('documento_investigacion/create_documento')->withErrors($validator)->withInput(Input::all());
				}else{
					//PREGUNTAR DE DONDE JALO LOS NUEVOS TIPOS SOLO DE INVESTIGACION
				    $data["tipo_documentos"] = TipoDocumentos::searchTipoDocumentosById(Input::get('idtipo_documento'))->get();	
				    $rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'documentos/' . $data["tipo_documentos"][0]->nombre . '/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }

				    //PREGUNTAR SI DEBO USAR EL MISMO MODEL
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
				//PREGUNTAR DE DONDE JALO LOS NUEVOS TIPOS SOLO DE INVESTIGACION
				$data["tipo_documentos"] = TipoDocumentos::lists('nombre','idtipo_documento');

				//$data["search_nombre"] = Input::get('search_nombre');
				$data["search_autor"] = Input::get('search_autor');
				$data["search_codigo_archivamiento"] = Input::get('search_codigo_archivamiento');
				$data["search_ubicacion"] = Input::get('search_ubicacion');
				$data["search_tipo_documento"] = Input::get('search_tipo_documento');

				//HACER UNA BUSQUEDA PARA EL NUEVO MODELO
				$data["documentos_data"] = Documento::searchDocumentos($data["search_autor"],$data["search_codigo_archivamiento"],
										$data["search_ubicacion"],$data["search_tipo_documento"])->paginate(10);
				return View::make('investigacion/documentos/listDocumentos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}