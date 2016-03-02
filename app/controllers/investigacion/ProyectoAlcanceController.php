<?php

class ProyectoAlcanceController extends \BaseController {

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
				$data["proyecto"] = Proyecto::find($id);

				return View::make('investigacion.proyecto.alcance.create',$data);
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
							'requerimientos' => 'required',
							'caracteristicas' => 'required',
							'criterios' => 'required',
							'entregables' => 'required',
							'exclusiones' => 'required',
							'restricciones' => 'required',
							'asunciones' => 'required',
						);
				$messages = array(
						'fecha_ini.required' => 'El campo Fecha Inicio es requerido',
						'fecha_fin.required' => 'El campo Fecha Final es requerido',
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto_alcance/create/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{
					$proyecto_alcance = new Alcance;
					$proyecto_alcance->nombre = Input::get('nombre');
					$proyecto_alcance->id_categoria = Input::get('categoria');
					$proyecto_alcance->id_servicio_clinico = Input::get('servicio_clinico');
					$proyecto_alcance->id_departamento = Input::get('departamento');
					$proyecto_alcance->id_responsable = Input::get('responsable');
					$proyecto_alcance->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$proyecto_alcance->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
					$proyecto_alcance->id_proyecto = $id;

					$proyecto_alcance->save();


					$proyecto = Proyecto::find($id);
					$proyecto->id_alcance = $proyecto_alcance->id;

					$proyecto->save();

					
					$requerimientos = Input::get('requerimientos');
					foreach($requerimientos as $requerimiento){
						$alcance_requerimiento = new AlcanceRequerimiento;
						$alcance_requerimiento->descripcion = $requerimiento;
						$alcance_requerimiento->id_alcance = $proyecto_alcance->id;

						$alcance_requerimiento->save();
					}

					$caracteristicas = Input::get('caracteristicas');
					foreach ($caracteristicas as $caracteristica) {
						$alcance_caracteristica = new AlcanceCaracteristica;
						$alcance_caracteristica->descripcion = $caracteristica;
						$alcance_caracteristica->id_alcance = $proyecto_alcance->id;

						$alcance_caracteristica->save();
					}

					$criterios = Input::get('criterios');
					foreach ($criterios as $criterio) {
						$alcance_criterio = new AlcanceCriterio;
						$alcance_criterio->descripcion = $criterio;
						$alcance_criterio->id_alcance = $proyecto_alcance->id;

						$alcance_criterio->save();
					}

					$entregables = Input::get('entregables');
					foreach ($entregables as $entregable) {
						$alcance_entregable = new AlcanceEntregable;
						$alcance_entregable->descripcion = $entregable;
						$alcance_entregable->id_alcance = $proyecto_alcance->id;

						$alcance_entregable->save();
					}

					$exclusiones = Input::get('exclusiones');
					foreach ($exclusiones as $exclusion) {
						$alcance_exclusion = new AlcanceExclusion;
						$alcance_exclusion->descripcion = $exclusion;
						$alcance_exclusion->id_alcance = $proyecto_alcance->id;

						$alcance_exclusion->save();
					}

					$restricciones = Input::get('restricciones');
					foreach ($restricciones as $restriccion) {
						$alcance_restriccion = new AlcanceRestriccion;
						$alcance_restriccion->descripcion = $restriccion;
						$alcance_restriccion->id_alcance = $proyecto_alcance->id;

						$alcance_restriccion->save();
					}

					$asunciones = Input::get('asunciones');
					foreach ($asunciones as $asuncion) {
						$alcance_asuncion = new AlcanceAsuncion;
						$alcance_asuncion->descripcion = $asuncion;
						$alcance_asuncion->id_alcance = $proyecto_alcance->id;

						$alcance_asuncion->save();
					}

					Session::flash('message', 'Se registró correctamente el alcance.');
					return Redirect::to('proyecto_alcance/show/'.$id);
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
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$proyecto = Proyecto::find($id);
				$data["alcance"] = $proyecto->alcance;

				return View::make('investigacion.proyecto.alcance.show',$data);
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


}
