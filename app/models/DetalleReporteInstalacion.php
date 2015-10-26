<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DetalleReporteInstalacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'detalle_reporte_instalaciones';
	protected $primaryKey = 'iddetalle_reporte_instalacion';

	public function scopeSearchDetalleReporteByIdReporteInstalacion($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('idreporte_instalacion','=',$search_criteria);
		return $query;
	}
	
}