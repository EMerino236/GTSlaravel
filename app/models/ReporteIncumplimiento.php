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

	public function scopeSearchReportes($query,$fecha_desde,$fecha_hasta,$proveedor,$tipo){
		$query->withTrashed()
			  ->whereNested(function($query) use($fecha_desde,$fecha_hasta,$proveedor,$tipo){
			  		$query->where('fecha','>',$fecha_desde)
			  			  ->where('fecha','<',$fecha_hasta)
			  			  ->where('idproveedor','=',$proveedor)
			  			  ->where('tipo_reporte','=',$tipo);
			  })
			  ->select('reporte_incumplimientos.*');
		return $query;
	}
}