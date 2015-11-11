<?php

class OtController extends BaseController {

	private static $nombre_tabla = 'estado_ot';
	//private static $equipo_noint = 'estado_equipo_noint';
	private static $estado_activo = 'estado_activo';

	public function render_program_ot_mant_correctivo($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 && $id){
				$mes_ini = date("Y-m-d",strtotime("first day of this month"));
				$mes_fin = date("Y-m-d",strtotime("last day of this month"));
				$trimestre_ini = null;
				$trimestre_fin = null;
				$this->calcular_trimestre($trimestre_ini,$trimestre_fin);
				$data['mes'] = OtCorrectivo::getOtXPeriodo(9,$mes_ini,$mes_fin)->get()->count();
				$data['trimestre'] = OtCorrectivo::getOtXPeriodo(9,$trimestre_ini,$trimestre_fin)->get()->count();
				$data['solicitantes'] = User::getJefes()->get();
				$data["sot_info"] = SolicitudOrdenTrabajo::searchSotById($id)->get();
				$data["prioridades"] = Prioridad::lists('nombre','idprioridad');
				$data["tipo_fallas"] = TipoFalla::lists('nombre','idtipo_falla');

				if($data["sot_info"]->isEmpty()){
					return Redirect::to('sot/list_sots');
				}
				$data["sot_info"] = $data["sot_info"][0];
				return View::make('ot/createProgramOtMantCo',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function getCorrelativeReportNumber(){
		$ot = OtCorrectivo::getOtsCorrectivo()->first();
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

	public function submit_program_ot_mant_correctivo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'fecha_programacion' => 'required',
							'solicitante' => 'required',
							'idprioridad' => 'required',
							'idtipo_falla' => 'required',
							'numero_ficha' => 'required|numeric',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$sot_id = Input::get('sot_id');
				if($validator->fails()){
					$url = "mant_correctivo/programacion/".$sot_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$idactivo = Input::get('idactivo');
					$activo = Activo::find($idactivo);
					// Algoritmo para añadir numeros correlativos
					$string = $this->getCorrelativeReportNumber();
					$ot = new OtCorrectivo;
					$ot->ot_tipo_abreviatura = "MC";
					$ot->ot_correlativo = $string;
					$ot->ot_activo_abreviatura = "TS";
					$ot->fecha_programacion = date('Y-m-d H:i:s',strtotime(Input::get('fecha_programacion')));
					$ot->idsolicitud_orden_trabajo = $sot_id;
					$ot->idactivo = $idactivo;
					$ot->idservicio = $activo->idservicio;
					$ot->idestado_ot = 9; // A mejorar este hardcode :/
					$ot->id_usuarioelaborador = $data["user"]->id;
					$ot->id_usuariosolicitante = Input::get('solicitante');
					$ot->idtipo_falla = Input::get('idtipo_falla');
					$ot->idprioridad = Input::get('idprioridad');
					$ot->numero_ficha = Input::get('numero_ficha');
					$ot->idestado_inicial = $activo->idestado;
					$ot->idubicacion_fisica = $activo->idubicacion_fisica;
					$ot->costo_total_repuestos = 0.0;
					$ot->costo_total_personal = 0.0;
					$ot->save();
					$url = "mant_correctivo/list_mant_correctivo";
					Session::flash('message', 'Se programó correctamente la OT.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function calendario_ot_mant_correctivo_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			$idactivo = Input::get('idactivo');
			$fecha_ini = null;
			$fecha_fin = null;
			$this->calcular_trimestre($fecha_ini,$fecha_fin);
			$data['programaciones'] = OtCorrectivo::getOtXPeriodo(9,$fecha_ini,$fecha_fin)->get()->toArray();
			$programaciones = [];
			$length = sizeof($data['programaciones']);
			for($i=0;$i<$length;$i++){
				$programaciones[] = date("Y-m-d",strtotime($data['programaciones'][$i]['fecha_programacion']));
			}
			$data['programaciones'] = $programaciones;
			//$data['programaciones'] = array("2015-10-30","2015-10-26","2015-10-03");
			return Response::json(array( 'success' => true,'programaciones'=>$data['programaciones']),200);
		}else{
			return Response::json(array( 'success' => false ),200);
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

	public function list_mant_correctivo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
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
				$data["mant_correctivos_data"] = OtCorrectivo::getOtsMantCorrectivoInfo()->paginate(10);
				return View::make('ot/listOtMantCorrectivo',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_ot_mant_correctivo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){

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
				$data["mant_correctivos_data"] = OtCorrectivo::searchOtsMantCorrectivo($data["search_ing"],$data["search_cod_pat"],$data["search_ubicacion"],$data["search_ot"],$data["search_equipo"],$data["search_proveedor"],$data["search_ini"],$data["search_fin"])->paginate(10);
				return View::make('ot/listOtMantCorrectivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_ot($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $id){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["prioridades"] = Prioridad::lists('nombre','idprioridad');
				$data["tipo_fallas"] = TipoFalla::lists('nombre','idtipo_falla');
				$tabla_estado_activo = Tabla::getTablaByNombre(self::$estado_activo)->get();
				$data["estado_activo"] = Estado::where('idtabla','=',$tabla_estado_activo[0]->idtabla)->lists('nombre','idestado');
				
				$data["ot_info"] = OtCorrectivo::searchOtById($id)->get();
				if($data["ot_info"]->isEmpty()){
					return Redirect::to('ot/createOtMantCo');
				}
				$data["ot_info"] = $data["ot_info"][0];
				$data["tareas"] = TareasOtCorrectivo::getTareasXOtXActi($data["ot_info"]->idot_correctivo)->get();
				$data["repuestos"] = RepuestosOtCorrectivo::getRepuestosXOtXActi($data["ot_info"]->idot_correctivo)->get();
				$data["personal_data"] = PersonalOtCorrectivo::getPersonalXOtXActi($data["ot_info"]->idot_correctivo)->get();
				return View::make('ot/createOtMantCo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_ot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1)){
				$idot_correctivo = Input::get('idot_correctivo');
				// Validate the info, create rules for the inputs
				$rules = array(
							'prioridades' => 'required',
							'idestado' => 'required',
							'descripcion_problema' => 'required|max:500',
							'tipo_falla' => 'required',
							'idestado_inicial' => 'required',
							'diagnostico_falla' => 'required|max:500',
							'sin_interrupcion_servicio' => 'required',
							'idestado_final' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('mant_correctivo/create_ot/'.$idot_correctivo)->withErrors($validator)->withInput(Input::all());
				}else{
					$ot = OtCorrectivo::find($idot_correctivo);
					//$ot->idprioridad = Input::get('prioridades');
					$ot->idestado_ot = Input::get('idestado');
					$ot->descripcion_problema = Input::get('descripcion_problema');
					$ot->idtipo_falla = Input::get('tipo_falla');
					//$ot->idestado_inicial = Input::get('idestado_inicial');
					$ot->diagnostico_falla = Input::get('diagnostico_falla');
					$ot->sin_interrupcion_servicio = Input::get('sin_interrupcion_servicio');
					$ot->idestado_final = Input::get('idestado_final');
					if(Input::get('fecha_conformidad'))
						$ot->fecha_conformidad = Input::get('fecha_conformidad');
					if(Input::get('fecha_inicio_ejecucion'))
						$ot->fecha_inicio_ejecucion = Input::get('fecha_inicio_ejecucion');
					if(Input::get('fecha_termino_ejecucion'))
						$ot->fecha_termino_ejecucion = Input::get('fecha_termino_ejecucion');
					$ot->save();

					$activo = Activo::find(Input::get('idactivo'));
					$activo->idestado = Input::get('idestado_final');
					$activo->save();
					Session::flash('message', 'Se guardó correctamente la información.');
					return Redirect::to('mant_correctivo/create_ot/'.$idot_correctivo);
				}
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_tarea_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			$tarea = new TareasOtCorrectivo;
			$tarea->nombre = Input::get('nombre_tarea');
			$tarea->idot_correctivo = Input::get('idot_correctivo');
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
		if($data["user"]->idrol == 1){
			$tarea = TareasOtCorrectivo::find(Input::get('idtareas_ot_correctivo'));
			$tarea->delete();
			return Response::json(array( 'success' => true),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_create_repuesto_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){

			$repuesto = new RepuestosOtCorrectivo;
			$repuesto->nombre = Input::get('nombre_repuesto');
			$repuesto->codigo = Input::get('codigo_repuesto');
			$repuesto->cantidad = Input::get('cantidad_repuesto');
			$repuesto->costo = Input::get('costo_repuesto');
			$repuesto->idot_correctivo = Input::get('idot_correctivo');
			$repuesto->save();
			$ot = OtCorrectivo::find(Input::get('idot_correctivo'));
			$ot->costo_total_repuestos = $ot->costo_total_repuestos + Input::get('cantidad_repuesto')*Input::get('costo_repuesto');
			$ot->save();
			return Response::json(array( 'success' => true,'repuesto'=>$repuesto,'costo_total_repuestos' => number_format($ot->costo_total_repuestos,2)),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_delete_repuesto_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){

			$repuesto = RepuestosOtCorrectivo::find(Input::get('idrepuestos_ot_correctivo'));
			$ot = OtCorrectivo::find(Input::get('idot_correctivo'));
			$ot->costo_total_repuestos = $ot->costo_total_repuestos - $repuesto->cantidad*$repuesto->costo;
			$ot->save();
			$repuesto->delete();
			return Response::json(array( 'success' => true,'costo_total_repuestos' => number_format($ot->costo_total_repuestos,2)),200);
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
		if($data["user"]->idrol == 1){

			$personal = new PersonalOtCorrectivo;
			$personal->nombre = Input::get('nombre_personal');
			$personal->horas_hombre = Input::get('horas_trabajadas');
			$personal->costo = Input::get('costo_personal');
			$personal->idot_correctivo = Input::get('idot_correctivo');
			$personal->save();
			$ot = OtCorrectivo::find(Input::get('idot_correctivo'));
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
		if($data["user"]->idrol == 1){

			$personal = PersonalOtCorrectivo::find(Input::get('idpersonal_ot_correctivo'));
			$ot = OtCorrectivo::find(Input::get('idot_correctivo'));
			$ot->costo_total_personal = $ot->costo_total_personal - $personal->horas_hombre*$personal->costo;
			$ot->save();
			$personal->delete();
			return Response::json(array( 'success' => true,'costo_total_personal' => number_format($ot->costo_total_personal,2)),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}