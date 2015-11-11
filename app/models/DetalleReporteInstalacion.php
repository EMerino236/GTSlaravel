<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DetalleReporteInstalacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'detalle_reporte_instalaciones';
	protected $primaryKey = 'iddetalle_reporte_instalacion';

	public function scopeSearchDetalleReporteByIdReporteInstalacion($query,$idReporte)
	{
		$sql = 'select nombre_tarea, if(tarea_realizada = 1,"Realizado","No Realizado") as tarea_realizada
				from detalle_reporte_instalaciones
				where idreporte_instalacion = '.$idReporte;
		$query = DB::select(DB::raw($sql));	
		return $query;
	}

	public function scopeDeleteDetalleByIdReporteInstalacion($query,$search_criteria)
	{
		$query->where('idreporte_instalacion','=',$search_criteria);
		return $query;
	}
	
}