<?php

class RegistroPerfilController extends \BaseController {

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
				
				$data["search_rol"] = null;
				$data["search_dni"] = null;
				$data["search_nombre"] = null;
				$data["search_pais"] = null;
				
				$data["roles"] = [0=>'Docente',1=>'Investigador',2=>'Interno'];
				$data["paises"] = Pais::all()->lists('nombre','id');

				$data["perfiles_data"] = Perfil::withTrashed()->paginate(10);
				
				return View::make('rrhh.registro_perfiles.index',$data);
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

				$data["search_rol"] = Input::get("search_rol");
				$data["search_dni"] = Input::get("search_dni");
				$data["search_nombre"] = Input::get("search_nombre");
				$data["search_pais"] = Input::get("search_pais");
				
				$data["roles"] = [0=>'Docente',1=>'Investigador',2=>'Interno'];
				$data["paises"] = Pais::all()->lists('nombre','id');
				
				$data["perfiles_data"] = Perfil::searchReporte($data['search_rol'],$data['search_dni'],$data['search_nombre'],$data['search_pais']);

				$data["perfiles_data"] = $data["perfiles_data"]->paginate(10);
				
				return View::make('rrhh.registro_perfiles.index',$data);
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

				$data["paises"] = Pais::all()->lists('nombre','id');
				$data["idiomas"] = Idioma::all()->lists('nombre','id');
				$data["roles"] = [0=>'Docente',1=>'Investigador',2=>'Interno'];
				$data["grados"] = [0=>'Bachiller',1=>'Titulado',2=>'Magister',3=>'Doctorado'];
				$data["generos"] = [0=>'Masculino',1=>'Femenino'];
				$data["niveles_idioma"] = [0=>'Basico',1=>'Intermedio',2=>'Avanzado',3=>'Nulo',4=>'Avanzado Superior'];
				$data["formas_idioma"] = [0=>'Estudio Internacional',1=>'Autodidacta',2=>'Software',3=>'Otros'];

