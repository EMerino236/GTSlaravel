<?php

class ComponenteController extends BaseController
{

	public function submit_delete_componente_ajax()
	{
		if(!Request::ajax() || !Auth::check())
		{
			return Response::json(array( 'success' => false ),200);
		}

		if(Auth::check())
		{
			$data["inside_url"] = Config::get('app.inside_url');
			$data["user"] = Session::get('user');
			// Verifico si el usuario es un Webmaster
			if($data["user"]->idrol == 1)
			{							
				$idcomponente = Input::get('idcomponente');				
				$componente = Componente::find($idcomponente);
				$componente->delete();
				
				Session::flash('message', 'Se eliminó correctamente el componente.');
				return Response::json(array( 'success' => true),200);				
			}
			else{
				return Response::json(array( 'success' => false),200);				
			}		
		}
	}

}