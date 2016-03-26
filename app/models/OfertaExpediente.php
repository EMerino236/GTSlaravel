<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class OfertaExpediente extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'oferta_expediente';
	protected $primaryKey = 'idoferta_expediente';

	public function scopeGetOfertaExpedienteInfo($query)
	{
		$query->withTrashed()
			  ->rightjoin('expediente_tecnico','expediente_tecnico.idexpediente_tecnico','=','oferta_expediente.idexpediente_tecnico')
			  ->join('users','users.id','=','expediente_tecnico.idresponsable')
			  ->leftjoin('servicios','servicios.idservicio','=','expediente_tecnico.idservicio')
			  ->join('areas','areas.idarea','=','expediente_tecnico.idarea')
			  ->select('servicios.nombre as nombre_servicio','areas.nombre as nombre_area','users.apellido_pat','users.apellido_mat','users.nombre','expediente_tecnico.*','oferta_expediente.idoferta_expediente',
			  	'oferta_expediente.correlativo_por_expediente')
			  ->orderBy('expediente_tecnico.codigo_compra')
			  ->orderBy('oferta_expediente.correlativo_por_expediente','asc');;
	  	return $query;
	}

	public function scopeSearchOfertaExpediente($query,$search_codigo_compra,$search_usuario,$search_area,$search_servicio,$search_fecha_ini,$search_fecha_fin)
	{
		$query->withTrashed()
			  ->rightjoin('expediente_tecnico','expediente_tecnico.idexpediente_tecnico','=','oferta_expediente.idexpediente_tecnico')
			  ->join('users','users.id','=','expediente_tecnico.idresponsable')
			  ->leftjoin('servicios','servicios.idservicio','=','expediente_tecnico.idservicio')
			  ->join('areas','areas.idarea','=','expediente_tecnico.idarea')
			  ->whereNested(function($query) use($search_usuario){
			  		$query->where('users.nombre','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
			  });
			  if($search_servicio!='')
			  	$query->where('expediente_tecnico.idservicio','=',$search_servicio);
			  if($search_area!='')
			  	$query->where('expediente_tecnico.idarea','=',$search_area);
			  if($search_codigo_compra!="")
			  	$query->where('expediente_tecnico.codigo_compra','LIKE',"%$search_codigo_compra%");
			  if($search_fecha_ini != "")
				$query->where('expediente_tecnico.created_at','>=',date('Y-m-d H:i:s',strtotime($search_fecha_ini)));
			  if($search_fecha_fin != "")
				$query->where('expediente_tecnico.created_at','<=',date('Y-m-d H:i:s',strtotime($search_fecha_fin)));
			  $query->select('servicios.nombre as nombre_servicio','areas.nombre as nombre_area','users.apellido_pat','users.apellido_mat','users.nombre','expediente_tecnico.*','oferta_expediente.idoferta_expediente',
			  	'oferta_expediente.correlativo_por_expediente')
			  ->orderBy('expediente_tecnico.codigo_compra')
			  ->orderBy('oferta_expediente.correlativo_por_expediente','asc');;
	  	return $query;
	}
	
	public function scopeGetMaximoCorrelativoPorExpediente($query,$idexpediente)
	{
		$query->withTrashed()
			  ->where('idexpediente_tecnico','=',$idexpediente)
			  ->orderBy('correlativo_por_expediente','desc')
			  ->select('correlativo_por_expediente');
	  	return $query;
	}

	public function scopeSearchOfertaExpedienteByNumeroExpediente($query,$expediente_tecnico)
	{
		$query->withTrashed()
			  ->join('expediente_tecnico','expediente_tecnico.idexpediente_tecnico','=','oferta_expediente.idexpediente_tecnico')			  
			  ->join('proveedores','proveedores.idproveedor','=','oferta_expediente.idproveedor')
			  ->where('oferta_expediente.idexpediente_tecnico','=',$expediente_tecnico)
			  ->select('proveedores.razon_social as nombre_proveedor','oferta_expediente.*')
			  ->orderBy('oferta_expediente.correlativo_por_expediente','asc');
	  	return $query;
	}

	public function scopeSearchOfertasByNumeroExpediente($query,$expediente_tecnico)
	{
		$query->withTrashed()
			  ->join('expediente_tecnico','expediente_tecnico.idexpediente_tecnico','=','oferta_expediente.idexpediente_tecnico')			  
			  ->join('proveedores','proveedores.idproveedor','=','oferta_expediente.idproveedor')
			  ->where('oferta_expediente.idexpediente_tecnico','=',$expediente_tecnico)
			  ->select('proveedores.razon_social as nombre_proveedor','oferta_expediente.*')
			  ->orderBy('correlativo_por_expediente','asc');
	  	return $query;
	}
}