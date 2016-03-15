<?php

class PlanAprendizajeController extends \BaseController {

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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){
				
				$data["search_nombre"] = null;
				$data["search_servicio_clinico"] = null;
				$data["search_departamento"] = null;
				$data["search_responsable"] = null;
				$data["search_fecha_ini"] = null;
				$data["search_fecha_fin"] = null;

				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$data["reportes_data"] = PlanAprendizaje::withTrashed()->paginate(10);
				
				return View::make('investigacion.proyecto.plan_aprendizaje.index',$data);
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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				$data["search_nombre"] = Input::get('search_nombre');
				$data["search_servicio_clinico"] = Input::get('search_servicio_clinico');
				$data["search_departamento"] = Input::get('search_departamento');
				$data["search_responsable"] = Input::get('search_responsable');
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');

				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$data["reportes_data"] = PlanAprendizaje::searchReporte($data['search_nombre'],$data['search_servicio_clinico'],$data['search_departamento'],$data['search_responsable'],$data["search_fecha_ini"],$data["search_fecha_fin"]);

				$data["reportes_data"] = $data["reportes_data"]->paginate(10);
				
				return View::make('investigacion.proyecto.plan_aprendizaje.index',$data);
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

				return View::make('investigacion.proyecto.plan_aprendizaje.create',$data);
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
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'id_reporte' => 'required|unique:planes_aprendizaje,id_proyecto|exists:proyectos,id',
							'nombre' => 'required',
							'categoria' => 'required',
							'departamento' => 'required',
							'responsable' => 'required',
							'servicio_clinico' => 'required',
							'plan_descripcion' => 'required',
							'objetivo' => 'required',
							'personal' => 'required',
							'competencias_requeridas' => 'required',

							'act_nombres' => 'required',
							'act_descripciones' => 'required',
							'act_servicios' => 'required',
							'act_fechas' => 'required',
							'act_duraciones' => 'required',

							'infraestructura' => 'required',
							'equipos' => 'required',
							'herramientas' => 'required',
							'insumos' => 'required',
							'equipo_personal' => 'required',
							'condiciones' => 'required',

							'competencias_generadas' => 'required',
							'indicadores' => 'required',

							'archivo' => 'required|max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);
				$messages = array(
						'act_nombres.required' => 'Las actividades deben ser llenadas correctamente',
						'competencias_generadas.required' => 'Los recursos deben ser llenados correctamente',

					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('plan_aprendizaje/create')->withErrors($validator)->withInput(Input::all());					
				}else{

					//dd(Input::all());

					$plan_aprendizaje = new PlanAprendizaje;
					$plan_aprendizaje->nombre = Input::get('nombre');
					$plan_aprendizaje->id_categoria = Input::get('categoria');
					$plan_aprendizaje->id_servicio_clinico = Input::get('servicio_clinico');
					$plan_aprendizaje->id_departamento = Input::get('departamento');
					$plan_aprendizaje->id_responsable = Input::get('responsable');
					$plan_aprendizaje->descripcion = Input::get('plan_descripcion');
					$plan_aprendizaje->personal = Input::get('personal');
					$plan_aprendizaje->objetivo = Input::get('objetivo');
					$plan_aprendizaje->competencias_requeridas = Input::get('competencias_requeridas');
					$plan_aprendizaje->infraestructura = Input::get('infraestructura');
					$plan_aprendizaje->equipos = Input::get('equipos');
					$plan_aprendizaje->herramientas = Input::get('herramientas');
					$plan_aprendizaje->insumos = Input::get('insumos');
					$plan_aprendizaje->equipo_personal = Input::get('equipo_personal');
					$plan_aprendizaje->condiciones = Input::get('condiciones');

					$rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/investigacion/plan_aprendizaje/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						$plan_aprendizaje->nombre_archivo = $nombreArchivo;
						$plan_aprendizaje->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$plan_aprendizaje->url = $rutaDestino;
					}		

					$plan_aprendizaje->id_proyecto = Input::get('id_reporte');

					$plan_aprendizaje->save();

					$nombres = Input::get('act_nombres');
					$descripciones = Input::get('act_descripciones');
					$servicios = Input::get('act_servicios');
					$fechas = Input::get('act_fechas');
					$duraciones = Input::get('act_duraciones');
					foreach($nombres as $key => $nombre){
						$plan_actividad = new PlanActividad;
						$plan_actividad->nombre = $nombre;
						$plan_actividad->descripcion = $descripciones[$key];
						$plan_actividad->servicio = $servicios[$key];
						$plan_actividad->fecha = date("Y-m-d",strtotime($fechas[$key]));
						$plan_actividad->duracion = $duraciones[$key];
						$plan_actividad->id_plan = $plan_aprendizaje->id;

						$plan_actividad->save();
					}

					$competencias_generadas = Input::get('competencias_generadas');
					$indicadores = Input::get('indicadores');
					foreach ($competencias_generadas as $key => $competencia_generada) {
						$plan_recurso = new PlanRecurso;
						$plan_recurso->competencia_generada = $competencia_generada;
						$plan_recurso->indicador = $indicadores[$key];
						$plan_recurso->id_plan = $plan_aprendizaje->id;

						$plan_recurso->save();
					}

					Session::flash('message', 'Se registró correctamente el plan de aprendizaje.');
					return Redirect::to('plan_aprendizaje/create');
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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				$data["categorias"] = ProyectoCategoria::orderBy('nombre')->get()->lists('nombre','id');
				$data["servicios"] = Servicio::orderBy('nombre')->get()->lists('nombre','idservicio');
				$data["departamentos"] = Area::orderBy('nombre')->get()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				$data["plan"] = PlanAprendizaje::withTrashed()->find($id);

				return View::make('investigacion.proyecto.plan_aprendizaje.show',$data);
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

				$data["plan"] = PlanAprendizaje::find($id);

				return View::make('investigacion.proyecto.plan_aprendizaje.edit',$data);
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
							'plan_descripcion' => 'required',
							'objetivo' => 'required',
							'personal' => 'required',
							'competencias_requeridas' => 'required',

							'infraestructura' => 'required',
							'equipos' => 'required',
							'herramientas' => 'required',
							'insumos' => 'required',
							'equipo_personal' => 'required',
							'condiciones' => 'required',

							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);
				$messages = array(
						'act_nombres.required' => 'Las actividades deben ser llenadas correctamente',
						'competencias_generadas.required' => 'Los recursos deben ser llenados correctamente',

					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('plan_aprendizaje/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					//dd(Input::all());

					$plan_aprendizaje = PlanAprendizaje::find($id);
					$plan_aprendizaje->nombre = Input::get('nombre');
					$plan_aprendizaje->id_categoria = Input::get('categoria');
					$plan_aprendizaje->id_servicio_clinico = Input::get('servicio_clinico');
					$plan_aprendizaje->id_departamento = Input::get('departamento');
					$plan_aprendizaje->id_responsable = Input::get('responsable');
					$plan_aprendizaje->descripcion = Input::get('plan_descripcion');
					$plan_aprendizaje->personal = Input::get('personal');
					$plan_aprendizaje->objetivo = Input::get('objetivo');
					$plan_aprendizaje->competencias_requeridas = Input::get('competencias_requeridas');
					$plan_aprendizaje->infraestructura = Input::get('infraestructura');
					$plan_aprendizaje->equipos = Input::get('equipos');
					$plan_aprendizaje->herramientas = Input::get('herramientas');
					$plan_aprendizaje->insumos = Input::get('insumos');
					$plan_aprendizaje->equipo_personal = Input::get('equipo_personal');
					$plan_aprendizaje->condiciones = Input::get('condiciones');

					$rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/investigacion/plan_aprendizaje/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						$plan_aprendizaje->nombre_archivo = $nombreArchivo;
						$plan_aprendizaje->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$plan_aprendizaje->url = $rutaDestino;
					}		

					$plan_aprendizaje->save();

					$nombres = Input::get('act_nombres');
					$descripciones = Input::get('act_descripciones');
					$servicios = Input::get('act_servicios');
					$fechas = Input::get('act_fechas');
					$duraciones = Input::get('act_duraciones');
					if($nombres){
						foreach($nombres as $key => $nombre){
							$plan_actividad = new PlanActividad;
							$plan_actividad->nombre = $nombre;
							$plan_actividad->descripcion = $descripciones[$key];
							$plan_actividad->servicio = $servicios[$key];
							$plan_actividad->fecha = date("Y-m-d",strtotime($fechas[$key]));
							$plan_actividad->duracion = $duraciones[$key];
							$plan_actividad->id_plan = $plan_aprendizaje->id;

							$plan_actividad->save();
						}
					}

					$competencias_generadas = Input::get('competencias_generadas');
					$indicadores = Input::get('indicadores');
					if($competencias_generadas){
						foreach ($competencias_generadas as $key => $competencia_generada) {
							$plan_recurso = new PlanRecurso;
							$plan_recurso->competencia_generada = $competencia_generada;
							$plan_recurso->indicador = $indicadores[$key];
							$plan_recurso->id_plan = $plan_aprendizaje->id;

							$plan_recurso->save();
						}
					}

					Session::flash('message', 'Se editó correctamente el plan de aprendizaje.');
					return Redirect::to('plan_aprendizaje/edit/'.$id);
				}
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
	public function editActividad($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["actividad"] = PlanActividad::find($id);

				return View::make('investigacion.proyecto.plan_aprendizaje.editActividad',$data);
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
	public function updateActividad($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'nombre' => 'required',
							'descripcion' => 'required',
							'servicio' => 'required',
							'fecha' => 'required',
							'duracion' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('plan_aprendizaje/actividad/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$plan_actividad = PlanActividad::find($id);
					$plan_actividad->nombre = Input::get('nombre');
					$plan_actividad->descripcion = Input::get('descripcion');
					$plan_actividad->servicio = Input::get('servicio');
					$plan_actividad->fecha = date('Y-m-d',strtotime(Input::get('fecha')));
					$plan_actividad->duracion = Input::get('duracion');
					
					$plan_actividad->save();
					
					Session::flash('message', 'Se modificó correctamente la actividad.');
					return Redirect::to('plan_aprendizaje/actividad/edit/'.$id);
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
	public function destroyActividad($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$actividad = PlanActividad::find($id);
				$url = "plan_aprendizaje/edit/".$actividad->id_plan;
				$actividad->delete();
				Session::flash('message','Se borro correctamente la actividad.');					
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
	public function editRecurso($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["recurso"] = PlanRecurso::find($id);

				return View::make('investigacion.proyecto.plan_aprendizaje.editRecurso',$data);
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
	public function updateRecurso($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'competencia_generada' => 'required',
							'indicador' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('plan_aprendizaje/recurso/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$plan_recurso = PlanRecurso::find($id);
					$plan_recurso->competencia_generada = Input::get('competencia_generada');
					$plan_recurso->indicador = Input::get('indicador');
					
					$plan_recurso->save();
					
					Session::flash('message', 'Se modificó correctamente la actividad.');
					return Redirect::to('plan_aprendizaje/recurso/edit/'.$id);
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
	public function destroyRecurso($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$recurso = PlanRecurso::find($id);
				$url = "plan_aprendizaje/edit/".$recurso->id_plan;
				$recurso->delete();
				Session::flash('message','Se borro correctamente el recurso.');					
				return Redirect::to($url);
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


	public function download($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){
				$plan = PlanAprendizaje::find($id);
				$rutaDestino = $plan->url.$plan->nombre_archivo_encriptado;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($plan->nombre_archivo),$headers);
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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){
				
				$plan = PlanAprendizaje::find($id);
				if(!$plan){
					Session::flash('error', 'No se encontró el plan de aprendizaje.');
					return Redirect::to('plan_aprendizaje/index');
				}
				$data["plan"] = $plan;

				$html = View::make('investigacion.proyecto.plan_aprendizaje.export',$data);
				return PDF::load($html,"A4","portrait")->download('Plan de aprendizaje - '.$data["plan"]->proyecto->codigo);
				
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}
