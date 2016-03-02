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

	public function render_edit_programacion_compra($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $id){
				$data["tipo_compra"] = TipoCompra::orderBy('nombre','asc')->lists('nombre','idtipo_compra');
				$data["unidad_medida"] = UnidadMedida::orderBy('nombre','asc')->lists('nombre','idunidad_medida');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["programacion_compra_info"] = ProgramacionCompraAdquisicion::withTrashed()->find($id);
				$data["usuario_info"] = User::withTrashed()->find($data["programacion_compra_info"]->iduser);
				$data["responsable_info"] = User::withTrashed()->find($data["programacion_compra_info"]->idresponsable);
				return View::make('programacion_compras/editProgramacionCompra',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_programacion_compra()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$iddocumento = Input::get('documento_id');
				$attributes = array(
					'descripcion_corta' => 'Descripción corta',
					'idtipo_compra' => 'Tipo de compra',
					'cantidad' => 'Cantidad',
					'idunidad_medida' => 'Unidad de Medida',
					'idarea' => 'Departamento',
					'costo_aproximado' => 'Costo aproximado',
					'descripcion' => 'Descripción',
					'fecha_inicio_evaluacion' => 'Fecha de inicio de evaluación',
					'fecha_aproximada_adquisicion' => 'Fecha aproximada de adquisicion',
				);

				$messages = array();

				$rules = array(
					'descripcion_corta' => 'required|max:100',
					'idtipo_compra' => 'required',
					'cantidad' => 'required|integer',
					'idunidad_medida' => 'required',
					'costo_aproximado' => 'required|numeric',
					'idarea' => 'required',
					'descripcion' => 'required|max:200',
					'fecha_inicio_evaluacion' => 'date',
					'fecha_aproximada_adquisicion' => 'date',	
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$url = "programacion_compra/edit_programacion_compra"."/".Input::get('programacion_compraid');
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{					
					$programacion_compra= ProgramacionCompraAdquisicion::withTrashed()->find(Input::get('programacion_compraid'));
					$programacion_compra->descripcion_corta = Input::get('descripcion_corta');
					$programacion_compra->idtipo_compra = Input::get('idtipo_compra');
					$programacion_compra->cantidad = Input::get('cantidad');
					$programacion_compra->idunidad_medida = Input::get('idunidad_medida');
					$programacion_compra->costo_aproximado = Input::get('costo_aproximado');
					$programacion_compra->idarea = Input::get('idarea');
					$programacion_compra->idservicio = Input::get('idservicio');
					$programacion_compra->descripcion = Input::get('descripcion');
					$programacion_compra->fecha_inicio_evaluacion = date("Y-m-d",strtotime(Input::get('fecha_inicio_evaluacion')));
					$programacion_compra->fecha_aproximada_adquisicion = date("Y-m-d",strtotime(Input::get('fecha_aproximada_adquisicion')));
					$programacion_compra->save();
					Session::flash('message', 'Se editó correctamente la Programación de Compra.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_programacion_compras()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){	
				$data["search_fecha"] = null;
				$data["anho_actual"] = date('Y');
				$data["dia_actual"] = date('d');
				$data["mes_actual"] = date('m');
				if($data["mes_actual"]%3==0)
					$data["trimestre"] = $data["mes_actual"]/3;
				else
					$data["trimestre"] = ceil($data["mes_actual"]/3);
				$data["programacion_compras_data"] = ProgramacionCompraAdquisicion::getProgramacionCompraInfo($data["anho_actual"])->get();
				return View::make('programacion_compras/listProgramacionCompra',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_programacion_compra()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_fecha"] = Input::get('search_fecha');	
				$data["anho_actual"] = date('Y');
				$data["dia_actual"] = date('d');
				$data["mes_actual"] = date('m');
				$data["programacion_compras_data"] = ProgramacionCompraAdquisicion::getProgramacionCompraInfo($data["search_fecha"] = Input::get('search_fecha'))->get();
				return View::make('programacion_compras/listProgramacionCompra',$data);
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
				$data["tipo_compra"] = TipoCompra::orderBy('nombre','asc')->lists('nombre','idtipo_compra');
				$data["unidad_medida"] = UnidadMedida::orderBy('nombre','asc')->lists('nombre','idunidad_medida');
				$data["areas"] = Area::lists('nombre','idarea');
				$data["servicios"] = Servicio::lists('nombre','idservicio');
				$data["programacion_compra_info"] = ProgramacionCompraAdquisicion::withTrashed()->find($id);
				$data["usuario_info"] = User::withTrashed()->find($data["programacion_compra_info"]->iduser);
				$data["responsable_info"] = User::withTrashed()->find($data["programacion_compra_info"]->idresponsable);
				return View::make('programacion_compras/viewProgramacionCompra',$data);
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