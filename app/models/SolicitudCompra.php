<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SolicitudCompra extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table ="solicitud_compras";
	protected $primaryKey = "idsolicitud_compra";

	public function scopeGetSolicitudesInfo($query)
	{
		$query->withTrashed()
			   ->join('servicios','servicios.idservicio','=','solicitud_compras.idservicio')			  
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','solicitud_compras.idfamilia_activo')
			  ->join('estados','estados.idestado','=','solicitud_compras.idestado')
			  ->select('servicios.nombre as nomb_servicio','solicitud_compras.*');
			return $query;
	}

	public function scopeSearchSolicitudes($query,$tipo,$servicio,$estado,$nombre_equipo,$fecha_desde,$fecha_hasta){
		$query->withTrashed()
			  ->join('servicios','servicios.idservicio','=','solicitud_compras.idservicio')			  
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','solicitud_compras.idfamilia_activo')
			  ->join('estados','estados.idestado','=','solicitud_compras.idestado')
			  ->whereNested(function($query) use($fecha_desde,$fecha_hasta,$proveedor,$tipo){
			  		$query->where('solicitud_compras.fecha','>',date('Y-m-d H:i:s',strtotime($fecha_desde)));	 			  			  
			  });
			  if($fecha_hasta != '1969-12-31 19:00:00')
			  {
			  	$query->where('solicitud_compras.fecha','<',date('Y-m-d H:i:s',strtotime($fecha_hasta)));
			  }
			  if($tipo != 0)
			  {
			  	$query->where('solicitud_compras.idtipo_solicitud_compra','=',$tipo);
			  }
			  if($servicio != '0')
			  {
			  	$query->where('solicitud_compras.idservicio','=',$servicio);
			  }
			  if($equipo != "")
			  {
			  	$query->where('familia_activos.nombre_equipo','LIKE',"%$nombre_equipo%");
			  }
			  if($estado != 0)
			  {
			  	$query->where('solicitud_compras.idestado','=',$estado);
			  }
			  $query->select('servicios.nombre as nomb_servicio','solicitud_compras.*');
		return $query;
	}

}