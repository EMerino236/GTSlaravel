<?php

class ServiciosClinicosController extends \BaseController {

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
			if(	$data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12){
				
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["usuarios"] = User::all()->lists('UserFullName','id');

				$data["search_codigo"] = null;
				$data["search_servicio"] = null;
				$data["search_usuario"] = null;
				$data["search_nombre"] = null;

				$data["servicios_data"] = DocumentoServicioClinico::withTrashed()->paginate(10);
				
				return View::make('investigacion.servicios_clinicos.index',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function search()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12){

				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["usuarios"] = User::all()->lists('UserFullName','id');

				$data["search_codigo"] = Input::get('search_codigo');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_usuario"] = Input::get('search_usuario');
				$data["search_nombre"] = Input::get('search_nombre');

				$data["servicios_data"] = DocumentoServicioClinico::searchDocumentos($data["search_codigo"],$data["search_servicio"], $data["search_usuario"], $data["search_nombre"]);

				$data["servicios_data"] = $data["servicios_data"]->paginate(10);

				return View::make('investigacion.servicios_clinicos.index',$data);
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
				$data["usuarios"] = User::all()->lists('UserFullName','id');

				return View::make('investigacion.servicios_clinicos.create',$data);
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
							'servicio' => 'required|max:100',
							'usuario' => 'required|max:200',
							'codigo' => 'required|max:100|unique:documentos_servicios_clinicos',
							'nombre' => 'required|max:100',
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('servicios_clinicos/create')->withErrors($validator)->withInput(Input::all());
				}else{
				    $rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/investigacion/servicios_clinicos/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }

					$documento = new DocumentoServicioClinico;
					$documento->nombre = Input::get('nombre');
					if (Input::hasFile('archivo')) {
						$documento->nombre_archivo = $nombreArchivo;
						$documento->nombre_archivo_encriptado = $nombreArchivoEncriptado;
					}
					$documento->id_servicio = Input::get('servicio');
					$documento->id_usuario = Input::get('usuario');
					$documento->codigo = Input::get('codigo');
					$documento->url = $rutaDestino;
					$documento->id_estado = 1;
					$documento->save();
					Session::flash('message', 'Se registró correctamente el Servicio Clínico.');
					return Redirect::to('servicios_clinicos/create');
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
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $id){
				
				$data["servicios"] = Servicio::all()->lists('nombre','idservicio');
				$data["usuarios"] = User::all()->lists('UserFullName','id');
				$data["documento_info"] = DocumentoServicioClinico::withTrashed()->find($id);
				$data["archivo"] = basename($data["documento_info"]->url);
				
				if(!$data["documento_info"]){
					return Redirect::to('servicios_clinicos/index');
				}
				
				$data["documento_info"] = $data["documento_info"];
				
				return View::make('investigacion.servicios_clinicos.edit',$data);
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
			$iddocumento = $id;
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$rules = array(
							'servicio' => 'required|max:100',
							'usuario' => 'required|max:200',
							'codigo' => 'required|max:100|unique:documentos_servicios_clinicos,codigo,'.$iddocumento.',id',
							'nombre' => 'required|max:100',
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$url = "servicios_clinicos/edit/".$iddocumento;
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{			
					$rutaDestino 	='';
				    $nombreArchivo 	='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            		= Input::file('archivo');
				        $rutaDestino 				= 'uploads/documentos/investigacion/servicios_clinicos/';
				        $nombreArchivo        		= $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado 	= Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess 				= $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }

					$documento = DocumentoServicioClinico::withTrashed()->find($iddocumento);
					if (Input::hasFile('archivo')) {
						$documento->nombre_archivo = $nombreArchivo;
						$documento->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$documento->url = $rutaDestino;
					}
					$documento->id_servicio = Input::get('servicio');
					$documento->id_usuario = Input::get('usuario');
					$documento->codigo = Input::get('codigo');
					$documento->nombre = Input::get('nombre');
					$documento->id_estado = 1;
					$documento->save();
					Session::flash('message', 'Se editó correctamente el documento de servicio clínico.');
					return Redirect::to($url);
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
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$documento_id = $id;
				$url = "servicios_clinicos/edit/".$documento_id;
				$documento = DocumentoServicioClinico::find($documento_id);
				$documento->delete();
				Session::flash('message','Se inhabilitó correctamente el documento.' );					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	/**
	 * Restore the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function restore($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$documento_id = $id;
				$url = "servicios_clinicos/edit/".$documento_id;
				$documento = DocumentoServicioClinico::withTrashed()->find($documento_id);
				$documento->restore();
				Session::flash('message', 'Se habilitó correctamente el documento.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


	public function download($id)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ||
				$data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 12){
				$documento = DocumentoServicioClinico::find($id);
				$rutaDestino = $documento->url.$documento->nombre_archivo_encriptado;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($documento->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}


}
