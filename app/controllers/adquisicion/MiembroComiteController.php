<?php

class MiembroComiteController extends BaseController {

/*
	public function render_create_miembro_comite($idexpediente_tecnico=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				$data["expediente_tecnico_data"] = ExpedienteTecnico::withTrashed()->find($idexpediente_tecnico);
				return View::make('miembro_comite/createMiembroComite',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_create_miembro_comite()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'idpresidente' => 'Presidente',
				);

				$messages = array();

				$rules = array(	
					'idpresidente' => 'required',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('miembro_comite/create_miembro_comite/'.Input::get('idexpediente_tecnico'))->withErrors($validator)->withInput(Input::all());
				}else{
			    	$expediente_tecnico = ExpedienteTecnico::withTrashed()->find(Input::get('idexpediente_tecnico'));
			    	$expediente_tecnico->idpresidente = Input::get('idpresidente');
			    	if(Input::get('idmiembro1')!='')
			    		$expediente_tecnico->idmiembro1 = Input::get('idmiembro1');
			    	if(Input::get('idmiembro2')!='')
			    		$expediente_tecnico->idmiembro2 = Input::get('idmiembro2');
			    	if(Input::get('idmiembro3')!='')
			    		$expediente_tecnico->idmiembro3 = Input::get('idmiembro3');
					$expediente_tecnico->save();
					
					Session::flash('message', 'Se registró correctamente los Miembros de Comité.');				
					return Redirect::to('miembro_comite/list_miembro_comites');
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	*/

