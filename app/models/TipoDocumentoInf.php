<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoDocumentoInf extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'tipo_documentosinf';

	public function scopeSearchTipoDocumentosById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('idtipo_documentosinf','=',$search_criteria);
		return $query;
	}		
}