<?php

class OtBusquedaInformacionController extends BaseController {

	private static $nombre_tabla = 'estado_ot';

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
				$data["tipos"] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');
				$data["busquedas"] = OrdenesTrabajoBusquedaInformacion::getOtsBusquedaInfo()->paginate(10);
				return View::make('ot/busquedaInformacion/listOtBusquedaInformacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_ot_busqueda_informacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){

				$data["search_tipo"] = Input::get('search_tipo');
				$data["search_area"] = Input::get('search_area');
				$data["search_encargado"] = Input::get('search_encargado');
				$data["search_ot"] = Input::get('search_ot');
				$data["search_ini"] = Input::get('search_ini');
				$data["search_fin"] = Input::get('search_fin');
				$data["areas"] = Area::lists('nombre','idarea');				
				$data["tipos"] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');			
				$data["busquedas"] = SolicitudBusquedaInformacion::searchOtsBusquedaInformacion($data["search_tipo"],$data["search_area"],$data["search_encargado"],$data["search_ot"],$data["search_ini"],$data["search_fin"])->paginate(10);
				$data['solicitantes'] = User::getJefes()->get();
				return View::make('ot/busquedaInformacion/listOtBusquedaInformacion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	

	

	public function getCorrelativeReportNumber(){
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

	public function render_create_ot($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4) && $id){
				
				$data["ot_info"] = OrdenesTrabajoBusquedaInformacion::searchOtBusquedaInformacionById($id)->get();
				if($data["ot_info"]->isEmpty()){
					return Redirect::to('busqueda_informacion/list_busqueda_informacion');
				}
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["areas"] = Area::lists('nombre','idarea');				
				$data["tipos"] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');			
				$data["ot_info"] = $data["ot_info"][0];		
				$data["tareas"] = TareasOtBusquedaInformacion::getTareasXOt($data["ot_info"]->idot_busqueda_info)->get();
				$data["personal_data"] = PersonalOtBusquedaInformacion::getPersonalXOt($data["ot_info"]->idot_busqueda_info)->get();
				return View::make('ot/busquedaInformacion/createOtBusquedaInformacion',$data);
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
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
				|| $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12) && $id){
				
				$data["ot_info"] = OrdenesTrabajoBusquedaInformacion::searchOtBusquedaInformacionById($id)->get();
				if($data["ot_info"]->isEmpty()){
					return Redirect::to('busqueda_informacion/list_busqueda_informacion');
				}
				$tabla = Tabla::getTablaByNombre(self::$nombre_tabla)->get();
				$data["estados"] = Estado::where('idtabla','=',$tabla[0]->idtabla)->lists('nombre','idestado');
				$data["areas"] = Area::lists('nombre','idarea');				
				$data["tipos"] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');			
				$data["ot_info"] = $data["ot_info"][0];		
				$data["tareas"] = TareasOtBusquedaInformacion::getTareasXOt($data["ot_info"]->idot_busqueda_info)->get();
				$data["personal_data"] = PersonalOtBusquedaInformacion::getPersonalXOt($data["ot_info"]->idot_busqueda_info)->get();
				return View::make('ot/busquedaInformacion/viewOtBusquedaInformacion',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
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
			$tarea = TareasOtBusquedaInformacion::find(Input::get('idtareas_ot_busqueda_info'));
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

			$personal = new PersonalOtBusquedaInformacion;
			$personal->nombre = Input::get('nombre_personal');
			$personal->horas_hombre = Input::get('horas_trabajadas');
			$personal->costo = Input::get('costo_personal');
			$personal->idot_busqueda_info = Input::get('idot_busqueda_info');
			$personal->save();
			$ot = OrdenesTrabajoBusquedaInformacion::find(Input::get('idot_busqueda_info'));
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

			$personal = PersonalOtBusquedaInformacion::find(Input::get('idpersonal_ot_busqueda_info'));
			$ot = OrdenesTrabajoBusquedaInformacion::find(Input::get('idot_busqueda_info'));
			$ot->costo_total_personal = $ot->costo_total_personal - $personal->horas_hombre*$personal->costo;
			$ot->save();
			$personal->delete();
			return Response::json(array( 'success' => true,'costo_total_personal' => number_format($ot->costo_total_personal,2)),200);
		}else{
			return Response::json(array( 'success' => false ),200);
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
			$tarea = new TareasOtBusquedaInformacion;
			$tarea->nombre = Input::get('nombre_tarea');
			$tarea->idestado_realizado = 23;
			$tarea->idot_busqueda_info = Input::get('idot_busqueda_info');
			$tarea->save();
			return Response::json(array( 'success' => true, 'tarea' => $tarea),200);
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
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			$idtarea = Input::get('idtareas_ot_busqueda_info');
			$tarea = TareasOtBusquedaInformacion::find($idtarea);
			$tarea->idestado_realizado = 22;
			$tarea->save();
			return Response::json(array( 'success' => true),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
		
	public function export_pdf(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
				|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10  || $data["user"]->idrol == 11 || $data["user"]->idrol == 12)){
				$idot_busqueda_info = Input::get('idot_busqueda_info');
				$data["ot_info"] = OrdenesTrabajoBusquedaInformacion::searchOtBusquedaInformacionById($idot_busqueda_info)->get();
				if($data["ot_info"]->isEmpty()){
					return Redirect::to('busqueda_informacion/list_busqueda_informacion');
				}
				$data["ot_info"] = $data["ot_info"][0];
				$data["tipo"] = TipoOtBusquedaInformacion::find($data["ot_info"]->idtipo_busqueda_info);		
				$data["tareas"] = TareasOtBusquedaInformacion::getTareasXOt($data["ot_info"]->idot_busqueda_info)->get();
				$data["personal_data"] = PersonalOtBusquedaInformacion::getPersonalXOt($data["ot_info"]->idot_busqueda_info)->get();
				$html = View::make('ot/busquedaInformacion/otBusquedaInformacionExport',$data);
				return PDF::load($html,"A4","portrait")->download('OTM busqueda informacion '.$data["ot_info"]->ot_tipo_abreviatura.$data["ot_info"]->ot_correlativo);

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
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'fecha_conformidad' => 'Fecha de Conformidad',
					'hora_conformidad' => 'Hora de Conformidad',
					);

				$messages = array(
					);

				$rules = array(
							
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$idot = Input::get('idot_busqueda_info');
					$url = "busqueda_informacion/create_ot_busqueda_informacion"."/".$idot;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{	
					$idot = Input::get('idot_busqueda_info');				
					$url = $url =  "busqueda_informacion/create_ot_busqueda_informacion"."/".$idot;				
					$ot = OrdenesTrabajoBusquedaInformacion::find($idot);
					$ot->idestado_ot = Input::get('estado_ot');
					if(Input::get('fecha_conformidad') && Input::get('hora_conformidad'))
						$ot->fecha_conformidad = date("Y-m-d H:i:s",strtotime(Input::get('fecha_conformidad')." ".Input::get('hora_conformidad')));
					$ot->save();
					
					return Redirect::to('solicitud_busqueda_informacion/list_busqueda_informacion')->with('message', 'Se editó correctamente la solicitud de búsqueda de información: '.$ot->ot_tipo_abreviatura.$ot->ot_correlativo);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_ot(){
		// If there was an error, respond with 404 status
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			$data["inside_url"] = Config::get('app.inside_url');
			$ot_busqueda = OrdenesTrabajoBusquedaInformacion::find(Input::get('idot_busqueda_info'));
			$ot_busqueda->idestado_ot= 25;
			$ot_busqueda->save();
			$message = "Se ha cancelado la OTM.";
			$type_message = "bg-success";
			return Response::json(array( 'success' => true, 'url' => $data["inside_url"], 'message' => $message, 'type_message'=>$type_message ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}