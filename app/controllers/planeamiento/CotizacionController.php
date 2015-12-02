<?php

class CotizacionController extends BaseController {

	public function render_create_cotizacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["nombres_equipo"] = FamiliaActivo::orderBy('nombre_equipo','asc')->lists('nombre_equipo','idfamilia_activo');
				$data["tipos_referencia"] = TipoReferencia::lists('nombre','idtipo_referencia');
				$data["proveedores"] = Proveedor::orderBy('razon_social','asc')->lists('razon_social','idproveedor');
				return View::make('cotizaciones/createCotizacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_cotizacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre_equipo' => 'required',
							'modelo_equipo' => 'required|max:100',
							'proveedor' => 'required',
							'anho' => 'required',
							'precio' => 'required',	
							'tipo_referencia' => 'required',														
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('cotizaciones/create_cotizacion')->withErrors($validator)->withInput(Input::all());
				}else{
				    $rutaDestino ='';
				    $nombreArchivo ='';	
				    if (Input::hasFile('archivo')) {
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'documentos/cotizaciones/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }


					$cotizacion = new Cotizacion;
					$cotizacion->precio = Input::get('precio');
					$cotizacion->anho = Input::get('anho');
					$cotizacion->nombre_archivo = $nombreArchivo;
					$cotizacion->nombre_archivo_encriptado = $nombreArchivoEncriptado;
					$cotizacion->anho = Input::get('anho');
					$cotizacion->idproveedor = Input::get('proveedor');
					$cotizacion->idtipo_referencia = Input::get('tipo_referencia');
					$cotizacion->codigo_cotizacion = Input::get('codigo_cotizacion');
					$cotizacion->url = $rutaDestino;
					$cotizacion->enlace_seace = Input::get('enlace_seace');
					$cotizacion->modelo_equipo = Input::get('modelo_equipo');
					$cotizacion->nombre_detallado = Input::get('nombre_detallado');
					$cotizacion->save();
					Session::flash('message', 'Se registró correctamente el cotizacion.');				
					return Redirect::to('cotizaciones/create_cotizacion');
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
			if(($data["user"]->idrol == 1) && $id){
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
			if($data["user"]->idrol == 1){
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

	public function list_cotizacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){

				$data["search_nombre_equipo"] = null;
				$data["search_nombre_detallado"] = null;
				$data["search_marca"] = null;
				$data["search_modelo"] = null;
				//$data["cotizaciones_data"] = Cotizacion::getCotizacionInfo()->paginate(10);
				$data["cotizaciones_data"] = array();
				return View::make('cotizaciones/listCotizacion',$data);
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
				$data["tipo_documentos"] = TipoDocumentos::lists('nombre','idtipo_documento');

				$data["search_nombre"] = Input::get('search_nombre');
				$data["search_autor"] = Input::get('search_autor');
				$data["search_codigo_archivamiento"] = Input::get('search_codigo_archivamiento');
				$data["search_ubicacion"] = Input::get('search_ubicacion');
				$data["search_tipo_documento"] = Input::get('search_tipo_documento');

				$data["documentos_data"] = Documento::searchDocumentos($data["search_nombre"],$data["search_autor"],$data["search_codigo_archivamiento"],
										$data["search_ubicacion"],$data["search_tipo_documento"])->paginate(10);
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
			if($data["user"]->idrol == 1){
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
			if($data["user"]->idrol == 1){
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
}