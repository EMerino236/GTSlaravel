<?php

class ConsumibleController extends BaseController
{

	public function submit_delete_consumible_ajax()
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
				$idconsumible = Input::get('idconsumible');				
				$consumible = Consumible::find($idconsumible);
				$consumible->delete();
				
				Session::flash('message', 'Se eliminó correctamente el consumible.');
				return Response::json(array( 'success' => true),200);				
			}
			else{
				return Response::json(array( 'success' => false),200);				
			}		
		}
	}

}