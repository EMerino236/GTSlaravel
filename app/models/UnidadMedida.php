<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UnidadMedida extends Eloquent{
	use SoftDeletingTrait;	
	protected $softDelete = true;

	protected $table = 'unidad_medida';
	protected $primaryKey = 'idunidad_medida';

}