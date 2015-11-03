<?php

class RetiroServicioController extends BaseController {

	private static $nombre_tabla = 'estado_ot';
	//private static $equipo_noint = 'estado_equipo_noint';
	private static $estado_activo = 'estado_activo';

	public function list_retiro_servicio()
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
				$data["retiro_servicios_data"] = OrdenesTrabajo::getOtsRetiroServicioInfo()->paginate(10);
				return View::make('retiro_servicio/listOtRetiroServicio',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_ot_retiro_servicio()
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
				$data["mant_correctivos_data"] = OrdenesTrabajo::searchOtsMantCorrectivo($data["search_ing"],$data["search_cod_pat"],$data["search_ubicacion"],$data["search_ot"],$data["search_equipo"],$data["search_proveedor"],$data["search_ini"],$data["search_fin"])->paginate(10);
				return View::make('ot/listOtMantCorrectivo',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_reporte_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["activos"] = Activo::lists('codigo_patrimonial','idactivo');
				$data["motivos"] = MotivoRetiro::lists('nombre','idmotivo_retiro');
				return View::make('retiro_servicio/createReporteRetiroServicio',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_reporte_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'idactivo' => 'required',
							'idmotivo_retiro' => 'required',
							'descripcion' => 'required|max:200',
							'costo' => array('required','regex:/^\d*(\.\d{2})?$/'),
							'fecha_baja' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('retiro_servicio/create_reporte_retiro_servicio')->withErrors($validator)->withInput(Input::all());
				}else{
					$reporte_retiro = new ReporteRetiro;
					$reporte_retiro->idactivo = Input::get('idactivo');
					$reporte_retiro->descripcion = Input::get('descripcion');
					$reporte_retiro->idmotivo_retiro = Input::get('idmotivo_retiro');
					$reporte_retiro->fecha_baja = date('Y-m-d H:i:s',strtotime(Input::get('fecha_baja')));
					$reporte_retiro->costo = Input::get('costo');
					$reporte_retiro->save();
					Session::flash('message', 'Se creó correctamente el informe.');
					return Redirect::to('retiro_servicio/create_reporte_retiro_servicio');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_reporte_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["motivos"] = MotivoRetiro::lists('nombre','idmotivo_retiro');
				$data["marcas"] = Marca::lists('nombre','idmarca');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');
				$data["search_motivo"] = null;
				$data["search_equipo"] = null;
				$data["search_cod_pat"] = null;
				$data["search_marca"] = null;
				$data["search_servicio"] = null;
				$data["search_proveedor"] = null;
				$data["reporte_retiros_data"] = ReporteRetiro::getReportesRetiroInfo()->paginate(10);
				return View::make('retiro_servicio/listReporteRetiroServicio',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_reporte_retiro_servicio()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["motivos"] = MotivoRetiro::lists('nombre','idmotivo_retiro');
				$data["marcas"] = Marca::lists('nombre','idmarca');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');

				$data["search_motivo"] = Input::get('search_motivo');
				$data["search_equipo"] = Input::get('search_equipo');
				$data["search_cod_pat"] = Input::get('search_cod_pat');
				$data["search_marca"] = Input::get('search_marca');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["reporte_retiros_data"] = ReporteRetiro::searchReportesRetiroInfo($data["search_motivo"],$data["search_equipo"],$data["search_cod_pat"],$data["search_marca"],$data["search_servicio"],$data["search_proveedor"])->paginate(10);
				return View::make('retiro_servicio/listReporteRetiroServicio',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}