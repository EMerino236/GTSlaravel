<?php

class RHPlanAprendizajeController extends \BaseController {

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
	public function create($id_programacion)
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

				$data["id_programacion"] = $id_programacion;
				return View::make('rrhh.plan_aprendizaje.create',$data);
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
	public function store($id_programacion)
	{
		//dd(Input::all());
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
							'fecha_ini'	=> 'required',
							'fecha_fin'	=> 'required',
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
					return Redirect::to('rh_plan_aprendizaje/create/'.$id_programacion)->withErrors($validator)->withInput(Input::all());					
				}else{

					dd(Input::all());

					$plan_aprendizaje = new RHPlanAprendizaje;
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
				        $rutaDestino 				= 'uploads/documentos/rrhh/plan_aprendizaje/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						$plan_aprendizaje->nombre_archivo = $nombreArchivo;
						$plan_aprendizaje->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$plan_aprendizaje->url = $rutaDestino;
					}		

					$plan_aprendizaje->id_programacion = $id_programacion;

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
					return Redirect::to('rh_plan_aprendizaje/show/'.$plan_aprendizaje->id);
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
