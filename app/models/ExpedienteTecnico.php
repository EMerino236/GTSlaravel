<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ExpedienteTecnico extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idexpediente_tecnico';
	protected $table = 'expediente_tecnico';

	public function scopeGetExpedienteTecnicoInfo($query)
	{
		$query->withTrashed()
			  ->leftjoin('servicios','servicios.idservicio','=','expediente_tecnico.idservicio')
			  ->join('areas','areas.idarea','=','expediente_tecnico.idarea')
			  ->join('users','users.id','=','expediente_tecnico.idresponsable')			  
			  ->select('servicios.nombre as nombre_servicio','areas.nombre as nombre_area','users.apellido_pat','users.apellido_mat','users.nombre','expediente_tecnico.*');
	  	return $query;
	}

	public function scopeSearchExpedienteTecnico($query,$search_codigo_compra,$search_usuario,$search_area,$search_servicio,$search_fecha_ini,$search_fecha_fin)
	{
		$query->withTrashed()
			  ->leftjoin('servicios','servicios.idservicio','=','expediente_tecnico.idservicio')
			  ->join('areas','areas.idarea','=','expediente_tecnico.idarea')
			  ->join('users','users.id','=','expediente_tecnico.idresponsable')
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
			  $query->select('servicios.nombre as nombre_servicio','areas.nombre as nombre_area','users.apellido_pat','users.apellido_mat','users.nombre','expediente_tecnico.*');
	  	return $query;
	}

	public function scopeSearchExpedienteTecnicoByNumeroExpediente($query,$expediente_tecnico)
	{
		$query->withTrashed()
			  ->leftjoin('proveedores','proveedores.idproveedor','=','expediente_tecnico.idproveedor_ganador')
			  ->where('expediente_tecnico.idexpediente_tecnico','=',$expediente_tecnico)			  		  
			  ->select('proveedores.razon_social as nombre_proveedor','expediente_tecnico.*');
	  	return $query;
	}

	public function scopeGetExpedienteTecnicoByFamiliaActivo($query,$familia_activo)
	{
		$query->withTrashed()
			  ->leftjoin('servicios','servicios.idservicio','=','expediente_tecnico.idservicio')
			  ->join('areas','areas.idarea','=','expediente_tecnico.idarea')	
			  ->where('expediente_tecnico.nombre_equipo',$familia_activo)	  
			  ->select('servicios.nombre as nombre_servicio','areas.nombre as nombre_area','expediente_tecnico.*')
	  		  ->orderBy('expediente_tecnico.created_at','desc')
	  		  ->limit(10);
	  	return $query;
	}

}