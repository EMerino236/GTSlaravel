<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoDocumentoPlanDirector extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_documentosplandirector';
	protected $primaryKey = 'idtipo_documentosPlanDirector';
}