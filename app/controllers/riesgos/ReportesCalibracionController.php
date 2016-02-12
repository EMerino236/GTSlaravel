<?php

class ReportesCalibracionController extends BaseController
{
	public function list_reportes_calibracion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				
				$data["search_codigo_reporte"] = null;
				$data["search_codigo_patrimonial"] = null;
				$data["search_nombre_equipo"] = null;
				$data["search_servicio"] = null;
				$data["search_area"] = null;
				$data["search_grupo"] = null;
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				//$data["eventos_adversos_data"] = EventoAdverso::getEventosInfo()->distinct()->paginate(10);
				return View::make('riesgos/reporte_calibracion/listReporteCalibracion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_create_reporte()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["grupos"] = Grupo::lists('nombre','idgrupo');
				return View::make('riesgos/reporte_calibracion/createReporteCalibracion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_reportes_calibracion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs
				 
				
				$attributes = array(
					
				);



				$messages = array(
					);

				$rules = array(
					
				);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);
				

				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('eventos_adversos/create_evento_adverso')->withErrors($validator)->withInput(Input::all());
				}else{	

					$cantidad_activos = Input::get('cantidad_activos');
					echo '<pre>';
					print_r($cantidad_activos);
					exit;
				
					return null;
					//return Redirect::to('eventos_adversos/list_eventos_adversos')->with('message', 'Se registró correctamente el reporte '.$evento->codigo_abreviatura.'-'.$evento->codigo_correlativo);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}
	

	public function search_activos(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4  || $data["user"]->idrol == 5 || $data["user"]->idrol == 6
			|| $data["user"]->idrol == 7 || $data["user"]->idrol == 8  || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
			// Check if the current user is the "System Admin"
			$codigo_patrimonial = Input::get('codigo_patrimonial');
			$nombre_equipo = Input::get('nombre_equipo');
			$area = Input::get('area');
			$servicio = Input::get('servicio');
			$grupo = Input::get('grupo');
		
			$activos = Activo::searchActivosCalibracion($codigo_patrimonial,$nombre_equipo,$area,$servicio,$grupo)->get();
			if($activos->isEmpty())
				$activos = null;
			
				

			return Response::json(array( 'success' => true, 'activos' => $activos),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	

}