<?php

class ProgramacionGuiasController extends \BaseController {

	public function list_programacion_guias()
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
				$data["usuarios_responsable_data"] = ProgramacionGuiaTS::getTodosUsuarios($data["anho_actual"])->get();
				$data["programaciones_reporte_ts"] = ProgramacionGuiaTS::getProgramacionesReporteTS($data["anho_actual"])->get();
				$data["programaciones_reporte_etes"] = ProgramacionReporteETES::getProgramacionesReporteETES($data["anho_actual"]);
				$data["programaciones_reporte_paac"] = ProgramacionGuiaGPC::getProgramacionesReporteGPC($data["anho_actual"]);
				return View::make('investigacion/programacion/listProgramacionGuias',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_programacion_guias()
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
				$data["usuarios_responsable_data"] = ProgramacionGuiaTS::searchTodosUsuarios($data["search_fecha"],$data["search_usuario"])->get();
				$data["programaciones_reporte_ts"] = ProgramacionGuiaTS::getProgramacionesReporteTS($data["search_fecha"])->get();
				$data["programaciones_reporte_etes"] = ProgramacionReporteETES::getProgramacionesReporteETES($data["search_fecha"]);
				$data["programaciones_reporte_paac"] = ProgramacionReportePAAC::getProgramacionesReportePAAC($data["search_fecha"]);
				return View::make('investigacion/programacion/listProgramacionGuias',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_programacion_guias()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_ts"] = SubtipoDocumentoInf::where('id_tipo','4')->lists('nombre','id'); //TS
				$data["tipo_reporte_etes"] = TipoReporteETES::lists('nombre','idtipo_reporte_ETES');
				$data["tipo_reporte_paac"] = SubtipoDocumentoInf::where('id_tipo','7')->lists('nombre','id'); //GPC
				$data["reporte_cn_info"] = null;
				return View::make('investigacion/programacion/createProgramacionGuia',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_programacion_reporte_ts(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
				// Validate the info, create rules for the inputs	
				$rules = array(	
							'idtipo_reporte_ts' => 'required',
							'fecha_ts' => 'required',
							'nombre_ts' => 'required|unique:documentosinf,nombre',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('programacion_guias/create_programacion_guias')->withErrors($validator)->withInput(Input::all());					
				}else{
						$programacion_guia_ts = new ProgramacionGuiaTS;
						$programacion_guia_ts->id_tipo = Input::get('idtipo_reporte_ts');
						$programacion_guia_ts->iduser = $data["user"]->id;
						$programacion_guia_ts->fecha = date("Y-m-d",strtotime(Input::get('fecha_ts')));
						$programacion_guia_ts->nombre_reporte = Input::get('nombre_ts');
						$programacion_guia_ts->id_estado = 1;
						$programacion_guia_ts->save();
					
					Session::flash('message', 'Se registró correctamente la programación de Guia de Tecnología de Salud.');
					return Redirect::to('programacion_guias/create_programacion_guias');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	//////////////////////////////////////////////////////////////

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
					$programacion_reporte_paac->iduser = Input::get('idresponsable_paac');
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

}
