<?php

class OfertaExpedienteController extends BaseController {

	public function render_create_oferta_expediente($idexpediente_tecnico=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$data["last_oferta_por_expediente"] = OfertaExpediente::getMaximoCorrelativoPorExpediente($idexpediente_tecnico)->first();
				$data["expediente_tecnico_data"] = ExpedienteTecnico::withTrashed()->find($idexpediente_tecnico);
				$data["proveedores"] = Proveedor::orderBy('razon_social','asc')->lists('razon_social','idproveedor');
				return View::make('oferta_expediente/createOfertaExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_oferta_expediente()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'idproveedor' => 'Proveedor',
					'precio' => 'Precio',
					'caracteristicas' => 'Características Principales',
					'archivo' => 'Archivo adjunto',
				);

				$messages = array();

				$rules = array(	
					'idproveedor' => 'required',
					'precio' => 'required|numeric',
					'caracteristicas' => 'required|max:255',
					'archivo' => 'required|max:15360',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('oferta_expediente/create_oferta_expediente/'.Input::get('idexpediente_tecnico'))->withErrors($validator)->withInput(Input::all());
				}else{
					if (Input::hasFile('archivo')) {
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/adquisicion/oferta/';
				        $nombre_archivo = $archivo->getClientOriginalName();
				        $nombre_archivo_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombre_archivo_encriptado);
				    }

			    	$oferta_expediente = new OfertaExpediente;
			    	$oferta_expediente->correlativo_por_expediente = Input::get('correlativo');
			    	$oferta_expediente->idexpediente_tecnico = Input::get('idexpediente_tecnico');
			    	$oferta_expediente->idproveedor = Input::get('idproveedor');
			    	$oferta_expediente->precio = Input::get('precio');
			    	$oferta_expediente->caracteristicas = Input::get('caracteristicas');
			    	$oferta_expediente->url = $rutaDestino;
					$oferta_expediente->nombre_archivo = $nombre_archivo;
					$oferta_expediente->nombre_archivo_encriptado = $nombre_archivo_encriptado;
					$oferta_expediente->save();
					
					Session::flash('message', 'Se registró correctamente la Oferta.');				
					return Redirect::to('oferta_expediente/list_oferta_expedientes');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_oferta_expediente($idoferta_expediente=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $idoferta_expediente){
				$data["oferta_expediente_data"] = OfertaExpediente::withTrashed()->find($idoferta_expediente);
				$data["expediente_tecnico_data"] = ExpedienteTecnico::withTrashed()->find($data["oferta_expediente_data"]->idexpediente_tecnico);
				$data["proveedores"] = Proveedor::orderBy('razon_social','asc')->lists('razon_social','idproveedor');				
				return View::make('oferta_expediente/editOfertaExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_oferta_expediente()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'idproveedor' => 'Proveedor',
					'precio' => 'Precio',
					'caracteristicas' => 'Características Principales',
					'archivo' => 'Archivo Adjunto',
				);

				$messages = array();

				$rules = array(	
					'idproveedor' => 'required',
					'precio' => 'required|numeric',
					'caracteristicas' => 'required|max:255',
					'archivo' => 'max:15360',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$url = "oferta_expediente/edit_oferta_expediente"."/".Input::get('idoferta_expediente');
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{					
					$oferta_expediente = OfertaExpediente::withTrashed()->find(Input::get('idoferta_expediente'));
					if (Input::hasFile('archivo')) {
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/adquisicion/oferta/';
				        $nombre_archivo = $archivo->getClientOriginalName();
				        $nombre_archivo_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombre_archivo_encriptado);
				    
					    $rutaArchivoEliminar = $oferta_expediente->url.$oferta_expediente->nombre_archivo_encriptado;
				        if(File::exists($rutaArchivoEliminar))
				            File::delete($rutaArchivoEliminar);

				        $oferta_expediente->url = $rutaDestino;
						$oferta_expediente->nombre_archivo = $nombre_archivo;
						$oferta_expediente->nombre_archivo_encriptado = $nombre_archivo_encriptado;
				    }
			    	$oferta_expediente->idproveedor = Input::get('idproveedor');
			    	$oferta_expediente->precio = Input::get('precio');
			    	$oferta_expediente->caracteristicas = Input::get('caracteristicas');
					$oferta_expediente->save();

					Session::flash('message', 'Se editó correctamente la Oferta.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_oferta_expedientes()
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
				$data["ofertas_expediente_data"] = OfertaExpediente::getOfertaExpedienteInfo()->paginate(10);	
				return View::make('oferta_expediente/listOfertaExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_oferta_expediente()
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
				$data["ofertas_expediente_data"] = OfertaExpediente::searchOfertaExpediente($data["search_codigo_compra"],$data["search_usuario"],$data["search_area"],$data["search_servicio"],
					$data["search_fecha_ini"],$data["search_fecha_fin"])->paginate(10);	
				return View::make('oferta_expediente/listOfertaExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_oferta_expediente($idoferta_expediente=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12  ) && $idoferta_expediente){
				$data["oferta_expediente_data"] = OfertaExpediente::withTrashed()->find($idoferta_expediente);
				$data["expediente_tecnico_data"] = ExpedienteTecnico::withTrashed()->find($data["oferta_expediente_data"]->idexpediente_tecnico);
				$data["proveedores"] = Proveedor::orderBy('razon_social','asc')->lists('razon_social','idproveedor');							
				return View::make('oferta_expediente/viewOfertaExpediente',$data);
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
				$oferta_expediente = OfertaExpediente::find($id);
				$file= $oferta_expediente->url.$oferta_expediente->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($oferta_expediente->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}