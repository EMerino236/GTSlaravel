<?php

class ReportesIncumplimientoController extends BaseController
{
	public function list_reportes_incumplimiento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["search_proveedor"] = null;
				$data["fecha_desde"] = null;
				$data["fecha_hasta"] = null;
				$data["search_tipo_reporte"] = null;
				$data["reportes_data"] = ReporteIncumplimiento::getReporteIncumplimientoInfo()->paginate(10);
				array_unshift($data["proveedor"], "Seleccione");
				return View::make('reportes_incumplimiento/listReportesIncumplimientos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_reporte(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["fecha_desde"] = Input::get('fecha_desde');				
				$data["fecha_hasta"] = Input::get('fecha_hasta');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["search_tipo_reporte"] = Input::get('search_tipo_reporte');
				
				if($data["fecha_desde"]==null && $data["fecha_hasta"]==null && $data["search_proveedor"]==0 &&
					$data["search_tipo_reporte"]==0){
					$data["reportes_data"] = ReporteIncumplimiento::getReporteIncumplimientoInfo()->paginate(10);
				}else{
					$data["reportes_data"] = ReporteIncumplimiento::searchReportes($data["fecha_desde"],$data["fecha_hasta"],$data["search_proveedor"],$data["search_tipo_reporte"])->paginate(10);
				}
				return View::make('reportes_incumplimiento/listReportesIncumplimientos',$data);	
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
				$data["tipo_documento"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["servicios"] = Servicio::searchServiciosClinicos(1)->lists('nombre','idservicio');
				$data["search"] = null;
				$data["documento_info"] =null;
				return View::make('reportes_incumplimiento/createReporteIncumplimiento',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_reporte($idreporte=null){
		
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $idreporte)
			{	
				$data["reporte_data"] = ReporteIncumplimiento::getReporteIncumplimientoById($idreporte)->get();
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["servicios"] = Servicio::searchServiciosClinicos(1)->lists('nombre','idservicio');
				
				if($data["reporte_data"]->isEmpty()){
					return Redirect::to('reportes_incumplimiento/list_reportes');
				}
				$data["reporte_data"] = $data["reporte_data"][0];
				$data["documento_info"] = Documento::searchDocumentoByIdReporteIncumplimiento($data["reporte_data"]->idreporte_incumplimiento)->get();
				$data["documento_info"] = $data["documento_info"][0];
				$data["usuario_revision"] = User::searchUserById($data["reporte_data"]->id_responsable)->get();
				$data["usuario_autorizado"] = User::searchUserById($data["reporte_data"]->id_autorizado)->get();
				$data["usuario_elaborado"] = User::searchUserById($data["reporte_data"]->id_elaborado)->get();
				$data["usuario_revision"] = $data["usuario_revision"][0];
				$data["usuario_autorizado"] = $data["usuario_autorizado"][0];
				$data["usuario_elaborado"] = $data["usuario_elaborado"][0];
				return View::make('reportes_incumplimiento/editReporteIncumplimiento',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}

	}

	public function render_view_reporte($idreporte=null){
		
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $idreporte)
			{	
				$data["reporte_data"] = ReporteIncumplimiento::getReporteIncumplimientoById($idreporte)->get();
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["servicios"] = Servicio::searchServiciosClinicos(1)->lists('nombre','idservicio');
				
				if($data["reporte_data"]->isEmpty()){
					return Redirect::to('reportes_incumplimiento/list_reportes');
				}
				$data["reporte_data"] = $data["reporte_data"][0];
				$data["documento_info"] = Documento::searchDocumentoByIdReporteIncumplimiento($data["reporte_data"]->idreporte_incumplimiento)->get();
				$data["documento_info"] = $data["documento_info"][0];
				$data["usuario_revision"] = User::searchUserById($data["reporte_data"]->id_responsable)->get();
				$data["usuario_autorizado"] = User::searchUserById($data["reporte_data"]->id_autorizado)->get();
				$data["usuario_elaborado"] = User::searchUserById($data["reporte_data"]->id_elaborado)->get();
				$data["usuario_revision"] = $data["usuario_revision"][0];
				$data["usuario_autorizado"] = $data["usuario_autorizado"][0];
				$data["usuario_elaborado"] = $data["usuario_elaborado"][0];
				return View::make('reportes_incumplimiento/viewReporteIncumplimiento',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}

	}

	public function return_name_contrato(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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

	public function return_responsable_servicio(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !=0){
				$servicio = Servicio::find($data);
				$iduser = $servicio->id_usuario_responsable;
				$usuario = User::find($iduser);			
			}else{
				$usuario = null;
			}

			return Response::json(array( 'success' => true, 'usuarios_resp' => $usuario ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_contacto_proveedor(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !=0){
				$proveedor = Proveedor::find($data);				
			}else{
				$proveedor = null;
			}
			return Response::json(array( 'success' => true, 'proveedor' => $proveedor),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_name_responsable(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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

	public function submit_edit_reporte(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$rules = array(
							'numero_ot' => 'required',
							'tipo_reporte' => 'required',
							'numero_doc1' => 'required',
							'fecha_reporte' => 'required',
							'descripcion_corta' => 'required',
							'descripcion' => 'required',
							'servicio' => 'required',						
							'proveedor' => 'required',
							'costo' => 'required',
							'accion_generada' => 'required',
							'reincidente' => 'required',
							'acciones' => 'required',
							'resultados' => 'required',				
							'numero_doc2' => 'required',
							'numero_doc3' => 'required',
						);
				
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$reporte_id = Input::get('reporte_id');
					$url = "reportes_incumplimiento/edit_reporte"."/".$reporte_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$reporte_id = Input::get('reporte_id');					
					$url = "reportes_incumplimiento/edit_reporte"."/".$reporte_id;
					$reporte = ReporteIncumplimiento::find($reporte_id);
					$reporte->codigo_ot = Input::get('numero_ot'); 
					if(Input::get('flag_ot')==1){
						Session::flash('error', 'Orden de Trabajo de Mantenimiento no existe.');
						return Redirect::to($url);
					}
					$reporte->tipo_reporte = Input::get('tipo_reporte');
					//validar si la fecha es mayor o igual que la actual
					$fecha_reporte = date('Y-m-d',strtotime(Input::get('fecha_reporte')));
					$fecha_actual = date('Y-m-d');
					
					$reporte->fecha = $fecha_reporte;
					$id_usuario_revision = Input::get('numero_doc1');
					$usuario_revision = User::searchPersonalByNumeroDoc($id_usuario_revision)->get();
					if($usuario_revision->isEmpty()){
						Session::flash('error', 'Usuario revisión no existe.');
						return Redirect::to($url);
					}else{
						$reporte->id_responsable = $usuario_revision[0]->id;
						
					}
					$reporte->descripcion_corta = Input::get('descripcion_corta');
					$reporte->descripcion_servicio = Input::get('descripcion');
					$reporte->costo_generado = Input::get('costo');
					$reporte->accion_correctiva = Input::get('accion_generada');
					$reporte->acciones = Input::get('acciones');
					$reporte->resultados = Input::get('resultados');
					$reporte->idservicio = Input::get('servicio');
					$reporte->idproveedor = Input::get('proveedor');
					$reporte->resultados = Input::get('resultados');
					$id_usuario_autorizado = Input::get('numero_doc2');
					$reporte->flag_reincidente = Input::get('reincidente');
					$usuario_autorizado = User::searchPersonalByNumeroDoc($id_usuario_autorizado)->get();
					if($usuario_autorizado->isEmpty()){
						Session::flash('error', 'Usuario autorizado no existe.');
						return Redirect::to($url);
					}else{
						$reporte->id_autorizado = $usuario_autorizado[0]->id;
					}
					$id_usuario_elaborador = Input::get('numero_doc3');
					$usuario_elaborador = User::searchPersonalByNumeroDoc($id_usuario_elaborador)->get();
					if($usuario_elaborador->isEmpty()){
						Session::flash('error', 'Usuario elaborador no existe.');
						return Redirect::to($url);
					}else{
						$reporte->id_elaborado = $usuario_elaborador[0]->id;
					}
					$reporte->idestado = 1;
					$documento_actual = Documento::searchDocumentoByIdReporteIncumplimiento($reporte->idreporte_incumplimiento)->get();
					$documento_actual = $documento_actual[0];
					$codigo_archivamiento = Input::get('numero_contrato');
					$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento)->get();
					if($documento->isEmpty()){
						Session::flash('error', 'No se pudo registrar los cambios, el documento no existe');
						return Redirect::to($url);
					}
					$documento = $documento[0];
					//se realizará la modificación siempre y cuando se cambie el documento por otro.
					if($documento_actual->iddocumento<>$documento->iddocumento){
						$documento_actual->idreporte_incumplimiento = null;
						$documento->idreporte_incumplimiento = $reporte->idreporte_incumplimiento;
						$documento_actual->save();
						$documento->save();
					}		
					$reporte->save();													
					
					Session::flash('message', 'Se modificó correctamente el reporte.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}	

	public function submit_create_reporte(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$rules = array(
							'numero_ot' => 'required',
							'tipo_reporte' => 'required',
							'numero_doc1' => 'required',
							'fecha_reporte' => 'required',
							'descripcion_corta' => 'required',
							'descripcion' => 'required',
							'servicio' => 'required',						
							'proveedor' => 'required',
							'costo' => 'required',
							'accion_generada' => 'required',
							'reincidente' => 'required',
							'acciones' => 'required',
							'resultados' => 'required',				
							'numero_doc2' => 'required',
							'numero_doc3' => 'required',
							'numero_contrato' => 'required'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reportes_incumplimiento/create_reporte')->withErrors($validator)->withInput(Input::all());
				}else{
					if(Input::get('flag_ot')==1){
						Session::flash('error', 'Orden de Trabajo de Mantenimiento no existe.');
						return Redirect::to('reportes_incumplimiento/create_reporte');
					}

					$reporte = new ReporteIncumplimiento;
					$abreviatura = "RI";
					
					$name_controller = "ReporteIncumplimiento";
					// Algoritmo para añadir numeros correlativos
					$string = $this->getCorrelativeReportNumber($name_controller);
					//Get Año Actual
					$anho = date('y');
					//---------------------------------------------------------------
					$reporte->numero_reporte_abreviatura = $abreviatura;
					$reporte->numero_reporte_correlativo = $string;
					$reporte->numero_reporte_anho = $anho;

					$reporte->codigo_ot = Input::get('numero_ot'); 
					$reporte->tipo_reporte = Input::get('tipo_reporte');
					$fecha_reporte = date('Y-m-d',strtotime(Input::get('fecha_reporte')));
					$fecha_actual = date('Y-m-d');
					if($fecha_actual>$fecha_reporte){
						Session::flash('error', 'No se puede guardar una fecha pasada a la actual.');
						return Redirect::to('reportes_incumplimiento/create_reporte');
					}
					$reporte->fecha = $fecha_reporte;
					$id_usuario_revision = Input::get('numero_doc1');
					$usuario_revision = User::searchPersonalByNumeroDoc($id_usuario_revision)->get();
					if($usuario_revision->isEmpty()){
						Session::flash('error', 'Usuario revisión no existe.');
						return Redirect::to('reportes_incumplimiento/create_reporte');
					}else{
						$reporte->id_responsable = $usuario_revision[0]->id;
						
					}
					$reporte->descripcion_corta = Input::get('descripcion_corta');
					$reporte->descripcion_servicio = Input::get('descripcion');
					$reporte->costo_generado = Input::get('costo');
					$reporte->accion_correctiva = Input::get('accion_generada');
					$reporte->acciones = Input::get('acciones');
					$reporte->resultados = Input::get('resultados');
					$reporte->idservicio = Input::get('servicio');
					$reporte->idproveedor = Input::get('proveedor');
					$reporte->resultados = Input::get('resultados');
					$id_usuario_autorizado = Input::get('numero_doc2');
					$reporte->flag_reincidente = Input::get('reincidente');
					$usuario_autorizado = User::searchPersonalByNumeroDoc($id_usuario_autorizado)->get();
					if($usuario_autorizado->isEmpty()){
						Session::flash('error', 'Usuario autorizado no existe.');
						return Redirect::to('reportes_incumplimiento/create_reporte');
					}else{
						$reporte->id_autorizado = $usuario_autorizado[0]->id;
					}
					$id_usuario_elaborador = Input::get('numero_doc3');
					$usuario_elaborador = User::searchPersonalByNumeroDoc($id_usuario_elaborador)->get();
					if($usuario_elaborador->isEmpty()){
						Session::flash('error', 'Usuario elaborador no existe.');
						return Redirect::to('reportes_incumplimiento/create_reporte');
					}else{
						$reporte->id_elaborado = $usuario_elaborador[0]->id;
					}
					$reporte->idestado = 1;					
					$reporte->save();
					$idReporte = $reporte->idreporte_incumplimiento;
					$codigo_archivamiento = Input::get('numero_contrato');
					$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento)->get();
					$documento = $documento[0];
					$documento->idreporte_incumplimiento = $idReporte;
					$documento->save();
					Session::flash('message', 'Se registró correctamente el reporte de incumplimiento.');
					return Redirect::to('reportes_incumplimiento/create_reporte');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	

	public function get_codigoArchivamento(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$documento = Documento::searchDocumentoByCodigoArchivamiento($data)->get();
				$url = $documento[0]->url;
			}else{
				$documento = null;
			}
			return Response::json(array( 'success' => true, 'url' => $url ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function download_contrato(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$codigo = Input::get('numero_contrato_hidden');		
				$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo)->get();
				$file= $documento[0]->url.$documento[0]->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($documento[0]->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_reporte(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$reporte_id = Input::get('reporte_id');
				$url = "reportes_incumplimiento/edit_reporte"."/".$reporte_id;
				$reporte = ReporteIncumplimiento::withTrashed()->find($reporte_id);
				$reporte->restore();
				Session::flash('message', 'Se habilitó correctamente el reporte de incumplimiento.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_reporte(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$reporte_id = Input::get('reporte_id');
				$url = "reportes_incumplimiento/edit_reporte"."/".$reporte_id;
				$reporte = ReporteIncumplimiento::withTrashed()->find($reporte_id);
				$reporte->delete();
				Session::flash('message','Se inhabilitó correctamente el reporte.' );
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function getCorrelativeReportNumber($name_controller){
		$reporte_ultimo = $name_controller::orderBy('created_at','desc')->first();
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

	public function validate_ot(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('numero_ot');
			$existe = false;
			$ot_correctivo = null;
			$ot_preventivo = null;
			$ot_retiro = null;
			$ot_verificacion = null;
			if($data != ""){
				$ot_correctivo = OtCorrectivo::getOtByCodigo($data)->get();
				$ot_preventivo = OrdenesTrabajoPreventivo::getOtByCodigo($data)->get();
				$ot_verificacion = OrdenesTrabajoVerifMetrologica::getOtByCodigo($data)->get();
				$ot_retiro = OtRetiro::getOtByCodigo($data)->get();
				if(count($ot_correctivo)>0 || count($ot_preventivo)>0 || count($ot_verificacion)>0 || count($ot_retiro)>0)
					$existe = true;
			}
			return Response::json(array( 'success' => true, 'existe' => $existe),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}	

}