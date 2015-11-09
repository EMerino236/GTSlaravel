<?php

class OtPreventivoController extends BaseController {

	private static $nombre_tabla = 'estado_ot';
	//private static $equipo_noint = 'estado_equipo_noint';
	private static $estado_activo = 'estado_activo';

	public function render_program_ot_mant_preventivo($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["mes_ini"] = date("Y-m-d",strtotime("first day of this month"));;
				$data["mes_fin"] = date("Y-m-d",strtotime("last day of this month"));;
				$data["trimestre_ini"] = null;
				$data["trimestre_fin"] = null;
				$this->calcular_trimestre($data["trimestre_ini"],$data["trimestre_fin"]);
				$data['solicitantes'] = User::getJefes()->get();
				
				return View::make('ot/preventivo/createProgramOtMantPre',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_equipo_ajax(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			$mes = 0;
			$trimestre = 0;	
			$mes_ini = date("Y-m-d",strtotime(Input::get('mes_ini')));
			$mes_fin = date("Y-m-d",strtotime(Input::get('mes_fin')));			
			$trimestre_ini=date("Y-m-d",strtotime(Input::get('trimestre_ini')));
			$trimestre_fin=date("Y-m-d",strtotime(Input::get('trimestre_fin')));
			if($data !="vacio"){
				$equipo = Activo::searchActivosByCodigoPatrimonial($data)->get();
				if($equipo->isEmpty()==false){
					$equipo = $equipo[0];
					$mes = OrdenesTrabajoPreventivo::getOtXPeriodoXActivo(9,$mes_ini,$mes_fin,$equipo->idactivo)->get()->count();
					$trimestre = OrdenesTrabajoPreventivo::getOtXPeriodoXActivo(9,$trimestre_ini,$trimestre_fin,$equipo->idactivo)->get()->count();
					
				}else{
				 	$equipo = null;
				 	$mes = 0;
				 	$trimestre = 0;
				 	
				}
			}else{
				$equipo = null;
				$mes = 0;
			 	$trimestre = 0;
			}

			return Response::json(array( 'success' => true, 'equipo' => $equipo,'count_trimester'=>$trimestre, 'count_month'=>$mes ),200);
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

	public function list_mant_preventivo()
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
				$data["search_servicio"] = null;
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["mant_preventivos_data"] = OrdenesTrabajoPreventivo::getOtsMantPreventivoInfo()->get();
				return View::make('ot/preventivo/listOtMantPreventivo',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_programaciones(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"	
			$fecha_ini=date("Y-m-d",strtotime("first day of january"));
			$fecha_fin=date("Y-m-d",strtotime('last day of december'));
			$array_programaciones = null;	
			$array_programaciones =  OrdenesTrabajoPreventivo::getOtXPeriodo(9,$fecha_ini,$fecha_fin)->orderBy('fecha_programacion','desc')->get()->toArray();
			$programaciones = [];
			$equipos = [];
			$horas = [];
			$estados = [];
			$length = sizeof($array_programaciones);					
			for($i=0;$i<$length;$i++){
				$programaciones[] = date("Y-m-d",strtotime($array_programaciones[$i]['fecha_programacion']));
				$hora = date("H:i",strtotime($array_programaciones[$i]['fecha_programacion']));
				$idestado = $array_programaciones[$i]['idestado_ot'];
				$idactivo = $array_programaciones[$i]['idactivo'];
				$equipo_ot = Activo::searchActivosById($idactivo)->get();
				$equipo_ot = $equipo_ot[0];
				$estado = Estado::getEstadoById($idestado)->get();
				$estado = $estado[0];
				array_push($equipos,$equipo_ot);
				array_push($horas,$hora);
				array_push($estados, $estado);
			}
			$array_programaciones = $programaciones;		
			return Response::json(array( 'success' => true, 'programaciones'=> $array_programaciones,'equipos'=>$equipos,'horas'=>$horas,'estados'=>$estados),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_ot_mant_preventivo()
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
				$data["search_servicio"] = Input::get('search_servicio');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["mant_preventivos_data"] = OrdenesTrabajoPreventivo::searchOtsMantPreventivo($data["search_ing"],$data["search_cod_pat"],$data["search_ubicacion"],$data["search_ot"],$data["search_equipo"],$data["search_proveedor"],$data["search_ini"],$data["search_fin"],$data["search_servicio"])->paginate(10);
				return View::make('ot/preventivo/listOtMantPreventivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}	

	public function getCorrelativeReportNumber(){
		$ot = OrdenesTrabajoPreventivo::getLastOtPreventivo()->first();
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

	public function submit_program_ot_mant_preventivo(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"			
			$array_detalles = Input::get('matrix_detalle');
			$row_size = count($array_detalles);
			if($row_size==0){				
				$message = "No se cargaron todas las OTM con éxito.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}						
			//Agregar Detalle			
			if($row_size > 0){				
				$message = "Se crearon las OTM con éxito";
				$type_message = "bg-success";
				for( $i = 0; $i<$row_size; $i++ ){
					$array_detalle = $array_detalles[$i];					
					$fecha = date('Y-m-d H:i:s',strtotime($array_detalle[4]." ".$array_detalle[5]));
					$cod_pat =$array_detalle[0];
					$activo = Activo::searchActivosByCodigoPatrimonial($cod_pat)->get();					
					$activo = $activo[0];
					$idactivo = $activo->idactivo;
					$ot = new OrdenesTrabajoPreventivo;
					$abreviatura = "MP";
					// Algoritmo para añadir numeros correlativos
					$string = $this->getCorrelativeReportNumber();
					//Get Año Actual
					$ts_abreviatura = "TS";
					$ot->fecha_programacion = $fecha;
					$ot->idservicio = $activo->idservicio;
					$ot->idestado_ot = 9;
					$ot->idubicacion_fisica = $activo->idubicacion_fisica;
					$ot->id_usuarioelaborador = $data["user"]->id;
					$ot->id_usuariosolicitante = $array_detalle[6];
					$ot->idactivo = $activo->idactivo;
					$ot->ot_tipo_abreviatura = $abreviatura;
					$ot->ot_correlativo = $string;
					$ot->ot_activo_abreviatura = $ts_abreviatura;
					$ot->save();

					// Asigno las tareas
					$tareas = TareaOtPreventivo::getTareasByFamiliaActivo($activo->idfamilia_activo)->get();
					foreach($tareas as $tarea){
						$otxtarea = new OrdenesTrabajoPreventivoxTarea;
						$otxtarea->idot_preventivo = $ot->idot_preventivo;
						$otxtarea->idtareas_ot_preventivo = $tarea->idtareas_ot_preventivo;
						$otxtarea->idestado_realizado = 25; // Estado de tarea no realizada
						$otxtarea->save();
					}
				}							
			}else{
				$message = "No se cargaron todas las OTM con éxito.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}
			
			return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
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
			if(($data["user"]->idrol == 1) && $id){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$tabla_estado_activo = Tabla::getTablaByNombre(self::$estado_activo)->get();
				$data["estado_activo"] = Estado::where('idtabla','=',$tabla_estado_activo[0]->idtabla)->lists('nombre','idestado');

				$data["ot_info"] = OrdenesTrabajoPreventivo::searchOtPreventivoById($id)->get();
				if($data["ot_info"]->isEmpty()){
					return Redirect::to('mant_preventivo/list_mant_preventivo');
				}
				$data["ot_info"] = $data["ot_info"][0];		
				$data["tareas"] = OrdenesTrabajoPreventivoxTarea::getTareasXOtXActivo($data["ot_info"]->idot_preventivo)->get();
				$data["repuestos"] = RepuestosOtPreventivos::getRepuestosXOt($data["ot_info"]->idot_preventivo)->get();
				$data["personal_data"] = PersonalOtPreventivo::getPersonalXOt($data["ot_info"]->idot_preventivo)->get();
				
				return View::make('ot/preventivo/createOtMantPre',$data);
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
				$idot_preventivo = Input::get('idot_preventivo');
				// Validate the info, create rules for the inputs
				$rules = array(
							'idestado' => 'required',
							'idestado_inicial' => 'required',
							'sin_interrupcion_servicio' => 'required',
							'idestado_final' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('mant_preventivo/create_ot_preventivo/'.$idot_preventivo)->withErrors($validator)->withInput(Input::all());
				}else{
					$ot = OrdenesTrabajoPreventivo::find($idot_preventivo);
					$ot->idestado_ot = Input::get('idestado');
					$ot->idestado_inicial = Input::get('idestado_inicial');
					$ot->sin_interrupcion_servicio = Input::get('sin_interrupcion_servicio');
					$ot->idestado_final = Input::get('idestado_final');
					if(Input::get('fecha_conformidad') && Input::get('hora_conformidad'))
						$ot->fecha_conformidad = date("Y-m-d H:i:s",strtotime(Input::get('fecha_conformidad')." ".Input::get('hora_conformidad')));
					if(Input::get('fecha_inicio_ejecucion'))
						$ot->fecha_inicio_ejecucion = date("Y-m-d H:i:s",strtotime(Input::get('fecha_inicio_ejecucion')));
					if(Input::get('fecha_termino_ejecucion'))
						$ot->fecha_termino_ejecucion = date("Y-m-d H:i:s",strtotime(Input::get('fecha_termino_ejecucion')));
					$ot->save();
					$activo = Activo::find(Input::get('idactivo'));
					$activo->idestado = Input::get('idestado_final');
					$activo->save();
					Session::flash('message', 'Se guardó correctamente la información.');
					return Redirect::to('mant_preventivo/create_ot_preventivo/'.$idot_preventivo);
				}
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
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

			$repuesto = new RepuestosOtPreventivos;
			$repuesto->nombre = Input::get('nombre_repuesto');
			$repuesto->codigo = Input::get('codigo_repuesto');
			$repuesto->cantidad = Input::get('cantidad_repuesto');
			$repuesto->costo = Input::get('costo_repuesto');
			$repuesto->idot_preventivo = Input::get('idot_preventivo');
			$repuesto->save();
			$ot = OrdenesTrabajoPreventivo::find(Input::get('idot_preventivo'));
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

			$repuesto = RepuestosOtPreventivos::find(Input::get('idrepuestos_ot_preventivo'));
			$ot = OrdenesTrabajoPreventivo::find(Input::get('idot_preventivo'));
			$ot->costo_total_repuestos = $ot->costo_total_repuestos - $repuesto->cantidad*$repuesto->costo;
			$ot->save();
			$repuesto->delete();
			return Response::json(array( 'success' => true,'costo_total_repuestos' => number_format($ot->costo_total_repuestos,2)),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function submit_marcar_tarea_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			$otPreventivoxtarea = Input::get('idtareas_ot_preventivosxot_preventivo');
			$otPreventivoxtarea = OrdenesTrabajosxactivoxtarea::find($idotPreventivoxtarea);
			$otPreventivoxtarea->idestado_realizado = 22;
			$otPreventivoxtarea->save();
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
		if($data["user"]->idrol == 1){

			$personal = new PersonalOtPreventivo;
			$personal->nombre = Input::get('nombre_personal');
			$personal->horas_hombre = Input::get('horas_trabajadas');
			$personal->costo = Input::get('costo_personal');
			$personal->idot_preventivo = Input::get('idot_preventivo');
			$personal->save();
			$ot = OrdenesTrabajoPreventivo::find(Input::get('idot_preventivo'));
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

			$personal = PersonalOtPreventivo::find(Input::get('idpersonal_ot_preventivo'));
			$ot = OrdenesTrabajoPreventivo::find(Input::get('idot_preventivo'));
			$ot->costo_total_personal = $ot->costo_total_personal - $personal->horas_hombre*$personal->costo;
			$ot->save();
			$personal->delete();
			return Response::json(array( 'success' => true,'costo_total_personal' => number_format($ot->costo_total_personal,2)),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

}