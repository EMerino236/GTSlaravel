<?php

class ProgramacionInternadoController extends \BaseController {

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

				$data["nombres"] = Perfil::where('id_rol',2)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$data["reportes_data"] = ProgramacionInternado::withTrashed()->paginate(10);
				
				return View::make('rrhh.programacion_internado.index',$data);
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

				$data["nombres"] = Perfil::where('id_rol',2)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$data["reportes_data"] = ProgramacionInternado::searchReporte($data['search_nombre'],$data['search_servicio_clinico'],$data['search_departamento'],$data['search_responsable'],$data["search_fecha_ini"],$data["search_fecha_fin"]);

				$data["reportes_data"] = $data["reportes_data"]->paginate(10);
				
				return View::make('rrhh.programacion_internado.index',$data);
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
				$data["nombres"] = Perfil::where('id_rol',2)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["tipos"] = RHTipo::all()->lists('nombre','id');
				$data["modalidades"] = RHModalidad::all()->lists('nombre','id');
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$ini = 	Carbon\Carbon::now()->startOfMonth();
				$end =	Carbon\Carbon::now()->startOfMonth()->addMonth();
				
				while($ini->month != $end->month){
					$dia = $ini->format('Y-m-d');
					$temp = ProgramacionInternado::where('fecha_ini','<=',$dia)->where('fecha_fin','>=',$dia)->get();

					if(!$temp->isEmpty()){
						foreach ($temp as $var) {
							$dayEvents[$var->id] = $var;
						}
						$dias[$dia] = ["number" => $temp->count(), "badgeClass" => "badge-warning", "dayEvents" => $dayEvents];	
					}else{
						$dias[$dia] = null;
					}
					
					$ini = $ini->addDay();
				}
				$dias = json_encode($dias);
				$data["dias"] = $dias;

				return View::make('rrhh.programacion_internado.create',$data);
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
							'nombre' => 'required',
							'departamento' => 'required',
							'servicio_clinico' => 'required',
							'responsable' => 'required',
							'numero_horas' => 'required',
							'fecha_ini' => 'required',
							'fecha_fin' => 'required',
						);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('programacion_internado/create')->withErrors($validator)->withInput(Input::all());					
				}else{

					$programacion_internado = new ProgramacionInternado;
					$programacion_internado->id_internista = Input::get('nombre');
					$programacion_internado->id_departamento = Input::get('departamento');
					$programacion_internado->id_servicio_clinico = Input::get('servicio_clinico');
					$programacion_internado->id_responsable = Input::get('responsable');
					$programacion_internado->num_horas = Input::get('numero_horas');
					$programacion_internado->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$programacion_internado->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
	
					$programacion_internado->save();
					Session::flash('message', 'Se registró correctamente la programación de internado.');
					return Redirect::to('programacion_internado/create');
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

				$data["tipos"] = RHTipo::all()->lists('nombre','id');
				$data["modalidades"] = RHModalidad::all()->lists('nombre','id');
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');

				$data["programacion"] = ProgramacionInternado::find($id);

				$ini = 	Carbon\Carbon::now()->startOfMonth();
				$end =	Carbon\Carbon::now()->startOfMonth()->addMonth();
				
				while($ini->month != $end->month){
					$dia = $ini->format('Y-m-d');
					$temp = ProgramacionInternado::where('fecha_ini','<=',$dia)->where('fecha_fin','>=',$dia)->get();

					if(!$temp->isEmpty()){
						foreach ($temp as $var) {
							$dayEvents[$var->id] = $var;
						}
						$dias[$dia] = ["number" => $temp->count(), "badgeClass" => "badge-warning", "dayEvents" => $dayEvents];	
					}else{
						$dias[$dia] = null;
					}
					
					$ini = $ini->addDay();
				}
				$dias = json_encode($dias);
				$data["dias"] = $dias;

				return View::make('rrhh.programacion_internado.show',$data);
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
				$data["nombres"] = Perfil::where('id_rol',2)->orderBy('nombres')->get()->lists('UserFullName','id');
				$data["tipos"] = RHTipo::all()->lists('nombre','id');
				$data["modalidades"] = RHModalidad::all()->lists('nombre','id');
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$data["programacion"] = ProgramacionInternado::find($id);

				$ini = 	Carbon\Carbon::now()->startOfMonth();
				$end =	Carbon\Carbon::now()->startOfMonth()->addMonth();
				
				while($ini->month != $end->month){
					$dia = $ini->format('Y-m-d');
					$temp = ProgramacionInternado::where('fecha_ini','<=',$dia)->where('fecha_fin','>=',$dia)->get();

					if(!$temp->isEmpty()){
						foreach ($temp as $var) {
							$dayEvents[$var->id] = $var;
						}
						$dias[$dia] = ["number" => $temp->count(), "badgeClass" => "badge-warning", "dayEvents" => $dayEvents];	
					}else{
						$dias[$dia] = null;
					}
					
					$ini = $ini->addDay();
				}
				$dias = json_encode($dias);
				$data["dias"] = $dias;

				return View::make('rrhh.programacion_internado.edit',$data);
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
							'numero_horas' => 'required',
							'fecha_ini' => 'required',
							'fecha_fin' => 'required',
						);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('programacion_internado/edit/',$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$programacion_internado = ProgramacionInternado::find($id);
					$programacion_internado->id_internista = Input::get('nombre');
					$programacion_internado->id_departamento = Input::get('departamento');
					$programacion_internado->id_servicio_clinico = Input::get('servicio_clinico');
					$programacion_internado->id_responsable = Input::get('responsable');
					$programacion_internado->num_horas = Input::get('numero_horas');
					$programacion_internado->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
					$programacion_internado->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
	
					$programacion_internado->save();

					Session::flash('message', 'Se editó correctamente la programación de internado.');
					return Redirect::to('programacion_internado/show/'.$id);
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


	public function getNumeroInternadosAjax()
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
			
			$id_servicio = Input::get('id_servicio');
			
			if($id_servicio!=''){				
				
				$programaciones = ProgramacionInternado::where('id_servicio_clinico',$id_servicio)->get();

				if($programaciones){
					$numero = $programaciones->count();
				}else{
					$numero = 0;
				}
			}else{
				$numero = 0;
			}
			
			
			return Response::json(array( 'success' => true, 'numero' => $numero),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

}
