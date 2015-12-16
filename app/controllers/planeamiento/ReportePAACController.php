<?php

class ReportePAACController extends BaseController
{
	public function render_create_reporte_paac($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_paac"] = TipoReportePAAC::lists('nombre','idtipo_reporte_PAAC');
				$data["programaciones_reporte_paac"] = ProgramacionReportePAAC::where('idestado_programacion_reportes',1)
																			->where('iduser',$data["user"]->id)
																			->orwhere('idestado_programacion_reportes',3)
																			->lists('nombre_reporte','idprogramacion_reporte_paac');
				$data["programacion_reporte_paac_id"] = $id;
				$data["programacion_reporte_paac"] = null;
				if($id){
					$data["programacion_reporte_paac"] = ProgramacionReportePAAC::where('idprogramacion_reporte_paac','=',$id)->get()[0];
				}
				$data["reporte_paac_info"] = null;
				return View::make('reportes_PAAC/createReportePAAC',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_reporte_paac(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'idprogramacion_reporte_paac' => 'required',
							'archivo' => 'max:15360',											
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reporte_paac/create_reporte_paac')->withErrors($validator)->withInput(Input::all());					
				}else{
					switch (Input::get('idtipo_reporte')) {
					    case 1:
					        $abreviatura = "PP";
					        break;
					    case 2:
					        $abreviatura = "PC";
					        break;
					}

				    $rutaDestino ='';
				    $nombreArchivo ='';	
				    if (Input::hasFile('archivo')) {
				        $archivo = Input::file('archivo');
				        $rutaDestino = 'documentos/planeamiento/ReportePAAC/';
				        $nombreArchivo        = $archivo->getClientOriginalName();
				        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
				        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
				    }

					$correlativo = $this->getCorrelativeReportNumber($abreviatura);
					$anho = date('y');
					$reporte_paac = new ReportePAAC;
					$reporte_paac->numero_reporte_abreviatura = $abreviatura;
					$reporte_paac->numero_reporte_correlativo = $correlativo;
					$reporte_paac->numero_reporte_anho = $anho;
					$reporte_paac->url = $rutaDestino;
					$reporte_paac->nombre_archivo = $nombreArchivo;
					$reporte_paac->nombre_archivo_encriptado = $nombreArchivoEncriptado;
					$reporte_paac->idprogramacion_reporte_paac = Input::get('idprogramacion_reporte_paac');
					$reporte_paac->save();

					$programacion_reporte_paac = ProgramacionReportePAAC::find(Input::get('idprogramacion_reporte_paac'));
					$programacion_reporte_paac->idestado_programacion_reportes = 2;
					$programacion_reporte_paac->save();
					
					Session::flash('message', 'Se registró correctamente el Reporte de Instalación.');
					return Redirect::to('reporte_paac/create_reporte_paac');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_reporte_paac($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_paac"] = TipoReportePAAC::lists('nombre','idtipo_reporte_PAAC');
				$data["reporte_paac_info"] = ReportePAAC::withTrashed()->find($id);
				$data["programacion_reporte_paac_info"] = ProgramacionReportePAAC::withTrashed()->find($data["reporte_paac_info"]->idprogramacion_reporte_paac);
				return View::make('reportes_PAAC/editReportePAAC',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_reporte_paac($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_paac"] = TipoReportePAAC::lists('nombre','idtipo_reporte_PAAC');
				$data["reporte_paac_info"] = ReportePAAC::withTrashed()->find($id);
				$data["programacion_reporte_paac_info"] = ProgramacionReportePAAC::withTrashed()->find($data["reporte_paac_info"]->idprogramacion_reporte_paac);
				return View::make('reportes_PAAC/viewReportePAAC',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_reporte_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_numero_reporte"] = null;	
				$data["search_fecha_ini"] = null;			
				$data["search_fecha_fin"] = null;			
				$data["servicio"] = Servicio::lists('nombre','idservicio');
				$data["area"] = Area::lists('nombre','idarea');
				$data["tipo_reporte_paac"] = TipoReportePAAC::lists('nombre','idtipo_reporte_PAAC');
				$data["search_tipo_reporte_paac"] = null;
				$data["search_usuario"] = null;
				$data["search_servicio"] = null;
				$data["search_area"] = null;			

				$data["reportes_paac_data"] = ReportePAAC::getReportesPAACInfo()->paginate(10);
				return View::make('reportes_PAAC/listReportePAAC',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_reporte_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_numero_reporte"] = Input::get('search_numero_reporte');
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');			
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');			
				$data["servicio"] = Servicio::lists('nombre','idservicio');
				$data["area"] = Area::lists('nombre','idarea');
				$data["tipo_reporte_paac"] = TipoReportePAAC::lists('nombre','idtipo_reporte_PAAC');
				$data["search_tipo_reporte_paac"] = Input::get('search_tipo_reporte_paac');
				$data["search_usuario"] = Input::get('search_usuario');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_area"] = Input::get('search_area');		

				$data["reportes_paac_data"] = ReportePAAC::searchReportesPAAC($data["search_numero_reporte"],
														$data["search_fecha_ini"],$data["search_fecha_fin"],
														$data["search_tipo_reporte_paac"],$data["search_usuario"],
														$data["search_servicio"],$data["search_area"])->paginate(10);
				return View::make('reportes_PAAC/listReportePAAC',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}


	public function getCorrelativeReportNumber($abreviatura){
		$reporte = ReportePAAC::getLastReporte($abreviatura)->first();
		$string = "";
		if($reporte!=null){	
			$numero = $reporte->numero_reporte_correlativo;
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

	public function download_documento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$reporte_paac = ReportePAAC::find($id);
				$file= $reporte_paac->url.$reporte_paac->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($reporte_paac->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_reporte_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$idreporte_PAAC = Input::get('idreporte_PAAC');
				$url = "reporte_paac/edit_reporte_paac/".$idreporte_PAAC;
				$reporte_paac = ReportePAAC::find($idreporte_PAAC);
				$reporte_paac->delete();

				Session::flash('message', 'Se inhabilitó correctamente el Reporte.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_reporte_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$idreporte_PAAC = Input::get('idreporte_PAAC');
				$url = "reporte_paac/edit_reporte_paac/".$idreporte_PAAC;
				$reporte_paac = ReportePAAC::withTrashed()->find($idreporte_PAAC);
				$reporte_paac->restore();

				Session::flash('message', 'Se habilitó correctamente el Reporte.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}
}