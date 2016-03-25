<?php

class ProgramacionDocenteController extends \BaseController {

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

				$data["nombres"] = Perfil::where('id_rol',0)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				
				$data["reportes_data"] = ProgramacionDocente::withTrashed()->paginate(10);
				
				return View::make('rrhh.programacion_docente.index',$data);
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

				$data["nombres"] = Perfil::where('id_rol',0)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				
				$data["reportes_data"] = ProgramacionDocente::searchReporte($data['search_nombre'],$data['search_servicio_clinico'],$data['search_departamento'],$data['search_responsable'],$data["search_fecha_ini"],$data["search_fecha_fin"]);

				$data["reportes_data"] = $data["reportes_data"]->paginate(10);
				
				return View::make('rrhh.programacion_docente.index',$data);
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
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4)
			{
				$data["nombres"] = Perfil::where('id_rol',0)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				
				$ini = 	Carbon\Carbon::now()->startOfMonth();
				$end =	Carbon\Carbon::now()->startOfMonth()->addMonth();
				
				while($ini->month != $end->month){
					$dia = $ini->format('Y-m-d');
					$temp = ProgramacionDocente::where('fecha',$dia)->get();

					if(!$temp->isEmpty()){
						$dayEvents = [];
						foreach ($temp as $var) {
							$dayEvents[$var->id] = $var;
						}
						$dias[$dia] = ["number" => count($dayEvents), "badgeClass" => "badge-warning", "dayEvents" => $dayEvents];	
					}else{
						$dias[$dia] = null;
					}
					
					$ini = $ini->addDay();
				}
				$dias = json_encode($dias);
				$data["dias"] = $dias;

				return View::make('rrhh.programacion_docente.create',$data);
			}
			else
			{
				return View::make('error/error',$data);
			}
		}
		else
		{
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
					'id_capacitacion' => 'required',
					'nombre' => 'required',
					'departamento' => 'required',
					'servicio_clinico' => 'required',
					'responsable' => 'required',
					'numero_sesion' => 'required',
				);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('programacion_docente/create')->withErrors($validator)->withInput(Input::all());					
				}else{
					$programacion_docente = new ProgramacionDocente;
					$programacion_docente->nombre = Input::get('nombre');
					$programacion_docente->id_departamento = Input::get('departamento');
					$programacion_docente->id_servicio_clinico = Input::get('servicio_clinico');
					$programacion_docente->id_sesion = Input::get('numero_sesion');
					$programacion_docente->id_responsable = Input::get('responsable');
					$programacion_docente->id_capacitacion = Input::get('id_capacitacion');
					$sesion = Sesion::find(Input::get('numero_sesion'));
					$programacion_docente->fecha = $sesion->fecha;
	
					$programacion_docente->save();

					Session::flash('message', 'Se registró correctamente la programación de docente.');
					return Redirect::to('programacion_docente/show/'.$programacion_docente->id);
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

				$data["nombres"] = Perfil::where('id_rol',0)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["sesiones"] = Sesion::lists('numero_sesion','id');

				$data["programacion"] = ProgramacionDocente::find($id);

				$ini = 	Carbon\Carbon::now()->startOfMonth();
				$end =	Carbon\Carbon::now()->startOfMonth()->addMonth();
				
				while($ini->month != $end->month){
					$dia = $ini->format('Y-m-d');
					$temp = ProgramacionDocente::where('fecha',$dia)->get();

					if(!$temp->isEmpty()){
						$dayEvents = [];
						foreach ($temp as $var) {
							$dayEvents[$var->id] = $var;
						}
						$dias[$dia] = ["number" => count($dayEvents), "badgeClass" => "badge-warning", "dayEvents" => $dayEvents];	
					}else{
						$dias[$dia] = null;
					}
					
					$ini = $ini->addDay();
				}
				$dias = json_encode($dias);
				$data["dias"] = $dias;

				return View::make('rrhh.programacion_docente.show',$data);
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
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4)
			{
				$data["nombres"] = Perfil::where('id_rol',0)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["programacion"] = ProgramacionDocente::find($id);
				$data["sesiones"] = Sesion::where('id_capacitacion',$data["programacion"]->id_capacitacion)->get()->lists('SesionNumero','id');

				$ini = 	Carbon\Carbon::now()->startOfMonth();
				$end =	Carbon\Carbon::now()->startOfMonth()->addMonth();
				
				while($ini->month != $end->month){
					$dia = $ini->format('Y-m-d');
					$temp = ProgramacionDocente::where('fecha',$dia)->get();

					if(!$temp->isEmpty()){
						$dayEvents = [];
						foreach ($temp as $var) {
							$dayEvents[$var->id] = $var;
						}
						$dias[$dia] = ["number" => count($dayEvents), "badgeClass" => "badge-warning", "dayEvents" => $dayEvents];	
					}else{
						$dias[$dia] = null;
					}
					
					$ini = $ini->addDay();
				}
				$dias = json_encode($dias);
				$data["dias"] = $dias;

				return View::make('rrhh.programacion_docente.edit',$data);
			}
			else
			{
				return View::make('error/error',$data);
			}
		}
		else
		{
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
					'departamento' => 'required',
					'servicio_clinico' => 'required',
					'responsable' => 'required',
					'numero_sesion' => 'required',
				);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('programacion_docente/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{
					$programacion_docente = ProgramacionDocente::find($id);
					$programacion_docente->nombre = Input::get('nombre');
					$programacion_docente->id_departamento = Input::get('departamento');
					$programacion_docente->id_servicio_clinico = Input::get('servicio_clinico');
					$programacion_docente->id_sesion = Input::get('numero_sesion');
					$programacion_docente->id_responsable = Input::get('responsable');
					$sesion = Sesion::find(Input::get('numero_sesion'));
					$programacion_docente->fecha = $sesion->fecha;
	
					$programacion_docente->save();

					Session::flash('message', 'Se editó correctamente la programación de docente.');
					return Redirect::to('programacion_docente/show/'.$id);
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


	public function validarCapacitacionAjax()
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
			$arr_capacitacion = null;
			if($id_capacitacion!=''){				
				$capacitacion = Capacitacion::find($id_capacitacion);
				if($capacitacion){

					$arr_capacitacion = ['capacitacion' => $capacitacion, 'id_departamento' => $capacitacion->servicio->idarea];
					$sesiones = $capacitacion->sesiones;
				}else{
					$capacitacion = null;
					$sesiones = null;	
				}
			}else{
				$capacitacion = null;
				$sesiones = null;
			}
			
			
			return Response::json(array( 'success' => true, 'arr_capacitacion' => $arr_capacitacion, 'sesiones' => $sesiones), 200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

}
