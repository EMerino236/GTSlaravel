<?php

class RetiroServicioController extends BaseController {

	private static $nombre_tabla = 'estado_ot';
	//private static $equipo_noint = 'estado_equipo_noint';
	private static $estado_activo = 'estado_activo';

	public function list_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search_ing"] = null;
				$data["search_cod_pat"] = null;
				$data["search_ubicacion"] = null;
				$data["search_ot"] = null;
				$data["search_equipo"] = null;
				$data["search_proveedor"] = null;
				$data["search_ini"] = null;
				$data["search_fin"] = null;
				$data["retiro_servicios_data"] = OtRetiro::getOtsRetiroServicioInfo()->paginate(10);
				return View::make('retiro_servicio/listOtRetiroServicio',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_ot_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){

				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');

				$data["search_ing"] = Input::get('search_ing');
				$data["search_cod_pat"] = Input::get('search_cod_pat');
				$data["search_ubicacion"] = Input::get('search_ubicacion');
				$data["search_ot"] = Input::get('search_ot');
				$data["search_equipo"] = Input::get('search_equipo');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["search_ini"] = Input::get('search_ini');
				$data["search_fin"] = Input::get('search_fin');
				$data["retiro_servicios_data"] = OtRetiro::searchOtsRetiroServicio($data["search_ing"],$data["search_cod_pat"],$data["search_ubicacion"],$data["search_ot"],$data["search_equipo"],$data["search_proveedor"],$data["search_ini"],$data["search_fin"])->paginate(10);
				return View::make('retiro_servicio/listOtRetiroServicio',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
	/*
	** REPORTE DE RETIRO
	*/
	public function render_create_reporte_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3){
				$data["activos"] = Activo::lists('codigo_patrimonial','idactivo');
				$data["motivos"] = MotivoRetiro::lists('nombre','idmotivo_retiro');
				return View::make('retiro_servicio/createReporteRetiroServicio',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function getCorrelativeReportNumber(){
		$sot = ReporteRetiro::getReportesRetiro()->first();
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

	public function submit_create_reporte_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'cod_pat' => 'Código Patrimonial',
							'idmotivo_retiro' => 'Motivo',
							'descripcion' => 'Descripción',
							'costo' => 'Costo',
							'fecha_baja' => 'Fecha de Baja',
						);
				$messages = array();
				$rules = array(
							'cod_pat' => 'required',
							'idmotivo_retiro' => 'required',
							'descripcion' => 'required|max:200|alpha_num_spaces_colon',
							'costo' => array('required','regex:/^\d*(\.\d{2})?$/'),
							'fecha_baja' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('retiro_servicio/create_reporte_retiro_servicio')->withErrors($validator)->withInput(Input::all());
				}else{
					$cod_pat = Input::get('cod_pat');
					$equipo = Activo::searchActivosByCodigoPatrimonial($cod_pat)->get();
					if(!$equipo->isEmpty()){
						$equipo = $equipo[0];
						$string = $this->getCorrelativeReportNumber();
						$reporte_retiro = new ReporteRetiro;
						$reporte_retiro->reporte_tipo_abreviatura = "BV";
						$reporte_retiro->reporte_correlativo = $string;
						$reporte_retiro->reporte_activo_abreviatura = "TS";
						$reporte_retiro->idactivo = $equipo->idactivo;
						$reporte_retiro->descripcion = Input::get('descripcion');
						$reporte_retiro->idmotivo_retiro = Input::get('idmotivo_retiro');
						$reporte_retiro->fecha_baja = date('Y-m-d H:i:s',strtotime(Input::get('fecha_baja')));
						$reporte_retiro->costo = Input::get('costo');
						$reporte_retiro->save();
						Session::flash('message', 'Se creó correctamente el informe.');
						return Redirect::to('/retiro_servicio/list_reporte_retiro_servicio');
					}else{
						Session::flash('error', 'No se encontró un activo con el código patrimonial ingresado.');
						return Redirect::to('retiro_servicio/create_reporte_retiro_servicio');
					}
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_reporte_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["motivos"] = MotivoRetiro::lists('nombre','idmotivo_retiro');
				$data["marcas"] = Marca::lists('nombre','idmarca');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');
				$data["search_motivo"] = null;
				$data["search_equipo"] = null;
				$data["search_cod_pat"] = null;
				$data["search_marca"] = null;
				$data["search_servicio"] = null;
				$data["search_proveedor"] = null;
				$data["reporte_retiros_data"] = ReporteRetiro::getReportesRetiroInfo()->paginate(10);
				return View::make('retiro_servicio/listReporteRetiroServicio',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_reporte_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["motivos"] = MotivoRetiro::lists('nombre','idmotivo_retiro');
				$data["marcas"] = Marca::lists('nombre','idmarca');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');

				$data["search_motivo"] = Input::get('search_motivo');
				$data["search_equipo"] = Input::get('search_equipo');
				$data["search_cod_pat"] = Input::get('search_cod_pat');
				$data["search_marca"] = Input::get('search_marca');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["reporte_retiros_data"] = ReporteRetiro::searchReportesRetiroInfo($data["search_motivo"],$data["search_equipo"],$data["search_cod_pat"],$data["search_marca"],$data["search_servicio"],$data["search_proveedor"])->paginate(10);
				return View::make('retiro_servicio/listReporteRetiroServicio',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_reporte_retiro_servicio($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3) && $id){
				//$data["activos"] = Activo::lists('codigo_patrimonial','idactivo');
				$data["motivos"] = MotivoRetiro::lists('nombre','idmotivo_retiro');
				$data["reporte_info"] = ReporteRetiro::searchReportesRetiroById($id)->get();
				if($data["reporte_info"]->isEmpty()){
					return Redirect::to('retiro_servicio/list_reporte_retiro_servicio');
				}
				$data["reporte_info"] = $data["reporte_info"][0];
				return View::make('retiro_servicio/editReporteRetiroServicio',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_reporte_retiro_servicio($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $id){
				//$data["activos"] = Activo::lists('codigo_patrimonial','idactivo');
				$data["motivos"] = MotivoRetiro::lists('nombre','idmotivo_retiro');
				$data["reporte_info"] = ReporteRetiro::searchReportesRetiroById($id)->get();
				if($data["reporte_info"]->isEmpty()){
					return Redirect::to('retiro_servicio/list_reporte_retiro_servicio');
				}
				$data["reporte_info"] = $data["reporte_info"][0];
				return View::make('retiro_servicio/viewReporteRetiroServicio',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_reporte_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3){
				$reporte_retiro = ReporteRetiro::find(Input::get('idreporte_retiro'));
				$reporte_retiro->delete();
				Session::flash('message', 'Se eliminó correctamente la solicitud.');
				return Redirect::to('retiro_servicio/list_reporte_retiro_servicio');
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
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
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

	public function render_program_ot_retiro_servicio($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $id){
				$data['mes_ini'] = date("Y-m-d",strtotime("first day of this month"));
				$data['mes_fin'] = date("Y-m-d",strtotime("last day of this month"));
				$data['trimestre_ini'] = null;
				$data['trimestre_fin'] = null;
				$this->calcular_trimestre($data['trimestre_ini'],$data['trimestre_fin']);
				$data['mes'] = OtRetiro::getOtXPeriodo(9,$data['mes_ini'],$data['mes_fin'])->get()->count();
				$data['trimestre'] = OtRetiro::getOtXPeriodo(9,$data['trimestre_ini'],$data['trimestre_fin'])->get()->count();
				$data['solicitantes'] = User::getJefes()->get();
				$data["reporte_info"] = ReporteRetiro::searchReporteById($id)->get();

				if($data["reporte_info"]->isEmpty()){
					return Redirect::to('retiro_servicio/list_retiro_servicio');
				}
				$data["reporte_info"] = $data["reporte_info"][0];
				return View::make('retiro_servicio/createProgramOt',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function calcular_trimestre(&$fecha_ini,&$fecha_fin){
		$esteMes = date("m");
		switch($esteMes){
			case "1":
			case "4":
			case "7":
			case "10":
					$fecha_ini = date("Y-m-d",strtotime("first day of this month"));
					$fecha_fin = date("Y-m-d",strtotime("last day of +2 month"));
					break;
			case "2":
			case "5":
			case "8":
			case "11":
					$fecha_ini = date("Y-m-d",strtotime("first day of -1 month"));
					$fecha_fin = date("Y-m-d",strtotime("last day of +1 month"));
					break;
			case "3":
			case "6":
			case "9":
			case "12":
					$fecha_ini = date("Y-m-d",strtotime("first day of -2 month"));
					$fecha_fin = date("Y-m-d",strtotime("last day of this month"));
					break;
		}
		return;
	}

	public function getOtCorrelativeReportNumber(){
		$sot = OtRetiro::getOtsRetiro()->first();
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

	public function submit_program_ot_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$attributes = array(
							'fecha_programacion' => 'Fecha de Programación',
							'solicitante' => 'Solicitante',
						);
				$messages = array();
				$rules = array(
							'fecha_programacion' => 'required',
							'solicitante' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$reporte_info_id = Input::get('reporte_info_id');
				if($validator->fails()){
					$url = "retiro_servicio/programacion/".$reporte_info_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$idactivo = Input::get('idactivo');
					$activo = Activo::find($idactivo);
					// Algoritmo para añadir numeros correlativos
					$string = $this->getOtCorrelativeReportNumber();
					$ot = new OtRetiro;
					$ot->ot_tipo_abreviatura = "OT";
					$ot->ot_correlativo = $string;
					$ot->ot_activo_abreviatura = "RS";
					$ot->fecha_programacion = date('Y-m-d H:i:s',strtotime(Input::get('fecha_programacion')));
					$ot->idreporte_retiro = $reporte_info_id;
					$ot->idactivo = $idactivo;
					$ot->idservicio = $activo->idservicio;
					$ot->idestado_ot = 9; // A mejorar este hardcode :/
					$ot->id_usuarioelaborador = $data["user"]->id;
					$ot->id_usuariosolicitante = Input::get('solicitante');
					$ot->idestado_inicial = $activo->idestado;
					$ot->idubicacion_fisica = $activo->idubicacion_fisica;
					$ot->costo_total_personal = 0.0;
					$ot->save();
					/* Aca se le cambia el estado al reporte de donde proviene...
					$reporte_retiro = SolicitudOrdenTrabajo::find($reporte_info_id);
					$reporte_retiro->idestado = 15;
					$reporte_retiro->save();
					*/
					$url = "retiro_servicio/list_retiro_servicio";
					Session::flash('message', 'Se programó correctamente la OT.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_programaciones(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			// Check if the current user is the "System Admin"	
			$fecha_ini=date("Y-m-d",strtotime("first day of january"));
			$fecha_fin=date("Y-m-d",strtotime('last day of december'));
			$array_ot = null;	
			$array_ot =  OtRetiro::getOtXPeriodo(9,$fecha_ini,$fecha_fin)->orderBy('fecha_programacion','desc')->get()->toArray();
			$programaciones = [];
			$horas = [];
			$estados = [];
			$codigos = [];
			$length = sizeof($array_ot);
			$ids = [];

			for($i=0;$i<$length;$i++){
				$programaciones[] = date("Y-m-d",strtotime($array_ot[$i]['fecha_programacion']));
				$codigo_ot = $array_ot[$i]['ot_tipo_abreviatura'].$array_ot[$i]['ot_correlativo'].$array_ot[$i]['ot_activo_abreviatura'];
				$hora = date("H:i",strtotime($array_ot[$i]['fecha_programacion']));
				$id = $array_ot[$i]['idot_retiro'];
				$idestado = $array_ot[$i]['idestado_ot'];
				$estado = Estado::getEstadoById($idestado)->get();
				$estado = $estado[0];
				array_push($horas,$hora);
				array_push($estados, $estado);
				array_push($codigos,$codigo_ot);
				array_push($ids,$id);
			}		
			return Response::json(array( 'success' => true, 'programaciones'=> $programaciones,'horas'=>$horas,'estados'=>$estados,'ots'=>$array_ot),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function render_create_ot($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if((($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)) && $id){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$tabla_estado_activo = Tabla::getTablaByNombre(self::$estado_activo)->get();
				$data["estado_activo"] = Estado::where('idtabla','=',$tabla_estado_activo[0]->idtabla)->lists('nombre','idestado');
				
				$data["ot_info"] = OtRetiro::searchOtById($id)->get();
				if($data["ot_info"]->isEmpty()){
					Session::flash('error', 'No se encontró la OT.');
					return Redirect::to('retiro_servicio/list_retiro_servicio');
				}
				$data["ot_info"] = $data["ot_info"][0];
				$data["tareas"] = TareasOtRetiro::getTareasXOtXActi($data["ot_info"]->idot_retiro)->get();
				$data["personal_data"] = PersonalOtRetiro::getPersonalXOtXActi($data["ot_info"]->idot_retiro)->get();
				return View::make('retiro_servicio/createOtRetiroServicio',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
	
	public function submit_create_ot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4)){
				$idot_retiro = Input::get('idot_retiro');
				// Validate the info, create rules for the inputs
				$attributes = array(
							'idestado' => 'Estado',
							'idestado_inicial' => 'Estado Inicial del Activo',
							'idestado_final' => 'Estado Final del Activo',
							'fecha_conformidad' => 'Fecha de Conformidad',
							);
				$messages = array();
				$rules = array(
							'idestado' => 'required',
							'idestado_inicial' => 'required',
							'idestado_final' => 'required',
							'fecha_conformidad' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('retiro_servicio/create_ot/'.$idot_retiro)->withErrors($validator)->withInput(Input::all());
				}else{
					$ot = OtRetiro::find($idot_retiro);
					//$ot->idprioridad = Input::get('prioridades');
					$ot->idestado_ot = Input::get('idestado');
					$ot->idestado_inicial = Input::get('idestado_inicial');
					$ot->idestado_final = Input::get('idestado_final');
					$ot->fecha_conformidad = date("Y-m-d H:i:s",strtotime(Input::get('fecha_conformidad')));
					$ot->save();

					$activo = Activo::find(Input::get('idactivo'));
					$activo->idestado = Input::get('idestado_final');
					$activo->save();
					Session::flash('message', 'Se guardó correctamente la información.');
					return Redirect::to('retiro_servicio/list_retiro_servicio');
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_tarea_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			$tarea = new TareasOtRetiro;
			$tarea->nombre = Input::get('nombre_tarea');
			$tarea->idot_retiro = Input::get('idot_retiro');
			$tarea->idestado_realizado = 24;
			$tarea->save();
			return Response::json(array( 'success' => true, 'tarea' => $tarea),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_delete_tarea_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			$tarea = TareasOtRetiro::find(Input::get('idtareas_ot_retiro'));
			$tarea->delete();
			return Response::json(array( 'success' => true),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_create_personal_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

			$personal = new PersonalOtRetiro;
			$personal->nombre = Input::get('nombre_personal');
			$personal->horas_hombre = Input::get('horas_trabajadas');
			$personal->costo = Input::get('costo_personal');
			$personal->idot_retiro = Input::get('idot_retiro');
			$personal->save();
			$ot = OtRetiro::find(Input::get('idot_retiro'));
			$ot->costo_total_personal = $ot->costo_total_personal + Input::get('horas_trabajadas')*Input::get('costo_personal');
			$ot->save();
			return Response::json(array( 'success' => true,'personal'=>$personal,'costo_total_personal' => number_format($ot->costo_total_personal,2)),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_delete_personal_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

			$personal = PersonalOtRetiro::find(Input::get('idpersonal_ot_retiro'));
			$ot = OtRetiro::find(Input::get('idot_retiro'));
			$ot->costo_total_personal = $ot->costo_total_personal - $personal->horas_hombre*$personal->costo;
			$ot->save();
			$personal->delete();
			return Response::json(array( 'success' => true,'costo_total_personal' => number_format($ot->costo_total_personal,2)),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function export_pdf(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				
				$idot_retiro = Input::get('idot_retiro');
				$ot_retiro = OtRetiro::searchOtById($idot_retiro)->get();
				if($ot_retiro->isEmpty()){
					Session::flash('error', 'No se encontró la OT.');
					return Redirect::to('retiro_servicio/list_retiro_servicio');
				}
				$data["ot_retiro"] = $ot_retiro[0];
				$data["tareas"] = TareasOtRetiro::getTareasXOtXActi($idot_retiro)->get();
				$data["personal"] = PersonalOtRetiro::getPersonalXOtXActi($idot_retiro)->get();
				$data["estado_ot"] = Estado::find($data["ot_retiro"]->idestado_ot);
				$data["estado_inicial_activo"] = Estado::find($data["ot_retiro"]->idestado_inicial);
				$data["estado_final_activo"] = Estado::find($data["ot_retiro"]->idestado_final);
				$html = View::make('retiro_servicio/otRetiroServicioExport',$data);

				
				return PDF::load($html,"A4","portrait")->show();
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_ot($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if((($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)) && $id){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$tabla_estado_activo = Tabla::getTablaByNombre(self::$estado_activo)->get();
				$data["estado_activo"] = Estado::where('idtabla','=',$tabla_estado_activo[0]->idtabla)->lists('nombre','idestado');
				
				$data["ot_info"] = OtRetiro::searchOtById($id)->get();
				if($data["ot_info"]->isEmpty()){
					Session::flash('error', 'No se encontró la OT.');
					return Redirect::to('retiro_servicio/list_retiro_servicio');
				}
				$data["ot_info"] = $data["ot_info"][0];
				$data["tareas"] = TareasOtRetiro::getTareasXOtXActi($data["ot_info"]->idot_retiro)->get();
				$data["personal_data"] = PersonalOtRetiro::getPersonalXOtXActi($data["ot_info"]->idot_retiro)->get();
				return View::make('retiro_servicio/viewOtRetiroServicio',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}