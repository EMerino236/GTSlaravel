<?php

class SotBusquedaInformacionController extends BaseController {

	public function render_create_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data['solicitantes'] = User::getJefes()->get();
				$data['tipos'] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');
				$data['areas'] = Area::lists('nombre','idarea');
				$data['encargados'] = User::getJefes()->get();
				return View::make('sot_busqueda_informacion/createSotBusquedaInformacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_sot($idsot=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $idsot)
			{	
				$data['solicitantes'] = User::getJefes()->get();
				$data['tipos'] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');
				$data['areas'] = Area::lists('nombre','idarea');
				$data['encargados'] = User::getJefes()->get();
				$data['sot_info'] = SolicitudBusquedaInformacion::searchSotById($idsot)->get();

				if($data["sot_info"]->isEmpty()){
					return Redirect::to('busqueda_informacion/list_busqueda_informacion');
				}
				$data["sot_info"] = $data["sot_info"][0];
				return View::make('sot_busqueda_informacion/editSotBusquedaInformacion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_sot($idsot=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $idsot)
			{	
				$data['solicitantes'] = User::getJefes()->get();
				$data['tipos'] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');
				$data['areas'] = Area::lists('nombre','idarea');
				$data['encargados'] = User::getJefes()->get();
				$data['sot_info'] = SolicitudBusquedaInformacion::searchSotById($idsot)->get();
				if($data["sot_info"]->isEmpty()){
					return Redirect::to('busqueda_informacion/list_busqueda_informacion');
				}
				$data["sot_info"] = $data["sot_info"][0];

				return View::make('sot_busqueda_informacion/viewSotBusquedaInformacion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_sot(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				 
				$attributes = array(
					'area' => 'Área',
					'tipo' => 'Tipo de Solicitud',
					'fecha_solicitud' => 'Fecha de Solicitud',
					'motivo' => 'Motivo de Solicitud',
					'detalle' => 'Detalle de Solicitud',
					'descripcion' => 'Descripcion de la Solicitud',
					'encargado' => 'Usuario Encargado'
					);

				$messages = array(
					);

				$rules = array(
							'area' => 'required',
							'tipo' => 'required',
							'fecha_solicitud' => 'required',
							'detalle' => 'max:500|alpha_num_spaces_slash_dash_enter',
							'motivo' => 'max:500|alpha_num_spaces_slash_dash_enter',
							'descripcion' => 'max:500|alpha_num_spaces_slash_dash_enter',
							'encargado' => 'required'
						);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);

				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('solicitud_busqueda_informacion/create_sot')->withErrors($validator)->withInput(Input::all());
				}else{
					$sot = new SolicitudBusquedaInformacion;
					$fecha = date('Y-m-d H:i:s',strtotime(Input::get('fecha_solicitud')));
					$abreviatura = "SBI";
					// Algoritmo para añadir numeros correlativos
					$string = $this->getCorrelativeReportNumberSot();
					$sot->fecha_solicitud = $fecha;
					$sot->idarea = Input::get('area');
					$sot->idestado = 14;
					$sot->idtipo_busqueda_info = Input::get('tipo');
					$sot->motivo = Input::get('motivo');
					$sot->descripcion = Input::get('descripcion');
					$sot->detalle = Input::get('detalle');
					$sot->sot_tipo_abreviatura = $abreviatura;
					$sot->sot_correlativo = $string;
					$sot->id = $data["user"]->id;
					$sot->id_usuarioencargado = Input::get('encargado');		
					$sot->save();			

					
					return Redirect::to('solicitud_busqueda_informacion/list_busqueda_informacion')->with('message', 'Se registró correctamente la solicitud: '.$sot->ot_tipo_abreviatura.$sot->ot_correlativo);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'area' => 'Área',
					'tipo' => 'Tipo de Solicitud',
					'fecha_solicitud' => 'Fecha de Solicitud',
					'motivo' => 'Motivo de Solicitud',
					'detalle' => 'Detalle de Solicitud',
					'descripcion' => 'Descripcion de la Solicitud',
					'encargado' => 'Usuario Encargado'
					);

				$messages = array(
					);

				$rules = array(
							'area' => 'required',
							'tipo' => 'required',
							'fecha_solicitud' => 'required',
							'detalle' => 'max:500|alpha_num_spaces_slash_dash_enter',
							'motivo' => 'max:500|alpha_num_spaces_slash_dash_enter',
							'descripcion' => 'max:500|alpha_num_spaces_slash_dash_enter',
							'encargado' => 'required'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$idsot = Input::get('idsot');
					$url = "solicitud_busqueda_informacion/edit_sot_busqueda_informacion"."/".$idsot;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{	
					$idsot = Input::get('idsot');				
					$url = $url = "solicitud_busqueda_informacion/edit_sot_busqueda_informacion"."/".$idsot;					
					$sot = SolicitudBusquedaInformacion::find($idsot);
					$sot->idtipo_busqueda_info = Input::get('tipo');
					$sot->motivo = Input::get('motivo');
					$sot->descripcion = Input::get('descripcion');
					$sot->detalle = Input::get('detalle');
					$sot->id_usuarioencargado = Input::get('encargado');	
					$sot->save();
					
					return Redirect::to('solicitud_busqueda_informacion/list_busqueda_informacion')->with('message', 'Se editó correctamente la solicitud de búsqueda de información: '.$sot->ot_tipo_abreviatura.$sot->ot_correlativo);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function getCorrelativeReportNumberSot(){
		$sot = SolicitudBusquedaInformacion::getLastSotBusqueda()->first();
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

	public function getCorrelativeReportNumberOt(){
		$ot = OrdenesTrabajoBusquedaInformacion::getLastOtBusqueda()->first();
		$string = "";
		if($ot!=null){	
			$numero = $ot->ot_correlativo;
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

	public function list_busqueda_informacion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_tipo"] = null;
				$data["search_area"] = null;
				$data["search_encargado"] = null;
				$data["search_ot"] = null;
				$data["search_ini"] = null;
				$data["search_fin"] = null;
				$data["areas"] = Area::lists('nombre','idarea');
				$data['solicitantes'] = User::getJefes()->get();
				$data["tipos"] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');
				$data["busquedas"] = SolicitudBusquedaInformacion::getSotsInfo()->paginate(10);
				return View::make('ot/busquedaInformacion/listOtBusquedaInformacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_ot(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
			// Check if the current user is the "System Admin"
			$idsot = Input::get('idsot');
			$sot = SolicitudBusquedaInformacion::find($idsot);
			$idsolicitante = Input::get('idsolicitante');
			$fecha_programacion = $sot->fecha_solicitud;
			$sot->idestado = 15;
			$sot->save();
			$ot = new OrdenesTrabajoBusquedaInformacion;
			$abreviatura = "BI";
			// Algoritmo para añadir numeros correlativos
			$string = $this->getCorrelativeReportNumberOt();
			$ot->fecha_programacion = $fecha_programacion;
			$ot->idarea = $sot->idarea;
			$ot->idestado_ot = 9;			
			$ot->ot_tipo_abreviatura = $abreviatura;
			$ot->ot_correlativo = $string;
			$ot->id_usuarioelaborador = $data["user"]->id;
			//el solicitante de la ot es el encargado de la sot
			$ot->id_usuariosolicitante = $sot->id;
			$ot->id_usuarioencargado = $sot->id_usuarioencargado;
			$ot->idsolicitud_busqueda_info = $idsot;	
			$ot->save();		
			

			return Response::json(array( 'success' => true ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_disable_sot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$idsot = Input::get('idsot');
				$sot = SolicitudBusquedaInformacion::find($idsot);
				$sot->idestado = 26; // Si se elimina la SOT, se le cambia de estado a Mal Ingreso
				$sot->save();
				Session::flash('message', 'Se marcó correctamente la solicitud como Mal Ingreso.');
				return Redirect::to("solicitud_busqueda_informacion/list_busqueda_informacion");
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	
}	