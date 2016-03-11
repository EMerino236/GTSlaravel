<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ArchivoECRI extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table ="archivos_ECRI";
	protected $primaryKey = "idarchivos_ECRI";
	
}