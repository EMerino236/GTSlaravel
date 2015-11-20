<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OrdenesTrabajoBusquedaInformacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'ot_busqueda_infos';
	protected $primaryKey = 'idot_busqueda_info';

	
	public function scopeGetOtsBusquedaInfo($query)
	{
		$query->join('estados','estados.idestado','=','ot_busqueda_infos.idestado_ot')
			  ->join('areas','areas.idarea','=','ot_busqueda_infos.idarea')
			  ->join('users','users.id','=','ot_busqueda_infos.id_usuariosolicitante')
			  ->join('tipo_busqueda_infos','tipo_busqueda_infos.idtipo_busqueda_info','=','ot_busqueda_infos.idtipo_busqueda_info')
			  ->select('areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','estados.nombre as nombre_estado','tipo_busqueda_infos.nombre as nombre_tipo','ot_busqueda_infos.*');
	  	return $query;
	}


	public function scopeSearchOtsBusquedaInformacion($query,$search_tipo,$search_area,$search_encargado,$search_ot,$search_ini)
	{
		$query->join('estados','estados.idestado','=','ot_busqueda_infos.idestado_ot')
			  ->join('areas','areas.idarea','=','ot_busqueda_infos.idarea')
			  ->join('users','users.id','=','ot_busqueda_infos.id_usuariosolicitante')
			  ->join('tipo_busqueda_infos','tipo_busqueda_infos.idtipo_busqueda_info','=','ot_busqueda_infos.idtipo_busqueda_info')
			  ->whereNested(function($query) use($search_encargado){
			  		$query->where('users.nombre','LIKE',"%$search_encargado%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_encargado%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_encargado%");
			  });
			  if($search_tipo!=0)
			  	$query->where('tipo_busqueda_infos.idtipo_busqueda_info','=',$search_tipo);
			  if($search_ot!="")
			  	$query->where(DB::raw("CONCAT(ot_busqueda_infos.ot_tipo_abreviatura,ot_busqueda_infos.ot_correlativo)"),'LIKE',"%$search_ot%");
			  if($search_area!=0)
			  	$query->where('areas.idarea','=',$search_area);			 
			  if($search_ini != "")
				$query->where('ot_busqueda_infos.fecha_programacion','>=',date('Y-m-d H:i:s',strtotime($search_ini)));
			  
			  $query->select('areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','estados.nombre as nombre_estado','tipo_busqueda_infos.nombre as nombre_tipo','ot_busqueda_infos.*');
	  	return $query;
	}

	public function scopeGetLastOtBusqueda($query)
	{
		$query->orderBy('idot_busqueda_info','desc');
	  	return $query;
	}

	public function scopeSearchOtBusquedaInformacionById($query,$search_criteria)
	{
		$query->join('estados','estados.idestado','=','ot_busqueda_infos.idestado_ot')
			  ->join('areas','areas.idarea','=','ot_busqueda_infos.idarea')
			  ->join('users as elaborador','elaborador.id','=','ot_busqueda_infos.id_usuarioelaborador')
			  ->join('users as solicitante','solicitante.id','=','ot_busqueda_infos.id_usuariosolicitante')
			  ->join('solicitud_busqueda_infos','solicitud_busqueda_infos.idsolicitud_busqueda_info','=','ot_busqueda_infos.idsolicitud_busqueda_info')
			  ->join('tipo_busqueda_infos','tipo_busqueda_infos.idtipo_busqueda_info','=','solicitud_busqueda_infos.idtipo_busqueda_info')
			  ->where('ot_busqueda_infos.idot_busqueda_info','=',$search_criteria)
			  ->select('solicitud_busqueda_infos.sot_tipo_abreviatura as sot_tipo_abreviatura','solicitud_busqueda_infos.sot_correlativo as sot_correlativo','tipo_busqueda_infos.idtipo_busqueda_info as idtipo_busqueda_info','areas.nombre as nombre_area','elaborador.nombre as nombre_elaborador','elaborador.apellido_pat as apat_elaborador','elaborador.apellido_mat as amat_elaborador','solicitante.nombre as nombre_solicitante','solicitante.apellido_pat as apat_solicitante','solicitante.apellido_mat as amat_solicitante','estados.nombre as nombre_estado','tipo_busqueda_infos.nombre as nombre_tipo','ot_busqueda_infos.*');
	  	return $query;
	}
	
	
}