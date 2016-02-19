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
			$dimensiones = Dimension::all()->count();
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
					dd(Input::all());
					$proyecto = new Proyecto;
					$proyecto->nombre = Input::get('nombre');
					$proyecto->id_categoria = Input::get('categoria');
					$proyecto->id_servicio_clinico = Input::get('servicio_clinico');
					$proyecto->id_departamento = Input::get('departamento');
					$proyecto->id_responsable = Input::get('responsable');
					$proyecto->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$proyecto->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
					$proyecto->id_proyecto = Input::get('id_proyecto');

					$proyecto->save();



					$requerimientos = Input::get('requerimientos');
					foreach($requerimientos as $requerimiento){
						$proyecto_requerimiento = new ProyectoRequerimiento;
						$proyecto_requerimiento->descripcion = $requerimiento;
						$proyecto_requerimiento->id_proyecto = $proyecto->id;

						$proyecto_requerimiento->save();
					}

					Session::flash('message', 'Se registró correctamente el presupuesto.');
					return Redirect::to('proyecto_presupuesto/create/',$id);
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
		//
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
