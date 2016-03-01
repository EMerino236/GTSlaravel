<?php

class ProgramacionComprasController extends BaseController {

	public function render_create_programacion_compra()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$data["tipo_compra"] = TipoCompra::orderBy('nombre','asc')->lists('nombre','idtipo_compra');
				$data["unidad_medida"] = UnidadMedida::orderBy('nombre','asc')->lists('nombre','idunidad_medida');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				return View::make('programacion_compras/createProgramacionCompra',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_programacion_compra()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'codigo_compra' => 'Código de Compra',
					'descripcion_corta' => 'Descripción corta',
					'idtipo_compra' => 'Tipo de compra',
					'cantidad' => 'Cantidad',
					'idunidad_medida' => 'Unidad de Medida',
					'idusuario' => 'Usuario Solicitante',
					'idarea' => 'Departamento',
					'costo_aproximado' => 'Costo aproximado',
					'idresponsable' => 'Responsable',
					'descripcion' => 'Descripción',
					'fecha_inicio_evaluacion' => 'Fecha de inicio de evaluación',
					'fecha_aproximada_adquisicion' => 'Fecha aproximada de adquisicion',		
				);

				$messages = array();

				$rules = array(	
					'codigo_compra' => 'required|unique:programacion_compra_adquisicion',
					'descripcion_corta' => 'required|max:100',
					'idtipo_compra' => 'required',
					'cantidad' => 'required|integer',
					'idunidad_medida' => 'required',
					'costo_aproximado' => 'required|numeric',
					'idusuario' => 'required',
					'idarea' => 'required',
					'idresponsable' => 'required',
					'descripcion' => 'required|max:200',
					'fecha_inicio_evaluacion' => 'date',
					'fecha_aproximada_adquisicion' => 'date',		
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('programacion_compra/create_programacion_compra')->withErrors($validator)->withInput(Input::all());
				}else{
			    	$programacion_compra = new ProgramacionCompraAdquisicion;
			    	$programacion_compra->codigo_compra = Input::get('codigo_compra');
					$programacion_compra->descripcion_corta = Input::get('descripcion_corta');
					$programacion_compra->idtipo_compra = Input::get('idtipo_compra');
					$programacion_compra->cantidad = Input::get('cantidad');
					$programacion_compra->idunidad_medida = Input::get('idunidad_medida');
					$programacion_compra->costo_aproximado = Input::get('costo_aproximado');
					$programacion_compra->idarea = Input::get('idarea');
					$programacion_compra->idservicio = Input::get('idservicio');
					$programacion_compra->iduser = Input::get('idusuario');
					$programacion_compra->idresponsable = Input::get('idresponsable');
					$programacion_compra->descripcion = Input::get('descripcion');
					$programacion_compra->fecha_inicio_evaluacion = date("Y-m-d",strtotime(Input::get('fecha_inicio_evaluacion')));
					$programacion_compra->fecha_aproximada_adquisicion = date("Y-m-d",strtotime(Input::get('fecha_aproximada_adquisicion')));
					$programacion_compra->save();
					
					Session::flash('message', 'Se registró correctamente la Programación de compra.');				
					return Redirect::to('programacion_compra/create_programacion_compra');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_edit_plan_mejora_proceso($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $id){
				$data["tipo_documentos"] = TipoDocumentos::lists('nombre','idtipo_documento');
				$data["plan_mejora_proceso_info"] = PlanMejoraProceso::searchPlanMejoraProcesoById($id)->get();
				$data["archivo"] = basename($data["plan_mejora_proceso_info"][0]->url);
				if($data["plan_mejora_proceso_info"]->isEmpty()){
					return Redirect::to('plan_mejora_proceso/list_plan_mejora_procesos');
				}
				$data["plan_mejora_proceso_info"] = $data["plan_mejora_proceso_info"][0];
				return View::make('plan_mejora_procesos/editPlanMejoraProceso',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_plan_mejora_proceso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$iddocumento = Input::get('documento_id');
				$attributes = array(
					'nombre' => 'Nombre del Documento',
					'descripcion' => 'Descripción',
					'autor' => 'Autor',
					'codigo_archivamiento' => 'Código de Archivamiento',
					'ubicacion' => 'Ubicación'	
				);

				$messages = array();

				$rules = array(
					'nombre' => 'required|max:100|alpha_num_spaces|unique:plan_mejora_procesos,nombre,'.$iddocumento.',iddocumento',
					'descripcion' => 'required|max:200|alpha_num_spaces',
					'autor' => 'required|max:100|alpha_num_spaces',
					'codigo_archivamiento' => 'required|max:100|alpha_num|unique:plan_mejora_procesos,codigo_archivamiento,'.$iddocumento.',iddocumento',
					'ubicacion' => 'required|max:100|alpha_num_spaces'
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$iddocumento = Input::get('documento_id');
					$url = "plan_mejora_proceso/edit_plan_mejora_proceso"."/".$iddocumento;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$data["tipo_documentos"] = TipoDocumentos::searchTipoDocumentosById(Input::get('idtipo_documento'))->get();
					$data["plan_mejora_proceso_info"] = PlanMejoraProceso::searchPlanMejoraProcesoById(Input::get('documento_id'))->get();

					$iddocumento = Input::get('documento_id');
					$url = "plan_mejora_proceso/edit_plan_mejora_proceso"."/".$iddocumento;
					$plan_mejora_proceso = PlanMejoraProceso::find($iddocumento);
					$plan_mejora_proceso->nombre = Input::get('nombre');
					$plan_mejora_proceso->descripcion = Input::get('descripcion');
					$plan_mejora_proceso->autor = Input::get('autor');
					$plan_mejora_proceso->codigo_archivamiento = Input::get('codigo_archivamiento');
					$plan_mejora_proceso->ubicacion = Input::get('ubicacion');
					$plan_mejora_proceso->url = $data["plan_mejora_proceso_info"][0]->url;
					$plan_mejora_proceso->idtipo_documento = $data["plan_mejora_proceso_info"][0]->idtipo_documento;
					$plan_mejora_proceso->save();
					Session::flash('message', 'Se editó correctamente el Plan de Mejora de Procesos.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_plan_mejora_procesos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				$data["tipo_documentos"] = TipoDocumentos::orderBy('nombre','asc')->lists('nombre','idtipo_documento');

				$data["search_nombre"] = null;
				$data["search_autor"] = null;
				$data["search_codigo_archivamiento"] = null;
				$data["search_ubicacion"] = null;
				$data["search_tipo_documento"] = null;
				$data["plan_mejora_procesos_data"] = PlanMejoraProceso::getPlanMejoraProcesosInfo()->paginate(10);
				return View::make('plan_mejora_procesos/listPlanMejoraProcesos',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_plan_mejora_proceso()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["tipo_documentos"] = TipoDocumentos::lists('nombre','idtipo_documento');

				$data["search_nombre"] = Input::get('search_nombre');
				$data["search_autor"] = Input::get('search_autor');
				$data["search_codigo_archivamiento"] = Input::get('search_codigo_archivamiento');
				$data["search_ubicacion"] = Input::get('search_ubicacion');
				$data["search_tipo_documento"] = Input::get('search_tipo_documento');

				
				if($data["search_nombre"]==null && $data["search_autor"] == null && $data["search_codigo_archivamiento"]==null &&
					$data["search_ubicacion"] == null && $data["search_tipo_documento"]==null){
					$data["plan_mejora_procesos_data"] = PlanMejoraProceso::getPlanMejoraProcesosInfo()->paginate(10);
				}else{
					$data["plan_mejora_procesos_data"] = PlanMejoraProceso::searchPlanMejoraProcesos($data["search_nombre"],$data["search_autor"],$data["search_codigo_archivamiento"],
										$data["search_ubicacion"],$data["search_tipo_documento"])->paginate(10);
				}

				return View::make('plan_mejora_procesos/listPlanMejoraProcesos',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_enable_plan_mejora_proceso(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$documento_id = Input::get('documento_id');
				$url = "plan_mejora_proceso/edit_plan_mejora_proceso"."/".$documento_id;
				$plan_mejora_procesos = PlanMejoraProceso::withTrashed()->find($documento_id);
				$plan_mejora_procesos->restore();
				Session::flash('message', 'Se habilitó correctamente el plan de mejora de procesos.');
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_disable_plan_mejora_proceso(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$documento_id = Input::get("documento_id");
				$url = "plan_mejora_proceso/edit_plan_mejora_proceso"."/".$documento_id;
				$plan_mejora_procesos = PlanMejoraProceso::find($documento_id);
				$plan_mejora_procesos->delete();
				Session::flash('message','Se inhabilitó correctamente el plan de mejora de procesos.' );					
				return Redirect::to($url);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_documento($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12  ) && $id){
				$data["tipo_documentos"] = TipoDocumentos::lists('nombre','idtipo_documento');
				$data["plan_mejora_proceso_info"] = PlanMejoraProceso::searchPlanMejoraProcesoById($id)->get();
				$data["archivo"] = basename($data["plan_mejora_proceso_info"][0]->url);
				if($data["plan_mejora_proceso_info"]->isEmpty()){
					return Redirect::to('plan_mejora_procesos/list_plan_mejora_procesos');
				}
				$data["plan_mejora_proceso_info"] = $data["plan_mejora_proceso_info"][0];
				return View::make('plan_mejora_procesos/viewPlanMejoraProceso',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	

	public function return_num_doc_responsable(){
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

	public function return_num_doc_usuario(){
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
		if($data["user"]->idrol == 1 || $data["user"]->idrol == 2){
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
}