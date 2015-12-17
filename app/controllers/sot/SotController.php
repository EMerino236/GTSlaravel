<?php

class SotController extends BaseController {

	private static $nombre_tabla = 'estado_sot';

	public function render_create_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estado"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->first();//El primer estado siempre es pendiente

				$data["activos"] = Activo::lists('codigo_patrimonial','idactivo');
				return View::make('sot/createSot',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function getCorrelativeReportNumber(){
		$sot = SolicitudOrdenTrabajo::getSots()->first();
		$string = "";
		if($sot!=null){	
			$numero = $sot->sot_correlativo;
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

	public function submit_create_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'cod_pat' => 'Código Patrimonial',
							'fecha_solicitud' => 'Fecha de Solicitud',
							'especificacion_servicio' => 'Especificación de Servicio',
							'motivo' => 'Motivo',
							'justificacion' => 'Justificación'
					);
				$messages = array();
				$rules = array(
							'cod_pat' => 'required|numeric',
							'fecha_solicitud' => 'required',
							'especificacion_servicio' => 'required|max:100|alpha_num_spaces_colon',
							'motivo' => 'required|max:200|alpha_num_spaces_colon',
							'justificacion' => 'required|max:200|alpha_num_spaces_colon'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('sot/create_sot')->withErrors($validator)->withInput(Input::all());
				}else{

					$cod_pat = Input::get('cod_pat');
					$equipo = Activo::searchActivosByCodigoPatrimonial($cod_pat)->get();
					if(!$equipo->isEmpty()){
						$equipo = $equipo[0];
						$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
						$estado = Estado::where('idtabla','=',$tabla[0]->idtabla)->first();//El primer estado siempre es pendiente
						// Algoritmo para añadir numeros correlativos
						$string = $this->getCorrelativeReportNumber();
						$sot = new SolicitudOrdenTrabajo;
						$sot->sot_tipo_abreviatura = "SOT";
						$sot->sot_correlativo = $string;
						$sot->sot_activo_abreviatura = "TS";
						$sot->fecha_solicitud = date('Y-m-d H:i:s',strtotime(Input::get('fecha_solicitud')));
						$sot->especificacion_servicio = Input::get('especificacion_servicio');
						$sot->idestado = $estado->idestado;
						$sot->idactivo = $equipo->idactivo;
						$sot->motivo = Input::get('motivo');
						$sot->justificacion = Input::get('justificacion');
						$sot->id = $data["user"]->id;
						$sot->save();
						Session::flash('message', 'Se generó correctamente la solicitud.');
						return Redirect::to('sot/create_sot');
					}else{
						Session::flash('error', 'No se encontró un activo con el código patrimonial ingresado.');
						return Redirect::to('sot/create_sot');
					}
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_sots()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search"] = null;
				$data["search_estado"] = null;
				$data["search_ini"] = null;
				$data["search_fin"] = null;
				$data["sots_data"] = SolicitudOrdenTrabajo::getSotsInfo()->paginate(10);
				return View::make('sot/listSots',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_sot($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $id){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["sot_info"] = SolicitudOrdenTrabajo::searchSotById($id)->get();
				if($data["sot_info"]->isEmpty()){
					return Redirect::to('user/list_proveedores');
				}
				$data["sot_info"] = $data["sot_info"][0];
				return View::make('sot/editSot',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
	
	public function submit_disable_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9){
				$sot_id = Input::get('sot_id');
				$sot = SolicitudOrdenTrabajo::find($sot_id);
				$sot->idestado = 16; // Si se elimina la SOT, se le cambia de estado a Falsa Alarma
				$sot->save();
				Session::flash('message', 'Se marcó correctamente la solicitud como Falsa Alarma.');
				return Redirect::to("sot/list_sots/");
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_sot_false_alarm()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9){
				$sot_id = Input::get('sot_id');
				$sot = SolicitudOrdenTrabajo::find($sot_id);
				$sot->idestado = 26; // Si se elimina la SOT, se le cambia de estado a Mal Ingreso
				$sot->save();
				Session::flash('message', 'Se marcó correctamente la solicitud como Mal Ingreso.');
				return Redirect::to("sot/list_sots/");
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){

				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search"] = Input::get('search');
				$data["search_estado"] = Input::get('search_estado');
				$data["search_ini"] = Input::get('search_ini');
				$data["search_fin"] = Input::get('search_fin');
				$data["sots_data"] = SolicitudOrdenTrabajo::searchSots($data["search"],$data["search_estado"],$data["search_ini"],$data["search_fin"])->paginate(10);
				return View::make('sot/listSots',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_program_ot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$sot_id = Input::get('sot_id');
				$url = "mant_correctivo/programacion/".$sot_id;
				$sot = SolicitudOrdenTrabajo::find($sot_id);
				//$sot->idestado = 15; // Estado de Aprobado
				$sot->save();
				Session::flash('message', 'Proceda a programar la OT');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_equipo_ajax(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$equipo = Activo::searchActivosByCodigoPatrimonial($data)->get();
				if(!$equipo->isEmpty()){
					$equipo = $equipo[0];
				}else{
				 	$equipo = null;
				}
			}else{
				$equipo = null;
			}

			return Response::json(array( 'success' => true, 'equipo' => $equipo ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}