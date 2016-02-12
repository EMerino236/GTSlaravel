<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TipoDocumento extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'tipo_doc_identidades';
	protected $primaryKey = 'idtipo_documento';
}