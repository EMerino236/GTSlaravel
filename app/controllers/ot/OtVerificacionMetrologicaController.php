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
			if($data["user"]->idrol == 1){
				$mes_ini = date("Y-m-d",strtotime("first day of this month"));;
				$mes_fin = date("Y-m-d",strtotime("last day of this month"));;
				$trimestre_ini = null;
				$trimestre_fin = null;
				$this->calcular_trimestre($trimestre_ini,$trimestre_fin);
				$data['mes'] = OrdenesTrabajosxactivo::getOtXActivoXPeriodo(1,9,$mes_ini,$mes_fin)->get()->count();
				$data['trimestre'] = OrdenesTrabajosxactivo::getOtXActivoXPeriodo(1,9,$trimestre_ini,$trimestre_fin)->get()->count();
				$data['solicitantes'] = User::getJefes()->get();
				
				return View::make('ot/createProgramOtVerificacionMetrologica',$data);
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
			if($data !="vacio"){
				$equipo = Activo::searchActivosByCodigoPatrimonial($data)->get();
				if($equipo->isEmpty()==false){
					$equipo = $equipo[0];
				}else
				 	$equipo = null;
			}else{
				$equipo = null;
			}

			return Response::json(array( 'success' => true, 'equipo' => $equipo ),200);
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
			if($data["user"]->idrol == 1){
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["search_ing"] = null;
				$data["search_cod_pat"] = null;
				$data["search_ubicacion"] = null;
				$data["search_ot"] = null;
				$data["search_equipo"] = null;
				$data["search_proveedor"] = null;
				$data["search_servicio"] = null;
				$data["search_ini"] = null;
				$data["search_fin"] = null;
				$data["verif_metrologicas_data"] = OrdenesTrabajo::getOtsVerifMetrologicaInfo()->paginate(10);
				return View::make('ot/listOtVerificacionMetrologica',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_ot_verif_metrologica()
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
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_ini"] = Input::get('search_ini');
				$data["search_fin"] = Input::get('search_fin');
				$data["verif_metrologicas_data"] = OrdenesTrabajo::searchOtsVerifMetrologica($data["search_ing"],$data["search_cod_pat"],$data["search_ubicacion"],$data["search_ot"],$data["search_equipo"],$data["search_proveedor"],$data["search_servicio"],$data["search_ini"],$data["search_fin"])->paginate(10);
				return View::make('ot/listOtMantPreventivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

public function submit_program_ot_verif_metrologica()
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
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				$sot_id = Input::get('sot_id');
				if($validator->fails()){
					$url = "verif_metrologica/programacion";
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$activo = Activo::searchActivosByCodigoPatrimonial(Input::get('cod_pat'));
					$ot = new OrdenesTrabajo;
					$ot->fecha_programacion = date('Y-m-d H:i:s',strtotime(Input::get('fecha_programacion')));
					$ot->idservicio = $activo->idservicio;
					$ot->idtipo_ordenes_trabajo = 3; // A mejorar este hardcode :/
					$ot->idestado = 9; // A mejorar este hardcode :/
					$ot->id_usuarioelaborado = $data["user"]->id;
					$ot->id_usuariosolicitante = Input::get('solicitante');
					$ot->save();

					$otxa = new OrdenesTrabajosxactivo;
					$otxa->idordenes_trabajo = $ot->idordenes_trabajo;
					$otxa->idactivo = $activo->idactivo;
					$otxa->idestado = 9;
					$otxa->costo_total_personal = 0.0;
					echo "<pre>";
					print_r($otxa);
					exit;
					$otxa->save();
					$url = "verif_metrologica/list_verif_metrologica";

					// Asigno las tareas
					$tareas = Tarea::getTareasByFamiliaActivo($activo->idfamilia_activo)->get();
					foreach($tareas as $tarea){
						$otxacxta = new OrdenesTrabajosxactivoxtarea;
						$otxacxta->idorden_trabajoxactivo = $otxa->idorden_trabajoxactivo;
						$otxacxta->idtarea = $tarea->idtareas;
						$otxacxta->idestado_realizado = 25; // Estado de tarea no realizada
						$otxacxta->save();
					}
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