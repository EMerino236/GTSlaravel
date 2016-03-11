<?php

class PresupuestoCapacitacionController extends \BaseController {

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
				$data["search_tipo"] = null;
				$data["search_modalidad"] = null;
				$data["search_servicio_clinico"] = null;
				$data["search_departamento"] = null;
				$data["search_responsable"] = null;

				$data["tipos"] = RHTipo::all()->lists('nombre','id');
				$data["modalidades"] = RHModalidad::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				//WIP DEBE SER PRESUPUESTO CAPACITACION
				$data["proyectos_data"] = PresupuestoCapacitacion::withTrashed()->paginate(10);
				
				return View::make('rrhh.presupuesto_capacitacion.index',$data);
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

				$data["tipos"] = RHTipo::all()->lists('nombre','id');
				$data["modalidades"] = RHModalidad::all()->lists('nombre','id');
				$data["servicios"] = Servicio::orderBy('nombre')->get()->lists('nombre','idservicio');
				$data["departamentos"] = Area::orderBy('nombre')->get()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');

				return View::make('rrhh.presupuesto_capacitacion.create',$data);
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
							'id_capacitacion' => 'required|unique:presupuestos_capacitacion|exists:capacitaciones,id',
							'nombre' => 'required',
							'tipo' => 'required',
							'modalidad' => 'required',
							'departamento' => 'required',
							'responsable' => 'required',
							'servicio_clinico' => 'required',
							
							'rh_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'eq_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'go_actividades' => 'required_if:tipo,0|required_if:tipo,2',
							'ga_actividades' => 'required_if:tipo,0|required_if:tipo,2',
						);
				$messages = array(
						'fecha_ini.required'			=> 'El campo Fecha Inicio es requerido.',
						'fecha_fin.required'			=> 'El campo Fecha Final es requerido.',
						'rh_actividades.required_if'	=> 'Se deben agregar datos de actividades RH.',
						'eq_actividades.required_if'	=> 'Se deben agregar datos de actividades de equipos.',
						'go_actividades.required_if'	=> 'Se deben agregar datos de actividades de gastos operativos.',
						'ga_actividades.required_if'	=> 'Se deben agregar datos de actividades de gastos administrativos.',
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('presupuesto_capacitacion/create')->withErrors($validator)->withInput(Input::all());					
				}else{
					
					//dd(Input::all());
					$presupuesto = new PresupuestoCapacitacion;
					$presupuesto->nombre = Input::get('nombre');
					$presupuesto->id_tipo = Input::get('tipo');
					$presupuesto->id_modalidad = Input::get('modalidad');
					$presupuesto->id_servicio_clinico = Input::get('servicio_clinico');
					$presupuesto->id_departamento = Input::get('departamento');
					$presupuesto->id_responsable = Input::get('responsable');
					$presupuesto->id_capacitacion = Input::get('id_capacitacion');

					$presupuesto->save();
					
					$rh_actividades = Input::get('rh_actividades');
					$rh_descripciones = Input::get('rh_descripciones');
					$rh_unidades = Input::get('rh_unidades');
					$rh_cantidades = Input::get('rh_cantidades');
					$rh_costos_unitarios = Input::get('rh_costos_unitarios');

					foreach($rh_actividades as $key => $actividad){
						$presupuesto_actividad = new PresupuestoCapacitacionActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $rh_descripciones[$key];
						$presupuesto_actividad->unidad = $rh_unidades[$key];
						$presupuesto_actividad->cantidad = $rh_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $rh_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $rh_cantidades[$key]*$rh_costos_unitarios[$key];
						$presupuesto_actividad->id_clase = 0; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_presupuesto_capacitacion = $presupuesto->id;

						$presupuesto_actividad->save();
					}

					$eq_actividades = Input::get('eq_actividades');
					$eq_descripciones = Input::get('eq_descripciones');
					$eq_unidades = Input::get('eq_unidades');
					$eq_cantidades = Input::get('eq_cantidades');
					$eq_costos_unitarios = Input::get('eq_costos_unitarios');

					foreach($eq_actividades as $key => $actividad){
						$presupuesto_actividad = new PresupuestoCapacitacionActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $eq_descripciones[$key];
						$presupuesto_actividad->unidad = $eq_unidades[$key];
						$presupuesto_actividad->cantidad = $eq_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $eq_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $eq_cantidades[$key]*$eq_costos_unitarios[$key];
						$presupuesto_actividad->id_clase = 1; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_presupuesto_capacitacion = $presupuesto->id;

						$presupuesto_actividad->save();
					}

					$go_actividades = Input::get('go_actividades');
					$go_descripciones = Input::get('go_descripciones');
					$go_unidades = Input::get('go_unidades');
					$go_cantidades = Input::get('go_cantidades');
					$go_costos_unitarios = Input::get('go_costos_unitarios');

					foreach($go_actividades as $key => $actividad){
						$presupuesto_actividad = new PresupuestoCapacitacionActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $go_descripciones[$key];
						$presupuesto_actividad->unidad = $go_unidades[$key];
						$presupuesto_actividad->cantidad = $go_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $go_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $go_cantidades[$key]*$go_costos_unitarios[$key];
						$presupuesto_actividad->id_clase = 2; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_presupuesto_capacitacion = $presupuesto->id;

						$presupuesto_actividad->save();
					}

					$ga_actividades = Input::get('ga_actividades');
					$ga_descripciones = Input::get('ga_descripciones');
					$ga_unidades = Input::get('ga_unidades');
					$ga_cantidades = Input::get('ga_cantidades');
					$ga_costos_unitarios = Input::get('ga_costos_unitarios');

					foreach($ga_actividades as $key => $actividad){
						$presupuesto_actividad = new PresupuestoCapacitacionActividad;
						$presupuesto_actividad->nombre = $actividad;
						$presupuesto_actividad->descripcion = $ga_descripciones[$key];
						$presupuesto_actividad->unidad = $ga_unidades[$key];
						$presupuesto_actividad->cantidad = $ga_cantidades[$key];
						$presupuesto_actividad->costo_unitario = $ga_costos_unitarios[$key];
						$presupuesto_actividad->subtotal = $ga_cantidades[$key]*$ga_costos_unitarios[$key];
						$presupuesto_actividad->id_clase = 3; 	//0 => RH, 1 => EQ, 2 => GO, 3 => GA
						$presupuesto_actividad->id_presupuesto_capacitacion = $presupuesto->id;

						$presupuesto_actividad->save();
					}

					Session::flash('message', 'Se registró correctamente el presupuesto.');
					return Redirect::to('presupuesto_capacitacion/show/'.$presupuesto->id);
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

				$data["presupuesto"] = PresupuestoCapacitacion::withTrashed()->find($id);

				return View::make('rrhh.presupuesto_capacitacion.show',$data);
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

				$data["tipos"] = RHTipo::all()->lists('nombre','id');
				$data["modalidades"] = RHModalidad::all()->lists('nombre','id');
				$data["servicios"] = Servicio::orderBy('nombre')->get()->lists('nombre','idservicio');
				$data["departamentos"] = Area::orderBy('nombre')->get()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');

				$data["presupuesto"] = PresupuestoCapacitacion::find($id);

				return View::make('rrhh.presupuesto_capacitacion.edit',$data);
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

	public function validarCapacitacionExisteAjax()
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
			
			$id_capacitacion = Input::get('id_capacitacion');
			
			if($id_capacitacion!=''){				
				
				$capacitacion = Capacitacion::find($id_capacitacion);

				if($capacitacion){
					$reporte = $capacitacion;
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
