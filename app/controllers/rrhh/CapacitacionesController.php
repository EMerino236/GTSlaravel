<?php

class CapacitacionesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)
			{
				$data["search_nombre_capacitacion"] = null;
				$data["search_responsable_capacitacion"]=null;
				$data["search_departamento_capacitacion"]=null;
				$data["search_servicio_capacitacion"]=null;
				$data["fecha_ini_capacitacion"]=null;
				$data["fecha_fin_capacitacion"]=null;
				$data["row_number"] = 10;

				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');

				$data["capacitaciones"] = Capacitacion::all();

				return View::make('rrhh/gestion_capacitaciones/index',$data);
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

				$data["search_nombre_capacitacion"] = Input::get('search_nombre_capacitacion');
				$data["search_responsable_capacitacion"]=Input::get('search_responsable_capacitacion');
				$data["search_departamento_capacitacion"]=Input::get('search_departamento_capacitacion');
				$data["search_servicio_capacitacion"]=Input::get('search_servicio_capacitacion');
				$data["fecha_ini_capacitacion"]=Input::get('fecha_ini_capacitacion');
				$data["fecha_fin_capacitacion"]=Input::get('fecha_fin_capacitacion');
				$data["row_number"] = Input::get('row_number');

				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$data["capacitaciones"] = Capacitacion::searchReporte($data['search_nombre_capacitacion'],$data['search_responsable_capacitacion'],$data['search_departamento_capacitacion'],$data['search_servicio_capacitacion'],$data["fecha_ini_capacitacion"],$data["fecha_fin_capacitacion"]);
				$data["capacitaciones"] = $data["capacitaciones"]->paginate($data["row_number"]);
				
				return View::make('rrhh.gestion_capacitaciones.index',$data);
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
				$data["tipos"] = RHTipo::all()->lists('nombre','id');
				$data["modalidades"] = RHModalidad::all()->lists('nombre','id');
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				return View::make('rrhh/gestion_capacitaciones/create',$data);
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
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
					'nombre_capacitacion' => 'required',
					'tipo_capacitacion' => 'required',
					'modalidad_capacitacion' => 'required',
					'descripcion' => 'required',
					'codigo_patrimonial' => 'required_if:tipo_capacitacion,1|required_if:tipo_capacitacion,2',
					'equipo_relacionado' => 'required_if:tipo_capacitacion,1|required_if:tipo_capacitacion,2',
					'departamento' => 'required',
					'responsable' => 'required',
					'servicio_clinico' => 'required',
					'fecha_ini' => 'required|date',
					'fecha_fin'	=> 'required|date',
				);

				$messages = array(
					'required_if' => 'El campo :attribute es requerido cuando el tipo de capacitacion es capacitacion de usuario o tecnica por equipo nuevo',
					'fecha_ini.required' => 'El campo Fecha Inicio es requerido',
					'fecha_fin.required' => 'El campo Fecha Final es requerido',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('capacitacion/create')->withErrors($validator)->withInput(Input::all());					
				}else{
						$capacitacion = new Capacitacion;
						$capacitacion->nombre = Input::get('nombre_capacitacion');
						$capacitacion->id_tipo = Input::get('tipo_capacitacion');
						$capacitacion->id_modalidad = Input::get('modalidad_capacitacion');
						$capacitacion->descripcion = Input::get('descripcion');
						
						if(Input::get('tipo_capacitacion') != 3){
							$capacitacion->codigo_patrimonial = Input::get('codigo_patrimonial');
							$capacitacion->equipo_relacionado = Input::get('equipo_relacionado');
						}
						
						$capacitacion->id_departamento = Input::get('departamento');
						$capacitacion->id_responsable = Input::get('responsable');
						$capacitacion->id_servicio_clinico = Input::get('servicio_clinico');
						$capacitacion->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
						$capacitacion->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));

						$capacitacion->save();

						$capacitacion->codigo = 'C-'.date('Y').'-'.$capacitacion->id;

						$capacitacion->save();


					Session::flash('message', 'Se registró correctamente la capacitación.');
					return Redirect::to('capacitacion/create');
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

				$data["capacitacion"] = Capacitacion::withTrashed()->find($id);

				return View::make('rrhh.gestion_capacitaciones.show',$data);
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

				$data["capacitacion"] = Capacitacion::find($id);

				return View::make('rrhh.gestion_capacitaciones.edit',$data);
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
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
					'nombre_capacitacion' => 'required',
					'tipo_capacitacion' => 'required',
					'modalidad_capacitacion' => 'required',
					'descripcion' => 'required',
					'codigo_patrimonial' => 'required_if:tipo_capacitacion,1|required_if:tipo_capacitacion,2',
					'equipo_relacionado' => 'required_if:tipo_capacitacion,1|required_if:tipo_capacitacion,2',
					'departamento' => 'required',
					'responsable' => 'required',
					'servicio_clinico' => 'required',
					'fecha_ini' => 'required|date',
					'fecha_fin'	=> 'required|date',
				);

				$messages = array(
					'required_if' => 'El campo :attribute es requerido cuando el tipo de capacitacion es capacitacion de usuario o tecnica por equipo nuevo',
					'fecha_ini.required' => 'El campo Fecha Inicio es requerido',
					'fecha_fin.required' => 'El campo Fecha Final es requerido',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('capacitacion/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{
						$capacitacion = Capacitacion::find($id);
						$capacitacion->nombre = Input::get('nombre_capacitacion');
						$capacitacion->id_tipo = Input::get('tipo_capacitacion');
						$capacitacion->id_modalidad = Input::get('modalidad_capacitacion');
						$capacitacion->descripcion = Input::get('descripcion');
						
						if(Input::get('tipo_capacitacion') != 3){
							$capacitacion->codigo_patrimonial = Input::get('codigo_patrimonial');
							$capacitacion->equipo_relacionado = Input::get('equipo_relacionado');
						}
						
						$capacitacion->id_departamento = Input::get('departamento');
						$capacitacion->id_responsable = Input::get('responsable');
						$capacitacion->id_servicio_clinico = Input::get('servicio_clinico');
						$capacitacion->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
						$capacitacion->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));

						$capacitacion->save();

					Session::flash('message', 'Se editó correctamente la capacitación.');
					return Redirect::to('capacitacion/show/'.$id);
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
