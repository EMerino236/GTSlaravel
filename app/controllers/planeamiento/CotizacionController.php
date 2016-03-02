<?php

class CotizacionController extends BaseController {

	public function render_create_cotizacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["nombres_equipo"] = FamiliaActivo::orderBy('nombre_equipo','asc')->distinct()->lists('nombre_equipo');
				$data["tipos_referencia"] = TipoReferencia::lists('nombre','idtipo_referencia');
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
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'nombre_equipo' => 'Nombre de Equipo',
							'modelo_equipo' => 'Modelo de Equipo',
							'proveedor' => 'Proveedor',
							'anho' => 'Año',
							'precio' => 'Precio',	
							'tipo_referencia' => 'Tipo de Referencia',														
							'archivo' => 'Documento adjunto',
				);

				$messages = array();

				$rules = array(
							'nombre_equipo' => 'required',
							'modelo_equipo' => 'required|max:100',
							'proveedor' => 'required',
							'anho' => 'required',
							'precio' => 'required',	
							'tipo_referencia' => 'required',														
							'archivo' => 'required|max:15360',			
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('cotizaciones/create_cotizacion')->withErrors($validator)->withInput(Input::all());
				}else{
				    $rutaDestino ='';
				    $nombreArchivo ='';	
				    if (Input::hasFile('archivo')) {
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/planeamiento/cotizaciones/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }


					$cotizacion = new Cotizacion;
					$cotizacion->nombre_equipo = Input::get('nombre_equipo_string');
					$cotizacion->marca = Input::get('marca');
					$cotizacion->precio = Input::get('precio');
					$cotizacion->anho = Input::get('anho');
					$cotizacion->nombre_archivo = $nombreArchivo;
					$cotizacion->nombre_archivo_encriptado = $nombreArchivoEncriptado;
					$cotizacion->anho = Input::get('anho');
					$cotizacion->proveedor = Input::get('proveedor');
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

	public function render_view_cotizacion($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $id){				
				$data["cotizacion_data"] = Cotizacion::find($id);
				$data["anho_actual"] = date('Y');	
				$data["cotizaciones_historico"] = Cotizacion::getCotizacionesHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["cotizacion_data"]->nombre_detallado,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				$data["referencias_seace_historico"] = Cotizacion::getReferenciasSeaceHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["cotizacion_data"]->nombre_detallado,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				if($data["cotizacion_data"]->nombre_detallado == '')
					$data["activos_precio_historico"] = FamiliaActivo::getActivosPrecioHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				else
					$data["activos_precio_historico"] = array();
				
				return View::make('cotizaciones/viewCotizacion',$data);
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
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){

				$data["search_nombre_equipo"] = null;
				$data["search_nombre_detallado"] = null;
				$data["search_marca"] = null;
				$data["search_modelo"] = null;
				$data["cotizaciones_data"] = Cotizacion::getCotizacionInfo()->paginate(10);
				//$data["cotizaciones_data"] = FamiliaActivo::getFamiliaActivosCotizacionesInfo()->get();
				//$page = Input::get('page', 1);
				//$slice = array_slice($data["cotizaciones_data"], 10 * ($page - 1), 10);
				//$data["cotizaciones_data"] = Paginator::make($slice,count($data["cotizaciones_data"]),10);
				return View::make('cotizaciones/listCotizacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_cotizacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_nombre_equipo"] = Input::get('search_nombre_equipo');
				$data["search_nombre_detallado"] = Input::get('search_nombre_detallado');;
				$data["search_marca"] = Input::get('search_marca');;
				$data["search_modelo"] = Input::get('search_modelo');;
				$data["cotizaciones_data"] = Cotizacion::searchCotizacionInfo($data["search_nombre_equipo"],
					$data["search_nombre_detallado"],$data["search_marca"],$data["search_modelo"])->paginate(10);
				/*
				$data["cotizaciones_data"] = FamiliaActivo::searchFamiliaActivosCotizacionesInfo($data["search_nombre_equipo"],
											$data["search_nombre_detallado"],$data["search_marca"],$data["search_modelo"])->get();
				$page = Input::get('page', 1);
				$slice = array_slice($data["cotizaciones_data"], 10 * ($page - 1), 10);
				$data["cotizaciones_data"] = Paginator::make($slice,count($data["cotizaciones_data"]),10);
				*/
				return View::make('cotizaciones/listCotizacion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	

	public function export_pdf(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["cotizacion_data"] = Cotizacion::find(Input::get('idcotizacion'));
				$data["anho_actual"] = date('Y');	
				$data["cotizaciones_historico"] = Cotizacion::getCotizacionesHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["cotizacion_data"]->nombre_detallado,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				$data["referencias_seace_historico"] = Cotizacion::getReferenciasSeaceHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["cotizacion_data"]->nombre_detallado,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				if($data["cotizacion_data"]->nombre_detallado == '')
					$data["activos_precio_historico"] = FamiliaActivo::getActivosPrecioHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				else
					$data["activos_precio_historico"] = array();

				$html = View::make('cotizaciones/CotizacionExport',$data);
				
				return PDF::load($html,"A4","portrait")->show();
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
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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

	public function render_view_cotizacion_adquisicion($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $id){				
				$data["cotizacion_data"] = Cotizacion::find($id);
				$data["anho_actual"] = date('Y');	
				$data["cotizaciones_historico"] = Cotizacion::getCotizacionesHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["cotizacion_data"]->nombre_detallado,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				$data["referencias_seace_historico"] = Cotizacion::getReferenciasSeaceHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["cotizacion_data"]->nombre_detallado,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				if($data["cotizacion_data"]->nombre_detallado == '')
					$data["activos_precio_historico"] = FamiliaActivo::getActivosPrecioHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				else
					$data["activos_precio_historico"] = array();
				
				return View::make('cotizaciones/viewCotizacionAdquisicion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_cotizacion_adquisicion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){

				$data["search_nombre_equipo"] = null;
				$data["search_nombre_detallado"] = null;
				$data["search_marca"] = null;
				$data["search_modelo"] = null;
				$data["cotizaciones_data"] = Cotizacion::getCotizacionInfo()->paginate(10);
				//$data["cotizaciones_data"] = FamiliaActivo::getFamiliaActivosCotizacionesInfo()->get();
				//$page = Input::get('page', 1);
				//$slice = array_slice($data["cotizaciones_data"], 10 * ($page - 1), 10);
				//$data["cotizaciones_data"] = Paginator::make($slice,count($data["cotizaciones_data"]),10);
				return View::make('cotizaciones/listCotizacionAdquisicion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_cotizacion_adquisicion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_nombre_equipo"] = Input::get('search_nombre_equipo');
				$data["search_nombre_detallado"] = Input::get('search_nombre_detallado');;
				$data["search_marca"] = Input::get('search_marca');;
				$data["search_modelo"] = Input::get('search_modelo');;
				$data["cotizaciones_data"] = Cotizacion::searchCotizacionInfo($data["search_nombre_equipo"],
					$data["search_nombre_detallado"],$data["search_marca"],$data["search_modelo"])->paginate(10);
				/*
				$data["cotizaciones_data"] = FamiliaActivo::searchFamiliaActivosCotizacionesInfo($data["search_nombre_equipo"],
											$data["search_nombre_detallado"],$data["search_marca"],$data["search_modelo"])->get();
				$page = Input::get('page', 1);
				$slice = array_slice($data["cotizaciones_data"], 10 * ($page - 1), 10);
				$data["cotizaciones_data"] = Paginator::make($slice,count($data["cotizaciones_data"]),10);
				*/
				return View::make('cotizaciones/listCotizacionAdquisicion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	

	public function export_pdf_adquisicion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["cotizacion_data"] = Cotizacion::find(Input::get('idcotizacion'));
				$data["anho_actual"] = date('Y');	
				$data["cotizaciones_historico"] = Cotizacion::getCotizacionesHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["cotizacion_data"]->nombre_detallado,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				$data["referencias_seace_historico"] = Cotizacion::getReferenciasSeaceHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["cotizacion_data"]->nombre_detallado,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				if($data["cotizacion_data"]->nombre_detallado == '')
					$data["activos_precio_historico"] = FamiliaActivo::getActivosPrecioHistorico($data["cotizacion_data"]->nombre_equipo,
									$data["anho_actual"]-5,$data["anho_actual"]-4,$data["anho_actual"]-3,$data["anho_actual"]-2,$data["anho_actual"]-1,$data["anho_actual"]);				
				else
					$data["activos_precio_historico"] = array();

				$html = View::make('cotizaciones/CotizacionExportAdquisicion',$data);
				
				return PDF::load($html,"A4","portrait")->show();
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	
}