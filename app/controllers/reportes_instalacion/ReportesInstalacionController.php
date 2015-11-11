<?php
	  
class ReportesInstalacionController extends BaseController {

	public function render_create_rep_instalacion($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');
				$data["tipos_reporte_instalacion"] = TipoReporteInstalacion::lists('nombre','idtipo_reporte_instalacion');
				$data["reporte_instalacion_info"] = null;
				if($id){
					$data["reporte_instalacion_info"] = ReporteInstalacion::searchReporteInstalacionById($id)->get();
					$data["reporte_instalacion_info"] = $data["reporte_instalacion_info"][0];
				}
				return View::make('reportes_instalacion/createReporteInstalacion',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_rep_instalacion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'idtipo_reporte_instalacion' => 'required',
							'idproveedor' => 'required',
							'fecha' => 'required',
							'codigo_compra' => 'required',
							'idarea' => 'required',
							'numero_documento1' => 'required',													
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('rep_instalacion/create_rep_instalacion')->withErrors($validator)->withInput(Input::all());					
				}else{
					$existeReporteEntornoConcluido = ReporteInstalacion::searchReporteEntornoConcluidoByCodigoCompra(Input::get('codigo_compra'))->get();					
					if(Input::get('idtipo_reporte_instalacion')==1 || (Input::get('idtipo_reporte_instalacion')==2 && !$existeReporteEntornoConcluido->isEmpty())){
						$details_tarea =Input::get('details_tarea');
						$details_estado =Input::get('details_estado');
						$cant = count($details_tarea);
						if($cant>0){
							$reporte = new ReporteInstalacion;
							if(Input::get('idtipo_reporte_instalacion')==1)
								$abreviatura = "IE";
							else 
								$abreviatura = "IF";
					
							$name_controller = "ReporteInstalacion";
							// Algoritmo para añadir numeros correlativos
							$string = $this->getCorrelativeReportNumber($name_controller,Input::get('idtipo_reporte_instalacion'));
							//Get Año Actual
							$anho = date('y');

							$reporte->numero_reporte_abreviatura = $abreviatura;
							$reporte->numero_reporte_correlativo = $string;
							$reporte->numero_reporte_anho = $anho;
							
							$reporte->idtipo_reporte_instalacion = Input::get('idtipo_reporte_instalacion'); 
							$reporte->descripcion = Input::get('descripcion');
							$reporte->fecha = date('Y-m-d H:i:s',strtotime(Input::get('fecha')));
							$reporte->idarea = Input::get('idarea');
							$reporte->idproveedor = Input::get('idproveedor');
							$reporte->codigo_compra = Input::get('codigo_compra');
							$reporte->idestado = 1;
							$id_usuario_responsable = Input::get('numero_documento1');
							$usuario_responsable = User::searchPersonalByNumeroDoc($id_usuario_responsable)->get();
							if($usuario_responsable->isEmpty()){
								Session::flash('error', 'Usuario revisión no existe.');
								return Redirect::to('rep_instalacion/create_rep_instalacion')->withInput(Input::all());
							}else{
								$reporte->id_responsable = $usuario_responsable[0]->id;
								
							}

							if(Input::get('idtipo_reporte_instalacion')==2){
								$num_rep_entorno_concluido = Input::get('numero_reporte_entorno_concluido');
								$abreviatura = mb_substr($num_rep_entorno_concluido,0,2);
								$correlativo = mb_substr($num_rep_entorno_concluido,2,4);
								$anho = mb_substr($num_rep_entorno_concluido,7,2);
								$rep_ent_concluido = ReporteInstalacion::searchReporteEntornoConcluidoByNumeroReporte($abreviatura,$correlativo,$anho)->get();								
								if($rep_ent_concluido->isEmpty()){
									Session::flash('error', 'Reporte de Entorno Concluido no existe.');
									return Redirect::to('rep_instalacion/create_rep_instalacion')->withInput(Input::all());
								}else{
									$reporte->idreporte_instalacion_entorno_concluido = $rep_ent_concluido[0]->idreporte_instalacion;
								}						
							}
							
							$reporte->save();

							$idReporte = $reporte->idreporte_instalacion;
							for($i=0;$i<$cant;$i++){
								$detalle_reporte_instalacion = new DetalleReporteInstalacion;
								$detalle_reporte_instalacion->nombre_tarea = $details_tarea[$i];
								if($details_estado[$i] == "Realizado"){
									$estado_tarea = 1;
								}
								else{
									$estado_tarea = 0;								
								}
								$detalle_reporte_instalacion->tarea_realizada = $estado_tarea;					
								$detalle_reporte_instalacion->idreporte_instalacion = $idReporte;	
								$detalle_reporte_instalacion->save();

							}

							$codigo_archivamiento_cert_funcionalidad = Input::get('num_doc_relacionado1');
							if($codigo_archivamiento_cert_funcionalidad != ''){
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_cert_funcionalidad)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}

							$codigo_archivamiento_contrato = Input::get('num_doc_relacionado2');
							if($codigo_archivamiento_contrato != ''){
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_contrato)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}

							$codigo_archivamiento_manual = Input::get('num_doc_relacionado3');
							if($codigo_archivamiento_manual != ''){							
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_manual)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}

							$codigo_archivamiento_tdr = Input::get('num_doc_relacionado4');
							if($codigo_archivamiento_tdr != ''){
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_tdr)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}						

