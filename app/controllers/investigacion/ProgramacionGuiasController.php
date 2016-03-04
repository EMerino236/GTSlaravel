<?php

class ProgramacionGuiasController extends \BaseController {

	public function list_programacion_guias()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["search_usuario"] = null;		
				$data["search_fecha"] = null;	
				$data["anho_actual"] = date('Y');
				$data["dia_actual"] = date('d');
				$data["mes_actual"] = date('m');
				$data["usuarios_responsable_data"] = ProgramacionGuiaTS::getTodosUsuarios($data["anho_actual"])->get();
				$data["programaciones_reporte_ts"] = ProgramacionGuiaTS::getProgramacionesReporteTS($data["anho_actual"])->get();
				$data["programaciones_reporte_etes"] = ProgramacionReporteETES::getProgramacionesReporteETES($data["anho_actual"]);
				$data["programaciones_reporte_gpc"] = ProgramacionGuiaGPC::getProgramacionesReporteGPC($data["anho_actual"])->get();
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
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
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
				$data["programaciones_reporte_gpc"] = ProgramacionGuiaGPC::getProgramacionesReporteGPC($data["search_fecha"])->get();
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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_ts"] = SubtipoDocumentoInf::where('id_tipo','4')->lists('nombre','id'); //TS
				$data["tipo_reporte_etes"] = TipoReporteETES::lists('nombre','idtipo_reporte_ETES');
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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
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

	public function submit_create_programacion_reporte_gpc(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(						
							'fecha_publicacion' => 'required',
							'fecha_gpc' => 'required',
							'nombre_gpc' => 'required|unique:documentosinf,nombre',				
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('programacion_guias/create_programacion_guias')->withErrors($validator)->withInput(Input::all());					
				}else{					
					$programacion_guia_gpc = new ProgramacionGuiaGPC;
					$programacion_guia_gpc->fecha_publicacion = Input::get('fecha_publicacion');
					$programacion_guia_gpc->iduser = $data["user"]->id;
					$programacion_guia_gpc->fecha = date("Y-m-d",strtotime(Input::get('fecha_gpc')));
					$programacion_guia_gpc->nombre_reporte = Input::get('nombre_gpc');
					$programacion_guia_gpc->id_estado = 1;
					$programacion_guia_gpc->save();

					Session::flash('message', 'Se registró correctamente la programación de Guía de Práctica Clínica.');
					return Redirect::to('programacion_guias/create_programacion_guias');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

}
