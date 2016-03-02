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
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
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
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
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
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["categorias"] = ProyectoCategoria::orderBy('nombre')->get()->lists('nombre','id');
				$data["servicios"] = Servicio::orderBy('nombre')->get()->lists('nombre','idservicio');
				$data["departamentos"] = Area::orderBy('nombre')->get()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');

				$data["proyecto"] = Proyecto::find($id);

				return View::make('investigacion.proyecto.edit',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
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
						);
				$messages = array(
						'fecha_ini.required' => 'El campo Fecha Inicio es requerido',
						'fecha_fin.required' => 'El campo Fecha Final es requerido',
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{
					$proyecto = Proyecto::find($id);
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

					$proyecto->save();
					
					$requerimientos = Input::get('requerimientos');
					if($requerimientos){
						foreach($requerimientos as $requerimiento){
							$proyecto_requerimiento = new ProyectoRequerimiento;
							$proyecto_requerimiento->descripcion = $requerimiento;
							$proyecto_requerimiento->id_proyecto = $proyecto->id;

							$proyecto_requerimiento->save();
						}
					}

					$asunciones = Input::get('asunciones');
					if($asunciones){
						foreach ($asunciones as $asuncion) {
							$proyecto_asuncion = new ProyectoAsuncion;
							$proyecto_asuncion->descripcion = $asuncion;
							$proyecto_asuncion->id_proyecto = $proyecto->id;

							$proyecto_asuncion->save();
						}
					}

					$restricciones = Input::get('restricciones');
					if($restricciones){
						foreach ($restricciones as $restriccion) {
							$proyecto_restriccion = new ProyectoRestriccion;
							$proyecto_restriccion->descripcion = $restriccion;
							$proyecto_restriccion->id_proyecto = $proyecto->id;

							$proyecto_restriccion->save();
						}
					}

					$pers_nombres = Input::get('pers_nombres');
					if($pers_nombres){
						foreach ($pers_nombres as $nombre) {
							$proyecto_personal = new ProyectoPersonal;
							$proyecto_personal->usuario = $nombre;
							$proyecto_personal->id_proyecto = $proyecto->id;

							$proyecto_personal->save();
						}
					}

					$entidades = Input::get('entidades');
					if($entidades){
						foreach ($entidades as $entidad) {
							$proyecto_entidad = new ProyectoEntidad;
							$proyecto_entidad->nombre = $entidad;
							$proyecto_entidad->id_proyecto = $proyecto->id;

							$proyecto_entidad->save();
						}
					}

					$apro_nombres = Input::get('apro_nombres');
					if($apro_nombres){
						foreach ($apro_nombres as $nombre) {
							$proyecto_aprobacion = new ProyectoAprobacion;
							$proyecto_aprobacion->usuario = $nombre;
							$proyecto_aprobacion->id_proyecto = $proyecto->id;

							$proyecto_aprobacion->save();
						}
					}

					$riesgo_descs =Input::get('riesgo_descs');
					$riesgo_tipos = Input::get('riesgo_tipos');
					if($riesgo_descs){
						foreach ($riesgo_descs as $key => $descripcion) {
							$proyecto_riesgo = new ProyectoRiesgo;
							$proyecto_riesgo->descripcion = $descripcion;
							$proyecto_riesgo->tipo = $riesgo_tipos[$key];
							$proyecto_riesgo->id_proyecto = $proyecto->id;

							$proyecto_riesgo->save();
						}
					}

					$crono_descs = Input::get('crono_descs');
					$crono_fechas_ini = Input::get('crono_fechas_ini');
					$crono_fechas_fin = Input::get('crono_fechas_fin');
					if($crono_descs){
						foreach ($crono_descs as $key => $descripcion) {
							$proyecto_cronograma = new ProyectoCronograma;
							$proyecto_cronograma->descripcion = $descripcion;
							$proyecto_cronograma->fecha_ini = date('Y-m-d',strtotime($crono_fechas_ini[$key]));
							$proyecto_cronograma->fecha_fin = date('Y-m-d',strtotime($crono_fechas_fin[$key]));
							$proyecto_cronograma->id_proyecto = $proyecto->id;

							$proyecto_cronograma->save();
						}
					}

					$pre_descs = Input::get('pre_descs');
					$pre_montos = Input::get('pre_montos');
					if($pre_descs){
						foreach ($pre_descs as $key => $descripcion) {
							$proyecto_presupuesto = new ProyectoPresupuesto;
							$proyecto_presupuesto->descripcion = $descripcion;
							$proyecto_presupuesto->monto = $pre_montos[$key];
							$proyecto_presupuesto->id_proyecto = $proyecto->id;

							$proyecto_presupuesto->save();
						}
					}

					Session::flash('message', 'Se editó correctamente el proyecto.');
					return Redirect::to('proyecto/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
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


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editRequerimiento($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["requerimiento"] = ProyectoRequerimiento::find($id);

				return View::make('investigacion.proyecto.editRequerimiento',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateRequerimiento($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'descripcion' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/requerimiento/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$requerimiento = ProyectoRequerimiento::find($id);
					$requerimiento->descripcion = Input::get('descripcion');
					
					$requerimiento->save();
					
					Session::flash('message', 'Se modificó correctamente el requerimiento.');
					return Redirect::to('proyecto/requerimiento/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyRequerimiento($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$requerimiento = ProyectoRequerimiento::find($id);
				$url = "proyecto/edit/".$requerimiento->id_proyecto;
				$requerimiento->delete();
				Session::flash('message','Se borro correctamente el requerimiento.');					
				return Redirect::to($url);
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
	public function editAsuncion($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["asuncion"] = ProyectoAsuncion::find($id);

				return View::make('investigacion.proyecto.editAsuncion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateAsuncion($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'descripcion' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/asuncion/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$asuncion = ProyectoAsuncion::find($id);
					$asuncion->descripcion = Input::get('descripcion');
					
					$asuncion->save();
					
					Session::flash('message', 'Se modificó correctamente la asuncion.');
					return Redirect::to('proyecto/asuncion/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyAsuncion($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$asuncion = ProyectoAsuncion::find($id);
				$url = "proyecto/edit/".$asuncion->id_proyecto;
				$asuncion->delete();
				Session::flash('message','Se borro correctamente la Asunción.');					
				return Redirect::to($url);
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
	public function editRestriccion($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["restriccion"] = ProyectoRestriccion::find($id);

				return View::make('investigacion.proyecto.editRestriccion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateRestriccion($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'descripcion' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/restriccion/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$restriccion = ProyectoRestriccion::find($id);
					$restriccion->descripcion = Input::get('descripcion');
					
					$restriccion->save();
					
					Session::flash('message', 'Se modificó correctamente la restriccion.');
					return Redirect::to('proyecto/restriccion/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyRestriccion($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$restriccion = ProyectoRestriccion::find($id);
				$url = "proyecto/edit/".$restriccion->id_proyecto;
				$restriccion->delete();
				Session::flash('message','Se borro correctamente la restriccion.');					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function editRiesgo($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["riesgo"] = ProyectoRiesgo::find($id);

				return View::make('investigacion.proyecto.editRiesgo',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function updateRiesgo($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'descripcion' => 'required',
							'tipo' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/riesgo/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$riesgo = ProyectoRiesgo::find($id);
					$riesgo->descripcion = Input::get('descripcion');
					$riesgo->tipo = Input::get('tipo');
					
					$riesgo->save();
					
					Session::flash('message', 'Se modificó correctamente el riesgo.');
					return Redirect::to('proyecto/riesgo/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function destroyRiesgo($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$riesgo = ProyectoRiesgo::find($id);
				$url = "proyecto/edit/".$riesgo->id_proyecto;
				$riesgo->delete();
				Session::flash('message','Se borro correctamente el riesgo.');					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function editCronograma($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["cronograma"] = ProyectoCronograma::find($id);

				return View::make('investigacion.proyecto.editCronograma',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function updateCronograma($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'descripcion' => 'required',
							'fecha_ini' => 'required',
							'fecha_fin' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/cronograma/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$cronograma = ProyectoCronograma::find($id);
					$cronograma->descripcion = Input::get('descripcion');
					$cronograma->fecha_ini = date('Y-m-d',strtotime(Input::get('fecha_ini')));
					$cronograma->fecha_ini = date('Y-m-d',strtotime(Input::get('fecha_ini')));
					
					$cronograma->save();
					
					Session::flash('message', 'Se modificó correctamente el cronograma.');
					return Redirect::to('proyecto/cronograma/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function destroyCronograma($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$cronograma = ProyectoCronograma::find($id);
				$url = "proyecto/edit/".$cronograma->id_proyecto;
				$cronograma->delete();
				Session::flash('message','Se borro correctamente el cronograma.');					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function editPresupuesto($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["presupuesto"] = ProyectoPresupuesto::find($id);

				return View::make('investigacion.proyecto.editPresupuesto',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function updatePresupuesto($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'descripcion' => 'required',
							'monto' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/presupuesto/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$presupuesto = ProyectoPresupuesto::find($id);
					$presupuesto->descripcion = Input::get('descripcion');
					$presupuesto->monto = Input::get('monto');
					
					$presupuesto->save();
					
					Session::flash('message', 'Se modificó correctamente el presupuesto.');
					return Redirect::to('proyecto/presupuesto/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function destroyPresupuesto($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$presupuesto = ProyectoPresupuesto::find($id);
				$url = "proyecto/edit/".$presupuesto->id_proyecto;
				$presupuesto->delete();
				Session::flash('message','Se borro correctamente el presupuesto.');					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function editPersonal($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				$data["personal"] = ProyectoPersonal::find($id);

				return View::make('investigacion.proyecto.editPersonal',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function updatePersonal($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'usuario' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/personal/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$personal = ProyectoPersonal::find($id);
					$personal->usuario = Input::get('usuario');
					
					$personal->save();
					
					Session::flash('message', 'Se modificó correctamente el personal.');
					return Redirect::to('proyecto/personal/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function destroyPersonal($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$personal = ProyectoPersonal::find($id);
				$url = "proyecto/edit/".$personal->id_proyecto;
				$personal->delete();
				Session::flash('message','Se borro correctamente el personal.');					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function editEntidad($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["entidad"] = ProyectoEntidad::find($id);

				return View::make('investigacion.proyecto.editEntidad',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function updateEntidad($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'nombre' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/entidad/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$entidad = ProyectoEntidad::find($id);
					$entidad->nombre = Input::get('nombre');
					
					$entidad->save();
					
					Session::flash('message', 'Se modificó correctamente la entidad.');
					return Redirect::to('proyecto/entidad/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function destroyEntidad($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$entidad = ProyectoEntidad::find($id);
				$url = "proyecto/edit/".$entidad->id_proyecto;
				$entidad->delete();
				Session::flash('message','Se borro correctamente la entidad.');					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


		public function editAprobacion($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				$data["aprobacion"] = ProyectoAprobacion::find($id);

				return View::make('investigacion.proyecto.editAprobacion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function updateAprobacion($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'usuario' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/aprobacion/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$aprobacion = ProyectoAprobacion::find($id);
					$aprobacion->usuario = Input::get('usuario');
					
					$aprobacion->save();
					
					Session::flash('message', 'Se modificó correctamente la aprobacion.');
					return Redirect::to('proyecto/aprobacion/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function destroyAprobacion($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$aprobacion = ProyectoAprobacion::find($id);
				$url = "proyecto/edit/".$aprobacion->id_proyecto;
				$aprobacion->delete();
				Session::flash('message','Se borro correctamente el aprobacion.');					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function export($id)
	{
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

	public function uploadCreate($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["proyecto"] = Proyecto::find($id);
				return View::make('investigacion.proyecto.upload',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function uploadStore($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$rules = array(
							'archivo' => 'required|max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto/upload/'.$id)->withErrors($validator)->withInput(Input::all());
				}else{
				    $rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/investigacion/proyecto/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }

					$proyecto = Proyecto::find($id);
					if (Input::hasFile('archivo')) {
						$proyecto->nombre_archivo = $nombreArchivo;
						$proyecto->nombre_archivo_encriptado = $nombreArchivoEncriptado;
					}
					$proyecto->url = $rutaDestino;
					$proyecto->save();
					Session::flash('message', 'Se registró correctamente el documento.');
					return Redirect::to('proyecto/show/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function download($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12){
				$proyecto = Proyecto::find($id);
				$rutaDestino = $proyecto->url.$proyecto->nombre_archivo_encriptado;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($proyecto->nombre_archivo),$headers);
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
			
			$id_reporte = Input::get('id_reporte');
			$req = RequerimientoClinico::find($id_reporte);

			if($id_reporte!='' && $req){				
				
				$linea = ReporteDesarrollo::where('id_requerimiento',$req->id)->first();
				$proy = Proyecto::where('id_requerimiento',$req->id)->first();
				$financia = ReporteFinanciamiento::find($req->id_reporte);
				// Requerimiento Estado aprobado, que exista linea de investigacion y que no se haya hecho un proyecto antes
				if($linea && ($req->estado->nombre == 'Aprobado') && !$proy){
					$reporte = $req;
					$inversion = $financia->inversiones->sum('costo');
				}elseif(!$linea){
					return Response::json(array( 'success' => false, 'mensaje' => 'No se encuentra una linea de investigación' ),200);
				}elseif($req->estado->nombre == 'Rechazado'){
					return Response::json(array( 'success' => false, 'mensaje' => 'El requerimiento se encuentra rechazado' ),200);
				}elseif($req->estado->nombre == 'Pendiente'){
					return Response::json(array( 'success' => false, 'mensaje' => 'El requerimiento se encuentra pendiente' ),200);
				}elseif($proy){
					return Response::json(array( 'success' => false, 'mensaje' => 'Ya existe un proyecto para este requerimiento clínico' ),200);
				}
			}else{
				$reporte = [];
			}
			
			
			return Response::json(array( 'success' => true, 'reporte' => $reporte,'inversion'=>$inversion),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function validarProyectoExisteAjax()
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
			
			$id_proyecto = Input::get('id_proyecto');
			
			if($id_proyecto!=''){				
				
				$proyecto = Proyecto::find($id_proyecto);

				if($proyecto){
					$reporte = $proyecto;
				}else{
					$reporte = [];
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
