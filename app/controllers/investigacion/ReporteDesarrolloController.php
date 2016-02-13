<?php

class ReporteDesarrolloController extends \BaseController {

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
				$data["search_fecha_ini"] = null;
				$data["search_fecha_fin"] = null;

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				
				$data["reportes_data"] = ReporteDesarrollo::withTrashed()->paginate(10);
				
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
				$data["reportes_data"] = ReporteDesarrollo::searchReporte($data['search_nombre'],$data['search_categoria'],$data['search_servicio_clinico'],$data['search_departamento'],$data['search_responsable'],$data["search_fecha_ini"],$data["search_fecha_fin"]);
				$data["reportes_data"] = $data["reportes_data"]->paginate(10);
				
				return View::make('investigacion.reportes.desarrollo.index',$data);
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
							'fecha_ini' => 'required|date',
							'fecha_fin'	=> 'required|date',
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
						//dd(Input::all());
						$reporte_desarrollo = new ReporteDesarrollo;
						$reporte_desarrollo->nombre = Input::get('nombre');
						$reporte_desarrollo->id_categoria = Input::get('categoria');
						$reporte_desarrollo->id_servicio_clinico = Input::get('servicio_clinico');
						$reporte_desarrollo->id_departamento = Input::get('departamento');
						$reporte_desarrollo->id_responsable = Input::get('responsable');
						$reporte_desarrollo->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
						$reporte_desarrollo->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
						$reporte_desarrollo->descripcion = Input::get('descripcion');
						$reporte_desarrollo->indicadores = Input::get('indicadores');
						$reporte_desarrollo->objetivos = Input::get('objetivos');
						$reporte_desarrollo->id_requerimiento = Input::get('id_reporte');

						$reporte_desarrollo->save();

						$reporte_desarrollo->codigo = 'ELB-'.date('Y').'-'.$reporte_desarrollo->id;

						$reporte_desarrollo->save();

						$nombres = Input::get('ind_nombres');
						$bases = Input::get('ind_bases');
						$unidades = Input::get('ind_unidades');
						$definiciones = Input::get('ind_definiciones');
						$verificaciones = Input::get('ind_verificaciones');

						foreach($nombres as $keyD => $dimension){
							//var_dump('DIMENSION '.$keyD);
							foreach($dimension as $keyA => $nombre){
								//var_dump(' Nombre: '.$nombre.' Base: '.$bases[$keyD][$keyA].' Unidad: '.$unidades[$keyD][$keyA].' Definicion: '.$definiciones[$keyD][$keyA].' Verificacion: '.$verificaciones[$keyD][$keyA]);
								$reporte_desarrollo_indicador = new ReporteDesarrolloIndicador;

								$reporte_desarrollo_indicador->nombre = $nombre;
								$reporte_desarrollo_indicador->base = $bases[$keyD][$keyA];
								$reporte_desarrollo_indicador->unidad = $unidades[$keyD][$keyA];
								$reporte_desarrollo_indicador->definicion = $definiciones[$keyD][$keyA];
								$reporte_desarrollo_indicador->medio = $verificaciones[$keyD][$keyA];
								$reporte_desarrollo_indicador->reporte_id = $reporte_desarrollo->id;
								$reporte_desarrollo_indicador->dimension_id = $keyD;

								$reporte_desarrollo_indicador->save();
							}
							
						}

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
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["reporte"] = ReporteDesarrollo::withTrashed()->find($id);

				return View::make('investigacion.reportes.desarrollo.show',$data);
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

				$data["categorias"] = ProyectoCategoria::all()->lists('nombre','id');
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				$data["dimensiones"] = Dimension::all();

				$data["reporte"] = ReporteDesarrollo::find($id);
				//var_dump($data["reporte"]->indicador);
				$arreglo = [];
				foreach($data["reporte"]->indicador as $indicador){
					if(isset($arreglo[$indicador->dimension_id])){
						array_push($arreglo[$indicador->dimension_id],$indicador);
					}else{
						$arreglo[$indicador->dimension_id] = [$indicador];
					}
					
				}
				$data["indicadores"] = $arreglo;

