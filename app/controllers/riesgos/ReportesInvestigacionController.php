<?php

class ReportesInvestigacionController extends BaseController
{
	public function list_reportes_investigacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				
				$data["search_codigo_reporte_investigacion"] = null;
				$data["search_codigo_reporte_evento"] = null;
				$data["search_entorno_asistencial"] = null;
				$data["search_usuario"] = null;
				$data["search_fecha_ini"] = null;
				$data["search_fecha_fin"] = null;
				$data["entornos_asistencial"] = EntornoAsistencial::lists('nombre','id');
				$data["reportes_data"] = ReporteInvestigacion::getReportesInfo()->distinct()->paginate(10);
				return View::make('riesgos/reporte_investigacion/listReporteInvestigacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_reporte_investigacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["tipo_documentos"] = TipoDocumentoRiesgos::lists('nombre','id');

				$data["search_codigo_reporte_investigacion"] = Input::get('search_codigo_reporte_investigacion');
				$data["search_codigo_reporte_evento"] = Input::get('search_codigo_reporte_evento');
				$data["search_entorno_asistencial"] = Input::get('search_entorno_asistencial');
				$data["search_usuario"] = Input::get('search_usuario');
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');
				$data["entornos_asistencial"] = EntornoAsistencial::lists('nombre','id');
				$data["reportes_data"] = ReporteInvestigacion::searchReportesInvestigacion($data["search_codigo_reporte_investigacion"],$data["search_codigo_reporte_evento"],
				$data["search_entorno_asistencial"],$data["search_usuario"],$data["search_fecha_ini"],$data["search_fecha_fin"])->distinct()->paginate(10);
				return View::make('riesgos/reporte_investigacion/listReporteInvestigacion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_reporte()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				
				$data["metodos"] = MetodoDifusion::getMetodos()->get();
				$data["tipos_capacitacion"] = TipoCapacitacionRiesgos::getTipos()->get();
				return View::make('riesgos/reporte_investigacion/createReporteInvestigacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_reporte_investigacion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				 
				
				$attributes = array(
					'archivo' => 'Archivo Reporte de Investigación'
				);



				$messages = array(
					);

				$rules = array(
					'archivo' => 'required'
				);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);
				

				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reportes_investigacion/create_reporte')->withErrors($validator)->withInput(Input::all());
				}else{	
					//se instancia un nuevo reporte de investigacion
					$reporte = new ReporteInvestigacion;
					$reporte->codigo_abreviatura = "RE";
					$reporte->codigo_correlativo = $this->getCorrelativeReportNumber();
					$reporte->codigo_anho = date('y');
					
					$reporte->usuario_reportante = $data["user"]->nombre.' '.$data["user"]->apellido_pat.' '.$data["user"]->apellido_mat;
					$reporte->idusuario_elaborador = $data["user"]->id;
					$reporte->idevento_adverso = Input::get('id_evento');

					if (Input::hasFile('archivo')) {
				        $archivo            = Input::file('archivo');
				        $rutaDestino = 'uploads/documentos/riesgos/Reportes Investigacion/' .$reporte->codigo_abreviatura.'-'.$reporte->codigo_correlativo.'-'.$reporte->codigo_anho . '/archivo_reporte/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				        $reporte->nombre = $nombreArchivo;
				        $reporte->nombre_archivo = $nombreArchivo;
				        $reporte->nombre_archivo_encriptado = $nombreArchivoEncriptado;
				        $reporte->url = $rutaDestino;
				    }

				    //verificar si seleccionar al menos un metodo y un tipo de capacitacion
				    $metodos = MetodoDifusion::getMetodos()->get();
				    $cantidad_metodos = count($metodos);
				    $tipos = TipoCapacitacionRiesgos::getTipos()->get();
				    $cantidad_tipos = count($tipos);
				    $seleccionMetodo = false;
				    $seleccionTipo = false;
				    for($i=0;$i<$cantidad_metodos;$i++){
				    	if(Input::has('seleccionado-metodo-'.$i)){
				    		$seleccionMetodo = true;
				    		break;
				    	}
				    }

				    for($i=0;$i<$cantidad_tipos;$i++){
				    	if(Input::has('seleccionado-tipo-'.$i)){
				    		$seleccionTipo = true;
				    		break;
				    	}
				    }

				    if($seleccionMetodo==false || $seleccionMetodo == false){
				    	Session::flash('error','Se debe seleccionar por lo menos un tipo de Método de Difusión y un tipo de Capacitación');
				    	return Redirect::to('reportes_investigacion/create_reporte')->withInput(Input::all());
				    }

				    $reporte->save();

				    //se agrega los detalles
				    //1) Metodo Difusion				    
				    for($i=0;$i<$cantidad_metodos;$i++){
				    	if(Input::has('seleccionado-metodo-'.$i)){
					    	if(Input::hasFile('archivo-'.$i)){
					    		$archivo            = Input::file('archivo-'.$i);
						        $rutaDestino = 'uploads/documentos/riesgos/Reportes Investigacion/' .$reporte->codigo_abreviatura.'-'.$reporte->codigo_correlativo.'-'.$reporte->codigo_anho . '/Metodos de Difusion/Tipo '.$metodos[$i]->id.'/';
						        $nombreArchivo        = $archivo->getClientOriginalName();
						        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
						        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						        $reportexmetodo = new ReporteInvestigacionxMetodoDifusion;
						        $reportexmetodo->idreporte = $reporte->id;
						        $reportexmetodo->idmetodo = $metodos[$i]->id;
						        $reportexmetodo->nombre = $nombreArchivo;
						        $reportexmetodo->nombre_archivo = $nombreArchivo;
						        $reportexmetodo->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						        $reportexmetodo->url = $rutaDestino;
						        $reportexmetodo->save();
					    	}
					    }
				    }

				    
			     	for($i=0;$i<$cantidad_tipos;$i++){			    	    
				        if(Input::has('seleccionado-tipo-'.$i)){
				        	$reportextipo = new ReporteInvestigacionxTipoCapacitacion;
				        	$reportextipo->idreporte = $reporte->id;
				        	$reportextipo->idtipo = $tipos[$i]->id;
				        	$reportextipo->save();
				        }			    
				    }

				    Session::flash('message','Se registró el reporte de investigación '.$reporte->codigo_abreviatura.'-'.$reporte->codigo_correlativo.'-'.$reporte->codigo_anho.' con éxito.');
				    return Redirect::to('reportes_investigacion/list_reportes_investigacion');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function validate_evento_adverso(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$codigo_evento = Input::get('codigo_evento');
			$evento_adverso = EventoAdverso::getEventoByCodigoEvento($codigo_evento)->get();

			$existe = 0;
			if(!$evento_adverso->isEmpty()){
				$evento_adverso = $evento_adverso[0];
				//verificamos si existe o ha sido eliminado
				if(!$evento_adverso->deleted_at){
					//verificamos si existe algun reporte de investigacion que tenga ese evento adverso
					$reporte_investigacion = ReporteInvestigacion::getReporteByIdEvento($evento_adverso->id)->get();
					if(!$reporte_investigacion->isEmpty()){
						//ya existe un reporte con ese evento adverso
						//verificamos si este reporte no ha sido eliminado
						$reporte_investigacion = $reporte_investigacion[0];
						if($reporte_investigacion->deleted_at == null)
							$existe = 1;
						else
							$existe = 2;
					}else
						$existe = 2;
				}else
					$existe = 0;
					
			}else{
				$existe = 0;
				$evento_adverso = null;
			}
			
				

			return Response::json(array( 'success' => true, 'existe' => $existe,'evento'=>$evento_adverso),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function getCorrelativeReportNumber(){
		$reporte_ultimo = ReporteInvestigacion::orderBy('id','desc')->first();
		$string = "";
		if($reporte_ultimo!=null){	
			$numero = $reporte_ultimo->codigo_correlativo;
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

	public function render_view_reporte_investigacion($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12  ) && $id){
				
				$data["reporte_data"] = ReporteInvestigacion::searchReporteById($id)->get();
			 	$data["metodos"] = MetodoDifusion::getMetodos()->get();
				$data["tipos_capacitacion"] = TipoCapacitacionRiesgos::getTipos()->get();

				
				if($data["reporte_data"]->isEmpty()){
					return Redirect::to('reportes_investigacion/list_reportes_investigacion');
				}
				$data["reporte_data"] = $data["reporte_data"][0];
				$data["archivo_anexo"] = basename($data["reporte_data"]->url);

				//sacamos los metodos y tipos capacitacion
				$data["reportexmetodos"] = ReporteInvestigacionxMetodoDifusion::getReportexMetodo($data["reporte_data"]->id)->get();
				$data["reportextipos"] = ReporteInvestigacionxTipoCapacitacion::getReportexTipo($data["reporte_data"]->id)->get();
				
				return View::make('riesgos/reporte_investigacion/viewReporteInvestigacion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	

	public function submit_disable_reporte()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$reporte_id = Input::get('reporte_id');
				$url = "reportes_investigacion/list_reportes_investigacion";
				$reporte = ReporteInvestigacion::find($reporte_id);
				$reporte->delete();
				Session::flash('message', 'Se inhabilitó correctamente al reporte.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_reporte()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$reporte_id = Input::get('reporte_id');
				$url = "reportes_investigacion/list_reportes_investigacion";
				$reporte = ReporteInvestigacion::searchReporteById($reporte_id)->get();
				if(!$reporte->isEmpty()){
					$reporte[0]->restore();
				}else{
					Session::flash('error', 'No se pudo habilitar el reporte.');
					return Redirect::to($url);
				}
				
				Session::flash('message', 'Se habilitó correctamente al reporte.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function show_toma_acciones(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$idEvento = Input::get('idEvento');
			$evento_adverso = EventoAdverso::find($idEvento);
			$texto = null;
			if($evento_adverso!= null){
				$texto = $evento_adverso->medidas;
			}
			
				

			return Response::json(array( 'success' => true, 'texto' => $texto),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}