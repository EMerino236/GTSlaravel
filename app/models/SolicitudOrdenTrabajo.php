<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SolicitudOrdenTrabajo extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	//protected $table = 'proveedores';
	protected $primaryKey = 'idsolicitud_orden_trabajo';

	public function scopeGetSotsInfo($query)
	{
		$query->join('estados','estados.idestado','=','solicitud_orden_trabajos.idestado')
			  ->join('users','users.id','=','solicitud_orden_trabajos.id')
			  ->select('estados.nombre as nombre_estado','users.nombre','users.apellido_pat','users.apellido_mat','solicitud_orden_trabajos.*');
		return $query;
	}
	
	public function scopeSearchSotById($query,$search_criteria)
	{
		$query->where('idsolicitud_orden_trabajo','=',$search_criteria);
		return $query;
	}
	
	public function scopeSearchSots($query,$search,$search_estado,$search_ini,$search_fin)
	{
		$query->join('estados','estados.idestado','=','solicitud_orden_trabajos.idestado')
			  ->join('users','users.id','=','solicitud_orden_trabajos.id')
			  ->whereNested(function($query) use($search){
			  		$query->where('users.nombre','LIKE',"%$search%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search%");
			  });
		if($search_estado != "16")
			$query->where('solicitud_orden_trabajos.idestado','=',$search_estado);
		if($search_ini != "")
			$query->where('solicitud_orden_trabajos.fecha_solicitud','>=',$search_ini);
		if($search_fin != "")
			$query->where('solicitud_orden_trabajos.fecha_solicitud','<=',$search_fin);
		$query->select('estados.nombre as nombre_estado','users.nombre','users.apellido_pat','users.apellido_mat','solicitud_orden_trabajos.*');
		return $query;
	}
}