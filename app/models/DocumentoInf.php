<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentoInf extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'documentosinf';
	protected $primaryKey = 'iddocumentosinf';

	public function scopeGetDocumentosInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_documentosinf','tipo_documentosinf.idtipo_documentosinf','=','documentosinf.idtipo_documentosinf')
			  ->select('tipo_documentosinf.nombre as nombre_tipo_documento','documentosinf.*');
		return $query;
	}

	public function scopeSearchDocumentosPadre($query,$search_nombre,$search_autor,$search_codigo_archivamiento,$search_ubicacion,$search_tipo_documento)
	{
		$query->withTrashed()
			  ->join('tipo_documentosinf_padre','tipo_documentosinf_padre.id','=','documentosinf.id_tipo_padre');
			  
			  if($search_nombre != "")
			  {
			  	$query->where('documentosinf.nombre','LIKE',"%$search_nombre%");
			  }

			  if($search_autor != "")
			  {
			  	$query->where('documentosinf.autor','LIKE',"%$search_autor%");
			  }

			  if($search_codigo_archivamiento != "")
			  {
			  	$query->where('documentosinf.codigo_archivamiento','LIKE',"%$search_codigo_archivamiento%");
			  }

			  if($search_ubicacion != "")
			  {
			  	$query->where('documentosinf.ubicacion','LIKE',"%$search_ubicacion%");
			  }

			  if($search_tipo_documento != '0')
			  {
			  	$query->where('documentosinf.id_tipo_padre','=',$search_tipo_documento);
			  }
			  
			  $query->select('tipo_documentosinf_padre.nombre as nombre_tipo_documento','documentosinf.*');
		return $query;
	}

	public function scopeSearchDocumentos($query,$search_nombre,$search_autor,$search_codigo_archivamiento,$search_ubicacion,$search_tipo_documento)
	{
		$query->withTrashed()
			  ->join('tipo_documentosinf','tipo_documentosinf.idtipo_documentosinf','=','documentosinf.idtipo_documentosinf');
			  
			  if($search_nombre != "")
			  {
			  	$query->where('documentosinf.nombre','LIKE',"%$search_nombre%");
			  }

			  if($search_autor != "")
			  {
			  	$query->where('documentosinf.autor','LIKE',"%$search_autor%");
			  }

			  if($search_codigo_archivamiento != "")
			  {
			  	$query->where('documentosinf.codigo_archivamiento','LIKE',"%$search_codigo_archivamiento%");
			  }

			  if($search_ubicacion != "")
			  {
			  	$query->where('documentosinf.ubicacion','LIKE',"%$search_ubicacion%");
			  }

			  if($search_tipo_documento != '0')
			  {
			  	$query->where('documentosinf.idtipo_documentosinf','=',$search_tipo_documento);
			  }
			  
			  
		return $query;
	}

	public function scopeSearchDocumentoById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('iddocumentosinf','=',$search_criteria);
		return $query;
	}	

	public function tipo()
	{
		return $this->belongsTo('TipoDocumentoInf', 'idtipo_documentosinf','idtipo_documentosinf');
	}

	public function subtipo(){
		return $this->belongsTo('SubtipoDocumentoInf','id_subtipo');
	}

	public function padre()
	{
		return $this->belongsTo('TipoDocumentoInfPadre','id_tipo_padre');
	}	
}