				return View::make('investigacion.reportes.desarrollo.edit',$data);
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
							'nombre' => 'required',
							'categoria' => 'required',
							'departamento' => 'required',
							'responsable' => 'required',
							'servicio_clinico' => 'required',
							'descripcion' => 'required',
							'indicadores' => 'required',
							'objetivos' => 'required',
							//'ind_nombres' => 'required|size:'.$dimensiones,
							//'ind_bases' => 'required',
							//'ind_unidades' => 'required',
							//'ind_definiciones' => 'required',
							//'ind_verificaciones' => 'required',
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
					return Redirect::to('reporte_desarrollo/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{
						//dd(Input::all());
						$reporte_desarrollo = ReporteDesarrollo::find($id);
						$reporte_desarrollo->nombre = Input::get('nombre');
						$reporte_desarrollo->id_categoria = Input::get('categoria');
						$reporte_desarrollo->id_servicio_clinico = Input::get('servicio_clinico');
						$reporte_desarrollo->id_departamento = Input::get('departamento');
						$reporte_desarrollo->id_responsable = Input::get('responsable');
						$reporte_desarrollo->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
						$reporte_desarrollo->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));
						$reporte_desarrollo->descripcion = Input::get('descripcion');
						$reporte_desarrollo->indicadores = Input::get('indicadores');
						$reporte_desarrollo->objetivos = Input::get('objetivos');

						$reporte_desarrollo->save();

						$nombres = Input::get('ind_nombres');
						$bases = Input::get('ind_bases');
						$unidades = Input::get('ind_unidades');
						$definiciones = Input::get('ind_definiciones');
						$verificaciones = Input::get('ind_verificaciones');

						if($nombres){
							foreach($nombres as $keyD => $dimension){
								//var_dump('DIMENSION '.$keyD);
								foreach($dimension as $keyA => $nombre){
									//var_dump(' Nombre: '.$nombre.' Base: '.$bases[$keyD][$keyA].' Unidad: '.$unidades[$keyD][$keyA].' Definicion: '.$definiciones[$keyD][$keyA].' Verificacion: '.$verificaciones[$keyD][$keyA]);
									$reporte_desarrollo_indicador = new ReporteDesarrolloIndicador;

									$reporte_desarrollo_indicador->nombre = $nombre;
									$reporte_desarrollo_indicador->base = $bases[$keyD][$keyA];
									$reporte_desarrollo_indicador->unidad = $unidades[$keyD][$keyA];
									$reporte_desarrollo_indicador->definicion = $definiciones[$keyD][$keyA];
									$reporte_desarrollo_indicador->medio = $verificaciones[$keyD][$keyA];
									$reporte_desarrollo_indicador->reporte_id = $reporte_desarrollo->id;
									$reporte_desarrollo_indicador->dimension_id = $keyD;

									$reporte_desarrollo_indicador->save();
								}
								
							}
						}

					Session::flash('message', 'Se modifico correctamente el reporte.');
					return Redirect::to('reporte_desarrollo/edit/'.$id);
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editIndicador($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["indicador"] = ReporteDesarrolloIndicador::find($id);
				
				return View::make('investigacion.reportes.desarrollo.editIndicador',$data);
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
	public function updateIndicador($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'nombre' => 'required',
							'base' => 'required',
							'unidad' => 'required',
							'definicion' => 'required',
							'medio' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reporte_desarrollo/indicador/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$indicador = ReporteDesarrolloIndicador::find($id);
					$indicador->nombre = Input::get('nombre');
					$indicador->base = Input::get('base');
					$indicador->unidad = Input::get('unidad');
					$indicador->definicion = Input::get('definicion');
					$indicador->medio = Input::get('medio');
					
					$indicador->save();
					
					Session::flash('message', 'Se modificó correctamente el indicador.');
					return Redirect::to('reporte_desarrollo/indicador/edit/'.$id);
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
	public function destroyIndicador($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$tarea = ReporteDesarrolloIndicador::find($id);
				$url = "reporte_desarrollo/edit/".$tarea->reporte_id;
				$tarea->delete();
				Session::flash('message','Se borro correctamente el indicador.');					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
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
