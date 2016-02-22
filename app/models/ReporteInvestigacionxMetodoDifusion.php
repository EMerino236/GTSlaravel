<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteInvestigacionxMetodoDifusion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reporte_investigacionxmetodo';

	public function scopeGetReportexMetodo($query,$idreporte)
	{
		$query->withTrashed()
			   ->join('metodo_difusion','metodo_difusion.id','=','reporte_investigacionxmetodo.idmetodo') 
			   ->where('reporte_investigacionxmetodo.idreporte','=',$idreporte)
			   ->select('reporte_investigacionxmetodo.*','metodo_difusion.nombre as nombre_metodo');
		return $query;
	}
}