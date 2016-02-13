	<?php

	class DashboardController extends BaseController
	{
	public function home()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		return View::make('dashboard/dashboard',$data);
	}

	public function mision_vision()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		return View::make('dashboard/misionVision',$data);
	}

	public function acerca_desarrollo()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		return View::make('dashboard/acercaDesarrollo',$data);
	}
}