<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentoRiesgos extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $table = 'documento_riesgos';	

	public function scopeGetDocumentosInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_documento_riesgos','tipo_documento_riesgos.id','=','documento_riesgos.id_tipo')
			  ->select('tipo_documento_riesgos.nombre as nombre_tipo_documento','documento_riesgos.*');
		return $query;
	}

	public function scopeSearchDocumentoById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('id','=',$search_criteria);
		return $query;
	}	

	
	public function scopeSearchDocumentoByCodigoArchivamiento($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('codigo_archivamiento','=',$search_criteria);
		return $query;
	}

		

	public function scopeSearchDocumentos($query,$search_nombre,$search_autor,$search_codigo_archivamiento,$search_ubicacion,$search_tipo_documento)
	{
		$query->withTrashed()
			  ->join('tipo_documento_riesgos','tipo_documento_riesgos.id','=','documento_riesgos.id_tipo');
			  
			  if($search_nombre != "")
			  {
			  	$query->where('documento_riesgos.nombre','LIKE',"%$search_nombre%");
			  }

			  if($search_autor != "")
			  {
			  	$query->where('documento_riesgos.autor','LIKE',"%$search_autor%");
			  }

			  if($search_codigo_archivamiento != "")
			  {
			  	$query->where('documento_riesgos.codigo_archivamiento','LIKE',"%$search_codigo_archivamiento%");
			  }

			  if($search_ubicacion != "")
			  {
			  	$query->where('documento_riesgos.ubicacion','LIKE',"%$search_ubicacion%");
			  }

			  if($search_tipo_documento != '0')
			  {
			  	$query->where('documento_riesgos.id_tipo','=',$search_tipo_documento);
			  }

			  $query->select('tipo_documento_riesgos.nombre as nombre_tipo_documento','documento_riesgos.*');
		return $query;
	}	

	
}