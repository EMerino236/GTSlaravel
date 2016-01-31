<?php

class ReporteFinanciamientoController extends \BaseController {

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

				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				
				$data["reportes_data"] = ReporteFinanciamiento::paginate(10);
				
				return View::make('investigacion.reportes.financiamiento.index',$data);
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
				$data["search_responsable"] = Input::get('search_responsable');

				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				
				$data["reportes_data"] = ReporteFinanciamiento::searchReporte($data['search_nombre'],$data['search_categoria'],$data['search_servicio_clinico'],$data['search_departamento'],$data['search_responsable']);
				$data["reportes_data"] = $data["reportes_data"]->paginate(10);
				
				return View::make('investigacion.reportes.financiamiento.index',$data);
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
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				
				return View::make('investigacion.reportes.financiamiento.create',$data);
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
							'descripcion' => 'required',
							'objetivos' => 'required',
							'crono_descripciones' => 'required',
							'fechas_ini' => 'required',
							'fechas_fin' => 'required',
							'duraciones' => 'required',
							'inv_descripciones' => 'required',
							'costos' => 'required',
							'impacto' => 'required',
							'costo_beneficio' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reporte_financiamiento/create')->withErrors($validator)->withInput(Input::all());					
				}else{
						//dd(Input::all());
						$reporte_financiamiento = new ReporteFinanciamiento;
						$reporte_financiamiento->nombre = Input::get('nombre');
						$reporte_financiamiento->id_categoria = Input::get('categoria');
						$reporte_financiamiento->id_servicio_clinico = Input::get('servicio_clinico');
						$reporte_financiamiento->id_departamento = Input::get('departamento');
						$reporte_financiamiento->id_responsable = Input::get('responsable');
						$reporte_financiamiento->descripcion = Input::get('descripcion');
						$reporte_financiamiento->objetivos = Input::get('objetivos');
						$reporte_financiamiento->impacto = Input::get('impacto');
						$reporte_financiamiento->costo_beneficio = Input::get('costo_beneficio');

						$reporte_financiamiento->save();

						foreach (Input::get('crono_descripciones') as $key => $crono_descripcion) {
							$cronograma = new ReporteFinanciamientoCronograma;
							$cronograma->descripcion = $crono_descripcion;
							$cronograma->fecha_ini = date("Y-m-d",strtotime(Input::get("fechas_ini")[$key]));
							$cronograma->fecha_fin = date("Y-m-d",strtotime(Input::get("fechas_fin")[$key]));
							$cronograma->duracion  = Input::get("duraciones")[$key];
							$cronograma->id_reporte = $reporte_financiamiento->id;

							$cronograma->save();
						}

						foreach (Input::get('inv_descripciones') as $key => $inv_descripcion) {
							$inversion = new ReporteFinanciamientoInversion;
							$inversion->descripcion = $inv_descripcion;
							$inversion->costo = Input::get("costos")[$key];
							$inversion->id_reporte = $reporte_financiamiento->id;

							$inversion->save();
						}
					
					Session::flash('message', 'Se registró correctamente el reporte.');
					return Redirect::to('reporte_financiamiento/create');
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
				return View::make('investigacion.reportes.financiamiento.show',$data);
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
				return View::make('investigacion.reportes.financiamiento.edit',$data);
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
							'nombre' => 'required',
							'categoria' => 'required',
							'servicio_clinico' => 'required',
							'departamento' => 'required',
							'responsable' => 'required',
							'descripcion' => 'required',
							'objetivos' => 'required',
							'crono_descripciones' => 'required',
							'fechas_ini' => 'required',
							'fechas_fin' => 'required',
							'inv_descripciones' => 'required',
							'costos' => 'required',
							'impacto' => 'required',
							'costo_beneficio' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reporte_financiamiento/edit')->withErrors($validator)->withInput(Input::all());					
				}else{
						dd(Input::all());
						$programacion_guia_ts = new ProgramacionGuiaTS;
						$programacion_guia_ts->id_tipo = Input::get('idtipo_reporte_ts');
						$programacion_guia_ts->iduser = $data["user"]->id;
						$programacion_guia_ts->fecha = date("Y-m-d",strtotime(Input::get('fecha_ts')));
						$programacion_guia_ts->nombre_reporte = Input::get('nombre_ts');
						$programacion_guia_ts->id_estado = 1;
						$programacion_guia_ts->save();
					
					Session::flash('message', 'Se registró correctamente el reporte.');
					return Redirect::to('reporte_financiamiento/edit');
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

	public function getServiciosAjax()
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
			$data = Input::get('id_departamento');			
			if($data != 0){
				$servicios = Servicio::where('idarea', $data)->lists('nombre','idservicio');
			}else{
				$servicios = array();
			}

			return Response::json(array( 'success' => true, 'servicios' => $servicios ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}


}
