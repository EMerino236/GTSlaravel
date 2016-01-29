<?php

class PlaneamientoController extends BaseController
{
	public function home()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		$data["reportes_cn_data"] = ReporteCN::getLast10CreatedReportesCNInfo()->get();
		return View::make('planeamiento/planeamiento',$data);
	}
}