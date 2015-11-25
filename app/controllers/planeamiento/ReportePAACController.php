<?php

class ReportePAACController extends BaseController
{
	public function render_create_reporte_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_paac"] = TipoReportePAAC::lists('nombre','idtipo_reporte_PAAC');
				$data["reporte_paac_info"] = null;
				return View::make('reportes_PAAC/createReportePAAC',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_create_reporte_paac(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs	
				$rules = array(
							'idtipo_reporte' => 'required',
							'idarea' => 'required',
							'archivo' => 'max:15360|mimes:png,jpe,jpeg,jpg,gif,bmp,zip,rar,pdf,doc,docx,xls,xlsx,ppt,pptx',											
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
				        $rutaDestino = 'documentos/ReportePAAC/';
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
					$reporte_paac->idtipo_reporte_PAAC = Input::get('idtipo_reporte');
					$reporte_paac->idservicio = Input::get('idservicio');					
					$reporte_paac->iduser = $data["user"]->id;
					$reporte_paac->idarea = Input::get('idarea');
					$reporte_paac->save();
					
					Session::flash('message', 'Se registró correctamente el Reporte de Instalación.');
					return Redirect::to('reporte_paac/create_reporte_paac');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_reporte_paac($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_paac"] = TipoReportePAAC::lists('nombre','idtipo_reporte_PAAC');
				$data["reporte_paac_info"] = ReportePAAC::withTrashed()->find($id);return View::make('reportes_PAAC/editReportePAAC',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function list_reporte_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
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
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function search_reporte_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
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
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
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
			if($data["user"]->idrol == 1){
				$reporte_paac = ReportePAAC::find($id);
				$file= $reporte_paac->url.$reporte_paac->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($reporte_paac->nombre_archivo),$headers);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_disable_reporte_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$idreporte_PAAC = Input::get('idreporte_PAAC');
				$url = "reporte_paac/edit_reporte_paac/".$idreporte_PAAC;
				$reporte_paac = ReportePAAC::find($idreporte_PAAC);
				$reporte_paac->delete();

				Session::flash('message', 'Se inhabilitó correctamente el Reporte.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_enable_reporte_paac()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$idreporte_PAAC = Input::get('idreporte_PAAC');
				$url = "reporte_paac/edit_reporte_paac/".$idreporte_PAAC;
				$reporte_paac = ReportePAAC::withTrashed()->find($idreporte_PAAC);
				$reporte_paac->restore();

				Session::flash('message', 'Se habilitó correctamente el Reporte.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}