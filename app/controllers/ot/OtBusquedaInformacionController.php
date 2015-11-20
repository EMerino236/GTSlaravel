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
				$data["areas"] = Area::lists('nombre','idarea');
				$data["tipos"] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');
				$data["busquedas"] = OrdenesTrabajoBusquedaInformacion::getOtsBusquedaInfo()->paginate(10);
				return View::make('ot/busquedaInformacion/listOtBusquedaInformacion',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
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
				$data["areas"] = Area::lists('nombre','idarea');				
				$data["tipos"] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');			
				$data["busquedas"] = OrdenesTrabajoBusquedaInformacion::searchOtsBusquedaInformacion($data["search_tipo"],$data["search_area"],$data["search_encargado"],$data["search_ot"],$data["search_ini"])->paginate(10);
				return View::make('ot/busquedaInformacion/listOtBusquedaInformacion',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}	

	public function render_program_ot_busqueda_informacion($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data['solicitantes'] = User::getJefes()->get();
				$data['tipos'] = TipoOtBusquedaInformacion::lists('nombre','idtipo_busqueda_info');
				$data['areas'] = Area::lists('nombre','idarea');
				
				return View::make('ot/busquedaInformacion/createProgramOtBusquedaInformacion',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_program_ot_busqueda_informacion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'solicitante' => 'Solicitante',
					'area' => 'Área',
					'tipo' => 'Tipo de Solicitud',
					'fecha_programacion' => 'Fecha de Solicitud',
					'motivo' => 'Motivo de Solicitud',
					'detalle' => 'Detalle de Solicitud',
					'descripcion' => 'Descripcion de la Solicitud'
					);

				$messages = array(
					);

				$rules = array(
							'solicitante' => 'required',
							'area' => 'required',
							'tipo' => 'required',
							'fecha_programacion' => 'required',
							'detalle' => 'max:500',
							'motivo' => 'max:500',
							'descripcion' => 'max:500'
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules, $messages, $attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('busqueda_informacion/programacion')->withErrors($validator)->withInput(Input::all());
				}else{
					$ot = new OrdenesTrabajoBusquedaInformacion;
					$fecha = date('Y-m-d H:i:s',strtotime(Input::get('fecha_programacion')));
					$abreviatura = "BI";
					// Algoritmo para añadir numeros correlativos
					$string = $this->getCorrelativeReportNumber();
					$ot->fecha_programacion = $fecha;
					$ot->idarea = Input::get('area');
					$ot->idestado_ot = 9;
					$ot->id_usuarioelaborador = $data["user"]->id;
					$ot->id_usuariosolicitante = Input::get('solicitante');
					$ot->idtipo_busqueda_info = Input::get('tipo');
					$ot->motivo = Input::get('motivo');
					$ot->descripcion = Input::get('descripcion');
					$ot->detalle_ot = Input::get('detalle');
					$ot->ot_tipo_abreviatura = $abreviatura;
					$ot->ot_correlativo = $string;
					$ot->save();			
					
					return Redirect::to('busqueda_informacion/list_busqueda_informacion')->with('message', 'Se registró correctamente la solicitud: '.$ot->ot_tipo_abreviatura.$ot->ot_correlativo);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
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

	
}