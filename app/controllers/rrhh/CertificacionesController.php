<?php

class CertificacionesController extends BaseController {

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

				return View::make('rrhh/certificaciones_capacitaciones/index',$data);
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
				
				return View::make('rrhh.certificaciones_capacitaciones.index',$data);
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
				return View::make('rrhh.certificaciones_capacitaciones.showCapacitacion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
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
				return View::make('rrhh.certificaciones_capacitaciones.showPersonal',$data);
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

				return View::make('rrhh.certificaciones_capacitaciones.showInfoPersonal',$data);
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
				return View::make('rrhh.certificaciones_capacitaciones.editInfoPersonal',$data);
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
					'sesiones_asistidas' => 'required'
					
				);
				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('certificacion/edit_info_personal/'.$id_personal)->withErrors($validator)->withInput(Input::all());					
				}else{
						
						$personal = PersonalCapacitacion::find($id_personal);
						$capacitacion = Capacitacion::find($personal->id_capacitacion);
						$sesiones_asistidas = Input::get('sesiones_asistidas');
						$numero_sesiones = Capacitacion::find($personal->id_capacitacion)->numero_sesiones;
						if($sesiones_asistidas > $numero_sesiones){
							Session::flash('error', 'La cantidad de sesiones asistidas excede del número de sesiones totales.');
							return Redirect::to('certificacion/edit_info_personal/'.$id_personal);
						}
						$personal->sesiones_asistidas = $sesiones_asistidas;
						
						$personal->save();

					Session::flash('message', 'Se edito correctamente la información del personal.');
					return Redirect::to('certificacion/show_info_personal/'.$id_personal);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function edit_certificado_personal($id=null){
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
				return View::make('rrhh.certificaciones_capacitaciones.editCertificadoPersonal',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function update_certificado_personal($id=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			$dimensiones = Dimension::all()->count();
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$id_personal = Input::get('id_personal');
				$id_capacitacion = Input::get('id_capacitacion');

				$rules = array();

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('certificacion/show_personal/'.$id_capacitacion)->withErrors($validator)->withInput(Input::all());					
				}else{
						
						$personal = PersonalCapacitacion::find($id_personal);
						$capacitacion = Capacitacion::find($personal->id_capacitacion);
						

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
					return Redirect::to('certificacion/show_personal/'.$id_capacitacion);
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


