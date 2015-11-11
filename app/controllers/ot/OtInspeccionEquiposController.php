<?php

class OtInspeccionEquiposController extends BaseController {
	private static $nombre_tabla = 'estado_ot';
	private static $estado_activo = 'estado_activo';

	public function list_inspec_equipos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search_ing"] = null;
				$data["search_ot"] = null;
				$data["search_ini"] = null;
				$data["search_fin"] = null;
				$data["search_servicio"] = null;
				$data["search_equipo"] = null;
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["inspecciones_equipos_data"] = OrdenesTrabajoInspeccionEquipo::getOtsInspecEquipoInfo()->get();
				return View::make('ot/inspeccionEquipo/listOtInspecEquipos',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_program_ot_inspeccion_equipo($id=null)
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
				$data['servicios'] = Servicio::lists('nombre','idservicio');
				$data['ingenieros'] = User::getJefes()->get();
				
				return View::make('ot/inspeccionEquipo/createProgramOtInspecEquipos',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
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
			$array_ot = null;	
			$array_ot =  OrdenesTrabajoInspeccionEquipo::getOtXPeriodo(9,$fecha_ini,$fecha_fin)->orderBy('fecha_inicio','desc')->get()->toArray();
			$programaciones = [];
			$horas = [];
			$estados = [];

			$length = sizeof($array_ot);

			for($i=0;$i<$length;$i++){
				$programaciones[] = date("Y-m-d",strtotime($array_ot[$i]['fecha_inicio']));
				$hora = date("H:i",strtotime($array_ot[$i]['fecha_inicio']));
				$idestado = $array_ot[$i]['idestado'];
				$estado = Estado::getEstadoById($idestado)->get();
				$estado = $estado[0];
				array_push($horas,$hora);
				array_push($estados, $estado);				
			}
			return Response::json(array( 'success' => true, 'programaciones'=> $programaciones,'horas'=>$horas,'estados'=>$estados,'ots'=>$array_ot),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_servicio_ajax(){
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
				$servicio = Servicio::find($data);
				if($servicio != null){
					$mes = OrdenesTrabajoInspeccionEquipo::getOtXPeriodoXServicio(9,$mes_ini,$mes_fin,$servicio->idservicio)->get()->count();
					$trimestre = OrdenesTrabajoInspeccionEquipo::getOtXPeriodoXServicio(9,$trimestre_ini,$trimestre_fin,$servicio->idservicio)->get()->count();					
				}else{
				 	$servicio = null;
				 	$mes = 0;
				 	$trimestre = 0;				 	
				}
			}else{
				$servicio = null;
				$mes = 0;
			 	$trimestre = 0;
			}

			return Response::json(array( 'success' => true,'count_trimestre'=>$trimestre, 'count_mes'=>$mes ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function getCorrelativeReportNumber(){
		$ot = OrdenesTrabajoInspeccionEquipo::getLastOtInspeccionEquipo()->first();
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


	public function submit_program_ot_inspec_equipos(){
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
			$list_activos = [];					
			//Agregar Detalle			
			if($row_size > 0){				
				$message = "Se crearon las OTM con éxito";
				$type_message = "bg-success";
				
				for( $i = 0; $i<$row_size; $i++ ){
					$array_detalle = $array_detalles[$i];					
					$fecha_inicio = date('Y-m-d H:i:s',strtotime($array_detalle[3]." ".$array_detalle[4]));
					$fecha_fin = date('Y-m-d H:i:s',strtotime($array_detalle[3]." ".$array_detalle[5]));
					$idservicio =$array_detalle[0];
					$servicio = Servicio::find($idservicio);
					$ot = new OrdenesTrabajoInspeccionEquipo;
					$abreviatura = "PIE";
					// Algoritmo para añadir numeros correlativos
					$string = $this->getCorrelativeReportNumber();
					$ot->fecha_inicio = $fecha_inicio;
					$ot->fecha_fin = $fecha_fin;
					$ot->idservicio = $idservicio;
					$ot->idestado = 9;
					$ot->id_ingeniero = $array_detalle[6];
					$ot->ot_tipo_abreviatura = $abreviatura;
					$ot->ot_correlativo = $string;
					$ot->save();

					$list_activos = Activo::getActivosByServicioId($idservicio)->get();
					if($list_activos->isEmpty()==false){
						foreach($list_activos as $activo){
							$modelo = ModeloActivo::find($activo->idmodelo_equipo);
							$idfamilia_activo = $modelo->idfamilia_activo;
							$otInspeccionxActivo = new OrdenesTrabajoInspeccionEquipoxActivo;
							$otInspeccionxActivo->idot_inspec_equipo = $ot->idot_inspec_equipo;
							$otInspeccionxActivo->idactivo = $activo->idactivo;
							$otInspeccionxActivo->save();
							//asignamos las tareas de ese activo de esa inspeccion
							$tareas = TareasOtInspeccionEquipo::getTareasByFamiliaActivo($idfamilia_activo)->get();
							foreach ($tareas as $tarea) {
								$otInspeccionxActivoxTarea = new TareasOtInspeccionEquipoxActivo;
								$otInspeccionxActivoxTarea->idot_inspec_equiposxactivo = $otInspeccionxActivo->idot_inspec_equiposxactivo;
								$otInspeccionxActivoxTarea->idtareas_inspec_equipo = $tarea->idtareas_inspec_equipo;
								$otInspeccionxActivoxTarea->idestado_realizado = 23; // Estado de tarea no realizada
								$otInspeccionxActivoxTarea->save();
							}
						}
					}
				}							
			}else{
				$message = "No se cargaron todas las OTM con éxito.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' =>$message, 'type_message'=>$type_message,'list'=>$list_activos ),200);
			}
			
			return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function validate_servicio(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$x = Input::get('selected_id');
			//$list_activos = Activo::getEquiposActivosByServicioId($data)->get();
			

			return Response::json(array( 'success' => true,'data'=>$x),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_ot_inspeccion_equipos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){

				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search_ing"] = Input::get('search_ing');
				$data["search_ot"] = Input::get('search_ot');
				$data["search_ini"] = Input::get('search_ini');
				$data["search_fin"] = Input::get('search_fin');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_equipo"] = Input::get('search_equipo');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["inspecciones_equipos_data"] = OrdenesTrabajoInspeccionEquipo::searchOtsInspecEquipo($data["search_ing"],$data["search_ot"],$data["search_ini"],$data["search_fin"],$data["search_servicio"],$data["search_equipo"])->paginate(10);
				return View::make('ot/inspeccionEquipo/listOtInspecEquipos',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}	

	public function submit_disable_inspeccion(){
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			$data["inside_url"] = Config::get('app.inside_url');
			$ot_inspeccion = OrdenesTrabajoInspeccionEquipo::find(Input::get('idot_inspec_equipo'));
			$ot_inspeccion->idestado= 26;
			$ot_inspeccion->save();
			$message = "Se ha cancelado la OTM.";
			$type_message = "bg-success";
			return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}