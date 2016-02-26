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
			  ->join('programacion_reporte_cn','programacion_reporte_cn.idprogramacion_reporte_cn','=','reporte_cn.idprogramacion_reporte_cn')
			  ->join('ot_retiros','ot_retiros.idot_retiro','=','reporte_cn.idot_retiro')
			  ->join('activos','activos.idactivo','=','ot_retiros.idactivo')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')
			  ->leftjoin('servicios','servicios.idservicio','=','programacion_reporte_cn.idservicio')
			  ->join('areas','areas.idarea','=','programacion_reporte_cn.idarea')
			  ->join('users','users.id','=','programacion_reporte_cn.iduser')
			  ->select('familia_activos.nombre_equipo','servicios.nombre as nombre_servicio','areas.nombre as nombre_area',
			  			'users.apellido_pat','users.apellido_mat','users.nombre','ot_retiros.idot_retiro',
			  			'ot_retiros.ot_tipo_abreviatura','ot_retiros.ot_correlativo','ot_retiros.ot_activo_abreviatura','reporte_cn.*');
	  	return $query;
	}

	public function scopeSearchReportesCN($query,$search_numero_reporte,$search_fecha_ini,$search_fecha_fin,$search_tipo_reporte_cn,
											$search_usuario,$search_servicio,$search_area,$search_nombre_equipo)
	{
		$query->withTrashed()
			  ->join('programacion_reporte_cn','programacion_reporte_cn.idprogramacion_reporte_cn','=','reporte_cn.idprogramacion_reporte_cn')
			  ->leftjoin('servicios','servicios.idservicio','=','programacion_reporte_cn.idservicio')
			  ->join('areas','areas.idarea','=','programacion_reporte_cn.idarea')
			  ->join('ot_retiros','ot_retiros.idot_retiro','=','reporte_cn.idot_retiro')
			  ->join('activos','activos.idactivo','=','ot_retiros.idactivo')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')
			  ->join('users','users.id','=','programacion_reporte_cn.iduser')
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
			  	$query->where('programacion_reporte_cn.idservicio','=',$search_servicio);
			  if($search_area!='')
			  	$query->where('programacion_reporte_cn.idarea','=',$search_area);
			  if($search_tipo_reporte_cn!='')
			  	$query->where('programacion_reporte_cn.idtipo_reporte_CN','=',$search_tipo_reporte_cn);
			  $query->select('familia_activos.nombre_equipo','servicios.nombre as nombre_servicio','areas.nombre as nombre_area',
			  			'users.apellido_pat','users.apellido_mat','users.nombre','ot_retiros.idot_retiro',
			  			'ot_retiros.ot_tipo_abreviatura','ot_retiros.ot_correlativo','ot_retiros.ot_activo_abreviatura','reporte_cn.*');
	  	return $query;
	}

	public function scopeGetLast10CreatedReportesCNInfo($query)
	{
		$query->withTrashed()
			  ->join('programacion_reporte_cn','programacion_reporte_cn.idprogramacion_reporte_cn','=','reporte_cn.idprogramacion_reporte_cn')
			  ->join('ot_retiros','ot_retiros.idot_retiro','=','reporte_cn.idot_retiro')
			  ->join('activos','activos.idactivo','=','ot_retiros.idactivo')
			  ->join('modelo_activos','modelo_activos.idmodelo_equipo','=','activos.idmodelo_equipo')
			  ->join('familia_activos','familia_activos.idfamilia_activo','=','modelo_activos.idfamilia_activo')
			  ->leftjoin('servicios','servicios.idservicio','=','programacion_reporte_cn.idservicio')
			  ->join('areas','areas.idarea','=','programacion_reporte_cn.idarea')
			  ->join('users','users.id','=','programacion_reporte_cn.iduser')
			  ->select('familia_activos.nombre_equipo','servicios.nombre as nombre_servicio','areas.nombre as nombre_area',
			  			'users.apellido_pat','users.apellido_mat','users.nombre','ot_retiros.idot_retiro',
			  			'ot_retiros.ot_tipo_abreviatura','ot_retiros.ot_correlativo','ot_retiros.ot_activo_abreviatura','reporte_cn.*')
			  ->orderBy('reporte_cn.created_at','desc')->take(10);
	  	return $query;
	}

	public function scopeSearchReporteCNconETESByCodigoReporte($query,$abreviatura,$correlativo,$anho)
	{
		$query->where('numero_reporte_abreviatura','=',$abreviatura)
			  ->where('numero_reporte_correlativo','=',$correlativo)
			  ->where('numero_reporte_anho','=',$anho)
			  ->where(function($query2){
					$query2->orWhereNotNull('idreporte_etes1')
						  ->orWhereNotNull('idreporte_etes2')
						  ->orWhereNotNull('idreporte_etes3')
						  ->orWhereNotNull('idreporte_etes4')
						  ->orWhereNotNull('idreporte_etes5');
			  })				  
			  ->select('reporte_cn.*');
	  	return $query;
	}

	public function scopeSearchReporteCN_PAACByCodigoReporte($query,$abreviatura,$correlativo,$anho)
	{
		$sql = 'select c.*
				from reporte_cn c
				join programacion_reporte_cn p 
					ON p.idprogramacion_reporte_cn = c.idprogramacion_reporte_cn 
					   and (p.idtipo_reporte_CN = 2 or p.idtipo_reporte_CN = 3)
				join (SELECT idreporte_cn1 as idreporte FROM `reporte_priorizacion` WHERE idreporte_cn1 is not null 
					UNION SELECT idreporte_cn2 as idreporte FROM `reporte_priorizacion` WHERE idreporte_cn2 is not null 
					UNION SELECT idreporte_cn3 as idreporte FROM `reporte_priorizacion` WHERE idreporte_cn3 is not null 
					UNION SELECT idreporte_cn4 as idreporte FROM `reporte_priorizacion` WHERE idreporte_cn4 is not null 
					UNION SELECT idreporte_cn5 as idreporte FROM `reporte_priorizacion` WHERE idreporte_cn5 is not null) as a
				ON c.idreporte_CN = a.idreporte
				where c.numero_reporte_abreviatura = \''.$abreviatura.'\' 
					and c.numero_reporte_correlativo = \''.$correlativo.'\' 
					and c.numero_reporte_anho = \''.$anho.'\' ';
		$query = DB::select(DB::raw($sql));	
		return $query;
	}

}