	public function render_edit_miembro_comite($idexpediente_tecnico=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ) && $idexpediente_tecnico){
				$data["expediente_tecnico_data"] = ExpedienteTecnico::withTrashed()->find($idexpediente_tecnico);
				$data["presidente_data"] = User::withTrashed()->find($data["expediente_tecnico_data"]->idpresidente);
				$data["miembro1_data"] = User::withTrashed()->find($data["expediente_tecnico_data"]->idmiembro1);
				$data["miembro2_data"] = User::withTrashed()->find($data["expediente_tecnico_data"]->idmiembro2);
				$data["miembro3_data"] = User::withTrashed()->find($data["expediente_tecnico_data"]->idmiembro3);
				return View::make('miembro_comite/editMiembroComite',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function submit_edit_miembro_comite()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 ){
				// Validate the info, create rules for the inputs
				$attributes = array(
					'idpresidente' => 'Presidente',
				);

				$messages = array();

				$rules = array(	
					'idpresidente' => 'required',
				);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules,$messages,$attributes);
				// If the validator fails, redirect back to the form
				$url = "miembro_comite/edit_miembro_comite"."/".Input::get('idexpediente_tecnico');
				if($validator->fails()){
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{		
					if(!((Input::get('idpresidente')==Input::get('idmiembro1'))
						||(Input::get('idpresidente')==Input::get('idmiembro2'))
						||(Input::get('idpresidente')==Input::get('idmiembro3'))
						||(Input::get('idmiembro1')==Input::get('idmiembro2') && Input::get('idmiembro1')!='')
						||(Input::get('idmiembro1')==Input::get('idmiembro3') && Input::get('idmiembro1')!='')
						||(Input::get('idmiembro2')==Input::get('idmiembro3') && Input::get('idmiembro2')!='')) ){			
						$expediente_tecnico = ExpedienteTecnico::withTrashed()->find(Input::get('idexpediente_tecnico'));
				    	$expediente_tecnico->idpresidente = Input::get('idpresidente');
				    	if(Input::get('idmiembro1')!='')
				    		$expediente_tecnico->idmiembro1 = Input::get('idmiembro1');
				    	else
				    		$expediente_tecnico->idmiembro1 = null;
				    	if(Input::get('idmiembro2')!='')
				    		$expediente_tecnico->idmiembro2 = Input::get('idmiembro2');
				    	else
				    		$expediente_tecnico->idmiembro2 = null;
				    	if(Input::get('idmiembro3')!='')
				    		$expediente_tecnico->idmiembro3 = Input::get('idmiembro3');
				    	else
				    		$expediente_tecnico->idmiembro3 = null;
						$expediente_tecnico->save();

						Session::flash('message', 'Se registró correctamente los Miembros de Comité.');
						return Redirect::to($url);
					}else{
						Session::flash('error', 'Existen dos o más Miembros de Comité con el mismo Nombre de Usuario.');
						return Redirect::to($url)->withInput(Input::all());	
					}
				}
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function list_miembro_comites()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12 ){
				$data["search_codigo_compra"] = null;	
				$data["search_fecha_ini"] = null;			
				$data["search_fecha_fin"] = null;	
				$data["search_usuario"] = null;
				$data["search_area"] = null;
				$data["search_servicio"] = null;
				$data["areas"] = Area::orderBy('nombre','asc')->lists('nombre','idarea');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["expedientes_tecnico_data"] = ExpedienteTecnico::getExpedienteTecnicoInfo()->paginate(10);
				return View::make('miembro_comite/listMiembroComite',$data);
			}else{
				return View::make('error/error',$data);
			}

		}else{
			return View::make('error/error',$data);
		}
	}

	public function search_oferta_expediente()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$data["search_codigo_compra"] = Input::get('search_codigo_compra');	
				$data["search_fecha_ini"] = Input::get('search_fecha_ini');			
				$data["search_fecha_fin"] = Input::get('search_fecha_fin');
				$data["search_usuario"] = Input::get('search_usuario');			
				$data["search_area"] = Input::get('search_area');
				$data["search_servicio"] = Input::get('search_servicio');
				$data["areas"] = Area::orderBy('nombre','asc')->lists('nombre','idarea');
				$data["servicios"] = Servicio::orderBy('nombre','asc')->lists('nombre','idservicio');
				$data["ofertas_expediente_data"] = OfertaExpediente::searchOfertaExpediente($data["search_codigo_compra"],$data["search_usuario"],$data["search_area"],$data["search_servicio"],
					$data["search_fecha_ini"],$data["search_fecha_fin"])->paginate(10);	
				return View::make('oferta_expediente/listOfertaExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function render_view_oferta_expediente($idoferta_expediente=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1 || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 
			   || $data["user"]->idrol == 5 || $data["user"]->idrol == 6 || $data["user"]->idrol == 7 || $data["user"]->idrol == 8
			   || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12  ) && $idoferta_expediente){
				$data["oferta_expediente_data"] = OfertaExpediente::withTrashed()->find($idoferta_expediente);
				$data["expediente_tecnico_data"] = ExpedienteTecnico::withTrashed()->find($data["oferta_expediente_data"]->idexpediente_tecnico);
				$data["proveedores"] = Proveedor::orderBy('razon_social','asc')->lists('razon_social','idproveedor');							
				return View::make('oferta_expediente/viewOfertaExpediente',$data);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}	

	public function download($id=null)
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1  || $data["user"]->idrol == 2 || $data["user"]->idrol == 3 || $data["user"]->idrol == 4 || $data["user"]->idrol == 7
				 || $data["user"]->idrol == 8 || $data["user"]->idrol == 9 || $data["user"]->idrol == 10 || $data["user"]->idrol == 11 || $data["user"]->idrol == 12){
				$oferta_expediente = OfertaExpediente::find($id);
				$file= $oferta_expediente->url.$oferta_expediente->nombre_archivo_encriptado;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($oferta_expediente->nombre_archivo),$headers);
			}else{
				return View::make('error/error',$data);
			}
		}else{
			return View::make('error/error',$data);
		}
	}

	public function return_nombre_usuario(){
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
				$usuario = User::searchPersonalByUsername($data)->get();
			}else{
				$usuario = null;
			}
			return Response::json(array( 'success' => true, 'usuario' => $usuario ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}