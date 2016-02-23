<?php

class IpersController extends BaseController
{

	public function list_ipers($tipo=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				
				$data["search_codigo_reporte"] = null;
				$data["search_anho"] = null;
				$data["search_usuario"] = null;
				$data["search_servicio"] = null;
				$data["search_entorno"] = null;
				$data["tipo"] = $tipo;
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["entornos"] = EntornoAsistencial::lists('nombre','id');		
				$data["ipers_data"] = Iper::getIpersInfo($tipo)->distinct()->paginate(10);

				return View::make('riesgos/ipers/listIpers',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_ipers()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				
				$data["search_codigo_reporte"] = Input::get('search_codigo_reporte');;
				$data["search_anho"] = Input::get('search_anho');;
				$data["search_servicio"] = Input::get('search_servicio');;
				$data["search_usuario"] = Input::get('search_usuario');
				$data["search_entorno"] = Input::get('search_entorno');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["entornos"] = EntornoAsistencial::lists('nombre','id');
				$tipo = Input::get('tipo');
				$data["tipo"] = $tipo;
				if($tipo == 1)
					$data["ipers_data"] = Iper::searchIpersTS($data["search_codigo_reporte"],$data["search_anho"],$data["search_usuario"],$data["search_servicio"],1)->distinct()->get();
				else
					$data["ipers_data"] = Iper::searchIpersSO($data["search_codigo_reporte"],$data["search_anho"],$data["search_usuario"],$data["search_entorno"],2)->distinct()->get();

				

				return View::make('riesgos/ipers/listIpers',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_iper($tipo)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){		
				if($tipo == 1)	
					$data["servicios"] = Servicio::lists('nombre','idservicio');
				else
					$data["entornos"] = EntornoAsistencial::lists('nombre','id');
				$data["tipo"] = $tipo;
				$data["periodicidades"] = array('I'=>'Inicial','P'=>'Periodica');
				return View::make('riesgos/ipers/createIper',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_iper()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$tipo = Input::get('tipo');

				$attributes = array(					
					'archivo' => 'Documento Anexo',		
					'fecha' => 'Fecha',
					'servicio' => 'Servicio',
					'entorno' => 'Entorno Asistencial',
 					'periodicidad' => 'Periodicidad',
				);

				$messages = array();

				$rules = array(
					'archivo'  => 'required|max:15360',		
					'fecha' => 'required',
							
				);

				if($tipo == 1){					
					$element_rule = array('servicio' => 'required');					
					$rules += $element_rule;
				}else{					
					$element_rule = array('entorno' => 'required');					
					$rules += $element_rule;
				}
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('ipers/create_iper_ts')->withErrors($validator)->withInput(Input::all());
				}else{
				   
				    $iper = new Iper;
				    $iper->codigo_abreviatura = "IPER";

				    
				    $iper->codigo_correlativo = $this->getCorrelativoIper($tipo);
				    $iper->codigo_anho = date('y');
				    if($tipo == 1){				    	
				   		$iper->codigo_tipo = "TS";
				   		$iper->idservicio = Input::get('servicio');
				   	}else{
				   		$iper->codigo_tipo = "SO";
				   		$iper->identorno_asistencial = Input::get('entorno');
				   	}
				    $iper->idusuario_elaborador = $data["user"]->id;
				    $iper->fecha = date("Y-m-d",strtotime(Input::get('fecha')));
				    $iper->periodicidad = 'I'; //por ser el primer registro
				    $iper->idtipo_iper = $tipo;

				    $iper->save();


				    $rutaDestino ='';
				    $nombreArchivo        ='';	
				    if (Input::hasFile('archivo')) {
				        $archivo            = Input::file('archivo');
				        if($tipo == 1)
				        	$rutaDestino = 'documentos/riesgos/IPER TS/' .$iper->codigo_abreviatura.'-'.$iper->codigo_tipo.'-'.$iper->codigo_correlativo.'-'.$iper->codigo_anho. '/';
				        else
				        	$rutaDestino = 'documentos/riesgos/IPER Salud Ocupacional/' .$iper->codigo_abreviatura.'-'.$iper->codigo_tipo.'-'.$iper->codigo_correlativo.'-'.$iper->codigo_anho. '/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				        
				        $detalle_iper = new DetalleIper;
				    	$detalle_iper->nombre_archivo = $nombreArchivo;
						$detalle_iper->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$detalle_iper->url = $rutaDestino;
						$detalle_iper->idiper = $iper->id;
						$detalle_iper->numero_version = 1; //puesto que es el primero
						$detalle_iper->save();
				    }

					
					Session::flash('message', 'Se registró correctamente el reporte '.$iper->codigo_abreviatura.'-'.$iper->codigo_tipo.'-'.$iper->codigo_correlativo.'-'.$iper->codigo_anho);
					if($tipo == 1)				
						return Redirect::to('ipers/list_ipers/1');
					else
						return Redirect::to('ipers/list_ipers/2');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_iper($tipo=null,$id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $id){
				
				if($tipo == 1)
					$data["servicios"] = Servicio::lists('nombre','idservicio');
				else
					$data["entornos"] = EntornoAsistencial::lists('nombre','id');

				$data["periodicidades"] = array('I'=>'Inicial','P'=>'Periodica');
				$data["tipo"] = $tipo;

				$data["iper_data"] = Iper::getIperById($id,$tipo)->get();
				if($data["iper_data"]->isEmpty()){
					return Redirect::to('ipers/list_ipers/'.$tipo);
				}


				$data["iper_data"] = $data["iper_data"][0];
				$data["detalles_data"] = DetalleIper::getDetallesByIdIper($data["iper_data"]->id)->get();
				
				return View::make('riesgos/ipers/editIperTS',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_iper($tipo=null,$id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $id){
				
				if($tipo == 1)
					$data["servicios"] = Servicio::lists('nombre','idservicio');
				else
					$data["entornos"] = EntornoAsistencial::lists('nombre','id');
				
				$data["periodicidades"] = array('I'=>'Inicial','P'=>'Periodica');
				$data["tipo"] = $tipo;
				$data["iper_data"] = Iper::getIperById($id,$tipo)->get();
				if($data["iper_data"]->isEmpty()){
					return Redirect::to('ipers/list_ipers_ts');
				}
				$data["iper_data"] = $data["iper_data"][0];
				$data["detalles_data"] = DetalleIper::getDetallesByIdIper($data["iper_data"]->id)->get();
				
				return View::make('riesgos/ipers/viewIperTS',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_iper()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$tipo = Input::get('tipo');

				$attributes = array(					
					'archivo' => 'Documento Anexo',		
					'fecha' => 'Fecha',
					'servicio' => 'Servicio',
					'entorno' => 'Entorno Asistencial',
					'periodicidad' => 'Periodicidad',
					'numero_version' => 'Número de Versión'
				);

				$messages = array();

				$rules = array(
					'archivo'  => 'max:15360',		
					'fecha' => 'required',
							
				);

				if($tipo == 1){					
					$element_rule = array('servicio' => 'required');					
					$rules += $element_rule;
				}else{					
					$element_rule = array('entorno' => 'required');					
					$rules += $element_rule;
				}

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$idiper = Input::get('iper_id');
					$url = "ipers/edit_iper"."/".$tipo."/".$idiper;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{

					$idiper = Input::get('iper_id');
					$url = "ipers/edit_iper"."/".$tipo."/".$idiper;

					$iper_data = Iper::getIperById($idiper,$tipo)->get();
					if($iper_data->isEmpty()){
						$url = "ipers/edit_iper"."/".$tipo."/".$idiper;
						return Redirect::to($url);
					}

					
					$iper_data = $iper_data[0];
					$iper_data->periodicidad = Input::get('periodicidad');
					if($tipo == 1)
						$iper_data->idservicio = Input::get('servicio');
					else
						$iper_data->identorno_asistencial = Input::get('entorno');


					$iper_data->fecha = date("Y-m-d",strtotime(Input::get('fecha')));

					

					

					$rutaDestino ='';
				    $nombreArchivo        ='';	
				    


				    if (Input::hasFile('archivo')) {

				    	$version = Input::get('numero_version');
					    $detalle = DetalleIper::getLastDetalle($iper_data->id)->first();
					    
					   
						if($detalle->numero_version >= $version){
					    	Session::flash('error', 'La versión ingresada es menor a la última versión.');
							return Redirect::to($url);
					    }

					   
				        $archivo            = Input::file('archivo');
				        if($tipo == 1)
				        	$rutaDestino = 'documentos/riesgos/IPER TS/' .$iper_data->codigo_abreviatura.'-'.$iper_data->codigo_tipo.'-'.$iper_data->codigo_correlativo.'-'.$iper_data->codigo_anho. '/';
				        else
				        	$rutaDestino = 'documentos/riesgos/IPER Salud Ocupacional/' .$iper_data->codigo_abreviatura.'-'.$iper_data->codigo_tipo.'-'.$iper_data->codigo_correlativo.'-'.$iper_data->codigo_anho. '/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				        
				        $detalle_iper = new DetalleIper;
				    	$detalle_iper->nombre_archivo = $nombreArchivo;
						$detalle_iper->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$detalle_iper->url = $rutaDestino;
						$detalle_iper->idiper = $iper_data->id;
						$detalle_iper->numero_version = $version ; //puesto que es el primero
						$detalle_iper->save();
				    }

				    $iper_data->save();

					Session::flash('message', 'Se editó correctamente el reporte.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function getCorrelativoIper($tipo){
		$iper = Iper::getLastIper($tipo)->first();
		$string = "";
		if($iper!=null){	
			$numero = $iper->codigo_correlativo;
			$cantidad_digitos = strlen($numero+1);						
			for($i=0;$i<4-$cantidad_digitos;$i++){
				$string = $string."0";
			}
			$string = $string.($numero+1);					
		}else{
			$string = "0001";
		}
		return $string;
	}

	public function download_version_iper($idDetalle=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$detalle = DetalleIper::find($idDetalle);
				$rutaDestino = $detalle->url.$detalle->nombre_archivo_encriptado;
		        $headers = array(
		              'Content-Type',mime_content_type($rutaDestino),
		            );
		        return Response::download($rutaDestino,basename($detalle->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_iper()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$iper_id = Input::get('iper_id');
				$tipo = Input::get('tipo');
				$url = "ipers/list_ipers/".$tipo;
				$iper = Iper::find($iper_id);
				$iper->delete();
				Session::flash('message', 'Se inhabilitó correctamente la IPER.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_iper()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$iper_id = Input::get('iper_id');
				$tipo = Input::get('tipo');
				$url = "ipers/list_ipers/".$tipo;
				$iper = Iper::getIperById($iper_id,$tipo)->get();
				if(!$iper->isEmpty()){
					$iper[0]->restore();
				}else{
					Session::flash('error', 'No se pudo habilitar la IPER.');
					return Redirect::to($url);
				}
				
				Session::flash('message', 'Se habilitó correctamente la IPER.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

}