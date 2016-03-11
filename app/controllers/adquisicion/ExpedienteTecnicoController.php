<?php

class ExpedienteTecnicoController extends BaseController {

	public function render_create_expediente_tecnico()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$data["tipos_adquisicion_expediente"] = TipoAdquisicionExpediente::orderBy('nombre','asc')->lists('nombre','idtipo_adquisicion_expediente');
				$data["tipos_compra_expediente"] = TipoCompraExpediente::orderBy('nombre','asc')->lists('nombre','idtipo_compra_expediente');
				$data["familia_activos"] = FamiliaActivo::getNombreEquipo()->get();
				$data["areas"] = Area::orderBy('nombre','asc')->lists('nombre','idarea');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				return View::make('expediente_tecnico/createExpedienteTecnico',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_expediente_tecnico()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'codigo_compra' => 'Código de Compra',
					'codigo_archivamiento' => 'Código de Archivamiento',
					'idtipo_adquisicion_expediente' => 'Tipo de adquisicion',
					'idtipo_compra_expediente' => 'Tipo de compra',
					'select_nombre_equipo' => 'Nombre de Equipo',
					'idarea' => 'Departamento',
					'descripcion' => 'Descripción',
					'archivo_resolucion' => 'Archivo adjunto Resolución',
					'archivo_tdr' => 'Archivo adjunto Término de referencia',
					'archivo_bases' => 'Archivo adjunto Bases',
				);

				$messages = array();

				$rules = array(	
					'codigo_compra' => 'required|unique:expediente_tecnico',
					'codigo_archivamiento' => 'required',
					'idtipo_adquisicion_expediente' => 'required',
					'idtipo_compra_expediente' => 'required',
					'select_nombre_equipo' => 'required',
					'idarea' => 'required',
					'descripcion' => 'required|max:255',
					'archivo_resolucion' => 'required|max:15360',
					'archivo_tdr' => 'max:15360',
					'archivo_bases' => 'max:15360',	
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('expediente_tecnico/create_expediente_tecnico')->withErrors($validator)->withInput(Input::all());
				}else{
					if(!(Input::get('select_nombre_equipo')==-1 && Input::get('otros_equipos')=='')){
						$rutaDestino_resolucion = '';
				        $nombre_archivo_resolucion = '';
				        $nombre_archivo_resolucion_encriptado = '';
				        $rutaDestino_tdr = '';
				        $nombre_archivo_tdr = '';
				        $nombre_archivo_tdr_encriptado = '';
				        $rutaDestino_bases = '';
				        $nombre_archivo_bases = '';
				        $nombre_archivo_bases_encriptado = '';
						if (Input::hasFile('archivo_resolucion')) {
					        $archivo_resolucion = Input::file('archivo_resolucion');
					        $rutaDestino_resolucion = 'uploads/documentos/adquisicion/resolucionExpediente/';
					        $nombre_archivo_resolucion = $archivo_resolucion->getClientOriginalName();
					        $nombre_archivo_resolucion_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo_resolucion, PATHINFO_EXTENSION);
					        $uploadSuccess = $archivo_resolucion->move($rutaDestino_resolucion, $nombre_archivo_resolucion_encriptado);
					    }

					    if (Input::hasFile('archivo_tdr')) {
					        $archivo_tdr = Input::file('archivo_tdr');
					        $rutaDestino_tdr = 'uploads/documentos/adquisicion/tdrExpediente/';
					        $nombre_archivo_tdr = $archivo_tdr->getClientOriginalName();
					        $nombre_archivo_tdr_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo_tdr, PATHINFO_EXTENSION);
					        $uploadSuccess = $archivo_tdr->move($rutaDestino_tdr, $nombre_archivo_tdr_encriptado);

					        $documento_tdr = new Documento;
							$documento_tdr->nombre = $nombre_archivo_tdr;
							$documento_tdr->autor = '';
							$documento_tdr->codigo_archivamiento = Input::get('codigo_archivamiento');
							$documento_tdr->ubicacion = '';
							$documento_tdr->idtipo_documento = 7;
							$documento_tdr->idestado = 1;
							$documento_tdr->url = $rutaDestino_tdr;
							$documento_tdr->nombre_archivo = $nombre_archivo_tdr;
							$documento_tdr->nombre_archivo_encriptado = $nombre_archivo_tdr_encriptado;
							$documento_tdr->save();
					    }

