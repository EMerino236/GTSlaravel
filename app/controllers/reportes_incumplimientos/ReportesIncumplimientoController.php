<?php

class ReportesIncumplimientoController extends BaseController
{
	public function list_reportes_incumplimiento()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["search_proveedor"] = null;
				$data["fecha_desde"] = null;
				$data["fecha_hasta"] = null;
				$data["search_tipo_reporte"] = null;
				$data["reportes_data"] = ReporteIncumplimiento::getReporteIncumplimientoInfo()->paginate(10);
				array_unshift($data["proveedor"], "Seleccione");
				return View::make('reportes_incumplimiento/listReportesIncumplimientos',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_reporte(){
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
				return View::make('reportes_incumplimiento/listReportesIncumplimientos',$data);	
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_reporte()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){	
				$data["tipo_documento"] = TipoDocumento::lists('nombre','idtipo_documento');
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["servicios"] = Servicio::searchServiciosClinicos(1)->lists('nombre','idservicio');
			
				return View::make('reportes_incumplimiento/createReporteIncumplimiento',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_reporte($idreporte=null){
		
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idreporte)
			{	
				$data["reporte_data"] = ReporteIncumplimiento::getReporteIncumplimientoById($idreporte)->get();
				
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				$data["servicios"] = Servicio::searchServiciosClinicos(1)->lists('nombre','idservicio');
				//$data["usuario_revision"] = User::searchUserById()
				if($data["reporte_data"]->isEmpty()){
					return Redirect::to('reportes_incumplimiento/list_reportes');
				}
				$data["reporte_data"] = $data["reporte_data"][0];

				return View::make('reportes_incumplimiento/editReporteIncumplimiento',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}

	}

	public function return_responsable_servicio(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
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
		if($data["user"]->idrol == 1){
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

	public function submit_create_reporte(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'numero_ot' => 'required',
							'tipo_reporte' => 'required',
							'numero_doc1' => 'required',
							'fecha' => 'required',
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
					return Redirect::to('reportes_incumplimiento/create_reporte')->withErrors($validator)->withInput(Input::all());
				}else{
					$reporte = new ReporteIncumplimiento;
					$reporte->idordenes_trabajo = Input::get('numero_ot'); 
					$reporte->tipo_reporte = Input::get('tipo_reporte');
					$reporte->fecha = date('Y-m-d H:i:s',strtotime(Input::get('fecha')));
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
					Session::flash('message', 'Se registró correctamente el area.');
					return Redirect::to('reportes_incumplimiento/create_reporte');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}	
}