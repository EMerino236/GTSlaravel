<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class DocumentoPAAC extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $primaryKey = 'iddocumentosPAAC';
	protected $table = 'documentospaac';

	public function scopeGetDocumentosPAACInfo($query)
	{
		$query->withTrashed()
			  ->join('tipo_documentospaac','tipo_documentospaac.idtipo_documentosPAAC','=','documentospaac.idtipo_documentosPAAC')
			  ->select('tipo_documentospaac.nombre as tipo_documento','documentospaac.*');
	  	return $query;
	}

	public function scopeSearchDocumentosPAAC($query,$search_fecha_ini,$search_fecha_fin,$search_tipo_documento_paac)
	{
		$query->withTrashed()
			  ->join('tipo_documentospaac','tipo_documentospaac.idtipo_documentosPAAC','=','documentospaac.idtipo_documentosPAAC');
			  if($search_fecha_ini != "")
				$query->where('documentospaac.anho','>=',$search_fecha_ini);
			  if($search_fecha_fin != "")
				$query->where('documentospaac.anho','<=',$search_fecha_fin);
			  if($search_tipo_documento_paac!='')
			  	$query->where('documentospaac.idtipo_documentosPAAC','=',$search_tipo_documento_paac);
			  $query->select('tipo_documentospaac.nombre as tipo_documento','documentospaac.*');
	  	return $query;
	}

}