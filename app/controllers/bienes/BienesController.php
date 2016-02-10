<?php

class BienesController extends BaseController
{
	public function home()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		$data["sots_data"] = SolicitudOrdenTrabajo::getSotPendientes()->get();
		$data["mant_correctivos_data"] = OtCorrectivo::getOtsMantCorrectivoPendientes()->get();
		return View::make('bienes/bienes',$data);
	}
}