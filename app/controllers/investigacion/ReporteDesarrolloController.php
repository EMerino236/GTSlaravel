<?php

class ReporteDesarrolloController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//die('index');
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
				$data["search_fecha_ini"] = null;
				$data["search_fecha_fin"] = null;

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				
				//WIP
				$data["reportes_data"] = ReporteFinanciamiento::withTrashed()->paginate(10);
				
				return View::make('investigacion.reportes.desarrollo.index',$data);
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
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				
				//WIP
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

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				$data["dimensiones"] = Dimension::all();
				return View::make('investigacion.reportes.desarrollo.create',$data);
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

		/*
			$nombres = Input::get('ind_nombres');
			$bases = Input::get('ind_bases');
			$unidades = Input::get('ind_unidades');
			$definiciones = Input::get('ind_definiciones');
			$verificaciones = Input::get('ind_verificaciones');
			dd(Input::all());
			foreach($nombres as $keyD => $dimension){
				var_dump('DIMENSION '.$keyD);
				foreach($dimension as $keyA => $nombre){
					var_dump(' Nombre: '.$nombre.' Base: '.$bases[$keyD][$keyA].' Unidad: '.$unidades[$keyD][$keyA].' Definicion: '.$definiciones[$keyD][$keyA].' Verificacion: '.$verificaciones[$keyD][$keyA]);
				}
				
			}
			die();
		*/
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'id_reporte' => 'required',
							'nombre' => 'required',
							'categoria' => 'required',
							'departamento' => 'required',
							'responsable' => 'required',
							'servicio_clinico' => 'required',
							'descripcion' => 'required',
							'indicadores' => 'required',
							'objetivos' => 'required',
							'ind_nombres' => 'required|size:'.$dimensiones,
							'ind_bases' => 'required',
							'ind_unidades' => 'required',
							'ind_definiciones' => 'required',
							'ind_verificaciones' => 'required',
						);
				$messages = array(
						'ind_nombres.size' => 'Debe llenar todas las dimensiones',
						'ind_bases.size' => 'Debe llenar todas las dimensiones',
						'ind_unidades.size' => 'Debe llenar todas las dimensiones',
						'ind_definiciones.size' => 'Debe llenar todas las dimensiones',
						'ind_verificaciones.size' => 'Debe llenar todas las dimensiones',
					);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reporte_desarrollo/create')->withErrors($validator)->withInput(Input::all());					
				}else{
						dd(Input::all());
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

					Session::flash('message', 'Se registró correctamente el reporte.');
					return Redirect::to('reporte_desarrollo/create');
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
			$info = RequerimientoClinico::find($id_reporte);
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

}
