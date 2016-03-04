<?php

class InformacionEconomicaController extends \BaseController {

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
				
				$data["proyectos_data"] = InformacionEconomica::withTrashed()->paginate(10);
				
				return View::make('investigacion.proyecto.informacion_economica.index',$data);
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
				$data["tipos"]	= [0=>'Fase de inversión',1=>'Fase de post-inversión',2=>'Ambas'];

				return View::make('investigacion.proyecto.informacion_economica.create',$data);
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
							'id_proyecto' => 'required|unique:informaciones_economicas|exists:proyectos,id',
							'nombre' => 'required',
							'categoria' => 'required',
							'departamento' => 'required',
							'responsable' => 'required',
							'servicio_clinico' => 'required',
							'fecha_ini' => 'required',
							'fecha_fin' => 'required',
							
							'rh_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'eq_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'go_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'ga_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'rh_actividades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'eq_actividades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'go_actividades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'ga_actividades_post' => 'required_if:tipo,1|required_if:tipo,2',						
						);
				$messages = array(
						'fecha_ini.required'	=> 'El campo Fecha Inicio es requerido.',
						'fecha_fin.required'	=> 'El campo Fecha Final es requerido.',
						'rh_actividades.required_if'			=> 'Se deben agregar datos de actividades RH.',
						'eq_actividades.required_if'			=> 'Se deben agregar datos de actividades de equipos.',
						'go_actividades.required_if'			=> 'Se deben agregar datos de actividades de gastos operativos.',
						'ga_actividades.required_if'			=> 'Se deben agregar datos de actividades de gastos administrativos.',
						'rh_actividades_post.required_if'			=> 'Se deben agregar datos de actividades RH en post inversión.',
						'eq_actividades_post.required_if'			=> 'Se deben agregar datos de actividades de equipos en post inversión.',
						'go_actividades_post.required_if'			=> 'Se deben agregar datos de actividades de gastos operativos en post inversión.',
						'ga_actividades_post.required_if'			=> 'Se deben agregar datos de actividades de gastos administrativos en post inversión.',
						
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('informacion_economica/create')->withErrors($validator)->withInput(Input::all());					
				}else{
					
					//dd(Input::all());
					$informacion = new InformacionEconomica;
					$informacion->nombre = Input::get('nombre');
					$informacion->id_categoria = Input::get('categoria');
					$informacion->id_servicio_clinico = Input::get('servicio_clinico');
					$informacion->id_departamento = Input::get('departamento');
					$informacion->id_responsable = Input::get('responsable');
					$informacion->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$informacion->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
					$informacion->id_proyecto = Input::get('id_proyecto');

					$informacion->save();
					
					if(Input::get('tipo') == 0 || Input::get('tipo') == 2){

						$rh_actividades = Input::get('rh_actividades');
						$rh_descripciones = Input::get('rh_descripciones');
						$rh_unidades = Input::get('rh_unidades');
						$rh_cantidades = Input::get('rh_cantidades');
						$rh_costos_unitarios = Input::get('rh_costos_unitarios');

						foreach($rh_actividades as $key => $actividad){
							$presupuesto_actividad = new InformacionEconomicaActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $rh_descripciones[$key];
							$presupuesto_actividad->unidad = $rh_unidades[$key];
							$presupuesto_actividad->cantidad = $rh_cantidades[$key];
							$presupuesto_actividad->costo_unitario = $rh_costos_unitarios[$key];
							$presupuesto_actividad->subtotal = $rh_cantidades[$key]*$rh_costos_unitarios[$key];
							$presupuesto_actividad->id_tipo = 0;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 0; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_informacion_economica = $informacion->id;

							$presupuesto_actividad->save();
						}

						$eq_actividades = Input::get('eq_actividades');
						$eq_descripciones = Input::get('eq_descripciones');
						$eq_unidades = Input::get('eq_unidades');
						$eq_cantidades = Input::get('eq_cantidades');
						$eq_costos_unitarios = Input::get('eq_costos_unitarios');

						foreach($eq_actividades as $key => $actividad){
							$presupuesto_actividad = new InformacionEconomicaActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $eq_descripciones[$key];
							$presupuesto_actividad->unidad = $eq_unidades[$key];
							$presupuesto_actividad->cantidad = $eq_cantidades[$key];
							$presupuesto_actividad->costo_unitario = $eq_costos_unitarios[$key];
							$presupuesto_actividad->subtotal = $eq_cantidades[$key]*$eq_costos_unitarios[$key];
							$presupuesto_actividad->id_tipo = 0;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 1; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_informacion_economica = $informacion->id;

							$presupuesto_actividad->save();
						}

						$go_actividades = Input::get('go_actividades');
						$go_descripciones = Input::get('go_descripciones');
						$go_unidades = Input::get('go_unidades');
						$go_cantidades = Input::get('go_cantidades');
						$go_costos_unitarios = Input::get('go_costos_unitarios');

						foreach($go_actividades as $key => $actividad){
							$presupuesto_actividad = new InformacionEconomicaActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $go_descripciones[$key];
							$presupuesto_actividad->unidad = $go_unidades[$key];
							$presupuesto_actividad->cantidad = $go_cantidades[$key];
							$presupuesto_actividad->costo_unitario = $go_costos_unitarios[$key];
							$presupuesto_actividad->subtotal = $go_cantidades[$key]*$go_costos_unitarios[$key];
							$presupuesto_actividad->id_tipo = 0;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 2; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_informacion_economica = $informacion->id;

							$presupuesto_actividad->save();
						}

						$ga_actividades = Input::get('ga_actividades');
						$ga_descripciones = Input::get('ga_descripciones');
						$ga_unidades = Input::get('ga_unidades');
						$ga_cantidades = Input::get('ga_cantidades');
						$ga_costos_unitarios = Input::get('ga_costos_unitarios');

						foreach($ga_actividades as $key => $actividad){
							$presupuesto_actividad = new InformacionEconomicaActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $ga_descripciones[$key];
							$presupuesto_actividad->unidad = $ga_unidades[$key];
							$presupuesto_actividad->cantidad = $ga_cantidades[$key];
							$presupuesto_actividad->costo_unitario = $ga_costos_unitarios[$key];
							$presupuesto_actividad->subtotal = $ga_cantidades[$key]*$ga_costos_unitarios[$key];
							$presupuesto_actividad->id_tipo = 0;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 3; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_informacion_economica = $informacion->id;

							$presupuesto_actividad->save();
						}

					}

					if(Input::get('tipo') == 1 || Input::get('tipo') == 2){

						$rh_actividades_post = Input::get('rh_actividades_post');
						$rh_descripciones_post = Input::get('rh_descripciones_post');
						$rh_unidades_post = Input::get('rh_unidades_post');
						$rh_cantidades_post = Input::get('rh_cantidades_post');
						$rh_costos_unitarios_post = Input::get('rh_costos_unitarios_post');

						foreach($rh_actividades_post as $key => $actividad){
							$presupuesto_actividad = new InformacionEconomicaActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $rh_descripciones_post[$key];
							$presupuesto_actividad->unidad = $rh_unidades_post[$key];
							$presupuesto_actividad->cantidad = $rh_cantidades_post[$key];
							$presupuesto_actividad->costo_unitario = $rh_costos_unitarios_post[$key];
							$presupuesto_actividad->subtotal = $rh_cantidades_post[$key]*$rh_costos_unitarios_post[$key];
							$presupuesto_actividad->id_tipo = 1;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 0; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_informacion_economica = $informacion->id;

							$presupuesto_actividad->save();
						}

						$eq_actividades_post = Input::get('eq_actividades_post');
						$eq_descripciones_post = Input::get('eq_descripciones_post');
						$eq_unidades_post = Input::get('eq_unidades_post');
						$eq_cantidades_post = Input::get('eq_cantidades_post');
						$eq_costos_unitarios_post = Input::get('eq_costos_unitarios_post');

						foreach($eq_actividades_post as $key => $actividad){
							$presupuesto_actividad = new InformacionEconomicaActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $eq_descripciones_post[$key];
							$presupuesto_actividad->unidad = $eq_unidades_post[$key];
							$presupuesto_actividad->cantidad = $eq_cantidades_post[$key];
							$presupuesto_actividad->costo_unitario = $eq_costos_unitarios_post[$key];
							$presupuesto_actividad->subtotal = $eq_cantidades_post[$key]*$eq_costos_unitarios_post[$key];
							$presupuesto_actividad->id_tipo = 1;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 1; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_informacion_economica = $informacion->id;

							$presupuesto_actividad->save();
						}

						$go_actividades_post = Input::get('go_actividades_post');
						$go_descripciones_post = Input::get('go_descripciones_post');
						$go_unidades_post = Input::get('go_unidades_post');
						$go_cantidades_post = Input::get('go_cantidades_post');
						$go_costos_unitarios_post = Input::get('go_costos_unitarios_post');

						foreach($go_actividades_post as $key => $actividad){
							$presupuesto_actividad = new InformacionEconomicaActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $go_descripciones_post[$key];
							$presupuesto_actividad->unidad = $go_unidades_post[$key];
							$presupuesto_actividad->cantidad = $go_cantidades_post[$key];
							$presupuesto_actividad->costo_unitario = $go_costos_unitarios_post[$key];
							$presupuesto_actividad->subtotal = $go_cantidades_post[$key]*$go_costos_unitarios_post[$key];
							$presupuesto_actividad->id_tipo = 1;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 2; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_informacion_economica = $informacion->id;

							$presupuesto_actividad->save();
						}

						$ga_actividades_post = Input::get('ga_actividades_post');
						$ga_descripciones_post = Input::get('ga_descripciones_post');
						$ga_unidades_post = Input::get('ga_unidades_post');
						$ga_cantidades_post = Input::get('ga_cantidades_post');
						$ga_costos_unitarios_post = Input::get('ga_costos_unitarios_post');

						foreach($ga_actividades_post as $key => $actividad){
							$presupuesto_actividad = new InformacionEconomicaActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $ga_descripciones_post[$key];
							$presupuesto_actividad->unidad = $ga_unidades_post[$key];
							$presupuesto_actividad->cantidad = $ga_cantidades_post[$key];
							$presupuesto_actividad->costo_unitario = $ga_costos_unitarios_post[$key];
							$presupuesto_actividad->subtotal = $ga_cantidades_post[$key]*$ga_costos_unitarios_post[$key];
							$presupuesto_actividad->id_tipo = 1;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 3; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_informacion_economica = $informacion->id;

							$presupuesto_actividad->save();
						}
					}

					Session::flash('message', 'Se registró correctamente el presupuesto.');
					return Redirect::to('informacion_economica/show/'.$informacion->id);
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

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$data["presupuesto"] = InformacionEconomica::find($id);

				return View::make('investigacion.proyecto.informacion_economica.show',$data);
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
	public function edit($id, $tipo)
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
				$data["tipos"]	= [0=>'Fase de inversión',1=>'Fase de post-inversión',2=>'Ambas'];
				$data["presupuesto"] = InformacionEconomica::find($id);
				$proyecto = $data["presupuesto"]->proyecto;
				$proyecto_presupuesto = $proyecto->presupuesto;
				$data["id_tipo"] = $tipo;
				$data['rh_inversion'] = $proyecto_presupuesto->actividadesrh->sum('subtotal');
				$data['eq_inversion'] = $proyecto_presupuesto->actividadeseq->sum('subtotal');
				$data['go_inversion'] = $proyecto_presupuesto->actividadesgo->sum('subtotal');
				$data['ga_inversion'] = $proyecto_presupuesto->actividadesga->sum('subtotal');
				$data['rh_actividades'] = $proyecto_presupuesto->actividadesrh->lists('nombre','id');
				$data['eq_actividades'] = $proyecto_presupuesto->actividadeseq->lists('nombre','id');
				$data['go_actividades'] = $proyecto_presupuesto->actividadesgo->lists('nombre','id');
				$data['ga_actividades'] = $proyecto_presupuesto->actividadesga->lists('nombre','id');

				return View::make('investigacion.proyecto.informacion_economica.edit',$data);
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
			$id_tipo = Input::get('id_tipo');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'rh_actividades' => 'required',					
							'eq_actividades' => 'required',
							'go_actividades' => 'required',
							'ga_actividades' => 'required',
						);
				$messages = array(
							'rh_actividades.required_if'	=> 'Se deben agregar datos de actividades RH.',
							'eq_actividades.required_if'	=> 'Se deben agregar datos de actividades de equipos.',
							'go_actividades.required_if'	=> 'Se deben agregar datos de actividades de gastos operativos.',
							'ga_actividades.required_if'	=> 'Se deben agregar datos de actividades de gastos administrativos.',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('informacion_economica/edit/'.$id.'/'.$id_tipo)->withErrors($validator)->withInput(Input::all());					
				}else{

					$rh_actividades = Input::get('rh_actividades');
					$rh_descripciones = Input::get('rh_descripciones');
					$rh_unidades = Input::get('rh_unidades');
					$rh_cantidades = Input::get('rh_cantidades');
					$rh_costos_unitarios = Input::get('rh_costos_unitarios');

					foreach($rh_actividades as $key => $actividad){
						$presupuesto_actividad = new InformacionEconomicaActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $rh_descripciones[$key];
						$presupuesto_actividad->unidad = $rh_unidades[$key];
						$presupuesto_actividad->cantidad = $rh_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $rh_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $rh_cantidades[$key]*$rh_costos_unitarios[$key];
						$presupuesto_actividad->id_tipo = $id_tipo;	//0 => durante, 1=> post
						$presupuesto_actividad->id_clase = 0; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_informacion_economica = $id;

						$presupuesto_actividad->save();
					}

					$eq_actividades = Input::get('eq_actividades');
					$eq_descripciones = Input::get('eq_descripciones');
					$eq_unidades = Input::get('eq_unidades');
					$eq_cantidades = Input::get('eq_cantidades');
					$eq_costos_unitarios = Input::get('eq_costos_unitarios');

					foreach($eq_actividades as $key => $actividad){
						$presupuesto_actividad = new InformacionEconomicaActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $eq_descripciones[$key];
						$presupuesto_actividad->unidad = $eq_unidades[$key];
						$presupuesto_actividad->cantidad = $eq_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $eq_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $eq_cantidades[$key]*$eq_costos_unitarios[$key];
						$presupuesto_actividad->id_tipo = $id_tipo;	//0 => durante, 1=> post
						$presupuesto_actividad->id_clase = 1; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_informacion_economica = $id;

						$presupuesto_actividad->save();
					}

					$go_actividades = Input::get('go_actividades');
					$go_descripciones = Input::get('go_descripciones');
					$go_unidades = Input::get('go_unidades');
					$go_cantidades = Input::get('go_cantidades');
					$go_costos_unitarios = Input::get('go_costos_unitarios');

					foreach($go_actividades as $key => $actividad){
						$presupuesto_actividad = new InformacionEconomicaActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $go_descripciones[$key];
						$presupuesto_actividad->unidad = $go_unidades[$key];
						$presupuesto_actividad->cantidad = $go_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $go_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $go_cantidades[$key]*$go_costos_unitarios[$key];
						$presupuesto_actividad->id_tipo = $id_tipo;	//0 => durante, 1=> post
						$presupuesto_actividad->id_clase = 2; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_informacion_economica = $id;

						$presupuesto_actividad->save();
					}

					$ga_actividades = Input::get('ga_actividades');
					$ga_descripciones = Input::get('ga_descripciones');
					$ga_unidades = Input::get('ga_unidades');
					$ga_cantidades = Input::get('ga_cantidades');
					$ga_costos_unitarios = Input::get('ga_costos_unitarios');

					foreach($ga_actividades as $key => $actividad){
						$presupuesto_actividad = new InformacionEconomicaActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $ga_descripciones[$key];
						$presupuesto_actividad->unidad = $ga_unidades[$key];
						$presupuesto_actividad->cantidad = $ga_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $ga_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $ga_cantidades[$key]*$ga_costos_unitarios[$key];
						$presupuesto_actividad->id_tipo = $id_tipo;	//0 => durante, 1=> post
						$presupuesto_actividad->id_clase = 3; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_informacion_economica = $id;

						$presupuesto_actividad->save();
					}

					Session::flash('message', 'Se editó correctamente la información económica.');
					return Redirect::to('informacion_economica/show/'.$id);
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

				if(!$proyecto){
					$mensaje = 'No se encontro el proyecto.';
					return Response::json(array( 'success' => false, 'mensaje'=>$mensaje),200);
				}

				$informacion_economica = InformacionEconomica::where('id_proyecto',$proyecto->id)->first();
				if(!$informacion_economica){
					$presupuesto = $proyecto->presupuesto;
					if($presupuesto){
						$reporte = $proyecto;
						$presupuestos['rh_inversion'] = $presupuesto->actividadesrh->sum('subtotal');
						$presupuestos['eq_inversion'] = $presupuesto->actividadeseq->sum('subtotal');
						$presupuestos['go_inversion'] = $presupuesto->actividadesgo->sum('subtotal');
						$presupuestos['ga_inversion'] = $presupuesto->actividadesga->sum('subtotal');
						$presupuestos['rh_inversion_post'] = $presupuesto->actividadesrhpost->sum('subtotal');
						$presupuestos['eq_inversion_post'] = $presupuesto->actividadeseqpost->sum('subtotal');
						$presupuestos['go_inversion_post'] = $presupuesto->actividadesgopost->sum('subtotal');
						$presupuestos['ga_inversion_post'] = $presupuesto->actividadesgapost->sum('subtotal');

						$actividades['rh_inversion'] = $presupuesto->actividadesrh;
						$actividades['eq_inversion'] = $presupuesto->actividadeseq;
						$actividades['go_inversion'] = $presupuesto->actividadesgo;
						$actividades['ga_inversion'] = $presupuesto->actividadesga;
						$actividades['rh_inversion_post'] = $presupuesto->actividadesrhpost;
						$actividades['eq_inversion_post'] = $presupuesto->actividadeseqpost;
						$actividades['go_inversion_post'] = $presupuesto->actividadesgopost;
						$actividades['ga_inversion_post'] = $presupuesto->actividadesgapost;
					}else{
						$mensaje = 'No se ha creado un presupuesto para este proyecto.';
						return Response::json(array( 'success' => false, 'mensaje'=>$mensaje),200);
					}
					
				}else{
					$reporte = [];
					
					if($informacion_economica){
						$mensaje = 'Ya existe un reporte de información económica para este proyecto.';
					}
					return Response::json(array( 'success' => false, 'mensaje'=>$mensaje),200);
				}
			}else{
				$reporte = [];
			}
			
			
			return Response::json(array( 'success' => true, 'reporte' => $reporte,'presupuestos' => $presupuestos, 'actividades' => $actividades),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}


}
