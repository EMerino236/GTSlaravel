<?php

class RiesgosController extends BaseController
{
	public function home()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		return View::make('riesgos/riesgos',$data);
	}
}