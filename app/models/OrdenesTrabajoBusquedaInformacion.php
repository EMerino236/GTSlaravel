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
			  ->join('users','users.id','=','ot_busqueda_infos.id_usuarioencargado')
			  ->join('tipo_busqueda_infos','tipo_busqueda_infos.idtipo_busqueda_info','=','ot_busqueda_infos.idtipo_busqueda_info')
			  ->select('areas.nombre as nombre_area','users.nombre as nombre_user','users.apellido_pat','users.apellido_mat','estados.nombre as nombre_estado','tipo_busqueda_infos.nombre as nombre_tipo','ot_busqueda_infos.*');
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
			  ->join('users as encargado','encargado.id','=','ot_busqueda_infos.id_usuarioencargado')
			  ->join('solicitud_busqueda_infos','solicitud_busqueda_infos.idsolicitud_busqueda_info','=','ot_busqueda_infos.idsolicitud_busqueda_info')
			  ->join('tipo_busqueda_infos','tipo_busqueda_infos.idtipo_busqueda_info','=','solicitud_busqueda_infos.idtipo_busqueda_info')
			  ->where('ot_busqueda_infos.idot_busqueda_info','=',$search_criteria)
			  ->select('solicitud_busqueda_infos.sot_tipo_abreviatura as sot_tipo_abreviatura','solicitud_busqueda_infos.sot_correlativo as sot_correlativo','tipo_busqueda_infos.idtipo_busqueda_info as idtipo_busqueda_info','areas.nombre as nombre_area','elaborador.nombre as nombre_elaborador','elaborador.apellido_pat as apat_elaborador','elaborador.apellido_mat as amat_elaborador','solicitante.nombre as nombre_solicitante','solicitante.apellido_pat as apat_solicitante','solicitante.apellido_mat as amat_solicitante','encargado.nombre as nombre_encargado','encargado.apellido_pat as apat_encargado','encargado.apellido_mat as amat_encargado','estados.nombre as nombre_estado','tipo_busqueda_infos.nombre as nombre_tipo','ot_busqueda_infos.*','solicitud_busqueda_infos.*');
	  	return $query;
	}
	
	
}