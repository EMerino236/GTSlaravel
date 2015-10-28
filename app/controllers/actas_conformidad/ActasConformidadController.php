<?php

class ActasConformidadController extends BaseController
{	
	public function list_actas()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["tipos_acta"] = TipoActa::lists('nombre','idtipo_acta');				
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');
				$data["search_tipo_acta"] = null;
				$data["search_proveedor"] = null;
				$data["fecha_desde"] = null;
				$data["fecha_hasta"] = null;
				$data["actas_data"] = Documento::getActasInfo()->paginate(10);
				return View::make('actas_conformidad/listActaConformidad',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function search_acta()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$data["search_tipo_acta"] = Input::get('search_tipo_acta');
				$data["search_proveedor"] = Input::get('search_proveedor');
				$data["fecha_desde"] = Input::get('fecha_desde');
				$data["fecha_hasta"] = Input::get('fecha_hasta');
				$data["tipos_acta"] = TipoActa::lists('nombre','idtipo_acta');				
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');
				
				$data["actas_data"] = Documento::searchActasConformidad($data["search_tipo_acta"],$data["search_proveedor"],$data["fecha_desde"],$data["fecha_hasta"])->get();
				
				return View::make('actas_conformidad/listActaConformidad',$data);

			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function render_create_acta(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){

				$data["tipo_actas"] = TipoActa::lists('nombre','idtipo_acta');
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');
				
				return View::make('actas_conformidad/createActaConformidad',$data);
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function render_edit_acta($iddocumento=null){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if(($data["user"]->idrol == 1) && $iddocumento)
			{	
				$data["tipo_actas"] = TipoActa::lists('nombre','idtipo_acta');
				$data["proveedores"] = Proveedor::lists('razon_social','idproveedor');
				$data["documento_info"] = Documento::searchDocumentoById($iddocumento)->get();
				if($data["documento_info"]->isEmpty()){
					return Redirect::to('actas_conformidad/list_actas');
				}
				$data["documento_info"] = $data["documento_info"][0];

				return View::make('actas_conformidad/editActaConformidad',$data);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}

	}

	public function submit_create_acta(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'tipo' => 'required',
							'proveedor' => 'required',
							'fecha' => 'required',
							'numero_acta' => 'required',						
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					return Redirect::to('actas_conformidad/create_acta')->withErrors($validator)->withInput(Input::all());
				}else{
					$numero_acta = Input::get('numero_acta');
					$documento = Documento::searchDocumentoByCodigoArchivamiento($numero_acta)->get();
					if($documento->isEmpty()==true){
						Session::flash('error', 'Se registró correctamente el area.');				
						return Redirect::to('actas_conformidad/list_actas');
					}
					$documento = $documento[0];
					$documento->idproveedor = Input::get('proveedor');
					$documento->fecha_acta = date('Y-m-d H:i:s',strtotime(Input::get('fecha')));
					$documento->idtipo_acta = Input::get('tipo');
					$documento->save();
					Session::flash('message', 'Se registró correctamente el acta de conformidad.');
					
					return Redirect::to('actas_conformidad/list_actas');
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function submit_edit_acta(){
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				// Validate the info, create rules for the inputs
				$rules = array(
							'tipo' => 'required',
							'proveedor' => 'required',
							'fecha' => 'required',						
						);
				// Run the validation rules on the inputs from the form
				$validator = Validator::make(Input::all(), $rules);
				// If the validator fails, redirect back to the form
				if($validator->fails()){
					$acta_id = Input::get('acta_id');
					$url = "actas_conformidad/edit_acta"."/".$acta_id;
					return Redirect::to($url)->withErrors($validator)->withInput(Input::all());
				}else{
					$acta_id = Input::get('acta_id');
					$url = "actas_conformidad/edit_acta"."/".$acta_id;
					$documento = Documento::find($acta_id);
					if($documento==null){
						Session::flash('error', 'Se registró correctamente el area.');				
						return Redirect::to('actas_conformidad/list_actas');
					}
					//verificar si es una nueva acta a la que se le está asignando el proveedor
					$documento->idproveedor = Input::get('proveedor');
					$documento->fecha_acta = date('Y-m-d H:i:s',strtotime(Input::get('fecha')));
					$documento->idtipo_acta = Input::get('tipo');
					$documento->save();

					Session::flash('message', 'Se registró correctamente el acta de conformidad.');
					
					return Redirect::to($url);
				}
			}else{
				return View::make('error/error');
			}

		}else{
			return View::make('error/error');
		}
	}

	public function download_acta()
	{
		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$codigo = Input::get('numero_acta_hidden');		
				$documento = Documento::searchDocumentoByCodigoArchivamiento($codigo)->get();
				$file= $documento[0]->url;
				$headers = array(
		              'Content-Type',mime_content_type($file),
	            );
		        return Response::download($file,basename($file),$headers);
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

	public function return_name_acta(){
		if(!Request::ajax() || !Auth::check()){
			return Response::json(array( 'success' => false ),200);
		}
		$id = Auth::id();
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"] = Session::get('user');
		if($data["user"]->idrol == 1){
			// Check if the current user is the "System Admin"
			$data = Input::get('selected_id');
			if($data !="vacio"){
				$documento = Documento::searchDocumentoByCodigoArchivamiento($data)->get();
				if($documento->isEmpty()==false){
					$documento = $documento[0];
					if($documento->idtipo_documento != 9)
						$documento = 1;
				}else
					$documento = 2;
			}else{
				$documento = 2;
			}

			return Response::json(array( 'success' => true, 'reporte' => $documento ),200);
		}else{
			return Response::json(array( 'success' => false ),200);
		}
	}
}