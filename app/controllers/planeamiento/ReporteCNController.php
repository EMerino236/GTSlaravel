<?php

class ReporteCNController extends BaseController
{
	public function render_create_reporte_cn($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_cn"] = TipoReporteCN::lists('nombre','idtipo_reporte_CN');
				$data["programaciones_reporte_cn"] = ProgramacionReporteCN::where('idestado_programacion_reportes',1)
																			->where('iduser',$data["user"]->id)
																			->orwhere('idestado_programacion_reportes',3)
																			->lists('nombre_reporte','idprogramacion_reporte_cn');
				$data["programacion_reporte_cn_id"] = $id;
				$data["programacion_reporte_cn"] = null;
				$data["responsable"] = null;
				if($id){
					$data["programacion_reporte_cn"] = ProgramacionReporteCN::where('idprogramacion_reporte_cn','=',$id)->get()[0];
					$data["responsable"] = User::find($data["programacion_reporte_cn"]->iduser);
				}
				$data["reporte_cn_info"] = null;
				return View::make('reportes_CN/createReportesCN',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_reporte_cn(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				// Validate the info, create rules for the inputs	
				$attributes = array(
					'idprogramacion_reporte_cn' => 'Programaciones No Concluidas',
					'archivo' => 'Documento adjunto',
					'codigo_ot_retiro' => 'OT de Baja de Equipo',
				);

				$messages = array();

				$rules = array(
							'idprogramacion_reporte_cn' => 'required',
							'archivo' => 'required|max:15360',		
							'codigo_ot_retiro' => 'required',									
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('reporte_cn/create_reporte_cn')->withErrors($validator)->withInput(Input::all());					
				}else{
					if(!((Input::get('idreporte_etes1')==Input::get('idreporte_etes2') && Input::get('idreporte_etes1')!='')
						||(Input::get('idreporte_etes1')==Input::get('idreporte_etes3') && Input::get('idreporte_etes1')!='')
						||(Input::get('idreporte_etes1')==Input::get('idreporte_etes4') && Input::get('idreporte_etes1')!='')
						||(Input::get('idreporte_etes1')==Input::get('idreporte_etes5') && Input::get('idreporte_etes1')!='')
						||(Input::get('idreporte_etes2')==Input::get('idreporte_etes3') && Input::get('idreporte_etes2')!='')
						||(Input::get('idreporte_etes2')==Input::get('idreporte_etes4') && Input::get('idreporte_etes2')!='')
						||(Input::get('idreporte_etes2')==Input::get('idreporte_etes5') && Input::get('idreporte_etes3')!='')
						||(Input::get('idreporte_etes3')==Input::get('idreporte_etes4') && Input::get('idreporte_etes3')!='')
						||(Input::get('idreporte_etes3')==Input::get('idreporte_etes5') && Input::get('idreporte_etes3')!='')
						||(Input::get('idreporte_etes4')==Input::get('idreporte_etes5') && Input::get('idreporte_etes4')!='')) 
						){
						switch (Input::get('idtipo_reporte')) {
						    case 1:
						        $abreviatura = "NS";
						        break;
						    case 2:
						        $abreviatura = "NI";
						        break;
						    case 3:
						        $abreviatura = "NP";
						        break;
						}

					    $rutaDestino ='';
					    $nombreArchivo ='';	
					    if (Input::hasFile('archivo')) {
					        $archivo = Input::file('archivo');
					        $rutaDestino = 'uploads/documentos/planeamiento/reporteCN/';
					        $nombreArchivo        = $archivo->getClientOriginalName();
					        $nombreArchivoEncriptado = Str::random(27).'.'.pathinfo($nombreArchivo, PATHINFO_EXTENSION);
					        $uploadSuccess = $archivo->move($rutaDestino, $nombreArchivoEncriptado);
					    }

						$correlativo = $this->getCorrelativeReportNumber($abreviatura);
						$anho = date('y');
						$reporte_cn = new ReporteCN;
						$reporte_cn->numero_reporte_abreviatura = $abreviatura;
						$reporte_cn->numero_reporte_correlativo = $correlativo;
						$reporte_cn->numero_reporte_anho = $anho;
						$reporte_cn->url = $rutaDestino;
						$reporte_cn->nombre_archivo = $nombreArchivo;
						$reporte_cn->nombre_archivo_encriptado = $nombreArchivoEncriptado;
						$reporte_cn->idot_retiro = Input::get('idot_retiro');
						$reporte_cn->idprogramacion_reporte_cn = Input::get('idprogramacion_reporte_cn');
						if(Input::get('idreporte_etes1')!=''){
							$reporte_cn->idreporte_etes1 = Input::get('idreporte_etes1');
						}
						if(Input::get('idreporte_etes2')!=''){
							$reporte_cn->idreporte_etes2 = Input::get('idreporte_etes2');
						}
						if(Input::get('idreporte_etes3')!=''){
							$reporte_cn->idreporte_etes3 = Input::get('idreporte_etes3');
						}
						if(Input::get('idreporte_etes4')!=''){
							$reporte_cn->idreporte_etes4 = Input::get('idreporte_etes4');
						}
						if(Input::get('idreporte_etes5')!=''){
							$reporte_cn->idreporte_etes5 = Input::get('idreporte_etes5');
						}
						$reporte_cn->save();

						$programacion_reporte_cn = ProgramacionReporteCN::find(Input::get('idprogramacion_reporte_cn'));
						$programacion_reporte_cn->idestado_programacion_reportes = 2;
						$programacion_reporte_cn->save();
						
						Session::flash('message', 'Se registró correctamente el Reporte para Certificado de Necesidad.');
						return Redirect::to('reporte_cn/create_reporte_cn');
					}
					else{
						Session::flash('error', 'Existen dos o más Reportes ETES repetidos.');
						return Redirect::to('reporte_cn/create_reporte_cn')->withInput(Input::all());		
					}
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_reporte_cn($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_cn"] = TipoReporteCN::lists('nombre','idtipo_reporte_CN');
				$data["reporte_cn_info"] = ReporteCN::withTrashed()->find($id);
				$data["programacion_reporte_cn_info"] = ProgramacionReporteCN::withTrashed()->find($data["reporte_cn_info"]->idprogramacion_reporte_cn);
				$data["otretiro_info"] = OtRetiro::find($data["reporte_cn_info"]->idot_retiro);
				$data["otretiro_info"] = OtRetiro::searchOtByCodigoReporte($data["otretiro_info"]->ot_tipo_abreviatura,$data["otretiro_info"]->ot_correlativo,$data["otretiro_info"]->ot_activo_abreviatura)->get()[0];
				$data["reporte_etes_info1"] = ReporteETES::withTrashed()->find($data["reporte_cn_info"]->idreporte_etes1);
				$data["reporte_etes_info2"] = ReporteETES::withTrashed()->find($data["reporte_cn_info"]->idreporte_etes2);
				$data["reporte_etes_info3"] = ReporteETES::withTrashed()->find($data["reporte_cn_info"]->idreporte_etes3);
				$data["reporte_etes_info4"] = ReporteETES::withTrashed()->find($data["reporte_cn_info"]->idreporte_etes4);
				$data["reporte_etes_info5"] = ReporteETES::withTrashed()->find($data["reporte_cn_info"]->idreporte_etes5);
				return View::make('reportes_CN/editReporteCN',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_reporte_cn(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				if(!((Input::get('idreporte_etes1')==Input::get('idreporte_etes2') && Input::get('idreporte_etes1')!='')
					||(Input::get('idreporte_etes1')==Input::get('idreporte_etes3') && Input::get('idreporte_etes1')!='')
					||(Input::get('idreporte_etes1')==Input::get('idreporte_etes4') && Input::get('idreporte_etes1')!='')
					||(Input::get('idreporte_etes1')==Input::get('idreporte_etes5') && Input::get('idreporte_etes1')!='')
					||(Input::get('idreporte_etes2')==Input::get('idreporte_etes3') && Input::get('idreporte_etes2')!='')
					||(Input::get('idreporte_etes2')==Input::get('idreporte_etes4') && Input::get('idreporte_etes2')!='')
					||(Input::get('idreporte_etes2')==Input::get('idreporte_etes5') && Input::get('idreporte_etes3')!='')
					||(Input::get('idreporte_etes3')==Input::get('idreporte_etes4') && Input::get('idreporte_etes3')!='')
					||(Input::get('idreporte_etes3')==Input::get('idreporte_etes5') && Input::get('idreporte_etes3')!='')
					||(Input::get('idreporte_etes4')==Input::get('idreporte_etes5') && Input::get('idreporte_etes4')!='')) 
					){					    
					$reporte_cn = ReporteCN::find(Input::get('idreporte_cn'));
					if(Input::get('idreporte_etes1')!=''){
						$reporte_cn->idreporte_etes1 = Input::get('idreporte_etes1');
					}
					if(Input::get('idreporte_etes2')!=''){
						$reporte_cn->idreporte_etes2 = Input::get('idreporte_etes2');
					}
					if(Input::get('idreporte_etes3')!=''){
						$reporte_cn->idreporte_etes3 = Input::get('idreporte_etes3');
					}
					if(Input::get('idreporte_etes4')!=''){
						$reporte_cn->idreporte_etes4 = Input::get('idreporte_etes4');
					}
					if(Input::get('idreporte_etes5')!=''){
						$reporte_cn->idreporte_etes5 = Input::get('idreporte_etes5');
					}
					$reporte_cn->save();
					
					Session::flash('message', 'Se editó correctamente el Reporte para Certificado de Necesidad.');
					return Redirect::to('reporte_cn/edit_reporte_cn/'.Input::get('idreporte_cn'));
				}
				else{
					Session::flash('error', 'Existen dos o más Reportes ETES repetidos.');
					return Redirect::to('reporte_cn/edit_reporte_cn/'.Input::get('idreporte_cn'))->withInput(Input::all());		
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_reporte_cn($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["tipo_reporte_cn"] = TipoReporteCN::lists('nombre','idtipo_reporte_CN');
				$data["reporte_cn_info"] = ReporteCN::withTrashed()->find($id);
				$data["programacion_reporte_cn_info"] = ProgramacionReporteCN::withTrashed()->find($data["reporte_cn_info"]->idprogramacion_reporte_cn);
				$data["otretiro_info"] = OtRetiro::find($data["reporte_cn_info"]->idot_retiro);
				$data["otretiro_info"] = OtRetiro::searchOtByCodigoReporte($data["otretiro_info"]->ot_tipo_abreviatura,$data["otretiro_info"]->ot_correlativo,$data["otretiro_info"]->ot_activo_abreviatura)->get()[0];
				return View::make('reportes_CN/viewReporteCN',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_reporte_cn()
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
				$data["tipo_reporte_cn"] = TipoReporteCN::lists('nombre','idtipo_reporte_CN');
				$data["search_tipo_reporte_cn"] = null;
				$data["search_usuario"] = null;
				$data["search_servicio"] = null;
				$data["search_area"] = null;
				$data["search_nombre_equipo"] = null;			

				$data["reportes_cn_data"] = ReporteCN::getReportesCNInfo()->paginate(10);
				return View::make('reportes_CN/listReporteCN',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_reporte_cn()
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
				$data["tipo_reporte_cn"] = TipoReporteCN::lists('nombre','idtipo_reporte_CN');
				$data["search_tipo_reporte_cn"] = Input::get('search_tipo_reporte_cn');
				$data["search_usuario"] = Input::get('search_usuario');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["search_area"] = Input::get('search_area');
				$data["search_nombre_equipo"] = Input::get('search_nombre_equipo');			

				$data["reportes_cn_data"] = ReporteCN::searchReportesCN($data["search_numero_reporte"],
														$data["search_fecha_ini"],$data["search_fecha_fin"],
														$data["search_tipo_reporte_cn"],$data["search_usuario"],
														$data["search_servicio"],$data["search_area"],$data["search_nombre_equipo"])->paginate(10);
				return View::make('reportes_CN/listReporteCN',$data);
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

	public function return_num_doc_responsable_cn(){
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

	public function return_reporte_etes(){
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
				$reporte = ReporteETES::searchReporteETESByCodigoReporte($abreviatura,$correlativo,$anho)->get();
			}else{
				$reporte = null;
			}
			return Response::json(array( 'success' => true, 'reporte' => $reporte ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}

	public function getCorrelativeReportNumber($abreviatura){
		$reporte = ReporteCN::getLastReporte($abreviatura)->first();
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
				$reporte_cn = ReporteCN::find($id);
				$file= $reporte_cn->url.$reporte_cn->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($reporte_cn->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_reporte_cn()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$idreporte_CN = Input::get('idreporte_CN');
				$url = "reporte_cn/edit_reporte_cn/".$idreporte_CN;
				$reporte_cn = ReporteCN::find($idreporte_CN);
				$reporte_cn->delete();

				Session::flash('message', 'Se inhabilitó correctamente el Reporte.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_reporte_cn()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4){
				$idreporte_CN = Input::get('idreporte_CN');
				$url = "reporte_cn/edit_reporte_cn/".$idreporte_CN;
				$reporte_cn = ReporteCN::withTrashed()->find($idreporte_CN);
				$reporte_cn->restore();

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