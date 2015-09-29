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
				$data["search"] = null;
				$data["proveedor"] = Proveedor::lists('razon_social','idproveedor');
				array_unshift($data["proveedor"], "");

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
				$data["search"] = Input::get('search');
				/*$data["tipo_servicio"] = TipoServicio::lists('nombre','idtipo_servicios'); 
				array_unshift($data["tipo_servicio"], "Todos");
				$data["servicios_data"] = Servicio::searchServicios($data["search"])->paginate(10);*/
				if($data["search"]==0){
					return Redirect::to('reportes_incumplimiento/list_reportes');
				}else{
					return View::make('reportes_incumplimiento/listReportesIncumplimientos',$data);	
				}
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
				array_unshift($data["tipo_documento"], "");
				array_unshift($data["proveedor"], "");
				array_unshift($data["servicios"], "");
				
				return View::make('reportes_incumplimiento/createReporteIncumplimiento',$data);
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
			}/*else{
				$proveedor = null;
			}*/
			return Response::json(array( 'success' => true, 'proveedor' => $data),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}