<?php

class SotController extends BaseController {

	private static $nombre_tabla = 'estado_sot';

	public function render_create_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["activos"] = Activo::lists('codigo_patrimonial','idactivo');
				return View::make('sot/createSot',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							//'numero_ficha' => 'required|numeric',
							'idactivo' => 'required',
							'fecha_solicitud' => 'required',
							'especificacion_servicio' => 'required|max:100',
							'idestado' => 'required',
							'motivo' => 'required|max:200',
							'justificacion' => 'required|max:200'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('sot/create_sot')->withErrors($validator)->withInput(Input::all());
				}else{
					$sot = new SolicitudOrdenTrabajo;
					$sot->fecha_solicitud = date('Y-m-d H:i:s',strtotime(Input::get('fecha_solicitud')));
					$sot->especificacion_servicio = Input::get('especificacion_servicio');
					//$sot->numero_ficha = Input::get('numero_ficha');
					$sot->idestado = Input::get('idestado');
					$sot->idactivo = Input::get('idactivo');
					$sot->motivo = Input::get('motivo');
					$sot->justificacion = Input::get('justificacion');
					$sot->id = $data["user"]->id;
					$sot->save();
					Session::flash('message', 'Se generó correctamente la solicitud.');
					return Redirect::to('sot/create_sot');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_sots()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search"] = null;
				$data["search_estado"] = null;
				$data["search_ini"] = null;
				$data["search_fin"] = null;
				$data["sots_data"] = SolicitudOrdenTrabajo::getSotsInfo()->paginate(10);
				return View::make('sot/listSots',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_sot($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $id){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["sot_info"] = SolicitudOrdenTrabajo::searchSotById($id)->get();
				if($data["sot_info"]->isEmpty()){
					return Redirect::to('user/list_proveedores');
				}
				$data["sot_info"] = $data["sot_info"][0];
				return View::make('sot/editSot',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
	/*
	public function submit_edit_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'especificacion_servicio' => 'required|max:100',
							'idestado' => 'required',
							'motivo' => 'required|max:200',
							'justificacion' => 'required|max:200'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				$sot_id = Input::get('sot_id');
				$url = "sot/edit_sot/".$sot_id;
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$sot = SolicitudOrdenTrabajo::find($sot_id);
					$sot->especificacion_servicio = Input::get('especificacion_servicio');
					$sot->idestado = Input::get('idestado');
					$sot->motivo = Input::get('motivo');
					$sot->justificacion = Input::get('justificacion');
					$sot->save();
					Session::flash('message', 'Se editó correctamente la solicitud.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
	*/
	public function submit_disable_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$sot_id = Input::get('sot_id');
				$sot = SolicitudOrdenTrabajo::find($sot_id);
				$sot->idestado = 17; // Si se elimina la SOT, se le cambia de estado a Falsa Alarma
				$sot->save();
				Session::flash('message', 'Se eliminó correctamente la solicitud.');
				return Redirect::to("sot/list_sots/");
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){

				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search"] = Input::get('search');
				$data["search_estado"] = Input::get('search_estado');
				$data["search_ini"] = Input::get('search_ini');
				$data["search_fin"] = Input::get('search_fin');
				$data["sots_data"] = SolicitudOrdenTrabajo::searchSots($data["search"],$data["search_estado"],$data["search_ini"],$data["search_fin"])->paginate(10);
				return View::make('sot/listSots',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_program_ot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
				$sot_id = Input::get('sot_id');
				$url = "mant_correctivo/programacion/".$sot_id;
				$sot = SolicitudOrdenTrabajo::find($sot_id);
				//$sot->idestado = 15; // Estado de Aprobado
				$sot->save();
				Session::flash('message', 'Proceda a programar la OT');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}
}