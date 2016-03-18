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
				

				if($acuerdo_convenio != null)
				{
					$acuerdo_convenio->delete();
					return Redirect::to('acuerdo_convenio/index');
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


}
