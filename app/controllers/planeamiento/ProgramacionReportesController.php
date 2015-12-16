<?php

class ProgramacionReportesController extends BaseController
{
	public function render_create_programacion_reportes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_cn"] = TipoReporteCN::lists('nombre','idtipo_reporte_CN');
				$data["tipo_reporte_etes"] = TipoReporteETES::lists('nombre','idtipo_reporte_ETES');
				$data["tipo_reporte_paac"] = TipoReportePAAC::lists('nombre','idtipo_reporte_PAAC');
				$data["reporte_cn_info"] = null;
				return View::make('programacion_reportes/createProgramacionReporte',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_programacion_reporte_cn(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'idtipo_reporte_cn' => 'required',
							'idarea_cn' => 'required',
							'fecha_cn' => 'required',
							'nombre_cn' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('programacion_reportes/create_programacion_reportes')->withErrors($validator)->withInput(Input::all());					
				}else{
						$programacion_reporte_cn = new ProgramacionReporteCN;
						$programacion_reporte_cn->idtipo_reporte_CN = Input::get('idtipo_reporte_cn');
						$programacion_reporte_cn->idservicio = Input::get('idservicio_cn');					
						$programacion_reporte_cn->iduser = $data["user"]->id;
						$programacion_reporte_cn->idarea = Input::get('idarea_cn');
						$programacion_reporte_cn->fecha = date("Y-m-d",strtotime(Input::get('fecha_cn')));
						$programacion_reporte_cn->nombre_reporte = Input::get('nombre_cn');
						$programacion_reporte_cn->idestado_programacion_reportes = 1;
						$programacion_reporte_cn->save();
					
					Session::flash('message', 'Se registró correctamente la programación de Reporte de Necesidad.');
					return Redirect::to('programacion_reportes/create_programacion_reportes');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_programacion_reporte_etes(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'idtipo_reporte_etes' => 'required',
							'fecha_etes' => 'required',
							'nombre_etes' => 'required',									
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('programacion_reportes/create_programacion_reportes')->withErrors($validator)->withInput(Input::all());					
				}else{					
					$programacion_reporte_etes = new ProgramacionReporteETES;
					$programacion_reporte_etes->idtipo_reporte_ETES = Input::get('idtipo_reporte_etes');					
					$programacion_reporte_etes->iduser = $data["user"]->id;
					$programacion_reporte_etes->fecha = date("Y-m-d",strtotime(Input::get('fecha_etes')));
					$programacion_reporte_etes->nombre_reporte = Input::get('nombre_etes');
					$programacion_reporte_etes->idestado_programacion_reportes = 1;
					$programacion_reporte_etes->save();
					
					Session::flash('message', 'Se registró correctamente la programación de Reporte ETES.');
					return Redirect::to('programacion_reportes/create_programacion_reportes');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_programacion_reporte_paac(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
				// Validate the info, create rules for the inputs	
				$rules = array(						
							'idtipo_reporte_paac' => 'required',
							'idarea_paac' => 'required',
							'fecha_paac' => 'required',
							'nombre_paac' => 'required',				
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('programacion_reportes/create_programacion_reportes')->withErrors($validator)->withInput(Input::all());					
				}else{					
					$programacion_reporte_paac = new ProgramacionReportePAAC;
					$programacion_reporte_paac->idtipo_reporte_PAAC = Input::get('idtipo_reporte_paac');
					$programacion_reporte_paac->idservicio = Input::get('idservicio_paac');					
					$programacion_reporte_paac->iduser = $data["user"]->id;
					$programacion_reporte_paac->idarea = Input::get('idarea_paac');
					$programacion_reporte_paac->fecha = date("Y-m-d",strtotime(Input::get('fecha_paac')));
					$programacion_reporte_paac->nombre_reporte = Input::get('nombre_paac');
					$programacion_reporte_paac->idestado_programacion_reportes = 1;
					$programacion_reporte_paac->save();

					Session::flash('message', 'Se registró correctamente la programación Reporte de Instalación.');
					return Redirect::to('programacion_reportes/create_programacion_reportes');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_reporte_cn($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_cn"] = TipoReporteCN::lists('nombre','idtipo_reporte_CN');
				$data["reporte_cn_info"] = ReporteCN::withTrashed()->find($id);
				$data["otretiro_info"] = OtRetiro::find($data["reporte_cn_info"]->idot_retiro);
				$data["otretiro_info"] = OtRetiro::searchOtByCodigoReporte($data["otretiro_info"]->ot_tipo_abreviatura,$data["otretiro_info"]->ot_correlativo,$data["otretiro_info"]->ot_activo_abreviatura)->get()[0];
				return View::make('reportes_CN/editReporteCN',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_programacion_reportes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_usuario"] = null;		
				$data["search_fecha"] = null;	
				$data["anho_actual"] = date('Y');
				$data["dia_actual"] = date('d');
				$data["mes_actual"] = date('m');
				$data["usuarios_responsable_data"] = ProgramacionReporteCN::getTodosUsuarios($data["anho_actual"])->get();
				$data["programaciones_reporte_cn"] = ProgramacionReporteCN::getProgramacionesReporteCN($data["anho_actual"]);
				$data["programaciones_reporte_etes"] = ProgramacionReporteETES::getProgramacionesReporteETES($data["anho_actual"]);
				$data["programaciones_reporte_paac"] = ProgramacionReportePAAC::getProgramacionesReportePAAC($data["anho_actual"]);
				return View::make('programacion_reportes/listProgramacionReportes',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_programacion_reportes()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_usuario"] = Input::get('search_usuario');	
				$data["anho_actual"] = date('Y');
				if(Input::get('search_fecha')=='')
					$data["search_fecha"] = $data["anho_actual"];
				else
					$data["search_fecha"] = Input::get('search_fecha');
				$data["dia_actual"] = date('d');
				$data["mes_actual"] = date('m');
				$data["usuarios_responsable_data"] = ProgramacionReporteCN::searchTodosUsuarios($data["search_fecha"],$data["search_usuario"])->get();
				$data["programaciones_reporte_cn"] = ProgramacionReporteCN::getProgramacionesReporteCN($data["search_fecha"]);
				$data["programaciones_reporte_etes"] = ProgramacionReporteETES::getProgramacionesReporteETES($data["search_fecha"]);
				$data["programaciones_reporte_paac"] = ProgramacionReportePAAC::getProgramacionesReportePAAC($data["search_fecha"]);
				return View::make('programacion_reportes/listProgramacionReportes',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function return_area(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$servicio = Servicio::where('idservicio','=',$data)->get();;
			}else{
				$servicio = null;
			}
			return Response::json(array( 'success' => true, 'servicio' => $servicio ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_programacion_cn(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$programacion_reporte_cn = ProgramacionReporteCN::where('idprogramacion_reporte_cn','=',$data)->get();
			}else{
				$programacion_reporte_cn = null;
			}
			return Response::json(array( 'success' => true, 'programacion_reporte_cn' => $programacion_reporte_cn ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_programacion_etes(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$programacion_reporte_etes = ProgramacionReporteETES::where('idprogramacion_reporte_etes','=',$data)->get();
			}else{
				$programacion_reporte_etes = null;
			}
			return Response::json(array( 'success' => true, 'programacion_reporte_etes' => $programacion_reporte_etes ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_programacion_paac(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$programacion_reporte_paac = ProgramacionReportePAAC::where('idprogramacion_reporte_paac','=',$data)->get();
			}else{
				$programacion_reporte_paac = null;
			}
			return Response::json(array( 'success' => true, 'programacion_reporte_paac' => $programacion_reporte_paac ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}