				return View::make('rrhh.registro_perfiles.create',$data);
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
		//dd(Input::all());
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'nombres' => 'required',
							'apellido_paterno' =>'required',
							'apellido_materno' =>'required',
							'dni' => 'required',
							'pais_nacimiento' => 'required',
							'genero' => 'required',
							'fecha_nacimiento' => 'required',
							'pais_residencia' => 'required',
							'domicilio' => 'required',
							'telefono' => 'required',
							'celular' => 'required',
							'email' => 'required',
							'web' => 'required',
							'institucion' => 'required',
							'archivos' => 'required',
							'rol' => 'required',
							'fa_grados' => 'required',
							'fc_nombres_capacitacion' => 'required',
							'nombres_idioma' => 'required',
							'archivo' => 'required|max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if(Input::has('fa_grados')){
					if(Input::hasFile('archivos')){
						foreach (Input::file('archivos') as $value) {
							if($value == null){
								Session::flash('error', 'Se necesita llenar todos los adjuntos en Formación Académica.');
								return Redirect::to('registro_perfil/create')->withErrors($validator)->withInput(Input::except('archivos'));
							}
						}	
					}else{
						Session::flash('error', 'Se necesita llenar todos los adjuntos en Formación Académica.');
						return Redirect::to('registro_perfil/create')->withErrors($validator)->withInput(Input::except('archivos'));
					}
					
				}

				if($validator->fails()){
					return Redirect::to('registro_perfil/create')->withErrors($validator)->withInput(Input::except('archivos'));
				}else{
					

					$perfil = new Perfil;
					$perfil->nombres = Input::get('nombres');
					$perfil->apellido_paterno = Input::get('apellido_paterno');
					$perfil->apellido_materno = Input::get('apellido_materno');
					$perfil->dni = Input::get('dni');
					$perfil->id_pais_nacimiento = Input::get('pais_nacimiento');
					$perfil->id_genero = Input::get('genero');
					$perfil->fecha_nacimiento =  date("Y-m-d",strtotime(Input::get('fecha_nacimiento')));
					$perfil->id_pais_residencia = Input::get('pais_residencia');
					$perfil->domicilio = Input::get('domicilio');
					$perfil->telefono = Input::get('telefono');
					$perfil->celular = Input::get('celular');
					$perfil->email = Input::get('email');
					$perfil->web = Input::get('web');
					$perfil->institucion = Input::get('institucion');
					$perfil->id_rol = Input::get('rol');
					$perfil->id_idioma_materno = Input::get('idioma_materno');

					$perfil->save();

					$rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/rrhh/perfiles/'.$perfil->id.'/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						$perfil->nombre_archivo = $nombreArchivo;
						$perfil->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$perfil->url = $rutaDestino;
					}

					$perfil->save();
					
					//Formacion academica
					
					$grados = Input::get('fa_grados');
					$titulos = Input::get('fa_titulos');
					$centros = Input::get('fa_centros');
					$paises = Input::get('fa_paises');
					$fechas_ini = Input::get('fa_fechas_ini');
					$fechas_fin = Input::get('fa_fechas_fin');
					$archivos = Input::file('archivos');
					foreach($grados as $key => $grado){
						$perfil_grado = new PerfilFormacionAcademica;
						$perfil_grado->id_grado = $grado;
						$perfil_grado->titulo = $titulos[$key];
						$perfil_grado->centro = $centros[$key];
						$perfil_grado->id_pais = $paises[$key];
						$perfil_grado->fecha_ini = date("Y-m-d",strtotime($fechas_ini[$key]));
						$perfil_grado->fecha_fin = date("Y-m-d",strtotime($fechas_fin[$key]));
						$perfil_grado->id_perfil = $perfil->id;

						$rutaDestino 	='';
					    $nombreArchivo 	='';	

				        $archivo            		= $archivos[$key];
				        $rutaDestino 				= 'uploads/documentos/rrhh/perfiles/'.$perfil->id.'/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						$perfil_grado->nombre_archivo = $nombreArchivo;
						$perfil_grado->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$perfil_grado->url = $rutaDestino;

						$perfil_grado->save();
					}

					//Formacion Continua
					
					$nombres_capacitacion = Input::get('fc_nombres_capacitacion');
					$fc_centros = Input::get('fc_centros');
					$fc_paises = Input::get('fc_paises');
					foreach($nombres_capacitacion as $key => $nombre){
						$perfil_continua = new PerfilFormacionContinua;
						$perfil_continua->nombre = $nombre;
						$perfil_continua->centro = $fc_centros[$key];
						$perfil_continua->id_pais = $fc_paises[$key];
						$perfil_continua->id_perfil = $perfil->id;

						$perfil_continua->save();
					}

					//Idioma
					
					$nombres_idioma = Input::get('nombres_idioma');
					$lecturas = Input::get('lecturas');
					$conversaciones = Input::get('conversaciones');
					$escrituras = Input::get('escrituras');
					$formas = Input::get('formas');
					foreach($nombres_idioma as $key => $nombre){
						$perfil_idioma = new PerfilIdioma;
						$perfil_idioma->id_nombre = $nombre;
						$perfil_idioma->id_lectura = $lecturas[$key];
						$perfil_idioma->id_conversacion = $conversaciones[$key];
						$perfil_idioma->id_escritura = $escrituras[$key];
						$perfil_idioma->id_forma = $formas[$key];
						$perfil_idioma->id_perfil = $perfil->id;

						$perfil_idioma->save();
					}
					

					Session::flash('message', 'Se registró correctamente el perfil.');
					return Redirect::to('registro_perfil/show/'.$perfil->id);
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

				$data["roles"] = [0=>'Docente',1=>'Investigador',2=>'Interno'];
				$data["grados"] = [0=>'Bachiller',1=>'Titulado',2=>'Magister',3=>'Doctorado'];
				$data["generos"] = [0=>'Masculino',1=>'Femenino'];
				$data["niveles_idioma"] = [0=>'Basico',1=>'Intermedio',2=>'Avanzado',3=>'Nulo',4=>'Avanzado Superior'];
				$data["formas_idioma"] = [0=>'Estudio Internacional',1=>'Autodidacta',2=>'Software',3=>'Otros'];
				$data["perfil"] = Perfil::find($id);

				return View::make('rrhh.registro_perfiles.show',$data);
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
				$data["paises"] = Pais::all()->lists('nombre','id');
				$data["idiomas"] = Idioma::all()->lists('nombre','id');
				$data["roles"] = [0=>'Docente',1=>'Investigador',2=>'Interno'];
				$data["grados"] = [0=>'Bachiller',1=>'Titulado',2=>'Magister',3=>'Doctorado'];
				$data["generos"] = [0=>'Masculino',1=>'Femenino'];
				$data["niveles_idioma"] = [0=>'Basico',1=>'Intermedio',2=>'Avanzado',3=>'Nulo',4=>'Avanzado Superior'];
				$data["formas_idioma"] = [0=>'Estudio Internacional',1=>'Autodidacta',2=>'Software',3=>'Otros'];
				
				$data["perfil"] = Perfil::find($id);

				return View::make('rrhh.registro_perfiles.edit',$data);
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
		//dd(Input::all());
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'nombres' => 'required',
							'apellido_paterno' =>'required',
							'apellido_materno' =>'required',
							'dni' => 'required',
							'pais_nacimiento' => 'required',
							'genero' => 'required',
							'fecha_nacimiento' => 'required',
							'pais_residencia' => 'required',
							'domicilio' => 'required',
							'telefono' => 'required',
							'celular' => 'required',
							'email' => 'required',
							'web' => 'required',
							'institucion' => 'required',
							'rol' => 'required',
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if(Input::has('fa_grados')){
					if(Input::hasFile('archivos')){
						foreach (Input::file('archivos') as $value) {
							if($value == null){
								Session::flash('error', 'Se necesita llenar todos los adjuntos en Formación Académica.');
								return Redirect::to('registro_perfil/edit/'.$id)->withErrors($validator)->withInput(Input::except('archivos'));
							}
						}	
					}else{
						Session::flash('error', 'Se necesita llenar todos los adjuntos en Formación Académica.');
						return Redirect::to('registro_perfil/edit/'.$id)->withErrors($validator)->withInput(Input::except('archivos'));
					}
					
				}

				if($validator->fails()){
					return Redirect::to('registro_perfil/edit/'.$id)->withErrors($validator)->withInput(Input::except('archivos'));
				}else{
					

					$perfil = Perfil::find($id);
					$perfil->nombres = Input::get('nombres');
					$perfil->apellido_paterno = Input::get('apellido_paterno');
					$perfil->apellido_materno = Input::get('apellido_materno');
					$perfil->dni = Input::get('dni');
					$perfil->id_pais_nacimiento = Input::get('pais_nacimiento');
					$perfil->id_genero = Input::get('genero');
					$perfil->fecha_nacimiento =  date("Y-m-d",strtotime(Input::get('fecha_nacimiento')));
					$perfil->id_pais_residencia = Input::get('pais_residencia');
					$perfil->domicilio = Input::get('domicilio');
					$perfil->telefono = Input::get('telefono');
					$perfil->celular = Input::get('celular');
					$perfil->email = Input::get('email');
					$perfil->web = Input::get('web');
					$perfil->institucion = Input::get('institucion');
					$perfil->id_rol = Input::get('rol');
					$perfil->id_idioma_materno = Input::get('idioma_materno');

					$perfil->save();

					$rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/rrhh/perfiles/'.$perfil->id.'/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						$perfil->nombre_archivo = $nombreArchivo;
						$perfil->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$perfil->url = $rutaDestino;
					}

					$perfil->save();
					
					//Formacion academica
					
					$grados = Input::get('fa_grados');
					$titulos = Input::get('fa_titulos');
					$centros = Input::get('fa_centros');
					$paises = Input::get('fa_paises');
					$fechas_ini = Input::get('fa_fechas_ini');
					$fechas_fin = Input::get('fa_fechas_fin');
					$archivos = Input::file('archivos');
					if($grados){
						foreach($grados as $key => $grado){
							$perfil_grado = new PerfilFormacionAcademica;
							$perfil_grado->id_grado = $grado;
							$perfil_grado->titulo = $titulos[$key];
							$perfil_grado->centro = $centros[$key];
							$perfil_grado->id_pais = $paises[$key];
							$perfil_grado->fecha_ini = date("Y-m-d",strtotime($fechas_ini[$key]));
							$perfil_grado->fecha_fin = date("Y-m-d",strtotime($fechas_fin[$key]));
							$perfil_grado->id_perfil = $perfil->id;

							$rutaDestino 	='';
						    $nombreArchivo 	='';	

					        $archivo            		= $archivos[$key];
					        $rutaDestino 				= 'uploads/documentos/rrhh/perfiles/'.$perfil->id.'/';
					        $nombreArchivo        		= $archivo->getClientOriginalName();
					        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
					        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
							$perfil_grado->nombre_archivo = $nombreArchivo;
							$perfil_grado->nombre_archivo_encriptado = $nombreArchivoEncriptado;
							$perfil_grado->url = $rutaDestino;

							$perfil_grado->save();
						}
					}

					//Formacion Continua
					
					$nombres_capacitacion = Input::get('fc_nombres_capacitacion');
					$fc_centros = Input::get('fc_centros');
					$fc_paises = Input::get('fc_paises');
					if($nombres_capacitacion){
						foreach($nombres_capacitacion as $key => $nombre){
							$perfil_continua = new PerfilFormacionContinua;
							$perfil_continua->nombre = $nombre;
							$perfil_continua->centro = $fc_centros[$key];
							$perfil_continua->id_pais = $fc_paises[$key];
							$perfil_continua->id_perfil = $perfil->id;

							$perfil_continua->save();
						}
					}

					//Idioma
					
					$nombres_idioma = Input::get('nombres_idioma');
					$lecturas = Input::get('lecturas');
					$conversaciones = Input::get('conversaciones');
					$escrituras = Input::get('escrituras');
					$formas = Input::get('formas');
					if($nombres_idioma){
						foreach($nombres_idioma as $key => $nombre){
							$perfil_idioma = new PerfilIdioma;
							$perfil_idioma->id_nombre = $nombre;
							$perfil_idioma->id_lectura = $lecturas[$key];
							$perfil_idioma->id_conversacion = $conversaciones[$key];
							$perfil_idioma->id_escritura = $escrituras[$key];
							$perfil_idioma->id_forma = $formas[$key];
							$perfil_idioma->id_perfil = $perfil->id;

							$perfil_idioma->save();
						}
					}
					

					Session::flash('message', 'Se editó correctamente el perfil.');
					return Redirect::to('registro_perfil/show/'.$id);
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
				$plan = Perfil::find($id);
				$rutaDestino = $plan->url.$plan->nombre_archivo_encriptado;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($plan->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function downloadFormacion($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12){
				$plan = PerfilFormacionAcademica::find($id);
				$rutaDestino = $plan->url.$plan->nombre_archivo_encriptado;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($plan->nombre_archivo),$headers);
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
	public function editAcademica($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["grados"] = [0=>'Bachiller',1=>'Titulado',2=>'Magister',3=>'Doctorado'];
				$data["paises"] = Pais::all()->lists('nombre','id');
				$data["academica"] = PerfilFormacionAcademica::find($id);

				return View::make('rrhh.registro_perfiles.editAcademica',$data);
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
	public function updateAcademica($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'fa_grado' => 'required',
							'fa_nombre_grado' => 'required',
							'fa_centro_estudios' => 'required',
							'fa_pais_estudios' => 'required',
							'fa_fecha_inicio' => 'required',
							'fa_fecha_fin' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('academica/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$academica = PerfilFormacionAcademica::find($id);
					$academica->id_grado = Input::get('fa_grado');
					$academica->titulo = Input::get('fa_nombre_grado');
					$academica->centro = Input::get('fa_centro_estudios');
					$academica->id_pais = Input::get('fa_pais_estudios');
					$academica->fecha_ini = date("Y-m-d",strtotime(Input::get('fa_fecha_inicio')));
					$academica->fecha_fin = date("Y-m-d",strtotime(Input::get('fa_fecha_fin')));

					if(Input::hasFile('archivo')){
						$rutaDestino 	='';
					    $nombreArchivo 	='';	

				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/rrhh/perfiles/'.$academica->id_perfil.'/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						$academica->nombre_archivo = $nombreArchivo;
						$academica->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$academica->url = $rutaDestino;
					}

					$academica->save();
					
					Session::flash('message', 'Se modificó correctamente la formación.');
					return Redirect::to('registro_perfil/academica/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function destroyAcademica($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$formacion = PerfilFormacionAcademica::find($id);
				$url = "registro_perfil/edit/".$formacion->id_perfil;
				$formacion->delete();
				Session::flash('message','Se borro correctamente la formación.');					
				return Redirect::to($url);
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
	public function editContinua($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["paises"] = Pais::all()->lists('nombre','id');
				$data["continua"] = PerfilFormacionContinua::find($id);

				return View::make('rrhh.registro_perfiles.editContinua',$data);
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
	public function updateContinua($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'fc_nombre_capacitacion' => 'required',
							'fc_centro_estudios' => 'required',
							'fc_pais_estudios' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('registro_perfil/continua/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$continua = PerfilFormacionContinua::find($id);
					$continua->nombre = Input::get('fc_nombre_capacitacion');
					$continua->centro = Input::get('fc_centro_estudios');
					$continua->id_pais = Input::get('fc_pais_estudios');

					$continua->save();
					
					Session::flash('message', 'Se modificó correctamente la formación.');
					return Redirect::to('registro_perfil/continua/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function destroyContinua($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$formacion = PerfilFormacionContinua::find($id);
				$url = "registro_perfil/edit/".$formacion->id_perfil;
				$formacion->delete();
				Session::flash('message','Se borro correctamente la formación.');					
				return Redirect::to($url);
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
	public function editIdioma($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$data["idiomas"] = Idioma::all()->lists('nombre','id');
				$data["niveles_idioma"] = [0=>'Basico',1=>'Intermedio',2=>'Avanzado',3=>'Nulo',4=>'Avanzado Superior'];
				$data["formas_idioma"] = [0=>'Estudio Internacional',1=>'Autodidacta',2=>'Software',3=>'Otros'];

				$data["idioma"] = PerfilIdioma::find($id);

				return View::make('rrhh.registro_perfiles.editIdioma',$data);
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
	public function updateIdioma($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'nombre_idioma' => 'required',
							'lectura' => 'required',
							'conversacion' => 'required',
							'escritura' => 'required',
							'forma_aprendizaje' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('registro_perfil/idioma/edit/'.$id)->withErrors($validator)->withInput(Input::all());					
				}else{

					$idioma = PerfilIdioma::find($id);
					$idioma->id_nombre = Input::get('nombre_idioma');
					$idioma->id_lectura = Input::get('lectura');
					$idioma->id_conversacion = Input::get('conversacion');
					$idioma->id_escritura = Input::get('escritura');
					$idioma->id_forma = Input::get('forma_aprendizaje');

					$idioma->save();
					
					Session::flash('message', 'Se modificó correctamente la formación.');
					return Redirect::to('registro_perfil/idioma/edit/'.$id);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function destroyIdioma($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$formacion = PerfilIdioma::find($id);
				$url = "registro_perfil/edit/".$formacion->id_perfil;
				$formacion->delete();
				Session::flash('message','Se borro correctamente el idioma.');					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}


