<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReportePAAC extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idreporte_PAAC';
	protected $table = 'reporte_paac';

	public function scopeGetLastReporte($query,$abreviatura)
	{
		$query->where('numero_reporte_abreviatura','=',$abreviatura)
			  ->orderBy('idreporte_PAAC','desc');
	  	return $query;
	}

	public function scopeGetReportesPAACInfo($query)
	{
		$query->withTrashed()
			  ->join('programacion_reporte_paac','programacion_reporte_paac.idprogramacion_reporte_paac','=','reporte_paac.idprogramacion_reporte_paac')
			  ->leftjoin('servicios','servicios.idservicio','=','programacion_reporte_paac.idservicio')
			  ->join('areas','areas.idarea','=','programacion_reporte_paac.idarea')
			  ->join('users','users.id','=','programacion_reporte_paac.iduser')
			  ->select('servicios.nombre as nombre_servicio','areas.nombre as nombre_area',
			  			'users.apellido_pat','users.apellido_mat','users.nombre','reporte_paac.*');
	  	return $query;
	}

	public function scopeSearchReportesPAAC($query,$search_numero_reporte,$search_fecha_ini,$search_fecha_fin,
							$search_tipo_reporte_paac,$search_usuario,$search_servicio,$search_area)
	{
		$query->withTrashed()
			  ->join('programacion_reporte_paac','programacion_reporte_paac.idprogramacion_reporte_paac','=','reporte_paac.idprogramacion_reporte_paac')
			  ->leftjoin('servicios','servicios.idservicio','=','programacion_reporte_paac.idservicio')
			  ->join('areas','areas.idarea','=','programacion_reporte_paac.idarea')
			  ->join('users','users.id','=','programacion_reporte_paac.iduser')
			  ->whereNested(function($query) use($search_usuario){
			  		$query->where('users.nombre','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
			  });
			  if($search_numero_reporte!="")
			  	$query->where(DB::raw("CONCAT(reporte_paac.numero_reporte_abreviatura,reporte_paac.numero_reporte_correlativo,'-',reporte_paac.numero_reporte_anho)"),'LIKE',"%$search_numero_reporte%");
			  if($search_fecha_ini != "")
				$query->where('reporte_paac.created_at','>=',date('Y-m-d H:i:s',strtotime($search_fecha_ini)));
			  if($search_fecha_fin != "")
				$query->where('reporte_paac.created_at','<=',date('Y-m-d H:i:s',strtotime($search_fecha_fin)));
			  if($search_servicio!='')
			  	$query->where('programacion_reporte_paac.idservicio','=',$search_servicio);
			  if($search_area!='')
			  	$query->where('programacion_reporte_paac.idarea','=',$search_area);
			  if($search_tipo_reporte_paac!='')
			  	$query->where('programacion_reporte_paac.idtipo_reporte_paac','=',$search_tipo_reporte_paac);
			  $query->select('servicios.nombre as nombre_servicio','areas.nombre as nombre_area',
			  			'users.apellido_pat','users.apellido_mat','users.nombre','reporte_paac.*');
	  	return $query;
	}

}