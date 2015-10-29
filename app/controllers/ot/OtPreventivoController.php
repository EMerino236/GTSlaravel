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
				
				return View::make('ot/createProgramOtMantPre',$data);
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
					$mes = OrdenesTrabajosxactivo::getOtXActivoXPeriodo(2,9,$mes_ini,$mes_fin)->get()->count();
					$trimestre = OrdenesTrabajosxactivo::getOtXActivoXPeriodo(2,9,$trimestre_ini,$trimestre_fin)->get()->count();
					
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
				$data["mant_preventivos_data"] = OrdenesTrabajo::getOtsMantPreventivoInfo()->get();
				return View::make('ot/listOtMantPreventivo',$data);
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
			$trimestre_ini=date("Y-m-d",strtotime(Input::get('trimestre_ini')));
			$trimestre_fin=date("Y-m-d",strtotime(Input::get('trimestre_fin')));
			$array_programaciones = null;	
			$array_programaciones = OrdenesTrabajosxactivo::getOtXActivoXPeriodo(2,9,$trimestre_ini,$trimestre_fin)->get()->toArray();
			$programaciones = [];
			$length = sizeof($array_programaciones);					
			for($i=0;$i<$length;$i++){
				$programaciones[] = date("Y-m-d",strtotime($array_programaciones[$i]['fecha_programacion']));
			}
			$array_programaciones = $programaciones;			
			return Response::json(array( 'success' => true, 'programaciones'=> $array_programaciones),200);
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
				$data["mant_preventivos_data"] = OrdenesTrabajo::searchOtsMantPreventivo($data["search_ing"],$data["search_cod_pat"],$data["search_ubicacion"],$data["search_ot"],$data["search_equipo"],$data["search_proveedor"],$data["search_ini"],$data["search_fin"])->paginate(10);
				return View::make('ot/listOtMantPreventivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	

	public function getCorrelativeReportNumber(){
		$ot = OrdenesTrabajo::getLastOtPreventivo()->first();
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
					$array_detalle = $array_detalle[0];
					$cod_pat =$array_detalle[0];
					$activo = Activo::searchActivosByCodigoPatrimonial($cod_pat)->get();					
					$activo = $activo[0];
					$idactivo = $activo->idactivo;
					$ot = new OrdenesTrabajo;
					$abreviatura = "MP";
					// Algoritmo para añadir numeros correlativos
					$string = $this->getCorrelativeReportNumber();
					//Get Año Actual
					$ts_abreviatura = "TS";

					$ot->fecha_programacion = date('Y-m-d H:i:s',strtotime($array_detalle[4]." ".$array_detalle[5]));
					$ot->idservicio = $activo->idservicio;
					$ot->idtipo_ordenes_trabajo = 2; // A mejorar este hardcode :/
					$ot->idestado = 9; // A mejorar este hardcode :/
					$ot->id_usuarioelaborado = $data["user"]->id;
					$ot->id_usuariosolicitante = $array_detalle[6];
					$ot->ot_tipo_abreviatura = $abreviatura = "MP";
					$ot->ot_correlativo = $string;
					$ot->ot_activo_abreviatura = $ts_abreviatura;
					$ot->save();

					$otxa = new OrdenesTrabajosxactivo;
					$otxa->idordenes_trabajo = $ot->idordenes_trabajo;
					$otxa->idactivo = $idactivo;
					$otxa->idestado = 9;
					$otxa->costo_total_repuestos = 0.0;
					$otxa->costo_total_personal = 0.0;
					$otxa->save();
					

					// Asigno las tareas
					$tareas = Tarea::getTareasByFamiliaActivo($activo->idfamilia_activo)->get();
					foreach($tareas as $tarea){
						$otxacxta = new OrdenesTrabajosxactivoxtarea;
						$otxacxta->idorden_trabajoxactivo = $otxa->idorden_trabajoxactivo;
						$otxacxta->idtarea = $tarea->idtareas;
						$otxacxta->idestado_realizado = 25; // Estado de tarea no realizada
						$otxacxta->save();
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

	
/*
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
				
				$data["ot_info"] = OrdenesTrabajo::searchOtById($id)->get();
				if($data["ot_info"]->isEmpty()){
					return Redirect::to('ot/createOtMantPre');
				}
				$data["ot_info"] = $data["ot_info"][0];
				$data["otxact"] = OrdenesTrabajosxactivo::getOtXActivo($id,$data["ot_info"]->idactivo)->get();
				if($data["otxact"]->isEmpty()){
					$data["tareas"] = array();
					$data["repuestos"] = array();
					$data["personal_data"] = array();
				}else{
					$data["otxact"] = $data["otxact"][0];
					$data["tareas"] = OrdenesTrabajosxactivoxtarea::getTareasXOtXActi($data["otxact"]->idorden_trabajoxactivo)->get();
					$data["repuestos"] = RepuestosOt::getRepuestosXOtXActi($data["otxact"]->idorden_trabajoxactivo)->get();
					$data["personal_data"] = DetallePersonalxot::getPersonalXOtXActi($data["otxact"]->idorden_trabajoxactivo)->get();
				}
				return View::make('ot/createOtMantPre',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}*/

}