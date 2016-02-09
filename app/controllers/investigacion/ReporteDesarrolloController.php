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
		$nombres = Input::get('ind_nombres');
		$bases = Input::get('ind_bases');
		$unidades = Input::get('ind_unidades');
		$definiciones = Input::get('ind_definiciones');
		$verificaciones = Input::get('ind_verificaciones');
		//dd(Input::all());
		foreach($nombres as $keyD => $dimension){
			var_dump('DIMENSION '.$keyD);
			foreach($dimension as $keyA => $nombre){
				var_dump(' Nombre: '.$nombre.' Base: '.$bases[$keyD][$keyA].' Unidad: '.$unidades[$keyD][$keyA].' Definicion: '.$definiciones[$keyD][$keyA].' Verificacion: '.$verificaciones[$keyD][$keyA]);
			}
			
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
