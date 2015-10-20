<?php

class AccesoriosController extends BaseController
{

	public function submit_delete_accesorio_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check()){
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1){
				$idmodelo_equipo = Input::get('idmodelo_equipo');
				$url = "familia_activos/create_accesorio_modelo_familia_activo"."/".$idmodelo_equipo;
				$idaccesorio = Input::get('idaccesorio');
				$accesorio = Accesorio::find($idaccesorio);
				$accesorio->delete();
				
				return Redirect::to($url)->with('message', 'Se eliminó correctamente el accesorio.');
			}else{
				return View::make('error/error');
			}
		}else{
			return View::make('error/error');
		}
	}

}