<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Documento extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $primaryKey = 'iddocumento';
	protected $table = 'documentos';	

	public function scopeGetDocumentosInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_documentos','tipo_documentos.idtipo_documento','=','documentos.idtipo_documento')
			  ->select('tipo_documentos.nombre as nombre_tipo_documento','documentos.*');
		return $query;
	}

	public function scopeSearchDocumentoById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('iddocumento','=',$search_criteria);
		return $query;
	}	

	public function scopeSearchDocumentoByCodigoArchivamiento($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('codigo_archivamiento','=',$search_criteria);
		return $query;
	}

	public function scopeSearchDocumentoByIdReporteIncumplimiento($query,$search_criteria){
		$query->withTrashed()
			  ->where('idreporte_incumplimiento','=',$search_criteria);
		return $query;
	}		

	public function scopeSearchDocumentos($query,$search_nombre,$search_autor,$search_codigo_archivamiento,$search_ubicacion,$search_tipo_documento)
	{
		$query->withTrashed()
			  ->join('tipo_documentos','tipo_documentos.idtipo_documento','=','documentos.idtipo_documento');
			  
			  if($search_nombre != "")
			  {
			  	$query->where('documentos.nombre','LIKE',"%$search_nombre%");
			  }

			  if($search_autor != "")
			  {
			  	$query->where('documentos.autor','LIKE',"%$search_autor%");
			  }

			  if($search_codigo_archivamiento != "")
			  {
			  	$query->where('documentos.codigo_archivamiento','LIKE',"%$search_codigo_archivamiento%");
			  }

			  if($search_ubicacion != "")
			  {
			  	$query->where('documentos.ubicacion','LIKE',"%$search_ubicacion%");
			  }

			  if($search_tipo_documento != '0')
			  {
			  	$query->where('documentos.idtipo_documento','=',$search_tipo_documento);
			  }

			  $query->select('tipo_documentos.nombre as nombre_tipo_documento','documentos.*');
		return $query;
	}	
}