							Session::flash('message', 'Se registró correctamente el Reporte de Instalación.');
							return Redirect::to('rep_instalacion/create_rep_instalacion');
						}else{
							Session::flash('error', 'Ingrese por lo menos una tarea.');
							return Redirect::to('rep_instalacion/create_rep_instalacion')->withInput(Input::all());		
						}
					}else{
							Session::flash('error', 'Solo se puede crear Reporte de Equipo Funcional si ha sido creado el Reporte de Entorno Concluido');
							return Redirect::to('rep_instalacion/create_rep_instalacion')->withInput(Input::all());	
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_rep_instalacion($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');
				$data["tipos_reporte_instalacion"] = TipoReporteInstalacion::lists('nombre','idtipo_reporte_instalacion');
				$data["reporte_instalacion_info"] = ReporteInstalacion::searchReporteInstalacionById($id)->get();
				$data["reporte_instalacion_info"] = $data["reporte_instalacion_info"][0];
				$data["reporte_instalacion_entorno_concluido"] = null;
				if($data["reporte_instalacion_info"]->idtipo_reporte_instalacion == 2){
					$data["reporte_instalacion_entorno_concluido"] = ReporteInstalacion::searchReporteInstalacionById($data["reporte_instalacion_info"]->idreporte_instalacion_entorno_concluido)->get();
					$data["reporte_instalacion_entorno_concluido"] = $data["reporte_instalacion_entorno_concluido"][0];
				}
				$data["tareas_info"] = DetalleReporteInstalacion::searchDetalleReporteByIdReporteInstalacion($id);
				$data["usuario_responsable"] = User::searchUserById($data["reporte_instalacion_info"]->id_responsable)->get()[0];
				$data["documento_certificado_funcionalidad"] = Documento::searchDocumentoCertificadoFuncionalidadByIdReporteInstalacion($id)->get();			
				if(!$data["documento_certificado_funcionalidad"]->isEmpty()){					
					$data["documento_certificado_funcionalidad"] = $data["documento_certificado_funcionalidad"][0];
				}
				else {
					$data["documento_certificado_funcionalidad"] = null;
				}
				$data["documento_contrato"] = Documento::searchDocumentoContratoByIdReporteInstalacion($id)->get();
				if(!$data["documento_contrato"]->isEmpty()){
					$data["documento_contrato"] = $data["documento_contrato"][0];
				}
				else{
					$data["documento_contrato"] = null;
				}
				$data["documento_manual"] = Documento::searchDocumentoManualByIdReporteInstalacion($id)->get();
				if(!$data["documento_manual"]->isEmpty()){
					$data["documento_manual"] = $data["documento_manual"][0];
				}
				else{
					$data["documento_manual"] = null;
				}
				$data["documento_tdr"] = Documento::searchDocumentoTdRByIdReporteInstalacion($id)->get();
				if(!$data["documento_tdr"]->isEmpty()){
					$data["documento_tdr"] = $data["documento_tdr"][0];
				}
				else{
					$data["documento_tdr"] = null;
				}
				return View::make('reportes_instalacion/editReporteInstalacion',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_rep_instalacion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'idproveedor' => 'required',
							'fecha' => 'required',
							'idarea' => 'required',
							'numero_documento1' => 'required',													
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$reporte_instalacion_id = Input::get('reporte_instalacion_id');
				$url = "rep_instalacion/edit_rep_instalacion"."/".$reporte_instalacion_id;
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());					
				}else{	
					$existeReporteEntornoConcluido = ReporteInstalacion::searchReporteEntornoConcluidoByCodigoCompra(Input::get('codigo_compra'))->get();							
					$reporte_instalacion_id = Input::get('reporte_instalacion_id');
					$reporte = ReporteInstalacion::find($reporte_instalacion_id);
					if($reporte->idtipo_reporte_instalacion==1 || ($reporte->idtipo_reporte_instalacion==2 && !$existeReporteEntornoConcluido->isEmpty())){
						$details_tarea =Input::get('details_tarea');
						$details_estado =Input::get('details_estado');
						$cant = count($details_tarea);
						if($cant>0){
							$reporte_instalacion_id = Input::get('reporte_instalacion_id');
							$url = "rep_instalacion/edit_rep_instalacion"."/".$reporte_instalacion_id;
							$reporte = ReporteInstalacion::find($reporte_instalacion_id);
							$reporte->descripcion = Input::get('descripcion');
							$reporte->fecha = date('Y-m-d H:i:s',strtotime(Input::get('fecha')));
							$reporte->idarea = Input::get('idarea');
							$reporte->idproveedor = Input::get('idproveedor');
							$reporte->idestado = 1;
							$id_usuario_responsable = Input::get('numero_documento1');
							$usuario_responsable = User::searchPersonalByNumeroDoc($id_usuario_responsable)->get();
							if($usuario_responsable->isEmpty()){
								Session::flash('error', 'Usuario revisión no existe.');
								return Redirect::to($url)->withInput(Input::all());
							}else{
								$reporte->id_responsable = $usuario_responsable[0]->id;
								
							}						
							
							$reporte->save();

							DetalleReporteInstalacion::deleteDetalleByIdReporteInstalacion($reporte_instalacion_id)->forcedelete();

							$idReporte = $reporte->idreporte_instalacion;
							for($i=0;$i<$cant;$i++){
								$detalle_reporte_instalacion = new DetalleReporteInstalacion;
								$detalle_reporte_instalacion->nombre_tarea = $details_tarea[$i];
								if($details_estado[$i] == "Realizado"){
									$estado_tarea = 1;
								}
								else{
									$estado_tarea = 0;								
								}
								$detalle_reporte_instalacion->tarea_realizada = $estado_tarea;					
								$detalle_reporte_instalacion->idreporte_instalacion = $idReporte;	
								$detalle_reporte_instalacion->save();

							}

							$codigo_archivamiento_cert_funcionalidad = Input::get('num_doc_relacionado1');
							if($codigo_archivamiento_cert_funcionalidad != ''){
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_cert_funcionalidad)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}

							$codigo_archivamiento_contrato = Input::get('num_doc_relacionado2');
							if($codigo_archivamiento_contrato != ''){
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_contrato)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}

							$codigo_archivamiento_manual = Input::get('num_doc_relacionado3');
							if($codigo_archivamiento_manual != ''){							
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_manual)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}

							$codigo_archivamiento_tdr = Input::get('num_doc_relacionado4');
							if($codigo_archivamiento_tdr != ''){
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_tdr)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}						

							Session::flash('message', 'Se registró correctamente el Reporte de Instalación.');
							return Redirect::to($url);
						}else{
							Session::flash('error', 'Ingrese por lo menos una tarea.');
							return Redirect::to($url)->withInput(Input::all());		
						}
					}else{
							Session::flash('error', 'Solo se puede crear Reporte de Equipo Funcional si ha sido creado el Reporte de Entorno Concluido');
							return Redirect::to($url)->withInput(Input::all());	
					}
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_rep_instalacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				/*
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				*/
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');	
				$data["areas"] = Area::lists('nombre','idarea');			
				$data["search_usuario_responsable"] = null;
				$data["search_proveedor"] = null;
				$data["search_area"] = null;
				$data["search_codigo_compra"] = null;			

				$data["reportes_instalacion_data"] = ReporteInstalacion::getReportesInstalacionInfo();
				return View::make('reportes_instalacion/listReporteInstalacion',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_rep_instalacion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_usuario_responsable"] = Input::get('search_usuario_responsable');
				$data["search_codigo_compra"] = Input::get('search_codigo_compra');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["search_area"] = Input::get('search_area');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["reportes_instalacion_data"] = ReporteInstalacion::searchReportes($data["search_usuario_responsable"],$data["search_codigo_compra"],$data["search_proveedor"],$data["search_area"]);
				return View::make('reportes_instalacion/listReporteInstalacion',$data);	
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
		
	public function return_name_responsable(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data!="vacio")
				$responsable = User::searchPersonalByNumeroDoc($data)->get();
			else{
				$responsable = "vacio";
			}
								
			return Response::json(array( 'success' => true, 'responsable' => $responsable),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_name_doc_relacionado(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$documento = Documento::searchDocumentoByCodigoArchivamiento($data)->get();
			}else{
				$documento = null;
			}

			return Response::json(array( 'success' => true, 'contrato' => $documento ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_num_rep_entorno_concluido(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$abreviatura = mb_substr($data,0,2);
				$correlativo = mb_substr($data,2,4);
				$anho = mb_substr($data,7,2);
				$reporte = ReporteInstalacion::searchReporteEntornoConcluidoByNumeroReporte($abreviatura,$correlativo,$anho)->get();
			}else{
				$reporte = null;
			}
			return Response::json(array( 'success' => true, 'reporte' => $reporte ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function getCorrelativeReportNumber($name_controller,$idtipo_reporte_instalacion){
		$reporte_ultimo = $name_controller::getUltimoCodigoByTipoReporte($idtipo_reporte_instalacion)->first();
		$string = "";
		if($reporte_ultimo!=null){	
			$numero = $reporte_ultimo->numero_reporte_correlativo;
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

	public function download_documento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$iddocumento = $id;		
				$documento = Documento::searchDocumentoById($id)->get();
				$file= $documento[0]->url;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($file),$headers);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
	
}