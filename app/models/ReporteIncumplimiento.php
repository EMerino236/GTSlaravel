<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteIncumplimiento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reporte_incumplimientos';
	protected $primaryKey = 'idreporte_incumplimiento';

	public function scopeGetReporteIncumplimientoInfo($query)
	{
		$query->withTrashed()
			  ->join('servicios','servicios.idservicio','=','reporte_incumplimientos.idservicio')
			  ->join('proveedores','proveedores.idproveedor','=','reporte_incumplimientos.idproveedor')
			  ->join('ordenes_trabajos','ordenes_trabajos.idordenes_trabajo','=','reporte_incumplimientos.idordenes_trabajo')
			  ->select('servicios.nombre as nomb_servicio','proveedores.razon_social as nomb_proveedor','reporte_incumplimientos.*');
		return $query;
	}

	public function scopeGetReporteIncumplimientoById($query,$idreporte)
	{
		$query->withTrashed()
			  ->join('servicios','servicios.idservicio','=','reporte_incumplimientos.idservicio')
			  ->join('proveedores','proveedores.idproveedor','=','reporte_incumplimientos.idproveedor')
			  ->join('ordenes_trabajos','ordenes_trabajos.idordenes_trabajo','=','reporte_incumplimientos.idordenes_trabajo')
			   ->whereNested(function($query) use($idreporte){
			  		$query->where('reporte_incumplimientos.idreporte_incumplimiento','=',$idreporte);	 			  			  
			  })
			  ->select('servicios.nombre as nomb_servicio','proveedores.razon_social as nomb_proveedor','reporte_incumplimientos.*');
		return $query;
	}

	public function scopeSearchReportes($query,$fecha_desde,$fecha_hasta,$proveedor,$tipo){
		$query->withTrashed()
			  ->join('servicios','servicios.idservicio','=','reporte_incumplimientos.idservicio')
			  ->join('proveedores','proveedores.idproveedor','=','reporte_incumplimientos.idproveedor')
			  ->join('ordenes_trabajos','ordenes_trabajos.idordenes_trabajo','=','reporte_incumplimientos.idordenes_trabajo');
			  
			  if($fecha_hasta != "")
			  {
			  	$query->where('reporte_incumplimientos.fecha','>',$fecha_desde);
			  }
			  if($fecha_hasta != "")
			  {
			  	$query->where('reporte_incumplimientos.fecha','<',$fecha_hasta);
			  }
			  if($proveedor != '0')
			  {
			  	$query->where('reporte_incumplimientos.idproveedor','=',$proveedor);
			  }
			  if($tipo != '0')
			  {
			  	$query->where('reporte_incumplimientos.tipo_reporte','=',$tipo);
			  }
			  $query->select('servicios.nombre as nomb_servicio','proveedores.razon_social as nomb_proveedor','reporte_incumplimientos.*');
		return $query;
	}
}