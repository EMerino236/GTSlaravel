<?php

class ProyectoPresupuestoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
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
				$data["proyecto"] = Proyecto::find($id);

				return View::make('investigacion.proyecto.presupuesto.create',$data);
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
	public function store($id)
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
							
							'rh_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'rh_descripciones' => 'required_if:tipo,0|required_if:tipo,2',
							'rh_unidades' => 'required_if:tipo,0|required_if:tipo,2',
							'rh_cantidades' => 'required_if:tipo,0|required_if:tipo,2',
							'rh_costos_unitarios' => 'required_if:tipo,0|required_if:tipo,2',
							
							'eq_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'eq_descripciones' => 'required_if:tipo,0|required_if:tipo,2',
							'eq_unidades' => 'required_if:tipo,0|required_if:tipo,2',
							'eq_cantidades' => 'required_if:tipo,0|required_if:tipo,2',
							'eq_costos_unitarios' => 'required_if:tipo,0|required_if:tipo,2',

							'go_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'go_descripciones' => 'required_if:tipo,0|required_if:tipo,2',
							'go_unidades' => 'required_if:tipo,0|required_if:tipo,2',
							'go_cantidades' => 'required_if:tipo,0|required_if:tipo,2',
							'go_costos_unitarios' => 'required_if:tipo,0|required_if:tipo,2',

							'ga_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'ga_descripciones' => 'required_if:tipo,0|required_if:tipo,2',
							'ga_unidades' => 'required_if:tipo,0|required_if:tipo,2',
							'ga_cantidades' => 'required_if:tipo,0|required_if:tipo,2',
							'ga_costos_unitarios' => 'required_if:tipo,0|required_if:tipo,2',

							'rh_actividades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'rh_descripciones_post' => 'required_if:tipo,1|required_if:tipo,2',
							'rh_unidades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'rh_cantidades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'rh_costos_unitarios_post' => 'required_if:tipo,1|required_if:tipo,2',
							
							'eq_actividades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'eq_descripciones_post' => 'required_if:tipo,1|required_if:tipo,2',
							'eq_unidades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'eq_cantidades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'eq_costos_unitarios_post' => 'required_if:tipo,1|required_if:tipo,2',

							'go_actividades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'go_descripciones_post' => 'required_if:tipo,1|required_if:tipo,2',
							'go_unidades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'go_cantidades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'go_costos_unitarios_post' => 'required_if:tipo,1|required_if:tipo,2',

							'ga_actividades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'ga_descripciones_post' => 'required_if:tipo,1|required_if:tipo,2',
							'ga_unidades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'ga_cantidades_post' => 'required_if:tipo,1|required_if:tipo,2',
							'ga_costos_unitarios_post' => 'required_if:tipo,1|required_if:tipo,2',
							
						);
				$messages = array(
						'fecha_ini.required'	=> 'El campo Fecha Inicio es requerido.',
						'fecha_fin.required'	=> 'El campo Fecha Final es requerido.',
						'required_if'			=> 'El campo :attribute es requerido en este tipo.',
						
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto_presupuesto/create/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{
					//dd(Input::all());

					$proyecto_presupuesto = new Presupuesto;
					$proyecto_presupuesto->nombre = Input::get('nombre');
					$proyecto_presupuesto->id_categoria = Input::get('categoria');
					$proyecto_presupuesto->id_servicio_clinico = Input::get('servicio_clinico');
					$proyecto_presupuesto->id_departamento = Input::get('departamento');
					$proyecto_presupuesto->id_responsable = Input::get('responsable');
					$proyecto_presupuesto->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$proyecto_presupuesto->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
					$proyecto_presupuesto->monto_restante = Input::get('total_inversion');
					$proyecto_presupuesto->id_proyecto = $id;

					$proyecto_presupuesto->save();

					$proyecto = Proyecto::find($id);
					$proyecto->id_presupuesto = $proyecto_presupuesto->id;
					$proyecto->save();
					
					if(Input::get('tipo') == 0 || Input::get('tipo') == 2){

						$rh_actividades = Input::get('rh_actividades');
						$rh_descripciones = Input::get('rh_descripciones');
						$rh_unidades = Input::get('rh_unidades');
						$rh_cantidades = Input::get('rh_cantidades');
						$rh_costos_unitarios = Input::get('rh_costos_unitarios');

						foreach($rh_actividades as $key => $actividad){
							$presupuesto_actividad = new PresupuestoActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $rh_descripciones[$key];
							$presupuesto_actividad->unidad = $rh_unidades[$key];
							$presupuesto_actividad->cantidad = $rh_cantidades[$key];
							$presupuesto_actividad->costo_unitario = $rh_costos_unitarios[$key];
							$presupuesto_actividad->subtotal = $rh_cantidades[$key]*$rh_costos_unitarios[$key];
							$presupuesto_actividad->id_tipo = 0;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 0; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_presupuesto = $proyecto_presupuesto->id;

							$presupuesto_actividad->save();
						}

						$eq_actividades = Input::get('eq_actividades');
						$eq_descripciones = Input::get('eq_descripciones');
						$eq_unidades = Input::get('eq_unidades');
						$eq_cantidades = Input::get('eq_cantidades');
						$eq_costos_unitarios = Input::get('eq_costos_unitarios');

						foreach($eq_actividades as $key => $actividad){
							$presupuesto_actividad = new PresupuestoActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $eq_descripciones[$key];
							$presupuesto_actividad->unidad = $eq_unidades[$key];
							$presupuesto_actividad->cantidad = $eq_cantidades[$key];
							$presupuesto_actividad->costo_unitario = $eq_costos_unitarios[$key];
							$presupuesto_actividad->subtotal = $eq_cantidades[$key]*$eq_costos_unitarios[$key];
							$presupuesto_actividad->id_tipo = 0;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 1; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_presupuesto = $proyecto_presupuesto->id;

							$presupuesto_actividad->save();
						}

						$go_actividades = Input::get('go_actividades');
						$go_descripciones = Input::get('go_descripciones');
						$go_unidades = Input::get('go_unidades');
						$go_cantidades = Input::get('go_cantidades');
						$go_costos_unitarios = Input::get('go_costos_unitarios');

						foreach($go_actividades as $key => $actividad){
							$presupuesto_actividad = new PresupuestoActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $go_descripciones[$key];
							$presupuesto_actividad->unidad = $go_unidades[$key];
							$presupuesto_actividad->cantidad = $go_cantidades[$key];
							$presupuesto_actividad->costo_unitario = $go_costos_unitarios[$key];
							$presupuesto_actividad->subtotal = $go_cantidades[$key]*$go_costos_unitarios[$key];
							$presupuesto_actividad->id_tipo = 0;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 2; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_presupuesto = $proyecto_presupuesto->id;

							$presupuesto_actividad->save();
						}

						$ga_actividades = Input::get('ga_actividades');
						$ga_descripciones = Input::get('ga_descripciones');
						$ga_unidades = Input::get('ga_unidades');
						$ga_cantidades = Input::get('ga_cantidades');
						$ga_costos_unitarios = Input::get('ga_costos_unitarios');

						foreach($ga_actividades as $key => $actividad){
							$presupuesto_actividad = new PresupuestoActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $ga_descripciones[$key];
							$presupuesto_actividad->unidad = $ga_unidades[$key];
							$presupuesto_actividad->cantidad = $ga_cantidades[$key];
							$presupuesto_actividad->costo_unitario = $ga_costos_unitarios[$key];
							$presupuesto_actividad->subtotal = $ga_cantidades[$key]*$ga_costos_unitarios[$key];
							$presupuesto_actividad->id_tipo = 0;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 3; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_presupuesto = $proyecto_presupuesto->id;

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
							$presupuesto_actividad = new PresupuestoActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $rh_descripciones_post[$key];
							$presupuesto_actividad->unidad = $rh_unidades_post[$key];
							$presupuesto_actividad->cantidad = $rh_cantidades_post[$key];
							$presupuesto_actividad->costo_unitario = $rh_costos_unitarios_post[$key];
							$presupuesto_actividad->subtotal = $rh_cantidades_post[$key]*$rh_costos_unitarios_post[$key];
							$presupuesto_actividad->id_tipo = 1;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 0; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_presupuesto = $proyecto_presupuesto->id;

							$presupuesto_actividad->save();
						}

						$eq_actividades_post = Input::get('eq_actividades_post');
						$eq_descripciones_post = Input::get('eq_descripciones_post');
						$eq_unidades_post = Input::get('eq_unidades_post');
						$eq_cantidades_post = Input::get('eq_cantidades_post');
						$eq_costos_unitarios_post = Input::get('eq_costos_unitarios_post');

						foreach($eq_actividades_post as $key => $actividad){
							$presupuesto_actividad = new PresupuestoActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $eq_descripciones_post[$key];
							$presupuesto_actividad->unidad = $eq_unidades_post[$key];
							$presupuesto_actividad->cantidad = $eq_cantidades_post[$key];
							$presupuesto_actividad->costo_unitario = $eq_costos_unitarios_post[$key];
							$presupuesto_actividad->subtotal = $eq_cantidades_post[$key]*$eq_costos_unitarios_post[$key];
							$presupuesto_actividad->id_tipo = 1;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 1; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_presupuesto = $proyecto_presupuesto->id;

							$presupuesto_actividad->save();
						}

						$go_actividades_post = Input::get('go_actividades_post');
						$go_descripciones_post = Input::get('go_descripciones_post');
						$go_unidades_post = Input::get('go_unidades_post');
						$go_cantidades_post = Input::get('go_cantidades_post');
						$go_costos_unitarios_post = Input::get('go_costos_unitarios_post');

						foreach($go_actividades_post as $key => $actividad){
							$presupuesto_actividad = new PresupuestoActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $go_descripciones_post[$key];
							$presupuesto_actividad->unidad = $go_unidades_post[$key];
							$presupuesto_actividad->cantidad = $go_cantidades_post[$key];
							$presupuesto_actividad->costo_unitario = $go_costos_unitarios_post[$key];
							$presupuesto_actividad->subtotal = $go_cantidades_post[$key]*$go_costos_unitarios_post[$key];
							$presupuesto_actividad->id_tipo = 1;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 2; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_presupuesto = $proyecto_presupuesto->id;

							$presupuesto_actividad->save();
						}

						$ga_actividades_post = Input::get('ga_actividades_post');
						$ga_descripciones_post = Input::get('ga_descripciones_post');
						$ga_unidades_post = Input::get('ga_unidades_post');
						$ga_cantidades_post = Input::get('ga_cantidades_post');
						$ga_costos_unitarios_post = Input::get('ga_costos_unitarios_post');

						foreach($ga_actividades_post as $key => $actividad){
							$presupuesto_actividad = new PresupuestoActividad;
							$presupuesto_actividad->nombre = $actividad;
							$presupuesto_actividad->descripcion = $ga_descripciones_post[$key];
							$presupuesto_actividad->unidad = $ga_unidades_post[$key];
							$presupuesto_actividad->cantidad = $ga_cantidades_post[$key];
							$presupuesto_actividad->costo_unitario = $ga_costos_unitarios_post[$key];
							$presupuesto_actividad->subtotal = $ga_cantidades_post[$key]*$ga_costos_unitarios_post[$key];
							$presupuesto_actividad->id_tipo = 1;	//0 => durante, 1=> post
							$presupuesto_actividad->id_clase = 3; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
							$presupuesto_actividad->id_presupuesto = $proyecto_presupuesto->id;

							$presupuesto_actividad->save();
						}
					}

					Session::flash('message', 'Se registró correctamente el presupuesto.');
					return Redirect::to('proyecto_presupuesto/show/'.$id);
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

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				
				$proyecto = Proyecto::find($id);
				$data["presupuesto"] = $proyecto->presupuesto;

				return View::make('investigacion.proyecto.presupuesto.show',$data);
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
				$data["presupuesto"] = Presupuesto::find($id);
				$data["id_tipo"] = $tipo;
				
				return View::make('investigacion.proyecto.presupuesto.edit',$data);
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
						'fecha_ini.required'	=> 'El campo Fecha Inicio es requerido.',
						'fecha_fin.required'	=> 'El campo Fecha Final es requerido.',
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto_presupuesto/edit/'.$id.'/'.$id_tipo)->withErrors($validator)->withInput(Input::all());					
				}else{

					$rh_actividades = Input::get('rh_actividades');
					$rh_descripciones = Input::get('rh_descripciones');
					$rh_unidades = Input::get('rh_unidades');
					$rh_cantidades = Input::get('rh_cantidades');
					$rh_costos_unitarios = Input::get('rh_costos_unitarios');

					foreach($rh_actividades as $key => $actividad){
						$presupuesto_actividad = new PresupuestoActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $rh_descripciones[$key];
						$presupuesto_actividad->unidad = $rh_unidades[$key];
						$presupuesto_actividad->cantidad = $rh_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $rh_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $rh_cantidades[$key]*$rh_costos_unitarios[$key];
						$presupuesto_actividad->id_tipo = $id_tipo;	//0 => durante, 1=> post
						$presupuesto_actividad->id_clase = 0; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_presupuesto = $id;

						$presupuesto_actividad->save();
					}

					$eq_actividades = Input::get('eq_actividades');
					$eq_descripciones = Input::get('eq_descripciones');
					$eq_unidades = Input::get('eq_unidades');
					$eq_cantidades = Input::get('eq_cantidades');
					$eq_costos_unitarios = Input::get('eq_costos_unitarios');

					foreach($eq_actividades as $key => $actividad){
						$presupuesto_actividad = new PresupuestoActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $eq_descripciones[$key];
						$presupuesto_actividad->unidad = $eq_unidades[$key];
						$presupuesto_actividad->cantidad = $eq_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $eq_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $eq_cantidades[$key]*$eq_costos_unitarios[$key];
						$presupuesto_actividad->id_tipo = $id_tipo;	//0 => durante, 1=> post
						$presupuesto_actividad->id_clase = 1; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_presupuesto = $id;

						$presupuesto_actividad->save();
					}

					$go_actividades = Input::get('go_actividades');
					$go_descripciones = Input::get('go_descripciones');
					$go_unidades = Input::get('go_unidades');
					$go_cantidades = Input::get('go_cantidades');
					$go_costos_unitarios = Input::get('go_costos_unitarios');

					foreach($go_actividades as $key => $actividad){
						$presupuesto_actividad = new PresupuestoActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $go_descripciones[$key];
						$presupuesto_actividad->unidad = $go_unidades[$key];
						$presupuesto_actividad->cantidad = $go_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $go_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $go_cantidades[$key]*$go_costos_unitarios[$key];
						$presupuesto_actividad->id_tipo = $id_tipo;	//0 => durante, 1=> post
						$presupuesto_actividad->id_clase = 2; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_presupuesto = $id;

						$presupuesto_actividad->save();
					}

					$ga_actividades = Input::get('ga_actividades');
					$ga_descripciones = Input::get('ga_descripciones');
					$ga_unidades = Input::get('ga_unidades');
					$ga_cantidades = Input::get('ga_cantidades');
					$ga_costos_unitarios = Input::get('ga_costos_unitarios');

					foreach($ga_actividades as $key => $actividad){
						$presupuesto_actividad = new PresupuestoActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $ga_descripciones[$key];
						$presupuesto_actividad->unidad = $ga_unidades[$key];
						$presupuesto_actividad->cantidad = $ga_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $ga_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $ga_cantidades[$key]*$ga_costos_unitarios[$key];
						$presupuesto_actividad->id_tipo = $id_tipo;	//0 => durante, 1=> post
						$presupuesto_actividad->id_clase = 3; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_presupuesto = $id;

						$presupuesto_actividad->save();
					}

					$presupuesto = Presupuesto::find($id);
					$presupuesto->monto_restante = Input::get('total_inversion');
					$presupuesto->save();

					Session::flash('message', 'Se editó correctamente el presupuesto.');
					return Redirect::to('proyecto_presupuesto/show/'.$id);
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


}
