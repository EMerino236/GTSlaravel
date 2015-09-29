<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteIncumplimiento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reporte_incumplimientos';

	public function scopeGetReporteIncumplimientoInfo($query)
	{
		$query->withTrashed()
			  ->join('servicios','servicios.idservicio','=','reporte_incumplimientos.idservicio')
			  ->join('proveedores','proveedores.idproveedor','=','reporte_incumplimientos.idproveedor')
			  ->join('ordenes_trabajos','ordenes_trabajos.idordenes_trabajo','=','reporte_incumplimientos.idordenes_trabajo')
			  ->select('servicios.nombre as nomb_servicio','proveedores.nombre as nomb_proveedor','ordenes_trabajo.*');
		return $query;
	}
}