<?php

class OtVerificacionMetrologicaController extends BaseController {

	private static $nombre_tabla = 'estado_ot';
	//private static $equipo_noint = 'estado_equipo_noint';
	private static $estado_activo = 'estado_activo';

	public function render_program_ot_verif_metrologica()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["mes_ini"] = date("Y-m-d",strtotime("first day of this month"));;
				$data["mes_fin"] = date("Y-m-d",strtotime("last day of this month"));;
				$data["trimestre_ini"] = null;
				$data["trimestre_fin"] = null;
				$this->calcular_trimestre($data["trimestre_ini"],$data["trimestre_fin"]);
				$data['solicitantes'] = User::getJefes()->get();
				
				return View::make('ot/verifMetrologica/createProgramOtVerificacionMetrologica',$data);
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
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
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
					$mes = OrdenesTrabajoVerifMetrologica::getOtXPeriodoXActivo(9,$mes_ini,$mes_fin,$equipo->idactivo)->get()->count();
					$trimestre = OrdenesTrabajoVerifMetrologica::getOtXPeriodoXActivo(9,$trimestre_ini,$trimestre_fin,$equipo->idactivo)->get()->count();
					
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

			return Response::json(array( 'success' => true, 'equipo' => $equipo,'count_trimestre'=>$trimestre, 'count_mes'=>$mes ),200);
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

