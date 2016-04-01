<?php

class OfertaEvaluadaExpedienteController extends BaseController {

	public function render_edit_oferta_evaluada_expediente($idoferta_expediente=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $idoferta_expediente){
				$data["oferta_expediente_data"] = OfertaExpediente::withTrashed()->find($idoferta_expediente);
				$data["expediente_tecnico_data"] = ExpedienteTecnico::withTrashed()->find($data["oferta_expediente_data"]->idexpediente_tecnico);
				if($data["user"]->id == $data["expediente_tecnico_data"]->idpresidente)
			    	$data["tipo_miembro"] = "Presidente";//Presidente
			    if($data["user"]->id == $data["expediente_tecnico_data"]->idmiembro1)
			    	$data["tipo_miembro"] = "Miembro 1";//Miembro1
			    if($data["user"]->id == $data["expediente_tecnico_data"]->idmiembro2)
			    	$data["tipo_miembro"] = "Miembro 2";//Miembro2
			    if($data["user"]->id == $data["expediente_tecnico_data"]->idmiembro3)
			    	$data["tipo_miembro"] = "Miembro 3";//Miembro3
				$data["oferta_evaluada_expediente_data"] = OfertaEvaluadaExpediente::getOfertaEvaluadaExpedientePorUsuario($idoferta_expediente,$data["user"]->id)->get();
				if($data["oferta_evaluada_expediente_data"]->isEmpty())
					$data["oferta_evaluada_expediente_data"] = null;
				else
					$data["oferta_evaluada_expediente_data"] = $data["oferta_evaluada_expediente_data"][0];
				
				return View::make('oferta_evaluada_expediente/editOfertaEvaluadaExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_oferta_evaluada_expediente()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'evaluacion' => 'Evaluación',
					'archivo' => 'Archivo Adjunto',
				);

				$messages = array();

				$rules = array(	
					'evaluacion' => 'required|max:500',
					'archivo' => 'max:15360',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$url = "oferta_evaluada_expediente/edit_oferta_evaluada_expediente"."/".Input::get('idoferta_expediente');
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{		
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


					$oferta_evaluada_expediente = OfertaEvaluadaExpediente::getOfertaEvaluadaExpedientePorUsuario(Input::get('idoferta_expediente'),$data["user"]->id)->get();	

					if($oferta_evaluada_expediente->isEmpty()){
						$oferta_evaluada_expediente = new OfertaEvaluadaExpediente;
						$oferta_evaluada_expediente->idoferta_expediente = Input::get('idoferta_expediente');
						$oferta_evaluada_expediente->iduser = $data["user"]->id;
						$oferta_evaluada_expediente->tipo_miembro = $tipo_miembro;
					    $oferta_evaluada_expediente->evaluacion = Input::get('evaluacion');
					    if (Input::hasFile('archivo')) {
					        $archivo = Input::file('archivo');
					        $rutaDestino = 'uploads/documentos/adquisicion/oferta_evaluada/';
					        $nombre_archivo = $archivo->getClientOriginalName();
					        $nombre_archivo_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo, PATHINFO_EXTENSION);
					        $uploadSuccess = $archivo->move($rutaDestino, $nombre_archivo_encriptado);

					        $oferta_evaluada_expediente->url = $rutaDestino;
							$oferta_evaluada_expediente->nombre_archivo = $nombre_archivo;
							$oferta_evaluada_expediente->nombre_archivo_encriptado = $nombre_archivo_encriptado;
						}
						$oferta_evaluada_expediente->save();
					}else{
						$oferta_evaluada_expediente = OfertaEvaluadaExpediente::getOfertaEvaluadaExpedientePorUsuario(Input::get('idoferta_expediente'),$data["user"]->id)->get()[0];
						if (Input::hasFile('archivo')) {
					        $archivo = Input::file('archivo');
					        $rutaDestino = 'uploads/documentos/adquisicion/oferta_evaluada/';
					        $nombre_archivo = $archivo->getClientOriginalName();
					        $nombre_archivo_encriptado = Str::random(27).'.'.pathinfo($nombre_archivo, PATHINFO_EXTENSION);
					        $uploadSuccess = $archivo->move($rutaDestino, $nombre_archivo_encriptado);
					    
						    $rutaArchivoEliminar = $oferta_evaluada_expediente->url.$oferta_evaluada_expediente->nombre_archivo_encriptado;
					        if(File::exists($rutaArchivoEliminar))
					            File::delete($rutaArchivoEliminar);

					        $oferta_evaluada_expediente->url = $rutaDestino;
							$oferta_evaluada_expediente->nombre_archivo = $nombre_archivo;
							$oferta_evaluada_expediente->nombre_archivo_encriptado = $nombre_archivo_encriptado;
					    }

					    $oferta_evaluada_expediente->evaluacion = Input::get('evaluacion');
						$oferta_evaluada_expediente->save();		
					}
					Session::flash('message', 'Se registró correctamente la Evaluación de la Oferta.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_oferta_evaluada_expedientes()
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
				$data["ofertas_evaluada_expediente_data"] = OfertaEvaluadaExpediente::getOfertaEvaluadaExpedienteInfo()->paginate(10);	
				return View::make('oferta_evaluada_expediente/listOfertaEvaluadaExpediente',$data);
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
				$oferta_evaluada_expediente = OfertaEvaluadaExpediente::find($id);
				$file= $oferta_evaluada_expediente->url.$oferta_evaluada_expediente->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($oferta_evaluada_expediente->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_finalizar_evaluacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$expediente_tecnico = ExpedienteTecnico::find(Input::get('idexpediente_tecnico'));
				$expediente_tecnico->estado_evaluacion_ofertas_finalizada = 1;
				$expediente_tecnico->save();
		        return Response::json(array( 'success' => true, 'expediente_tecnico' => $expediente_tecnico),200);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_reabrir_evaluacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$expediente_tecnico = ExpedienteTecnico::find(Input::get('idexpediente_tecnico'));
				$expediente_tecnico->estado_evaluacion_ofertas_finalizada = 0;
				$expediente_tecnico->save();
		        return Response::json(array( 'success' => true, 'expediente_tecnico' => $expediente_tecnico),200);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}