<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoDocumentoPAAC extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'tipo_documentospaac';
	protected $primaryKey = 'idtipo_documentosPAAC';
}