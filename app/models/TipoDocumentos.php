<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoDocumentos extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'tipo_documentos';

	public function scopeSearchTipoDocumentosById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('idtipo_documento','=',$search_criteria);
		return $query;
	}		
}