	public function list_verif_metrologica()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search_ing"] = null;
				$data["search_cod_pat"] = null;
				$data["search_ubicacion"] = null;
				$data["search_ot"] = null;
				$data["search_equipo"] = null;
				$data["search_proveedor"] = null;
				$data["search_servicio"] = null;
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["search_ini"] = null;
				$data["search_fin"] = null;
				$data["verif_metrologicas_data"] = OrdenesTrabajoVerifMetrologica::getOtsVerifMetrologicaInfo()->paginate(10);
				return View::make('ot/verifMetrologica/listOtVerificacionMetrologica',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_ot_verif_metrologica()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){

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
				if($data["search_ing"]==null && $data["search_cod_pat"] == null && $data["search_ubicacion"]==null && $data["search_ot"]==null &&
					$data["search_equipo"]==null && $data["search_proveedor"]==null && $data["search_ini"] == null && $data["search_fin"]==null &&
					$data["search_servicio"]==0){
					$data["verif_metrologicas_data"] = OrdenesTrabajoVerifMetrologica::getOtsVerifMetrologicaInfo()->paginate(10);
				}else{
					$data["verif_metrologicas_data"] = OrdenesTrabajoVerifMetrologica::searchOtsVerifMetrologica($data["search_ing"],$data["search_cod_pat"],$data["search_ubicacion"],$data["search_ot"],$data["search_equipo"],$data["search_proveedor"],$data["search_servicio"],$data["search_ini"],$data["search_fin"])->paginate(10);								
				}
				
				return View::make('ot/verifMetrologica/listOtVerificacionMetrologica',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_program_ot_verif_metrologica(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			// Check if the current user is the "System Admin"
			$array_detalles = Input::get('matrix_detalle');
			$row_size = count($array_detalles);
			
			if($row_size==0){				
				$message = "No se cargaron todas las OT con éxito.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}	

			
			//Agregar Detalle	
			if($row_size > 0){				
				$message = "Se crearon las OT con éxito";
				$type_message = "bg-success";
				for( $i = 0; $i<$row_size; $i++ ){
					$array_detalle = $array_detalles[$i];					
					$fecha = date('Y-m-d H:i:s',strtotime($array_detalle[4]." ".$array_detalle[5]));
					$cod_pat =$array_detalle[0];
					$activo = Activo::searchActivosByCodigoPatrimonial($cod_pat)->get();					
					$activo = $activo[0];
					$idactivo = $activo->idactivo;
					$ot = new OrdenesTrabajoVerifMetrologica;
					$abreviatura = "VM";
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
				}							
			}else{
				$message = "No se cargaron todas las OT con éxito.";
				$type_message = "bg-danger";
				return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
			}
			
			return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function search_programaciones(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"	
			$fecha_ini=date("Y-m-d",strtotime("first day of january"));
			$fecha_fin=date("Y-m-d",strtotime('last day of december'));
			$array_ot = null;	
			$array_ot =  OrdenesTrabajoVerifMetrologica::getOtXPeriodo(9,$fecha_ini,$fecha_fin)->orderBy('fecha_programacion','desc')->get()->toArray();
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
				$id = $array_ot[$i]['idot_vmetrologica'];
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

	public function getCorrelativeReportNumber(){
		$ot = OrdenesTrabajoVerifMetrologica::getLastOtVerifMetrologica()->first();
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

	public function render_create_ot_verif_metrologica($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $id){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$tabla_estado_activo = Tabla::getTablaByNombre(self::$estado_activo)->get();
				$data["estado_activo"] = Estado::where('idtabla','=',$tabla_estado_activo[0]->idtabla)->lists('nombre','idestado');

				$data["ot_info"] = OrdenesTrabajoVerifMetrologica::searchOtVerifMetrologicaById($id)->get();
				if($data["ot_info"]->isEmpty()){
					return Redirect::to('verif_metrologica/list_verif_metrologica');
				}
				$data["ot_info"] = $data["ot_info"][0];
				$data["documento_info"] = Documento::searchDocumentoByIdOtVerifMetrologica($id)->get();
				if(!$data["documento_info"]->isEmpty()){
					$data["documento_info"] = $data["documento_info"][0];
				}
				else{
					$data["documento_info"] = null;
				}
				$data["personal_data"] = PersonalOtVerifMetrologica::getPersonalXOt($data["ot_info"]->idot_vmetrologica)->get();
				return View::make('ot/verifMetrologica/createOtVerificacionMetrologica',$data);
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
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4)){
				$idot_vmetrologica = Input::get('idot_vmetrologica');
				// Validate the info, create rules for the inputs
				$rules = array(
							'numero_ficha' => 'required',
							'idestado_ot' => 'required',
							'idestado_inicial' => 'required',
							'idestado_final' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('verif_metrologica/create_ot_verif_metrologica/'.$idot_vmetrologica)->withErrors($validator)->withInput(Input::all());
				}else{
					$ot = OrdenesTrabajoVerifMetrologica::find($idot_vmetrologica);
					$ot->numero_ficha = Input::get('numero_ficha');
					$ot->nombre_ejecutor = Input::get('nombre_ejecutor');
					$ot->idestado_ot = Input::get('idestado_ot');
					$ot->idestado_inicial = Input::get('idestado_inicial');
					$ot->idestado_final = Input::get('idestado_final');
					if(Input::get('fecha_conformidad') && Input::get('hora_conformidad'))
						$ot->fecha_conformidad = date("Y-m-d H:i:s",strtotime(Input::get('fecha_conformidad')." ".Input::get('hora_conformidad')));
					$ot->save();
					$activo = Activo::find(Input::get('idactivo'));
					$activo->idestado = Input::get('idestado_final');
					$activo->save();

					$codigo_archivamiento_documento = Input::get('num_doc_relacionado1');
					if($codigo_archivamiento_documento != ''){
						$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo_archivamiento_documento)->get();
						$documento = $documento[0];
						$documento->idot_vmetrologica = $idot_vmetrologica;
						$documento->save();
					}
					Session::flash('message', 'Se guardó correctamente la información.');
					return Redirect::to('verif_metrologica/create_ot_verif_metrologica/'.$idot_vmetrologica);
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_personal_ajax()
	{
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

			$personal = new PersonalOtVerifMetrologica;
			$personal->nombre = Input::get('nombre_personal');
			$personal->horas_hombre = Input::get('horas_trabajadas');
			$personal->costo = Input::get('costo_personal');
			$personal->idot_vmetrologica = Input::get('idot_vmetrologica');
			$personal->save();
			$ot = OrdenesTrabajoVerifMetrologica::find(Input::get('idot_vmetrologica'));
			$ot->costo_total += Input::get('horas_trabajadas')*Input::get('costo_personal');
			$ot->save();
			return Response::json(array( 'success' => true,'personal'=>$personal,'costo_total' => number_format($ot->costo_total,2)),200);
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
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){

			$personal = PersonalOtVerifMetrologica::find(Input::get('idpersonal_ot_vmetrologica'));
			$ot = OrdenesTrabajoVerifMetrologica::find(Input::get('idot_vmetrologica'));
			$ot->costo_total -= $personal->horas_hombre*$personal->costo;
			$ot->save();
			$personal->delete();
			return Response::json(array( 'success' => true,'costo_total' => number_format($ot->costo_total,2)),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_name_doc_relacionado(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
			|| $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$documento = Documento::searchDocumentoByCodigoArchivamiento($data)->get();
			}else{
				$documento = null;
			}

			return Response::json(array( 'success' => true, 'contrato' => $documento ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function download_documento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$iddocumento = $id;		
				$documento = Documento::searchDocumentoById($id)->get();
				$file= $documento[0]->url.$documento[0]->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($documento[0]->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_verif_metrologica(){
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			$data["inside_url"] = Config::get('app.inside_url');
			$ot = OrdenesTrabajoVerifMetrologica::find(Input::get('idot_vmetrologica'));
			$ot->idestado_ot = 25;
			$ot->save();
			$message = "Se ha cancelado la OT.";
			$type_message = "bg-success";
			return Response::json(array( 'success' => true,'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function export_pdf(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$idot_vmetrologica = Input::get('idot_vmetrologica');
				$data["ot_vm"] = OrdenesTrabajoVerifMetrologica::find($idot_vmetrologica);

				if($data["ot_vm"]==null){
					$url = "verif_metrologica/create_ot_verif_metrologica"."/".$idot_vmetrologica;
					return Redirect::to($url);
				}

				$data["usuarioSolicitante"] = User::find($data["ot_vm"]->id_usuariosolicitante);
				$data["usuarioElaborador"] = User::find($data["ot_vm"]->id_usuarioelaborador);
				$data["servicio"] = Servicio::find($data["ot_vm"]->idservicio);
				$data["ejecutor"] = $data["ot_vm"]->nombre_ejecutor;
				$data["ubicacion"] = UbicacionFisica::find($data["ot_vm"]->idubicacion_fisica);
				$data["numero_ficha"] = $data["ot_vm"]->numero_ficha;
				$data["activo"] = Activo::find($data["ot_vm"]->idactivo);
				$data["modelo"] = ModeloActivo::find($data["activo"]->idmodelo_equipo);
				$data["familia"] = FamiliaActivo::find($data["modelo"]->idfamilia_activo);
				$data["marca"] = Marca::find($data["familia"]->idmarca);
				$data["fecha_programacion"] = $data["ot_vm"]->fecha_programacion;
				$data["fecha_conformidad"] = $data["ot_vm"]->fecha_conformidad;
				$data["estado_inicial"] = Estado::find($data["ot_vm"]->idestado_inicial);
				$data["estado_final"] = Estado::find($data["ot_vm"]->idestado_final);
				$data["estado_ot"] = Estado::find($data["ot_vm"]->idestado_ot);
				$data["documento"] = Documento::searchDocumentoByIdOtVerifMetrologica($idot_vmetrologica)->get();
				
				if(count($data["documento"])!=0){
					$data["documento"] = $data["documento"][0];
				}
					
				$data["personal_data"] = PersonalOtVerifMetrologica::getPersonalXOt($idot_vmetrologica)->get();
				$html = View::make('ot/verifMetrologica/otVerifMetrologicaExport',$data);
				
				return PDF::load($html,"A4","portrait")->show();
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_ot_verif_metrologica($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $id){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$tabla_estado_activo = Tabla::getTablaByNombre(self::$estado_activo)->get();
				$data["estado_activo"] = Estado::where('idtabla','=',$tabla_estado_activo[0]->idtabla)->lists('nombre','idestado');

				$data["ot_info"] = OrdenesTrabajoVerifMetrologica::searchOtVerifMetrologicaById($id)->get();
				if($data["ot_info"]->isEmpty()){
					return Redirect::to('verif_metrologica/list_verif_metrologica');
				}
				$data["ot_info"] = $data["ot_info"][0];
				$data["documento_info"] = Documento::searchDocumentoByIdOtVerifMetrologica($id)->get();
				if(!$data["documento_info"]->isEmpty()){
					$data["documento_info"] = $data["documento_info"][0];
				}
				else{
					$data["documento_info"] = null;
				}
				$data["personal_data"] = PersonalOtVerifMetrologica::getPersonalXOt($data["ot_info"]->idot_vmetrologica)->get();
				return View::make('ot/verifMetrologica/viewOtVerificacionMetrologica',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

}