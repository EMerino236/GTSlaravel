<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SubtipoDocumentoInf extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;
	protected $table = 'subtipo_documentosinf';

}