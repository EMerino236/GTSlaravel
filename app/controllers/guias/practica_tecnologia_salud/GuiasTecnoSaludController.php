<?php

class GuiasTecnoSaludController extends \BaseController {

	public function list_guias()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(	$data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12){
				
				$data["tipo_documentos"] = SubtipoDocumentoInf::where('id_tipo', 4)->orderBy('nombre','asc')->lists('nombre','id');

				$data["search_nombre"] = null;
				$data["search_autor"] = null;
				$data["search_tipo_documento"] = null;
				$data["documentos_data"] = DocumentoInf::withTrashed()->where('idtipo_documentosinf', 4)->paginate(10);
				return View::make('investigacion/guias/tecno_salud/listGuias',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_guia()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12){

				$data["tipo_documentos"] = SubtipoDocumentoInf::where('id_tipo', 4)->orderBy('nombre','asc')->lists('nombre','id');

				$data["search_nombre"] = Input::get('search_nombre');
				$data["search_autor"] = Input::get('search_autor');
				$data["search_tipo_documento"] = Input::get('search_tipo_documento');

				$data["documentos_data"] = DocumentoInf::searchDocumentos($data["search_nombre"],$data["search_autor"], null, null, 4);

				if(Input::get('search_tipo_documento') != 0){
					$data["documentos_data"] = $data["documentos_data"]->where('id_subtipo',Input::get('search_tipo_documento'));
				}

				$data["documentos_data"] = $data["documentos_data"]->paginate(10);

				return View::make('investigacion/guias/tecno_salud/listGuias',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_guia($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["programacion"] = ProgramacionGuiaTS::find($id);
				$data["tipo_documentos"] = SubtipoDocumentoInf::where('id_tipo', 4)->orderBy('nombre','asc')->lists('nombre','id');
				return View::make('investigacion/guias/tecno_salud/createGuia',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_guia()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100|unique:documentosinf',
							'descripcion' => 'required|max:200',
							'autor' => 'required|max:100',
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('guias_tecno_salud/create_guia/'.Input::get('id_programacion'))->withErrors($validator)->withInput(Input::all());
				}else{
				    $data["tipo_documentos"] = TipoDocumentoInf::searchTipoDocumentosById(4)->first();
				    $subtipo = SubtipoDocumentoInf::find(Input::get('idtipo_documento'));
				    $rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/investigacion/guias/' . $data["tipo_documentos"]->nombre . '/' . $subtipo->nombre .'/';
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
					$documento->url = $rutaDestino;
					$documento->idtipo_documentosinf = 4;
					$documento->id_subtipo = Input::get('idtipo_documento');
					$documento->id_tipo_padre = $data["tipo_documentos"]->padre->id;
					$documento->idestado = 1;
					$documento->id_programacion = Input::get('id_programacion');
					$documento->save();

					$programacion = ProgramacionGuiaTS::find(Input::get('id_programacion'));
					$programacion->id_guia = $documento->iddocumentosinf;
					if (Input::hasFile('archivo')) {
						$programacion->id_estado = 2;
					}
					$programacion->save();

					Session::flash('message', 'Se registró correctamente el Documento.');				
					return Redirect::to('guias_tecno_salud/create_guia/'.Input::get('id_programacion'));
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_guia($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $id){
				$data["tipo_documentos"] = TipoDocumentoInf::lists('nombre','idtipo_documentosinf');
				$data["documento_info"] = DocumentoInf::searchDocumentoById($id)->get();
				$data["archivo"] = basename($data["documento_info"][0]->url);
				if($data["documento_info"]->isEmpty()){
					return Redirect::to('documento_investigacion/list_documentos');
				}
				$data["documento_info"] = $data["documento_info"][0];
				return View::make('investigacion/guias/tecno_salud/editGuia',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_guia()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$iddocumento = Input::get('documento_id');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100',
							'descripcion' => 'required|max:200',
							'autor' => 'required|max:100',
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$url = "guias_tecno_salud/edit_guia"."/".$iddocumento;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$data["tipo_documentos"] = TipoDocumentoInf::searchTipoDocumentosById(4)->first();
					$subtipo = SubtipoDocumentoInf::find(Input::get('id_subtipo'));
					$data["documento_info"] = DocumentoInf::searchDocumentoById(Input::get('documento_id'))->get();

					$url = "guias_tecno_salud/edit_guia"."/".$iddocumento;
					$rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/investigacion/guias/' . $data["tipo_documentos"]->nombre . '/' . $subtipo->nombre .'/';
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
					$documento->idtipo_documentosinf = 4;
					$documento->id_subtipo = Input::get('id_subtipo');
					$documento->id_tipo_padre = $data["tipo_documentos"]->padre->id;
					$documento->idestado = 1;
					$documento->save();

					if (Input::hasFile('archivo')) {
						$programacion = ProgramacionGuiaTS::find($documento->id_programacion);
						$programacion->id_estado = 2;
						$programacion->save();
					}

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

	public function download_guia()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12){
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

	public function submit_enable_guia(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$documento_id = Input::get('documento_id');
				$url = "guias_tecno_salud/edit_guia"."/".$documento_id;
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

	public function submit_disable_guia(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$documento_id = Input::get("documento_id");
				$url = "guias_tecno_salud/edit_guia"."/".$documento_id;
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
