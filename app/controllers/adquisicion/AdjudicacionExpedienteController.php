<?php

class AdjudicacionExpedienteController extends BaseController {

	public function render_edit_adjudicacion_expediente($idexpediente_tecnico=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $idexpediente_tecnico){
				$data["expediente_tecnico_data"] = ExpedienteTecnico::searchExpedienteTecnicoByNumeroExpediente($idexpediente_tecnico)->get()[0];
				$data["proveedores"] = OfertaExpediente::searchProveedorOfertaByNumeroExpediente($idexpediente_tecnico)->get();	
				return View::make('adjudicacion_expediente/editAdjudicacionExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_adjudicacion_expediente()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'idproveedor_ganador' => 'Proveedor',
					'precio_ganador' => 'Precio',
					'archivo_contrato' => 'Archivo Adjunto Contrato',
					'archivo_adicional' => 'Archivo Adjunto Adicional',
				);

				$messages = array();

				$rules = array(	
					'idproveedor_ganador' => 'required',
					'precio_ganador' => 'required|numeric',
					'archivo_contrato' => 'max:15360',
					'archivo_adicional' => 'max:15360',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$url = "adjudicacion_expediente/edit_adjudicacion_expediente"."/".Input::get('idexpediente_tecnico');
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{		
					$expediente_tecnico = ExpedienteTecnico::withTrashed()->find(Input::get('idexpediente_tecnico'));
			    	$expediente_tecnico->idproveedor_ganador = Input::get('idproveedor_ganador');
			    	$expediente_tecnico->precio_ganador = Input::get('precio_ganador');
			    	if (Input::hasFile('archivo_contrato')) {
				        $archivo_contrato = Input::file('archivo_contrato');
				        $rutaDestino_contrato = 'uploads/documentos/adquisicion/contrato/';
				        $nombre_archivo_contrato = $archivo_contrato->getClientOriginalName();
				        $nombre_archivo_encriptado_contrato = Str::random(27).'.'.pathinfo($nombre_archivo_contrato, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo_contrato->move($rutaDestino_contrato, $nombre_archivo_encriptado_contrato);
				    
					    $rutaArchivoEliminar = $expediente_tecnico->url_contrato.$expediente_tecnico->nombre_archivo_encriptado_contrato;
				        if(File::exists($rutaArchivoEliminar))
				            File::delete($rutaArchivoEliminar);

				        $expediente_tecnico->url_contrato = $rutaDestino_contrato;
						$expediente_tecnico->nombre_archivo_contrato = $nombre_archivo_contrato;
						$expediente_tecnico->nombre_archivo_encriptado_contrato = $nombre_archivo_encriptado_contrato;

						$documento_contrato = new Documento;
						$documento_contrato->nombre = $nombre_archivo_contrato;
						$documento_contrato->autor = '';
						$documento_contrato->codigo_archivamiento = $expediente_tecnico->codigo_archivamiento;
						$documento_contrato->ubicacion = '';
						$documento_contrato->idtipo_documento = 1;
						$documento_contrato->idestado = 1;
						$documento_contrato->url = $rutaDestino_contrato;
						$documento_contrato->nombre_archivo = $nombre_archivo_contrato;
						$documento_contrato->nombre_archivo_encriptado = $nombre_archivo_encriptado_contrato;
						$documento_contrato->save();
				    }

				    if (Input::hasFile('archivo_adicional')) {
				        $archivo_documento_adicional = Input::file('archivo_adicional');
				        $rutaDestino_documento_adicional = 'uploads/documentos/adquisicion/documento_adicional/';
				        $nombre_archivo_documento_adicional = $archivo_documento_adicional->getClientOriginalName();
				        $nombre_archivo_encriptado_documento_adicional = Str::random(27).'.'.pathinfo($nombre_archivo_documento_adicional, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo_documento_adicional->move($rutaDestino_documento_adicional, $nombre_archivo_encriptado_documento_adicional);
				    
					    $rutaArchivoEliminar = $expediente_tecnico->url_documento_adicional.$expediente_tecnico->nombre_archivo_encriptado_documento_adicional;
				        if(File::exists($rutaArchivoEliminar))
				            File::delete($rutaArchivoEliminar);

				        $expediente_tecnico->url_documento_adicional = $rutaDestino_documento_adicional;
						$expediente_tecnico->nombre_archivo_documento_adicional = $nombre_archivo_documento_adicional;
						$expediente_tecnico->nombre_archivo_encriptado_documento_adicional = $nombre_archivo_encriptado_documento_adicional;
				    }
					$expediente_tecnico->save();

					Session::flash('message', 'Se registró correctamente la Adjudicación y Contrato Firmado.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_adjudicacion_expedientes()
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
				$data["expedientes_tecnico_data"] = ExpedienteTecnico::getExpedienteTecnicoInfo()->paginate(10);
				return View::make('adjudicacion_expediente/listAdjudicacionExpediente',$data);
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

	public function download_contrato($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$expediente_tecnico = ExpedienteTecnico::find($id);
				$file= $expediente_tecnico->url_contrato.$expediente_tecnico->nombre_archivo_encriptado_contrato;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($expediente_tecnico->nombre_archivo_contrato),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function download_documento_adicional($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$expediente_tecnico = ExpedienteTecnico::find($id);
				$file= $expediente_tecnico->url_documento_adicional.$expediente_tecnico->nombre_archivo_encriptado_documento_adicional;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($expediente_tecnico->nombre_archivo_documento_adicional),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function return_nombre_usuario(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$usuario = User::searchPersonalByUsername($data)->get();
			}else{
				$usuario = null;
			}
			return Response::json(array( 'success' => true, 'usuario' => $usuario ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}