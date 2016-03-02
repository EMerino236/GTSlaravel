<?php

class ReportePriorizacionController extends BaseController
{
	public function render_create_reporte_priorizacion($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["responsable"] = null;
				$data["reporte_priorizacion_info"] = null;
				return View::make('reportes_priorizacion/createReportesPriorizacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_reporte_priorizacion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	

				$attributes = array(
					'idarea_rp' => 'Departamento',
					'num_doc_responsable_priorizacion' => 'N° Documento Responsable',
					'archivo' => 'Documento adjunto',
				);

				$messages = array();

				$rules = array(	
							'idarea_rp' => 'required',
							'num_doc_responsable_priorizacion' => 'required',
							'archivo' => 'required|max:15360',	
						);

				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reporte_priorizacion/create_reporte_priorizacion')->withErrors($validator)->withInput(Input::all());					
				}else{
					if(!(Input::get('idreporte_cn1')=='' && Input::get('idreporte_cn2')=='' 
						&& Input::get('idreporte_cn3')=='' && Input::get('idreporte_cn4')==''
						&& Input::get('idreporte_cn5')=='')){
						if(!((Input::get('idreporte_cn1')==Input::get('idreporte_cn2') && Input::get('idreporte_cn1')!='')
						||(Input::get('idreporte_cn1')==Input::get('idreporte_cn3') && Input::get('idreporte_cn1')!='')
						||(Input::get('idreporte_cn1')==Input::get('idreporte_cn4') && Input::get('idreporte_cn1')!='')
						||(Input::get('idreporte_cn1')==Input::get('idreporte_cn5') && Input::get('idreporte_cn1')!='')
						||(Input::get('idreporte_cn2')==Input::get('idreporte_cn3') && Input::get('idreporte_cn2')!='')
						||(Input::get('idreporte_cn2')==Input::get('idreporte_cn4') && Input::get('idreporte_cn2')!='')
						||(Input::get('idreporte_cn2')==Input::get('idreporte_cn5') && Input::get('idreporte_cn2')!='')
						||(Input::get('idreporte_cn3')==Input::get('idreporte_cn4') && Input::get('idreporte_cn3')!='')
						||(Input::get('idreporte_cn3')==Input::get('idreporte_cn5') && Input::get('idreporte_cn3')!='')
						||(Input::get('idreporte_cn4')==Input::get('idreporte_cn5') && Input::get('idreporte_cn4')!='')) 
							){
							$abreviatura = "RP";
						    $rutaDestino ='';
						    $nombreArchivo ='';	
						    if (Input::hasFile('archivo')) {
						        $archivo = Input::file('archivo');
						        $rutaDestino = 'uploads/documentos/planeamiento/ReportePriorizacion/';
						        $nombreArchivo        = $archivo->getClientOriginalName();
						        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
						        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
						    }

							$correlativo = $this->getCorrelativeReportNumber($abreviatura);
							$anho = date('y');
							$reporte_priorizacion = new ReportePriorizacion;
							$reporte_priorizacion->numero_reporte_abreviatura = $abreviatura;
							$reporte_priorizacion->numero_reporte_correlativo = $correlativo;
							$reporte_priorizacion->numero_reporte_anho = $anho;
							$reporte_priorizacion->idservicio = Input::get('idservicio_rp');	
							$reporte_priorizacion->iduser = Input::get('idresponsable_priorizacion');
							$reporte_priorizacion->idarea = Input::get('idarea_rp');
							$reporte_priorizacion->url = $rutaDestino;
							$reporte_priorizacion->nombre_archivo = $nombreArchivo;
							$reporte_priorizacion->nombre_archivo_encriptado = $nombreArchivoEncriptado;
							if(Input::get('idreporte_cn1')!=''){
								$reporte_priorizacion->idreporte_cn1 = Input::get('idreporte_cn1');
							}
							if(Input::get('idreporte_cn2')!=''){
								$reporte_priorizacion->idreporte_cn2 = Input::get('idreporte_cn2');
							}
							if(Input::get('idreporte_cn3')!=''){
								$reporte_priorizacion->idreporte_cn3 = Input::get('idreporte_cn3');
							}
							if(Input::get('idreporte_cn4')!=''){
								$reporte_priorizacion->idreporte_cn4 = Input::get('idreporte_cn4');
							}
							if(Input::get('idreporte_cn5')!=''){
								$reporte_priorizacion->idreporte_cn5 = Input::get('idreporte_cn5');
							}
							$reporte_priorizacion->save();

							Session::flash('message', 'Se registró correctamente el Reporte de Priorización.');
							return Redirect::to('reporte_priorizacion/create_reporte_priorizacion');
						}else{
							Session::flash('error', 'Existen dos o más Reportes de Necesidad repetidos.');
							return Redirect::to('reporte_priorizacion/create_reporte_priorizacion')->withInput(Input::all());
						}
					}else{
							Session::flash('error', 'Debe ingresar al menos un Reporte de Necesidad vinculado.');
							return Redirect::to('reporte_priorizacion/create_reporte_priorizacion')->withInput(Input::all());
					}
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_reporte_priorizacion($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["reporte_priorizacion_info"] = ReportePriorizacion::withTrashed()->find($id);
				$data["responsable_info"] = User::withTrashed()->find($data["reporte_priorizacion_info"]->iduser);
				$data["reporte_cn_info1"] = ReporteCN::withTrashed()->find($data["reporte_priorizacion_info"]->idreporte_cn1);
				$data["reporte_cn_info2"] = ReporteCN::withTrashed()->find($data["reporte_priorizacion_info"]->idreporte_cn2);
				$data["reporte_cn_info3"] = ReporteCN::withTrashed()->find($data["reporte_priorizacion_info"]->idreporte_cn3);
				$data["reporte_cn_info4"] = ReporteCN::withTrashed()->find($data["reporte_priorizacion_info"]->idreporte_cn4);
				$data["reporte_cn_info5"] = ReporteCN::withTrashed()->find($data["reporte_priorizacion_info"]->idreporte_cn5);
				return View::make('reportes_priorizacion/editReportesPriorizacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_reporte_priorizacion(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				if(!((Input::get('idreporte_cn1')==Input::get('idreporte_cn2') && Input::get('idreporte_cn1')!='')
				||(Input::get('idreporte_cn1')==Input::get('idreporte_cn3') && Input::get('idreporte_cn1')!='')
				||(Input::get('idreporte_cn1')==Input::get('idreporte_cn4') && Input::get('idreporte_cn1')!='')
				||(Input::get('idreporte_cn1')==Input::get('idreporte_cn5') && Input::get('idreporte_cn1')!='')
				||(Input::get('idreporte_cn2')==Input::get('idreporte_cn3') && Input::get('idreporte_cn2')!='')
				||(Input::get('idreporte_cn2')==Input::get('idreporte_cn4') && Input::get('idreporte_cn2')!='')
				||(Input::get('idreporte_cn2')==Input::get('idreporte_cn5') && Input::get('idreporte_cn2')!='')
				||(Input::get('idreporte_cn3')==Input::get('idreporte_cn4') && Input::get('idreporte_cn3')!='')
				||(Input::get('idreporte_cn3')==Input::get('idreporte_cn5') && Input::get('idreporte_cn3')!='')
				||(Input::get('idreporte_cn4')==Input::get('idreporte_cn5') && Input::get('idreporte_cn4')!='')) 
					){
					$reporte_priorizacion = ReportePriorizacion::find(Input::get('idreporte_priorizacion'));
					if(Input::get('idreporte_cn1')!=''){
						$reporte_priorizacion->idreporte_cn1 = Input::get('idreporte_cn1');
					}
					if(Input::get('idreporte_cn2')!=''){
						$reporte_priorizacion->idreporte_cn2 = Input::get('idreporte_cn2');
					}
					if(Input::get('idreporte_cn3')!=''){
						$reporte_priorizacion->idreporte_cn3 = Input::get('idreporte_cn3');
					}
					if(Input::get('idreporte_cn4')!=''){
						$reporte_priorizacion->idreporte_cn4 = Input::get('idreporte_cn4');
					}
					if(Input::get('idreporte_cn5')!=''){
						$reporte_priorizacion->idreporte_cn5 = Input::get('idreporte_cn5');
					}
					$reporte_priorizacion->save();

					Session::flash('message', 'Se editó correctamente el Reporte de Priorización.');
					return Redirect::to('reporte_priorizacion/edit_reporte_priorizacion/'.Input::get('idreporte_priorizacion'));
				}else{
					Session::flash('error', 'Existen dos o más Reportes de Necesidad repetidos.');
					return Redirect::to('reporte_priorizacion/edit_reporte_priorizacion/'.Input::get('idreporte_priorizacion'))->withInput(Input::all());
				}
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_reporte_priorizacion($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["reporte_priorizacion_info"] = ReportePriorizacion::withTrashed()->find($id);
				$data["responsable_info"] = User::withTrashed()->find($data["reporte_priorizacion_info"]->iduser);
				return View::make('reportes_priorizacion/viewReportesPriorizacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_reporte_priorizacion()
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
				$data["search_usuario"] = null;
				$data["search_servicio"] = null;
				$data["search_area"] = null;		

				$data["reportes_priorizacion_data"] = ReportePriorizacion::getReportesPriorizacionInfo()->paginate(10);
				return View::make('reportes_priorizacion/listReportesPriorizacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_reporte_priorizacion()
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
				$data["search_usuario"] = Input::get('search_usuario');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_area"] = Input::get('search_area');		

				$data["reportes_priorizacion_data"] = ReportePriorizacion::searchReportesPriorizacion($data["search_numero_reporte"],
														$data["search_fecha_ini"],$data["search_fecha_fin"],$data["search_usuario"],$data["search_servicio"],$data["search_area"])->paginate(10);
				return View::make('reportes_priorizacion/listReportesPriorizacion',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function return_num_ot_retiro(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$ottipo_abreviatura = mb_substr($data,0,2);
				$correlativo = mb_substr($data,2,4);
				$activo_abreviatura = mb_substr($data,6,2);
				$reporte = OtRetiro::searchOtByCodigoReporte($ottipo_abreviatura,$correlativo,$activo_abreviatura)->get();
			}else{
				$reporte = null;
			}
			return Response::json(array( 'success' => true, 'reporte' => $reporte ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_num_doc_responsable_priorizacion(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$responsable = User::searchPersonalByNumeroDoc($data)->get();
			}else{
				$reporte = null;
			}
			return Response::json(array( 'success' => true, 'reporte' => $responsable ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_area(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$servicio = Servicio::where('idservicio','=',$data)->get();;
			}else{
				$servicio = null;
			}
			return Response::json(array( 'success' => true, 'servicio' => $servicio ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function return_reporte_cn(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$abreviatura = mb_substr($data,0,2);
				$correlativo = mb_substr($data,2,4);
				$anho = mb_substr($data,7,2);
				$reporte = ReporteCN::searchReporteCNconETESByCodigoReporte($abreviatura,$correlativo,$anho)->get();
			}else{
				$reporte = null;
			}
			return Response::json(array( 'success' => true, 'reporte' => $reporte ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function getCorrelativeReportNumber($abreviatura){
		$reporte = ReportePriorizacion::getLastReporte($abreviatura)->first();
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
				$reporte_priorizacion = ReportePriorizacion::find($id);
				$file= $reporte_priorizacion->url.$reporte_priorizacion->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($reporte_priorizacion->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_reporte_priorizacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$idreporte_priorizacion = Input::get('idreporte_priorizacion');
				$url = "reporte_priorizacion/edit_reporte_priorizacion/".$idreporte_priorizacion;
				$reporte_priorizacion = ReportePriorizacion::find($idreporte_priorizacion);
				$reporte_priorizacion->delete();

				Session::flash('message', 'Se inhabilitó correctamente el Reporte.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_reporte_priorizacion()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$idreporte_priorizacion = Input::get('idreporte_priorizacion');
				$url = "reporte_priorizacion/edit_reporte_priorizacion/".$idreporte_priorizacion;
				$reporte_priorizacion = ReportePriorizacion::withTrashed()->find($idreporte_priorizacion);
				$reporte_priorizacion->restore();

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