<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteCN extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idreporte_CN';
	protected $table = 'reporte_cn';

	public function scopeGetLastReporte($query,$abreviatura)
	{
		$query->where('numero_reporte_abreviatura','=',$abreviatura)
			  ->orderBy('idreporte_CN','desc');
	  	return $query;
	}

	public function scopeGetReportesCNInfo($query)
	{
		$query->withTrashed()
			  ->join('ot_retiros','ot_retiros.idot_retiro','=','reporte_cn.idot_retiro')
			  ->join('activos','activos.idactivo','=','ot_retiros.idactivo')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')
			  ->leftjoin('servicios','servicios.idservicio','=','reporte_cn.idservicio')
			  ->join('areas','areas.idarea','=','reporte_cn.idarea')
			  ->join('users','users.id','=','reporte_cn.iduser')
			  ->select('familia_activos.nombre_equipo','servicios.nombre as nombre_servicio','areas.nombre as nombre_area',
			  			'users.apellido_pat','users.apellido_mat','users.nombre','ot_retiros.idot_retiro',
			  			'ot_retiros.ot_tipo_abreviatura','ot_retiros.ot_correlativo','ot_retiros.ot_activo_abreviatura','reporte_cn.*');
	  	return $query;
	}

	public function scopeSearchReportesCN($query,$search_numero_reporte,$search_fecha_ini,$search_fecha_fin,$search_tipo_reporte_cn,
											$search_usuario,$search_servicio,$search_area,$search_nombre_equipo)
	{
		$query->withTrashed()
			  ->leftjoin('servicios','servicios.idservicio','=','reporte_cn.idservicio')
			  ->join('areas','areas.idarea','=','reporte_cn.idarea')
			  ->join('ot_retiros','ot_retiros.idot_retiro','=','reporte_cn.idot_retiro')
			  ->join('activos','activos.idactivo','=','ot_retiros.idactivo')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')
			  ->join('users','users.id','=','reporte_cn.iduser')
			  ->whereNested(function($query) use($search_usuario){
			  		$query->where('users.nombre','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
			  });
			  if($search_numero_reporte!="")
			  	$query->where(DB::raw("CONCAT(reporte_cn.numero_reporte_abreviatura,reporte_cn.numero_reporte_correlativo,'-',reporte_cn.numero_reporte_anho)"),'LIKE',"%$search_numero_reporte%");
			  if($search_nombre_equipo!="")
			  	$query->where('familia_activos.nombre_equipo','LIKE','%$search_nombre_equipo%');
			  if($search_fecha_ini != "")
				$query->where('reporte_cn.created_at','>=',date('Y-m-d H:i:s',strtotime($search_fecha_ini)));
			  if($search_fecha_fin != "")
				$query->where('reporte_cn.created_at','<=',date('Y-m-d H:i:s',strtotime($search_fecha_fin)));
			  if($search_servicio!='')
			  	$query->where('reporte_cn.idservicio','=',$search_servicio);
			  if($search_area!='')
			  	$query->where('reporte_cn.idarea','=',$search_area);
			  if($search_tipo_reporte_cn!='')
			  	$query->where('reporte_cn.idtipo_reporte_CN','=',$search_tipo_reporte_cn);
			  $query->select('familia_activos.nombre_equipo','servicios.nombre as nombre_servicio','areas.nombre as nombre_area',
			  			'users.apellido_pat','users.apellido_mat','users.nombre','ot_retiros.idot_retiro',
			  			'ot_retiros.ot_tipo_abreviatura','ot_retiros.ot_correlativo','ot_retiros.ot_activo_abreviatura','reporte_cn.*');
	  	return $query;
	}

}