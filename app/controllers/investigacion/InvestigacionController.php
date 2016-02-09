<?php

class InvestigacionController extends \BaseController 
{

	public function home()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		$data["documentos_data"] = DocumentoInf::GetGuiasPendientesCargar()->get();
		return View::make('investigacion/investigacion',$data);
	}

}
