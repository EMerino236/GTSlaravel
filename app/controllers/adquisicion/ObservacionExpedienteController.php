<?php

class ObservacionExpedienteController extends BaseController {

	public function render_create_observacion_expediente($idoferta_expediente=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
			$data["tipo_observacion_expediente"] = TipoObservacionExpediente::lists('nombre','idtipo_observacion_expediente');							
			$data["last_observacion_por_oferta"] = ObservacionExpediente::getMaximoCorrelativoPorOferta($idoferta_expediente)->first();
			$data["oferta_expediente_data"] = OfertaExpediente::withTrashed()->find($idoferta_expediente);			
				return View::make('observacion_expediente/createObservacionExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_observacion_expediente()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'idtipo_observacion_expediente' => 'Tipo de Observación',
					'descripcion' => 'Descripción',
					'archivo' => 'Archivo adjunto',
				);

				$messages = array();

				$rules = array(	
					'idtipo_observacion_expediente' => 'required',
					'descripcion' => 'required|max:255',
					'archivo' => 'required|max:15360',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('observacion_expediente/create_observacion_expediente/'.Input::get('idoferta_expediente'))->withErrors($validator)->withInput(Input::all());
				}else{
					if (Input::hasFile('archivo')) {
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/adquisicion/observacion/';
				        $nombre_archivo = $archivo->getClientOriginalName();
				        $nombre_archivo_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombre_archivo_encriptado);
				    }
				    $oferta_expediente = OfertaExpediente::withTrashed()->find(Input::get('idoferta_expediente'));
				    $expediente_tecnico = ExpedienteTecnico::withTrashed()->find($oferta_expediente->idexpediente_tecnico);
				    if($data["user"]->id == $expediente_tecnico->idpresidente)
				    	$tipo_miembro = 1;//Presidente
				    if($data["user"]->id == $expediente_tecnico->idmiembro1)
				    	$tipo_miembro = 2;//Miembro1
				    if($data["user"]->id == $expediente_tecnico->idmiembro2)
				    	$tipo_miembro = 3;//Miembro2
				    if($data["user"]->id == $expediente_tecnico->idmiembro3)
				    	$tipo_miembro = 4;//Miembro3

			    	$observacion_expediente = new ObservacionExpediente;
			    	$observacion_expediente->correlativo_por_oferta = Input::get('correlativo');
			    	$observacion_expediente->idoferta_expediente = Input::get('idoferta_expediente');
			    	$observacion_expediente->idtipo_observacion_expediente = Input::get('idtipo_observacion_expediente');
			    	$observacion_expediente->descripcion = Input::get('descripcion');
			    	$observacion_expediente->iduser = $data["user"]->id;
			    	$observacion_expediente->tipo_miembro = $tipo_miembro;
			    	$observacion_expediente->url = $rutaDestino;
					$observacion_expediente->nombre_archivo = $nombre_archivo;
					$observacion_expediente->nombre_archivo_encriptado = $nombre_archivo_encriptado;
					$observacion_expediente->save();
					
					Session::flash('message', 'Se registró correctamente la Observación.');				
					return Redirect::to('observacion_expediente/list_observacion_expedientes');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_observacion_expediente($idobservacion_expediente=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $idobservacion_expediente){
				$data["tipo_observacion_expediente"] = TipoObservacionExpediente::lists('nombre','idtipo_observacion_expediente');											
				$data["observacion_expediente_data"] = ObservacionExpediente::withTrashed()->find($idobservacion_expediente);
				$data["oferta_expediente_data"] = OfertaExpediente::withTrashed()->find($data["observacion_expediente_data"]->idoferta_expediente);	
				return View::make('observacion_expediente/editObservacionExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_observacion_expediente()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'idtipo_observacion_expediente' => 'Tipo de Observación',
					'descripcion' => 'Descripción',
					'archivo' => 'Archivo adjunto',
				);

				$messages = array();

				$rules = array(	
					'idtipo_observacion_expediente' => 'required',
					'descripcion' => 'required|max:255',
					'archivo' => 'max:15360',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$url = "observacion_expediente/edit_observacion_expediente"."/".Input::get('idobservacion_expediente');
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{					
					$observacion_expediente = ObservacionExpediente::withTrashed()->find(Input::get('idobservacion_expediente'));
					if (Input::hasFile('archivo')) {
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/adquisicion/observacion/';
				        $nombre_archivo = $archivo->getClientOriginalName();
				        $nombre_archivo_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombre_archivo_encriptado);
				    
					    $rutaArchivoEliminar = $observacion_expediente->url.$observacion_expediente->nombre_archivo_encriptado;
				        if(File::exists($rutaArchivoEliminar))
				            File::delete($rutaArchivoEliminar);

				        $observacion_expediente->url = $rutaDestino;
						$observacion_expediente->nombre_archivo = $nombre_archivo;
						$observacion_expediente->nombre_archivo_encriptado = $nombre_archivo_encriptado;
				    }
			    	$observacion_expediente->idtipo_observacion_expediente = Input::get('idtipo_observacion_expediente');			    	
			    	$observacion_expediente->descripcion = Input::get('descripcion');
					$observacion_expediente->save();

					Session::flash('message', 'Se editó correctamente la Observación.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_observacion_expedientes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				$data["search_codigo_compra"] = null;	
				$data["search_fecha_ini"] = null;			
				$data["search_fecha_fin"] = null;	
				$data["search_usuario"] = null;
				$data["search_area"] = null;
				$data["search_servicio"] = null;
				$data["areas"] = Area::orderBy('nombre','asc')->lists('nombre','idarea');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["observaciones_expediente_data"] = ObservacionExpediente::getObservacionExpedienteInfo()->paginate(10);	
				return View::make('observacion_expediente/listObservacionExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_observacion_expediente()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_codigo_compra"] = Input::get('search_codigo_compra');	
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');			
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');
				$data["search_usuario"] = Input::get('search_usuario');			
				$data["search_area"] = Input::get('search_area');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["areas"] = Area::orderBy('nombre','asc')->lists('nombre','idarea');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["observaciones_expediente_data"] = ObservacionExpediente::searchObservacionExpediente($data["search_codigo_compra"],$data["search_usuario"],$data["search_area"],$data["search_servicio"],
					$data["search_fecha_ini"],$data["search_fecha_fin"])->paginate(10);	
				return View::make('observacion_expediente/listObservacionExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_observacion_expediente($idobservacion_expediente=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12  ) && $idobservacion_expediente){
				$data["tipo_observacion_expediente"] = TipoObservacionExpediente::lists('nombre','idtipo_observacion_expediente');											
				$data["observacion_expediente_data"] = ObservacionExpediente::withTrashed()->find($idobservacion_expediente);
				$data["oferta_expediente_data"] = OfertaExpediente::withTrashed()->find($data["observacion_expediente_data"]->idoferta_expediente);	
				return View::make('observacion_expediente/viewObservacionExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	

	public function download($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$observacion_expediente = ObservacionExpediente::find($id);
				$file= $observacion_expediente->url.$observacion_expediente->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($observacion_expediente->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}