<?php

class RiesgosController extends BaseController
{
	public function home()
	{
		$data["inside_url"] = Config::get('app.inside_url');
		$data["user"]= Session::get('user');
		$data["eventos_adversos_data"] = EventoAdverso::getEventosInfo()->distinct()->take(5)->get();
		$data["reportes_data"] = ReporteCalibracion::getReportesInfoPendientes()->get();
		return View::make('riesgos/riesgos',$data);
	}
}