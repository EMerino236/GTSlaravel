<?php

class ProyectosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				
				$data["search_nombre"] = null;
				$data["search_categoria"] = null;
				$data["search_servicio_clinico"] = null;
				$data["search_departamento"] = null;
				$data["search_responsable"] = null;
				$data["search_fecha_ini"] = null;
				$data["search_fecha_fin"] = null;

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				
				$data["reportes_data"] = Proyecto::withTrashed()->paginate(10);
				
				return View::make('investigacion.proyecto.index',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Display a listing of the searched resource.
	 *
	 * @return Response
	 */
	public function search()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["search_nombre"] = Input::get('search_nombre');
				$data["search_categoria"] = Input::get('search_categoria');
				$data["search_servicio_clinico"] = Input::get('search_servicio_clinico');
				$data["search_departamento"] = Input::get('search_departamento');
				$data["search_responsable"] = Input::get('search_responsable');
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				
				$data["reportes_data"] = Proyecto::searchReporte($data['search_nombre'],$data['search_categoria'],$data['search_servicio_clinico'],$data['search_departamento'],$data['search_responsable'],$data["search_fecha_ini"],$data["search_fecha_fin"]);
				$data["reportes_data"] = $data["reportes_data"]->paginate(10);
				
				return View::make('investigacion.proyecto.index',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["categorias"] = ProyectoCategoria::orderBy('nombre')->get()->lists('nombre','id');
				$data["servicios"] = Servicio::orderBy('nombre')->get()->lists('nombre','idservicio');
				$data["departamentos"] = Area::orderBy('nombre')->get()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');

				return View::make('investigacion.proyecto.create',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'id_reporte' => 'required',
							'nombre' => 'required',
							'categoria' => 'required',
							'departamento' => 'required',
							'responsable' => 'required',
							'servicio_clinico' => 'required',
							'fecha_ini' => 'required',
							'fecha_fin' => 'required',
							'proposito' => 'required',
							'objetivos' => 'required',
							'metodologia' => 'required',
							'requerimientos' => 'required',
							'asunciones' => 'required',
							'restricciones' => 'required',
							'riesgo_descs' => 'required',
							'riesgo_tipos' => 'required',
							'crono_descs' => 'required',
							'crono_fechas_ini' => 'required',
							'crono_fechas_fin' => 'required',
							'pre_descs' => 'required',
							'pre_montos' => 'required',
							'pers_nombres' => 'required',
							'entidades' => 'required',
							'apro_nombres' => 'required',
						);
				$messages = array(
						'fecha_ini.required' => 'El campo Fecha Inicio es requerido',
						'fecha_fin.required' => 'El campo Fecha Final es requerido',
						'riesgo_descs.required' => 'El campo descripcion de riesgos es requerido',
						'riesgo_tipos.required' => 'El campo tipos de riesgos es requerido',
						'crono_descs.required' => 'El campo descripcion de cronograma es requerido',
						'crono_fechas_ini.required' => 'El campo fechas de inicio de cronograma es requerido',
						'crono_fechas_fin.required' => 'El campo fechas de finales de cronograma es requerido',
						'pre_descs.required' => 'El campo descripcion de presupuesto es requerido',
						'pre_montos.required' => 'El campo montos de presupuesto es requerido',
						'pers_nombres.required' => 'El campo nombres de personal es requerido',
						'apro_nombres.required' => 'El campo nombres de aprobacion es requerido',
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/create')->withErrors($validator)->withInput(Input::all());					
				}else{
					$proyecto = new Proyecto;
					$proyecto->nombre = Input::get('nombre');
					$proyecto->id_categoria = Input::get('categoria');
					$proyecto->id_servicio_clinico = Input::get('servicio_clinico');
					$proyecto->id_departamento = Input::get('departamento');
					$proyecto->id_responsable = Input::get('responsable');
					$proyecto->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$proyecto->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
					$proyecto->proposito = Input::get('proposito');
					$proyecto->objetivos = Input::get('objetivos');
					$proyecto->metodologia = Input::get('metodologia');
					$proyecto->descripcion = Input::get('descripcion');
					$proyecto->id_requerimiento = Input::get('id_reporte');

					$proyecto->save();

					$proyecto->codigo = 'P-'.date('Y').'-'.$proyecto->id;

					$proyecto->save();
					
					$requerimientos = Input::get('requerimientos');
					foreach($requerimientos as $requerimiento){
						$proyecto_requerimiento = new ProyectoRequerimiento;
						$proyecto_requerimiento->descripcion = $requerimiento;
						$proyecto_requerimiento->id_proyecto = $proyecto->id;

						$proyecto_requerimiento->save();
					}

					$asunciones = Input::get('asunciones');
					foreach ($asunciones as $asuncion) {
						$proyecto_asuncion = new ProyectoAsuncion;
						$proyecto_asuncion->descripcion = $asuncion;
						$proyecto_asuncion->id_proyecto = $proyecto->id;

						$proyecto_asuncion->save();
					}

					$restricciones = Input::get('restricciones');
					foreach ($restricciones as $restriccion) {
						$proyecto_restriccion = new ProyectoRestriccion;
						$proyecto_restriccion->descripcion = $restriccion;
						$proyecto_restriccion->id_proyecto = $proyecto->id;

						$proyecto_restriccion->save();
					}

					$pers_nombres = Input::get('pers_nombres');
					foreach ($pers_nombres as $nombre) {
						$proyecto_personal = new ProyectoPersonal;
						$proyecto_personal->usuario = $nombre;
						$proyecto_personal->id_proyecto = $proyecto->id;

						$proyecto_personal->save();
					}

					$entidades = Input::get('entidades');
					foreach ($entidades as $entidad) {
						$proyecto_entidad = new ProyectoEntidad;
						$proyecto_entidad->nombre = $entidad;
						$proyecto_entidad->id_proyecto = $proyecto->id;

						$proyecto_entidad->save();
					}

					$apro_nombres = Input::get('apro_nombres');
					foreach ($apro_nombres as $nombre) {
						$proyecto_aprobacion = new ProyectoAprobacion;
						$proyecto_aprobacion->usuario = $nombre;
						$proyecto_aprobacion->id_proyecto = $proyecto->id;

						$proyecto_aprobacion->save();
					}

					$riesgo_descs =Input::get('riesgo_descs');
					$riesgo_tipos = Input::get('riesgo_tipos');
					foreach ($riesgo_descs as $key => $descripcion) {
						$proyecto_riesgo = new ProyectoRiesgo;
						$proyecto_riesgo->descripcion = $descripcion;
						$proyecto_riesgo->tipo = $riesgo_tipos[$key];
						$proyecto_riesgo->id_proyecto = $proyecto->id;

						$proyecto_riesgo->save();
					}

					$crono_descs = Input::get('crono_descs');
					$crono_fechas_ini = Input::get('crono_fechas_ini');
					$crono_fechas_fin = Input::get('crono_fechas_fin');
					foreach ($crono_descs as $key => $descripcion) {
						$proyecto_cronograma = new ProyectoCronograma;
						$proyecto_cronograma->descripcion = $descripcion;
						$proyecto_cronograma->fecha_ini = date('Y-m-d',strtotime($crono_fechas_ini[$key]));
						$proyecto_cronograma->fecha_fin = date('Y-m-d',strtotime($crono_fechas_fin[$key]));
						$proyecto_cronograma->id_proyecto = $proyecto->id;

						$proyecto_cronograma->save();
					}

					$pre_descs = Input::get('pre_descs');
					$pre_montos = Input::get('pre_montos');
					foreach ($pre_descs as $key => $descripcion) {
						$proyecto_presupuesto = new ProyectoPresupuesto;
						$proyecto_presupuesto->descripcion = $descripcion;
						$proyecto_presupuesto->monto = $pre_montos[$key];
						$proyecto_presupuesto->id_proyecto = $proyecto->id;

						$proyecto_presupuesto->save();
					}



					Session::flash('message', 'Se registró correctamente el proyecto.');
					return Redirect::to('proyecto/create');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["reporte"] = Proyecto::withTrashed()->find($id);

				return View::make('investigacion.proyecto.show',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	public function export($id){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				
				$reporte = Proyecto::find($id);
				if(!$reporte){
					Session::flash('error', 'No se encontró el proyecto.');
					return Redirect::to('proyecto/index');
				}
				$data["reporte"] = $reporte;

				$html = View::make('investigacion.proyecto.export',$data);
				return PDF::load($html,"A4","portrait")->download('Proyecto - '.$data["reporte"]->codigo);
				
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function validarProyectoAjax()
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
			$id_reporte = Input::get('id_reporte');
			$req = RequerimientoClinico::find($id_reporte);
			

			if($id_reporte!='' && $req){				
				
				$linea = ReporteDesarrollo::where('id_requerimiento',$req->id)->first();
				$proy = Proyecto::where('id_requerimiento',$req->id)->first();
				// Requerimiento Estado aprobado, que exista linea de investigacion y que no se haya hecho un proyecto antes
				if($linea && $req->estado->nombre == 'Aprobado' && !$proy){
					$reporte = $req;
				}elseif(!$linea){
					return Response::json(array( 'success' => false, 'mensaje' => 'No se encuentra una linea de investigación' ),200);
				}elseif($req->estado->nombre == 'Rechazado'){
					return Response::json(array( 'success' => false, 'mensaje' => 'El requerimiento se encuentra rechazado' ),200);
				}elseif($req->estado->nombre == 'Pendiente'){
					return Response::json(array( 'success' => false, 'mensaje' => 'El requerimiento se encuentra pendiente' ),200);
				}elseif(!$proy){
					return Response::json(array( 'success' => false, 'mensaje' => 'Ya existe un proyecto para este requerimiento clínico' ),200);
				}
			}else{
				$reporte = [];
			}
			
			
			return Response::json(array( 'success' => true, 'reporte' => $reporte),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

}
