<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReportePriorizacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idreporte_Priorizacion';
	protected $table = 'reporte_priorizacion';

	public function scopeGetLastReporte($query,$abreviatura)
	{
		$query->where('numero_reporte_abreviatura','=',$abreviatura)
			  ->orderBy('idreporte_Priorizacion','desc');
	  	return $query;
	}

	public function scopeGetReportesPriorizacionInfo($query)
	{
		$query->withTrashed()
			  ->leftjoin('servicios','servicios.idservicio','=','reporte_priorizacion.idservicio')
			  ->join('areas','areas.idarea','=','reporte_priorizacion.idarea')
			  ->join('users','users.id','=','reporte_priorizacion.iduser')
			  ->select('servicios.nombre as nombre_servicio','areas.nombre as nombre_area',
			  			'users.apellido_pat','users.apellido_mat','users.nombre','reporte_priorizacion.*');
	  	return $query;
	}

	public function scopeSearchReportesPriorizacion($query,$search_numero_reporte,$search_fecha_ini,$search_fecha_fin,
											$search_usuario,$search_servicio,$search_area)
	{
		$query->withTrashed()
			  ->leftjoin('servicios','servicios.idservicio','=','reporte_priorizacion.idservicio')
			  ->join('areas','areas.idarea','=','reporte_priorizacion.idarea')
			  ->join('users','users.id','=','reporte_priorizacion.iduser')
			  ->whereNested(function($query) use($search_usuario){
			  		$query->where('users.nombre','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
			  });
			  if($search_numero_reporte!="")
			  	$query->where(DB::raw("CONCAT(reporte_priorizacion.numero_reporte_abreviatura,reporte_priorizacion.numero_reporte_correlativo,'-',reporte_priorizacion.numero_reporte_anho)"),'LIKE',"%$search_numero_reporte%");
			  if($search_fecha_ini != "")
				$query->where('reporte_priorizacion.created_at','>=',date('Y-m-d H:i:s',strtotime($search_fecha_ini)));
			  if($search_fecha_fin != "")
				$query->where('reporte_priorizacion.created_at','<=',date('Y-m-d H:i:s',strtotime($search_fecha_fin)));
			  if($search_servicio!='')
			  	$query->where('reporte_priorizacion.idservicio','=',$search_servicio);
			  if($search_area!='')
			  	$query->where('reporte_priorizacion.idarea','=',$search_area);
			  $query->select('servicios.nombre as nombre_servicio','areas.nombre as nombre_area','users.apellido_pat','users.apellido_mat','users.nombre','reporte_priorizacion.*');
	  	return $query;
	}

	public function scopeGetLast10CreatedReportesPriorizacionInfo($query)
	{
		$query->withTrashed()
			  ->leftjoin('servicios','servicios.idservicio','=','reporte_priorizacion.idservicio')
			  ->join('areas','areas.idarea','=','reporte_priorizacion.idarea')
			  ->join('users','users.id','=','reporte_priorizacion.iduser')
			  ->select('servicios.nombre as nombre_servicio','areas.nombre as nombre_area','users.apellido_pat','users.apellido_mat','users.nombre','reporte_priorizacion.*')
			  ->orderBy('reporte_priorizacion.created_at','desc')->take(10);
	  	return $query;
	}

}