<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoDocumentoRiesgos extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'tipo_documento_riesgos';

	public function scopeSearchTipoDocumentosById($query,$search_criteria)
	{
		$query->withTrashed()
			  ->where('id','=',$search_criteria);
		return $query;
	}	
}