<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ReporteInvestigacion extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'reporte_investigacion';

	public function scopeGetReportesInfo($query)
	{
		$query->withTrashed()
			  ->join('users','users.id','=','reporte_investigacion.idusuario_elaborador')
			  ->join('reporte_investigacionxmetodo','reporte_investigacionxmetodo.idreporte','=','reporte_investigacion.id')
			  ->join('reporte_investigacionxtipo_capacitacion','reporte_investigacionxtipo_capacitacion.idreporte','=','reporte_investigacion.id')
			  ->join('eventos_adversos','eventos_adversos.id','=','reporte_investigacion.idevento_adverso')
			  ->join('etapa_servicio','etapa_servicio.id','=','eventos_adversos.idetapa_servicio')
			  ->join('entorno_asistencialxtipo_servicio','entorno_asistencialxtipo_servicio.id','=','etapa_servicio.identornoxtipo')
			  ->join('entorno_asistencial','entorno_asistencial.id','=','entorno_asistencialxtipo_servicio.identorno')
			  ->select('reporte_investigacion.*','entorno_asistencial.nombre as nombre_entorno','eventos_adversos.codigo_abreviatura as evento_abreviatura','eventos_adversos.codigo_correlativo as evento_correlativo','eventos_adversos.codigo_anho as evento_anho','users.nombre as nombre','users.apellido_pat as apellido_pat','users.apellido_mat as apellido_mat','eventos_adversos.id as idevento');
		return $query;
	}

	public function scopeSearchReportesInvestigacion($query,$search_codigo_reporte_investigacion,$search_codigo_reporte_evento,$search_entorno_asistencial,$search_usuario,$search_ini,$search_fin)
	{
		$query->withTrashed()
			  ->join('users','users.id','=','reporte_investigacion.idusuario_elaborador')
			  ->join('reporte_investigacionxmetodo','reporte_investigacionxmetodo.idreporte','=','reporte_investigacion.id')
			  ->join('reporte_investigacionxtipo_capacitacion','reporte_investigacionxtipo_capacitacion.idreporte','=','reporte_investigacion.id')
			  ->join('eventos_adversos','eventos_adversos.id','=','reporte_investigacion.idevento_adverso')
			  ->join('etapa_servicio','etapa_servicio.id','=','eventos_adversos.idetapa_servicio')
			  ->join('entorno_asistencialxtipo_servicio','entorno_asistencialxtipo_servicio.id','=','etapa_servicio.identornoxtipo')
			  ->join('entorno_asistencial','entorno_asistencial.id','=','entorno_asistencialxtipo_servicio.identorno');
			  

			  if($search_codigo_reporte_investigacion != '')
			  {
			  	$query->where(DB::raw("CONCAT(reporte_investigacion.codigo_abreviatura,'-',reporte_investigacion.codigo_correlativo,'-',reporte_investigacion.codigo_anho)"),'LIKE',"%$search_codigo_reporte_investigacion%");
			  }

			 if($search_codigo_reporte_evento != '')
			  {
			  	$query->where(DB::raw("CONCAT(eventos_adversos.codigo_abreviatura,'-',eventos_adversos.codigo_correlativo,'-',eventos_adversos.codigo_anho)"),'LIKE',"%$search_codigo_reporte_evento%");
			  }
			    
			  if($search_entorno_asistencial != '')
			  {
			  	$query->where('entorno_asistencial.id','=',$search_entorno_asistencial);
			  }

			  if($search_usuario != '')
			  {
			  	$query->whereNested(function($query) use($search_usuario){
		  			$query->where('users.nombre','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_pat','LIKE',"%$search_usuario%")
			  			  ->orWhere('users.apellido_mat','LIKE',"%$search_usuario%");
			  	});
			  }

			   if($search_ini != "")
				$query->where(DB::raw('STR_TO_DATE(reporte_investigacion.created_at,\'%Y-%m-%d\')'),'>=',date('Y-m-d',strtotime($search_ini)));

			  if($search_fin != "")
				$query->where(DB::raw('STR_TO_DATE(reporte_investigacion.created_at,\'%Y-%m-%d\')'),'<=',date('Y-m-d',strtotime($search_fin)));

			  $query->select('reporte_investigacion.*','entorno_asistencial.nombre as nombre_entorno','eventos_adversos.codigo_abreviatura as evento_abreviatura','eventos_adversos.codigo_correlativo as evento_correlativo','eventos_adversos.codigo_anho as evento_anho','users.nombre as nombre','users.apellido_pat as apellido_pat','users.apellido_mat as apellido_mat','eventos_adversos.id as idevento');

		return $query;
	}

	public function scopeGetReporteByIdEvento($query,$idevento)
	{
		$query->withTrashed()
			  ->join('eventos_adversos','eventos_adversos.id','=','reporte_investigacion.idevento_adverso')
			  ->where('eventos_adversos.id','=',$idevento)
			  ->select('reporte_investigacion.*');
		return $query;
	}

	public function scopeSearchReporteById($query,$idreporte)
	{
		$query->withTrashed()
			  ->join('users','users.id','=','reporte_investigacion.idusuario_elaborador')
			  ->join('reporte_investigacionxmetodo','reporte_investigacionxmetodo.idreporte','=','reporte_investigacion.id')
			  ->join('reporte_investigacionxtipo_capacitacion','reporte_investigacionxtipo_capacitacion.idreporte','=','reporte_investigacion.id')
			  ->join('eventos_adversos','eventos_adversos.id','=','reporte_investigacion.idevento_adverso')
			  ->join('etapa_servicio','etapa_servicio.id','=','eventos_adversos.idetapa_servicio')
			  ->join('entorno_asistencialxtipo_servicio','entorno_asistencialxtipo_servicio.id','=','etapa_servicio.identornoxtipo')
			  ->join('entorno_asistencial','entorno_asistencial.id','=','entorno_asistencialxtipo_servicio.identorno')
			  ->where('reporte_investigacion.id','=',$idreporte)
			  ->select('reporte_investigacion.*','entorno_asistencial.nombre as nombre_entorno','eventos_adversos.codigo_abreviatura as evento_abreviatura','eventos_adversos.codigo_correlativo as evento_correlativo','eventos_adversos.codigo_anho as evento_anho','users.nombre as nombre','users.apellido_pat as apellido_pat','users.apellido_mat as apellido_mat');
		return $query;
	}

}