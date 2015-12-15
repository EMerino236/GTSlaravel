<?php

class RegistroHistoricoOTController extends BaseController {
	private static $nombre_tabla = 'estado_ot';
	private static $estado_activo = 'estado_activo';

	public function list_ot()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7  || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_nombre_equipo"] = null;
				$data["search_marca"] = null;
				$data["search_modelo"] = null;
				$data["search_grupo"] = null;
				$data["search_serie"] = null;
				$data["search_proveedor"] = null;
				$data["search_codigo_patrimonial"] = null;
				$data["search_ini"] = null;
				$data["search_fin"] = null;
				$data["search_tipo"] = 0;
				$data["search_codigo_ot"] = null;
				$data["tipos"] = array(0 => 'Seleccione',
					1=> 'OTM Correctivo',
					2=> 'OTM Preventivo',
					3=> 'OTM Verificación Metrológica',
					4=> 'OTM Inspección de Equipos',
					5=> 'OTM Retiro de Servicio'
					);
				$data["marcas"] = Marca::lists('nombre','idmarca');
				$data["preventivos"] = OrdenesTrabajoPreventivo::getOtsMantPreventivoAllHistorico()->paginate(10);
				$data["correctivos"] = OtCorrectivo::getOtsMantCorrectivoAllHistorico()->paginate(10);				
				$data["verificaciones"] = OrdenesTrabajoVerifMetrologica::getOtsMantVerificacionMetrologicaAllHistorico()->paginate(10);
				$data["inspecciones"] = OrdenesTrabajoInspeccionEquipo::getOtsMantInspeccionAllHistorico()->paginate(10);
				$data["retiros"] = OtRetiro::getOtsMantRetiroAllHistorico()->paginate(10);
				return View::make('ot/registroHistorico/listRegistroHistoricoOt',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_ot(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){

				$data["search_nombre_equipo"] = Input::get('search_nombre_equipo');
				$data["search_marca"] = Input::get('search_marca');
				$data["search_modelo"] =  Input::get('search_modelo');
				$data["search_grupo"] =  Input::get('search_grupo');
				$data["search_serie"] =  Input::get('search_serie');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["search_codigo_patrimonial"] =  Input::get('search_codigo_patrimonial');
				$data["search_ini"] =  Input::get('search_ini');
				$data["search_fin"] =  Input::get('search_fin');
				$data["search_tipo"] =  Input::get('search_tipo');				
				$data["search_codigo_ot"] = Input::get('search_codigo_ot');
				$data["tipos"] = array(0 => 'Seleccione',
					1=> 'OTM Correctivo',
					2=> 'OTM Preventivo',
					3=> 'OTM Verificación Metrológica',
					4=> 'OTM Inspección de Equipos',
					5=> 'OTM Retiro de Servicio'
					);
				$data["marcas"] = Marca::lists('nombre','idmarca');
				if($data["search_tipo"] == 0){
					$data["correctivos"] = OtCorrectivo::searchOTHistorico($data["search_nombre_equipo"],$data["search_marca"],$data["search_modelo"],$data["search_grupo"],$data["search_serie"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["search_ini"],$data["search_fin"],$data["search_codigo_ot"])->paginate(10);
					$data["preventivos"] = OrdenesTrabajoPreventivo::searchOTHistorico($data["search_nombre_equipo"],$data["search_marca"],$data["search_modelo"],$data["search_grupo"],$data["search_serie"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["search_ini"],$data["search_fin"],$data["search_codigo_ot"])->paginate(10);
					$data["verificaciones"] = OrdenesTrabajoVerifMetrologica::searchOTHistorico($data["search_nombre_equipo"],$data["search_marca"],$data["search_modelo"],$data["search_grupo"],$data["search_serie"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["search_ini"],$data["search_fin"],$data["search_codigo_ot"])->paginate(10);
					$data["inspecciones"] = OrdenesTrabajoInspeccionEquipo::searchOTHistorico($data["search_nombre_equipo"],$data["search_marca"],$data["search_modelo"],$data["search_grupo"],$data["search_serie"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["search_ini"],$data["search_fin"],$data["search_codigo_ot"])->paginate(10);
					$data["retiros"] = OtRetiro::searchOTHistorico($data["search_nombre_equipo"],$data["search_marca"],$data["search_modelo"],$data["search_grupo"],$data["search_serie"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["search_ini"],$data["search_fin"],$data["search_codigo_ot"])->paginate(10);
				}else if($data["search_tipo"]==1){ //correctivo
					$data["correctivos"] = OtCorrectivo::searchOTHistorico($data["search_nombre_equipo"],$data["search_marca"],$data["search_modelo"],$data["search_grupo"],$data["search_serie"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["search_ini"],$data["search_fin"],$data["search_codigo_ot"])->paginate(10);
					$data["preventivos"] = [];
					$data["verificaciones"] = [];
					$data["inspecciones"] = [];
					$data["retiros"] = [];
				}else if($data["search_tipo"]==2){ //preventivo
					$data["correctivos"] = [];
					$data["preventivos"] = OrdenesTrabajoPreventivo::searchOTHistorico($data["search_nombre_equipo"],$data["search_marca"],$data["search_modelo"],$data["search_grupo"],$data["search_serie"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["search_ini"],$data["search_fin"],$data["search_codigo_ot"])->paginate(10);
					$data["verificaciones"] = [];
					$data["inspecciones"] = [];	
					$data["retiros"] = [];				
				}else if($data["search_tipo"]==3){
					$data["correctivos"] = [];
					$data["preventivos"] = [];
					$data["verificaciones"] = OrdenesTrabajoVerifMetrologica::searchOTHistorico($data["search_nombre_equipo"],$data["search_marca"],$data["search_modelo"],$data["search_grupo"],$data["search_serie"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["search_ini"],$data["search_fin"],$data["search_codigo_ot"])->paginate(10);
					$data["inspecciones"] = [];	
					$data["retiros"] = [];
				}else if($data["search_tipo"]==4){
					$data["correctivos"] = [];
					$data["preventivos"] = [];
					$data["verificaciones"] = [];
					$data["inspecciones"] = OrdenesTrabajoInspeccionEquipo::searchOTHistorico($data["search_nombre_equipo"],$data["search_marca"],$data["search_modelo"],$data["search_grupo"],$data["search_serie"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["search_ini"],$data["search_fin"],$data["search_codigo_ot"])->paginate(10);	
				}else if($data["search_tipo"]==5){
					$data["correctivos"] = [];
					$data["preventivos"] = [];
					$data["verificaciones"] = [];
					$data["inspecciones"] = [];
					$data["retiros"] = OtRetiro::searchOTHistorico($data["search_nombre_equipo"],$data["search_marca"],$data["search_modelo"],$data["search_grupo"],$data["search_serie"],$data["search_proveedor"],$data["search_codigo_patrimonial"],$data["search_ini"],$data["search_fin"],$data["search_codigo_ot"])->paginate(10);
				}
				return View::make('ot/registroHistorico/listRegistroHistoricoOt',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

}