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
			  ->join('tipo_solicitud_compras','tipo_solicitud_compras.idtipo_solicitud_compra','=','solicitud_compras.idtipo_solicitud_compra')
			  ->select('servicios.nombre as nombre_servicio','tipo_solicitud_compras.nombre as nombre_tipo','estados.nombre as nombre_estado','familia_activos.nombre_equipo as nombre_equipo','solicitud_compras.*');
			return $query;
	}

	public function scopeSearchSolicitudes($query,$search_tipo,$search_servicio,$search_estado,$search_nombre_equipo,$fecha_desde,$fecha_hasta){
		$query->withTrashed()
			  ->join('servicios','servicios.idservicio','=','solicitud_compras.idservicio')			  
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','solicitud_compras.idfamilia_activo')
			  ->join('estados','estados.idestado','=','solicitud_compras.idestado')
			  ->join('tipo_solicitud_compras','tipo_solicitud_compras.idtipo_solicitud_compra','=','solicitud_compras.idtipo_solicitud_compra');
			  
			  if($fecha_desde != "")
			  {
			  	$query->where('solicitud_compras.fecha','>',date('Y-m-d H:i:s',strtotime($fecha_desde)));
			  }

			  if($fecha_hasta != "")
			  {
			  	$query->where('solicitud_compras.fecha','<',date('Y-m-d H:i:s',strtotime($fecha_hasta)));
			  }
			  if($search_tipo != '0')
			  {
			  	$query->where('solicitud_compras.idtipo_solicitud_compra','=',$search_tipo);
			  }
			  if($search_servicio != '0')
			  {
			  	$query->where('solicitud_compras.idservicio','=',$search_servicio);
			  }
			  if($search_nombre_equipo != "")
			  {
			  	$query->where('familia_activos.nombre_equipo','LIKE',"%$search_nombre_equipo%");
			  }
			  if($search_estado != '0')
			  {
			  	$query->where('solicitud_compras.idestado','=',$search_estado);
			  }
			  $query->select('servicios.nombre as nombre_servicio','tipo_solicitud_compras.nombre as nombre_tipo','estados.nombre as nombre_estado','familia_activos.nombre_equipo as nombre_equipo','solicitud_compras.*');

		return $query;
	}

	public function scopeGetSolicitudCompraById($query,$idsolicitud_compra){
		$query->withTrashed()
			   ->join('servicios','servicios.idservicio','=','solicitud_compras.idservicio')			  
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','solicitud_compras.idfamilia_activo')
			  ->join('marcas','marcas.idmarca','=','familia_activos.idmarca')
			  ->join('estados','estados.idestado','=','solicitud_compras.idestado')
			  ->join('tipo_solicitud_compras','tipo_solicitud_compras.idtipo_solicitud_compra','=','solicitud_compras.idtipo_solicitud_compra')
			  ->where('solicitud_compras.idsolicitud_compra','=',$idsolicitud_compra)
			  ->select('marcas.idmarca as idmarca','solicitud_compras.*');
			return $query;
	}

}