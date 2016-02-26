<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteCalibracion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reporte_calibracion';

	public function scopeGetReportesInfo($query)
	{
		$query->withTrashed()
			  ->join('activos','activos.idactivo','=','reporte_calibracion.idactivo')			
			  ->join('servicios','servicios.idservicio','=','activos.idservicio')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')			  
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->join('detalle_reporte_calibracion','detalle_reporte_calibracion.idreporte_calibracion','=','reporte_calibracion.id')
			  ->select('reporte_calibracion.*','servicios.nombre as nombre_servicio','grupos.nombre as nombre_grupo','marcas.nombre as nombre_marca','familia_activos.nombre_equipo as nombre_familia','modelo_activos.nombre as nombre_modelo','activos.*','proveedores.razon_social as nombre_proveedor','activos.idactivo as idactivo');
		return $query;
	}

	public function scopeSearchReportesCalibracion($query,$search_codigo_reporte,$search_codigo_patrimonial,$search_nombre_equipo,$search_servicio,$search_area,$search_grupo)
	{
		$query->join('activos','activos.idactivo','=','reporte_calibracion.idactivo')			
			  ->join('servicios','servicios.idservicio','=','activos.idservicio')
			  ->join('areas','areas.idarea','=','servicios.idarea')
			  ->join('grupos','grupos.idgrupo','=','activos.idgrupo')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')			  
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('proveedores','proveedores.idproveedor','=','activos.idproveedor')
			  ->join('detalle_reporte_calibracion','detalle_reporte_calibracion.idreporte_calibracion','=','reporte_calibracion.id');	
			  
			  if($search_codigo_reporte != '')
			  {
			  	$query->where(DB::raw("CONCAT(reporte_calibracion.codigo_abreviatura,'-',reporte_calibracion.codigo_correlativo,'-',reporte_calibracion.codigo_anho)"),'LIKE',"%$search_codigo_reporte%");
			  }

			  if($search_codigo_patrimonial != '')
			  {
			  	$query->where('activos.codigo_patrimonial','=',$search_codigo_patrimonial);
			  }

			  if($search_nombre_equipo != '')
			  {
			  	$query->where('familia_activos.nombre_equipo','LIKE',"%search_nombre_equipo%");
			  }

			  if($search_servicio != "")
			  {
			  	$query->where('servicios.idservicio','=',$search_servicio);
			  }

			  if($search_area != "")
			  {
			  	$query->where('areas.idarea','=',$search_area);
			  }

			  if($search_grupo != "")
			  {
			  	$query->where('grupos.idgrupo','=',$search_grupo);
			  }

			  $query ->select('reporte_calibracion.*','servicios.nombre as nombre_servicio','grupos.nombre as nombre_grupo','marcas.nombre as nombre_marca','familia_activos.nombre_equipo as nombre_familia','modelo_activos.nombre as nombre_modelo','activos.*','proveedores.razon_social as nombre_proveedor','activos.idactivo as idactivo');
		return $query;
	}

	public function scopeGetDetalleReporteCalibracion($query,$idReporte){
		$query->withTrashed()			  
			  ->join('detalle_reporte_calibracion','detalle_reporte_calibracion.idreporte_calibracion','=','reporte_calibracion.id')
			  ->where('detalle_reporte_calibracion.idreporte_calibracion','=',$idReporte)
			  ->select('detalle_reporte_calibracion.*');
		return $query;
	}
}