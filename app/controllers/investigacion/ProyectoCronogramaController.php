<?php

class ProyectoCronogramaController extends \BaseController {

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

				return View::make('investigacion.proyecto.cronograma.create',$data);
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
						);
				$messages = array(
						'fecha_ini.required'	=> 'El campo Fecha Inicio es requerido.',
						'fecha_fin.required'	=> 'El campo Fecha Final es requerido.',
						
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto_cronograma/create/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{
					$proyecto_cronograma = new Cronograma;
					$proyecto_cronograma->nombre = Input::get('nombre');
					$proyecto_cronograma->id_categoria = Input::get('categoria');
					$proyecto_cronograma->id_servicio_clinico = Input::get('servicio_clinico');
					$proyecto_cronograma->id_departamento = Input::get('departamento');
					$proyecto_cronograma->id_responsable = Input::get('responsable');
					$proyecto_cronograma->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$proyecto_cronograma->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
					$proyecto_cronograma->id_proyecto = $id;

					$proyecto_cronograma->save();

					$proyecto = Proyecto::find($id);
					$proyecto->id_cronograma = $proyecto_cronograma->id;
					$proyecto->save();
					
					Session::flash('message', 'Se registró correctamente el cronograma.');
					return Redirect::to('proyecto_cronograma/show/'.$id);
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
				
				$proyecto = Proyecto::find($id);
				$data["cronograma"] = $proyecto->cronograma;

				return View::make('investigacion.proyecto.cronograma.show',$data);
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

				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				$data["cronograma"] = Cronograma::find($id);
				$data["tipos"]	= [0=>'Fase de inversión',1=>'Fase de post-inversión'];

				return View::make('investigacion.proyecto.cronograma.edit',$data);
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
							'actividad' => 'required',					
							'descripcion' => 'required',
							'actividad_previa' => 'required',
							'fecha_ini' => 'required',
							'fecha_fin' => 'required',
							'duracion'	=> 'required',
							'tipo' => 'required',
						);
				$messages = array(
						'fecha_ini.required'	=> 'El campo Fecha Inicio es requerido.',
						'fecha_fin.required'	=> 'El campo Fecha Final es requerido.',
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto_cronograma/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$cronograma_actividad = new CronogramaActividad;

					$cronograma_actividad->nombre = Input::get('actividad');
					$cronograma_actividad->descripcion = Input::get('descripcion');
					$cronograma_actividad->id_actividad_previa = Input::get('actividad_previa');
					$cronograma_actividad->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$cronograma_actividad->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
					$cronograma_actividad->duracion = Input::get('duracion');
					$cronograma_actividad->id_tipo = Input::get('tipo');
					$cronograma_actividad->id_cronograma = $id;

					$cronograma_actividad->save();
					
					$cronograma = Cronograma::find($id);
					Session::flash('message', 'Se editó correctamente el cronograma.');
					return Redirect::to('proyecto_cronograma/show/'.$cronograma->proyecto->id);
				}
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
	public function editCronograma($id)
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
				$data["cronograma"] = Cronograma::find($id);

				return View::make('investigacion.proyecto.cronograma.editCronograma',$data);
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

				$data["actividad"] = CronogramaActividad::find($id);
				$data["cronograma"] = Cronograma::find($data["actividad"]->id_cronograma);
				if($data["actividad"]->id_tipo == 0){
					$data["actividades"] = $data["cronograma"]->actividades->lists('nombre','id');
				}else{
					$data["actividades"] = $data["cronograma"]->actividadespost->lists('nombre','id');
				}
				

				return View::make('investigacion.proyecto.cronograma.editActividad',$data);
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
			$id_tipo = Input::get('id_tipo');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'actividad' => 'required',					
							'descripcion' => 'required',
							'actividad_previa' => 'required',
							'fecha_ini' => 'required',
							'fecha_fin' => 'required',
							'duracion'	=> 'required',
						);
				$messages = array(
						'fecha_ini.required'	=> 'El campo Fecha Inicio es requerido.',
						'fecha_fin.required'	=> 'El campo Fecha Final es requerido.',
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('proyecto_cronograma/edit/actividad/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$cronograma_actividad = CronogramaActividad::find($id);

					$cronograma_actividad->nombre = Input::get('actividad');
					$cronograma_actividad->descripcion = Input::get('descripcion');
					$cronograma_actividad->id_actividad_previa = Input::get('actividad_previa');
					$cronograma_actividad->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$cronograma_actividad->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
					$cronograma_actividad->duracion = Input::get('duracion');

					$cronograma_actividad->save();
					
					$cronograma = Cronograma::find($cronograma_actividad->id_cronograma);
					Session::flash('message', 'Se editó correctamente la actividad del cronograma.');
					return Redirect::to('proyecto_cronograma/show/'.$cronograma->proyecto->id);
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
				$actividad = CronogramaActividad::find($id);
				$url = "proyecto_cronograma/show/".$actividad->cronograma->proyecto->id;

				if($actividad->actividadesPosteriores->isEmpty()){
					$actividad->delete();
					Session::flash('message','Se borro correctamente la actividad.');					
					return Redirect::to($url);
				}else{
					Session::flash('error','La actividad posee actividades posteriores.');					
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function getActividadesAjax()
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
			$id_cronograma = Input::get('id_cronograma');
			$id_tipo = Input::get('id_tipo');

			if($id_cronograma!="" && $id_tipo!=""){

				$cronograma = Cronograma::find($id_cronograma);
				if($id_tipo == 0){
					$actividades = [0=>'No posee actividad previa'] + $cronograma->actividades->lists('nombre','id');
				}else{
					$actividades = [0=>'No posee actividad previa'] + $cronograma->actividadespost->lists('nombre','id');
				}
				
			}else{
				$actividades = [0=>'No posee actividad previa'];
			}

			return Response::json(array( 'success' => true, 'actividades' => $actividades ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function getActividadAjax()
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
			$id_actividad = Input::get('id_actividad');

			if($id_actividad!=""){

				$actividad = CronogramaActividad::find($id_actividad);

			}else{
				$actividad = null;
			}

			return Response::json(array( 'success' => true, 'actividad' => $actividad ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}
