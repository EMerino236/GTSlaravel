<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DetalleSolicitudCompra extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'detalle_solicitud_compras';
	protected $primaryKey = 'iddetalle_solicitud_compra';

	public function scopeGetDetalleSolicitudCompra($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('idsolicitud_compra','=',$search_criteria);
		return $query;
	}

	public function scopeGetDetalleSolicitudCompraById($query,$search_criteria){
		$query->withTrashed()
			  ->where('iddetalle_solicitud_compra','=',$search_criteria);
		return $query;
	}	

	public function scopeDeleteDetalleByIdSolicitudCompra($query,$search_criteria)
	{
		$query->where('idsolicitud_compra','=',$search_criteria);
		return $query;
	}
	

}