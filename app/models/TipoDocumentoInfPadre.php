<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoDocumentoInfPadre extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'tipo_documentosinf_padre';

	public function scopeSearchTipoDocumentosById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('idtipo_documentosinf','=',$search_criteria);
		return $query;
	}
}