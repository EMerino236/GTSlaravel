<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EventoAdverso extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'eventos_adversos';

	public function scopeGetEventosInfo($query)
	{
		$query->withTrashed()
			  ->join('eventos_adversosxsubtipohijo_incidente','eventos_adversosxsubtipohijo_incidente.idevento','=','eventos_adversos.id')
			  ->join('subtipohijo_incidente','subtipohijo_incidente.id','=','eventos_adversosxsubtipohijo_incidente.idsubtipohijo')
			  ->join('subtipopadre_incidente','subtipopadre_incidente.id','=','subtipohijo_incidente.idsubtipopadre_incidente')
			  ->join('tipo_incidente','tipo_incidente.id','=','subtipopadre_incidente.idtipo_incidente')
			  ->select('tipo_incidente.nombre as nombre_incidente','eventos_adversos.*');
		return $query;
	}

	public function scopeSearchEventoAdversoById($query,$idevento)
	{
		$query->withTrashed()
			  ->join('eventos_adversosxsubtipohijo_incidente','eventos_adversosxsubtipohijo_incidente.idevento','=','eventos_adversos.id')
			  ->join('subtipohijo_incidente','subtipohijo_incidente.id','=','eventos_adversosxsubtipohijo_incidente.idsubtipohijo')
			  ->join('subtipopadre_incidente','subtipopadre_incidente.id','=','subtipohijo_incidente.idsubtipopadre_incidente')
			  ->join('tipo_incidente','tipo_incidente.id','=','subtipopadre_incidente.idtipo_incidente')
			  ->where('eventos_adversos.id','=',$idevento)
			  ->select('tipo_incidente.nombre as nombre_incidente','eventos_adversos.*');
		return $query;
	}

	public function scopeSearchEventosAdversos($query,$search_numero_reporte,$search_tipo,$search_usuario_reportante,$search_fecha_ini,$search_fecha_fin){

		$query->withTrashed()
			  ->join('eventos_adversosxsubtipohijo_incidente','eventos_adversosxsubtipohijo_incidente.idevento','=','eventos_adversos.id')
			  ->join('subtipohijo_incidente','subtipohijo_incidente.id','=','eventos_adversosxsubtipohijo_incidente.idsubtipohijo')
			  ->join('subtipopadre_incidente','subtipopadre_incidente.id','=','subtipohijo_incidente.idsubtipopadre_incidente')
			  ->join('tipo_incidente','tipo_incidente.id','=','subtipopadre_incidente.idtipo_incidente');

		if($search_numero_reporte != "")
		{
			$query->where(DB::raw("CONCAT(eventos_adversos.codigo_abreviatura,'-',eventos_adversos.codigo_correlativo,'-',eventos_adversos.codigo_anho)"),'LIKE',"%$search_numero_reporte%");
		}

		if($search_tipo != "")
		{
			$query->where('tipo_incidente.id','=',$search_tipo);
		}

		if($search_usuario_reportante != "")
		{
			$query->where('eventos_adversos.nombre_reportante','LIKE',"%$search_usuario_reportante%");
		}

		if($search_fecha_ini != "")
			$query->where(DB::raw('STR_TO_DATE(eventos_adversos.fecha_reporte,\'%Y-%m-%d\')'),'>=',date('Y-m-d H:i:s',strtotime($search_fecha_ini)));
	    
	    if($search_fecha_fin != "")
			$query->where(DB::raw('STR_TO_DATE(eventos_adversos.fecha_reporte,\'%Y-%m-%d\')'),'<=',date('Y-m-d H:i:s',strtotime($search_fecha_fin)));
			  		
			  
	    $query->select('tipo_incidente.nombre as nombre_incidente','eventos_adversos.*');
	    $query->distinct();
		return $query;
	}

	public function scopeGetLastEventoAdverso($query)
	{
		$query->orderBy('id','desc');
	  	return $query;
	}

	public function scopeGetEventoByCodigoEvento($query,$codigo)
	{
		$query->withTrashed()
			  ->join('eventos_adversosxsubtipohijo_incidente','eventos_adversosxsubtipohijo_incidente.idevento','=','eventos_adversos.id')
			  ->join('subtipohijo_incidente','subtipohijo_incidente.id','=','eventos_adversosxsubtipohijo_incidente.idsubtipohijo')
			  ->join('subtipopadre_incidente','subtipopadre_incidente.id','=','subtipohijo_incidente.idsubtipopadre_incidente')
			  ->join('tipo_incidente','tipo_incidente.id','=','subtipopadre_incidente.idtipo_incidente')
			  ->where(DB::raw("CONCAT(eventos_adversos.codigo_abreviatura,'-',eventos_adversos.codigo_correlativo,'-',eventos_adversos.codigo_anho)"),'=',$codigo)
			  ->select('tipo_incidente.nombre as nombre_incidente','eventos_adversos.*');
		return $query;
	}
}