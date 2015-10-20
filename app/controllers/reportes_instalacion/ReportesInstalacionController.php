<?php
	  
class ReportesInstalacionController extends BaseController {

	public function render_create_rep_instalacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');
				$data["tipos_reporte_instalacion"] = TipoReporteInstalacion::lists('nombre','idtipo_reporte_instalacion');
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
							$reporte->idtipo_reporte_instalacion = Input::get('idtipo_reporte_instalacion'); 
							$reporte->numero_reporte_abreviatura = 'EC';
							$reporte->numero_reporte_correlativo = '0001';
							$reporte->numero_reporte_anho = '15';
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
								return Redirect::to('rep_instalacion/create_rep_instalacion');
							}else{
								$reporte->id_responsable = $usuario_responsable[0]->id;
								
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

							$codigo_archivamiento_cert_funcionalidad = Input::get('nombre_doc_relacionado1');
							if($codigo_archivamiento_cert_funcionalidad != ''){
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_cert_funcionalidad)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}

							$codigo_archivamiento_contrato = Input::get('nombre_doc_relacionado2');
							if($codigo_archivamiento_contrato != ''){
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_contrato)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}

							$codigo_archivamiento_manual = Input::get('nombre_doc_relacionado3');
							if($codigo_archivamiento_manual != ''){							
								$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_manual)->get();
								$documento = $documento[0];
								$documento->idreporte_instalacion = $idReporte;
								$documento->save();
							}

							$codigo_archivamiento_tdr = Input::get('nombre_doc_relacionado4');
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
							return Redirect::to('rep_instalacion/create_rep_instalacion');		
						}
					}else{
							Session::flash('error', 'Solo se puede crear Reporte de Equipo Funcional si ha sido creado el Reporte de Entorno Concluido');
							return Redirect::to('rep_instalacion/create_rep_instalacion');	
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
				$data["search"] = null;
				$data["search_proveedor"] = null;
				$data["search_area"] = null;
				$data["search_codigo_compra"] = null;
				/*
				$data["sots_data"] = SolicitudOrdenTrabajo::getSotsInfo()->paginate(10);
				*/
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
				$data["fecha_desde"] = date('Y-m-d H:i:s',strtotime(Input::get('fecha_desde')));				
				$data["fecha_hasta"] = date('Y-m-d H:i:s',strtotime(Input::get('fecha_hasta')));
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["search_tipo_reporte"] = Input::get('search_tipo_reporte');
				$data["reportes_data"] = ReporteIncumplimiento::searchReportes($data["fecha_desde"],$data["fecha_hasta"],$data["search_proveedor"],$data["search_tipo_reporte"])->paginate(10);
				$data["fecha_desde"] = date('d-m-Y',strtotime(Input::get('fecha_desde')));				
				$data["fecha_hasta"] = date('d-m-Y',strtotime(Input::get('fecha_hasta')));
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
	
}