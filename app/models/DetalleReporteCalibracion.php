<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DetalleReporteCalibracion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'detalle_reporte_calibracion';

	public function scopeGetDetalleReporteCalibracion($query,$idReporte){
		$query->withTrashed()			  
			  ->join('reporte_calibracion','reporte_calibracion.id','=','detalle_reporte_calibracion.idreporte_calibracion')
			  ->where('detalle_reporte_calibracion.idreporte_calibracion','=',$idReporte)
			  ->select('detalle_reporte_calibracion.*');
		return $query;
	}
	
}