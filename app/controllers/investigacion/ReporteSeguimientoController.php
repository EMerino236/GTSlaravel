<?php

class ReporteSeguimientoController extends \BaseController {

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

				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$data["reportes_data"] = ReporteSeguimiento::withTrashed()->paginate(10);
				
				return View::make('investigacion.reportes.seguimiento.index',$data);
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

				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["departamentos"] = Area::all()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');
				
				$data["reportes_data"] = ReporteSeguimiento::searchReporte($data['search_nombre'],$data['search_servicio_clinico'],$data['search_departamento'],$data['search_responsable'],$data["search_fecha_ini"],$data["search_fecha_fin"]);

				$data["reportes_data"] = $data["reportes_data"]->paginate(10);
				
				return View::make('investigacion.reportes.seguimiento.index',$data);
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

				$data["categorias"] = ProyectoCategoria::orderBy('nombre')->get()->lists('nombre','id');
				$data["servicios"] = Servicio::orderBy('nombre')->get()->lists('nombre','idservicio');
				$data["departamentos"] = Area::orderBy('nombre')->get()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');

				return View::make('investigacion.reportes.seguimiento.create',$data);
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
							'id_proyecto' => 'required|unique:reportes_seguimiento|exists:proyectos,id',
							'nombre' => 'required',
							'departamento' => 'required',
							'responsable' => 'required',
							'servicio_clinico' => 'required',
							
							'archivo' => 'required|max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
				);
				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reporte_seguimiento/create')->withErrors($validator)->withInput(Input::all());					
				}else{

					//dd(Input::all());

					$reporte = new ReporteSeguimiento;
					$reporte->nombre = Input::get('nombre');
					$reporte->id_servicio_clinico = Input::get('servicio_clinico');
					$reporte->id_departamento = Input::get('departamento');
					$reporte->id_responsable = Input::get('responsable');


					$rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/investigacion/reporte_seguimiento/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						$reporte->nombre_archivo = $nombreArchivo;
						$reporte->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$reporte->url = $rutaDestino;
					}		

					$reporte->id_proyecto = Input::get('id_proyecto');

					$reporte->save();

					$reporte->codigo = 'RSC-'.date('Y').'-'.$reporte->id;

					$reporte->save();					

					Session::flash('message', 'Se registró correctamente el reporte de seguimiento.');
					return Redirect::to('reporte_seguimiento/create');
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

				$data["reporte"] = ReporteSeguimiento::withTrashed()->find($id);

				return View::make('investigacion.reportes.seguimiento.show',$data);
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

				$data["categorias"] = ProyectoCategoria::orderBy('nombre')->get()->lists('nombre','id');
				$data["servicios"] = Servicio::orderBy('nombre')->get()->lists('nombre','idservicio');
				$data["departamentos"] = Area::orderBy('nombre')->get()->lists('nombre','idarea');
				$data["usuarios"] = User::orderBy('nombre')->get()->lists('UserFullName','id');

				$data["reporte"] = ReporteSeguimiento::find($id);

				return View::make('investigacion.reportes.seguimiento.edit',$data);
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
							'departamento' => 'required',
							'responsable' => 'required',
							'servicio_clinico' => 'required',
							
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
				);
				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reporte_seguimiento/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					//dd(Input::all());

					$reporte = ReporteSeguimiento::find($id);
					$reporte->nombre = Input::get('nombre');
					$reporte->id_servicio_clinico = Input::get('servicio_clinico');
					$reporte->id_departamento = Input::get('departamento');
					$reporte->id_responsable = Input::get('responsable');

					$rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/investigacion/reporte_seguimiento/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						$reporte->nombre_archivo = $nombreArchivo;
						$reporte->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$reporte->url = $rutaDestino;
					}		

					$reporte->save();

					Session::flash('message', 'Se editó correctamente el reporte de seguimiento.');
					return Redirect::to('reporte_seguimiento/edit/'.$id);
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

	public function download($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){
				$reporte = ReporteSeguimiento::find($id);
				$rutaDestino = $reporte->url.$reporte->nombre_archivo_encriptado;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($reporte->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


}
