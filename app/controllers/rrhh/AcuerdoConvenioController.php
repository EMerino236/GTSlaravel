<?php

class AcuerdoConvenioController extends \BaseController {

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
				$data["search_nombre_convenio"]= null;
				$data["search_duracion_convenio"]=null;
				$data["fecha_ini_firma_convenio"]=null;
				$data["fecha_fin_firma_convenio"]=null;
				
				$data["row_number"] = 10;

				$data["acuerdos_convenios"] = AcuerdoConvenio::paginate($data["row_number"]);
				return View::make('rrhh/acuerdos_convenios/index',$data);
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

	public function search()
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)
			{
				$data["search_nombre_convenio"]= Input::get('search_nombre_convenio');
				$data["search_duracion_convenio"]=Input::get('search_duracion_convenio');
				$data["fecha_ini_firma_convenio"]=Input::get('fecha_ini_firma_convenio');
				$data["fecha_fin_firma_convenio"]=Input::get('fecha_fin_firma_convenio');
				
				$data["row_number"] = 10;

				$data["acuerdos_convenios"] = AcuerdoConvenio::searchAcuerdoConvenio($data["search_nombre_convenio"],$data["search_duracion_convenio"],$data["fecha_ini_firma_convenio"],$data["fecha_fin_firma_convenio"])->paginate($data["row_number"]);
				return View::make('rrhh/acuerdos_convenios/index',$data);
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
				return View::make('rrhh/acuerdos_convenios/create',$data);
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
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$attributes=array(
					'nombre_convenio' => 'Nombre del Convenio',
					'fecha_firma_convenio' => 'Fecha de Firma del Convenio',
					'duracion_convenio' => 'Duración del Convenio',
					'descripcion_convenio' => 'Descripción del Convenio',
					'objetivo_convenio' => 'Objetivo del Convenio',
					'archivo' => 'Documento del Convenio'
					);

				$messages=array(
					);

				$rules = array(
					'nombre_convenio' => 'required|max:200',
					'fecha_firma_convenio' => 'required',
					'duracion_convenio' => 'required|numeric',
					'descripcion_convenio' => 'required|max:200',
					'objetivo_convenio' => 'required|max:200',									
					'archivo' => 'required'				
					);

				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){
					return Redirect::to('acuerdo_convenio/create')->withErrors($validator)->withInput(Input::all());
				}else{

					$acuerdo_convenio = new AcuerdoConvenio;
					$acuerdo_convenio->nombre = Input::get('nombre_convenio');
					$acuerdo_convenio->fechafirma = date('Y-m-d',strtotime(Input::get('fecha_firma_convenio')));
					$acuerdo_convenio->duracion = Input::get('duracion_convenio');
					$acuerdo_convenio->descripcion = Input::get('descripcion_convenio');
					$acuerdo_convenio->objetivo = Input::get('objetivo_convenio');
					

					if(Input::hasFile('archivo'))
					{
						$archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/RRHH/Acuerdo y Convenio/';
				        $nombreArchivo = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);						
						
						$acuerdo_convenio->nombre_archivo = $nombreArchivo;
						$acuerdo_convenio->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$acuerdo_convenio->url = $rutaDestino;
					}

					$acuerdo_convenio->save();

					$id = $acuerdo_convenio->id;

					$instituciones =Input::get('instituciones');
					$size = count($instituciones);

					for($i=0 ;$i < $size ;$i++)
					{
						$institucion_acuerdo_convenio = new InstitucionAcuerdoConvenio;
						$institucion_acuerdo_convenio->nombre = $instituciones[$i];										
						$institucion_acuerdo_convenio->idacuerdo_convenio = $id;	
						$institucion_acuerdo_convenio->save();

					}

					$representantes_nombre = Input::get('representantes_nombre');
					$representantes_appat =	Input::get('representantes_appat');
					$representantes_apmat = Input::get('representantes_apmat');
					$representantes_area = Input::get('representantes_area');
					$representantes_rol	= Input::get('representantes_rol');
					$size2 = count($representantes_nombre);

					for($j=0 ;$j < $size2 ;$j++)
					{
						$representante_acuerdos_convenios = new RepresentanteAcuerdoConvenio;
						$representante_acuerdos_convenios->nombre = $representantes_nombre[$j];
						$representante_acuerdos_convenios->ap_paterno = $representantes_appat[$j];
						$representante_acuerdos_convenios->ap_materno = $representantes_apmat[$j];
						$representante_acuerdos_convenios->area = $representantes_area[$j];
						$representante_acuerdos_convenios->rol = $representantes_rol[$j];										
						$representante_acuerdos_convenios->idacuerdo_convenio = $id;	
						$representante_acuerdos_convenios->save();

					}

					$representantes_institucional = Input::get('representantes_institucional');
					$size3 = count($representantes_institucional);
					for($k=0 ;$k < $size3 ;$k++)
					{
						$user_acuerdos_convenios = new UserAcuerdoConvenio;
						$user_acuerdos_convenios->iduser = $representantes_institucional[$k];																
						$user_acuerdos_convenios->idacuerdo_convenio = $id;	
						$user_acuerdos_convenios->save();

					}

					return Redirect::to('acuerdo_convenio/index')->with('message', 'Se registró correctamente el Convenio.');
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
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 && $id)
			{
				$data["acuerdo_convenio"] = AcuerdoConvenio::find($id);
				$data["instituciones"] = InstitucionAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->get();
				$data["reprsentantes_institucionales"] = UserAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->get();
				$data["representantes_convenio"] = RepresentanteAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->get();

				if($data["acuerdo_convenio"] == null)
					return Redirect::to('acuerdo_convenio/index');

				return View::make('rrhh/acuerdos_convenios/show',$data);
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

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 && $id)
			{
				$data["acuerdo_convenio"] = AcuerdoConvenio::find($id);
				$data["instituciones"] = InstitucionAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->get();
				$data["representantes_institucionales"] = UserAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->get();
				$data["representantes_convenio"] = RepresentanteAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->get();

				if($data["acuerdo_convenio"] == null)
					return Redirect::to('acuerdo_convenio/index');

				return View::make('rrhh/acuerdos_convenios/edit',$data);
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
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

				$attributes=array(
					'nombre_convenio' => 'Nombre del Convenio',
					'fecha_firma_convenio' => 'Fecha de Firma del Convenio',
					'duracion_convenio' => 'Duración del Convenio',
					'descripcion_convenio' => 'Descripción del Convenio',
					'objetivo_convenio' => 'Objetivo del Convenio',
					'archivo' => 'Documento del Convenio'
					);

				$messages=array(
					);

				$rules = array(
					'nombre_convenio' => 'required|max:200',
					'fecha_firma_convenio' => 'required',
					'duracion_convenio' => 'required|numeric',
					'descripcion_convenio' => 'required|max:200',
					'objetivo_convenio' => 'required|max:200',									
					'archivo' => ''				
					);

				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);

				if($validator->fails()){
					return Redirect::to('acuerdo_convenio/edit/'.$id)->withErrors($validator)->withInput(Input::all());
				}else{

					$acuerdo_convenio = AcuerdoConvenio::find($id);
					

					if($acuerdo_convenio == null)
						return Redirect::to('acuerdo_convenio/index');
					
					$acuerdo_convenio->nombre = Input::get('nombre_convenio');
					$acuerdo_convenio->fechafirma = date('Y-m-d',strtotime(Input::get('fecha_firma_convenio')));
					$acuerdo_convenio->duracion = Input::get('duracion_convenio');
					$acuerdo_convenio->descripcion = Input::get('descripcion_convenio');
					$acuerdo_convenio->objetivo = Input::get('objetivo_convenio');
					

					if(Input::hasFile('archivo'))
					{
						$archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/RRHH/Acuerdo y Convenio/';
				        $nombreArchivo = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);						
						
						$acuerdo_convenio->nombre_archivo = $nombreArchivo;
						$acuerdo_convenio->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$acuerdo_convenio->url = $rutaDestino;
					}

					$acuerdo_convenio->save();

					InstitucionAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->forcedelete();					

					$id = $acuerdo_convenio->id;
					$instituciones =Input::get('instituciones');
					$size = count($instituciones);

					for($i=0 ;$i < $size ;$i++)
					{
						$institucion_acuerdo_convenio = new InstitucionAcuerdoConvenio;
						$institucion_acuerdo_convenio->nombre = $instituciones[$i];										
						$institucion_acuerdo_convenio->idacuerdo_convenio = $id;	
						$institucion_acuerdo_convenio->save();

					}

					RepresentanteAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->forcedelete();

					$representantes_nombre = Input::get('representantes_nombre');
					$representantes_appat =	Input::get('representantes_appat');
					$representantes_apmat = Input::get('representantes_apmat');
					$representantes_area = Input::get('representantes_area');
					$representantes_rol	= Input::get('representantes_rol');
					$size2 = count($representantes_nombre);

					for($j=0 ;$j < $size2 ;$j++)
					{
						$representante_acuerdos_convenios = new RepresentanteAcuerdoConvenio;
						$representante_acuerdos_convenios->nombre = $representantes_nombre[$j];
						$representante_acuerdos_convenios->ap_paterno = $representantes_appat[$j];
						$representante_acuerdos_convenios->ap_materno = $representantes_apmat[$j];
						$representante_acuerdos_convenios->area = $representantes_area[$j];
						$representante_acuerdos_convenios->rol = $representantes_rol[$j];										
						$representante_acuerdos_convenios->idacuerdo_convenio = $id;	
						$representante_acuerdos_convenios->save();

					}

					UserAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->forcedelete();

					$representantes_institucional = Input::get('representantes_institucional');					
					$size3 = count($representantes_institucional);
					for($k=0 ;$k < $size3 ;$k++)
					{
						$user_acuerdos_convenios = new UserAcuerdoConvenio;
						$user_acuerdos_convenios->iduser = $representantes_institucional[$k];																
						$user_acuerdos_convenios->idacuerdo_convenio = $id;	
						$user_acuerdos_convenios->save();

					}
					
					return Redirect::to('acuerdo_convenio/index')->with('message', 'Se actualizó correctamente el Convenio.');
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
	public function destroy()
	{
		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"]= Session::get('user');

			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2)
			{
				$id = Input::get("id_acuerdo_convenio");

				$acuerdo_convenio = AcuerdoConvenio::find($id);
				$instituciones = InstitucionAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->get();
				$reprsentantes_institucionales = UserAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->get();
				$representantes_convenio = RepresentanteAcuerdoConvenio::where('idacuerdo_convenio','=',$id)->get();				

				if($acuerdo_convenio != null)
				{
					$acuerdo_convenio->delete();

					foreach ($instituciones as $institucion_data)
					{
						$institucion_data->delete();
					}

					foreach ($reprsentantes_institucionales as $reprsentante_institucional_data)
					{
						$reprsentante_institucional_data->delete();
					}

					foreach ($representantes_convenio as $representante_convenio_data)
					{
						$representante_convenio_data->delete();
					}

				}	

				return Redirect::to('acuerdo_convenio/index');
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

	public function download($id)
	{
		if(Auth::check()){

			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 7 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 ||
				$data["user"]->idrol == 12 && $id )
			{
				$data["acuerdo_convenio"] = AcuerdoConvenio::find($id);

				if($data["acuerdo_convenio"] == null)
					return Redirect::to('acuerdo_convenio/index');

				$rutaDestino = $data["acuerdo_convenio"]->url.$data["acuerdo_convenio"]->nombre_archivo_encriptado;

		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );

		        return Response::download($rutaDestino,basename($data["acuerdo_convenio"]->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function getUserAjax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		$id = Auth::id();

		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');

		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4)
		{			
			$data = Input::get('value');			

			if($data != "")
			{
				$user = User::searchUserByNumDoc($data)->get();								
			}
			else
			{
				$user = array();				
			}

			return Response::json(array( 'success' => true, 'user' => $user),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}


}


