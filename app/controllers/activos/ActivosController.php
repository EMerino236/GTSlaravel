<?php

class ActivosController extends BaseController
{
	
	public function list_activos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_grupo"] = null;
				$data["search_servicio"] = null;
				$data["search_nombre_equipo"] =null;
				$data["search_marca"] = null;
				$data["search_nombre_siga"] = null;
				$data["search_modelo"] = null;
				$data["search_serie"] = null;
				$data["search_proveedor"] = null;
				$data["search_codigo_compra"] = null;
				$data["search_codigo_patrimonial"] = null;
				$data["search_servicio"] = null;
				$data["search_ubicacion"] = null;
				$data["row_number"] = 10;

				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicio"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["ubicacion"] = UbicacionFisica::lists('nombre','idubicacion_fisica');
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');

				$data["activos_data"] = Activo::getActivosInfo()->paginate($data["row_number"]);
				return View::make('activos/listActivos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_activos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicio"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["ubicacion"] = UbicacionFisica::lists('nombre','idubicacion_fisica');

				$data["search_grupo"] = Input::get('search_grupo');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_ubicacion"] = Input::get('search_ubicacion');
				$data["search_nombre_equipo"] = Input::get('search_nombre_equipo');
				$data["search_marca"] = Input::get('search_marca');
				$data["search_modelo"] = Input::get('search_modelo');
				$data["search_nombre_siga"] = Input::get('search_nombre_siga');
				$data["search_serie"] = Input::get('search_serie');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["search_codigo_compra"] = Input::get('search_codigo_compra');
				$data["search_codigo_patrimonial"] = Input::get('search_codigo_patrimonial');
				$data["row_number"] = Input::get('row_number');			

				$data["activos_data"] = Activo::searchActivos($data["search_grupo"],$data["search_servicio"],$data["search_ubicacion"],$data["search_nombre_siga"],$data["search_nombre_equipo"],
										$data["search_marca"],$data["search_modelo"],$data["search_serie"],$data["search_proveedor"],
										$data["search_codigo_compra"],$data["search_codigo_patrimonial"])->paginate($data["row_number"]);

				return View::make('activos/listActivos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_inventario()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_grupo"] = null;
				$data["search_servicio"] = null;
				$data["search_nombre_equipo"] =null;
				$data["search_marca"] = null;				
				$data["search_modelo"] = null;				
				$data["search_proveedor"] = null;				
				$data["search_codigo_patrimonial"] = null;
				$data["search_servicio"] = null;
				$data["search_ubicacion"] = null;
				$data["search_vigencia"] = null;
				$data["fecha_adquisicion_ini"] = null;
				$data["fecha_adquisicion_fin"] = null;
				$data["row_number"] = 10;				

				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicio"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["ubicacion"] = UbicacionFisica::lists('nombre','idubicacion_fisica');
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');

				$data["activos_data"] = Activo::getInventarioInfo()->paginate($data["row_number"]);
				

				foreach ($data["activos_data"] as $value)
				{				

					$meses_garantia = $value->garantia;					
					//$inicio_garantia = Carbon\Carbon::createFromFormat('Y-m-d', $value->anho_adquisicion);
					//$fin_garantia = $inicio_garantia->addMonths($meses_garantia);
					$fin_garantia = Carbon\Carbon::createFromFormat('Y-m-d', $value->fecha_garantia_fin);

					$fecha_actual = Carbon\Carbon::now();
					
					$meses_restantes = $fin_garantia->diff($fecha_actual);					
					$value->garantia = ($meses_restantes);											
					
				}

				return View::make('activos/listActivosInventario',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_inventario()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicio"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["marca"] = Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["ubicacion"] = UbicacionFisica::lists('nombre','idubicacion_fisica');

				$data["search_grupo"] = Input::get('search_grupo');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_ubicacion"] = Input::get('search_ubicacion');
				$data["search_nombre_equipo"] = Input::get('search_nombre_equipo');
				$data["search_marca"] = Input::get('search_marca');
				$data["search_modelo"] = Input::get('search_modelo');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["search_vigencia"] = Input::get('search_vigencia');		
				$data["search_codigo_patrimonial"] = Input::get('search_codigo_patrimonial');
				$data["fecha_adquisicion_ini"] = Input::get('fecha_adquisicion_ini');
				$data["fecha_adquisicion_fin"] = Input::get('fecha_adquisicion_fin');
				$data["row_number"] = Input::get('row_number');			

				$data["activos_data"] = Activo::searchInventario($data["search_grupo"],$data["search_servicio"],$data["search_ubicacion"],$data["search_nombre_equipo"],
										$data["search_marca"],$data["search_modelo"],$data["search_proveedor"],$data["search_codigo_patrimonial"],
										$data["search_vigencia"],$data["fecha_adquisicion_ini"], $data["fecha_adquisicion_fin"])->paginate($data["row_number"]);

				foreach ($data["activos_data"] as $value)
				{
					$meses_garantia = $value->garantia;					
					//$inicio_garantia = Carbon\Carbon::createFromFormat('Y-m-d', $value->anho_adquisicion);
					//$fin_garantia = $inicio_garantia->addMonths($meses_garantia);
					$fin_garantia = Carbon\Carbon::createFromFormat('Y-m-d', $value->fecha_garantia_fin);

					$fecha_actual = Carbon\Carbon::now();
					
					$meses_restantes = $fin_garantia->diff($fecha_actual);					
					$value->garantia = ($meses_restantes);											
					
				}

				return View::make('activos/listActivosInventario',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_ire()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_departamento"] = null;
				$data["search_servicio"] = null;				
				$data["row_number"] = 10;				

				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');

				$data["servicios_data"] = Servicio::getServiciosInfo()->paginate($data["row_number"]);								

				return View::make('bienes/ire/listIre',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_ire()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				
				$data["search_departamento"] = Input::get('search_departamento');
				$data["search_servicio"] = Input::get('search_servicio');

				$data["row_number"] = Input::get('row_number');			

				$data["servicios_data"] = Servicio::searchServicios($data["search_servicio"],$data["search_departamento"])->paginate($data["row_number"]);

				return View::make('bienes/ire/listIre',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["ubicacion"] = UbicacionFisica::lists('nombre','idubicacion_fisica');		
				$data["marcas"]	= Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');			
				return View::make('activos/createActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$attributes=array(
					'servicio_clinico' => 'Servicio Clínico',
					'ubicacion_fisica' => 'Ubicación Física',
					'grupo' => 'Grupo',
					'marca' => 'Marca',
					'nombre_equipo' => 'Nombre del Equipo',
					'modelo' => 'Modelo',
					'numero_serie' => 'Número de Serie',
					'proveedor' => 'Proveedor',
					'codigo_compra' => 'Código de Compra',
					'codigo_patrimonial' => 'Código Patrimonial',
					'fecha_adquisicion' => 'Fecha de Adquisición',
					'garantia' => 'Garantía',
					'idreporte_instalacion' => 'Código de Reporte de Instalación',
					'costo' => 'Costo',
					'fecha_calibracion' => 'Fecha de Calibración',
					'fecha_proximo' => 'Próxima Fecha de Calibración',
					'input-file-0' => 'Certificado de Calibración',
					);

				$messages=array(
					);

				$rules = array(
					'servicio_clinico' => 'required',
					'ubicacion_fisica' => 'required',
					'grupo' => 'required',
					'marca' => 'required',
					'nombre_equipo' => 'required',
					'modelo' => 'required',
					'numero_serie' => 'required|alpha_dash',
					'proveedor' => 'required',
					'codigo_compra' => 'required|numeric',
					'codigo_patrimonial' => 'required|digits:12|unique:activos,codigo_patrimonial',
					'fecha_adquisicion' => 'required',
					'garantia' => 'required|numeric',
					'idreporte_instalacion' => 'required',
					'costo' => 'required|numeric',
					'fecha_calibracion' => 'required',
					'fecha_proximo' => 'required',
					'input-file-0' => 'required',
					);

				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){
					return Redirect::to('equipos/create_equipo')->withErrors($validator)->withInput(Input::all());
				}else{

					$activo = new Activo;
					$activo->codigo_patrimonial = Input::get('codigo_patrimonial');
					$activo->numero_serie = Input::get('numero_serie');
					$activo->anho_adquisicion = date('Y-m-d',strtotime(Input::get('fecha_adquisicion')));
					$activo->garantia = Input::get('garantia');
					$activo->fecha_garantia_fin = Carbon\Carbon::createFromFormat('Y-m-d',$activo->anho_adquisicion)->addMonths($activo->garantia);
					$activo->codigo_compra = Input::get('codigo_compra');
					$activo->idgrupo = Input::get('grupo');
					$activo->idmodelo_equipo = Input::get('modelo');
					$activo->idservicio = Input::get('servicio_clinico');
					$activo->idproveedor = Input::get('proveedor');
					$activo->idreporte_instalacion = Input::get('idreporte_instalacion');
					$activo->idestado = 3;
					$activo->idubicacion_fisica = Input::get('ubicacion_fisica');
					$activo->costo = Input::get('costo');
					$activo->save();

					/* Registrar reporte de calibracion */
					$reporte_calibracion = new ReporteCalibracion;
					$reporte_controller = new ReportesCalibracionController;
					$reporte_calibracion->codigo_abreviatura = "RC";
					$reporte_calibracion->codigo_correlativo = $reporte_controller->getCorrelativeReportNumber();
					$reporte_calibracion->codigo_anho = date('y');
					$reporte_calibracion->idactivo = $activo->idactivo;
					$reporte_calibracion->fecha_calibracion = date("Y-m-d",strtotime(Input::get('fecha_calibracion')));
					$reporte_calibracion->fecha_proxima_calibracion = date("Y-m-d",strtotime(Input::get('fecha_proximo')));
					$reporte_calibracion->idestado = 27;
					$reporte_calibracion->save();


					if(Input::hasFile('input-file-0')){
						$archivo            = Input::file('input-file-0');
				        $rutaDestino = 'uploads/documentos/riesgos/Reportes de Calibracion/' . $reporte_calibracion->codigo_abreviatura . $reporte_calibracion->codigo_correlativo. $reporte_calibracion->codigo_anho  . '/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						$detalle_reporte_calibracion = new DetalleReporteCalibracion;										
						$detalle_reporte_calibracion->nombre = $nombreArchivo;
						$detalle_reporte_calibracion->nombre_archivo = $nombreArchivo;
						$detalle_reporte_calibracion->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$detalle_reporte_calibracion->url = $rutaDestino;
						$detalle_reporte_calibracion->idreporte_calibracion = $reporte_calibracion->id;
						$detalle_reporte_calibracion->save();
					}
					
					return Redirect::to('equipos/list_equipos')->with('message', 'Se registró correctamente el activo.');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_activo($idequipo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $idequipo){
				$data["equipo_info"] = Activo::searchActivosById($idequipo)->get();

				if($data["equipo_info"]->isEmpty())
				{
					return Redirect::to('equipos/list_equipos');
				}

				$data["equipo_info"] = $data["equipo_info"][0];
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["ubicaciones"] = UbicacionFisica::lists('nombre','idubicacion_fisica');
				$data["nombre_equipo"] = FamiliaActivo::where('idmarca','=',$data["equipo_info"]->idmarca)->lists('nombre_equipo','idfamilia_activo');
				$data["modelo_equipo"] = ModeloActivo::where('idfamilia_activo','=',$data["equipo_info"]->idfamilia_activo)->lists('nombre','idmodelo_equipo');
				$data["reporte_instalacion"] = ReporteInstalacion::where('idreporte_instalacion','=',$data["equipo_info"]->idreporte_instalacion)->get();
				$data["reporte_instalacion"] = $data["reporte_instalacion"][0];				
				$data["reporte_calibracion"] =ReporteCalibracion::getReporteCalibracionByIdActivo($data["equipo_info"]->idactivo)->get();
				if($data["reporte_calibracion"]->isEmpty()){
					$data["reporte_calibracion"] = null;
					$data["detalles_reporte_calibracion"] = null;
				}else{
					$data["reporte_calibracion"] = $data["reporte_calibracion"][0];
					$data["detalles_reporte_calibracion"] = ReporteCalibracion::getDetalleReporteCalibracion($data["reporte_calibracion"]->id)->get();
				}
				
				$data["marcas"]	= Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				return View::make('activos/editActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_activo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$attributes=array(
					'servicio_clinico' => 'Servicio Clínico',
					'ubicacion_fisica' => 'Ubicación Física',
					'grupo' => 'Grupo',
					'marca' => 'Marca',
					'nombre_equipo' => 'Nombre del Equipo',
					'modelo' => 'Modelo',
					'numero_serie' => 'Número de Serie',
					'proveedor' => 'Proveedor',
					'codigo_compra' => 'Código de Compra',
					'codigo_patrimonial' => 'Código Patrimonial',
					'fecha_adquisicion' => 'Fecha de Adquisición',
					'garantia' => 'Garantía',
					'idreporte_instalacion' => 'Código de Reporte de Instalación',
					'costo' => 'Costo'
					);

				$messages=array(
					);

				$rules = array(
					'servicio_clinico' => 'required',
					'ubicacion_fisica' => 'required',
					'grupo' => 'required',					
					'numero_serie' => 'required',
					'proveedor' => 'required',										
					'fecha_adquisicion' => 'required',
					'garantia' => 'required',					
					'costo' => 'required|numeric'
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$equipo_id = Input::get('equipo_id');
					$url = "equipos/edit_equipo"."/".$equipo_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$equipo_id = Input::get('equipo_id');
					//$url = "equipos/edit_equipo"."/".$equipo_id;
					$activo = Activo::find($equipo_id);
					
					$activo->numero_serie = Input::get('numero_serie');
					$activo->anho_adquisicion = date('Y-m-d',strtotime(Input::get('fecha_adquisicion')));
					$activo->garantia = Input::get('garantia');
					$activo->fecha_garantia_fin = Carbon\Carbon::createFromFormat('Y-m-d',$activo->anho_adquisicion)->addMonths($activo->garantia);					
					$activo->idgrupo = Input::get('grupo');					
					$activo->idservicio = Input::get('servicio_clinico');
					$activo->idproveedor = Input::get('proveedor');
					$activo->idestado = 1;
					$activo->idubicacion_fisica = Input::get('ubicacion_fisica');
					$activo->costo = Input::get('costo');

					$activo->save();
					
					return Redirect::to('equipos/list_equipos')->with('message', 'Se editó correctamente el equipo.');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_soporte_tecnico_equipo($idequipo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if(($data["user"]->idrol == 1) && $idequipo){
				$data["equipo_info"] = Activo::searchActivosById($idequipo)->get();
				$data["tipo_documento_identidad"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["soporte_tecnico_info"] = SoporteTecnicoxActivo::searchSoporteTecnicoByActivo($idequipo)->get();				
				
				$data["search_tipo_documento_activo"] = null;
				$data["search_numero_documento_soporte_tecnico_activo"] = null;

				if($data["equipo_info"]->isEmpty()){

					return Redirect::to('equipos/list_equipos');
				}

				$data["equipo_info"] = $data["equipo_info"][0];
				
				
				return View::make('soporte_tecnico/createSoporteTecnicoActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_soporte_tecnico_equipo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				
				$attributes = array(
					'idsoporte_tecnico' => 'Soporte Técnico'
				);

				$messages = array(
			    	'idsoporte_tecnico.required' => 'Debe agregar un :attribute existente.',
				);

				$rules = array(					
					'idsoporte_tecnico' => 'required'
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$idequipo = Input::get('idactivo');
					$url = "equipos/create_soporte_tecnico_equipo"."/".$idequipo;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$idequipo = Input::get('idactivo');
					$url = "equipos/create_soporte_tecnico_equipo"."/".$idequipo;

					$soporte_tecnico_activo = new SoporteTecnicoxActivo;
					$soporte_tecnico_activo->idsoporte_tecnico = Input::get('idsoporte_tecnico');
					$soporte_tecnico_activo->idactivo = $idequipo;

					$soporte_tecnico_activo->idestado = 1;					

					$soporte_tecnico_activo->save();
					
					return Redirect::to($url)->with('message', 'Se agregó correctamente el soporte técnico.');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_activo($idequipo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $idequipo){
				$data["equipo_info"] = Activo::searchActivosById($idequipo)->get();
				if($data["equipo_info"]->isEmpty()){
					return Redirect::to('equipos/list_equipos');
				}
				$data["equipo_info"] = $data["equipo_info"][0];
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["ubicaciones"] = UbicacionFisica::lists('nombre','idubicacion_fisica');
				$data["nombre_equipo"] = FamiliaActivo::where('idmarca','=',$data["equipo_info"]->idmarca)->lists('nombre_equipo','idfamilia_activo');
				$data["modelo_equipo"] = ModeloActivo::where('idfamilia_activo','=',$data["equipo_info"]->idfamilia_activo)->lists('nombre','idmodelo_equipo');
				$data["reporte_instalacion"] = ReporteInstalacion::where('idreporte_instalacion','=',$data["equipo_info"]->idreporte_instalacion)->get();
				$data["reporte_instalacion"] = $data["reporte_instalacion"][0];

				$data["documentos"]=[];
				$data["documento_contrato"]= Documento::searchDocumentoContratoByIdReporteInstalacion($data["reporte_instalacion"]->idreporte_instalacion)->get();
				$data["documento_certificado_func"]= Documento::searchDocumentoCertificadoFuncionalidadByIdReporteInstalacion($data["reporte_instalacion"]->idreporte_instalacion)->get();
				$data["documento_manual"]= Documento::searchDocumentoManualByIdReporteInstalacion($data["reporte_instalacion"]->idreporte_instalacion)->get();
				$data["documento_trd"]= Documento::searchDocumentoTdRByIdReporteInstalacion($data["reporte_instalacion"]->idreporte_instalacion)->get();
				
				if(!$data["documento_contrato"]->isEmpty())
					array_push($data["documentos"],$data["documento_contrato"][0]);

				if(!$data["documento_certificado_func"]->isEmpty())
					array_push($data["documentos"],$data["documento_certificado_func"][0]);

				if(!$data["documento_manual"]->isEmpty())
					array_push($data["documentos"],$data["documento_manual"][0]);

				if(!$data["documento_trd"]->isEmpty())
					array_push($data["documentos"],$data["documento_trd"][0]);
				
				
				$data["soporte_tecnico_info"] = SoporteTecnicoxActivo::searchSoporteTecnicoByActivo($idequipo)->get();

				$data["accesorios_info"] = Accesorio::getAccesorioByModelo($data["equipo_info"]->idmodelo_equipo)->get();
				$data["consumibles_info"] = Consumible::getConsumibleByModelo($data["equipo_info"]->idmodelo_equipo)->get();				
				$data["componentes_info"] = Componente::getComponenteByModelo($data["equipo_info"]->idmodelo_equipo)->get();				
				
				$data["marcas"]	= Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');

				$data["reporte_calibracion"] =ReporteCalibracion::getReporteCalibracionByIdActivo($data["equipo_info"]->idactivo)->get();

				if($data["reporte_calibracion"]->isEmpty()){

					$data["reporte_calibracion"] = null;
					$data["detalles_reporte_calibracion"] = null;
				}else{
					$data["reporte_calibracion"] = $data["reporte_calibracion"][0];
					$data["detalles_reporte_calibracion"] = ReporteCalibracion::getDetalleReporteCalibracion($data["reporte_calibracion"]->id)->get();
				}
				return View::make('activos/viewActivo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_activo_inventario($idequipo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $idequipo){
				$data["equipo_info"] = Activo::searchActivosById($idequipo)->get();
				if($data["equipo_info"]->isEmpty()){
					return Redirect::to('equipos/list_equipos');
				}
				$data["equipo_info"] = $data["equipo_info"][0];
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["ubicaciones"] = UbicacionFisica::lists('nombre','idubicacion_fisica');
				$data["nombre_equipo"] = FamiliaActivo::where('idmarca','=',$data["equipo_info"]->idmarca)->lists('nombre_equipo','idfamilia_activo');
				$data["modelo_equipo"] = ModeloActivo::where('idfamilia_activo','=',$data["equipo_info"]->idfamilia_activo)->lists('nombre','idmodelo_equipo');
				$data["reporte_instalacion"] = ReporteInstalacion::where('idreporte_instalacion','=',$data["equipo_info"]->idreporte_instalacion)->get();
				$data["reporte_instalacion"] = $data["reporte_instalacion"][0];

				$data["soporte_tecnico_info"] = SoporteTecnicoxActivo::searchSoporteTecnicoByActivo($idequipo)->get();

				$data["accesorios_info"] = Accesorio::getAccesorioByModelo($data["equipo_info"]->idmodelo_equipo)->get();
				$data["consumibles_info"] = Consumible::getConsumibleByModelo($data["equipo_info"]->idmodelo_equipo)->get();				
				$data["componentes_info"] = Componente::getComponenteByModelo($data["equipo_info"]->idmodelo_equipo)->get();				
				
				$data["marcas"]	= Marca::lists('nombre','idmarca');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');

				$data["reporte_calibracion"] =ReporteCalibracion::getReporteCalibracionByIdActivo($data["equipo_info"]->idactivo)->get();

				if($data["reporte_calibracion"]->isEmpty()){

					$data["reporte_calibracion"] = null;
					$data["detalles_reporte_calibracion"] = null;
				}else{
					$data["reporte_calibracion"] = $data["reporte_calibracion"][0];
					$data["detalles_reporte_calibracion"] = ReporteCalibracion::getDetalleReporteCalibracion($data["reporte_calibracion"]->id)->get();
				}
				return View::make('activos/viewActivoInventario',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_activo_ire($idactivo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $idactivo){
				
				$data["equipo_info"] = Activo::find($idactivo);

				if($data["equipo_info"] == null)
				{
					return Redirect::to('estado_ts/list_ire');
				}				
				
				return View::make('bienes/ire/editIre',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_activo_ire()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$attributes=array(
					'fe' => 'Funciol del Equipo',
					'ac' => 'Aplicación Clínica',
					'rm' => 'Requerimiento de Mantenimiento',
					'hie' => 'Historial de Incidentes del Equipo',					
					);

				$messages=array(
					);

				$rules = array(
					'fe' => 'required|integer',
					'ac' => 'required|integer',
					'rm' => 'required|integer',
					'hie' => 'required|integer'
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$equipo_id = Input::get('idequipo');
					$url = "estado_ts/edit_ire_activo/"."/".$equipo_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					
					$equipo_id = Input::get('idequipo');
					
					$activo = Activo::find($equipo_id);
					$fe = Input::get('fe');
					$ac = Input::get('ac');
					$rm = Input::get('rm');
					$hie = Input::get('hie');

					$activo->fe = $fe;
					$activo->ac = $ac;
					$activo->rm = $rm;
					$activo->hie = $hie;	
					
					$activo->ge = $fe + $ac + $rm + $hie;

					$activo->save();
					
					$url = "estado_ts/view_ire_servicio"."/".$activo->idservicio;
					return Redirect::to($url)->with('message', 'Se editó correctamente el equipo.');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_servicio_ire($idservicio=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $idservicio){
				
				$data["equipo_info"] = Activo::getActivosByServicioId($idservicio)->paginate(10);
				
				if($data["equipo_info"]->isEmpty())
				{
					return Redirect::to('estado_ts/list_ire');
				
				}
				
				$data["servicio_info"] = Servicio::find($idservicio);
				
				return View::make('bienes/ire/viewIre',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_ubicacion_ajax()
	{

		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');			
			if($data !=0){
				$ubicacion = UbicacionFisica::searchUbicacionByServicio($data)->get();
			}else{
				$ubicacion = array();
			}

			return Response::json(array( 'success' => true, 'ubicacion' => $ubicacion ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_nombre_equipo_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');			
			if($data !=0){
				$familia_activo = FamiliaActivo::searchFAmiliaActivoByMarca($data)->get();
			}else{
				$familia_activo = array();
			}

			return Response::json(array( 'success' => true, 'nombre_equipo' => $familia_activo ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_modelo_equipo_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');			
			if($data !=0){
				$modelo_equipo = ModeloActivo::getModeloByFamiliaActivo($data)->get();
			}else{
				$modelo_equipo = array();
			}

			return Response::json(array( 'success' => true, 'modelo_equipo' => $modelo_equipo ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function validate_numero_reporte_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('numero_reporte');
			
			$abreviatura = mb_substr($data,0,2);
			$correlativo = mb_substr($data,2,4);
			$anho = mb_substr($data,7,2);
			$reporte = ReporteInstalacion::searchReporteInstalacionByNumeroReporte($abreviatura,$correlativo,$anho)->get();

			return Response::json(array( 'success' => true,'data' => $reporte),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_soporte_tecnico_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			console.log('AQUI LLEGO');
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$idtipo_documento = Input::get('idtipo_documento');
			$numero_documento_identidad = Input::get('numero_documento_identidad');
					
			$soporte_tecnico = SoporteTecnico::searchSoporteTecnicoByNumeroDocumento($idtipo_documento,$numero_documento_identidad)->get();
			
			return Response::json(array( 'success' => true,'data' => $soporte_tecnico),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_delete_soporte_tecnico_equipo_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)
			{				
				$idsoporte_tecnico_activo = Input::get('idsoporte_tecnico');				
				$soporte_tecnico_activo = SoporteTecnicoxActivo::find($idsoporte_tecnico_activo);
				$soporte_tecnico_activo->delete();
				
				Session::flash('message', 'Se eliminó correctamente el soporte técnico.');
				return Response::json(array( 'success' => true),200);				
			}
			else{
				return Response::json(array( 'success' => false),200);				
			}		
		}
	}
	
}