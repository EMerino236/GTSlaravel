<?php

class DocumentoPAACController extends BaseController
{
	public function render_create_documento_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["tipo_documento"] = TipoDocumentoPAAC::lists('nombre','idtipo_documentosPAAC');
				$data["documento_paac_info"] = null;
				return View::make('documentos_PAAC/createDocumentoPAAC',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_documento_paac(){
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
							'nombre' => 'required|unique:documentospacc',
							'anho' => 'required',
							'archivo' => 'required|max:15360',											
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('documentos_PAAC/create_documento_paac')->withErrors($validator)->withInput(Input::all());					
				}else{
					if(!(Input::get('cod_reporte_cn_paac1')=='' && Input::get('cod_reporte_cn_paac2')=='' 
						&& Input::get('cod_reporte_cn_paac3')=='' && Input::get('cod_reporte_cn_paac4')==''
						&& Input::get('cod_reporte_cn_paac5')=='')){
						if(!((Input::get('cod_reporte_cn_paac1')==Input::get('cod_reporte_cn_paac2') && Input::get('cod_reporte_cn_paac1')!='')
							||(Input::get('cod_reporte_cn_paac1')==Input::get('cod_reporte_cn_paac3') && Input::get('cod_reporte_cn_paac1')!='')
							||(Input::get('cod_reporte_cn_paac1')==Input::get('cod_reporte_cn_paac4') && Input::get('cod_reporte_cn_paac1')!='')
							||(Input::get('cod_reporte_cn_paac1')==Input::get('cod_reporte_cn_paac5') && Input::get('cod_reporte_cn_paac1')!='')
							||(Input::get('cod_reporte_cn_paac2')==Input::get('cod_reporte_cn_paac3') && Input::get('cod_reporte_cn_paac2')!='')
							||(Input::get('cod_reporte_cn_paac2')==Input::get('cod_reporte_cn_paac4') && Input::get('cod_reporte_cn_paac2')!='')
							||(Input::get('cod_reporte_cn_paac2')==Input::get('cod_reporte_cn_paac5') && Input::get('cod_reporte_cn_paac2')!='')
							||(Input::get('cod_reporte_cn_paac3')==Input::get('cod_reporte_cn_paac4') && Input::get('cod_reporte_cn_paac3')!='')
							||(Input::get('cod_reporte_cn_paac3')==Input::get('cod_reporte_cn_paac5') && Input::get('cod_reporte_cn_paac3')!='')
							||(Input::get('cod_reporte_cn_paac4')==Input::get('cod_reporte_cn_paac5') && Input::get('cod_reporte_cn_paac4')!='')) ){
						    $rutaDestino ='';
						    $nombreArchivo ='';	
						    if (Input::hasFile('archivo')) {
						        $archivo = Input::file('archivo');
						        $rutaDestino = 'uploads/documentos/planeamiento/DocumentosPAAC/';
						        $nombreArchivo        = $archivo->getClientOriginalName();
						        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
						        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						    }
							$documento_paac = new DocumentoPAAC;
							$documento_paac->nombre = Input::get('nombre');	
							$documento_paac->url = $rutaDestino;
							$documento_paac->nombre_archivo = $nombreArchivo;
							$documento_paac->nombre_archivo_encriptado = $nombreArchivoEncriptado;
							$documento_paac->idtipo_documentosPAAC = Input::get('idtipo_documento');
							$documento_paac->anho = Input::get('anho');		
							if(Input::get('cod_reporte_cn_paac1')!=''){
								$documento_paac->cod_reporte_cn_paac1 = Input::get('cod_reporte_cn_paac1');
							}
							if(Input::get('cod_reporte_cn_paac2')!=''){
								$documento_paac->cod_reporte_cn_paac2 = Input::get('cod_reporte_cn_paac2');
							}
							if(Input::get('cod_reporte_cn_paac3')!=''){
								$documento_paac->cod_reporte_cn_paac3 = Input::get('cod_reporte_cn_paac3');
							}
							if(Input::get('cod_reporte_cn_paac4')!=''){
								$documento_paac->cod_reporte_cn_paac4 = Input::get('cod_reporte_cn_paac4');
							}
							if(Input::get('cod_reporte_cn_paac5')!=''){
								$documento_paac->cod_reporte_cn_paac5 = Input::get('cod_reporte_cn_paac5');
							}		
							$documento_paac->save();
							
							Session::flash('message', 'Se registró correctamente el Documento para PAAC.');
							return Redirect::to('documentos_PAAC/create_documento_paac');
						}else{
							Session::flash('error', 'Existen dos o más Reportes de Necesidad o PAAC repetidos.');
							return Redirect::to('documentos_PAAC/create_documento_paac')->withInput(Input::all());
						}
					}else{
						Session::flash('error', 'Debe ingresar al menos un Reporte de Necesidad o PAAC vinculado.');
						return Redirect::to('documentos_PAAC/create_documento_paac')->withInput(Input::all());
					}
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_documento_paac($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["tipo_documento"] = TipoDocumentoPAAC::lists('nombre','idtipo_documentosPAAC');
				$data["documento_paac_info"] = DocumentoPAAC::withTrashed()->find($id);
				return View::make('documentos_PAAC/editDocumentoPAAC',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_documento_paac(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$iddocumentosPAAC = Input::get('iddocumentosPAAC');
				// Validate the info, create rules for the inputs	
				$rules = array(
							'idtipo_documento' => 'required',
							'nombre' => 'required|unique:documentospacc,nombre,'.$iddocumentosPAAC.',iddocumentosPAAC',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$url = "documentos_PAAC/edit_documento_paac"."/".$iddocumentosPAAC;
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());					
				}else{
					if(!((Input::get('cod_reporte_cn_paac1')==Input::get('cod_reporte_cn_paac2') && Input::get('cod_reporte_cn_paac1')!='')
							||(Input::get('cod_reporte_cn_paac1')==Input::get('cod_reporte_cn_paac3') && Input::get('cod_reporte_cn_paac1')!='')
							||(Input::get('cod_reporte_cn_paac1')==Input::get('cod_reporte_cn_paac4') && Input::get('cod_reporte_cn_paac1')!='')
							||(Input::get('cod_reporte_cn_paac1')==Input::get('cod_reporte_cn_paac5') && Input::get('cod_reporte_cn_paac1')!='')
							||(Input::get('cod_reporte_cn_paac2')==Input::get('cod_reporte_cn_paac3') && Input::get('cod_reporte_cn_paac2')!='')
							||(Input::get('cod_reporte_cn_paac2')==Input::get('cod_reporte_cn_paac4') && Input::get('cod_reporte_cn_paac2')!='')
							||(Input::get('cod_reporte_cn_paac2')==Input::get('cod_reporte_cn_paac5') && Input::get('cod_reporte_cn_paac2')!='')
							||(Input::get('cod_reporte_cn_paac3')==Input::get('cod_reporte_cn_paac4') && Input::get('cod_reporte_cn_paac3')!='')
							||(Input::get('cod_reporte_cn_paac3')==Input::get('cod_reporte_cn_paac5') && Input::get('cod_reporte_cn_paac3')!='')
							||(Input::get('cod_reporte_cn_paac4')==Input::get('cod_reporte_cn_paac5') && Input::get('cod_reporte_cn_paac4')!='')) ){
						$documento_paac = DocumentoPAAC::find($iddocumentosPAAC);
						$documento_paac->nombre = Input::get('nombre');	
						$documento_paac->idtipo_documentosPAAC = Input::get('idtipo_documento');
						$documento_paac->anho = Input::get('anho');	
						if(Input::get('cod_reporte_cn_paac1')!=''){
							$documento_paac->cod_reporte_cn_paac1 = Input::get('cod_reporte_cn_paac1');
						}
						if(Input::get('cod_reporte_cn_paac2')!=''){
							$documento_paac->cod_reporte_cn_paac2 = Input::get('cod_reporte_cn_paac2');
						}
						if(Input::get('cod_reporte_cn_paac3')!=''){
							$documento_paac->cod_reporte_cn_paac3 = Input::get('cod_reporte_cn_paac3');
						}
						if(Input::get('cod_reporte_cn_paac4')!=''){
							$documento_paac->cod_reporte_cn_paac4 = Input::get('cod_reporte_cn_paac4');
						}
						if(Input::get('cod_reporte_cn_paac5')!=''){
							$documento_paac->cod_reporte_cn_paac5 = Input::get('cod_reporte_cn_paac5');
						}				
						$documento_paac->save();
						
						Session::flash('message', 'Se editó correctamente el Documento para PAAC.');
						return Redirect::to($url);
					}else{
						Session::flash('error', 'Existen dos o más Reportes de Necesidad o PAAC repetidos.');
						return Redirect::to($url)->withInput(Input::all());
					}
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_documento_paac($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["tipo_documento"] = TipoDocumentoPAAC::lists('nombre','idtipo_documentosPAAC');
				$data["documento_paac_info"] = DocumentoPAAC::withTrashed()->find($id);
				return View::make('documentos_PAAC/viewDocumentoPAAC',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_documento_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_fecha_ini"] = null;			
				$data["search_fecha_fin"] = null;	
				$data["tipo_documento"] = TipoDocumentoPAAC::lists('nombre','idtipo_documentosPAAC');
				$data["search_tipo_documento"] = null;		

				$data["documentos_paac_data"] = DocumentoPAAC::getDocumentosPAACInfo()->paginate(10);
				return View::make('documentos_PAAC/listDocumentoPAAC',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_documento_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');			
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');	
				$data["tipo_documento"] = TipoDocumentoPAAC::lists('nombre','idtipo_documentosPAAC');
				$data["search_tipo_documento"] = Input::get('search_tipo_documento');	

				$data["documentos_paac_data"] = DocumentoPAAC::searchDocumentosPAAC($data["search_fecha_ini"],$data["search_fecha_fin"],$data["search_tipo_documento"])->paginate(10);
				return View::make('documentos_PAAC/listDocumentoPAAC',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function return_reporte_cn_paac(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$abreviatura = mb_substr($data,0,2);
				$correlativo = mb_substr($data,2,4);
				$anho = mb_substr($data,7,2);
				if($abreviatura=="NS" || $abreviatura=="NI" || $abreviatura=="NP"){
					$reporte = ReporteCN::searchReporteCN_PAACByCodigoReporte($abreviatura,$correlativo,$anho);
				}else{
					$reporte = ReportePAAC::searchReporteCN_PAACByCodigoReporte($abreviatura,$correlativo,$anho);
				}
			}else{
				$reporte = null;
			}

			return Response::json(array( 'success' => true, 'reporte' => $reporte ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
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
				$reporte_paac = DocumentoPAAC::find($id);
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

	public function submit_disable_documento_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$iddocumentosPAAC = Input::get('iddocumentosPAAC');
				$url = "documentos_PAAC/edit_documento_paac/".$iddocumentosPAAC;
				$reporte_paac = DocumentoPAAC::find($iddocumentosPAAC);
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

	public function submit_enable_documento_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$iddocumentosPAAC = Input::get('iddocumentosPAAC');
				$url = "documentos_PAAC/edit_documento_paac/".$iddocumentosPAAC;
				$reporte_paac = DocumentoPAAC::withTrashed()->find($iddocumentosPAAC);
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