					    if (Input::hasFile('archivo_bases')) {
					        $archivo_bases = Input::file('archivo_bases');
					        $rutaDestino_bases = 'uploads/documentos/adquisicion/basesExpediente/';
					        $nombre_archivo_bases = $archivo_bases->getClientOriginalName();
					        $nombre_archivo_bases_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo_bases, PATHINFO_EXTENSION);
					        $uploadSuccess = $archivo_bases->move($rutaDestino_bases, $nombre_archivo_bases_encriptado);
					    }


				    	$expediente_tecnico = new ExpedienteTecnico;
				    	$expediente_tecnico->codigo_compra = Input::get('codigo_compra');
				    	$expediente_tecnico->codigo_archivamiento = Input::get('codigo_archivamiento');
				    	$expediente_tecnico->idtipo_adquisicion_expediente = Input::get('idtipo_adquisicion_expediente');
				    	$expediente_tecnico->idtipo_compra_expediente = Input::get('idtipo_compra_expediente');				    	
				    	if(Input::get('select_nombre_equipo')==-1){
				    		$expediente_tecnico->otros_equipos = Input::get('otros_equipos');
				    		$expediente_tecnico->nombre_equipo = '';
				    	}else{
				    		$expediente_tecnico->nombre_equipo = Input::get('nombre_equipo');
				    	}
				    	$expediente_tecnico->idarea = Input::get('idarea');
						$expediente_tecnico->idservicio = Input::get('idservicio');
				    	$expediente_tecnico->descripcion = Input::get('descripcion');
				    	$expediente_tecnico->url_resolucion = $rutaDestino_resolucion;
						$expediente_tecnico->nombre_archivo_resolucion = $nombre_archivo_resolucion;
						$expediente_tecnico->nombre_archivo_encriptado_resolucion = $nombre_archivo_resolucion_encriptado;
						$expediente_tecnico->url_tdr = $rutaDestino_tdr;
						$expediente_tecnico->nombre_archivo_tdr = $nombre_archivo_tdr;
						$expediente_tecnico->nombre_archivo_encriptado_tdr = $nombre_archivo_tdr_encriptado;
						$expediente_tecnico->url_bases = $rutaDestino_bases;
						$expediente_tecnico->nombre_archivo_bases = $nombre_archivo_bases;
						$expediente_tecnico->nombre_archivo_encriptado_bases = $nombre_archivo_bases_encriptado;
						$expediente_tecnico->idresponsable = $data["user"]->id;
						$expediente_tecnico->estado_evaluacion_ofertas_finalizada = 0;
						$expediente_tecnico->save();					
						
						Session::flash('message', 'Se registró correctamente el Expediente Técnico.');				
						return Redirect::to('expediente_tecnico/create_expediente_tecnico');
					}else{
						Session::flash('error', 'Debe especificar el Nombre de Equipo en el campo Otros Equipos.');	
						return Redirect::to('expediente_tecnico/create_expediente_tecnico')->withInput(Input::all());
					}
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_expediente_tecnico($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $id){
				$data["tipos_adquisicion_expediente"] = TipoAdquisicionExpediente::orderBy('nombre','asc')->lists('nombre','idtipo_adquisicion_expediente');
				$data["tipos_compra_expediente"] = TipoCompraExpediente::orderBy('nombre','asc')->lists('nombre','idtipo_compra_expediente');
				$data["areas"] = Area::orderBy('nombre','asc')->lists('nombre','idarea');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["expediente_tecnico_info"] = ExpedienteTecnico::searchExpedienteTecnicoByNumeroExpediente($id)->get()[0];
				$data["ofertas_expediente_data"] = OfertaExpediente::searchOfertaExpedienteByNumeroExpediente($id)->get();
				$data["ofertas_evaluada_expediente_data"] = OfertaEvaluadaExpediente::select('oferta_evaluada_expediente.*')->get();
				$data["observaciones_expediente_data"] = ObservacionExpediente::join('tipo_observacion_expediente',
														'tipo_observacion_expediente.idtipo_observacion_expediente','=',
														'observacion_expediente.idtipo_observacion_expediente')
														->select('tipo_observacion_expediente.nombre as tipo_observacion','observacion_expediente.*')->get();
				$data["presidente_data"] = User::withTrashed()->find($data["expediente_tecnico_info"]->idpresidente);
				$data["miembro1_data"] = User::withTrashed()->find($data["expediente_tecnico_info"]->idmiembro1);
				$data["miembro2_data"] = User::withTrashed()->find($data["expediente_tecnico_info"]->idmiembro2);
				$data["miembro3_data"] = User::withTrashed()->find($data["expediente_tecnico_info"]->idmiembro3);
				return View::make('expediente_tecnico/editExpedienteTecnico',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_expediente_tecnico()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'idtipo_adquisicion_expediente' => 'Tipo de adquisicion',
					'idtipo_compra_expediente' => 'Tipo de compra',
					'idarea' => 'Departamento',
					'archivo_resolucion' => 'Archivo adjunto Resolución',
					'archivo_tdr' => 'Archivo adjunto Término de referencia',
					'archivo_bases' => 'Archivo adjunto Bases',
				);

				$messages = array();

				$rules = array(	
					'idtipo_adquisicion_expediente' => 'required',
					'idtipo_compra_expediente' => 'required',
					'idarea' => 'required',	
					'archivo_resolucion' => 'max:15360',
					'archivo_tdr' => 'max:15360',
					'archivo_bases' => 'max:15360',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$url = "expediente_tecnico/edit_expediente_tecnico"."/".Input::get('idexpediente_tecnico');
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{	
					$expediente_tecnico = ExpedienteTecnico::find(Input::get('idexpediente_tecnico'));				
					if (Input::hasFile('archivo_resolucion')) {
				        $archivo_resolucion = Input::file('archivo_resolucion');
				        $rutaDestino_resolucion = 'uploads/documentos/adquisicion/resolucionExpediente/';
				        $nombre_archivo_resolucion = $archivo_resolucion->getClientOriginalName();
				        $nombre_archivo_resolucion_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo_resolucion, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo_resolucion->move($rutaDestino_resolucion, $nombre_archivo_resolucion_encriptado);
				    
					    $rutaArchivoEliminar = $expediente_tecnico->url_resolucion.$expediente_tecnico->nombre_archivo_encriptado_resolucion;
				        if(File::exists($rutaArchivoEliminar))
				            File::delete($rutaArchivoEliminar);

				        $expediente_tecnico->url_resolucion = $rutaDestino_resolucion;
						$expediente_tecnico->nombre_archivo_resolucion = $nombre_archivo_resolucion;
						$expediente_tecnico->nombre_archivo_encriptado_resolucion = $nombre_archivo_resolucion_encriptado;
				    }

				    if (Input::hasFile('archivo_tdr')) {
				        $archivo_tdr = Input::file('archivo_tdr');
				        $rutaDestino_tdr = 'uploads/documentos/adquisicion/tdrExpediente/';
				        $nombre_archivo_tdr = $archivo_tdr->getClientOriginalName();
				        $nombre_archivo_tdr_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo_tdr, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo_tdr->move($rutaDestino_tdr, $nombre_archivo_tdr_encriptado);
				    
					    $rutaArchivoEliminar = $expediente_tecnico->url_tdr.$expediente_tecnico->nombre_archivo_encriptado_tdr;
				        if(File::exists($rutaArchivoEliminar))
				            File::delete($rutaArchivoEliminar);

				        $expediente_tecnico->url_tdr = $rutaDestino_tdr;
						$expediente_tecnico->nombre_archivo_tdr = $nombre_archivo_tdr;
						$expediente_tecnico->nombre_archivo_encriptado_tdr = $nombre_archivo_tdr_encriptado;
				    }

				    if (Input::hasFile('archivo_bases')) {
				        $archivo_bases = Input::file('archivo_bases');
				        $rutaDestino_bases = 'uploads/documentos/adquisicion/basesExpediente/';
				        $nombre_archivo_bases = $archivo_bases->getClientOriginalName();
				        $nombre_archivo_bases_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo_bases, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo_bases->move($rutaDestino_bases, $nombre_archivo_bases_encriptado);
				    
					    $rutaArchivoEliminar = $expediente_tecnico->url_bases.$expediente_tecnico->nombre_archivo_encriptado_bases;
				        if(File::exists($rutaArchivoEliminar))
				            File::delete($rutaArchivoEliminar);

				        $expediente_tecnico->url_bases = $rutaDestino_bases;
						$expediente_tecnico->nombre_archivo_bases = $nombre_archivo_bases;
						$expediente_tecnico->nombre_archivo_encriptado_bases = $nombre_archivo_bases_encriptado;
				    }

			    	$expediente_tecnico->idtipo_adquisicion_expediente = Input::get('idtipo_adquisicion_expediente');
			    	$expediente_tecnico->idtipo_compra_expediente = Input::get('idtipo_compra_expediente');
			    	$expediente_tecnico->idservicio = Input::get('idservicio');
			    	$expediente_tecnico->idarea = Input::get('idarea');
					$expediente_tecnico->save();

					Session::flash('message', 'Se editó correctamente el Expediente Técnico.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_expediente_tecnicos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				$data["search_codigo_compra"] = null;	
				$data["search_fecha_ini"] = null;			
				$data["search_fecha_fin"] = null;	
				$data["search_usuario"] = null;
				$data["search_area"] = null;
				$data["search_servicio"] = null;
				$data["areas"] = Area::orderBy('nombre','asc')->lists('nombre','idarea');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["expedientes_tecnico_data"] = ExpedienteTecnico::getExpedienteTecnicoInfo()->paginate(10);				
				return View::make('expediente_tecnico/listExpedienteTecnico',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_expediente_tecnico()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_codigo_compra"] = Input::get('search_codigo_compra');	
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');			
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');
				$data["search_usuario"] = Input::get('search_usuario');			
				$data["search_area"] = Input::get('search_area');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["areas"] = Area::orderBy('nombre','asc')->lists('nombre','idarea');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["expedientes_tecnico_data"] = ExpedienteTecnico::searchExpedienteTecnico($data["search_codigo_compra"],
															$data["search_usuario"],$data["search_area"],
															$data["search_servicio"],$data["search_fecha_ini"],
															$data["search_fecha_fin"])->paginate(10);	
				return View::make('expediente_tecnico/listExpedienteTecnico',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_expediente_tecnico($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12  ) && $id){
				$data["tipos_adquisicion_expediente"] = TipoAdquisicionExpediente::orderBy('nombre','asc')->lists('nombre','idtipo_adquisicion_expediente');
				$data["tipos_compra_expediente"] = TipoCompraExpediente::orderBy('nombre','asc')->lists('nombre','idtipo_compra_expediente');
				$data["expediente_tecnico_info"] = ExpedienteTecnico::withTrashed()->find($id);
				return View::make('expediente_tecnico/viewExpedienteTecnico',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	

	public function return_num_doc_usuario(){
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
				$responsable = User::searchPersonalByNumeroDoc($data)->get();
			}else{
				$reporte = null;
			}
			return Response::json(array( 'success' => true, 'reporte' => $responsable ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function download_resolucion($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$expediente_tecnico = ExpedienteTecnico::find($id);
				$file= $expediente_tecnico->url_resolucion.$expediente_tecnico->nombre_archivo_encriptado_resolucion;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($expediente_tecnico->nombre_archivo_resolucion),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function download_tdr($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$expediente_tecnico = ExpedienteTecnico::find($id);
				$file= $expediente_tecnico->url_tdr.$expediente_tecnico->nombre_archivo_encriptado_tdr;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($expediente_tecnico->nombre_archivo_tdr),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function download_bases($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$expediente_tecnico = ExpedienteTecnico::find($id);
				$file= $expediente_tecnico->url_bases.$expediente_tecnico->nombre_archivo_encriptado_bases;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($expediente_tecnico->nombre_archivo_bases),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}