<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteETES extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'idreporte_ETES';
	protected $table = 'reporte_etes';

	public function scopeGetLastReporte($query,$abreviatura)
	{
		$query->where('numero_reporte_abreviatura','=',$abreviatura)
			  ->orderBy('idreporte_ETES','desc');
	  	return $query;
	}

	public function scopeGetReportesETESInfo($query)
	{
		$query->withTrashed()
			  ->join('users','users.id','=','reporte_etes.iduser')
			  ->select('users.apellido_pat','users.apellido_mat','users.nombre as nombre_usuario','reporte_etes.*');
	  	return $query;
	}

	public function scopeSearchReportesETES($query,$search_numero_reporte,$search_fecha_ini,$search_fecha_fin,
											$search_tipo_reporte_etes,$search_usuario)
	{
		$query->withTrashed()
			  ->join('users','users.id','=','reporte_etes.iduser')
			  ->whereNested(function($query) use($search_usuario){
			  		$query->where('users.nombre','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
			  });
			  if($search_numero_reporte!="")
			  	$query->where(DB::raw("CONCAT(reporte_etes.numero_reporte_abreviatura,reporte_etes.numero_reporte_correlativo,'-',reporte_etes.numero_reporte_anho)"),'LIKE',"%$search_numero_reporte%");
			  if($search_fecha_ini != "")
				$query->where('reporte_etes.created_at','>=',date('Y-m-d H:i:s',strtotime($search_fecha_ini)));
			  if($search_fecha_fin != "")
				$query->where('reporte_etes.created_at','<=',date('Y-m-d H:i:s',strtotime($search_fecha_fin)));
			  if($search_tipo_reporte_etes!='')
			  	$query->where('reporte_etes.idtipo_reporte_etes','=',$search_tipo_reporte_etes);
			  $query->select('users.apellido_pat','users.apellido_mat','users.nombre as nombre_usuario','reporte_etes.*');
	  	return $query;
	}

}