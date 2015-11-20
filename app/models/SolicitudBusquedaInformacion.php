<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SolicitudBusquedaInformacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	//protected $table = 'proveedores';

	protected $table = 'solicitud_busqueda_infos';
	protected $primaryKey = 'idsolicitud_busqueda_info';

	public function scopeGetSotsInfo($query)
	{
		$query->join('estados','estados.idestado','=','solicitud_busqueda_infos.idestado')
			  ->join('areas','areas.idarea','=','solicitud_busqueda_infos.idarea')
			  ->join('users','users.id','=','solicitud_busqueda_infos.id')
			  ->join('tipo_busqueda_infos','tipo_busqueda_infos.idtipo_busqueda_info','=','solicitud_busqueda_infos.idtipo_busqueda_info')
			  ->leftJoin('ot_busqueda_infos','ot_busqueda_infos.idsolicitud_busqueda_info','=','solicitud_busqueda_infos.idsolicitud_busqueda_info')
			  ->select('ot_busqueda_infos.idot_busqueda_info as idot','ot_busqueda_infos.ot_tipo_abreviatura as ot_tipo_abreviatura','ot_busqueda_infos.ot_correlativo as ot_correlativo','tipo_busqueda_infos.nombre as nombre_tipo','estados.nombre as nombre_estado','areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat as apat','users.apellido_mat as amat','solicitud_busqueda_infos.*');
		return $query;
	}
	
	/*
	public function scopeSearchSotById($query,$search_criteria)
	{
		$query->join('activos','activos.idactivo','=','solicitud_orden_trabajos.idactivo')
			  ->join('users','users.id','=','solicitud_orden_trabajos.id')
			  ->where('idsolicitud_orden_trabajo','=',$search_criteria)
			  ->select('activos.idactivo','activos.codigo_patrimonial','users.nombre','users.apellido_pat','users.apellido_mat','solicitud_orden_trabajos.*');
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
		if($search_estado != "0")
			$query->where('solicitud_orden_trabajos.idestado','=',$search_estado);
		if($search_ini != "")
			$query->where('solicitud_orden_trabajos.fecha_solicitud','>=',date('Y-m-d H:i:s',strtotime($search_ini)));
		if($search_fin != "")
			$query->where('solicitud_orden_trabajos.fecha_solicitud','<=',date('Y-m-d H:i:s',strtotime($search_fin)));
		$query->select('estados.nombre as nombre_estado','users.nombre','users.apellido_pat','users.apellido_mat','solicitud_orden_trabajos.*');
		return $query;
	}*/

	public function scopeGetLastSotBusqueda($query)
	{
		$query->orderBy('idsolicitud_busqueda_info','desc');
	  	return $query;
	}
}