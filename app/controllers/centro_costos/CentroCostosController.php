<?php

class CentroCostosController extends BaseController
{	
	public function list_centros_costos()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = null;
				$data["centro_costos"] = CentroCosto::getCentroCostosInfo()->paginate(10);
				return View::make('centro_costos/listCentroCostos',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_centro_costo(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search"] = Input::get('search');
				$data["centro_costos"] = CentroCosto::searchCentroCostos($data["search"])->paginate(10);
				if($data["search"]==""){
					return Redirect::to('centro_costos/list_centros_costos');
				}else{
					return View::make('centro_costos/listCentroCostos',$data);	
				}
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_centro_costo()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){				
				return View::make('centro_costos/createCentroCosto',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_centro_costo($idcentro_costo=null){
		
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $idcentro_costo)
			{	
				$data["centro_costo_info"] = CentroCosto::searchCentroCostoById($idcentro_costo)->get();
				if($data["centro_costo_info"]->isEmpty()){
					return Redirect::to('centro_costos/listCentroCostos');
				}
				$data["centro_costo_info"] = $data["centro_costo_info"][0];

				return View::make('centro_costos/editCentroCosto',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}

	}

	public function submit_create_centro_costo(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100|unique:centro_costos',
							'descripcion' => 'max:200',
							'presupuesto' => 'required',					
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('centro_costos/create_centro_costo')->withErrors($validator)->withInput(Input::all());
				}else{
					$centro_costo = new CentroCosto;
					$centro_costo->nombre = Input::get('nombre');
					$centro_costo->descripcion = Input::get('descripcion');
					$centro_costo->presupuesto = Input::get('presupuesto');
					$centro_costo->idestado = 1;
					$centro_costo->save();
					Session::flash('message', 'Se registró correctamente el centro de costo.');
					return Redirect::to('centro_costos/list_centros_costos');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}	

	public function submit_edit_centro_costo(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'nombre' => 'required|max:100',
							'descripcion' => 'max:200',
							'presupuesto' => 'required',
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$centro_id = Input::get('centro_id');
					$url = "centro_costos/edit_centro_costo"."/".$centro_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{	
					$centro_id = Input::get('centro_id');				
					$url = "centro_costos/edit_centro_costo"."/".$centro_id;
					$centro_costo = CentroCosto::find($centro_id);
					$centro_costo->nombre = Input::get('nombre');
					$centro_costo->descripcion = Input::get('descripcion');
					$centro_costo->presupuesto = Input::get('presupuesto');
					$centro_costo->save();
					Session::flash('message', 'Se editó correctamente el centro de costo.');
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_enable_centro_costo(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$centro_id = Input::get('centro_id');
				$url = "centro_costos/edit_centro_costo"."/".$centro_id;
				$centro_costo = CentroCosto::withTrashed()->find($centro_id);
				$centro_costo->restore();
				Session::flash('message', 'Se habilitó correctamente el centro de costo.');
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function submit_disable_centro_costo(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$centro_id = Input::get("centro_id");
				$url = "centro_costos/edit_centro_costo"."/".$centro_id;
				$centro_costo = CentroCosto::find($centro_id);
				$areasActivas = Area::searchAreaActivoByIdCentroCosto($centro_id)->get();
				$serviciosActivos = Servicio::searchServicioActivoByIdCentroCosto($centro_id)->get();
				if(count($areasActivas)==0 && count($serviciosActivos)==0 ){			
					$centro_costo->delete();
					Session::flash('message','Se inhabilitó correctamente el centro de costo.' );
				}
				else{
					Session::flash('error', 'El centro de costo tiene un área/servicio activo. Acción no realizada.' );
				}				
				return Redirect::to($url);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}
}