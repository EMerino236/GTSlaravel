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
					'departamento' => 'required',
					'responsable' => 'required',
					'servicio_clinico' => 'required',
					'fecha_ini' => 'required|date',
					'fecha_fin'	=> 'required|date',
					'numero_sesiones' => 'required|numeric',
					'horasxsesion' => 'required|numeric',
					'objetivo' =>'required|alpha_num_spaces',
					'personas_involucradas' => 'required|alpha_num_spaces',
					'competencias_requeridas' => 'required|alpha_num_spaces',
					'archivo' =>'required'
				);

				$messages = array(
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
							$activo = Activo::searchActivosByCodigoPatrimonial(Input::get('codigo_patrimonial'))->get();
							if(!$activo->isEmpty()){
								$capacitacion->id_activo = $activo[0]->idactivo;
							}							
						}
						
						$capacitacion->id_responsable = Input::get('responsable');
						$capacitacion->id_servicio_clinico = Input::get('servicio_clinico');
						$capacitacion->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
						$capacitacion->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));

						$numero_sesiones = Input::get('numero_sesiones');
						if($numero_sesiones<=0){
							Session::flash('error', 'La capacitación debe tener una o más sesiones.');
							return Redirect::to('capacitacion/create')->withInput(Input::all());
						}

						$capacitacion->numero_sesiones = $numero_sesiones;

						$capacitacion->horasxsesiones = Input::get('horasxsesion');

						//Para el plan de capacitacion
						$capacitacion->objetivo = Input::get('objetivo');
						$capacitacion->personal_involucrado = Input::get('personas_involucradas');
						$capacitacion->competencia = Input::get('competencias_requeridas');

						$capacitacion->save();

						for($i=1;$i<$numero_sesiones+1;$i++){
							$sesion = new Sesion;
							$sesion->numero_sesion = $i;
							$sesion->id_capacitacion = $capacitacion->id;
							$sesion->save();

							$material_sesion = new MaterialSesion;
							$material_sesion->idsesion = $sesion->id;
							$material_sesion->save();
						}

						$details_nombre =Input::get('details_nombre');
						$details_descripcion = Input::get('details_descripcion');
						$details_rol = Input::get('details_rol');
						$details_institucion = Input::get('details_institucion');

						$cantidad = count($details_nombre);
						for($i=0;$i<$cantidad;$i++){
							$personal_externo = new PersonalExternoCapacitacion;
							$personal_externo->nombre = $details_nombre[0];
							$personal_externo->descripcion = $details_descripcion[0];
							$personal_externo->rol = $details_rol[0];
							$personal_externo->institucion = $details_institucion[0];
							$personal_externo->id_capacitacion = $capacitacion->id;
							$personal_externo->save();
						}

						$capacitacion->codigo = 'C-'.date('Y').'-'.$capacitacion->id;

						if (Input::hasFile('archivo')) {
							$archivo            = Input::file('archivo');
					        $rutaDestino = 'uploads/documentos/rrhh/Plan de Capacitacion/' .$capacitacion->codigo. '/';
					        $nombreArchivo        = $archivo->getClientOriginalName();
					        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
					        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);					        
					       	$capacitacion->nombre_archivo = $nombreArchivo;
							$capacitacion->nombre_archivo_encriptado = $nombreArchivoEncriptado;
							$capacitacion->url = $rutaDestino;
					    }

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
				if($data["capacitacion"]->activo != null){
					$data["codigo_patrimonial"] = $data["capacitacion"]->activo->codigo_patrimonial;
					$data["equipo_relacionado"] = $data["capacitacion"]->activo->modelo->familiaActivo->nombre_equipo;
				}else{
					$data["codigo_patrimonial"] = null;
					$data["equipo_relacionado"] = null;
				}
				$data["details_personas"] = PersonalExternoCapacitacion::getDetallePersonasInvolucradas($data["capacitacion"]->id)->get();
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
				$data["departamento"] = Servicio::find($data["capacitacion"]->id_servicio_clinico)->departamento;
				$data["details_personas"] = PersonalExternoCapacitacion::getDetallePersonasInvolucradas($data["capacitacion"]->id)->get();
				if($data["capacitacion"]->activo != null){
					$data["codigo_patrimonial"] = $data["capacitacion"]->activo->codigo_patrimonial;
					$data["equipo_relacionado"] = $data["capacitacion"]->activo->modelo->familiaActivo->nombre_equipo;
				}else{
					$data["codigo_patrimonial"] = null;
					$data["equipo_relacionado"] = null;
				}
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
							$activo = Activo::searchActivosByCodigoPatrimonial(Input::get('codigo_patrimonial'))->get();
							if(!$activo->isEmpty()){
								$capacitacion->id_activo = $activo[0]->idactivo;
							}else{
								$capacitacion->id_activo = null;
							}	
						}else{
							$capacitacion->id_activo = null;
						}

						$capacitacion->horasxsesiones = Input::get('horasxsesion');

						//Para el plan de capacitacion
						$capacitacion->objetivo = Input::get('objetivo');
						$capacitacion->personal_involucrado = Input::get('personas_involucradas');
						$capacitacion->competencia = Input::get('competencias_requeridas');
						
						$capacitacion->id_responsable = Input::get('responsable');
						$capacitacion->id_servicio_clinico = Input::get('servicio_clinico');
						$capacitacion->fecha_ini = date("Y-m-d",strtotime(Input::get('fecha_ini')));
						$capacitacion->fecha_fin = date("Y-m-d",strtotime(Input::get('fecha_fin')));

						PersonalExternoCapacitacion::getDetallePersonasInvolucradas($capacitacion->id)->forceDelete();

						$details_nombre =Input::get('details_nombre');
						$details_descripcion = Input::get('details_descripcion');
						$details_rol = Input::get('details_rol');
						$details_institucion = Input::get('details_institucion');

						$cantidad = count($details_nombre);
						for($i=0;$i<$cantidad;$i++){
							$personal_externo = new PersonalExternoCapacitacion;
							$personal_externo->nombre = $details_nombre[0];
							$personal_externo->descripcion = $details_descripcion[0];
							$personal_externo->rol = $details_rol[0];
							$personal_externo->institucion = $details_institucion[0];
							$personal_externo->id_capacitacion = $capacitacion->id;
							$personal_externo->save();
						}

						if(Input::has('seleccionado')){
							if (Input::hasFile('archivo')) {
								$rutaArchivoEliminar = $capacitacion->url.$capacitacion->nombre_archivo_encriptado;
								if(File::exists($rutaArchivoEliminar))
						            File::delete($rutaArchivoEliminar);
								$archivo            = Input::file('archivo');
						        $rutaDestino = 'uploads/documentos/rrhh/Plan de Capacitacion/' .$capacitacion->codigo. '/';
						        $nombreArchivo        = $archivo->getClientOriginalName();
						        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
						        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);					        
						       	$capacitacion->nombre_archivo = $nombreArchivo;
								$capacitacion->nombre_archivo_encriptado = $nombreArchivoEncriptado;
								$capacitacion->url = $rutaDestino;
						    }
						}

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

	public function search_equipo_ajax(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$equipo = Activo::searchActivosByCodigoPatrimonial($data)->get();
				if(!$equipo->isEmpty()){
					$equipo = $equipo[0];
				}else{
				 	$equipo = null;
				}
			}else{
				$equipo = null;
			}

			return Response::json(array( 'success' => true, 'equipo' => $equipo ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function download($idCapacitacion=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$capacitacion = Capacitacion::find($idCapacitacion);
				$rutaDestino = $capacitacion->url.$capacitacion->nombre_archivo_encriptado;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($capacitacion->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function create_personal($id=null){

		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4)
			{
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipos_documentos"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["id_capacitacion"] = $id;
				
				return View::make('rrhh/personal_capacitaciones/create',$data);
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

	public function store_personal(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$id_capacitacion = Input::get('id_capacitacion');

				$rules = array(
					'nombre' => 'required|alpha_spaces',
					'apellidos' => 'required|alpha_spaces',
					'departamento' => 'required',
					'servicio_clinico' => 'required',
					'tipo_documento' => 'required',
					'numero_documento' => 'required|numeric|unique:personal_capacitaciones,numero_documento,NULL,id,id_capacitacion,'.$id_capacitacion
				);

				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('capacitacion/create_personal/'.$id_capacitacion)->withErrors($validator)->withInput(Input::all());					
				}else{
						
						$personal = new PersonalCapacitacion;
						$personal->nombre = Input::get('nombre');
						$personal->apellidos = Input::get('apellidos');
						$personal->id_servicio = Input::get('servicio_clinico');
						$personal->id_tipodocumento = Input::get('tipo_documento');
						$personal->numero_documento = Input::get('numero_documento');
						$personal->id_capacitacion = $id_capacitacion;
						$personal->save();

					Session::flash('message', 'Se registró correctamente al nuevo personal de la capacitación.');
					return Redirect::to('capacitacion/show_personal/'.$id_capacitacion);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function show_personal($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				$data["capacitacion"] = Capacitacion::withTrashed()->find($id);
				if($data["capacitacion"]->activo != null){
					$data["codigo_patrimonial"] = $data["capacitacion"]->activo->codigo_patrimonial;
					$data["equipo_relacionado"] = $data["capacitacion"]->activo->modelo->familiaActivo->nombre_equipo;
				}else{
					$data["codigo_patrimonial"] = null;
					$data["equipo_relacionado"] = null;
				}

				$data["personal_data"] = PersonalCapacitacion::getPersonalByIdCapacitacion($data["capacitacion"]->id)->get(); 
				return View::make('rrhh.personal_capacitaciones.show',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function destroy_personal(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			$personal = PersonalCapacitacion::find($data);
			$exito = 0;
			if($personal != null){
				$exito = 1;
				$personal->delete();
			}else
				$exito = 0;
				

			return Response::json(array( 'success' => true, 'exito' => $exito ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function show_sesiones($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				$data["capacitacion"] = Capacitacion::withTrashed()->find($id);
				if($data["capacitacion"]->id_activo != null){
					$data["codigo_patrimonial"] = $data["capacitacion"]->activo->codigo_patrimonial;
					$data["equipo_relacionado"] = $data["capacitacion"]->activo->modelo->familiaActivo->nombre_equipo;
				}else{
					$data["codigo_patrimonial"] = null;
					$data["equipo_relacionado"] = null;
				}

				$data["sesiones_data"] = Sesion::getSesionesByIdCapacitacion($data["capacitacion"]->id)->get(); 
				
				return View::make('rrhh.sesiones_capacitaciones.show',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function show_actividades($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				

				$data["actividades_data"] = ActividadCapacitacion::getActividadesByIdSesion($id)->get(); 
				$data["sesion"] = Sesion::find($id);
				
				return View::make('rrhh.sesiones_capacitaciones.showActividades',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function create_actividad($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){


				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["sesion"] = Sesion::find($id);
				
				return View::make('rrhh.sesiones_capacitaciones.createActividad',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function store_actividad(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$id_sesion = Input::get('id_sesion');

				$rules = array(
					'nombre' => 'required|alpha_num_spaces|unique:actividad_capacitaciones,nombre,NULL,id,id_sesion,'.$id_sesion,
					'descripcion' => 'required|alpha_num_spaces',
					'servicio_clinico' => 'required',
					'fecha' => 'required',
					'duracion' => 'required|numeric'
				);

				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('capacitacion/create_actividad/'.$id_sesion)->withErrors($validator)->withInput(Input::all());					
				}else{
						
						$actividad = new ActividadCapacitacion;
						$actividad->nombre = Input::get('nombre');
						$actividad->descripcion = Input::get('descripcion');
						$actividad->id_servicio = Input::get('servicio_clinico');
						$actividad->fecha = date("Y-m-d",strtotime(Input::get('fecha')));
						$actividad->duracion = Input::get('duracion');
						$actividad->id_sesion = $id_sesion;
						$actividad->save();

					Session::flash('message', 'Se registró correctamente la nueva actividad de la sesión.');
					return Redirect::to('capacitacion/show_actividades/'.$id_sesion);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function edit_actividad($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				$data["actividad"] = ActividadCapacitacion::find($id);
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				return View::make('rrhh.sesiones_capacitaciones.editActividad',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function update_actividad(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$id_actividad = Input::get('id_actividad');
				$actividad = ActividadCapacitacion::find($id_actividad);
				$rules = array(
					'nombre' => 'required|alpha_num_spaces|unique:actividad_capacitaciones,nombre,'.$id_actividad.',id,id_sesion,'.$actividad->id_sesion,
					'descripcion' => 'required|alpha_num_spaces',
					'servicio_clinico' => 'required',
					'fecha' => 'required',
					'duracion' => 'required|numeric'
				);

				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('capacitacion/edit_actividad/'.$id_actividad)->withErrors($validator)->withInput(Input::all());					
				}else{
						
						$actividad = ActividadCapacitacion::find($id_actividad);
						$actividad->nombre = Input::get('nombre');
						$actividad->descripcion = Input::get('descripcion');
						$actividad->id_servicio = Input::get('servicio_clinico');
						$actividad->fecha = date("Y-m-d",strtotime(Input::get('fecha')));
						$actividad->duracion = Input::get('duracion');
						$actividad->save();

					Session::flash('message', 'Se editó correctamente la actividad.');
					return Redirect::to('capacitacion/show_actividades/'.$actividad->id_sesion);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function destroy_actividad(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			$actividad = ActividadCapacitacion::find($data);
			$exito = 0;
			if($actividad != null){
				$exito = 1;
				$actividad->delete();
			}else
				$exito = 0;
				

			return Response::json(array( 'success' => true, 'exito' => $exito ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function show_competencias($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				$data["competencias_data"] = CompetenciaCapacitacion::getCompetenciasByIdSesion($id)->get(); 
				$data["sesion"] = Sesion::find($id);
				
				return View::make('rrhh.sesiones_capacitaciones.showCompetencias',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function create_competencia($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				

				$data["sesion"] = Sesion::find($id);
				
				return View::make('rrhh.sesiones_capacitaciones.createCompetencia',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function store_competencia(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$id_sesion = Input::get('id_sesion');

				$rules = array(
					'nombre' => 'required|alpha_num_spaces|unique:competencias_generadas,nombre,NULL,id,id_sesion,'.$id_sesion,
					'indicador' => 'required|alpha_num_spaces',
				);

				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('capacitacion/create_competencia/'.$id_sesion)->withErrors($validator)->withInput(Input::all());					
				}else{
						
						$competencia = new CompetenciaCapacitacion;
						$competencia->nombre = Input::get('nombre');
						$competencia->indicador = Input::get('indicador');
						$competencia->id_sesion = $id_sesion;
						$competencia->save();

					Session::flash('message', 'Se registró correctamente la nueva competencia de la sesión.');
					return Redirect::to('capacitacion/show_competencias/'.$id_sesion);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function edit_competencia($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				$data["competencia"] = CompetenciaCapacitacion::find($id);
				return View::make('rrhh.sesiones_capacitaciones.editCompetencia',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function update_competencia(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$id_competencia = Input::get('id_competencia');
				$competencia = CompetenciaCapacitacion::find($id_competencia);
				$rules = array(
					'nombre' => 'required|alpha_num_spaces|unique:competencias_generadas,nombre,'.$id_competencia.',id,id_sesion,'.$competencia->id_sesion,
					'indicador' => 'required|alpha_num_spaces',
				);

				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('capacitacion/edit_competencia/'.$id_competencia)->withErrors($validator)->withInput(Input::all());					
				}else{
						
						$competencia = CompetenciaCapacitacion::find($id_competencia);
						$competencia->nombre = Input::get('nombre');
						$competencia->indicador = Input::get('indicador');
						$competencia->save();

					Session::flash('message', 'Se editó correctamente la competencia.');
					return Redirect::to('capacitacion/show_competencias/'.$competencia->id_sesion);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function destroy_competencia(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			$competencia = CompetenciaCapacitacion::find($data);
			$exito = 0;
			if($competencia != null){
				$exito = 1;
				$competencia->delete();
			}else
				$exito = 0;
				

			return Response::json(array( 'success' => true, 'exito' => $exito ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function show_fecha_sesion($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["sesion"] = Sesion::find($id);
				$data["capacitacion"] = Capacitacion::find($data["sesion"]->id_capacitacion);
				return View::make('rrhh.sesiones_capacitaciones.showFechaSesion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function edit_fecha_sesion($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["sesion"] = Sesion::find($id);
				$data["capacitacion"] = Capacitacion::find($data["sesion"]->id_capacitacion);
				return View::make('rrhh.sesiones_capacitaciones.editFechaSesion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function update_fecha_sesion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$id_sesion = Input::get('id_sesion');

				$rules = array(
					'fecha' => 'required',
					'hora_inicio' => 'required',
				);

				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('capacitacion/edit_fecha_sesion/'.$id_sesion)->withErrors($validator)->withInput(Input::all());					
				}else{
						
						$sesion = Sesion::find($id_sesion);
						$capacitacion = Capacitacion::find($sesion->id_capacitacion);
						$fecha_sesion = date('Y-m-d',strtotime(Input::get('fecha')));
						if(($fecha_sesion<=$capacitacion->fecha_fin) && ($fecha_sesion >= $capacitacion->fecha_ini)){
							$sesion->fecha = date('Y-m-d H:i:s',strtotime($fecha_sesion." ".Input::get('hora_inicio')));
							$sesion->save();
						}else{
							Session::flash('error', 'La fecha de la sesión debe estar comprendido entre las fechas de inicio y fin de la capacitación.');
							return Redirect::to('capacitacion/show_fecha_sesion/'.$id_sesion);
						}			

					Session::flash('message', 'Se edito correctamente la fecha de la sesión.');
					return Redirect::to('capacitacion/show_fecha_sesion/'.$id_sesion);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function show_info_personal($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				$data["personal"] = PersonalCapacitacion::find($id); 
				$data["id_capacitacion"] = $data["personal"]->id_capacitacion;
				$data["personal"]->nombre_area = Servicio::find($data["personal"]->id_servicio)->departamento->nombre;
				$data["personal"]->nombre_servicio = Servicio::find($data["personal"]->id_servicio)->nombre;
				$data["personal"]->nombre_tipo_documento = TipoDocumento::find($data["personal"]->id_tipodocumento)->nombre;

				return View::make('rrhh.personal_capacitaciones.showInfoPersonal',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function edit_info_personal($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){

				$data["personal"] = PersonalCapacitacion::find($id); 
				$data["id_capacitacion"] = $data["personal"]->id_capacitacion;
				$data["personal"]->id_departamento = Servicio::find($data["personal"]->id_servicio)->departamento->idarea;
				$data["departamentos"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipos_documentos"] = TipoDocumento::lists('nombre','idtipo_documento');
				return View::make('rrhh.personal_capacitaciones.editInfoPersonal',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function update_info_personal($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$id_personal = Input::get('id_personal');
				$id_capacitacion = Input::get('id_capacitacion');

				$rules = array(
					'nombre' => 'required|alpha_spaces',
					'apellidos' => 'required|alpha_spaces',
					'departamento' => 'required',
					'servicio_clinico' => 'required',
					'tipo_documento' => 'required',
					'numero_documento' => 'required|numeric|unique:personal_capacitaciones,numero_documento,'.$id_personal.',id,id_capacitacion,'.$id_capacitacion,
					'sesiones_asistidas' => 'numeric'
				);
				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('capacitacion/edit_info_personal/'.$id_personal)->withErrors($validator)->withInput(Input::all());					
				}else{
						
						$personal = PersonalCapacitacion::find($id_personal);
						$capacitacion = Capacitacion::find($personal->id_capacitacion);
						$personal->nombre = Input::get('nombre');
						$personal->apellidos = Input::get('apellidos');
						$personal->id_servicio = Input::get('servicio_clinico');
						$personal->id_tipodocumento = Input::get('tipo_documento');
						$personal->numero_documento = Input::get('numero_documento');

						$sesiones_asistidas = Input::get('sesiones_asistidas');
						$numero_sesiones = Capacitacion::find($personal->id_capacitacion)->numero_sesiones;
						if($sesiones_asistidas > $numero_sesiones){
							Session::flash('error', 'La cantidad de sesiones asistidas excede del número de sesiones totales.');
							return Redirect::to('capacitacion/edit_info_personal/'.$id_personal);
						}
						$personal->sesiones_asistidas = $sesiones_asistidas;

						if (Input::hasFile('archivo')) {
					        $archivo            = Input::file('archivo');
					        $rutaDestino = 'uploads/documentos/rrhh/Capacitaciones/' . $capacitacion->codigo.'/Personal Asistente/'. $personal->apellidos.' '.$personal->nombre .'/Certificado/';
					        $nombreArchivo        = $archivo->getClientOriginalName();
					        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
					        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
					    	if(!$personal->nombre_archivo == null){				    	
					    		$rutaArchivoEliminar = $personal->url.$personal->nombre_archivo_encriptado;
						        if(File::exists($rutaArchivoEliminar))
						            File::delete($rutaArchivoEliminar);
					    	}
					    	$personal->nombre_archivo = $nombreArchivo;
							$personal->nombre_archivo_encriptado = $nombreArchivoEncriptado;
							$personal->url = $rutaDestino;
					    }

						$personal->save();

					Session::flash('message', 'Se edito correctamente la información del personal.');
					return Redirect::to('capacitacion/show_info_personal/'.$id_personal);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function downloadCertificado ($idPersonal=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$personal = PersonalCapacitacion::find($idPersonal);
				$rutaDestino = $personal->url.$personal->nombre_archivo_encriptado;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($personal->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

}


