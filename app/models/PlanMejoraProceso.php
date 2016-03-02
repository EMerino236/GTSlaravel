<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PlanMejoraProceso extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $primaryKey = 'iddocumento';
	protected $table = 'plan_mejora_procesos';

	public function tipoDocumento()
	{
		return $this->belongsTo('TipoDocumentos','idtipo_documento');
	}	

	public function scopeGetPlanMejoraProcesosInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_documentos','tipo_documentos.idtipo_documento','=','plan_mejora_procesos.idtipo_documento')
			  ->select('tipo_documentos.nombre as nombre_tipo_documento','plan_mejora_procesos.*');
		return $query;
	}

	public function scopeSearchPlanMejoraProcesoById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('iddocumento','=',$search_criteria);
		return $query;
	}	

	public function scopeSearchPlanMejoraProcesoByCodigoArchivamiento($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('codigo_archivamiento','=',$search_criteria);
		return $query;
	}	

	public function scopeSearchPlanMejoraProcesos($query,$search_nombre,$search_autor,$search_codigo_archivamiento,$search_ubicacion,$search_tipo_documento)
	{
		$query->withTrashed()
			  ->join('tipo_documentos','tipo_documentos.idtipo_documento','=','plan_mejora_procesos.idtipo_documento');
			  
			  if($search_nombre != "")
			  {
			  	$query->where('plan_mejora_procesos.nombre','LIKE',"%$search_nombre%");
			  }

			  if($search_autor != "")
			  {
			  	$query->where('plan_mejora_procesos.autor','LIKE',"%$search_autor%");
			  }

			  if($search_codigo_archivamiento != "")
			  {
			  	$query->where('plan_mejora_procesos.codigo_archivamiento','LIKE',"%$search_codigo_archivamiento%");
			  }

			  if($search_ubicacion != "")
			  {
			  	$query->where('plan_mejora_procesos.ubicacion','LIKE',"%$search_ubicacion%");
			  }

			  if($search_tipo_documento != '0')
			  {
			  	$query->where('plan_mejora_procesos.idtipo_documento','=',$search_tipo_documento);
			  }

			  $query->select('tipo_documentos.nombre as nombre_tipo_documento','plan_mejora_procesos.*');
		return $query;
	}	
}