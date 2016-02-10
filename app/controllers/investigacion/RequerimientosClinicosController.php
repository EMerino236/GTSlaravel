<?php

class RequerimientosClinicosController extends \BaseController {

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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				
				$data["search_nombre"] = null;
				$data["search_categoria"] = null;
				$data["search_servicio_clinico"] = null;
				$data["search_departamento"] = null;
				$data["search_responsable"] = null;
				$data["search_estado"] = null;
				$data["search_tipo"] = null;

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["estados"] = RequerimientoClinicoEstado::all()->lists('nombre','id');
				$data["tipos"] = [0=>"Seleccione",1=>'Clínico',2=>'Hospitalario'];

				$data["requerimientos_data"] = RequerimientoClinico::withTrashed()->paginate(10);
				
				return View::make('investigacion.requerimientos_clinicos.index',$data);
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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["search_nombre"] = Input::get('search_nombre');
				$data["search_categoria"] = Input::get('search_categoria');
				$data["search_servicio_clinico"] = Input::get('search_servicio_clinico');
				$data["search_departamento"] = Input::get('search_departamento');
				$data["search_tipo"] = Input::get('search_tipo');
				$data["search_estado"] = Input::get('search_estado');

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["estados"] = RequerimientoClinicoEstado::all()->lists('nombre','id');
				$data["tipos"] = [0=>"Seleccione",1=>'Clínico',2=>'Hospitalario'];
				
				$data["requerimientos_data"] = RequerimientoClinico::searchRequerimiento($data['search_nombre'],$data['search_categoria'],$data['search_servicio_clinico'],$data['search_departamento'],$data['search_tipo'],$data['search_estado']);
				$data["requerimientos_data"] = $data["requerimientos_data"]->paginate(10);
				
				return View::make('investigacion.requerimientos_clinicos.index',$data);
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

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				$data["tipos"] = [0=>"Seleccione",1=>'Clínico',2=>'Hospitalario'];

				return View::make('investigacion.requerimientos_clinicos.create',$data);
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
							'nombre' => 'required',
							'categoria' => 'required',
							'servicio_clinico' => 'required',
							'departamento' => 'required',
							'responsable' => 'required',
							'fecha_ini' => 'required|date',
							'fecha_fin' => 'required|date',
							'presupuesto' => 'required',
							'observaciones' => 'required',
							'tipo' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('requerimientos_clinicos/create')->withErrors($validator)->withInput(Input::all());					
				}else{
						//dd(Input::all());
						$requerimiento_clinico = new RequerimientoClinico;
						$requerimiento_clinico->nombre = Input::get('nombre');
						$requerimiento_clinico->id_categoria = Input::get('categoria');
						$requerimiento_clinico->id_servicio_clinico = Input::get('servicio_clinico');
						$requerimiento_clinico->id_departamento = Input::get('departamento');
						$requerimiento_clinico->id_responsable = Input::get('responsable');
						$requerimiento_clinico->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
						$requerimiento_clinico->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
						$requerimiento_clinico->presupuesto = Input::get('presupuesto');
						$requerimiento_clinico->tipo = Input::get('tipo');
						$requerimiento_clinico->observaciones = Input::get('observaciones');
						$requerimiento_clinico->id_estado = 3;
						$requerimiento_clinico->id_reporte = Input::get('id_reporte');

						$requerimiento_clinico->save();

						$requerimiento_clinico->codigo = 'P-'.date('Y').'-'.$requerimiento_clinico->id;

						$requerimiento_clinico->save();

					Session::flash('message', 'Se registró correctamente el requerimiento.');
					return Redirect::to('requerimientos_clinicos/create');
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

				$data["estados"] = RequerimientoClinicoEstado::all()->lists('nombre','id');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				$data["requerimiento"] = RequerimientoClinico::withTrashed()->find($id);
				$data["tipos"] = [1=>'Clínico',2=>'Hospitalario'];
				return View::make('investigacion.requerimientos_clinicos.show',$data);
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

				$data["requerimiento"] = RequerimientoClinico::withTrashed()->find($id);
				$data["estados"] = RequerimientoClinicoEstado::all()->lists('nombre','id');
				$data["usuarios"] = User::all()->lists('UserFullName','id');

				return View::make('investigacion.requerimientos_clinicos.edit',$data);
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
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'estado' => 'required',
							'observaciones' => 'required',
							'modificador' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('requerimientos_clinicos/show/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{
						$requerimiento_clinico = RequerimientoClinico::find($id);
						$requerimiento_clinico->id_estado = Input::get('estado');
						$requerimiento_clinico->observaciones = Input::get('observaciones');
						$requerimiento_clinico->id_modificador = Input::get('modificador');

						$requerimiento_clinico->save();
		
					Session::flash('message', 'Se registró correctamente el reporte.');
					return Redirect::to('requerimientos_clinicos/show/'.$id);
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


	public function validarReporteAjax()
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
			$id_reporte = Input::get('id_reporte');
			$info = ReporteFinanciamiento::find($id_reporte);
			if($id_reporte != "" && $info){
				$reporte = $info;
			}else{
				$reporte = [];
			}

			return Response::json(array( 'success' => true, 'reporte' => $reporte),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}


	public function export($id){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				
				$reporte = RequerimientoClinico::find($id);
				if(!$reporte){
					Session::flash('error', 'No se encontró el requerimiento.');
					return Redirect::to('requerimientos_clinicos/index');
				}
				$data["reporte"] = $reporte;
				$data["tipos"] = [1=>'Clínico',2=>'Hospitalario'];

				$html = View::make('investigacion.requerimientos_clinicos.export',$data);
				return PDF::load($html,"A4","portrait")->download('Requerimiento Clinico - '.$data["reporte"]->categoria->nombre.' - '.$data["reporte"]->id);
				
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

}
